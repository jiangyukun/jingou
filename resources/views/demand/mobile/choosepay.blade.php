<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>惠买车</title>
    <link rel="stylesheet" href="/img.huimaiche.cn/uimg/m/v20150713/css/style.css?v=10163">
    <link rel="stylesheet" href="/img.huimaiche.cn/uimg/m/v20150713/css/common.css?v=1016778">
    <link rel="stylesheet" href="/img.huimaiche.cn/uimg/m/v20150713/css/usercenter.css?v=101677">
    <script src="/img.huimaiche.cn/uimg/m/v20141031/js/uc/jquery-1.9.1.min.js?v=1"></script>
    <script src="../JS/common.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/validate.js"></script>
    <script type="text/javascript" src="../js/switchery.min.js"></script>
    <script type="text/javascript" src="../js/payable.js?v=908"></script>
    <script type="text/javascript" src="/www.huimaiche.com/js/hmt_timestamp.js?v=20140826"></script>
    <script type="text/javascript">
        $(function () {
            $.payable.init({
                orderID: "5834935",
                paytime: "7天",
                carCount: "-1",
                carColor: "",
                loginUrl: "/m.huimaiche.com/login?re=http%3a%2f%2fm.huimaiche.com%2ftransfer%3fre%3dhttp%253a%252f%252fi.m.huimaiche.com%253a80%252forder%252fPayable.aspx%253foid%253d5834935%2526cp%253dHRJa8nZlMOM!%2526relogin%253d1",
                subscription: "499",
                urlParam: "?oid=5834935&cp=HRJa8nZlMOM!"
            });
        });
    </script>

     </head>
<body>
<div>
<form method="post" action="Payable.aspx?oid=5834935&amp;cp=HRJa8nZlMOM!" id="form1">
<div class="aspNetHidden">
    <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKLTkzNzkzNjYyN2RkuigROGq8RE35eTpmzgeDje+79dg=">
</div>

<div class="header" style="">
    <a href="List.aspx" class="turnback"><i class="i-back"></i>我的车</a>
    <h1>
        预付订金到惠买车</h1>
