@extends('layouts.master')
@section('title')
{{$demand->title}} - 竞购详情 - @parent
@stop
@section('content')
<div class="page-demand-show">
    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li>当前位置：</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/demand/list">竞价列表</a></li>
                    <li class="active">选择竞价</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="row">

<form role="form" action="/demand/choose/{{$demand->id}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">



    @if(count($avlbids)>0)




            <div class="row">
                <div class="col-lg-2">
                    <!-- /.col-lg-4 -->
                </div>
                <div class="col-lg-8">
                    <div class="panel panel-red" style="border-radius:0px;">
                        <div class="panel-heading" style="border-radius:0px;"> 温馨提醒</div>
                        <div class="panel-body">
                            <p>
                                {{$user->username}}先生,你好,在这个竞购中,目前的商家竞价中,<br />
                            @foreach ($avlbids as $bid)
                                商家{{$bid->username}}的报价为{{$bid->price}},<br />
                            @endforeach
                                均低于起竞价格10%,按竞购规则,
                                此次竞购有效,您若选择放弃,将被没收定金,您确定吗?
                            </p>
                        </div>
                        <div class="panel-footer" style="text-align: center;">
                            <input type="hidden" name="deid" value="{{$demand->id}}">
                            <button type="button" onclick="javascript:history.back();" class="btn  btn-success btn-lg">返回上一页</button> &nbsp;&nbsp;&nbsp;
                            <button type="submit" class="btn  btn-success btn-lg">确定放弃</button>
                        </div>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <div class="col-lg-2">
                </div>
            </div>
    @else
    <div class="row">
        <div class="col-lg-2">
            <!-- /.col-lg-4 -->
        </div>
        <div class="col-lg-8">
            <div class="panel panel-red" style="border-radius:0px;">
                <div class="panel-heading" style="border-radius:0px;"> 温馨提醒</div>
                <div class="panel-body">
                    <p>
                        {{$user->username}},先生,你好,是不是目前暂时没有您满意的商家竞价,所以您选择放弃,那您可以考虑申请延时.
                    </p>
                </div>
                <div class="panel-footer" style="text-align: center;">
                    <button type="button" onclick="javascript:history.back();" class="btn  btn-success btn-lg">确定放弃</button> &nbsp;&nbsp;&nbsp;
                    <a href="/demand/delay/{{$demand->id}}" class="btn  btn-success btn-lg" style="color: #fff;">我要延时</a>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    @endif
        </div>

 </form>


    </div>
    <!-- /.container -->
</div>
@stop