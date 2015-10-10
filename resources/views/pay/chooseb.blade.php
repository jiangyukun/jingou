@extends('layouts.master')
@section('title')
收银台选择银行 - @parent
@stop
@section('content')

<link rel="stylesheet" type="text/css" href="http://respay.suning.com/epps-ppps/style/standardCashier/css/payfirst.css?v=V2015-08-06">
<link rel="stylesheet" href="https://respay.suning.com/epps-ppps/style/default/css/pay/cashierHelper.css?v=V2015-08-06">
<style>
    .btn{padding: 0px;}
</style>
<!--m-pay s-->
<div class="g-main clearfix">


<div class="g-main-bd">

<!--m-bank s -->
<!--m-bank [[ -->
<div class="m-bank">
<div class="bank-tabs clearfix">
    <ul class="clearfix">
        <li data-paymodel="STANDARD_DEBIT_CARD" class="bank-tabs-item active"><a hidefocus="true" href="javascript:;">储蓄卡</a></li>
    </ul>
    <span class="bank-tabs-bar" style="left: 0px; top: 0px;"></span>
</div>
<div class="bank-cont clearfix">
<!-- 储蓄卡开始 -->

    <form action="/pay/paybank" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="deid" value="{{$deid}}">
        <input type="hidden" name="orderid" value="{{$orderid}}">

<div style="display: block;" class="bank-cont-item cont0">
    <div class="bank-list-hd quick-pay clearfix"><i class="quick-pay-icon"></i>
        <span class="quick-pay-desc">（无需开通网银，双重密码保障）</span>
    </div>

    <ul class="bank-list clearfix">
        <li><i class="icon-bank CCB"> <input type="radio" name="banks" value="CCB-DEBIT"  /></i> </li>
        <li><i class="icon-bank CMB"><input type="radio" name="banks" value="CMB-DEBIT" /></i></li>
        <li><i class="icon-bank CGB"><input type="radio" name="banks" value="GDB-DEBIT" /></i></li>
        <li><i class="icon-bank BOC"><input type="radio" name="banks" value="BOC-DEBIT" /></i></li>
        <li><i class="icon-bank ICBC"><input type="radio" name="banks" value="ICBC-DEBIT" /></i></li>
        <li><i class="icon-bank PSBC"><input type="radio" name="banks" value="PSBC-DEBIT" /></i></li>
        <li><i class="icon-bank COMM"><input type="radio" name="banks" value="COMM-DEBIT" /></i></li>
    </ul>




    <div class="bank-list-action">
        <input type="submit"    class="btn go-next" name1="ppps1_debit_tab_xiayibu" value="下一步" />

    </div>
</div>
<!-- 储蓄卡结束 -->

    </form>

<span style="left: 41px; top: 74px; display: block;" class="bank-item-bar"></span>
</div>
</div>
<!--m-bank ]] -->
<!--m-bank e -->

</div>
</div>


@stop