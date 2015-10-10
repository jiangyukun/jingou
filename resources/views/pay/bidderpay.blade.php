@extends('layouts.master')
@section('title')
{{$demand->title}} - @parent
@stop
@section('content')
<div class="page-pay-deposit">
    <!-- Page Content -->
    <div class="container">
        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li>当前位置：</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/demand/my">我的竞购</a></li>
                    <li><a href="/demand/show/{{ $demand->id }}">{{ $demand->title }}</a></li>
                    <li class="active">支付尾款</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <br />
        @if($step==2)
        <div class="row">
            <form role="form " class="form-horizontal" id="Form1" action="/pay/saveaddr" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-lg-8  col-lg-offset-2">
                    <div class="form-group" style="height:30px;">
                        <div class="col-lg-3" style="text-align: right">
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="checked"></div>
                        <div class="col-lg-9"  ><label>已保存的地址</label></div>
                    </div>
                    <div class="form-group" style="height: 30px;">
                        <div class="col-lg-3" style="text-align: right">
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" ></div>
                        <div class="col-lg-9" ><label>新增地址</label></div>
                    </div>
                    <div class="form-group" style="height: 50px;" >
                        <div class="col-lg-3" style="text-align: right"><label>地区：</label></div>
                        <div class="col-lg-3">

                            <select name="province" class="form-control"  onchange="loadArea(this.value,'city')">
                                <option value="-1" selected>省份/直辖市</option>
                                @foreach ($provices as $area)
                                <option value="{{$area->id}}">{{$area->areaname}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-3">

                            <select name="city"   id="city" class="form-control"  key="district" onchange="loadArea(this.value,'district')">
                                <option value="-1">市/县</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select name="district" id="district" class="form-control"  key="null" onchange="loadArea(this.value,'null')">
                                <option value="-1">镇/区</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="height: 50px;">
                        <div class="col-lg-3" style="text-align: right"><label>收货地址：</label></div>
                        <div class="col-lg-9" style="text-align: right"><input class="form-control" name="addr_detail"></div>
                    </div>
                    <div class="form-group" style="height: 50px;">
                        <div class="col-lg-3" style="text-align: right"><label>收货人姓名：</label></div>
                        <div class="col-lg-9" style="text-align: right"><input class="form-control" name="send[name]"></div>
                    </div>
                    <div class="form-group" style="height: 50px;">
                        <div class="col-lg-3" style="text-align: right"><label>手机号码：</label></div>
                        <div class="col-lg-9" style="text-align: right"><input class="form-control" name="send[mobile]"></div>
                    </div>
                    <div class="form-group" style="height: 50px;text-align: center">
                        <button type="button" id="mybutton" class="btn btn-success btn-lg" style="width: 100px;">保存</button>
                    </div>
                </div>
            </form>


        </div>
        @endif
        <br>
        <!-- Portfolio Item Row -->
        <div class="row pay-deposit-box">
            <div class="col-lg-12">
                <form method="post" action="{{ isset($purl) ? $purl : '?' }}" target="_blank">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="step" value="{{ $step }}">

                    <div class="row text-center">
                        <div class="col-md-2"> </div>
                        <div class="col-md-3"><hr></div>
                        <div class="col-md-3"><h1>{{ $showtitle }}</h1></div>
                        <div class="col-md-3"><hr></div>
                        <div class="col-md-2"> </div>
                    </div>




                    <div class="row">
                        <div class="col-md-4"> </div>
                        <div class="col-md-4 text-center"><h3>订金金额：<span class="price">￥{{ $lastPrice }}</span> 元</h3></div>
                        <div class="col-md-4">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                商家保证金2000元，每次竞价按该商品起竞价1%计算保证金。
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4"> </div>
                        <div class="col-md-4 text-center pay-type"><h3>支付方式：
                                <div class="btn-group btn-block" data-toggle="buttons">
                                    <label class="btn btn-default active pay_type_alipay">
                                        <input type="radio" name="pay_type" id="pay_type_alipay" value="0" autocomplete="off" checked> </label>
                                    <label class="btn btn-default pay_type_weixin">
                                        <input type="radio" name="pay_type" id="pay_type_weixin" value="1" autocomplete="off"> </label>
                                </div></h3>
                        </div>
                        <div class="col-md-4"> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3 text-center"><button type="submit" class="btn btn-success btn-lg">立即支付</button></div>
                        <div class="col-md-3 text-center"><a href="/demand/my" class="btn btn-default btn-lg">等会再付</a></div>
                        <div class="col-md-3"></div>
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