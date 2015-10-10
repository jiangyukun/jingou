@extends('layouts.master')
@section('title')
我的竞购 - @parent
@stop
@section('content')
    <div class="page-demand-my">
	    <div class="container">
            @include('bid.leftm')
            <div class="col-xs-9">

                <ul class="nav nav-tabs">
                    <li role="presentation"{{ isset($type)&&$type=='all'?' class=active':'' }}><a href="/bid/my/all">我的竞价</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='active'?' class=active':'' }}><a href="/bid/my/active">竞价中</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='notchoose'?' class=active':'' }}><a href="/bid/my/notchoose">待选标</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='notpayed'?' class=active':'' }}><a href="/bid/my/notpayed">待付款</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='notsend'?' class=active':'' }}><a href="/bid/my/notsend">待发货</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='notreceive'?' class=active':'' }}><a href="/bid/my/notreceive">待收款</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='finish'?' class=active':'' }}><a href="/bid/my/finish">已完成</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='lose'?' class=active':'' }}><a href="/bid/my/lose">淘汰</a></li>
                </ul>
                @if (count($bids))
                    @foreach ($bids as $bid)
                <div class="row">
                    <div class="d-list-sn{{ $bid->is_win=='1'?' text-success':'' }}">
                        <span>订单编号：{{ $bid->demand->sn }}</span><span>提交时间：{{ $bid->demand->created_at }}</span>
                        <span class="d-author">

@if($bid->demand->is_pay>=1)

                        @if($bid->is_win=='1')
                            <strong style="color: #FFF; background-color: #f00;padding: 2px; "><i class="glyphicon glyphicon-thumbs-up"></i>中标</strong>
                        @else
                            <strong style="color: #FFF; background-color: #FF7F27;padding: 2px; "><i class="glyphicon "></i>淘汰</strong>
                        @endif
@endif

                        </span>
                    </div>
                    <div class="col-xs-2"><a href="{{ $bid->demand->url }}" title="点击进入竞价对照商品页面" target="_blank" rel="nofollow">
                            <img src="/{{ $bid->demand->thumb }}" alt="{{ $bid->demand->title }}"></a></div>
                    <div class="col-xs-7 d-list-title">
                        <h5>
                            <a href="{{ URL::to('demand/show/'.$bid->demand->id) }}" title="{{ $bid->demand->title }}">{{ $bid->demand->title }}</a>
                        </h5>

                        <div class="col-xs-12"><span>竞价商家 {{ count($bid->demand->bids)?'('.count($bid->demand->bids).')':'暂无' }}</span></div>
                    </div>
                    <div class="col-xs-3 d-list-info">


                        <p>当前状态：
                            @if($type=='lose')
                                淘汰
                            @else
                                @if($bid->demand->status>=1 &&  $bid->is_win!='1')
                                      淘汰
                                 @else
                                     {{ $bid->demand->getbidstatus() }}
                                @endif


                            @endif
                          </p>

                        <p>距离结束：  {{ $bid->demand->getexptime() }} </p>
                        <p>初始竞价：￥{{ $bid->dprice }}</p>
                        <p>我的竞价：￥{{ $bid->price }}</p>
                        @if($bid->demand->status==2)
                            <a href="{{ URL::to('bid/f/'.$bid->demand->id) }}" class="btn btn-warning" title="查看详情">发货 <i class="fa fa-angle-right"></i></a>
                        @endif

                        @if($bid->demand->status==3 || $bid->demand->status==4)
                        <a href="{{ URL::to('bid/sk/'.$bid->demand->id) }}" class="btn btn-warning" title="查看详情">确认收款 <i class="fa fa-angle-right"></i></a>
                        @endif

                    </div>
                </div>
                    @endforeach
                @else
                    <div class="row">
                        暂无竞购信息
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop