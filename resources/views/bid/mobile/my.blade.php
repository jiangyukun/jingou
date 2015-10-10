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

    <a style="float: right">首页</a>
</div>



<div data-role="content">
    <div id="wrapper">
        <div id="scroller">
            <div class="pick">
                <div class="car-menu">

                    <nav class="pick-submenu" id="masterBrandDis">
                           <span {{ isset($type)&&$type=='all'?' class=on':'' }}><a href="/bid/my/all">我的竞价</a></span>
                           <span {{ isset($type)&&$type=='active'?' class=on':'' }}><a href="/bid/my/active">竞价中</a></span>
                           <span {{ isset($type)&&$type=='notchoose'?' class=on':'' }}><a href="/bid/my/notchoose">待选标</a></span>
                           <span {{ isset($type)&&$type=='notpayed'?' class=on':'' }}><a href="/bid/my/notpayed">待付款</a></span>
                           <span {{ isset($type)&&$type=='notsend'?' class=on':'' }}><a href="/bid/my/notsend">待发货</a></span>
                           <span {{ isset($type)&&$type=='notreceive'?' class=on':'' }}><a href="/bid/my/notreceive">待收款</a></span>
                           <span {{ isset($type)&&$type=='finish'?' class=on':'' }}><a href="/bid/my/finish">已完成</a></span>
                           <span {{ isset($type)&&$type=='lose'?' class=on':'' }}><a href="/bid/my/lose">淘汰</a></span>

                        </ul>


                    </nav>
                </div>
                <div class="pick-cars">
                    <div>
                        <ul id="pick-car">



                            @if (count($bids))
                            @foreach ($bids as $bid)
                            <li><a href="{{ URL::to('demand/show/'.$bid->demand->id) }}">
                                    <img src="/{{ $bid->demand->thumb }}" alt="">
                                    <h3>{{ $bid->demand->title }}</h3></a>
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



    <script>
        $("#btnback").click(function () {
                window.history.go(-1);
        });
    </script>

</div>
@stop