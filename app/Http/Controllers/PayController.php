<?php namespace ZuiHuiGou\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use ZuiHuiGou\Address;
use ZuiHuiGou\Area;
use ZuiHuiGou\Bid;
use ZuiHuiGou\Demand;
use ZuiHuiGou\libraries\pay\alipaywap;
use ZuiHuiGou\Setting;
use Illuminate\Http\Request;
use ZuiHuiGou\Http\Helper;
use ZuiHuiGou\User;
use ZuiHuiGou\orders;

class PayController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function deposit($id)
    {
        header("Content-Type:text/html;charset=utf-8");
        try
        {
            $demand = Demand::findOrFail($id);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }



        switch ($demand->status)
        {
            case -3:
                return Redirect::to('/')
                    ->withInput()
                    ->withErrors('该竞购已取消！');
                $demand->status = '已取消';
                break;
            case -1:
                $demand->status = '审核中';
                break;
            case 0:
                $demand->status = '竞价中';
                if($demand->is_pay==1)
                {
                    return Redirect::to('/demand/my')
                        ->withInput()
                        ->withErrors('竞购订金支付成功！');
                }
                break;
            case 1:
                return Redirect::to('/')
                    ->withInput()
                    ->withErrors('该竞购已结束！');
                $demand->status = '竞价结束';
                break;
        }

        $dset=Setting::where('set_key','=',"deposite")->get()->first();
        $depositfee=intval($dset->set_value);
        $deposit = $demand->price *  $depositfee / 100;

        $data=array(
            'demand' => $demand, 'deposit' => $deposit,'depositfee'=>$depositfee
        );

        if ($this->ismobile())
            return view('pay.mobile.deposit')->with($data);
        else
            return view('pay.deposit')->with($data);
    }

    public function payDeposit(Request $request,   $id)
    {
        header("Content-Type:text/html;charset=utf-8");
        $demand = Demand::findOrFail($id);
        $dset=Setting::where('set_key','=',"deposite")->get()->first();
        $depositfee=intval($dset->set_value);
        $demand->deposit = $demand->price * $depositfee / 100;  //这个地方需要个判断
        $demand->save();//这个是支付定金的地方


    //    $oneorder=Orders::where("desn1","=",$id);

        $order= DB::table('orders')->where('desn', '=',$id)->first();


        if ($order == null)
        {
            $order = new orders();
            $order->desn = $demand->id;
            $order->userid=Auth::user()->id;//加入用户的编号,用于以后检索
            $order->fee = $demand->deposit;
            $order->fee = 0.01; //must comment
            $order->step = 1; //第一阶段支付保证金
            $order->status = 0;


            $order->title = $demand->title . "-支付保证金";
            $order->details = $demand->title . "-支付保证金";
            $order->showurl = "http://www.51jinggou.com/demand/show/" . $id;
            $order->save();
        }
        else
        {
            if($order->status==1)
                return redirect()->back()
                    ->withErrors('您已经支付过保证金了,不需要再支付一次。');

        }

        $paytype=$request->input("pay_type");



        if($paytype=="alipay")
        {
            if ($this->ismobile())
                $this->alipayapi($order->id);
            else
                $this->payorder($order->id);

        }elseif($paytype=="weixin")
        {

            //微信支付
         //   $data=array( "deid"=>$id,'orderid'=>$order->id );
         //   return view('pay.chooseb',$data );
         //   return ;
        }else
        {        //网银支付
            $this->bankorder($paytype,$order->id);
        }
     }

    public function wxpay(Request $request)
    {

    }




    //使用网银支付
    public function paybank(Request $request)
    {
        $bank=$request->input("banks");
        $order=$request->input("orderid");
        $this->bankorder($bank,$order);
    }


