@extends('admin.master')
@section('title')
用户管理 @parent
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                用户列表
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <form method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="25"><input type="checkbox" onclick="checkall(this.form);"></th>
                            <th>编号</th> <th>用户名</th> <th>用户类型</th> <th>手机号码</th> <th>用户认证</th> <th>注册日期</th> <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if (count($users))
                        @if($i=0) @endif
                        @foreach($users as $user)
                        <tr class="{{$i==0?' odd':' even'}}" role="row">
                            <td><input type="checkbox" name="itemid[]" value="{{$user->id}}" class=""></td>
                            <td class="sorting_1">{{$user->id}}</td>
                            <td class="center">{{$user->username}}</td>
                            <td class="center">@if($user->hasRole('admin'))管理员@elseif($user->hasRole('bidder'))商家@else客户@endif</td>
                            <td class="center">{{$user->mobile}}</td>
                            <td class="center">
                                @if ($user->valid ==1)  已认证 @else 未认证 @endif
                            </td>
                            <td class="center">{{$user->created_at}}</td>
                            <td class="center">
                                <a href="{{url('admin/user/'.$user->id)}}"  ><i class="fa fa-list"></i></a>
                                <a href="{{url('admin/d_user/'.$user->id)}}" onclick="return confirm('确定删除？')"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        @if($i=1) @endif
                        @endforeach
                        @else
                        <tr class="odd">
                            <td class="center">暂无信息</td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                        </tr>
                        @endif
                        </tbody>
                    </table>

                <!-- /.table-responsive -->

<table class="table table-striped table-bordered table-hover">
                <tr>
                    <td colspan="6">
                            <select name="audit" onchange="this.form.submit();">
                            <option value="0">审核商户</option>
                            <option value="0">取消</option>
                            <option value="1">资料认证通过</option>
                            <option value="2">2 级</option>
                        </select>&nbsp;

                    </td>
                </tr>
</table>

                </div>

                </form>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-xs-12 -->
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
@endsection