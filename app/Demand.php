<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demand extends Model
{
    //use SoftDeletes;

    //protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo('ZuiHuiGou\User');
    }

    public function bids()
    {
        return $this->hasMany('ZuiHuiGou\Bid');
    }

    protected static function addRules()
    {
        return [
            'title' => 'required|min:3',
            'price' => 'required'
        ];
    }

    public $status_d;
    public $expire_time_d;
    public $startprice; //开始价格
    public $lowprice; //最低价格


    //分类的ID与品牌的IDs
    public function getDemands($idstr,$bids="",$key="")
    {



        $ids=explode(",",$idstr);
        $conditions=" 1!=1";
        foreach($ids as $id)
        {
            $id = trim($id);
            if (empty($id)) continue;
            $conditions .= " or sortpath like  '%," . $id . ",%' ";
        }
        $catemodel=new Category();
        $catarray=$catemodel->getbysql2array($conditions);
        if(!$catarray) return;
        $cateids=implode(",",$catarray);




        //TODO:去掉注释
        $condition="  1=1 " ;
        $condition=" status=0 and is_pay=1 ";
      //  $condition.='and status != -1 and deposit!=0';
        $condition.=" and category_id in ( $cateids  )";
       $condition.=" and expire_time>now()";

        if (substr($bids, -1) == ',')
            $bids = substr($bids, 0, -1);
        if (!empty($bids))
        {
            $condition .= " and  bid in ( $bids )  ";
        }
        if(!empty($key))
        {
            $condition .= " and  title like '%". urldecode(  $key) ."%'  ";
        }

       //echo "condition =$condition";exit();

        return $this->whereRaw($condition)->orderby( "id","desc")->get()->toArray();
    }

    public function getdelay()
    {
        $exptime = strtotime($this->expire_time);
        $paytime = strtotime($this->paytime);
        if ($paytime == null)
        {
            return "--";
            $paytime = strtotime($this->created_at);
        }

        $avltime = strtotime("+ " . $this->avltime . " hours", $paytime);  //如果没有支付定金的情况,就按添加时间来

        if ($exptime > $avltime)
            return "是";
        return "否";

    }

