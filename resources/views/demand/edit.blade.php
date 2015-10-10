@extends('layouts.master')
@section('title')
    {{Lang::get('layout.PostDemand')}} - @parent
@stop
@section('content')
    <div class="page-demand-post">
	    <div class="container">
            <div class="col-xs-3 side-bar"></div>
            <div class="col-xs-9 topics-show main-col">
                <div class="row">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/demand/post') }}" id="demand-post-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="col-xs-2">商品分类</div>
                            <div class="col-xs-2">
                                <select class="form-control" id="goods-cates-f" name="fCate">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <select class="form-control" id="goods-cates-s" name="sCate">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                            <div class="col-xs-2"></div>
                        </div>
                        <div class="form-group get-info">
                            <div class="col-xs-2">商品连接</div>
                            <div class="col-xs-8">
                                <input type="text" class="form-control" name="url" value="{{ old('url') }}" id="url">
                                <input type="hidden" name="isInfo" id="isInfo" value="0">
                            </div>
                            <div class="col-xs-2">
                                <button type="button" data-loading-text="获取中..." class="btn btn-success" id="getInfo">获取信息</button></div>
                        </div>
                        <div class="info-box col-xs-12" id="info-box">

                            <div class="form-group">
                                <div class="col-xs-2">{{ Lang::get('layout.Title') }}</div>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">{{ Lang::get('layout.Price') }}</div>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-2">{{ Lang::get('layout.Picture') }}</div>
                                <div class="col-xs-2" id="goods-img">
                                    <input type="hidden" class="form-control" name="thumb" id="thumb" value="{{ old('thumb') }}">
                                    <img src="{{ url("/img/blank.gif") }}" width="300" height="300" id="goods-pic">
                                </div>
                                <div class="col-xs-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-xs-2">{{ Lang::get('layout.EndTime') }}</div>
                                <div class="col-xs-8">
                                    <input type="text" class="form-control" name="expire_time" value="{{ old('title') }}" id="expire_time">
                                </div>
                            <div class="col-xs-2"></div>
                        </div>
                        <div class="form-group">
                                <div class="col-xs-2">{{ Lang::get('layout.Details') }}</div>
                                <div class="col-xs-8">
                                    <textarea type="text" class="form-control" name="details" rows="4">{{ old('details') }}</textarea>
                                </div>
                            <div class="col-xs-2"></div>
                            </div>
                        <div class="form-group">
                            <div class="col-xs-6 col-xs-offset-5">
                                <button type="submit" class="btn btn-primary">{{Lang::get('layout.Submit')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	    </div>
    </div>
@stop