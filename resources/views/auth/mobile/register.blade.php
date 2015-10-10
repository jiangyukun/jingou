<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>创建账号来接受和管理底价</title>
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
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/libs/ejs_production.js"></script>
    <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/topfooter.js?v=2015072901"></script>

</head>
<body>

<!-- Start of first page -->
<div>

<div class="header" data-position="fixed">
    <a href="javascript:" id="btnback" class="turnback">
        <i class="i-back"></i>返回</a>
    <h1>
        注册</h1>
</div>

<div data-role="content">
    <div class="account">
        <div class="account-form">
            <ul>
                <li><i class="i-form-2"></i>
                    <input type="text" class="inputtxt" id="phone" maxlength="11" placeholder="请输入手机号作为登录帐号"></li>
                <li class="input-yzm"><i class="i-form-3"></i>
                    <input type="text" class="inputtxt" placeholder="请输入确认码" id="checkcode" maxlength="6"></li>
                <li class="get-yzm"><span class="c-blue" id="get-yzm" data-hmclog="{pageid: 16, eventid: 66}">获取确认码</span></li>
                <li class="clear"></li>
                <li><i class="i-form-1"></i>
                    <input type="password" class="inputtxt" maxlength="16" placeholder="请设置长度为6-16位密码"
                           id="pwd"></li>
            </ul>
        </div>
        <div class="account-form account-uname">
            <ul>
                <li><i class="i-form-4"></i>
                    <input type="text" class="inputtxt" placeholder="您的姓名" id="name" maxlength="6"></li>
            </ul>
        </div>
        <div class="foot-btn">
            <a href="javascript:" class="main-btn" id="submitButton" data-hmclog="{pageid: 16, eventid: 67}">
                确定
            </a>
            <div id="log_regsuccess" style="display: none;"  data-hmclog="{pageid: 16, eventid: 68}"></div>
            <p class="no-message">
                <a href="javascript:" id="btnnomsg">无法收到确认码短信？</a></p>
        </div>
        <script src="/image.bitautoimg.com/bt/webtrends/dcs_tag_huimc.js" type="text/javascript"></script>
        <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/validate.js?v=20140804"></script>
        <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/ordersubmit.js?v=20140529"></script>
        <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/register.js?v=20150121"></script>

        <script type="text/javascript">
            //禁止滑动
            function stopwipe(e) {
                $(".mask").css({ "height": $(document).height() });
                $(".maskcontent").css("position", "fixed")
            }
            $(document).ready(function () {
                //配置全屏底色
                $(".account").css({ "background": "#f2f4f7" });
                $.register.init({
                    oid: "",
                    callback: function (data) {
                        if (data && data.IsSuccess && $.register.oid !== "") {
                            baiduStat.orderreg_suc();
                            $.aftersubmit.init({ o: $.register.oid });
                        } else {
                            baiduStat.navreg_suc();
                            pageChange("/transfer?re=/m.beijing.huimaiche.com/select");
                        }
                    }
                });
                $("#btnnomsg").click(function () {
                    $("#400mask").show();
                    $("#400mask").css({ "height": $(document).height() });
                });
                $("#btnmskcancel,#btnmsgcall,#btnsendccmask").click(function () {
                    $(".mask").hide();
                });

                window.addEventListener("resize", function () {
                    $(".mask").css({ "height": $(document).height() });
                }, false);

            });
        </script>
    </div>
</div>

    <div data-role="footer">
        <div class="footer">
            <div class="fl">
                <a href="/auth/login" data-hmclog="{pageid: 19, eventid: 41}">登录</a>
              </div>
            <div class="fr"><a href="/">首页</a></div>
        </div>
    </div>



    <script type="text/javascript">
    var cookie = readcookie("guideshowed");
    if (!cookie || cookie != "1") {
        $.ajax({
            type: "POST",
            url: "/Ajax/GetGuideStatus.ashx",
            data: {
                refer: document.referrer,
            },
            success: function (data) {
                if (typeof data !== "undefined" && data.CanShow) {
                    $('#guidemask').show();

                    var guide = new Swiper('#div_guide', {
                        autoplay:3000,
                        pagination: '#guide-pointer',
                        loop: true,
                        grabCursor: true,
                        paginationClickable: true,
                        calculateHeight: true
                    });
                    window.onorientationchange = function () {
                        var guide = new Swiper('#div_guide', {
                            calculateHeight: true
                        });
                    };

                    setCookie("guideshowed", "1", 30 * 24 * 3600);
                } else if (typeof data !== "undefined" && !data.CanShow) {
                    setCookie("guideshowed", "1");
                }
            }
        });
    }

    $(".guide-close").click(function () {
        $("#guidemask").hide();
    });
</script>

<script type="text/javascript">
    var ref = document.referrer;
    if (ref.indexOf("order") > -1) {
        $("#btnback").unbind("click").click(function () {
            if (ref.indexOf("t=") > 0) {
                ref = ref.replace(/t=\d+/g, "t=" + new Date().getTime());
            } else {
                ref = ref + (ref.indexOf("?") > -1 ? "&" : "?") + "t=" + new Date().getTime();
            }
            if (ref.indexOf("l=") < 0) {
                ref += "&l=1";
            }
            window.location.href = ref;
        });
    }
</script>
</div>
<!-- 切换弹层 -->
<div class="mask" id="400mask" style="display: none;">
    <div class="maskcontent">
        <div class="mask-cot">
            <p class="calltogetcode">
                使用本手机拨打<br />
                400-810-0053听确认码</p>
        </div>
        <div class="mask-btns">
            <a href="javascript:" class="c-link" id="btnmskcancel">取消</a> <a href="tel://4008100053"
                                                                             class="c-link" id="btnmsgcall">立即拨打</a>
        </div>
    </div>
</div>
<div class="mask" id="sendccmask" style="display: none;">
    <div class="maskcontent">
        <div class="mask-cot">
            <div class="default-txt">
                确认码已经发送到你的<span></span>手机<p class="small">
                    收不到短信，请拔打400-810-0053收听确认码</p>
            </div>
        </div>
        <div class="mask-btns">
            <a href="javascript:void(0);" id="btnsendccmask">关闭</a> <a href="tel://4008100053">立即拨打</a>
        </div>
    </div>
</div>
</body>
</html>
