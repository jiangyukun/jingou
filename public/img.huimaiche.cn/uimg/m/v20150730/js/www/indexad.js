/* File Created: 四月 29, 2015 */
var adprocessor = {
    adshow_4: function (adlist) {
        if (adlist.length > 0) {
            var html = "", tpl = "<li class=\"swiper-slide\"><a href=\"{0}\"><img src=\"{1}\" ></a></li>";
            for (var i = 0; i < adlist.length; i++) {
                html += tpl.replace("{0}", adlist[i].adHref).replace("{1}", adlist[i].adSrc);
            }
            $("div[data-adcode='" + 4 + "']").replaceWith(html);
            if (adlist.length > 1) {
                if (typeof Swiper !== "undefined") {
                    new Swiper('#ad01', {
                        pagination: '#ad01pointer',
                        loop: true,
                        grabCursor: true,
                        paginationClickable: true,
                        calculateHeight: true,
                        autoplay:3000
                    });
                    window.onresize = function () {
                        new Swiper('#ad01', {
                            calculateHeight: true,
                            autoplay:3000
                        });
                    };
                }
            }
        }
       
    },
    adshow_6: function (adlist) {
        if (adlist.length > 0) {
            var html = "", tpl = "<li class=\"swiper-slide\"><a href=\"{0}\"><img src=\"{1}\" ></a></li>";
            for (var i = 0; i < adlist.length; i++) {
                html += tpl.replace("{0}", adlist[i].adHref).replace("{1}", adlist[i].adSrc);
            }
            $("div[data-adcode='" + 6 + "']").replaceWith(html);
            if (adlist.length > 1) {
                if (typeof Swiper !== "undefined") {
                    new Swiper('#ad02', {
                        pagination: '#ad02pointer',
                        loop: true,
                        grabCursor: true,
                        paginationClickable: true,
                        calculateHeight: true,
                        autoplay: 3000
                    });
                    window.onresize = function () {
                        new Swiper('#ad02', {
                            calculateHeight: true,
                            autoplay: 3000
                        });
                    };
                }
            }
        }
    },
    adshow_16: function (adlist) {
        if (adlist.length > 0) {
            var html = "", tpl = "<p>{0}</p>";
            html += tpl.replace("{0}", adlist[0].adText);
            $("div[data-adcode='" + 16 + "']").replaceWith(html);
        }
    }
};





