@extends('layouts.master')
@section('title')
确认收货地址 - @parent
@stop
@section('content')
<div class="page-pay-deposit">
<!-- Page Content -->
<div class="container">
<!-- Page Heading/Breadcrumbs -->


<br>
<!-- Portfolio Item Row -->
<div class="row pay-deposit-box">
<div class="col-lg-12">

<div class="row text-center">
    <div class="col-md-2"> </div>
    <div class="col-md-2"><hr></div>
    <div class="col-md-4"><h1>确认收货地址</h1></div>
    <div class="col-md-2"><hr></div>
    <div class="col-md-2"> </div>
</div>
<div class="row">
    <div class="col-md-4"> </div>
    <div class="col-md-4 text-center"><h3>&nbsp;</h3></div>

</div>




        <form role="form " class="form-horizontal" id="Form1" action="/pay/saveaddr" method="post" style="padding-left: 104px;">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="deid" value="{{ $order->desn }}">

            <div id="select-address" class="w mt20">
            <div class="title w mb10">
                <b class="fs14">选择收货人及地址信息</b>
            </div>

            <div class="oldaddress w">
                @foreach ($useraddrs as $useraddr)
                <dl class="f66 clearfix address_item">
                    <dt class="float-left">
                        <input  type="radio"   name="myaddr" value="{{$useraddr->id}}"></dt>
                    <dd class="float-left">{{$useraddr->fulladdr}}</dd>
                </dl>
                @endforeach
            </div>
            </div>

            <div class="row" style=" margin-top: 40px;">
                <div class="col-md-12 "> <span class="fs14" style="color: #2677B5;padding-left: 10px;">新增收货地址</span>  </div>
           </div>


<style>

    body{font-size: 12px;  font-family:'Microsoft YaHei';  }
    input[type=radio],input[type=checkbox] {
        margin: 4px 5px 5px;
        margin-top: 1px \9;
        line-height: normal
    }

    dl {
        margin-top: 0;
        margin-bottom: 0px;
    }
    #select-address .title {
        line-height: 30px;
        font-size: 12px;
        padding-bottom: 20px;
    }
    .title a {
        color: #0033CC;
        text-decoration: none;
    }
    #select-address dl {
        padding: 5px 0 5px 0;
        cursor: pointer;
        width: 100%;
    }

    .clearfix:after{ content:'\20'; display:block; overflow:hidden; height:0; clear:both;}
    .clearboth{ clear:both;}

    .newaddressform .fill_in_content {
        margin-left:5px;
        border: 1px #DEE9F1 solid;
        padding: 20px;
        font-size: 12px;
    }
    ul, ol {list-style: none;}

    .newaddressform .fill_in_content li {
        height: 36px;
        line-height: 36px;
        clear: both;
    }
    .newaddressform .fill_in_content input {
        border: 1px #829FBB solid;
        line-height: 17px;
    }
    #select-address .field_notice {
        color: #9C9C9C;
        margin-left: 5px;
    }
    input, button, select, textarea {
        outline: none;
    }
    input, select {
        vertical-align: middle;
    }
    .float-left {
        float: left;
    }

</style>


            <div class="newaddressform w">
                <ul class="fill_in_content mt10" id="address_form" style="display: block;">
                    <li>
                      <span style="color: #f00;">*</span>  收货人姓名：<input type="text" name="send[name]" id="consignee">
                        <span class="field_message explain"><span class="field_notice">请填写真实姓名</span></span>
                    </li>
                    <li class="clearfix">
                        <div class="float-left"> <span style="color: #f00;">*</span> 所在地区：</div>
                        <div id="region" class="float-left">

                            <select name="province" onchange="loadArea(this.value,'city')">
                                <option value="-1" selected>请选择地区</option>
                                @foreach ($provices as $area)
                                <option value="{{$area->id}}">{{$area->areaname}}</option>
                                @endforeach
                            </select>

                            <select name="city"   id="city"   key="district" onchange="loadArea(this.value,'district')">
                                <option value="-1">市/县</option>
                            </select>

                            <select name="district" id="district"  key="null" onchange="loadArea(this.value,'null')">
                                <option value="-1">镇/区</option>
                            </select>

                        </div>
                    </li>
                    <li>
                        <span style="color: #f00;">*</span>  详细地址：<input type="text" name="addr_detail" id="address">
                        <span class="field_message explain"><span class="field_notice">请填写真实地址，不需要重复填写所在地区</span></span>
                    </li>
                    <li>
                        <span style="color: #f00;">*</span>   手机号码：<input type="text" id="phone_mob" name="send[mobile]">
                        <span class="field_message explain"><span class="field_notice">手机和固定电话至少填一项</span></span>
                    </li>
                    <li> <span class="explain f66">自动保存收货地址(选择后该地址将会保存到您的收货地址列表)</span></li>
                </ul>
            </div>


            <div class="col-md-12  " style="margin-top: 40px;margin-bottom: 20px;">
                <button type="button" class="btn   btn-lg"  name="bntSubmit"  onClick="ChkReg(this.form);"
                        style="background: #FE6501;border: #FE6501;border-radius: 0px;
                            color: #ffffff;">确认地址</button>
                <input name="action" type="hidden" id="action" value="choose" />
            </div>




        </form>








</div>
</div>
<!-- /.row -->
<br>



</div>
<!-- /.container -->
</div>
@stop

@section('script')

<script language="javascript">
    function ChkReg(frm)
    {

        frm.bntSubmit.disabled=true;
        frm.submit();
    }
</script>


<script type="text/javascript">

    function loadArea(areaId, areaType) {
        ajaxurl="/ajax/area/?areaid="+areaId+"&rnd="+new Date().getTime();
        $.get(ajaxurl,  function (data) {
            if (areaType == 'city') {
                $('#' + areaType).html('<option value="-1">市/县</option>');
                $('#district').html('<option value="-1">镇/区</option>');
            } else if (areaType == 'district') {
                $('#' + areaType).html('<option value="-1">镇/区</option>');
            }
            if (areaType != 'null') {
                var obj = eval(data);
                $(obj).each(function(index) {
                    var val = obj[index];
                    opt = $("<option/>").text(val.areaname ).attr("value", val.id);
                    $('#' + areaType).append(opt);
                });

                /*
                 $.each(data, function (no, items) {
                 opt = $("<option/>").text(items.area_name).attr("value", items.area_id);
                 $('#' + areaType).append(opt);
                 });*/

            }
        });
    }








    //将form转为AJAX提交
    function ajaxSubmit(frm, fn) {
        var dataPara = getFormJson(frm);
        var url=frm.action;
        $.ajax({
            url: url,
            type: frm.method,
            data: dataPara,
            success: fn
        });
    }

    //将form中的值转换为键值对。
    function getFormJson(frm) {
        var o = {};
        var a = $(frm).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });

        return o;
    }

    //调用
    $(document).ready(function(){
        $("#mybutton").bind("click",function(){
            ajaxSubmit( $('#Form1')[0], function(data){
                alert(data);
            });
        });

    });
</script>
@endsection