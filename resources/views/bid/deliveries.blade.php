@extends('layouts.master')
@section('title')
我的竞购 - @parent
@stop
@section('content')

<div class="page-demand-my">
    <div class="container">
        @include('bid.leftm')
        <div class="col-xs-9">
            <div class="row">


                @if (count($delis))
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>



                        <tr   align="center">
                            <td>快递公司</td>
                            <td>快递单号</td>
                            <td width="100">快递状态</td>
                            <td width="150">发货时间</td>
                            <td width="120">订单</td>
                        </tr>


                        @foreach ($delis as $deli)

                        <tr align="center">
                            <td>{{$deli->types}}</td>
                            <td title="快递追踪"><a href="javascript:void(0);" class="t">{{$deli->numbers}}</a></td>
                            <td><span style="color:#888888;">未知</span></td>
                            <td>{{$deli->created_at}}</td>
                            <td><a href="/demand/show/{{$deli->deid}}" class="t">查看</a></td>
                        </tr>

                        @endforeach

                        </tbody>
                    </table>
                @else
                    <div class="row">
                        暂无物流信息
                    </div>

                @endif

            </div>

        </div>
    </div>
</div>

@stop