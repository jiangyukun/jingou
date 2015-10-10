@extends('admin.master')
@section('title')
首页 @parent
@endsection
@section('content')


<form role="form" action="" method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="table">
        <tbody>
           <input  name="oldid"  type="hidden"  value="{{$ecate->id}}"  />
        <tr>
            <td class="tl"> 上级分类</td>
            <td><input name="category[parentid]" id="catid_1" type="hidden" value="0">
                <span id="load_category_1">
                    <select name="pid" onchange="load_category(this.value, 1);">
                        <option value="0">请选择</option>
                     <? echo $htmls;?>
                    </select> </span>
            </td>
        </tr>
        <tr>
            <td class="tl">分类名称</td>
            <td><textarea name="slug" id="catname" style="width:200px;height:100px;">{{$ecate->slug}}</textarea>
                <span  id="dcatname"  >允许批量添加，一行一个，点回车换行</span></td>
        </tr>
        <tr>
            <td class="tl">排序</td>
            <td><input type="text" name="sorts" id="catname"  value="{{$ecate->sort}}" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"   >
                <button type="submit" class="btn btn-primary">保存修改</button>
                <button type="button" class="btn btn-default" onclick="javascript:history.back();">返回</button>
            </td>
        </tr>

        </tbody>
    </table>

    <script>
        var DMURL = document.location.protocol+'//'+location.hostname+(location.port ? ':'+location.port : '')+'/';
        if(DTPath.indexOf(DMURL) != -1) DMURL = DTPath;
        var AJPath = DMURL+'ajax.php';
        var cat_id;
        function load_category(catid, id) {
            cat_id = id; category_catid[id] = catid;
            $.post(AJPath, 'action=category&category_title='+category_title[id]
                +'&category_moduleid='+category_moduleid[id]
                +'&category_extend='+category_extend[id]
                +'&category_deep='+category_deep[id]+'&cat_id='+cat_id+'&catid='+catid, function(data) {
                $('#catid_'+cat_id).val(category_catid[cat_id]);
                if(data) $('#load_category_'+cat_id).html(data);
            });
        }
    </script>

</form>
@endsection