//使用网争支付
    public function bankorder($bankname,$id)
    {
        header("Content-Type:text/html;charset=utf-8");
        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= '2088021119804774';
        $alipay_config['seller_email']	= '2896852384@qq.com';
        $alipay_config['key']			= 'celthm4ly0ajknddh6hmz0xecmxm68sw';
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        $alipay_config['sign_type']    = strtoupper('MD5');
        $alipay_config['input_charset']= strtolower('utf-8');
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $alipay_config['transport']    = 'http';



        //支付类型
        $payment_type = "1";
        $siteurl="http://jg51.game0635.com/pay/back/";
        $notify_url = $siteurl; //必填，不能修改服务器异步  通知页面路径
        $return_url = $siteurl; //需http://格式的完整路径，不能加?id=123这类自定义参数  页面跳转同步通知页面路径

        $oneorder = orders::findOrFail($id);
        $out_trade_no = $oneorder->id; //商户网站订单系统中唯一订单号，必填
        $subject = $oneorder->title ; //订单名称
        $total_fee = $oneorder->fee;   //必填付款金额
        $body = $oneorder->details; //必填订单描述
        $show_url = $oneorder->showurl;//商品展示地址
        $paymethod = "bankPay";
        $defaultbank =$bankname;
        //非局域网的外网IP地址，如：221.0.0.1

        $anti_phishing_key = "";
        $exter_invoke_ip = "";
        /************************************************************/

//构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "paymethod"	=> $paymethod,
            "defaultbank"	=> $defaultbank,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );


//建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;


    }





    //step=1 表示保证金,step=2表示尾款
     public function  payorder($id )
     {
         header("Content-Type:text/html;charset=utf-8");
         //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
         $alipay_config['partner'] = '2088021119804774'; //合作身份者id，以2088开头的16位纯数字
         $alipay_config['seller_email'] = '2896852384@qq.com'; //收款支付宝账号
         $alipay_config['key'] = 'celthm4ly0ajknddh6hmz0xecmxm68sw'; //安全检验码，以数字和字母组成的32位字符
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
         $alipay_config['sign_type'] = strtoupper('MD5'); //签名方式 不需修改
         $alipay_config['input_charset'] = strtolower('utf-8'); //字符编码格式 目前支持 gbk 或 utf-8
         $alipay_config['cacert'] = getcwd() . '\\cacert.pem'; //ca证书路径地址，用于curl中ssl校验 请保证cacert.pem文件在当前文件夹目录中
         $alipay_config['transport'] = 'http'; //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

         $payment_type = "1"; //支付类型
         $siteurl="http://jg51.game0635.com/pay/back/";
         $notify_url = $siteurl; //必填，不能修改服务器异步  通知页面路径
         $return_url = $siteurl; //需http://格式的完整路径，不能加?id=123这类自定义参数  页面跳转同步通知页面路径
         //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/  商户订单号

      //   echo "id=$id;<br />";
        $oneorder = orders::findOrFail($id);
        $out_trade_no = $oneorder->id; //商户网站订单系统中唯一订单号，必填
        $subject = $oneorder->title ; //订单名称
        $total_fee = $oneorder->fee;   //必填付款金额
        $body = $oneorder->details; //必填订单描述
        $show_url = $oneorder->showurl;//商品展示地址
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1



        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "show_url"	=> $show_url,
            "anti_phishing_key"	=> $anti_phishing_key,
            "exter_invoke_ip"	=> $exter_invoke_ip,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );

