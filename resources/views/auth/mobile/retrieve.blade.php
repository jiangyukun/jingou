<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改密码</title>
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
            使用手机找回密码</h1>
    </div>



    <div data-role="content">
        <div class="etzone">
        </div>
        <div class="account">
            <div class="findpsw">
            </div>
            <div class="account-form no-bdb">
                <ul>
                    <li><i class="i-form-2"></i>
                        <input type="text" class="inputtxt" id="phone" maxlength="11" placeholder="请输入手机号">
                    </li>
                    <li class="input-yzm"><i class="i-form-3"></i>
                        <input type="text" class="inputtxt" placeholder="请输入确认码" id="checkcode" maxlength="6">
                    </li>
                    <li class="get-yzm"><span class="c-blue" id="get-yzm">获取确认码</span></li>
                    <li class="clear"></li>
                    <li><i class="i-form-1"></i>
                        <input type="password" class="inputtxt" maxlength="16" id="pwd" placeholder="请输入6-16位新密码">
                    </li>
                </ul>
            </div>
            <div class="foot-btn">
                <a href="javascript:" class="main-btn" id="submitButton">设置新密码</a>
                <p class="no-message">
                    <a href="/m.qichetong.com/authenservice/aboutpassword/retrievepassword.aspx" >通过账号或者邮箱找回密码</a>
                </p>
            </div>
            <script src="/image.bitautoimg.com/bt/webtrends/dcs_tag_huimc.js" type="text/javascript"></script>
            <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/validate.js?v=20140515"></script>
            <script type="text/javascript" src="/img.huimaiche.cn/uimg/m/v20150730/js/www/retrieve.js?v=20141106"></script>
            <script type="text/javascript">
                //禁止滑动
                function stopwipe(e) {
                    $(".mask").css({ "height": $(document).height() });
                    $(".maskcontent").css("position", "fixed")
                }

                $(document).ready(function () {
                    $.retrieve.init({
                        callback: function (data) {
                            pageChange("/login?re=%2ftransfer%3fre%3dhttp%3a%2f%2fm.beijing.huimaiche.com%2f");
                        }
                    });
                    $("#btnmskcancel,#btnmsgcall,#btnsendccmask,#btnSuccesscmask").click(function () {
                        $(".mask").hide();
                    });
                    window.addEventListener("resize", function () {
                        $(".mask").css({ "height": $(document).height() });
                    }, false);
                });
            </script>
        </div>
    </div>


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




    <div data-role="footer">
        <div class="footer">
            <div class="fl">

			 <a href="/auth/login" data-hmclog="{pageid: 19, eventid: 58}">登录</a>
            <a href="/auth/register" data-hmclog="{pageid: 19, eventid: 59}">注册</a> 
		 
			</div>
            <div class="fr">   <a href="javascript:void(0);">电脑版</a></div>
        </div>
    </div>



</div>
<!-- 切换弹层 -->
<div class="mask" style="display: none;" id="nomsgmask">
    <div class="maskcontent">
        <div class="mask-cot">
            <p class="calltogetcode">
                使用本手机拨打<br />
                400-000-0053听确认码</p>
        </div>
        <div class="mask-btns">
            <a href="javascript:" class="c-link" id="btnmskcancel">取消</a>
            <a href="tel://40080000" class="c-link" id="btnmsgcall">立即拨打</a>
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

<div class="mask" style="display: none;" id="retrievemask">
    <div class="maskcontent">
        <div class="mask-cot">
            <p class="calltogetcode">找回密码成功</p>
        </div>
        <div class="mask-btns">
            <a href="javascript:void(0);" id="btnSuccesscmask">关闭</a>
            <a href="/auth/login/">立即登录</a>
        </div>
    </div>
</div>
</body>
</html>
