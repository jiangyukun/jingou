@extends('layouts.master')
@section('title')
我的竞购 - @parent
@stop
@section('content')
<style>
    .page-demand-my .row{border: none;}
</style>
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
                    <li role="presentation"{{ isset($type)&&$type=='choose'?' class=active':'' }}><a href="/demand/my/choose">待选标</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='pay'?' class=active':'' }}><a href="/demand/my/pay">待付款</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='delivery'?' class=active':'' }}><a href="/demand/my/delivery">待收货</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='getted'?' class=active':'' }}><a href="/demand/my/getted">已完成</a></li>
                    <li role="presentation"{{ isset($type)&&$type=='cancelled'?' class=active':'' }}><a href="/demand/my/cancelled">已取消</a></li>
                </ul>
                @if (count($demands))
                    @foreach ($demands as $demand)
                <div class="row">
                    <div class="d-list-sn">
                        <span>订单编号：{{ $demand->sn }}</span><span>提交时间：{{ $demand->created_at }}</span>
                        @if($demand->status==0 && $demand->is_pay==0)
                        <span class="d-author">
                        <a href="{{ URL::to('demand/cancel/'.$demand->id) }}" onclick="return confirm('确定要取消？');" title="取消竞价">取消竞价</a>
                        </span>
                        @endif
                    </div>
                    <div class="col-xs-2"><a href="{{ $demand->url }}" title="点击进入竞价对照商品页面" target="_blank" rel="nofollow">
                            <img src="/{{ $demand->thumb }}" alt="{{ $demand->title }}"></a></div>
                    <div class="col-xs-7 d-list-title"><h5><a href="{{ URL::to('demand/show/'.$demand->id) }}" class="blacka" title="{{ $demand->title }}">{{ $demand->title }}</a></h5>

                        <div class="col-xs-12">
                            <span>
                              <a href="{{ $demand->url }}" title="点击进入竞价对照商品页面" target="_blank" rel="nofollow" class="urlspan">  点此进入竞价对照商品链接网页</a>
                            </span>
                        </div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-xs-3 d-list-info">
                            <?
                            $statusd=$demand->getstatus();
                            ?>
                            <p><b>当前状态：</b>{{$statusd }}</p>
                            <p><b>竞价商家：</b><? if (count($demand->bids))
                                    echo '<b>' . count($demand->bids) . '</b>家';
                                else
                                    echo '--';?></p>

                                <p><b>距离结束：</b>{{$demand->getexptime()}}</p>


                            <p><b>起竞价格：</b>￥{{ $demand->price }}</p>
                            <p><b>最低竞价：</b>￥{{ $demand->getlowprice() }}</p>

                            @if( $statusd=='定金待付')
                                <a href="{{ URL::to('pay/deposit/'.$demand->id) }}" class="btn btn-warning" title="支付定金">支付定金 <i class="fa fa-angle-right"></i></a>
                            @elseif($statusd=='竞价中'  )
                                @if(count($demand->bids)>=1)
                                    <a href="{{ URL::to('demand/show/'.$demand->id) }}" class="btn btn-warning"   title="提前选标" >提前选标</a>
                                @else
                                    <a href="{{ URL::to('demand/show/'.$demand->id) }}" class="btn btn-warning"   title="提前选标" >查看</a>
                                @endif
                            @elseif($statusd=='待选标' && $demand->is_pay>0 )
                                <a href="{{ URL::to('demand/show/'.$demand->id) }}" class="btn btn-warning" title="选标/延时">选标/延时 <i class="fa fa-angle-right"></i></a>
                            @elseif($statusd=='待付款')
                                <a href="{{ URL::to('pay/demand/'.$demand->id) }}" class="btn btn-warning" title="支付尾款">支付尾款 <i class="fa fa-angle-right"></i></a>
                            @elseif($statusd=='待收货')
                                <input type="hidden" name="deid" value="{{ $demand->id }}">
                                <input type="submit" value=" 确认收货 " class="btn btn-warning"  onclick="this.form.action='/demand/shouhuo';">
                            @elseif($statusd=='已完成')
								<input type="hidden" name="deid" value="{{ $demand->id }}">
                                <input type="button" value="我要点评" class="btn btn-warning"  onclick="javascript:void(0);">
                            @endif
                        </div>
                    </form>
                </div>
                    @endforeach
                @else
                    <div class="row">
                        <div style="width: 400px;margin: 0px auto;margin-top: 40px;margin-bottom: 20px;" >
                     <img src="/images/noinfo.jpg"  style="width: 100px;height: 95px;margin-right: 40px;"  />  此状态下暂时没有订单哦
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop