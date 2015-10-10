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
                这里是商家的信息
            </div>

        </div>
    </div>
</div>
@stop