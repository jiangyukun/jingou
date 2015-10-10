@extends('admin.master')
@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="/ncss/admin.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        //<!CDATA[
        var SITE_URL = "";
        var REAL_SITE_URL = "";
        var REAL_BACKEND_URL = "/admin";
        //]]>
    </script>

    <script type="text/javascript" src="/njs/jquery.js" charset="utf-8"></script>
    <script type="text/javascript" src="/njs/mall.js" charset="utf-8"></script>
    <script type="text/javascript" src="/njs/admin.js" charset="utf-8"></script>

    <script type="application/ecmascript">
        var lang = {"select_pls":"\u8bf7\u9009\u62e9...","loading":"\u52a0\u8f7d\u4e2d...",
            "loading_please":"\u52a0\u8f7d\u4e2d\uff0c\u8bf7\u7a0d\u5019...","confirm":"\u786e\u5b9a","yes":"\u662f","no":"\u5426",
            "error":"\u9519\u8bef","please_confirm":"\u8bf7\u786e\u8ba4",
            "delete_widget_confirm":"\u60a8\u786e\u5b9a\u8981\u4ece\u8be5\u9875\u9762\u4e2d\u5220\u9664\u8be5\u6302\u4ef6\u5417\uff1f",
            "config_widget":"\u914d\u7f6e\u6302\u4ef6","submitting":"\u63d0\u4ea4\u4e2d...","submit":"\u63d0\u4ea4","reset":"\u91cd\u7f6e","saving":"\u4fdd\u5b58\u4e2d...",
            "save_successed":"\u4fdd\u5b58\u6210\u529f\uff01",
            "display":"\u663e\u793a","hidden":"\u9690\u85cf","empty_area_notice":"\u60a8\u53ef\u4ee5\u5c06\u6302\u4ef6\u62d6\u653e\u81f3\u6b64",
            "name_exist":"\u6b64\u540d\u79f0\u5df2\u5b58\u5728\uff0c\u8bf7\u60a8\u66f4\u6362\u4e00\u4e2a","editable":"\u53ef\u7f16\u8f91",
            "only_number":"\u6b64\u9879\u4ec5\u80fd\u4e3a\u6570\u5b57","only_int":"\u6b64\u9879\u4ec5\u80fd\u4e3a\u6574\u6570",
            "only_pint":"\u6b64\u9879\u4ec5\u80fd\u4e3a\u6b63\u6574\u6570","not_empty":"\u6b64\u9879\u4e0d\u80fd\u4e3a\u7a7a","edit":"\u7f16\u8f91",
            "drop":"\u5220\u9664","add_child":"\u65b0\u589e\u4e0b\u7ea7",
            "confirm_delete":"\u5220\u9664\u8be5\u5206\u7c7b\u5c06\u4f1a\u540c\u65f6\u5220\u9664\u8be5\u5206\u7c7b\u7684\u6240\u6709\u4e0b\u7ea7\u5206\u7c7b\uff0c\u60a8\u786e\u5b9a\u8981\u5220\u9664\u5417",
            "small":"\u6b64\u9879\u5e94\u5c0f\u4e8e\u7b49\u4e8e","insert_editor":"\u63d2\u5165\u7f16\u8f91\u5668",
            "not_allowed_type":"\u60a8\u4e0a\u4f20\u7684\u6b64\u6587\u4ef6\u683c\u5f0f\u4e0d\u6b63\u786e",
            "not_allowed_size":"\u60a8\u4e0a\u4f20\u7684\u6b64\u6587\u4ef6\u5927\u5c0f\u8d85\u8fc7\u4e86\u5141\u8bb8\u503c",
            "space_limit_arrived":"\u5f88\u62b1\u6b49\uff0c\u60a8\u4e0a\u4f20\u7684\u6587\u4ef6\u6240\u5360\u7a7a\u95f4\u5df2\u8fbe\u4e0a\u9650\uff0c\u8bf7\u8054\u7cfb\u5546\u57ce\u7ba1\u7406\u5458\u5347\u7ea7\u5e97\u94fa",
            "no_upload_file":"\u672a\u77e5\u9519\u8bef\uff0c\u6ca1\u6709\u83b7\u53d6\u5230\u9700\u8981\u4e0a\u4f20\u7684\u6587\u4ef6\uff0c\u8bf7\u91cd\u8bd5\u6216\u8054\u7cfb\u5546\u57ce\u7ba1\u7406\u5458",
            "file_save_error":"\u6587\u4ef6\u4fdd\u5b58\u5931\u8d25\uff0c\u8bf7\u8054\u7cfb\u5546\u57ce\u7ba1\u7406\u5458",
            "file_add_error":"\u6587\u4ef6\u4fe1\u606f\u5165\u5e93\u9519\u8bef\uff0c\u8bf7\u8054\u7cfb\u5546\u57ce\u7ba1\u7406\u5458\u68c0\u67e5\u9519\u8bef",
            "queue_too_many":"\u4e00\u6b21\u4e0a\u4f20\u6587\u4ef6\u592a\u591a\uff0c\u8bf7\u5c11\u9009\u53d6\u4e00\u4e9b",
            "uploading":"\u6b63\u5728\u4e0a\u4f20...",
            "success":"\u6210\u529f\u3002","finish":"\u5b8c\u6210","cancelled":"\u5df2\u53d6\u6d88",
            "stopped":"\u5df2\u505c\u6b62",
            "uploadedfile_drop_confirm":"\u5220\u9664\u4f1a\u5bfc\u81f4\u7f16\u8f91\u5668\u7684\u6b64\u56fe\u7247\u65e0\u6cd5\u663e\u793a\uff0c\u786e\u5b9a\u8981\u5220\u9664\u5417\uff1f"};
        lang.get = function(key){
            eval('var langKey = lang.' + key);
            if(typeof(langKey) == 'undefined'){
                return key;
            }else{
                return langKey;
            }
        }
    </script>

    <script charset="utf-8" type="text/javascript" src="/njs/jqtable.js" ></script>
    <script charset="utf-8" type="text/javascript" src="/njs/inline_edit.js" ></script>
    <link rel="stylesheet" type="text/css" href="/ncss/jqtreetable.css"  /></head>
