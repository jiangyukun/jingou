@extends('layouts.master')
@section('title')
    @parent
@stop
@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #b0bec5;
            font-weight: 100;
        }

        .container {
            text-align: center;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>
    <div class="page-error">
        <div class="container">
            <div class="content">
                <div class="title">404 Not Found.</div>
                <div id="ShowDiv"></div>
            </div>
        </div></div>
    <script type="text/javascript">
        var secs = 2; //倒计时的秒数
        for(var i=secs;i>=0;i--)
        {
            window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000);
        }
        function doUpdate(num)
        {
            document.getElementById('ShowDiv').innerHTML = num+'秒后自动跳转到首页' ;
            if(num == 0) { window.location = "/"; }
        }
    </script>
@stop