//当前状态
    public function getstatus($nstatus = '')
    {
        if ($this->status == -3) return '已取消';
      //  if ($this->status == -4) return '已放弃';
        if ($this->status == -4) return '已取消';


        $now = strtotime(gmdate('Y-m-d h:i:s')) + 28800; //标准时间+8个小时的时区

        $enddate = strtotime($this->expire_time);
        $timediff = $enddate - $now;
        //var_dump($enddate .'-'. $now);exit;
        if ($enddate > $now)
        {
            $days = intval($timediff / 86400);
            $remain = $timediff % 86400;

            $hours = intval($remain / 3600);
            $remain = $remain % 3600;
            $mins = intval($remain / 60);
            $this->expire_time_d = ($days ? $days . '天' : '') . ($hours ? $hours . '小时' : '') . $mins . '分钟';
        }
        else
        {
            $this->expire_time_d = '已结束';
        }


        $is_win = false;
        $bidis = $this->bids;
        for ($y = 0; $y < count($bidis); $y++)
        {
            if ($bidis[$y]->is_win == 1)
            {
                $is_win = true;
            }
        }


        //echo "i_win=".$is_win." and status is:".$demands[$i]->status."<br />";
        //状态0为未选标,1为选标,2已经付尾款,3为已经发货,4为收到货了
        switch ($this->status)
        {
            case -4:    //已经放弃
                $this->status_d = '已取消';
                break;
            case -1:
                $this->status_d = '审核中';
                break;
            case 0:
                if ($this->is_pay == 0) $this->status_d = '定金待付';
                if ($this->is_pay == 1)
                {
                    if ($this->expire_time_d != '已结束')
                        return "竞价中";
                    else
                    {
                        $this->status_d = '待选标'; //已经有人投标了,但是没有找到合适的
                    }
                }
                break;
            case 1:
                //   echo "demand i=".$demands[$i]->is_pay."<br />";
                if ($this->is_pay <= 1)
                {
                    $this->status_d = '待付款';
                    break;
                }
                break;
            case 2:
                // $demands[$i]->status_d = '已付款';//已经支付了尾款,等待商家发货
                $this->status_d = '待收货'; //已经支付了尾款,等待商家发货
                break;
            case 3:
                //  $this->status_d = '已发货';
                $this->status_d = '待收货'; //已经支付了尾款,等待商家发货
                break;
            case 4:
                $this->status_d = '已完成';
                break;

            case 5:
                $this->status_d = '已完成';
                break;

        }
        if ($nstatus != '') $this->status_d = $nstatus; //指定状态

        return $this->status_d;
    }



    public function  getstarttime()
    {
        if($this->status<0) echo "已取消";
        if($this->status>=1) echo "已结束";
        if($this->satus==0 && $this->is_pay==1)
        {
            $exptime=strtotime($this->expire_time);
            $nowtime=strtotime("now");
            if($exptime<=$nowtime)
            {
                echo "已结束";
                return;
            }
            $timediff = strtotime('now') - strtotime($this->paytime);
            $days = intval($timediff / 86400);
            $remain = $timediff % 86400;
            $hours = intval($remain / 3600);
            $remain = $remain % 3600;
            $mins = intval($remain / 60);
            echo $days . "天 " . $hours . "小时" . $mins . "分钟";
        }

    }





    //同样的状态对于卖家来说,状态的描述是不一样的,所以在这里做一个函数
    public function getbidstatus()
    {

        if ($this->status == -3) return '已取消';
        $isend=false;//是否结束
        $now = strtotime(gmdate('Y-m-d h:i:s')) + 28800; //标准时间+8个小时的时区
        $enddate = strtotime($this->expire_time);
        if ($enddate < $now)  $isend=true; //时间结束

        $is_win = false;
        $bidis = $this->bids;
        for ($y = 0; $y < count($bidis); $y++)
        {
            if ($bidis[$y]->is_win == 1)
            {
                $is_win = true;
            }
        }


        //echo "i_win=".$is_win." and status is:".$demands[$i]->status."<br />";
        //状态0为未选标,1为选标,2已经付尾款,3为已经发货,4为收到货了
        switch ($this->status)
        {
            case -4:
                $this->status_d = '淘汰';
                break;
            case -3:
                $this->status_d = '淘汰';
                break;
            case -1:
                $this->status_d = '审核中';
                break;
            case 0:
                if ($this->is_pay == 0) $this->status_d = '定金待付';
                if ($this->is_pay == 1)
                {
                    if (!$isend)
                        return "竞价中";
                    else
                        $this->status_d = '待选标'; //已经有人投标了,但是没有找到合适的

                }
                break;
            case 1:
                //   echo "demand i=".$demands[$i]->is_pay."<br />";
                if ($this->is_pay <= 1)
                {
                    $this->status_d = '待付款';
                    break;
                }
                break;
            case 2:
                // $demands[$i]->status_d = '已付款';//已经支付了尾款,等待商家发货
                $this->status_d = '待发货'; //已经支付了尾款,等待商家发货
                break;
            case 3:
                //  $this->status_d = '已发货';
                $this->status_d = '待收款'; //已经支付了尾款,等待商家发货
                break;
            case 4:
                $this->status_d = '待收款';
                break;

            case 5:
                $this->status_d = '已完成';
                break;

        }
        return $this->status_d;

    }



    //竞价商家
    public function  getbidders()
    {
        if ($this->status == -3) return count($this->bids());
        if ($this->status == 0) return '---';
    }

    //距离结束
    public function  getexptime()
    {

        if ($this->status == -3) return '已结束';
        if($this->status>=1) return "已结束";
        if ($this->status == 0 && $this->is_pay==0)   return '---'; //没有支付保证金

        $now = strtotime(gmdate('Y-m-d h:i:s')) + 28800; //标准时间+8个小时的时区

        $enddate = strtotime($this->expire_time);
        $timediff = $enddate - $now;
        if ($enddate > $now)
        {
            $days = intval($timediff / 86400);
            $remain = $timediff % 86400;

            $hours = intval($remain / 3600);
            $remain = $remain % 3600;
            $mins = intval($remain / 60);
            $this->expire_time_d = ($days ? $days . '天' : '') . ($hours ? $hours . '小时' : '') . $mins . '分钟';
        }
        else
        {
            $this->expire_time_d = '已结束';
        }
        return $this->expire_time_d;

    }

    public function getbidinfo()
    {
        $bids =$this->bids;

        $data=array();
        $data['demand']=$this;
        $data['bids']=$bids;//所有的出价信息

        $myBid = null;

        $lowprice=9999999;
        $firstbidtime=strtotime("now");
        $data['winbid']=null;
        $data['firstbid']=null;
        $data['lowbid']=null;
        $data['winuser']=null;
        $data['lowprice']=$lowprice;
        $data['winprice']=0;
        foreach ($bids as $bid)
        {
            if ($bid->is_win == 1)
            {
                $data['winbid']=$bid;
                $data['winprice']=$bid->price;
            }

            if(strtotime($bid->created_at)<$firstbidtime)
            {
                $data['firstbidtime']=$bid->created_at;
                $data['firstbid']=$bid;
            }

            if ($bid->price <$lowprice)
            {
                $lowprice = $bid->price;
                $data['lowprice']=$lowprice;
                $data['lowbid']=$bid;
            }
        }
        if($data['winbid']!=null)
        {
            $userid=$data['winbid']->user_id;
            $winuser=User::whereRaw("id=".$userid)->get()->first();
            $data['winuser']=$winuser;
        }
        return $data;
    }


    public function getwinprice()
    {
        if($this->status>=1)
        {
            $bids =$this->bids;
            foreach ($bids as $bid)
            {
                if ($bid->is_win == 1)
                {
                    return $bid->price;
                }
            }
        }
        return "--";
    }

    public function getstartprice()
    {
        return $this->price;
    }

    public function getlowprice()
    {

        $bids = $this->bids;
        $tlowprice = $this->price;
        if(count($bids)<=0)
        {
            $tlowprice="---";
            return $tlowprice;
        }
        foreach ($bids as $bid)
        {
            if ($bid->price < $tlowprice)
                $tlowprice = $bid->price;
        }
        return $tlowprice;

    }

    public function cancel()
    {
        if($this->id==0)  return "参数传递错误";
        if($this->status==0  && $this->is_pay==0)  //未付保证金的情况才可以取消息
        {
            $this->status=-3;
            $this->save();
            return "取消竞购成功";
        }
        else
        {
            return "当前状态不能取消息";
        }
    }


//取得正在竞价的信息
    public function getBidding($nums=10)
    {
         $demands=Demand::whereRaw(" status=0 and is_pay=1  and expire_time>now() ")->orderby("id", "desc")->take(8)->get();
        return $demands;
    }


}
