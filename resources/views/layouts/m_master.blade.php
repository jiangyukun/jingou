@section('title')
{{$settings['site_name']}}
@endsection
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <title>{{$settings['site_name']}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="/www.huimaiche.com/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/www.huimaiche.com/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="/img.huimaiche.cn/uimg/m/v20150730/images/iconweb.png" />
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/common.css?v=2015051201" rel="stylesheet" type="text/css">
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/style.css?v=2015051201" rel="stylesheet" type="text/css">
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/idangerous.swiper.css?v=20150413" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/libs/idangerous.swiper-2.1.min.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/common.js?v=20141032"></script>
</head>
<body>



    @yield('content')

<div data-role="footer">
    <div class="footer">
        <div class="fl">

@if (Auth::guest())
<a href="{{ url('/auth/login') }}" id="link-login" >{{Lang::get('layout.Login')}}</a>
<a href="{{ url('/auth/register') }}">{{Lang::get('layout.Register')}}</a>
@else
<a href="{{isset(Auth::user()->id) && Auth::user()->hasRole('admin') ? url('/admin/index') : (Auth::user()->hasRole('bidder')?url('/bid/my'):url('/demand/my')) }}">
    {{ Auth::user()->username }}</a>
<a href="{{ url('/auth/logout') }}">{{ Lang::get('layout.Logout') }}</a>
@endif

        </div>
        <div class="fr">
            <a href="/">首页</a>&nbsp;
            <a href="/">杭州竞商科技有限公司2015 copyright</a>
        </div>
    </div>
</div>

<div class="gotop"></div>
    <script>
   $("#btnback").click(function () {
                window.history.go(-1);
        });



   $(".gotop").on("click", function () {
       $("html, body").animate({scrollTop: 0}, 300);
   });
   function goTop() {
       $('html, body').animate({ scrollTop: 0 }, 200);
   }





    </script>

</body>
</html>