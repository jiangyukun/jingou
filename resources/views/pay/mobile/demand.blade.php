@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')


<div>
<link rel="stylesheet" href="/img.huimaiche.cn/uimg/m/v20150730/css/usercenter.css?v=101677">
<form method="post" action="{{ isset($purl) ? $purl : '?' }}" id="form1">
    <div class="header" style="">
        <a href="/demand/my" class="turnback"><i class="i-back"></i>我的竞购</a>
        <h1>预付订金</h1>
    </div>
    <div data-role="content">
        <div class="subscription card-detail">

            <div class="car-card">
                <div class="car-pic">
                    <img src="/{{ $demand->thumb}}" alt=""></div>
                <div class="car-short-info">
                    <h2>{{ $showtitle }}</h2>
                    <p class="cgray">竞购价格：{{  $winprice }}</p>
                </div>

                <div class="card-switch">
                    <i class="i-bg-0"></i>
                </div>
            </div>


            <div class="order-money">
                <strong>订金金额</strong> <span>￥{{ $demand->deposit}}</span><del></del>
            </div>
            <div id="payTypeDivLine" class="line">
            </div>
            <div id="payTypeDiv" class="choose-pay-type">
                <dl>

                    <dt>支付方式</dt>
                    <dd>
                        <i class="ali"></i>
                        <h3> 支付宝网页版支付</h3>

                    </dd>

                </dl>
            </div>


            <div class="line"></div>


            <div id="noPayDiv" class="pay-immediate"  >
                <div class="price-txt">
                    实际支付：<strong class="c-gray">￥{{ $lastPrice }}</strong>
                </div>
            </div>
            <div class="line"></div>



            <div id="hasPayDiv" class="pay-immediate">
                <div class="price-txt">
                </div>
                <div class="btn">
                    <form method="post" action="{{ isset($purl) ? $purl : '?' }}" target="_blank">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="step" value="{{ $step }}">
                        <input type="hidden" name="deid" value="{{ $demand->id }}">

                        <button type="submit"  class="main-btn" id="btnPay">立即支付</button>

                 </form>
                </div>






<!--------
            <div class="pay-consist">
                <ul id="ulCarLink">
                    <li><a href=""><strong>车型参数</strong> </a><i class="i-link"></i>
                    </li>
                    <li><a href=""><strong>车型图片</strong> </a><i class="i-link"></i>
                    </li>
                </ul>
            </div>
 ---------->

            <div class="line"></div>

            <div class="s-block nobdt">
                <p class="btn-block"><a href="/demand/my" class="cancel">等会再付</a></p>

                <p>51竞购为您服务</p>
                <p><span>4000-000-000</span> 周一至周日(9:00 - 21:00)</p>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".footer-bar span").on("click", function () {
                $("html, body").animate({
                    scrollTop: 0
                }, 300);
            });
        });
    </script>

    <script src="../JS/footer.js" type="text/javascript"></script>

</form>
</div>
@stop

