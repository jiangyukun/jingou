<?php namespace ZuiHuiGou\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use ZuiHuiGou\Address;
use ZuiHuiGou\Bid;
use ZuiHuiGou\delivery;
use ZuiHuiGou\Demand;
use ZuiHuiGou\Setting;
use Illuminate\Http\Request;
use ZuiHuiGou\Http\Helper;
use ZuiHuiGou\User;
use ZuiHuiGou\Certification;

class BidController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function addBid(Request $request)
    {

        $this->validate($request, Bid::addRules());
       if(! isset(Auth::user()->id))
           return Redirect::to('/auth/login')
               ->withErrors('你没有登录,请登录后再出价！');

        $cert = Certification::where('user_id', '=', Auth::user()->id)->first();
        if($cert==null)
        {
            return Redirect::to('auth/cert')->with('cert', $cert)
                ->withErrors('你没有通过审核,请审核后再出价！');
        }

        if ($cert->is_identity == "1" && $cert->is_license == "1")
        {
            $user=User::where("id","=",Auth::user()->id)->get()->first();
            if($user->deposit=="0")//未交保证金
            {
                $demand = new Demand();
                $demand->title = "商家".$user->username."支付保证金 - ";
                $lastPrice = 2000;
                $showtitle="支付保证金";
                $step=3;  //商家的保证金为3
                $purl="/pay/payorder/bidder";
                return view('pay.demand', ['demand' => $demand, 'lastPrice' => $lastPrice,'showtitle'=> $showtitle,
                    'step'=>$step ,'purl'=>$purl ])
                    ->withErrors('请缴纳保证金后出价！');
            }
        }
        else
            return Redirect::to('auth/cert')->with('cert', $cert)
                ->withErrors('你没有通过审核,请审核后再出价！');



     //       return Redirect::to('/auth/cert')
      //          ->withErrors('删除成功！');





        if ($request->bid_id == 0)
        {
            $bid = new Bid();
            $bid->user_id = Auth::user()->id;
            $bid->demand_id = $request->get('demand_id');
            $helper = new Helper();
            $bid->sn = 'DE' . time() . $helper->mt_rand_str(4, '0123456789'); //单号算法：DE+当前时间戳10位数字+4位随机数
            $bid->url = $request->get('url');
            $bid->price = $request->get('price');
            $bid->details = $request->get('details');
            $bid->area_id = 110000;
            $bid->save();
        }
        else
        {
            $bid = Bid::find($request->bid_id);
            $bid->price = $request->get('price');
            $bid->details = $request->get('details');
            $bid->url = $request->get('url');
            $bid->save();
        }
        return Redirect::to('demand/show/' . $bid->demand_id);
    }


    public function fahuo(Request $request,$id)
    {
        if($request->isMethod("post"))
        {
            $deid=$request->input("deid");
            $demand=Demand::where("id","=",$deid)->get()->first();
            if(!$demand)
            {
                return redirect()->back()->withErrors('没有找到订单。');
            }
            $demand->status=3;
            $demand->save();

            $types="";
            $deli=new delivery();
            $deli->deid=$deid;
            $deli->uid=$demand->user_id;
            $deli->types=$request->input("express");
            $deli->numbers=$request->input("numbers");
            $deli->notes=$request->input("notes");

            $deli->save();

            return Redirect::to('bid/my/all')
                ->withErrors('发货成功！');

        }

        $demand=Demand::where("id","=",$id)->get()->first();
        if(!$demand)
        {
            return redirect()->back()->withErrors('没有找到订单。');
        }
        $user=User::where("id","=",$demand->user_id)->get()->first();
        $addr = Address::where("id", "=", $demand->addrid)->get()->first();
        $data=array("user"=>$user,
            "demand"=>$demand,
            'addr'=>$addr
        );
        return view('bid.fahuo')->with($data);
    }

    public function shoukuan($id)
    {

        try
        {
            $userid = Auth::user()->id;
            $demand = Demand::findOrFail($id);

            $bid=Bid::whereRaw(" demand_id=".$demand->id." and user_id=".$userid." and is_win=1")->get()->first();
            if(!$bid)
            {
                return redirect()->back()
                    ->withInput()
                    ->withErrors('没有找到相关的订单,收款失败。');
            }
            $demand->status=5;
            $demand->save();//收款
            return redirect()->back()
                ->withInput()
                ->withErrors('收款成功。');

        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }
    }

    public function myexpress()
    {
        header("Content-Type:text/html;charset=utf-8");

        $delis= delivery::where("uid",'=',Auth::user()->id)->orderBy('id', 'desc')->get();


        return view('bid.deliveries')->with(array("delis"=>$delis));


    }
   /* public function savehuo(Request $request)
    {
       echo "hello world";
    }
*/

    public function myBidsByType($type='all')
    {
        header("Content-Type:text/html;charset=utf-8");
        $bidcondition=" bids.user_id=".Auth::user()->id;
        $demandcon=" 1=1 ";
        switch ($type)
        {
            case 'all':
                break;
            case 'active':
                $demandcon.=" and demands.status=0 and expire_time>CURRENT_TIMESTAMP()";
                break;
            case 'win':
                $bidcondition.=" and bids.is_win=1 ";
                $demandcon.=" and demands.status=1 ";
                break;
            case "notchoose": //已经结束但是没有选标的
                $demandcon.=" and demands.status=0  and  expire_time<CURRENT_TIMESTAMP()";
                break;
            case "notpayed": //未付尾款的
                $demandcon.=" and demands.status=1 and demands.is_pay=1 ";
                $bidcondition.=" and bids.is_win=1 ";
                break;
            case "notsend":
                $demandcon.=" and demands.status=2 and demands.is_pay=2";
                break;
            case "notreceive":
                $demandcon.="  and demands.status in(3,4) and bids.is_win=1";
                break;
            case "lose":
                $bidcondition.=" and bids.is_win<>1 ";
                $demandcon .=" and demands.is_pay>0 ";
                break;
            case 'finish':
                $demandcon.=" and demands.status=5 and  bids.is_win=1";
                break;
        }

        $bids= Bid::leftJoin('demands', 'bids.demand_id', '=', 'demands.id')
        ->select("bids.*","demands.price as dprice" )
        ->whereRaw($bidcondition)
        ->whereRaw($demandcon)
            ->orderBy('demands.id', 'desc')
            ->get();

//        print_r($bids);exit();

        $data=array('bids' => $bids, 'type' => $type);

        if ($this->ismobile())
            return view('bid.mobile.my')->with($data);
        else
            return view('bid.my')->with($data);
    }


    public function  myinfo()
    {
        return view('bid.myinfo' );
    }

    public function cancelBid($id)
    {
        try
        {
            $bid = Bid::findOrFail($id);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞价信息不存在或已被删除！');
        }
        $bid->delete();
        return Redirect::to('/bid/my')
            ->withInput()
            ->withErrors('删除成功！');
    }

}
