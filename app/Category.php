<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model {
  //  use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'slug'];
    public function posts()
    {
        return $this->hasMany('Post');
    }
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getbysql2array($conditions)
    {
        $cats=$this->whereRaw($conditions)->orderby('sort','asc',"id","desc")->get();//->toArray();

        $data=array();
        foreach($cats as $key=>$val)
        {
            $data[]=$val["id"];
        }

        return $data;


    }

    public function get_list($parent_id = -1, $shown = false)
    {
        $conditions = "1 = 1";
        $parent_id >= 0 && $conditions .= " AND parent_id = '$parent_id'";
      //  $shown && $conditions .= " AND if_show = 1";

        return $this->whereRaw($conditions)->orderby('sort','asc',"id","desc")->get()->toArray();
    }

    public function getbrand($pid)
    {
        $conditions=" 1=1 and levels=4  and parent_id=".$pid;;
        return $this->whereRaw($conditions)->orderby('sort','asc',"id","desc")->get()->toArray();

    }


    public function modicate($id,$catname)
    {

        $count = $this::where("slug", "=", $catname)->count();
        if ($count > 1) return false;

        $pinyin=\ZuiHuiGou\CUtf8_PY::encode($catname);
        $this::where('id', $id)
            ->update(array('slug' => $catname,'name'=>$pinyin));
        return true;
    }


    function InitClassSelectOption($ParentID, $ChkID)
    {
        $htmls = "";
        $cates = $this::select('slug', 'id', 'parent_id', 'levels')->where('parent_id', '=', $ParentID)->get();

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


    public function  addCategory($pid,$slug)
    {

        $level=0;
        $sortpath="0,";
        if($pid!=0)
        {
            $pcate=Category::find($pid);
            $level=$pcate->levels;
            $sortpath=$pcate->sortpath;
        }
        //找出父类别
        //找出当前的编号
        $count=Category::where("levels","=",($level+1) )->where('parent_id','=',$pid)->count();
        $pinyin = CUtf8_PY::encode($slug);
        $pinyin=str_replace("/","",$pinyin);
        $cate = new Category();
        $cate->parent_id = $pid;
        $cate->name = $pinyin;
        $cate->slug = $slug;
        $cate->sort = $count*2+1;
        $cate->levels = $level + 1;//1,2,3级是不允许有重复的

        if($cate->levels<4)
        {
            $coutcate=Category::where("slug",'=',$slug)->where("levels","<","4")->count();
            if($coutcate>0)
                return;
        }
        else
        {
            //在本级分类下不能出现两个相同的分类名称
            $coutcate = Category::where("slug", '=', $slug)
                ->where("levels", "=", "4")
                ->where('parent_id', '=', $pid)
                ->count();
            if($coutcate>0)
                return;
        }


        $cate->save();
        //$cate::where('id','=',$cateid)->update(['sortpath'=>$sortpath  .$cateid.","]);
        $cate->sortpath=$sortpath . $cate->id . ",";
        $cate->save();

    }



    //cid is old categoryid
    public function  eidtCategory($cid,$pid,$slug,$sort)
    {

        $level=0;
        $sortpath="0,";
        if($pid!=0)
        {
            $pcate=Category::find($pid);
            $level=$pcate->levels;
            $sortpath=$pcate->sortpath;
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
        //echo "the find id is:".$findid."<br />";
        if($findid) $cateid=$findid+1; //在当前的编号上加1
      //  echo "the cateid is:".$cateid."<br />";


        $pinyin = CUtf8_PY::encode($slug);



        $cate = new Category();
        $cate->id = $cateid;
        $cate->parent_id = $pid;
        $cate->name = $pinyin;
        $cate->slug = $slug;
        $cate->sort = $sort;
        $cate->levels = $level + 1;
        $cate->sortpath=$sortpath  .$cateid.",";
        $cate->save();


        $oldcate=Category::find($cid);


        $allcateneedmodify=Category::where("sortpath",'like',$oldcate->sortpath)->select();

        foreach($allcateneedmodify as $key=>$val)
        {
            $newsortpath=str_replace($val->oldpath, $cate->sortpath ,$val->sortpath );
            $val::update(['sortpath'=>$newsortpath]);
        }


    //    $uinfos=array(
     //       "sortpath"=>"replace(sortpath,'".$oldcate->sortpath."','".$cate->sortpath
    //            ."')"
    //    );
    //    $cate::where("sortpath",'like',$oldcate->sortpath)->update($uinfos);



      //   DB::statement("update categories set sortpath=replace(sortpath,'".$oldcate->sortpath."','".$cate->sortpath
      //      ."') where sortpath like '".$oldcate->sortpath."'");
     //   $cate::statement("update categories set sortpath=");
     //   $cate::where("sortpath",'like','%,'.$cid.',%')->update($uinfos);
        $cate::where("id",'=',$cid)->delete();

    }






}
