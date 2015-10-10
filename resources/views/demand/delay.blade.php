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
                    <li class="active">竞价延时</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

    <!-- Page Content -->
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <form role="form" action="?time=<?echo strtotime("now");?>" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>请选择延时的时间单位(小时)</label>
                <select name="delaytime" class="form-control">
                    <option>24</option>
                    <option>36</option>
                    <option>48</option>
                    <option>60</option>
                    <option>72</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">保存</button>
            <button type="button" onclick="window.history.back();"  class="btn btn-success">取消</button>
        </form>
    </div>
    <div class="col-lg-3"></div>

    <!-- /.container -->
        </div>
</div>
@stop