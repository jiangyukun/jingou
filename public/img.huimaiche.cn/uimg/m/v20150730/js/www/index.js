(function ($) {
    $.index = {};
    $.extend($.index, {
        ccode: 201,
        init: function (options) {
            $.extend($.index, options);

            $(".index-buy a").on("click", baiduStat.home_search);

            //gotop
            $(window).on('load scroll', function () {
                $(window).scrollTop() > 300 ? $(".gotop").show() : $(".gotop").hide();
            });
            $(".gotop").on("click", function () {
                $("html, body").animate({scrollTop: 0}, 300);
            });

            $.index.signalR.start();
            $.index.rapidCars.init();
            $.index.share.load();
            $.index.group();
        },
        signalR: {
            jumpInter: 10, //毫秒
            duration: 2000, //毫秒
            start: function () {
                setInterval(function () {
                    $.ajax({
                        async: false,
                        url: hmc_global.config.syncDomain + "GetOrderData.ashx",
                        type: "GET",
                        dataType: 'jsonp',
                        jsonp: "jsonpcb",
                        data: {
                            ccode: $.index.ccode,
                            callback: "$.index.signalR.setData"
                        },
                        timeout: 2000
                    });
                }, 60 * 1000);
            },
            setData: function (obj) {
                if (obj) {
                    var strong = $("#spanoc");
                    strong.html((obj.p + '').replace(/\d{1,3}(?=(\d{3})+(\.\d*)?$)/g, '$&,') + "人");
                }
            }
        },
        rapidCars: {
            container: $("#div_rapidCars"),
            init: function (options) {
                $.extend($.index.rapidCars, options);
                $.index.rapidCars.load();

                setInterval(function () {
                    $.index.rapidCars.load();
                }, 1000 * 60 * 3);
            },
            load: function () {
                var data = {
                    ccode: $.index.ccode,
                    callback: "$.index.rapidCars._carsCb"
                };
                $.ajax({
                    url: hmc_global.config.syncDomain + "RapidIndexCars.ashx?v=" + (+new Date()),
                    type: "POST",
                    dataType: 'jsonp',
                    data: data,
                    timeout: 30000
                });
            },
            _carsCb: function (data) {
                if (data) {
                    var content = new EJS({
                        url: hmc_global.config.tpl() + 'RapidIndex.html',
                        cache: false
                    }).render({
                        datalist: data
                    });
                    content && $("#div_rapidCars").html(content);
                    if (typeof Swiper !== "undefined") {

                        (data.length > 1) || $('.sg-pointer').hide();

                        var sp = new Swiper('.index-sg', {
                            pagination: '.sg-pointer',
                            loop: data.length > 1,
                            grabCursor: data.length > 1,
                            paginationClickable: data.length > 1,
                            calculateHeight: true
                        });

                        window.onresize = function () {
                            var sp = new Swiper('.index-sg', {
                                calculateHeight: true
                            });
                        };
                    }
                }
            }
        },
        share: {
            load: function () {
                $.ajax({
                    url: "/Ajax/GetShare.ashx",
                    type: "GET",
                    cache: true,
                    data: {
                        ccode: $.index.ccode,
                        csid: 0,
                        count: 5
                    },
                    success: function (response) {
                        if (response.IsSuccess) {
                            var data = response.Obj;
                            if (data && data.length > 0) {
                                var content = new EJS({
                                    url: '/tpl/Share_Index.html',
                                    cache: false
                                }).render({
                                    datalist: data
                                });

                                $("#sharePlaceholder").replaceWith(content);
                            }
                        }
                    }
                });
            }
        },
        //初始化团购
        group: function () {
            if ($(".group-list").length > 0) {
                var group = new Swiper('.group-list', {
                    pagination: '.group-pointer',
                    loop: true,
                    grabCursor: true,
                    paginationClickable: true,
                    calculateHeight: true
                });	
            }
        }
    });
})(jQuery);