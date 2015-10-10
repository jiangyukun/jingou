<?php namespace ZuiHuiGou\Http\Controllers\Auth;

use Ender\YunPianSms\SMS\YunPianSms;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Krucas\Notification\Facades\Notification;
use ZuiHuiGou\Certification;
use ZuiHuiGou\Demand;
use ZuiHuiGou\Http\Helper;
use ZuiHuiGou\Http\Requests;
use ZuiHuiGou\Http\Controllers\Controller;
use ZuiHuiGou\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;









class AuthorityController extends Controller
{

    /**
     * 返回login视图,登录页面
     */
    public function loginGet()
    {
        if ($this->ismobile())
            return view('auth.mobile.login');
        else
            return view('auth/login');
    }

    /**
     * 登录响应
     */
    public function loginPost(Request $request)
    {
        $this->validate($request, User::loginRules());
        $username = $request->get('username');
        $password = $request->get('password');
        //var_dump(Auth::attempt(['username' => $username, 'password' => $password], $request->get('remember')));exit;
        if (Auth::attempt(['username' => $username, 'password' => $password], $request->get('remember')))
        {
            $user=User::find(Auth::user()->id);
            $user->last_time=date("Y-m-d H:i:s");
            $user->save();

            if (Auth::user()->hasRole('bidder'))
            {
                return Redirect::to('auth/cert');
            }
            if ($request->get('refe') != '')
            {
                return Redirect::to($request->get('refe'));
            }
            return Redirect::to('/');
        }
        else
        {
            return Redirect::route('login')
                ->withInput()
                ->withErrors('用户名或密码,请重试！');
        }
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
        }
        return Redirect::route('login');
    }


    /**
     * 注册页面
     */
    public function registerGet()
    {
        if ($this->ismobile())
            return view('auth.mobile.register');
        else
            return view('auth/register');
    }



    public function  retrieve()
    {
        if ($this->ismobile())
            return view('auth.mobile.retrieve');
        else
            return view('auth.retrieve');
    }


    public function isUsernameExist(Request $request)
    {
        $user = DB::table('users')->where('username', $request->get('username'))->first();
        if ($user) return 1;
        else return 0;
    }

    public function isMobileExist(Request $request)
    {
        $user = DB::table('users')->where('mobile', $request->get('mobile'))->first();
        if ($user) return 1;
        else return 0;
    }

    /**
     * 注册响应
     */
    public function registerPost(Request $request)
    {
        $this->validate($request, User::registerRules());

        $regcode=Session::get('mobile_code');
        $mobile_code= $request->get('mobile_code');
        if($regcode!=$mobile_code)
        {
            return redirect()->back()
                ->withErrors('手机验证码不正确。 ');
            exit();
        }

        if (time() - Session::get('mobile_code_time') > 1800)
        {
            return redirect()->back()
                ->withErrors('验证码已经过期。 ');
            exit();
        }

        $user = new User();
        $user->username = $request->get('username');
        $user->mobile = $request->get('mobile');
        $user->password = Hash::make($request->get('password'));
        $user->reg_ip=$_SERVER["REMOTE_ADDR"];
        if ($user->save())
        {
            //注册成功直接登录
            Auth::attempt(['username' => $user->username, 'password' => $request->get('password')], true);
            if ($request->get('reg_type') == 0)
            {
                $user->roles()->attach(2); // 招标人
                return Redirect::to('/');
            }
            else
            {
                $user->roles()->attach(3); // 投标人
                return Redirect::to('/auth/cert');
            }
        }
        else
        {
            return Redirect::route('register')
                ->withErrors('注册失败，请重试！')
                ->withInput();
        }
    }

    public function checkMobileCode(Request $request)
    {

        $mobile_code = Session::get('mobile_code');
       //  echo "session time= ".  date("Y-m-d H:i:s",Session::get('mobile_code_time'))  ."<br />";
      //  echo "now=". date("Y-m-d H:i:s")."<br />";
      //  echo time() - Session::get('mobile_code_time');

        if( $request->get('mobile_code')  == $mobile_code)
        {
            if (time() - Session::get('mobile_code_time') > 1800)
            {
                return 0;
            }
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function getRegCode(Request $request)
    {
        if (Session::has('mobile_code'))
        {
            if (time() - Session::get('mobile_code_time') < 30)
            {
                return 999;
            }
        }



      /*  $yunpianSms = new YunPianSms();
        $helper = new Helper();
        $random_code = $helper->mt_rand_str(6, '0123456789');
        $response = $yunpianSms->sendMsg($mobile, '【最惠购】您的验证码是' . $random_code . '。有效期为5分钟，请尽快验证');

        */

        $mobile = $request->get('mobile');
        $apikey = "b2e2c4a661a0cf7e1d80f7bb167d142f"; //请用自己的apikey代替
        $helper = new Helper();
        $random_code = $helper->mt_rand_str(6, '0123456789');
        $tpl_value = "#company#=最惠购&#code#=".$random_code;

       // $text='【最惠购】您的验证码是' . $random_code . '。有效期为5分钟，请尽快验证';
       // Session::flash('regcode', $random_code);

        $tpl_id = 1;
        $response= json_decode($this->tpl_send_sms($apikey,$tpl_id, $tpl_value, $mobile))->data->code;


        //Log::error('Something is really going wrong.');
      //  $result = json_decode($response)->data->code;
     //   if ($result == 0)
     //   {
            Session::put('mobile_code',$random_code);
            Session::put('mobile_code_time', time());
     //   }
        Session::save();
        return $response;
    }


    /**
     * 模板接口发短信
     * apikey 为云片分配的apikey
     * tpl_id 为模板id
     * tpl_value 为模板值
     * mobile 为接受短信的手机号
     */
    function tpl_send_sms($apikey, $tpl_id, $tpl_value, $mobile){
        $url="http://yunpian.com/v1/sms/tpl_send.json";
        $encoded_tpl_value = urlencode("$tpl_value");  //tpl_value需整体转义
        $mobile = urlencode("$mobile");
        $query="apikey=$apikey&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";


        $data = "";
        $info=parse_url($url);
        $fp=fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head="POST ".$info['path']." HTTP/1.0\r\n";
        $head.="Host: ".$info['host']."\r\n";
        $head.="Referer: http://".$info['host'].$info['path']."\r\n";
        $head.="Content-type: application/x-www-form-urlencoded\r\n";
        $head.="Content-Length: ".strlen(trim($query))."\r\n";
        $head.="\r\n";
        $head.=trim($query);
        $write=fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header.=$str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        return $data;
    }









    public function atest(Request $request)
    {
        /*if (Session::has('mobile_code'))
        {
            if (time() - Session::get('mobile_code_time') < 30)
            {
                return 999;
            }
        }*/

        $apikey = "6152e179eb3e7018cc642ba82460303d"; //请用自己的apikey代替
         $mobile = "13686355607";
        $helper = new Helper();
        $random_code = $helper->mt_rand_str(6, '0123456789');
        $text='【最惠购】您的验证码是' . $random_code . '。有效期为5分钟，请尽快验证';
        echo send_sms($apikey,$text,$mobile);

/*
        $mobile = "13686355607";
        $yunpianSms = new YunPianSms();
        $helper = new Helper();
        $random_code = $helper->mt_rand_str(6, '0123456789');
        $response = $yunpianSms->sendMsg($mobile, '【最惠购】您的验证码是' . $random_code . '。有效期为5分钟，请尽快验证');
        //Log::error('Something is really going wrong.');
        $result = json_decode(json_encode($response))->data->code;
        if ($result == 0)
        {
            Session::put('mobile_code', md5($random_code . $mobile));
            Session::put('mobile_code_time', time());
        }
        return $result;
*/
    }

    public function cert()
    {
        $cert = Certification::where('user_id', '=', Auth::user()->id)->first();
        if($cert==null)
        {
            return view('auth/cert')->with('cert', $cert);
            exit();
        }

        //return Response::error(404);
        //return response()->download(base_path().$cert->identity_card_front);
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
                return view('pay.bidderpay', ['demand' => $demand, 'lastPrice' => $lastPrice,'showtitle'=> $showtitle,
                'step'=>$step ,'purl'=>$purl ])->withErrors('你没有支付保证金,请支付保证金！');
            }
            else
            {
                return Redirect::to('demand/list');
            }
        }
        else
            return view('auth/cert')->with('cert', $cert);
    }

    /**
     * 获取商家认证图片
     * @param $id
     * @param $type
     * @return mixed
     */
    public function getCertImg($id, $type)
    {
       // $cert = Certification::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $cert = Certification::where('user_id', '=', $id)->firstOrFail();
        switch ($type)
        {
            case 'icf':
                $path = base_path() . '/storage/certfiles/' . $cert->identity_card_front;
                break;
            case 'icb':
                $path = base_path() . '/storage/certfiles/' . $cert->identity_card_back;
                break;
            case 'bl':
                $path = base_path() . '/storage/certfiles/' . $cert->business_license;
                break;
        }
        if (file_exists($path))
        {
            return Response::inline($path);
        }
    }

    public function certPost()
    {
        $data = array();
        $path = date("Ym", time()) . '/' . date("d", time()) . '/' . Auth::user()->id;
        $cert = Certification::where('user_id', '=', Auth::user()->id)->first();
        if ($cert == null)
        {
            $cert = new Certification();
            $cert->user_id = Auth::user()->id;
        }

        if ($file = Input::file('identity_card_front'))
        {
            $extension = $file->getClientOriginalExtension() ? : 'png';
            $safeName = str_random(10) . '.' . $extension;
            $file->move(base_path() . '/storage/certfiles/' . $path, $safeName);
            $cert->identity_card_front = $path . '/' . $safeName;
            $data['msg'] = "身份证正面照片上传成功";
        }
        else if ($file = Input::file('identity_card_back'))
        {
            $extension = $file->getClientOriginalExtension() ? : 'png';
            $safeName = str_random(10) . '.' . $extension;
            $file->move(base_path() . '/storage/certfiles/' . $path, $safeName);
            $cert->identity_card_back = $path . '/' . $safeName;
            $data['msg'] = "身份证反面照片上传成功";
        }
        else if ($file = Input::file('business_license'))
        {
            $extension = $file->getClientOriginalExtension() ? : 'png';
            $safeName = str_random(10) . '.' . $extension;
            $file->move(base_path() . '/storage/certfiles/' . $path, $safeName);
            $cert->business_license = $path . '/' . $safeName;
            $data['msg'] = "营业执照上传成功";
        }
        else
        {
            $data['error'] = "上传失败";
        }
        $cert->save();
        return json_encode($data); //'{"files":[{"url":"https://jquery-file-upload.appspot.com/image%2Fpng/888465575/lm00.png","thumbnailUrl":"https://jquery-file-upload.appspot.com/image%2Fpng/888465575/lm00.png.80x80.png","name":"lm00.png","type":"image/png","size":17903,"deleteUrl":"https://jquery-file-upload.appspot.com/image%2Fpng/888465575/lm00.png","deleteType":"DELETE"}]}';
    }


}
