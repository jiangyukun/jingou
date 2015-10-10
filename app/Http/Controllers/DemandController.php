<?php namespace ZuiHuiGou\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use ZuiHuiGou\Bid;
use ZuiHuiGou\Brand;
use ZuiHuiGou\Category;
use ZuiHuiGou\delivery;
use ZuiHuiGou\Demand;
use ZuiHuiGou\Setting;
use Illuminate\Http\Request;
use ZuiHuiGou\Http\Helper;
use ZuiHuiGou\User;
use ZuiHuiGou\libraries\api;

class DemandController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function atest()
    {
        $allcate= $this->getallcate(0);
        foreach($allcate as $onecate)
        {
            echo $onecate["slug"]."<br /><br />";
            if($onecate["children"])
            {
                $onechilds=$onecate["children"];
                foreach($onechilds as $onechild)
                {
                    echo $onechild["slug"]."<br />";
                }
            }
            echo "------------<br />";
        }
        //  return view('demand.atest' );
    }


    public function index(Request $request,$id=0)
    {

        header("Content-Type:text/html;charset=utf-8");
        $condition=" status=0 and is_pay=1 ";
        if ($request->get('s') != '')
        {
            $condition.=" and title like '%" . urldecode($request->get('s') ). "%' and status != -1 and deposit!=0";
            // $demands = Demand::whereRaw('title like ? and status != -1 and deposit!=0', ['%' . $request->get('s') . '%'])->orderBy('id', 'desc')->get();
        }
        else
        {
            $condition.='and status != -1 and deposit!=0';
        }

        $condition.=" and expire_time>now()";
        // echo $condition."<br />";


        if($id!=0)
        {
            $allcatids="";
            $allcat=Category::whereRaw("parent_id=$id or id=$id")->get();
            foreach($allcat as $onecate)
            {
                $allcatids.=$onecate->id.",";
            }

            $allcatids=substr($allcatids,0,-1);
            $condition.=" and (category_id in($allcatids)  or cat1=$id or cat2=$id or cat3=$id ) ";
        }

        if ($id == 0)
            $brands = array();
        else
            $brands = Brand::select("bname", "id")->where('cateid','=',$id)->orderBy("id", 'desc')->get();

        $bid=$request->input("bid");
        if($bid) $condition.=" and bid=".$bid;


        $demands = Demand::whereRaw($condition)
            ->orderBy('is_top', 'desc')
            ->orderBy('is_recommend', 'desc')
            ->orderBy('is_hot', 'desc')
            ->orderBy('id', 'desc')->paginate(15);



        //$cates = Category::where("parent_id", "=", $catid)->orderBy("id", "desc")->get();
        $cates=$this->getallcate(0);
        $data=array(
            'brands'=>$brands,
            "cates"=> $cates,
            'hcateid'=>$id   //当前的分类ID
        );
        if ($this->ismobile())
            $view = view("demand.mobile.list")->with($data);
        else
            //  $view = view("demand.list")->with($data);
            $view = view("demand.atest")->with($data);

        if($id!=0)
        {
            $pcate=Category::where("id","=",$id)->orderby("sort","asc")->get();
            $pone=$pcate[0];
        }
        else
        {
            $pone=new Category();
            $pone->slug="不限";
            $pone->id=0;
            $pone->parent_id=0;
        }

        $view = $view->with('pcate', $pone);
        $view = $view->with('demands', $demands);
        return $view;


    }



    public function myDemandsByType($type="all")
    {

        header("Content-Type:text/html;charset=utf-8");

        if(! isset(Auth::user()->id))
            return Redirect::to('/auth/login')
                ->withErrors('你没有登录！');

        //定义支付状态,0为未支付保证金,1为已支付保证金,2为支付货款,
        //状态0为未选标,1为选标,2已经付款,3为已经发货,4为收到货了
        $condition="user_id=".Auth::user()->id;
        switch ($type)
        {
            case 'all':
                break;
            case 'deposit':
                $condition.=" and is_pay = 0 and status>=0";
                break;
            case 'active':
                $condition.=" and is_pay=1 and status = 0  and expire_time>CURRENT_TIMESTAMP()";
                break;
            case 'choose':
                $condition.=" and is_pay=1 and status = 0 and expire_time<CURRENT_TIMESTAMP()";
                break;
            case 'pay':
                $condition.=" and is_pay=1 and status = 1 ";
                break;
            case 'delivery':
                $condition.=" and is_pay=2 and status in(2, 3) ";
                break;
            case 'getted':
                $condition.=" and is_pay=2 and status in( 4,5)";
                break;
            case 'cancelled':
                $condition.=" and status in( -3,-4) ";
                break;
        }
        //$demands = Demand::whereRaw('user_id=? and status = 1',[Auth::user()->id])->get();

        $demands = Demand::whereRaw($condition)->orderBy('id', 'desc')->get();
        if($this->ismobile())
            return view('demand.mobile.my', ['demands' => $demands, 'type' => $type]);
        else
            return view('demand.my', ['demands' => $demands, 'type' => $type]);
    }

    /*
    public  function  getStatus($demands,$nstatus='')
    {
        header("Content-Type:text/html;charset=utf-8");
        $now = strtotime(gmdate('Y-m-d h:i:s')) + 28800;  //标准时间+8个小时的时区
        for ($i = 0; $i < count($demands); $i++)
        {
            $enddate = strtotime($demands[$i]->expire_time);
            $timediff = $enddate - $now;
            //var_dump($enddate .'-'. $now);exit;
            if ($enddate > $now)
            {
                $days = intval($timediff / 86400);
                $remain = $timediff % 86400;

                $hours = intval($remain / 3600);
                $remain = $remain % 3600;
                $mins = intval($remain / 60);
                $demands[$i]->expire_time_d = ($days ? $days . '天' : '') . ($hours ? $hours . '小时' : '') . $mins . '分钟';
            }
            else
            {
                $demands[$i]->expire_time_d = '已结束';
            }


            $is_win = false;
            $bidis = $demands[$i]->bids;
            for ($y = 0; $y < count($bidis); $y++)
            {
                if ($bidis[$y]->is_win == 1)
                {
                    $is_win = true;
                }
            }


            //      echo "i_win=".$is_win." and status is:".$demands[$i]->status."<br />";
            //状态0为未选标,1为选标,2已经付尾款,3为已经发货,4为收到货了
            switch ($demands[$i]->status)
            {
                case -3:
                    $demands[$i]->status_d = '已取消';
                    break;
                case -1:
                    $demands[$i]->status_d = '审核中';
                    break;
                case 0:
                    if ($demands[$i]->expire_time_d == '已结束')
                    {
                        $demands[$i]->status_d = '未选标';
                        break;
                    }
                    if ($demands[$i]->expire_time_d != '已结束')
                    {
                        if ($demands[$i]->is_pay == 0) $demands[$i]->status_d = '定金待付';
                        if ($demands[$i]->is_pay == 1) $demands[$i]->status_d = '竞价中';
                        break;
                    }

                    $bid = Bid::join('demands', function ($join)
                    {
                        $join->on('bids.demand_id', '=', 'demands.id')
                            ->where('bids.is_win', '=', '1');
                    })->where('bids.demand_id', '=', $demands[$i]->id)->first();

                    if ($bid) $demands[$i]->status_d = '待选标'; //已经有人投标了,但是没有找到合适的
                    break;
                case 1:
                    if (!$is_win)
                    {
                        $demands[$i]->status_d = '竞价结束';
                        break;
                    }

                    //   echo "demand i=".$demands[$i]->is_pay."<br />";
                    if ($demands[$i]->is_pay <= 1)
                    {
                        $demands[$i]->status_d = '待付款';
                        break;
                    }


                    break;
                case 2:
                   // $demands[$i]->status_d = '已付款';//已经支付了尾款,等待商家发货
                    $demands[$i]->status_d = '待收货';//已经支付了尾款,等待商家发货
                    break;
                case 3:
                    $demands[$i]->status_d = '已发货';
                    break;
                case 4:
                    $demands[$i]->status_d = '已完成';
                    break;

            }
            if ($nstatus != '') $demands[$i]->status_d = $nstatus; //指定状态

        }
    }

    */

    //这里是查看物流
    public function delivery($id)
    {
        header("Content-Type:text/html;charset=utf-8");
        try
        {
            $demand = Demand::findOrFail($id);
            $demand->status_d ="已发货";
            $delivery=delivery::where("deid",'=',$demand->id)->get()->first();
        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }
        return view('demand.deli', ['demand' => $demand,"deli"=>$delivery]);

    }
    //这个是商家收藏
    public function fav()
    {
        echo "this is fav";
    }
    public function shouhuo(Request $request)
    {
        $id=$request->input("deid");
        try
        {
            $demand = Demand::findOrFail($id);
            $demand->status=4;
            $demand->save();
            return redirect()->back()
                ->withErrors('已经收到货了');

        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }
    }

    public function save($id)
    {
        $setting = Setting::find($id);
        $setting->update(Input::all());
        $resolved_content = Markdown::parse(Input::get('content'));
        $setting->resolved_content = $resolved_content;
        $setting->save($id);
    }

    public function post()
    {
        //var_dump(Auth::user()->hasRole('tenderee'));exit;


        if(! isset(Auth::user()->id))
        {
            return Redirect::to('/auth/login')
                ->withErrors('你没有登录,请登录后再发布竞购！');
        }


        if(Auth::user()->hasRole('bidder'))
        {
            return redirect()->back()
                ->withErrors('您不能发布竞购，无法进行此操作。');
        }


        $cates=$this->getallcate(0);
        $data=array(  "cates"=> $cates,  );




        if ($this->ismobile())
            return view('demand.mobile.post')->with($data);
        else
            return view('demand.post')->with($data);
    }


    public function getInfo(Request $request)
    {

        $url = $request->get('url');
        if(empty($url)) {echo "no param";exit();}
       /* $tempu = parse_url($url);
        $host = $tempu['host'];
        $dotp1=strpos($host,".");
        $host=substr($host,$dotp1+1 );
        $dotp1=strpos($host,".");
        $host=substr($host,0,$dotp1);
*/
        try
        {



          //  $url = "http://info.51jinggou.com/infos.php?weburl=".$url;

            $uri = "http://info.51jinggou.com/infos.php";// 参数数组
            $data = array ( 'weburl' =>$url);
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $uri );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
            $contents = curl_exec($ch);
            curl_close($ch);
           // print_r($contents);



           // echo $url;
          //  $contents = file_get_contents($url);
            $infos= json_decode($contents);
            //var_dump($infos);

            $goods = array();
            $goods['name'] = $infos->title;
            $goods['img'] =   $infos->img;
            $goods['id'] = 0;
            $goods['code'] = 0;

            $error['code'] = 0;
            $error['msg'] = '';
            return array($error, $goods);

/*

            $host = '\\ZuiHuiGou\\libraries\api\\' . $host;
            $a = new $host();
            $infos = $a->getinfo($request->get('url'));
            return $infos;
 */
        } catch (Exception $e)
        {
            $error['code'] = 1;
            $error['msg'] = '没有找到相应的类';
            return array($error);
        }

        $error['code'] = 1;
        $error['msg'] = '暂时只支持京东,淘宝连接';
        return array($error);


    }

    public  function gettbinfo()
    {
        header("Content-Type:text/html;charset=utf-8");
        $url="http://item.jd.com/1247660.html";




        $url = "http://localhost:8028/fb/infos.php?weburl=".$url;
        $contents = file_get_contents($url);
//如果出现中文乱码使用下面代码
//$getcontent = iconv("gb2312", "utf-8",$contents);
        //echo $contents;

        $infos= json_decode($contents);

        // eval('$my_var=' . $contents . ';');
        //var_dump($my_var);
        exit();



        $spider=new GetInfos();
        $spider->geturl($url);
        exit();


        $tempu = parse_url($url);
        $host = $tempu['host'];
        $dotp1=strpos($host,".");
        $host=substr($host,$dotp1+1 );
        $dotp1=strpos($host,".");
        $host=substr($host,0,$dotp1);

        try
        {
            $host = '\\ZuiHuiGou\\libraries\api\\' . $host;
            echo $host."<br />";
            $a = new $host();
            $infos=$a->getinfo($url);
            var_dump($infos);
            return $infos;
        } catch (Exception $e)
        {
            $error['code'] = 1;
            $error['msg'] = '没有找到相应的类';
            return array($error);
        }

        $r = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'GBK,GB2312,UTF-8'); //用file_get_contents将网址打开并读取所打开的页面的内容
        preg_match('/J_itemViewed[\S\s]+?J_showContract/', $r, $goods_id);


        preg_match('/{[\S\s]+?}/', $goods_id[0], $infos);
        $oneinfo=json_decode($infos[0]);

        $goods['id'] = $oneinfo->itemId;
        $goods['price'] = $oneinfo->price/100;
        $goods['name'] = $oneinfo->title;
        $goods['img'] = 'http://gd2.alicdn.com/bao/uploaded/i2/' . $oneinfo->pic;


        $error['code'] = 0;
        $error['msg'] = '';
    }





    public function add(Request $request)
    {
        $this->validate($request, Demand::addRules());
        $demand = new Demand();
        $demand->user_id = Auth::user()->id;
        if($request->get('esCate')!=0)
            $demand->category_id = $request->get('esCate');
        else
        {
            if ($request->get('sCate') == 0)
                $demand->category_id = $request->get('fCate');
            else
                $demand->category_id = $request->get('sCate');
        }

        $helper = new Helper();
        $demand->sn = 'DE' . time() . $helper->mt_rand_str(4, '0123456789'); //单号算法：DE+当前时间戳10位数字+4位随机数
        $demand->url = $request->get('url');
        $demand->title = $request->get('title');
        $demand->price = $request->get('price');
        $demand->ip = $_SERVER["REMOTE_ADDR"];

        $cate2=Category::find($demand->category_id);
        $demand->cat2=$cate2->parent_id;
        $cate1=Category::find($cate2->parent_id);
        $demand->cat1=$cate1->parent_id;



        $demand->cat3=$request->get("esCate");
        $demand->bid=$request->get("esbrand");//品牌的ID
        //    $demand->expire_time = $request->get('expire_time');这个从支付时间算起
        $demand->avltime =intval( $request->get('avltime'));
        $demand->expire_time =date("Y-m-d H:i:s",strtotime("+ ".$demand->avltime." hours")); //设置过期时间,
        $demand->addtime = date("Y-m-d H:i:s");
        $demand->details = $request->get('details');
        $demand->status=0;//表示审核中
        $helper = new Helper();
        $demand->thumb = $helper->get_thumb($request->get('thumb'));
        $demand->save();
        //return Redirect::to('demand/show/'.$demand->id);
        return Redirect::to('/pay/deposit/' . $demand->id);
    }

    public function showDemand($id)
    {
        try
        {
            $demand = Demand::findOrFail($id);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }


        $onecate=$demand->cat1;
        $twocate=$demand->cat2;
        $tricate=$demand->cat3;
        $path=array();
        if($onecate!=0)
        {
            $cinfo=Category::find($onecate);
            if($cinfo)
            {
                $path[]=array('id'=>$cinfo->id,'name'=>$cinfo->slug );
            }
        }
        if ($twocate != 0)
        {
            $cinfo = Category::find($twocate);
            if ($cinfo)
            {
                $path[] = array('id' => $cinfo->id, 'name' => $cinfo->slug);
            }
        }

        if($tricate!=0)
        {
            $cinfo = Category::find($tricate);
            if ($cinfo)
            {
                $path[] = array('id' => $cinfo->id, 'name' => $cinfo->slug);
            }
        }




        // print_r($demand);
        $bids = $demand->bids;
        $myBid = null;

        $bidinfo=$this->getbidinfo($demand);
        $lowprice = $bidinfo['lowprice'];

        if (isset(Auth::user()->id))
        {
            foreach ($bids as $bid)
            {
                if ($bid->user_id == Auth::user()->id)
                {
                    $myBid = $bid;
                    break;
                }
            }
        }

        $data=array(
            'demand' => $demand, 'bids' => $bids, 'myBid' => $myBid,
            'lowprice' => $lowprice,
            'path'=>$path
        );


        if ($this->ismobile())
            return view('demand.mobile.show', $data);
        else
            return view('demand.show',$data);

    }

    //找出竞价的相关信息,比如最低价,出价用户,出价
    public function getbidinfo($demand)
    {
        $bids =$demand->bids;

        $data=array();
        $data['demand']=$demand;
        $data['bids']=$bids;//所有的出价信息

        $myBid = null;

        $lowprice=9999999;
        $firstbidtime=strtotime("now");
        $data['winbid']=null;
        $data['firstbid']=null;
        $data['lowbid']=null;
        $data['winuser']=null;
        $data['lowprice']=$lowprice;
        foreach ($bids as $bid)
        {
            if ($bid->is_win == 1)
            {
                $data['winbid']=$bid;
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

    public function choose(Request $request,$id)
    {
        try
        {
            $demand = Demand::findOrFail($id);

            if($request->method()=="POST")
            {
                $demand->deposit=0;
                $demand->status=-4;
                $demand->save();
                return Redirect::to('demand/my/all')
                    ->withErrors('当前竞购已经被放弃。');
            }


            $user=Auth::user();


            $bids=$demand->bids;//所有的竞价
            $avlbids=array();
            foreach ($bids as $bid)
            {
                $oneuser = User::where("id", "=", $bid->user_id)->get()->first();
                $bid->username = $oneuser->username;

                if($bid->is_win==1)
                {
                    return   redirect()->back()
                        ->withErrors('已经有人中标了。');
                }
                if ($bid->price <= 0.9 * $demand->price)
                {
                    $avlbids[] = $bid;
                }
            }

            $data = array(
                'demand' => $demand,
                'avlbids'=>$avlbids,
                'user'=>$user
            );
            return view('demand.choose')->with($data);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }

    }

    public function getallcate($id=0)
    {
        $fCates = DB::select('select * from categories where parent_id = ' . $id." order by sort asc,id asc");
        $cates = array();
        for ($i = 0; $i < count($fCates); $i++)
        {
            $cates[$i]['id'] = $fCates[$i]->id;
            $cates[$i]['name'] = $fCates[$i]->name;
            $cates[$i]['slug'] = $fCates[$i]->slug;
            $cates[$i]['slug'] = $fCates[$i]->slug;
            $sCates = $this->getallcate($fCates[$i]->id);
            $cates[$i]['children'] = $sCates;
        }
        return $cates;
    }

    public function getCategories()
    {
        $fCates = DB::select('select * from categories where parent_id = 0');
        $cates = array();
        for ($i = 0; $i < count($fCates); $i++)
        {
            $cates[$i]['id'] = $fCates[$i]->id;
            $cates[$i]['name'] = $fCates[$i]->name;
            $cates[$i]['slug'] = $fCates[$i]->slug;
            $cates[$i]['slug'] = $fCates[$i]->slug;
            $sCates = DB::select('select * from categories where parent_id = ' . $fCates[$i]->id);

            $cates[$i]['children'] = $sCates;
        }
        return $cates;
    }

    public function cancelDemand($id)
    {
        try
        {
            $demand = Demand::findOrFail($id);
            $message= $demand->cancel();
            return Redirect::to('/demand/my')
                ->withInput()
                ->withErrors($message);


        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }


    }

    public function delaya(Request $request, $id)
    {
        try
        {
            $demand = Demand::findOrFail($id);
            if($request->method()=="POST")
            {
                $delaytime=$request->input("delaytime");
                $demand->expire_time= date("Y-m-d H:i:s",strtotime("+ $delaytime hours")) ;
                $demand->save();
                return Redirect::to('demand/my/active')->withErrors('延时成功！');
            }

        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }
        return view('demand.delay' ,['demand' => $demand ] );
    }

    public function win(Request $request)
    {
        try
        {

            $action=$request->get("action");
            if($action=="")
            {
                $bid = Bid::findOrFail($request->get('id'));
                if($bid->demand->stauts<0)
                {
                    return Redirect::to('/demand/show/' . $bid->demand->id)
                        ->withErrors('当前状态下不能选择中标！');
                }

                if (Auth::user()->id != $bid->demand->user_id)
                {
                    return '没有权限';
                    return Redirect::to('/demand/show/' . $bid->demand->id)
                        ->withInput()
                        ->withErrors('没有权限！');
                }


                $bid->is_win = 1;
                $bid->demand->status = 1;
                $bid->save();
                $bid->demand->save();
                return '操作成功';

                return Redirect::to('/demand/show/' . $bid->demand->id)
                    ->withInput()
                    ->withErrors('操作成功！');
            }



            if($action=="drop") //放弃
            {
                $deid=$request->get("deid");
                $demand=Demand::findOrFail($deid);
                $demand->status="-3";//取消,放弃
                $demand->deposit=0;//扣除保证金
                $demand->save();
                return '操作成功';
            }

        } catch (ModelNotFoundException $e)
        {
            return '删除';
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }


    }
}