<body><script type="text/javascript" src="/njs/ajax_tree.js" charset="utf-8"></script>
<div id="rightTop">
    <p>商品分类</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="/admin/cate/add/{{$sid}}">新增</a></li>
    </ul>
</div>

<div class="info2">
<table  class="distinction">
<thead>
<tr class="tatr1">
    <td class="w30"><input id="checkall_1" type="checkbox" class="checkall" /></td>
    <td width="50%"><span class="all_checkbox"><label for="checkall_1">全选</label></span>分类名称</td>
    <td>排序</td>
    <td>显示</td>
    <td class="handler">操作</td>
</tr>
</thead>
<tbody id="treet1">



@foreach ($cates as $gcategory)


<tr>
    <td class="align_center w30"><input type="checkbox" class="checkitem" value="{{$gcategory['id']}}" /></td>
    <td class="node" width="50%">
        @if ($gcategory['switchs'] )
            <img src="/ncss/images/tv-expandable.gif" ectype="flex" status="open" fieldid="{{$gcategory['id']}}">
        @else
            <img src="/ncss/images/tv-item.gif">
        @endif
        <span class="node_name editable" ectype="inline_edit" fieldname="cate_name" fieldid="{{$gcategory['id']}}" required="1"
              title="编辑">{{$gcategory['slug']}}</span></td>
    <td class="align_center">
        <span class="editable" ectype="inline_edit" fieldname="sort_order"
              fieldid="{{$gcategory['id']}}" datatype="number" title="编辑">{{ $gcategory['sort']}}</span>
    </td>
    <td class="align_center">
        <img src="/ncss/images/positive_enabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="{{$gcategory['id']}}"
             fieldvalue="1" title="编辑"/>
    </td>
    <!-- props tyioocom -->
    <td  width="200">
        <span>
            <a href="/admin/editcate/{{$gcategory->id}}">编辑</a>|
            <a href="javascript:if(confirm('您确定要删除吗'))window.location = '/admin/delcate/{{$gcategory->id}}';">删除</a>
            | <a href="/admin/cate/add/{{$gcategory->id}}?sortpath={{$gcategory->sortpath}}">新增下级</a>
         </span>
    </td>
</tr>

@endforeach



</tbody>

</table>
</div>

@endsection
