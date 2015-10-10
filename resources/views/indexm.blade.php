@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')



<div class="header" data-position="fixed" id="divhead">
    <i class="i-logo">竞东东</i>
    @if (Auth::guest())
    <a href="{{ url('/auth/login') }}" id="link-login"  class="header-cancel btnre ui-btn-right lg">{{Lang::get('layout.Login')}}</a>
    @else
    <a  class="header-cancel btnre ui-btn-right lg"
        href="{{isset(Auth::user()->id) && Auth::user()->hasRole('admin') ? url('/admin/index') : (Auth::user()->hasRole('bidder')?url('/bid/my'):url('/demand/my')) }}">
        {{ Auth::user()->username }}</a>
    @endif

</div>



<div data-role="content">
    <div class="index-buy" style="color: #fff;">
        <h2>最低价,竞出来！</h2>
        <h3>在淘宝，在京东，在任何地方看中了一件商品，就来51竞购，我们帮你竞价最便宜的！</h3>
        <p> &nbsp;</p>

        <div id="ad16" data-adcode="16"></div>

        <a href="/demand/post" class="buy-begin">发布竞购</a>
    </div>
    <ul class="index-nav">
        <li><a href="/demand/list"><i class="i-mycar">
                </i>正在竞价</a> </li>
        <li><a href="/demand/my/"><i class="i-mydjq">
                </i>我的竞购</a> </li>
        <li><a href="/bid/my/all" data-hmclog="{pageid: 1, eventid: 71}"><i class="i-tuan">
                </i>我的竞价</a></li>
        <li><a href="javascript:void(0);" rel="external"><i class="i-mykhd"></i>
                客户端</a> </li>
    </ul>

    <div class="index-cot">
        <div class="index-title">
            <strong>轻松玩转51竞购</strong>
        </div>
        <div class="index-reason" id="index_reason">
            <ul class="swiper-wrapper">
                <li class="swiper-slide"><i class="icon">&#xe607;</i>
                    <h2>我应该在购物的什么阶段发布竞价？</h2>
                    <h2>A：确定购买阶段。也就是商品、品牌、价格已经选定，下单前您来51竞购发布竞价，争取最后一次7折、8折的机会。</h2>
                </li>
                <li class="swiper-slide"><i class="icon">&#xe605;</i>
                    <h2>我购买所有商品都可以发布竞购吗？</h2>
                    <h2>不是。品牌型号确定的商品适合发布竞购，如品牌加点、3C等，这些商品能让商家在同一标准下竞价。个性服装、鞋包及商家自产自销的商品不适合竞价。</h2>
                </li>
                <li class="swiper-slide"><i class="icon">&#xe601;</i>
                    <h2>什么是起竟价格？</h2>
                    <h2>您发布的竞价商品，卖家的报价就是起竟价格。</h2>
                </li>
                <li class="swiper-slide"><i class="icon">&#xe603;</i>
                    <h2>什么是竞价成功？</h2>
                    <h2>参加竞价的商家发布的竞价中，有二个或二个以上竞价低于起竟价格10%，本次竞价成功。</h2>
                </li>
            </ul>
            <div class="clear">
            </div>
            <div class="index-pointer" id="reason-pointer">
            </div>
        </div>



        <div class="index-title">
            <strong>正在竞价</strong>
        </div>
        <div class="index-list">
            <ul>
                @foreach ($demands as $demand)
                <li><a href="{{ URL::to('demand/show/'.$demand->id) }}">
                        <img src="/{{ $demand->thumb }}" >
                        <p><span>{{ $demand->title }}</span>
                            <span class="many-buy">
                                <strong class="c-orange">{{ $demand->price }}</strong>
                            </span></p>
                    </a></li>
                @endforeach
            </ul>
        </div>

        <div id="sharePlaceholder">
        </div>
        <div class="ads" id="ad02">
            <ul class="swiper-wrapper" id="adList">
                <div id="ad6" data-adcode="6">
                </div>
            </ul>
            <div class="ads-pointer" id="ad02pointer">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" type="text/javascript">
     
    if (typeof Swiper !== "undefined") {
        new Swiper('#index_reason', {
            pagination: '#reason-pointer',
            loop: true,
            grabCursor: true,
            paginationClickable: true,
            calculateHeight: true,
            autoplay: 3000
        });
        window.onresize = function () {
            new Swiper('#index_reason', {
                calculateHeight: true
            });
        };
    }


</script>
@stop