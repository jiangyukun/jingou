(function ($) {
    $.cardetail = {};
    $.extend($.cardetail, {
        carid: "0",
        csid: "0",
        ccode: "0",
        colorId: "0",
        dealerCount: "0",
        mbid:"0",
        init: function (options) {
            $.extend($.cardetail, options);
            //推荐车款跳转
            $("#div_recmd").on("click", "a", function () {
                var loc = window.location;
                loc.href = "/" + loc.host + "/" + $(this).attr("data-code") + "/?re=" + encodeURIComponent(loc.href);
            });
            //开始购买或者缺货登记
            $(".buy-begin").on("click", function () {
                var urlParam = "carid=" + $.cardetail.carid;
                if ($.cardetail.dealerCount > 0) {
                    var url = "/order1?" + urlParam;
                    if ($.cardetail.colorId > 0) {
                        url += "& color = " + $.cardetail.colorId;
                    }
                    window.location = url;
                } else {
                    window.location = "/oos?" + urlParam;
                }
            });

            $.cardetail.param_share.init();
            $.cardetail.rapidCars.init();
            $.cardetail.priceTrend.init();
            $.cardetail.groupSale($.cardetail.ccode, $.cardetail.mbid);
        },
        rapidCars: {
            init: function (options) {
                $.extend($.cardetail.rapidCars, options);
                $.cardetail.rapidCars.load();

                setInterval(function () {
                    $.cardetail.rapidCars.load();
                }, 1000 * 60 * 3);
            },
            load: function (data) {
                if (!data) {
                    data = {
                        csid: $.cardetail.csid,
                        ccode: $.cardetail.ccode,
                        callback: "$.cardetail.rapidCars._carsCb"
                    };
                }

                $.ajax({
                    url: hmc_global.config.syncDomain + "RapidIndexCars.ashx?v=" + (+new Date()),
                    type: "POST",
                    dataType: 'jsonp',
                    data: data,
                    timeout: 30000
                });
            },
            _carsCb: function (data) {
                if (data && data.length > 0) {
                    $.cardetail.rapidCars._cbCommon(data);
                } else {
                    $.cardetail.rapidCars.load({
                        ccode: $.cardetail.ccode,
                        callback: "$.cardetail.rapidCars._carsRemCb"
                    });
                }
            },
            _carsRemCb: function (data) {
                if (data && data.length > 0) {
                    $.cardetail.rapidCars._cbCommon(data);
                } else {
                    $("#rapidLine").hide();
                }
            },
            _cbCommon: function (data) {
                var content = new EJS({
                    url: hmc_global.config.tpl() + 'RapidList_New.html',
                    cache: false
                }).render({
                    datalist: data
                });

                if (content) {
                    $("#div_rapidCars").html(content);
                    $("#rapidLine").show();
                }
            }
        },
        //购车须知,参数配置,购车分享
        param_share: {
            init: function (options) {
                $(window).scroll(function () {
                    var _top = $(".p-tab").eq(0).offset().top;
                    var stop = $(window).scrollTop();
                    if (stop > _top) {
                        $("#p-tab").addClass("p-fixed");
                    } else {
                        $("#p-tab").removeClass("p-fixed");
                    }
                });

                $(".p-tab").find("span").click(function () {
                    var index = $(this).index();
                    $(".p-tab").find("span").removeClass("current").eq(index).addClass("current");
                    $("#p-tab").find("span").removeClass("current").eq(index).addClass("current");
                    if ($(this).attr("data-loaded") != "1") {
                        if ($(this).data("type") == "param") {
                            $.cardetail.param_share.loadParam();
                        } else if ($(this).data("type") == "share") {
                            $.cardetail.param_share.loadShare();
                        }
                    }
                    $(".p-tab-cot").hide().eq(index).show();
                    $(window).scrollTop($(".p-tab").eq(0).offset().top);
                });

                setTimeout(function () {
                    $.cardetail.param_share.loadShare();
                }, 500);
            },
            loadParam: function () {
                $.ajax({
                    url: "/Ajax/GetCarParam.ashx",
                    type: "POST",
                    data: {
                        carid: $.cardetail.carid
                    },
                    success: function (response) {
                        if (response.IsSuccess) {
                            var data = response.Obj;
                            var cardata = { ParamObj: {} };
                            for (var i = 0; i < data.length; i++) {
                                cardata.ParamObj[data[i].Code] = data[i].ParamValue;
                            }
                            $("#param-item").html(new EJS({
                                url: '/tpl/CarParam.html',
                                cache: true
                            }).render(cardata));

                            $(".p-tab span[data-type=param]").attr("data-loaded", "1");
                        }
                    }
                });
            },
            loadShare: function () {
                $.ajax({
                    url: "/Ajax/GetShare.ashx",
                    type: "GET",
                    cache: true,
                    data: {
                        ccode: $.cardetail.ccode,
                        csid: $.cardetail.csid,
                        count: 3
                    },
                    success: function (response) {
                        if (response.IsSuccess) {
                            var data = response.Obj;
                            if (data && data.length > 0) {
                                var content = new EJS({
                                    url: '/tpl/Share.html',
                                    cache: false
                                }).render({
                                    datalist: data
                                });

                                $("#param-share").html(content);
                                $(".p-tab span[data-type=share]").attr("data-loaded", "1");
                            }
                        }
                    }
                });
            }
        },
        priceTrend: {
            init: function () {
                var version, img = new Image(),
                    carid = $.cardetail.carid;
                if (window.hmc_timestamp) {
                    version = window.hmc_timestamp.timestamp;
                } else {
                    version = +new Date();
                }

                img.style.width = "100%";
                img.src = "/img.huimaiche.com/web/ptcity/" + carid % 10 + "/" + carid + "/" + carid + "_Curves_" + $.cardetail.ccode + ".png?v=" + version;
                if (img.complete) {
                    $("#svg_pt").append(img);
                    if ($.cardetail.usenation) {
                        $("#svg_pt").append('<div style="font-size:1.2rem;color:#999;padding: 0 0 16px 16px;">（注：本统计来源于全国数据，仅供参考）</div>');
                    }
                    $("#svg_pt_line").show();
                } else {
                    img.onload = function () {
                        $("#svg_pt").append(img);
                        if ($.cardetail.usenation) {
                            $("#svg_pt").append('<div style="font-size:1.2rem;color:#999;padding: 0 0 16px 16px;">（注：本统计来源于全国数据，仅供参考）</div>');
                        }
                        $("#svg_pt_line").show();
                    };
                }
            }
        },
        //团购信息绑定
        groupSale: function (cityId, mbId) {
                    var data = {
                        mbid: mbId,
                        ccode: cityId,
                        cb: "$.cardetail.groupSaleCallBack"
                    };
                $.ajax({
                    url: hmc_global.config.syncDomain + "group.ashx?v=" + (+new Date()),
                    type: "POST",
                    dataType: 'jsonp',
                    data: data,
                    timeout: 30000
                });
        },
            groupSaleCallBack: function (data) {
            var h = "<div class=\"line\"></div>";
            $.each(data, function () {
                h += "<div class=\"group-product\"><a href=\"/tuangou/"+this.Spell+"?groupId=" + this.GroupPurchaseID + "\"><h2>" + this.GroupPurchaseName + "</h2><div class=\"g-info\"><span class=\"fl\"><strong>" + this.SaleCount + "</strong>人已报名</span><p><span class=\"timerSpan\" data-timetype=\"1\" data-time=\"" + this.EndTimeFmt + "\">5天22小时15分2秒</span></p></div></a></div>";
            });
            var panel = $("#groupSalePanel");
            panel.html(h);
            $.cardetail.initTimer();
            },
         //初始化定时器
        initTimer : function () {
            $.getJSON("/ajax.huimaiche.com/gettime.ashx?callback=?", function (data) {
                $(".timerSpan").attr("data-curtime", data).CountdownClock({
                    callback: function (container) {
                        window.location.reload(true);
                    }
                });
            });
        }
    });
})(jQuery);