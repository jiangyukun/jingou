@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')


<div>
<div class="header" data-position="fixed">
    <a href="javascript:" id="btnback" class="turnback">
        <i class="i-back"></i>返回</a>
        <h1>我的竞购</h1>
    <a href="/" data-hmclog="{pageid: 1, eventid: 41}" class="header-cancel btnre ui-btn-right lg">首页</a>
</div>



<div data-role="content">
    <div id="wrapper">
        <div id="scroller">
            <div class="pick">
                <div class="car-menu">

                    <nav class="pick-submenu" id="masterBrandDis">

    <ul class="nav nav-tabs"  style="padding: 0px;">
        <span {{ isset($type)&&$type=='all'?' class=on':'' }} > <a href="/demand/my/all">所有竞购</a> </span>
        <span {{ isset($type)&&$type=='deposit'?' class=on':'' }}> <a href="/demand/my/deposit">定金待支付</a></span>
        <span {{ isset($type)&&$type=='active'?' class=on':'' }}> <a href="/demand/my/active">竞价中</a></span>
        <span {{ isset($type)&&$type=='choose'?' class=on':'' }}> <a href="/demand/my/choose">待选标</a></span>
        <span {{ isset($type)&&$type=='pay'?' class=on':'' }} > <a href="/demand/my/pay">待付款</a></span>
        <span {{ isset($type)&&$type=='delivery'?' class=on':'' }} > <a href="/demand/my/delivery">待收货</a></span>
        <span {{ isset($type)&&$type=='getted'?' class=on':'' }}><a href="/demand/my/getted">已完成</a></span>
        <span {{ isset($type)&&$type=='cancelled'?' class=on':'' }}> <a href="/demand/my/cancelled">已取消</a></span>
    </ul>


                    </nav>
                </div>
                <div class="pick-cars">
                    <div>
                        <ul id="pick-car">



                            @if (count($demands))
                            @foreach ($demands as $demand)

                            <li><a href="{{ URL::to('demand/show/'.$demand->id) }}">
                                    <img src="/{{ $demand->thumb }}" alt="">
                                    <h3>{{ $demand->title }}</h3></a>
                            </li>


                            @endforeach
                            @endif

                        </ul>
                        <div id="pullUp" onclick="myLoad();" style="display:none">
                            加载更多
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

@stop