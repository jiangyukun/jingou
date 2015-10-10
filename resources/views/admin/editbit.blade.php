@extends('admin.master')
@section('title')
编辑竞价 @parent
@endsection
@section('content')




<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6  col-lg-offset-1">
                        <div class="row">
                            <div class="col-lg-12"><h4 class="page-header">竞价详细信息</h4></div>
                            <!-- /.col-lg-12 -->
                        </div>


                        <form role="form" action="/admin/savebid/{{$bid->id}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group"><label>订单编号</label>
                                <input class="form-control" name="sn" value="{{$bid->sn}}">
                            </div>
                            <div class="form-group"><label>竞价用户</label>
                                <input class="form-control"   value="{{$bid->user->username}}" disabled>
                            </div>

                            <div class="form-group"><label>价格</label>
                                <input class="form-control" name="price" value="{{$bid->price}}">
                            </div>
                            <div class="form-group"><label>商品地址</label>
                                <input class="form-control" name="url" value="{{$bid->url}}">
                            </div>
                            <div class="form-group"><input type="checkbox"   name="is_win" @if($bid->is_win) checked @endif   value="1">中标</div>
                            <div class="form-group"><label>详情</label>
                                <textarea class="form-control" name="details" >{{$bid->details}}</textarea>
                            </div>
                            <div class="form-group"><label>IP:{{$bid->ip}} </label>
                            </div>

                            <button type="submit" class="btn btn-success">保存</button>
                            <button type="button" onclick="history.back();" class="btn btn-default">返回</button>
                        </form>






                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
