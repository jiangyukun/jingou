<?php namespace ZuiHuiGou\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;
use ZuiHuiGou\Address;
use ZuiHuiGou\Bid;
use ZuiHuiGou\Brand;
use ZuiHuiGou\Category;
use ZuiHuiGou\Certification;
use ZuiHuiGou\delivery;
use ZuiHuiGou\Demand;
use ZuiHuiGou\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use ZuiHuiGou\Http\Controllers\DemandController;
use ZuiHuiGou\Setting;
use ZuiHuiGou\User;
use ZuiHuiGou\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function setting()
    {
        if (Auth::user()->hasRole("admin"))
        {
            $set1=DB::select("select * from settings where types=2 order by sorts asc ");

            $setts = DB::select('select * from settings where types=1 order by sorts asc');
            return view('admin.setting')->with(
              array(  'setts'=>$setts,
              'set1'=>$set1)
            );
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('您不是管理员，无法进行此操作。');
    }

    public function user(Request $request,  $id)
    {
        header("Content-Type:text/html;charset=utf-8");
        if (Auth::user()->hasRole("admin"))
        {
            $user = User::find($id);

            if($request->method()=="POST")
            {
                $user = User::find($id);
                $user->username = $request->get('username');
                $user->mobile = $request->get('mobile');
                if ($request->get('password') != "") $user->password = Hash::make($request->get('password'));
                $user->save();
                return redirect()->back()
                    ->withErrors('修改成功!');
            }


            $cert=array();
            if($user->hasRole('bidder'))
            {
                //商家
                $cert=Certification::where('user_id','=',$user->id)->get()->first();
                // var_dump($cert);
            }
            return view('admin.user')->with(
                array('user' => $user,
                    'cert' => $cert));
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('您不是管理员，无法进行此操作。');
    }


    public function certPost(Request $request, $id = 0)
    {
        if ($id == 0)
        {
            $data['error'] = "上传失败";
            return json_encode($data);
        }

        $data = array();
        $path = date("Ym", time()) . '/' . date("d", time()) . '/' .  $id;
        $cert = Certification::where('user_id', '=',  $id)->first();

        if ($cert == null)
        {
            $cert = new Certification();
            $cert->user_id = $id;
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

    public function index()
    {
        if (Auth::user()->hasRole("admin"))
        {
            $users = User::all();
            $demands = Demand::all();
            $bids = Bid::all();
            $counts['user'] = count($users);
            $counts['demand'] = count($demands);
            $counts['bid'] = count($bids);
            return view('admin.index')->with('counts', $counts);
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('您不是管理员，无法进行此操作。');
    }



    public  function  bidders()
    {
        if (Auth::user()->hasRole("admin"))
        {
            $roles=  DB::select('select * from role_user where role_id =3' );

            $userids="";
            foreach($roles as $k)
            {
                $userids.=$k->user_id.",";
            }
            $userids=substr($userids,0,-1);

            $users = User::whereRaw("id in ($userids)" )->orderBy('id', 'desc')->get();
            return view('admin.bidders')->with('users', $users);
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('您不是管理员，无法进行此操作。');
    }

    public function  biddersaudit(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
        $audit=$request->get('audit');
        $items=$request->get('itemid');
        $itemids=implode(",",$items);

        //echo "user_id in($itemids)";
        $res = Certification::whereRaw("user_id in($itemids)")->update(array('is_identity' => 1, 'is_license' => 1));
        User::whereRaw("id in ($itemids)")->update( array("valid"=>1));
        //->get();
        //var_dump($res);


        return Redirect::to('admin/bidders')
            ->withErrors("成功审核通过" . $res . "供应商！");
    }

    public function  certs()
    {
        if (Auth::user()->hasRole("admin"))
        {
            $roles=  DB::select('select * from role_user where role_id =3' );

            $userids="";
            foreach($roles as $k)
            {
                $userids.=$k->user_id.",";
            }
            $userids=substr($userids,0,-1);

            $users = User::whereRaw("id in ($userids)" )->orderBy('id', 'desc')->get();
            return view('admin.users')->with('users', $users);
        }
        else
            return redirect()->back()
                ->withInput()
                ->withErrors('您不是管理员，无法进行此操作。');
    }

    public function saveset(Request $request)
    {
        var_dump(Input::all());
        $vars=Input::all();
        foreach($vars as $key=>$val)
        {

            $sql="update settings set set_value='$val' where set_key='$key' ";
            DB::statement($sql);

        }
        return Redirect::to('admin/setting')->withErrors('设置保存完成');
    }

    public function save($id)
    {
        $setting = Setting::find($id);
        $setting->update(Input::all());
        $resolved_content = Markdown::parse(Input::get('content'));
        $setting->resolved_content = $resolved_content;
        $setting->save($id);
    }


    function InitClassSelectOption($ParentID, $ChkID)
    {
        $htmls = "";
        $cates = DB::table('categories')->select('slug', 'id', 'parent_id', 'levels')->where('parent_id', '=', $ParentID)->get();

        //$r = $db->fetch_array($result);
        //var_dump($r);
        foreach ($cates as $r)
        {
            $htmls .= "<option  value=" . $r->id;
            if ($ChkID == $r->id) $htmls .= " selected='selected' ";
            $htmls .= ">";

            for ($i = 0; $i < $r->levels; $i++)
            {
                $htmls .= "&nbsp;&nbsp;&nbsp;&nbsp;";
            }

            $htmls .= "├-" . $r->slug . " </option>";

            $htmls .= $this->InitClassSelectOption($r->id, $ChkID);

        }

        return $htmls;
    }


    public function demandManage(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
        if($request->method()=="POST")
        {
          //  print_r(Input::all());

            $action=$request->input("act");
            if($action=="edit_username")
            {
                try
                {
                    //{error: 0, message: "", content: "高质感毛呢大衣111222"}
                    $deid = $request->input("id");
                    $demand = Demand::find($deid);
                    $user = User::find($demand->user_id);
                    $user->username = $request->input("val");
                    $user->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $user->username;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
                return ;
            }
            if($action=="edit_title")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = Demand::find($deid);
                    $demand->title=urldecode( $request->input("val"));
                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->title;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if($action=="edit_comment")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = Demand::find($deid);
                    $demand->comment=urldecode( $request->input("val"));
                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->comment;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if ($action == "edit_address")
            {
                try
                {
                    $adid = $request->input("id");
                    $address = Address::find($adid);
                    $address->fulladdr=urldecode( $request->input("val"));
                    $address->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $address->fulladdr;
                    echo json_encode($mess);
                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] = $e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if($action=="choosewin")
            {
                try
                {
                    $bid = $request->input("bid");
                    $bid=Bid::find($bid);
                    $bid::where('demand_id', $bid->demand_id)->update(array('is_win' => 0));

                    $bid->is_win=1;
                    $bid->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = "";
                    echo json_encode($mess);
                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] = $e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }


            if($action=="edit_model")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = Demand::find($deid);
                    $demand->model=urldecode( $request->input("val"));
                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->model;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if($action=="edit_price")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = Demand::find($deid);
                    $demand->price=urldecode( $request->input("val"));
                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->price;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if($action=="edit_delistatus")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = delivery::find($deid);
                    $demand->status=urldecode( $request->input("val"));
                    if ($demand->status != "")
                    {
                        $demand->save();

                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "修改成功";
                        $mess['content'] = $demand->status;
                        echo json_encode($mess);
                    }
                    else
                    {
                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "传值为空";
                        $mess['content'] = $demand->status;
                        echo json_encode($mess);
                    }



                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }
            }

            if($action=="edit_delinumber")
            {

                try
                {
                    $deid = $request->input("id");
                    $demand = delivery::find($deid);
                    $demand->numbers=urldecode( $request->input("val"));
                    if ($demand->numbers != "")
                    {
                        $demand->save();

                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "修改成功";
                        $mess['content'] = $demand->numbers;
                        echo json_encode($mess);
                    }
                    else
                    {
                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "传值为空";
                        $mess['content'] = $demand->numbers;
                        echo json_encode($mess);
                    }



                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }

            }

            if($action=="edit_delimobile")
            {
                try
                {
                    $deid = $request->input("id");
                    $demand = delivery::find($deid);
                    $demand->mobile=urldecode( $request->input("val"));
                    if ($demand->mobile != "")
                    {
                        $demand->save();

                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "修改成功";
                        $mess['content'] = $demand->mobile;
                        echo json_encode($mess);
                    }
                    else
                    {
                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "传值为空";
                        $mess['content'] = $demand->mobile;
                        echo json_encode($mess);
                    }



                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }

            }


            if($action=="edit_delisemobile")
            {

                try
                {
                    $deid = $request->input("id");
                    $demand = delivery::find($deid);
                    $demand->sendmobile=urldecode( $request->input("val"));
                    if ($demand->mobile != "")
                    {
                        $demand->save();

                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "修改成功";
                        $mess['content'] = $demand->sendmobile;
                        echo json_encode($mess);
                    }
                    else
                    {
                        $mess = array();
                        $mess['error'] = 0;
                        $mess['message'] = "传值为空";
                        $mess['content'] = $demand->sendmobile;
                        echo json_encode($mess);
                    }



                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }

            }

            if($action=="is_pay")
            {

                try
                {
                    $deid = $request->input("deid");
                    $demand = Demand::find($deid);
                    $demand->is_pay=urldecode( $request->input("val"));
                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->is_pay;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }

            }

            if($action=="is_payd")
            {
                try
                {
                    $deid = $request->input("deid");
                    $demand = Demand::find($deid);
                    $tval=urldecode( $request->input("val"));

                    if ($demand->is_pay <= 0 && $tval < 0)
                        $demand->is_pay += $tval;
                    else
                        $demand->is_pay = $tval;


                    $demand->save();

                    $mess = array();
                    $mess['error'] = 0;
                    $mess['message'] = "修改成功";
                    $mess['content'] = $demand->is_pay;
                    echo json_encode($mess);

                } catch (Exception $e)
                {
                    $mess = array();
                    $mess['error'] = $e->getCode();
                    $mess['message'] =$e->getMessage();
                    $mess['content'] = "message";
                    echo json_encode($mess);
                    exit();
                }

            }


            if($action=="savecate")
            {




                try
                {
                    $deid = $request->input("deid");
                    $demand = Demand::find($deid);
                    $cat1=$request->input("cat1");
                    $cat2=$request->input("cat2");
                    $cat3=$request->input("cat3");
                    $bid=$request->input("bname");


                    $demand->cat1=$cat1;
                    $demand->cat2=$cat2;
                    $demand->cat3=$cat3;
                    $demand->category_id=$cat3;//最终分类等于第三级分类
                    $demand->bid=$bid;
                    $demand->save();
                    echo  "修改成功";


                } catch (Exception $e)
                {
                    echo "出错了".$e->getMessage();
                }
            }

            exit();
        }




        $catetree=$this->InitClassSelectOption(0,1 );


        $cat1=Category::where("parent_id",'=',0)->orderBy('sort',' asc')->get();
        $cat2=Category::where("levels",'=',2)->orderBy('sort','asc')->get();
        $cat3=Category::where("levels",'=',3)->orderBy('sort','asc')->get();

       // $brands=Brand::orderBy("id","desc")->get();
        $brands= Category::where("levels",'=',4)->orderBy('sort','asc')->get();


        $start=$request->input("start");
        $end=$request->input("end");
        $condition="1=1";
        if($start && $end)
        {
            $condition.=" and demands.created_at between '$start' and '$end' ";
        }

        $cateid=$request->input("cate");
        if($cateid)
        {
            $condition.=" and ( cat1=$cateid or cat2=$cateid or cat3=$cateid or category_id= $cateid)  "  ;
        }

        if ($request->has('status'))
        {
            $condition .=" and status in(" .  $request->input("status") .")";
        }
        if ($request->has('is_pay'))   //支付的条件
        {
            $condition .=" and is_pay=" . intval( $request->input("is_pay"));
        }
        if ($request->has('exp'))
        {
            if($request->input("exp")==1)  //竞购过期了
                $condition .=" and expire_time<CURRENT_TIMESTAMP() ";
            else                            //竞购未过期
                $condition .=" and expire_time>CURRENT_TIMESTAMP() ";
        }


        // if($request->input("is_pay")) $condition .=" and is_pay=" . intval( $request->input("is_pay"));
        if($request->input("exp")==1) $condition .=" and expire_time <'".date("Y-m-d H:i:s")."' ";


        $sinfo=$request->input("sinfo");
        if($sinfo)
        {
            $condition.=" and ( username like '%$sinfo%') or (mobile like '%$sinfo%') or (title like '%$sinfo%') or (sn like '%$sinfo%' ) ";
        }

        //   echo "condition=$condition <br />";
        $demands = Demand::leftjoin('users', 'users.id', '=', 'demands.user_id')
            ->select("demands.*","users.id as uid","users.username as uname ",'users.alipay as alipay')
            ->whereRaw($condition)
            ->orderBy("demands.id","desc")->paginate(10);


        $branddata=array();
        foreach($demands as $onedemand)
        {
            $branddata["a".$onedemand->id] = Category::where("levels", '=', 4)
            ->where("parent_id", '=',$onedemand->category_id )
            ->orderBy('sort', 'asc')->get()->toarray();
        }

        $data=array(
            'demands'=> $demands,
            'catetree'=>$catetree,
            'cat1'=>$cat1,
            'cat2'=>$cat2,
            'cat3'=>$cat3,
            'brands'=>$brands,
            'demandbrand'=>$branddata
        );

       //var_dump($branddata);
 //var_dump($branddata["a"."43"]);
    //     exit();
        return view('admin.demands')->with($data);
    }

    public function gettime($start)
    {
        $start=str_replace("年","/",$start);
        $start=str_replace("月","/",$start);
        $start=str_replace("日","/",$start);
        return strtotime($start);
    }

    public function userManage()
    {
        $users = User::all();
        return view('admin.users')->with('users', $users);

    }

    public function bidManage()
    {
        $bids = Bid::all();
        return view('admin.bids')->with('bids', $bids);

    }
    public function editBid($id)
    {
        $bid=Bid::findOrFail($id);
        $data=array(
            'bid'=>$bid
        );
        return view('admin.editbit')->with($data);
    }

    public function delcate($id)
    {
        try
        {
            $catenum = Category::where('id','=',$id)->count();
            if($catenum==0)
            {
                return redirect()->back()
                    ->withErrors('分类不存在!');
                exit();
            }


            $onecate = Category::findOrFail($id);
            if($onecate!=null)
            {
                $onecate->delete();
                $onecate::whereRaw("sortpath like '%,".$id.",%'  ")->delete();

            }

        } catch (ModelNotFoundException $e)
        {
            return Redirect::to('/')
                ->withInput()
                ->withErrors('分类不存在!');
        }

        return   Redirect::to("/admin/cate?id=".rand(0,100));
    }


    //批量删除分类
    public function deletecate(Request $request )
    {
        if($request->method()=="POST")
        {
            //  $catids=implode(",",$request->input("catids"));
            $res=Category::whereIn( 'id', $request->input("catids") )->delete();
            if($res>0)
                return redirect()->back()
                    ->withErrors('共删除'.$res.'条记录。');
        }

    }


    public function sortcate(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
        print_r(Input::all());
        $category=$request->input("category");
        if (!is_array($category)) return false;
        foreach ($category as $k => $v)
        {
            if (!$v['slug']) continue;
            $v['parent_id'] = intval($v['parent_id']);
            //   $v['listorder'] = intval($v['listorder']);
            $v['sort'] = intval($v['sort']);
            DB::table('categories')
                ->where('id', $k)
                ->update(array(
                    'sort' => $v['sort'],
                    'parent_id'=> $v['parent_id'],
                    'slug'=>$v['slug'],
                    'sort'=>$v['sort']
                ));
        }

        return redirect()->back()
            ->withErrors('保存分类成功。');
    }

    public function atest($id=14)
    {

        $cate=new Category();
        echo $cate->InitClassSelectOption(0,0);exit();

        echo CUtf8_PY::encode("家用电器");


        exit();

        $demand=Demand::findOrFail($id);
        $cattree=$this->InitClassSelectOption(0,$demand->category_id);
        $cates=Category::where('parent_id','=',0)->orderby('id','desc')->get();
        $user=User::whereRaw('id='.$demand->user_id)->get()->first();

        $dc = new DemandController();
        $bidinfo = $bidinfo = $dc->getbidinfo($demand);
        $deli=delivery::whereRaw('deid='.$demand->id)->get()->first();

        $data=array(
            'demand'=>$demand,
            'cates'=>$cates,
            'user'=>$user,
            'bids'=>$bidinfo['bids'],
            'bidinfo'=>$bidinfo,
            'deli'=>$deli,
            'catetree'=>$cattree


        );

        return view("admin.edemand1")->with($data);
    }


    private function add($pid,$slug,$sort,$sortpath)
    {

        $level=0;
        if($pid!=0)
        {
            $pcate=Category::find($pid);
            $level=$pcate->levels;
        }
        //找出父类别

        if($level==0) $cateid=10;
        if($level==1) $cateid=$pid*100;//第二级
        if($level==2) $cateid=$pid*1000;//第三级
        if($level==3) $cateid=$pid*1000;//第三级

        //找出当前的编号
        $findid=Category::where("levels","=",($level+1) )
            ->where("id",">=",$cateid)
            ->max("id");
        echo "the find id is:".$findid."<br />";
        if($findid) $cateid=$findid+1; //在当前的编号上加1
        echo "the cateid is:".$cateid."<br />";


        $pinyin = CUtf8_PY::encode($slug);

        $tpcate = Category::where("slug", "=", $slug)->count();
        if ($tpcate >= 1)  return;

        $cate = new Category();
        $cate->id = $cateid;
        $cate->parent_id = $pid;
        $cate->name = $pinyin;
        $cate->slug = $slug;
        $cate->sort = $sort;
        $cate->levels = $level + 1;
        $cate->sortpath=$sortpath  .$cateid.",";
        $cate->save();
    }

    public function addcate(Request $request,$id=0)
    {
        header("Content-Type:text/html;charset=utf-8");
        // echo $request->method()."<br/>";
        if ($request->method() == "POST")
        {
            $pid = $request->input("pid",0);
            $slugs = $request->input("slug");
            $i_slugs = trim($slugs);

            $catemode = new Category();
            if (strpos($i_slugs, "\n") === false)
            {
                $catemode->addCategory($pid, $i_slugs);
            }
            else
            {

                $names = explode("\n", $i_slugs);
                foreach ($names as $bname)
                {
                    $bname = trim($bname);
                    if(empty($bname)) continue;
                    $tpcate = Category::where("slug", "=", $bname)->count();
                    if ($tpcate >= 1) continue; //分类存在时跳过继续添加分类
                    $catemode->addCategory($pid,$bname );
                }
            }
            return Redirect::to('admin/cate');

        }
        else
        {
            if ($id != 0)
            {
                $tcate = Category::where('id', '=', $id)->orderBy('id', 'desc')->get()->first();
                if($tcate==null)
                {

                    echo "未找到分类";
                    exit();
                }
                $pcate = Category::where('parent_id', '=',$tcate->parent_id)->get();
            }
            else
            {
                $pcate = Category::where('parent_id', '=', 0)->get();
            }
            $data=array("cates"=>$pcate,'sid'=>$id);
            return view("admin.addcate",$data);
        }

    }

    public function editcate(Request $request,$id)
    {
        header("Content-Type:text/html;charset=utf-8");

        if($request->method()=="POST")
        {

            $oldid = $request->input("oldid");
            $pid = $request->input("pid");
            $slug = $request->input("slug");
            $sort = $request->input("sorts");

            $onecate = new Category();
            $onecate->eidtCategory($oldid, $pid, $slug, $sort);

            return Redirect::to("/admin/cate")
                ->withErrors('保存成功。');
        }
        else
        {

            $onecate = Category::where("id", '=', $id)->get()->first();
            if ($onecate == null)
            {
                return redirect()->back()
                    ->withErrors('没有找到相关分类');
            }
            $pcate = Category::where('parent_id', '=', $onecate->parent_id)->get();

            $htmls=$onecate->InitClassSelectOption(0,$onecate->parent_id );


            $data = array(
                "cates" => $pcate,
                'ecate' => $onecate,
                'sid' => $onecate->parent_id,
                'htmls'=>$htmls
            );


            return view("admin.editcate", $data);
        }
    }

    public function cate(Request $request,  $id=0)
    {
        header("Expires:-1");
        header("Cache-Control:no-cache");
        header("Pragma:no-cache");
        header("Content-Type:text/html;charset=utf-8");
        if($request->method()=="POST")
        {
            if($request->input("action")=="delete")
            {
                $ids=implode(",",$request->input("catids"));
                Category::whereRaw("id in ($ids)")->delete();
                return redirect()->back()
                    ->withInput()
                    ->withErrors('删除成功。');
            }

        }

        if($request->method()=="GET")
        {
            $cates=Category::whereRaw("parent_id=$id")->orderBy('sort','asc',"id","desc")
                ->select('id as switchs','id','name','slug','sort' ,'sortpath' )->get();
            $data=array('cates'=> $cates,"sid"=>$id);
            return view('admin.cates',$data);
        }

    }


    //保存订单
    public function sdemand(Request $request, $id)
    {
        if($request->method()=="POST")
        {
            $demmand=Demand::findOrFail($id);
            if ($request->input("user_id"))  $demmand->user_id=$request->input("user_id");
            if ($request->input("details"))  $demmand->details=$request->input("details");
            if ($request->input("title")) $demmand->title=$request->input("title");
            if ($request->input("url"))  $demmand->url=$request->input("url");
            $demmand->category_id=$request->input("category_id");
            $demmand->model=$request->input("model");
            $demmand->bid=$request->input("bid");
            $demmand->price=$request->input("price");
            $demmand->deposit=$request->input("deposit");
            //  $demmand->is_pay=$request->input("is_pay");
            // $demmand->thumb=$request->input("thumb");
            $demmand->amount=$request->input("amount");
            $demmand->expire_time=$request->input("expire_time");
            if ($request->input("view_count")) $demmand->view_count=$request->input("view_count");
            // $demmand->paytime=$request->input("paytime");
            $demmand->addtime=$request->input("addtime");
            //    $demmand->status=$request->input("status");

            if ($request->input("is_hot")) $demmand->is_hot=$request->input("is_hot");
            if ($request->input("is_top")) $demmand->is_top=$request->input("is_top");
            if ($request->input("is_recommend")) $demmand->is_recommend = $request->input("is_recommend");

            $demmand->avltime=$request->input("avltime");
            $demmand->save();
            return redirect()->back()
                ->withInput()
                ->withErrors('保存成功。');

        }

    }

    //保存竞价
    public function savebid(Request $request, $id)
    {

        try
        {
            $bid = Bid::findOrFail($id);
            //  if ($request->input("id"))  $bid->id=$request->input("id");
            if ($request->input("sn"))  $bid->sn=$request->input("sn");
            if ($request->input("user_id"))  $bid->user_id=$request->input("user_id");
            if ($request->input("demand_id"))  $bid->demand_id=$request->input("demand_id");
            if ($request->input("details"))  $bid->details=$request->input("details");
            if ($request->input("price"))  $bid->price=$request->input("price");
            if ($request->input("url"))  $bid->url=$request->input("url");
            if ($request->input("is_win"))  $bid->is_win=$request->input("is_win");

            // if ($request->input("transport_fee"))  $bid->transport_fee=$request->input("transport_fee");
            //   if ($request->input(""))  $bid->area_id=$request->input("");
            //    if ($request->input(""))  $bid->status=$request->input("");
            //  if ($request->input("ip"))  $bid->ip=$request->input("ip");
            //  if ($request->input(""))  $bid->created_at=$request->input("");
            //  if ($request->input(""))  $bid->updated_at=$request->input("");
            //    if ($request->input(""))  $bid->deleted_at=$request->input("");




            $bid->save();


        } catch (ModelNotFoundException $e)
        {
            return Redirect::back()
                ->withInput()
                ->withErrors('竞价信息不存在或已被删除！');
        }


        return redirect()->back()
            ->withInput()
            ->withErrors('保存竞价成功!');
    }

    //保存物流
    public function savedeli(Request $request,$id)
    {
        if($request->method()=="POST")
        {
            $deli=delivery::where("deid","=",$id)->get()->first();
            if($deli)
            {

                if ($request->input("uid")) $deli->uid = $request->input("uid");
                if ($request->input("types")) $deli->types = $request->input("types");
                if ($request->input("address")) $deli->address = $request->input("address");
                if ($request->input("numbers")) $deli->numbers = $request->input("numbers");
                if ($request->input("notes")) $deli->notes = $request->input("notes");
                if ($request->input("status")) $deli->status = $request->input("status");
                if ($request->input("mobile")) $deli->mobile = $request->input("mobile");
                $deli->save();
                return redirect()->back()
                    ->withInput()
                    ->withErrors('相关物流信息保存成功。');

            }
            else
            {
                return redirect()->back()
                    ->withInput()
                    ->withErrors('没有找到相关订单。');
            }

        }

    }


//编辑竞价
    public function editDemand($id)
    {
        $demand=Demand::findOrFail($id);
        $cattree=$this->InitClassSelectOption(0,$demand->category_id);

        $cates=Category::where('parent_id','=',0)->orderby('id','desc')->get();
        $user=User::whereRaw('id='.$demand->user_id)->get()->first();


        $brands=Brand::where("cateid",'=',$demand->category_id)->orderBy('id','desc')->get();
        //  var_dump($brands);exit();



        $dc = new DemandController();
        $bidinfo = $bidinfo = $dc->getbidinfo($demand);

        $deli=delivery::whereRaw('deid='.$demand->id)->get()->first();



        $data=array(
            'demand'=>$demand,
            'cates'=>$cates,
            'user'=>$user,
            'bids'=>$bidinfo['bids'],
            'bidinfo'=>$bidinfo,
            'deli'=>$deli,
            'catetree'=>$cattree,
            'brands'=>$brands,

        );

        return view("admin.edemand")->with($data);
    }


    public function brand(Request $request)
    {
        if ($request->method() == "POST")
        {
            $brandname = $request->input("brandname");
            $catid = intval($request->input("cateid"));
            if (!$brandname) echo "品牌名称不能为空";
            $brandname = trim($brandname);
            if (strpos($brandname, "\n") === false)
            {

                $abrand = new Brand();
                $abrand->bname = $brandname;
                $abrand->cateid = $catid;
                $abrand->save();

            }
            else
            {
                $names = explode("\n", $brandname);
                foreach ($names as $bname)
                {
                    $bname = trim($bname);
                    if (!$bname) continue;
                    $abrand = new Brand();
                    $abrand->bname = $bname;
                    $abrand->cateid = $catid;
                    $abrand->save();


                }
            }
            return redirect()->back()
                ->withErrors('添加品牌成功。');
        }

        $brands=Brand::whereRaw('1=1')->orderBy('id','desc')->get();
        $catree=$this->InitClassSelectOption(0,0);

        $data=array(
            'brands'=>$brands,
            'catetree'=>$catree
        );
        return view("admin.brand")->with($data);
    }

    //竞价相关出价
    public function Demandbid($id)
    {
        $bids=Bid::whereRaw("demand_id=$id")->orderBy('id','desc')->get();
        return view("admin.debids")->with("bids",$bids);
    }


    public function delDemand($id)
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
        $demand->delete();
        return Redirect::back()
            ->withInput()
            ->withErrors('删除成功！');
    }

    public function delUser($id)
    {
        if ($id == 1)
            return Redirect::back()
                ->withInput()
                ->withErrors('不能删除管理员！');
        try
        {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::back()
                ->withInput()
                ->withErrors('用户不存在或已被删除！');
        }
        $user->delete();
        return Redirect::back()
            ->withInput()
            ->withErrors('删除成功！');
    }

    public function delBid($id)
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
        return Redirect::back()
            ->withInput()
            ->withErrors('删除成功！');
    }
}
