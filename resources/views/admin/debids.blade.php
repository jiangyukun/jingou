@extends('admin.master')
@section('title')
    竞购管理 @parent
@endsection
@section('content')

<div class="panel panel-default">
    <div class="panel-heading"> 相关出价</div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>序号</th><th>商家名</th> <th>竞价时间</th><th>竞价时间</th><th>竞价价格</th><th>说明</th><th>链接</th><th>竞价状态</th><th>中标</th>
                </tr>
                </thead>
                <tbody>

@if( count($bids)>0 )
                @foreach ($bids as $bid)
                <tr class="success">
                    <td>{{$bid->id}}</td>
                    <td>{{$bid->user_id}}</td>
                    <td>{{$bid->details}}</td>
                    <td>{{$bid->price}}</td>
                    <td>{{$bid->url}}</td>
                    <td>{{$bid->is_win}}</td>
                    <td>{{$bid->created_at}}</td>
                    <td>{{$bid->details}}</td>
                    <td>{{$bid->updated_at}}</td>
                </tr>
                @endforeach

 @else
    <tr class="info">
    <td colspan="9">没有相关的竞价信息</td>
    </tr>
@endif
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.panel-body -->
</div>
@endsection