//建立请求
        //var_dump($parameter);exit();

     $alipaySubmit = new AlipaySubmit($alipay_config);
      $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");


        echo $html_text;


    }


    public function backorder()
    {
        header("Content-Type:text/html;charset=utf-8");
        //var_dump($_GET);
        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $alipay_config['partner'] = '2088021119804774'; //合作身份者id，以2088开头的16位纯数字
        $alipay_config['seller_email'] = '2896852384@qq.com'; //收款支付宝账号
        $alipay_config['key'] = 'celthm4ly0ajknddh6hmz0xecmxm68sw'; //安全检验码，以数字和字母组成的32位字符
        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        $alipay_config['sign_type'] = strtoupper('MD5'); //签名方式 不需修改
        $alipay_config['input_charset'] = strtolower('utf-8'); //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['cacert'] = getcwd() . '\\cacert.pem'; //ca证书路径地址，用于curl中ssl校验 请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['transport'] = 'http'; //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        $verify_result=true;  //must comment
        if ($verify_result)
        { //验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            $out_trade_no = $_GET['out_trade_no']; //商户订单号
            $trade_no = $_GET['out_trade_no']; //支付宝交易号
            $total_fee=$_GET["total_fee"];
         //   $trade_no=10; //comment
         //   $total_fee="219.9";
            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS')
            {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $oneOrder = Orders::where('id','=',$trade_no)->orderBy('id', 'desc')->get()->first();
                if($oneOrder==null)
                {
                    echo "没有找到订单,返回<a href='/demand/my/'>用户中心</a>";
                    exit();
                }

                if($oneOrder->status=="1")
                {
                    echo "订单已经支付过了,返回<a href='/demand/my/'>用户中心</a>";
                    exit();
                }
                if($oneOrder->fee!=$total_fee)
                {
                    echo "支付金额与订单金额不等,返回<a href='/demand/my/'>用户中心</a>";
                    exit();
                }

              //  var_dump($demand);//comment
                $oneOrder->status = 1;
                $oneOrder->save();//设置订单状态,查找竞价并设置状态

                //竞价支付保证金
               if($oneOrder->step=='1')
               {
                   $buyer_email = "";
                   if (isset($_GET['buyer_email']))
                       $buyer_email = $_GET['buyer_email'];
                   $demand=Demand::where("id","=",$oneOrder->desn)->get()->first();
                   if($demand==null)
                   {
                       echo "未找到竞价单,支付失败";
                       exit();
                   }
                   $demand->is_pay=1; //设置成订单已经支付保证金的情况下
                   $demand->paytime=date("Y-m-d H:i:s");
                   $demand->expire_time=date("Y-m-d H:i:s", strtotime("+ ".$demand->avltime." hours")  ) ; //设置过期时间
                   $demand->deposit=$total_fee ; //设置收到的保证金
                   $demand->save();

                   if($buyer_email)
                   {
                       $buyer = User::where('id', '=', $demand->user_id)->get()->first();
                       $buyer->alipay = $buyer_email;
                       $buyer->save();
                   }

                   echo "支付竞价保证金成功,请刷新页面,返回 <a href='/demand/my/'>用户中心</a>";

               }
                //竞价支付尾款
                if($oneOrder->step=='2')
                {
                    $demand=Demand::where("id","=",$oneOrder->desn)->get()->first();
                    if($demand==null)
                    {
                        echo "未找到竞价单,支付失败";
                        exit();
                    }
                    $demand->is_pay=2; //设置成订单已经支付保证金的情况下
                    $demand->status=2;//设置成已经支付尾款,
                    $demand->save();
                    echo "支付竞价尾款成功,请刷新页面 &nbsp;返回 <a href='/demand/my/'>用户中心</a>";
                }

                //商家支付保证金
                if($oneOrder->step=='3')
                {
                    $buyer_email=$_GET['buyer_email'];//支付人的支付宝
                    $res=User::where("id","=",$oneOrder->desn)->update(array('deposit' => $oneOrder->fee,'alipay'=>$buyer_email));
                    //desn为订单的id在支付保证金时,这个字段存储的是商家的id
                    if ($res)
                        echo "商家支付保证金成功,请刷新页面";
                    else
                        echo "商家支付保证金失败,没有找到此用户";
                }


            }
            else
            {
                echo "trade_status=" . $_GET['trade_status'];
            }

            echo "验证成功<br />";

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
    else {
        //验证失败
        //如要调试，请看alipay_notify.php页面的verifyReturn函数
        echo "验证失败";
    }




    }

    public function saveaddr(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
      //  $addrid=$request->input("myaddr");
      //  echo "addrid=".$addrid;
     //   var_dump($_POST);exit();
        $addrid=$request->input("myaddr"); //如果不是已经选好的地址,就是新增
        if($addrid)
        {
            $demand=Demand::findOrFail($request->input("deid"));
            if($demand!=null)
            {
                $demand->addrid=$addrid;
                $demand->save();
                return "保存地址成功";
            }
            else
            {
                echo "参数错误未找到订单";
                exit();
            }
        }



        $addr=new Address();
        $send=$request->input('send');
        $addr->user_id=Auth::user()->id;
        $addr->name=$send['name'];

        //$addr->title=$send['title'];
        // $addr->telephone=$send['telephone'];
        // $addr->zipcode=$send['zipcode'];

        $addr->province = $request->input('province');
        $addr->city = $request->input('city');
        $addr->mobile = $send['mobile'];
        $addr->area_id = $request->input("district");
        $addr->addr_detail = $request->input('addr_detail');



        $onearea=Area::select("areaname")->where("id",'=',  $addr->province)->get()->first();
        $provincename=$onearea->areaname;
        $onearea=Area::select("areaname")->where("id",'=',  $addr->city)->get()->first();
        $cityname=$onearea->areaname;


        $addr->fulladdr = $provincename . " " .$cityname . " " . $addr->addr_detail;
        $addr->is_default = 1;

        $addr->save();

        $demand=Demand::findOrFail($request->input("deid"));
        $demand->addrid=$addr->id;
        $demand->save();//保存订单的地址
      //  return "保存地址成功";
        return Redirect::to('demand/my')
            ->withErrors('保存地址成功！');
    }

    public function action(Request $request)
    {
        print_r(Input::all());
    }

    public function atest()
    {
        if($this->ismobile())
            return view('pay.mobile.atest'  );
        else
            echo "hello world";
        // return view('pay.atest'  );

    }


    //这个是手机网站的支付接口
    //ali wap接口
    public function alipayapi($id)
    {

        header("Content-Type:text/html;charset=utf-8");
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= '2088021119804774';
        $alipay_config['seller_id']	= $alipay_config['partner'];
        $alipay_config['private_key_path']	=getcwd(). '\\key\\rsa_private_key.pem';
        $alipay_config['ali_public_key_path']= getcwd().'\\key\\alipay_public_key.pem';
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('RSA');
        $alipay_config['input_charset']= strtolower('utf-8');
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $alipay_config['transport']    = 'http';


        //支付类型
        $payment_type = "1";



        $siteurl="http://jg51.game0635.com/pay/back/";
        $notify_url = $siteurl;
        $return_url =$siteurl;

        $oneorder = orders::findOrFail($id);
        $out_trade_no = $oneorder->id; //商户网站订单系统中唯一订单号，必填
        $subject = $oneorder->title ; //订单名称
        $total_fee = $oneorder->fee;   //必填付款金额
        $body = $oneorder->details; //必填订单描述
        $show_url = $oneorder->showurl;//商品展示地址



        //商户订单号
        $out_trade_no = $oneorder->id;//商户网站订单系统中唯一订单号，必填
        $subject = $oneorder->title ;//必填订单名称付款金额
        $total_fee = $oneorder->fee; //必填
        $show_url =  $oneorder->showurl;//商品展示地址
        $body =  $oneorder->details; //必填订单描述
        $it_b_pay = "";
        $extern_token = "";



        /************************************************************/

//构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "alipay.wap.create.direct.pay.by.user",
            "partner" => trim($alipay_config['partner']),
            "seller_id" => trim($alipay_config['seller_id']),
            "payment_type"	=> $payment_type,
            "notify_url"	=> $notify_url,
            "return_url"	=> $return_url,
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "show_url"	=> $show_url,
            "body"	=> $body,
            "it_b_pay"	=> $it_b_pay,
            "extern_token"	=> $extern_token,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );

//建立请求
        $alipaySubmit = new  alipaywap\AlipaywapSubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }


    public function demand($id)
    {
        header("Content-Type:text/html;charset=utf-8");
        try
        {
            $uid=Auth::user()->id;
            $useraddrs=Address::where("user_id","=",$uid)->get();
            $provices=Area::whereRaw('parent_id=1')->orderby('id','asc')->get();
            $areas=Area::whereRaw('1=1')->orderBy('id','desc')->get();

            $demand = Demand::findOrFail($id);
            if($demand->is_pay==2)
            {
                $order=Orders::where("deid","=",$demand->id)
                                ->where("step","=",2)->first();
                if($order!=null)
                return Redirect::to('pay/address/'.$order->id)
                    ->withErrors('尾款已经支付完毕,等待卖家发货');
            }

        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('竞购信息不存在或已被删除！');
        }

        $winbid=Bid::whereRaw("demand_id=$id and is_win=1")->first();
        if($winbid==null)
        {
            return redirect()->back()
                ->withErrors('没有找到中标的竞价。');
            exit();
        }



        $demand->title="支付尾款 - ".$demand->title;
        $lastPrice = $winbid->price - $demand->deposit;
        $showtitle="支付商品货款";
        $step=2;//竞购的尾款的支付类型为2

        $data=array(
            'demand' => $demand,
            'winprice'=>$winbid->price,
            'lastPrice' => $lastPrice,
            'showtitle'=>$showtitle,
            'step'=>$step,
            'areas'=>$areas,
            'provices'=>$provices,
            'useraddrs'=>$useraddrs,

        );

        if ($this->ismobile())
            return view('pay.mobile.demand', $data);
        else
            return view('pay.demand', $data);
    }



    //POST支付尾款的动作
    public function payDemand(Request $request,$id)
    {
        $demand = Demand::findOrFail($id);
        $demand->is_pay = 1;
        $demand->save();


        $winbid=Bid::whereRaw("demand_id=$id and is_win=1")->first();

        $order=new Orders();
        $order->desn=$demand->id;
        $order->userid=Auth::user()->id;//这个是用户的编号用于以后检索
        $order->fee=$winbid->price-$demand->deposit;
        $order->fee=0.01;//must comment
        $order->step=2;//这是第二阶段来支付尾款
        $order->status=0;


        $order->title = $demand->title . "-支付尾款";
        $order->details = $demand->title . "-支付尾款";
        $order->showurl = "http://www.51jinggou.com/demand/show/" . $id;
        $order->save();



        $paytype=$request->input("pay_type");
        if($paytype=="alipay")
        {

          //  echo "this is alipay and id=".$order->id;

            //支付宝支付
            //根据不同的用户界面pc与mobile进行跳转
            if ($this->ismobile())
                $this->alipayapi($order->id);
            else
                $this->payorder($order->id);

            exit();
            return;
        }elseif($paytype=="weixin")
        {
            exit();
            //微信支付
            return;
        }else
        {
           // echo "this is bankpay";
        //网银支付
        $this->bankorder($paytype,$order->id);
        }


/*
        return Redirect::to('/demand/show/' . $demand->id)
            ->withInput()
            ->withErrors('尾款支付成功，等待卖家发货！');
*/
    }


    //显示页面来让用户选择地址
    public function address(Request $request,$id=0 )
    {
        header("Content-Type:text/html;charset=utf-8");
        if($id==0) {
            echo "参数错误,没有找到订单";
            exit();
        }

        //这个地方,需要判断一下有没有tendree的权限
      //  echo "userid=".Auth::user()->id;
        $order=Orders::where("id","=",$id)->where("userid","=",Auth::user()->id)
        ->where("step","=",2)
            ->first();//只有支付到了第二段才有可能去选地址
        if($order==null)
        {
            echo "参数错误,没有找到订单";
            exit();
        }

        $uid=Auth::user()->id;
        $useraddrs=Address::where("user_id","=",$uid)->get();
        $provices=Area::whereRaw('parent_id=1')->orderby('id','asc')->get();
        $areas=Area::whereRaw('1=1')->orderBy('id','desc')->get();

        $order = Orders::findOrFail($id);
        $data=array(
            'order' => $order,
            'areas'=>$areas,
            'provices'=>$provices,
            'useraddrs'=>$useraddrs,
        );

        return view('pay.address', $data);
    }

    //这个是商户支付保证金,所以desn一般作为竞购的编号,但这个地方,用的是用户的ID
    public function bidderdeposit()
    {
        $order=new Orders();
        $order->desn=Auth::user()->id;
        $order->fee=200;
        $order->fee=0.01;//must comment
        $order->step=3;//这是商家支付保证金
        $order->status=0;

        $order->title = Auth::user()->username . "-支付保证金";
        $order->details =Auth::user()->username . "-支付保证金";
        $order->showurl = "http://www.51jinggou.com/demand/show/1" ;
        $order->save();
        $this->payorder($order->id);


    }

}
