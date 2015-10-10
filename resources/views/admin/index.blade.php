@extends('admin.master')
@section('title')
    首页 @parent
@endsection
@section('content')
<h1 class="page-header">@yield('title')</h1>
    <div class="row">
        <div class="col-xs-3 col-xs-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-shopping-cart fa-5x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$counts['demand']}}</div>
                            <div>竞购总数</div>
                        </div>
                    </div>
                </div>
                <a href="demands">
                    <div class="panel-footer">
                        <span class="pull-left">查看详情</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3 col-xs-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-tasks fa-5x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$counts['bid']}}</div>
                            <div>竞价总数</div>
                        </div>
                    </div>
                </div>
                <a href="bids">
                    <div class="panel-footer">
                        <span class="pull-left">查看详情</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xs-3 col-xs-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="fa fa-user fa-5x"></i></div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$counts['user']}}</div>
                            <div>用户总数</div>
                        </div>
                    </div>
                </div>
                <a href="users">
                    <div class="panel-footer">
                        <span class="pull-left">查看详情</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
