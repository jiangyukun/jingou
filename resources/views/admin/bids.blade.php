@extends('admin.master')
@section('title')
    竞价管理 @parent
@endsection
@section('content')
    <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                竞价列表
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">


                                    <div class="dataTable_wrapper">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>单号</th>
                                                <th>竞购单</th>
                                                <th>起竞价</th>
                                                <th>报价</th>
                                                <th>用户</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if (count($bids))
                                            @if($i=0) @endif
                                            @foreach($bids as $bid)
                                                <tr class="{{$i==0?' odd':' even'}}" role="row">
                                                    <td class="sorting_1">{{$bid->sn}}</td>
                                                    <td>{{$bid->demand->title}}{{$bid->demand->price}}</td>
                                                    <td>{{$bid->demand->price}}</td>
                                                    <td class="center">{{$bid->price}}</td>
                                                    <td class="center"><a href="{{url('admin/user/'.$bid->user->id)}}" title="管理该用户">{{$bid->user->username}}</a></td>
                                                    <td class="center">

                                                        <a href="{{url('admin/e_bid/'.$bid->id)}}" ><i class="fa fa-list"></i></a>
                                                        <a href="{{url('admin/d_bid/'.$bid->id)}}" onclick="return confirm('确定删除？')"> <i class="fa fa-times"></i> </a> </td>
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
                                    </div>
                                <!-- /.table-responsive -->

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