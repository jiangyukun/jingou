@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')

<div >

    <link rel="stylesheet" href="http://cdn.staticfile.org/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">



    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="http://cdn.staticfile.org/jquery/1.11.1-rc2/jquery.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="http://localhost:8022/js/jquery.validate.js"></script>
    <script src="http://localhost:8022/js/bootstrap-datepicker.min.js"></script>
    <script src="http://localhost:8022/js/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="http://localhost:8022/js/script.js"></script>




    <div class="header" style="">
        <a href="/" class="turnback"><i class="i-home"></i></a>
        <h1>发布竞购</h1>
        <a href="javascript:void(0);" class="add-car"><i class="i-add"></i>
        </a>
    </div>


    <div class="row" style="margin-top:10%;padding-left:5%;">
        <form class="form-horizontal" role="form" method="get"
              action="/demand/postadd" id="demand-post-form" novalidate="novalidate">
            <input type="hidden" name="_token" value="nHFne1ykXcWxvmyjerCQYu8Hmjc1NW7yxChu6lkj">

            <div class="form-group">

                <div class="col-xs-4">
                    <select class="form-control" id="goods-cates-f" name="fCate">
                        <option value="0">请选择</option>
                    </select>

                </div>
                <div class="col-xs-4">
                    <select class="form-control" id="goods-cates-s" name="sCate">
                        <option value="0">请选择</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select class="form-control" id="goods-cates-es" name="esCate">
                        <option value="0">请选择</option>
                    </select>
                </div>
            </div>
            <div class="form-group get-info">

                <div class="col-xs-8">
                    <input type="text" class="form-control" name="url" value="{{ old('url') }}" id="url">
                    <input type="hidden" name="isInfo" id="isInfo" value="0">
                </div>
                <div class="col-xs-2">
                    <button type="button" data-loading-text="获取中..." class="btn btn-success" id="getInfo_mb">获取信息</button></div>
            </div>
            <div class="info-box col-xs-12" id="info-box">

                <div class="form-group">

                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                    </div>
                    <div class="col-xs-2"></div>
                </div>

                <div class="form-group">

                    <div class="col-xs-4">
                        <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                    </div>
                    <div class="col-xs-2"></div>
                </div>
                <div class="form-group">

                    <div class="col-xs-10" id="goods-img">
                        <input type="hidden" class="form-control" name="thumb" id="thumb" value="{{ old('thumb') }}">
                        <img src="{{ url("/img/blank.gif") }}" width="300" height="300" id="goods-pic">
                    </div>
                    <div class="col-xs-2"></div>
                </div>
            </div>
            <div class="form-group">

                <div class="col-xs-8">
                    <select name="avltime" class="form-control">
                        <option>24</option>
                        <option>48</option>
                        <option>72</option>
                        <option>96</option>
                    </select>


                </div>
                <div class="col-xs-2"></div>
            </div>
            <div class="form-group">

                <div class="col-xs-10">
                    <textarea type="text" class="form-control" name="details" rows="4">{{ old('details') }}</textarea>
                </div>
                <div class="col-xs-2"></div>
            </div>
            <div class="form-group">
                <div class="col-xs-6 col-xs-offset-5">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>


</div>
@stop