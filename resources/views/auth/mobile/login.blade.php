

<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录账号</title>
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link rel="shortcut icon" type="image/x-icon" href="/www.huimaiche.com/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/www.huimaiche.com/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="/img.huimaiche.cn/uimg/m/v20150730/images/iconweb.png" />
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/common.css?v=2015051201" rel="stylesheet" type="text/css">
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/style.css?v=2015051201" rel="stylesheet" type="text/css">
    <link href="/img.huimaiche.cn/uimg/m/v20150730/css/idangerous.swiper.css?v=20150413" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/libs/idangerous.swiper-2.1.min.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/common.js?v=20141032"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/libs/json2_min.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/topfooter.js?v=2015072901"></script>


</head>
<body>
<div class="common-down" id="common-down-div" style="display:none">
    <span id="common-down-close">&nbsp;</span>
    <p>获取底价更实时<br>底价更方便</p>
    <a href="javascript:void(0);" data-hmclog="{pageid: 19, eventid: 69}" id="a_openapp">立即打开</a>
</div>

<!-- Start of first page -->
<div>

    <div class="header" data-position="fixed">
        <a href="javascript:" id="btnback" class="turnback">
            <i class="i-back"></i>返回</a>
        <h1>登录</h1>
    </div>



    <div data-role="content">
        <div class="etzone">
        </div>
        <div class="account">

            <div class="login-padding">
            </div>



            <form class="form-horizontal" role="form" method="POST" action="{{ isset($_REQUEST['refe']) ? url('/auth/login').'?refe='.$_REQUEST['refe'] : url('/auth/login') }}" id="login-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">


            <div class="account-form">
                <ul>
                    <li><i class="i-form-4"></i>
                        <input type="text" class="inputtxt" maxlength="60" name="username" id="phone" placeholder="邮箱/手机/用户名" value=""></li>
                    <li><i class="i-form-1"></i>
                        <input type="password" maxlength="21" class="inputtxt" name="password" id="pwd" placeholder="请输入密码"></li>
                </ul>
            </div>



            <div class="foot-btn" style="border-top: 0;">

                <button type="submit"  class="main-btn">{{Lang::get('layout.Login')}}</button>

                <div id="log_loginsuccess" style="display: none;"  data-hmclog="{pageid: 15, eventid: 63}"></div>
            </div>


            </form>

            <div class="account-tips forgetps">
                <p>
                    <a href="/auth/retrieve"
                       data-hmclog="{pageid: 15, eventid: 64}">忘记密码？</a>
                    <a href="/auth/register"
                       data-hmclog="{pageid: 15, eventid: 65}" id="register">注册帐号</a>
                </p>
            </div>
        </div>
        <script src="/image.bitautoimg.com/bt/webtrends/dcs_tag_huimc.js" type="text/javascript"></script>
        <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/login.js?v=20150121"></script>
        <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/ordersubmit.js?v=20141103"></script>
        <script src="/img.huimaiche.cn/uimg/m/v20150730/js/www/validate.js?v=20140804"></script>
        <script type="text/javascript">
            (function(){
                if(0 && 0){
                    $("#register").hide();
                }
            })();

            $(document).ready(function () {
                $.login.init({
                    callback: function (data) {
                        if (data && data.IsSuccess) {
                            if ("" !== "") {
                                $.aftersubmit.init({ o: "" });
                            }  
                        }
                    }
                });
            })
        </script>
    </div>

    <div data-role="footer">
        <div class="footer"> 
            <div class="fl">
			<a href="/auth/login" data-hmclog="{pageid: 19, eventid: 58}">登录</a>
            <a href="/auth/register" data-hmclog="{pageid: 19, eventid: 59}">注册</a>
			</div>
            <div class="fr"><a href="/">首页</a></div>
        </div>
    </div>

</div>
</body>
</html>
