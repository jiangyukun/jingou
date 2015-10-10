@extends('layouts.m_master')
@section('title')
支付订金 - {{$demand->title}} - @parent
@stop
@section('content')

<link rel="stylesheet" href="http://cdn.staticfile.org/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ url('/css/style.css') }}">
<div>

    <div class="header" style="">
        <a href="javascript:void(0);" class="turnback"><i class="i-back"></i>返回</a>
        <h1>预付订金</h1>
    </div>

<div class="col-lg-12">
    <form method="post" action="" target="_self">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row text-center">

            <div class="col-sm-3"><hr></div>
            <div class="col-sm-6"><h1>支付订金</h1></div>
            <div class="col-sm-3"><hr></div>

        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-6 text-center"><h3>订金金额：<span class="price">{{ $deposit }}</span> 元</h3></div>
            <div class="col-sm-6">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    每个订单按参考商品价格{{$depositfee}}%支付定金,招标成功定金转为付款,无有效竞价定金二天内退还.
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-12 text-center pay-type"><h3>支付方式：
                    <div class="btn-group btn-block" data-toggle="buttons">
                        <label class="btn btn-default active pay_type_alipay">
                            <input type="radio" name="pay_type" id="pay_type_alipay" value="0" autocomplete="off" checked> </label>
                        <label class="btn btn-default pay_type_weixin">
                            <input type="radio" name="pay_type" id="pay_type_weixin" value="1" autocomplete="off"> </label>
                    </div></h3>
            </div>

        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-3"></div>
            <div class="col-md-3 text-center"><button type="submit" class="btn btn-success btn-lg">立即支付</button></div>
            <div class="col-md-3 text-center"><a href="/demand/my" class="btn btn-default btn-lg">等会再付</a></div>
            <div class="col-md-3"></div>
        </div>
    </form>
</div>
</div>


@stop