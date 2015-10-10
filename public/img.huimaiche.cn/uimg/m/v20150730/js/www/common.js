var baiduStat = {
    isDebug: true,
    eventName: "_trackEvent",
    exec: function (event_args) {
        try {
            if (!this.isDebug && event_args && event_args.constructor === Array)
                _hmt.push(event_args);
        } catch (e) {
        }
    },
    home_search: function () { this.exec([this.eventName, 'm_开始下单', 'm_首页', 'm_点击-搜索框', '']); },
    home_select: function () { this.exec([this.eventName, 'm_开始下单', 'm_首页', 'm_点击-首页下方', '']); },
    cardetail_buy: function () { this.exec([this.eventName, 'm_订单底价买车', 'm_商品详情页', 'm_点击-订单底价买车', '']); },
    order_submit: function () { this.exec([this.eventName, 'm_订单填写详情', 'm_订单提交页', 'm_点击-订单填写详情', '']); },
    order_subSuc: function () { this.exec([this.eventName, 'm_订单提交成功', 'm_订单提交页', 'm_成功-订单提交', '']); },
    navreg_reg: function () { this.exec([this.eventName, 'm_导航注册', 'm_注册', 'm_点击-导航注册', '']); },
    navreg_reg_code: function () { this.exec([this.eventName, '导航注册确认码', '确认码', '点击-导航注册确认码', '']); },
    navreg_suc: function () { this.exec([this.eventName, 'm_导航注册成功', 'm_注册', 'm_成功-导航注册', '']); },
    orderreg_reg: function () { this.exec([this.eventName, 'm_订单注册', 'm_注册', 'm_点击-订单注册', '']); },
    orderreg_code: function () { this.exec([this.eventName, '订单注册确认码', '确认码', '点击-订单注册确认码', '']); },
    orderreg_suc: function () { this.exec([this.eventName, 'm_订单注册成功', 'm_注册', 'm_成功-订单注册', '']); }
};

function getDomain() {
    var arr_dps = document.domain.split(".");
    var str_domain = ".";
    if (arr_dps.length >= 2) {
        str_domain += arr_dps[arr_dps.length - 2] + "." + arr_dps[arr_dps.length - 1];
    }
    return str_domain;
}
function readcookie(name) {
    var cookieValue = "";
    var search = name + "=";
    if (document.cookie.length > 0) {
        offset = document.cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = document.cookie.indexOf(";", offset);
            if (end == -1) end = document.cookie.length;
            cookieValue = document.cookie.substring(offset, end);
        }
    }
    return cookieValue;
}
//设定Cookie值
function setCookie(name, value) {
    var expdate = new Date();
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    var path = (argc > 3) ? argv[3] : "/";
    var domain = (argc > 4) ? argv[4] : getDomain();
    var secure = (argc > 5) ? argv[5] : false;
    if (expires != null) expdate.setTime(expdate.getTime() + (expires * 1000));
    document.cookie = name + "=" + value + ((expires == null) ? "" : ("; expires=" + expdate.toGMTString()))
+ ((path == null) ? "" : ("; path=" + path)) + ((domain == null) ? "" : ("; domain=" + domain))
+ ((secure == true) ? "; secure" : "");
}


function pageChange(url) {
    if (url && url != "")
        window.location.href = decodeURIComponent(url);
    else {
        var u = "/select";
        window.location.href = u;
    }
}

function popStopCancel(e) {
    return e ? e.stopPropagation() : event.cancelBubble = true;
};

function goTop() {
    $('html, body').animate({ scrollTop: 0 }, 200);
}

var hmc_global = {
    config: {
        syncDomain: "/ajax.huimaiche.com/", //异步域名
        tpl: function () { return "/tpl/"; } //模板文件域名
    }
}

//------------------------------------------------------------------------
// 扩展原生数据类型
//------------------------------------------------------------------------
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423 
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18 
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1,                 //月份 
        "d+": this.getDate(),                    //日 
        "h+": this.getHours(),                   //小时 
        "m+": this.getMinutes(),                 //分 
        "s+": this.getSeconds(),                 //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds()             //毫秒 
    };
    if (/(y+)/.test(fmt))
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
String.prototype.format = function (args) {
    if (arguments.length > 0) {
        var result = this;
        if (arguments.length == 1 && typeof (args) == "object") {
            for (var key in args) {
                var reg = new RegExp("({" + key + "})", "g");
                result = result.replace(reg, args[key]);
            }
        } else {
            for (var i = 0; i < arguments.length; i++) {
                if (arguments[i] == undefined) {
                    return "";
                } else {
                    var reg = new RegExp("({[" + i + "]})", "g");
                    result = result.replace(reg, arguments[i]);
                }
            }
        }
        return result;
    } else {
        return this;
    }
};
