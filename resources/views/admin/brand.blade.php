@extends('admin.master')
@section('title')
首页 @parent
@endsection
@section('content')

<h3>添加品牌</h3>
<form role="form" action="" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table class="table">
        <tbody>
        <tr>
            <td class="tl">商品分类</td>
            <td>
                <span id="load_category_1">
                    <select name="cateid"  class="form-control"
                            onchange="load_category(this.value);" size="2"  style="width:200px;height:130px;display: inline-block; " >
                        <option value="0">请选择</option>
                        <? echo $catetree;?>
                    </select>
                </span>
                <select  class="form-control"   id="catbrand" size="2" style="width:200px;height:130px;display: inline-block;">
                </select>
            </td>

        </tr>
        <tr>
            <td class="tl">品牌名称</td>
            <td><textarea name="brandname" class="form-control" style="width: 300px;height:100px;"></textarea>
                <span  >允许批量添加，一行一个，点回车换行</span></td>
        </tr>
        <tr>
            <td colspan="2" align="center"   >
                <button type="submit" class="btn btn-primary">添加</button>
                <button type="button" class="btn btn-default" onclick="javascript:history.back();">返回</button>
            </td>
        </tr>

        </tbody>
    </table>

    @endsection
    @section('script')

    <script>
        /*
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
        }*/

        function load_category(cateid ) {
            ajaxurl="/ajax/brand/?cateid="+cateid+"&rnd="+new Date().getTime();
            $.get(ajaxurl,  function (data) {
                $("#catbrand").empty();
                    var obj = eval(data);
                    $(obj).each(function(index) {
                        var val = obj[index];
                        opt = $("<option/>").text(val.bname ).attr("value", val.id);
                        $('#catbrand').append(opt);
                    });
                });

        }


    </script>

</form>
@endsection