</div>
<div data-role="content">
    <div class="subscription card-detail">

        <div class="car-card">
            <div class="car-pic">
                <img src="/www.huimaiche.com/orderPhoto/113516/8157_6/" alt=""></div>
            <div class="car-short-info">
                <h2>
                    2015款 速腾 1.4T 双离合 230TSI 舒适型</h2>
                <p class="cgray">厂商指导价：16.08万</p>
            </div>
            <div class="car-info">

                <span>生效时间：</span><strong>2015/8/15 17:40:41</strong>
                <br><span>买车计划：</span><strong>7日内购车</strong>
                <br> <span>外观颜色：</span><strong>雅士银</strong>

                <br><span>买车方式：</span><strong>全款买车</strong>

                <br><span>上牌城市：</span><strong>潍坊</strong>

            </div>
            <div class="card-switch">
                <i class="i-bg-0"></i>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $(".card-switch").on("click", function () {
                    if ($(".car-info").css("display") == "none") {
                        $(".car-info").show(200);
                        $(this).find("i").addClass("up");
                    } else {
                        $(".car-info").hide(200);
                        $(this).find("i").removeClass("up");
                    }
                    return false;
                })
            })
        </script>

        <div class="order-money">
            <strong>订金金额</strong> <span>￥499
                    </span><del></del>
        </div>
        <div id="payTypeDivLine" class="line">
        </div>
        <div id="payTypeDiv" class="choose-pay-type">
            <dl>

                <dt>支付方式</dt>
                <dd>
                    <i class="ali"></i>
                    <h3>
                        支付宝网页版支付</h3>
                    <i class="choose on" pt="3" style="display: none"></i>
                </dd>

            </dl>
        </div>
        <div class="line" id="line-voucher" style="display: none">
        </div>
        <div class="switch-voucher" style="display: none">
            <div class="switch-voucher-title">
                <strong>使用易车优惠券</strong>
                <div class="base-switch">
                    <input type="checkbox" id="switch-input" class="js-switch" checked="checked"></div>
            </div>
            <div class="voucher-cot">
                <ul>
                </ul>
                <p>
                    优惠券可抵购车款，退款时优惠券会自动退回</p>
            </div>
        </div>
        <div class="line">
        </div>
        <div id="hasPayDiv" class="pay-immediate">
            <div class="price-txt">
            </div>
            <div class="btn">
                <a id="btnPay" href="javascript:void(0);" class="main-btn" data-hmclog="{ pageid: '5', eventid: '60'}">
                    立即支付</a>
            </div>
            <div id="payTip" class="pay-ts">请在7天内完成付款，否则您的订单将自动取消</div>
            <ul>
                <li><i class="ri"></i>预付到惠买车</li>
                <li><i class="ri"></i>支持随时退</li>
                <li><i class="ri"></i>可抵购车款</li>
            </ul>
        </div>
        <div id="noPayDiv" class="pay-immediate" style="display: none;">
            <div class="price-txt">
                实际支付：<strong class="c-gray">￥499</strong>
            </div>
            <div class="btn">
                <a class="main-btn disabled" href="javascript:void(0)">卖光了</a></div>
            <div id="payTip2" class="pay-ts">
                <a href="">选择其他车款</a> 或 <a href="OrderCancel.aspx?oid=5834935&amp;cp=HRJa8nZlMOM!">
                    取消购车</a><br>
                尽快下单并支付才能够抢到
            </div>
            <ul>
                <li><i class="ri"></i>预付到惠买车</li>
                <li><i class="ri"></i>支持随时退</li>
                <li><i class="ri"></i>可抵购车款</li>
            </ul>
        </div>
        <div class="line">
        </div>

        <script type="text/javascript" src="giftInterface/Js/GiftCommon.js?v=20150319"></script>
        <script>
            $(function () {
                try {
                    Gift.init("0798159ef2183771", 4, "giftDivID","");
                }
                catch (e) { }
            });
        </script>
        <div id="giftDivID" class="car-card c1" style=""><div class="car-pic">    <img alt="" src="/image.huimaiche.cn/gift/8b557881-ef04-41bf-a64d-ada5bc5187e2.jpg"></div><div class="car-short-info">    <p class="lead">        您已获得购车礼品1188元新车专属大礼包！，完成购车即可领取。</p>    <p class="txt">        <a href="/hd.huimaiche.com/hd/201508" target="_blank">查看活动</a></p></div></div>

        <div class="line">
        </div>

        <script type="text/javascript" src="/www.huimaiche.com/js/hmt_timestamp.js?v=20140826"></script>
        <div class="pay-consist">
            <ul id="ulCarLink">
                <li><a href="/m.huimaiche.com/carparam?carid=113516&amp;re=http%253a%252f%252fi.m.huimaiche.com%253a80%252forder%252fPayable.aspx%253foid%253d5834935%2526cp%253dHRJa8nZlMOM!"><strong>车型参数</strong> </a><i class="i-link"></i>
                </li>
                <li><a href="/m.huimaiche.com/photogroup?carid=113516&amp;re=http%253a%252f%252fi.m.huimaiche.com%253a80%252forder%252fPayable.aspx%253foid%253d5834935%2526cp%253dHRJa8nZlMOM!"><strong>车型图片</strong> </a><i class="i-link"></i>
                </li>

            </ul>
        </div>
        <div class="line"></div>
        <script>
            (function () {
                if (true) {

                }
                else{
                    $("#ulCarLink_li2").remove();
                }
                var version = +new Date();
                if (window.hmc_timestamp)
                    version = window.hmc_timestamp.timestamp;
                var url = "/img.huimaiche.com/web/pt/6/113516/113516_Curves.png?v=" + version;
                var img = new Image();
                img.src = url;
                img.style.width = "100%";
                img.onerror = function () {
                    $("#ulCarLink_li2").remove();
                }
            })();
        </script>

        <div class="s-block nobdt">
            <p class="btn-block"><a href="OrderCancel.aspx?oid=5834935&amp;cp=HRJa8nZlMOM!" class="cancel">取消买车</a></p>



            <p>惠买车为您服务</p>
            <p><span>4000-591-591</span> 周一至周日(9:00 - 21:00)</p>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".footer-bar span").on("click", function () {
            $("html, body").animate({
                scrollTop: 0
            }, 300);
        });
    });
</script>

<div>
    <div class="footer">
        <div class="fl">
            <a id="footlist" class="footlist" href="../Order/List.aspx">我的车</a>
            <a href="/www.huimaiche.com/index.aspx?viewPc=1" rel="external">电脑版</a>
            <a href="/www.huimaiche.com/app">下载APP</a>
        </div>
        <div class="fr">
            <a href="/m.huimaiche.com/guide" class="buy-guide">买车指南</a>
        </div>
    </div>
</div>

<script src="../JS/footer.js" type="text/javascript"></script>

</form>
<form id="zf_PayForm" action="PayJump.aspx?oid=5834935&amp;cp=HRJa8nZlMOM!" method="post">
    <input id="zf_pu" type="hidden" name="zf_pu" value="">
</form>
<form id="wx_PayForm" action="/wxpay.huimaiche.com/pay/order?oid=5834935&amp;cp=HRJa8nZlMOM!" method="post">
    <input id="wx_appId" type="hidden" name="wx_appId" value="">
    <input id="wx_timestamp" type="hidden" name="wx_timestamp" value="">
    <input id="wx_noncestr" type="hidden" name="wx_noncestr" value="">
    <input id="wx_package" type="hidden" name="wx_package" value="">
    <input id="wx_signType" type="hidden" name="wx_signType" value="">
    <input id="wx_paySign" type="hidden" name="wx_paySign" value="">
</form>
</div>
</body>
</html>