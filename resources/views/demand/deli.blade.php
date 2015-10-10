@extends('layouts.master')
@section('title')
我的竞购 - @parent
@stop
@section('content')
<div class="page-demand-my">
    <div class="container">
        <div class="col-xs-3 side-bar">
            <div class="list-group">
                <a class="list-group-item" href="{{ url('demand/post') }}">发布竞购</a>
                <a class="list-group-item active" href="{{ url('demand/my') }}">我的竞购</a>
                <a class="list-group-item" href="{{ url('bidder/fav') }}">商家收藏</a>
            </div>
        </div>
        <div class="col-xs-9">

            <ul class="nav nav-tabs">
                <li role="presentation"{{ isset($type)&&$type=='all'?' class=active':'' }}><a href="/demand/my/all">所有竞购</a></li>
                <li role="presentation"{{ isset($type)&&$type=='deposit'?' class=active':'' }}><a href="/demand/my/deposit">定金待支付</a></li>
                <li role="presentation"{{ isset($type)&&$type=='active'?' class=active':'' }}><a href="/demand/my/active">竞价中</a></li>
                <li role="presentation"{{ isset($type)&&$type=='finish'?' class=active':'' }}><a href="/demand/my/finish">竞价结束</a></li>
                <li role="presentation" class='active'  }}><a href="/demand/my/finish">查看物流</a></li>
            </ul>

            <div class="row">
                <div class="d-list-sn">
                    <span>订单编号：{{ $demand->sn }}</span><span>提交时间：{{ $demand->created_at }}</span>
                    @if($demand->status!='已取消')
                        <span class="d-author">
                        <a href="{{ URL::to('demand/cancel/'.$demand->id) }}" onclick="return confirm('确定要取消？');" title="取消竞价">取消竞价</a>
                        </span>
                    @endif
                </div>
                <div class="col-xs-2"><a href="{{ $demand->url }}" title="点击进入竞价对照商品页面" target="_blank" rel="nofollow"><img src="/{{ $demand->thumb }}" alt="{{ $demand->title }}"></a></div>
                <div class="col-xs-7 d-list-title"><h5><a href="{{ URL::to('demand/show/'.$demand->id) }}" title="{{ $demand->title }}">{{ $demand->title }}</a></h5>

                    <div class="col-xs-12"><span>竞价商家 {{ count($demand->bids)?'('.count($demand->bids).')':'暂无' }}</span></div>
                </div>
                <div class="col-xs-3 d-list-info">

                    <p>当前状态：{{ $demand->status }}</p>
                    @if($demand->status!='已取消')
                    <p>距离结束：{{ $demand->expire_time }}</p>
                    @endif
                    <p>初始竞价：￥{{ $demand->price }}</p>
                    <p>当前竞价：￥{{ $demand->price }}</p>
                </div>
            </div>


            <div class="row">
                <div class="d-list-sn">
                    <span>收货地址:{{$deli->address}}&nbsp;&nbsp;&nbsp;快递公司:{{$deli->types}}&nbsp;&nbsp;&nbsp;  运单号:{{$deli->numbers}}</span>
                </div>
                <div class="d-list-info">
                    <span>物流信息:</span>
                </div>
            </div>


        </div>
    </div>
</div>
@stop