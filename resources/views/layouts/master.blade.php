@section('title')
    {{$settings['site_name']}}
@endsection
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- 新 Bootstrap 核心 CSS 文件 --> 
    <link rel="stylesheet" href="{{ url('/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker.min.css') }}">
    <link href="{{ url('/css/modern-business.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.staticfile.org/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var url = this.location.href;
    </script>
</head>
<body>
<style>

    .fs14 { font-size: 14px;}
    .fs15 { font-size: 15px;}
    .mt20 {margin-top: 20px;} 
</style>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand logo-index" href="#"    hidefocus="true"  >{{$settings["site_name"]}}</a>
            <h4>{{$settings["site_subhead"]}}</h4>
        </div>

        <div>
            <ul class="nav navbar-nav navbar-main">
                <li><a href="{{ url('/') }}"  hidefocus="true"  >{{Lang::get('layout.Home')}}</a></li>
                @if(isset(Auth::user()->id) && Auth::user()->hasRole('bidder'))
                    <li><a href="{{ URL::to('bid/my/all') }}"  hidefocus="true" >我的竞价</a></li>
                @else
                    <li><a href="{{ URL::to('demand/post') }}" hidefocus="true" >{{Lang::get('layout.PostDemand')}}</a></li>
                @endif
                <li><a href="{{ URL::to('demand/list') }}" hidefocus="true" >{{Lang::get('layout.Demanding')}}</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/auth/login') }}" id="link-login"   hidefocus="true"  >{{Lang::get('layout.Login')}}</a></li>
                    <li><a href="{{ url('/auth/register') }}"  hidefocus="true"  >{{Lang::get('layout.Register')}}</a></li>
                    <li class="service-phone">{{Lang::get('layout.ServicePhone')}}{{$settings["service_phone"]}}</li>
                @else
                    <li>
                        <a href="{{isset(Auth::user()->id) && Auth::user()->hasRole('admin') ? url('/admin/index') : (Auth::user()->hasRole('bidder')?url('/bid/my'):url('/demand/my')) }}"   hidefocus="true"  >{{ Auth::user()->username }}</a>
                    </li>
                    <li><a href="{{ url('/auth/logout') }}"   hidefocus="true"  >{{ Lang::get('layout.Logout') }}</a></li>
                    <li class="service-phone">{{Lang::get('layout.ServicePhone')}}{{$settings["service_phone"]}}</li>
                @endif
            </ul>
        </div>
    </div>
</nav>


@yield('content')
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a href="#"   hidefocus="true"  >关于我们</a> 
				<a href="#"   hidefocus="true"  >加入51竞购</a> 
				<a href="#"  hidefocus="true"  >联系我们</a>
                <span>Copyright &copy; 2015 www.51jinggou.com All Rights Reserved</span>
                <span>杭州竟商网络有限公司 浙ICP备09032634</span>
            </div>
        </div>
    </div>
</div>
<a href="#" id="back-to-top"><i class="fa fa-angle-up"></i></a>
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.staticfile.org/jquery/1.11.1-rc2/jquery.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{ url('/js/jquery.validate.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('/js/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
@yield('script')
<script src="{{ url('/js/script.js') }}"></script>

@if (count($errors) > 0)
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content alert-danger alert">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                <p class="">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript">
        $('#errorModal').modal('show');
    </script>
@endif
</body>
</html>