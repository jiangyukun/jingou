@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')


<style type="text/css">
    body { padding-bottom: 70px; }
</style>
<div class="header" data-position="fixed">
    <a href="javascript:" id="btnback" class="turnback">
        <i class="i-back"></i>返回</a>
    <h1>{{$demand->title}}</h1>
</div>



<div data-role="content">
<div class="car-detail">
    <div class="p-data">
        <a href="/photos">
            <img src="/{{$demand->thumb}}" >
        </a>


        <div class="change-car">
            <h2>
                <a href="javascript:void(0);" data-hmclog="{pageid: 3, eventid: 51}">{{$demand->title}}</a>
                <i class="i-link"></i>
            </h2>

            <p><del>起竞价格&nbsp;{{$demand->price}}</del></p>
        </div>



        <ul>

            <li><strong>
                    {{ $lowprice<9999999?$lowprice:'暂无' }}</strong>最低价</li>

            <li><strong> {{ count($demand->bids)?count($demand->bids):'暂无' }} </strong>竞价商家</li>

            <li><strong>
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

                    @endif</strong>当前状态</li>

        </ul>
    </div>



    <div class="line"></div> 


    <div id="svg_pt_line" class="line" style="">
    </div>
</div>
<!-- 购车须知参数配置购车分享 -->
<div class="p-tab">
    <p id="p-tab" class=""><span class="current" data-loaded="1">竞购说明</span></p>
</div>
<div class="p-tab-cot" style="display: block;">
        <div class="p-qa">

            <h2>竞购信息：</h2>

            <dl>
                <dt><i></i>当前状态：</dt>
                <dd>
                    <i></i>
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
                    &nbsp;
                </dd>
            </dl>


            <dl>
                <dt><i></i>竞价时间</dt>
                <dd>
                    <i></i><?php
                    if ($demand->paytime == "") echo "----";
                    else
                    {
                        $timediff = strtotime('now') - strtotime($demand->paytime);
                        $days = intval($timediff / 86400);
                        $remain = $timediff % 86400;
                        $hours = intval($remain / 3600);
                        $remain = $remain % 3600;
                        $mins = intval($remain / 60);
                        echo $days . "天 " . $hours . "小时" . $mins . "分钟";
                    }
                    ?></dd>
            </dl>

            <dl>
                <dt><i></i>距离结束</dt>
                <dd>
                    <i></i>{{$demand->getexptime()}}</dd>
            </dl>


            @if($myBid)
            <dl>
                <dt><i></i>我的竞价</dt>
                <dd>
                    <i></i><? if($myBid) echo $myBid->price;else echo "---"; ?>
                    @if($myBid->is_win)  <b class="rstt">中标</b>  @endif</dd>
            </dl>
            @endif
        </div>





</div>

<div class="p-tab">
        <p id="p-tab" class="">
            <span class="current" data-loaded="1">全部竞价</span>
        </p>
</div>
<div class="p-tab-cot" >
    <ul class="param" id="param-item">
        @if(isset($bids))
        @foreach($bids as $key=>$bid)
        <li>
            @if(isset(Auth::user()->id) && $demand->user->id==Auth::user()->id && ($demand->status=='待选标'||$demand->status=='竞价中'||$demand->status=='未选标') && $bid->is_win==0)
            <input type="radio" name="chose-win" class="chose-win" id="chose-win-{{ $bid->id }}" value="{{ $bid->id }}">
            @elseif($bid->is_win==1)
            <span class="glyphicon glyphicon-thumbs-up" style="color: #f01717;">√</span>
            @endif

            <span>{{$bid->user->username}}</span><strong> {{$bid->price}} </strong>



        </li>
        @endforeach
        @else

        <li><span>暂无商家参与竞标 </span> </li>
        @endif

    </ul>
</div>


<div class="p-tab">
    <p id="p-tab" class=""><span class="current" data-loaded="1">我的竞价</span></p>
</div>

<div class="line"></div>

@if( isset(Auth::user()->id) &&  Auth::user()->id == $demand->user_id )
        @include('demand.mobile.buyer')

@else
    @include('demand.mobile.bidder')
@endif




<div class="line">
</div>

<div class="service">
    <div class="service-title">
       51竞购</div>
    <div class="service-phone">
        <div>
            <a href="tel://4000591591">杭州竟商网络有限公司 </a><p>
                周一至周日(9:00 - 21:00)</p>
        </div>
        <a href="tel://4000591591" class="telbg"><i class="i-greenphone"></i>拨打电话</a>
    </div>
</div>


<div class="line"></div>
</div>


<script>
    function Win(){
        $.post('/demand/win',{"_token" : $(document).find( 'input[name=_token]' ).val(),id:$('input:radio[name=chose-win]:checked').val()},
            function(data){
                location.reload();
            }
        );
    }

</script>


<script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/timerg.js?v=2015052108"></script> 
<script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/cardetail.js?v=2015072901"></script>
<script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/carsourcead.js?v=2015052108"></script>
<script type="text/javascript" src="/img.huimaiche.com/web/ad/WapCarSource_201.js?v=201508131703"></script>

@stop
