<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-7-30
 * Time: 上午9:56
 */

namespace ZuiHuiGou\Http\Controllers;


use Illuminate\Http\Request;
use ZuiHuiGou\Area;
use ZuiHuiGou\Brand;
use ZuiHuiGou\Category;
use ZuiHuiGou\Demand;

define('MAX_LAYER', 4);
class ajaxController extends Controller
{

    public function index()
    {
        echo "hello world";
    }


    public function category(Request $request)
    {
        $cate=Category::select("id",'slug')->where("parent_id",'=',$request->input('cateid'))->orderBy('id','desc')->get();
        return json_encode($cate);
    }
    public function area(Request $request)
    {
        $area=Area::select("id","areaname")->where("parent_id",'=',$request->input('areaid'))->get();
        ;
        return json_encode($area);

    }

    public function ajax_col(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
        $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $column = empty($_GET['column']) ? '' : trim($_GET['column']);
        $value  = isset($_GET['value']) ? trim(urldecode($_GET['value'])) : '';


        if (in_array($column ,array('cate_name', 'sort_order')))
        {
            $data[$column] = $value;
            if($column == 'cate_name')
            {
                $acategory=new Category();
                $res=$acategory->modicate($id,$value);
                if($res) return json_encode(true);
            }
        }
        else
        {
            return ;
        }
        return ;

    }


    public function brand(Request $request)
    {
        $brand=Brand::select("id",'bname')->where("cateid",'=',$request->input('cateid'))->orderBy('id','desc')->get();
        return json_encode($brand);
    }




    public function  ajax_cate(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");
        if(!isset($_GET['id']) || empty($_GET['id']))
        {
            echo $this->ecm_json_encode(false);
            return;
        }

        //  var_dump($_GET);exit();
        $catemodel=new Category();
        $cate = $catemodel->get_list($_GET['id']);

        //   var_dump($cate);exit();
        foreach ($cate as $key => $val)
        {
            $child = $catemodel->get_list($val['id']);
            $lay =  $val['levels'];
            if ($lay >= MAX_LAYER)
            {
                $cate[$key]['add_child'] = 0;
            }
            else
            {
                $cate[$key]['add_child'] = 1;
            }
            /*  if ($val['levels']>=4 )
              {
                  $cate[$key]['switchs'] = 0;
              }
              else
              {*/
            $cate[$key]['switchs'] = 1;
            //  }
            $cate[$key]['cate_name'] =$val['slug'];;
            $cate[$key]['parent_id'] =$val['parent_id'];;
            $cate[$key]['if_show'] =1;
            $cate[$key]['sort_order']= $val['sort'];
            $cate[$key]['cate_id']= $val['id'];
            $cate[$key]['sortpath']= $val['sortpath'];
            // $cate[$key]['switchs']= $val['sort'];

        }

        echo $this->ecm_json_encode(array_values($cate));
        return ;

    }

    function  ajax_brand()
    {
        header("Content-Type:text/html;charset=utf-8");
        if(!isset($_GET['id']) || empty($_GET['id']))
        {
            echo $this->ecm_json_encode(false);
            return;
        }
        $id=$_GET['id'];
        $id=intval($id);

        //  var_dump($_GET);exit();
        $catemodel=new Category();
        $cate = $catemodel->getbrand($id);

        //   var_dump($cate);exit();

        $data=array();
        foreach ($cate as $key => $val)
        {
            $onedata=array();
            $onedata['cate_name'] =$val['slug'];
            $onedata['cate_id']= $val['id'];
            $data[]=$onedata;
        }

        echo $this->ecm_json_encode(array_values($data));
        return ;
    }


    function ecm_json_encode($value)
    {
        if ( function_exists('json_encode'))
        {
            return json_encode($value);
        }

        $props = '';
        if (is_object($value))
        {
            foreach (get_object_vars($value) as $name => $propValue)
            {
                if (isset($propValue))
                {
                    $props .= $props ? ','.$this->ecm_json_encode($name)  : $this->ecm_json_encode($name);
                    $props .= ':' . $this->ecm_json_encode($propValue);
                }
            }
            return '{' . $props . '}';
        }
        elseif (is_array($value))
        {
            $keys = array_keys($value);
            if (!empty($value) && !empty($value) && ($keys[0] != '0' || $keys != range(0, count($value)-1)))
            {
                foreach ($value as $key => $val)
                {
                    $key = (string) $key;
                    $props .= $props ? ','.$this->ecm_json_encode($key)  : $this->ecm_json_encode($key);
                    $props .= ':' . $this->ecm_json_encode($val);
                }
                return '{' . $props . '}';
            }
            else
            {
                $length = count($value);
                for ($i = 0; $i < $length; $i++)
                {
                    $props .= ($props != '') ? ','.$this->ecm_json_encode($value[$i])  : $this->ecm_json_encode($value[$i]);
                }
                return '[' . $props . ']';
            }
        }
        elseif (is_string($value))
        {
            //$value = stripslashes($value);
            $replace  = array('\\' => '\\\\', "\n" => '\n', "\t" => '\t', '/' => '\/',
                "\r" => '\r', "\b" => '\b', "\f" => '\f',
                '"' => '\"', chr(0x08) => '\b', chr(0x0C) => '\f'
            );
            $value  = strtr($value, $replace);
            if (CHARSET == 'big5' && $value{strlen($value)-1} == '\\')
            {
                $value  = substr($value,0,strlen($value)-1);
            }
            return '"' . $value . '"';
        }
        elseif (is_numeric($value))
        {
            return $value;
        }
        elseif (is_bool($value))
        {
            return $value ? 'true' : 'false';
        }
        elseif (empty($value))
        {
            return '""';
        }
        else
        {
            return $value;
        }
    }

    function ecm_json_decode($value, $type = 0)
    {
        if (CHARSET == 'utf-8' && function_exists('json_decode'))
        {
            return empty($type) ? json_decode($value) : get_object_vars_deep(json_decode($value));
        }

        if (!class_exists('JSON'))
        {
            import('json.lib');
        }
        $json = new JSON();
        return $json->decode($value, $type);
    }



    public function ajax_demand(Request $request)
    {
        header("Content-Type:text/html;charset=utf-8");


        if(!isset($_GET['id']) || empty($_GET['id']))
        {
            echo $this->ecm_json_encode(false);
            return;
        }

        $id = $_GET['id'];
        $bids= isset($_GET['bid']) ? $_GET['bid'] : '';
        $key= isset($_GET['key']) ? $_GET['key'] : '';

        $demandmode = new Demand();
        $demands = $demandmode->getDemands($id,$bids,$key);//取得当前正在进行的竞购

        $data = array();
        foreach ($demands as $key => $val)
        {
            $onedata = array();
            $onedata['sn'] = $val['sn'];
            $onedata['id'] = $val['id'];
            $onedata['title'] = $val['title'];
            $onedata['price'] = $val['price'];
            $onedata['paytime'] = $val['paytime'];
            $onedata['thumb'] = $val['thumb'];
            $onedata['url'] = $val['url'];


            $onede=Demand::find($val['id']);
            $onedata['exptime'] =$onede->getexptime(); //当前竞购的状态
            $onedata['bidnum'] =count($onede->bids);
            $data[] = $onedata;
        }
        echo $this->ecm_json_encode(array_values($data));
        return;

    }


}