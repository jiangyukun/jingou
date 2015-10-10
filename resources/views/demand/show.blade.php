@extends('layouts.master')
@section('title')
    {{$demand->title}} - 竞购详情 - @parent
@stop
@section('content')
    <div class="page-demand-show">
        <!-- Page Content -->
        <div class="container">
            @if($demand)
                <!-- Page Heading/Breadcrumbs -->
                <div class="row">
                    <div class="col-xs-12">
                        <ol class="breadcrumb">
                            <li>当前位置：</li>
                            <li><a href="/">首页</a></li>
                            <li><a href="/demand/list">竞价列表</a></li>
                            @foreach ($path as $cate)
                            <li><a href="/demand/list/cate/{{$cate['id']}}">{{$cate['name']}}</a></li>
                            @endforeach
                            <li class="active">竞价详情</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Portfolio Item Row -->
                <div class="row d-info-box">
<div class="col-xs-12">
                    <div class="col-xs-7">
                        <div id="carousel-example-generic" class="slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="img-responsive" src="/{{$demand->thumb}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-5">
                        <h3 class="jingtitle">{{$demand->title}}
                            <span style="font-size: 12px;padding-left: 20px;">
                                <a href="javascript:void(0);" onclick="alert('收藏成功!')" style="color: #f00;" >收藏 </a> </span></h3>
                       <!---- {{$demand->created_at}}
                        <small class="d-author">{{$demand->user->username}}</small>---->

                        <ul class="jinglist">
                            <li><b>起竞价格</b>：<strong class="rstt">{{$demand->price}}元</strong></li>
                            <li>当前状态：
                                @if($demand->status<=0)
                                    <!------竞价中----->
                                    <b class="rstt">  {{$demand->getstatus()}}</b>
                                @else
                                    <!-----不在竞价中-------->
                                    @if($myBid)
                                        @if($myBid->is_win==0  )
                                            <b class="rstt">淘汰</b>
                                        @else
                                            <b class="rstt">{{$demand->getbidstatus()}}</b>
                                        @endif
                                    @else
                                         <b class="rstt">{{$demand->getstatus()}}</b>
                                    @endif

                                @endif




                            </li>

                            <li>竞价时间：
                                <?php
                                if ($demand->paytime == "") echo "----";
                                else
                                {
                                    $demand->getstarttime();
                                }
                                ?></li>
                            <li>竞价商家：{{ count($demand->bids)?count($demand->bids):'暂无' }}</li>
                            <li>最低竞价：{{ $lowprice<9999999?$lowprice:'暂无' }}</li>
                            <li>距离结束:{{$demand->getexptime()}}</li>
                            @if($myBid)
                            <li>我的竞价： <? if($myBid) echo $myBid->price;else echo "---"; ?>
                                 @if($myBid->is_win)  <b class="rstt">中标</b>  @endif
                            </li>
                            @endif

                        </ul>
                     <!-----   <h5>买家备注</h5><p>{{$demand->details}}</p>----->
                        <h5><a href="{{$demand->url}}" title="{{$demand->title}}" target="_blank" rel="nofollow">点击进入竞价对照商品页面</a> </h5>

                    </div>
</div>
                </div>
                <!-- /.row -->
                <hr>






            @if( isset(Auth::user()->id) &&  Auth::user()->id == $demand->user_id )
                @include('demand.buyer')
            @else
                @include('demand.bidder')
            @endif





            @else
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="page-header">竞购信息不存在或已被删除！</h3>
                    </div>
                </div>
            @endif




        </div>
        <!-- /.container -->
    </div>
@stop