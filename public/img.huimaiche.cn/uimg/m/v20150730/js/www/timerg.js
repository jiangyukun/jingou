(function ($) {
    $.fn.CountdownClock = function (opts) {
        var defaults = {
            fmtFull: "<em>{d}</em>天<em>{h}</em>小时<em>{m}</em>分<em>{s}</em>秒",
            fmtShort: "<em>{h}</em>小时<em>{m}</em>分<em>{s}</em>秒",
            callback: null
        };
        var options = $.extend(defaults, opts);

        var checkTime = function (i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        };
        function tick(container, ts) {
            return function (t) {
                var dd = parseInt(ts / 1000 / 60 / 60 / 24, 10); //计算剩余的天数  
                var hh = parseInt(ts / 1000 / 60 / 60 % 24, 10); //计算剩余的小时数  
                var mm = parseInt(ts / 1000 / 60 % 60, 10); //计算剩余的分钟数  
                var ss = parseInt(ts / 1000 % 60, 10); //计算剩余的秒数 
                hh = checkTime(hh);
                mm = checkTime(mm);
                ss = checkTime(ss);
                if (dd > 0) {
                    $(container[0]).html("<em>" + dd + "</em>天<em>" + hh + "</em>小时<em>" + mm + "</em>分<em>" + ss + "</em>秒");
                } else {
                    $(container[0]).html("<em>" + hh + "</em>小时<em>" + mm + "</em>分<em>" + ss + "</em>秒");
                }
                ts -= 1000;
                if (t && ts < 0) {
                    clearInterval(t);
                    if (typeof options.callback === "function") {
                        options.callback(container);
                    }
                }
            };
        }

        $(this).each(function () {
            var curtime = $(this).data("curtime");
            var time = $(this).data("time");
            var ts = (new Date(time)) - (new Date(curtime)); //剩余的毫秒数 
            var f = tick($(this), ts);
            f();
            var t = setInterval(function () {
                f(t);
            }, 1000);
        });
    };
})(jQuery);