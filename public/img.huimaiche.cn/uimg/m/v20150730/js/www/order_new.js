/* File Created: 三月 19, 2014 */
(function ($) {
    $.ordernew = {};
    $.extend($.ordernew, {
        oColor: $(".need-list li").eq(0).find("select"),
        oUpColor: $(".need-list li").eq(1).find("select"),
        oBuyTime: $(".need-list li").eq(2).find("select"),
        oBuyType: $(".need-list li").eq(3).find("select"),
        oDealerLink: $("#todealer"),
        oBrandLoc: $("#locBrand"),
        oCheckCode: $("#oCode"),
        oSendBtn: $("span[name='btnOSendcc']"),
        oName: $("#oName"),
        oPhone: $("#oPhone"),
        btnSubmit: null,
        callback: null,
        carid:"0",
        ccode: 201,
        logined: 1,
        recover: 0,
        errorTips: [],
        errorZone: $(".etzone"),
        giftId: 0,
        giftType: 0,
        isGift: false,
        init: function (options) {
            $.ordernew.btnSubmit = $("#next");
            $.extend($.ordernew, options);
            var ov = readcookie("formvalue");
            if (ov && ov != "" && $.ordernew.recover) {
                var obj = undefined;
                try {
                    obj = $.parseJSON(decodeURIComponent(ov));
                } catch (e) { }
                if (obj) {
                    $.ordernew.oColor.attr("data-code", obj.color);
                    $.ordernew.oBuyTime.attr("data-code", obj.time);
                    $.ordernew.oBuyType.attr("data-code", obj.type);
                    $.ordernew.oUpColor.attr("data-code", obj.upcolor);
                    $.ordernew.oName.attr("data-code", obj.name);
                    $.ordernew.oPhone.attr("data-code", obj.phone);
                    $.ordernew.oCheckCode.attr("data-code", obj.ccode);
                }
            }

            var Oarray = new Array($.ordernew.oName, $.ordernew.oPhone, $.ordernew.oCheckCode);
            for (var o in Oarray) {
                if (Oarray[o].attr("data-code")) {
                    Oarray[o].val(Oarray[o].attr("data-code"));
                }
            }

            if ($.trim($("#oPhone").val()) == '' || $("#oPhone").val() == '手机号码'
                    || $("#oPhone").val() != $("#oPhone").attr("data-mobile")
                    || $.ordernew.logined == 0) {
                $("#divMobile").removeClass("no-bdb");
                $(".bd0").show();
            }

            if ($.ordernew.oColor.find("option").length == 1) {
                var opt = $.ordernew.oColor.find("option").eq(1);
                opt.attr("selected", "selected");
                $.ordernew.oColor.attr("data-code", opt.val());
            }
            $.ordernew.oColor.bind("change", function () {
                var opt = $("option:selected", $(this));
                $("#carimg").attr("src", opt.attr("data-imgurl")).attr("alt", $.trim(opt.text() || opt.html())).attr("title", $.trim(opt.text() || opt.html()));
            });

            $("option").each(function () {
                var v = $(this).val();
                if (v == $(this).parent().attr("data-code")) {
                    $(this).parent().val(v);
                    $(this).attr("selected", "selected");
                    if (v !== "")
                        $(this).parent().addClass("on").prev().addClass("on");
                }
            });
            $("select").bind("change", function () {
                var opt = $("option:selected", $(this));
                if (opt.val() !== "") {
                    opt.parent().addClass("on").prev().addClass("on");
                }
            });
            $.ordernew.oPhone.bind("change", function () {
                if ($.trim($(this).val()) == '' || $.trim($(this).val()) != $(this).attr('data-mobile')) {
                    $("#divMobile").removeClass("no-bdb");
                    $('.bd0').show();
                } else {
                    $("#divMobile").addClass("no-bdb");
                    $('.bd0').hide();
                }
            });
            $(".giftc").on("click", function () {
                $(".giftc").find(".choose").removeClass("on");
                $(this).find(".choose").addClass("on");
                $.ordernew.giftId = $(this).attr("data-id");
                $.ordernew.giftType = $(this).attr("data-type");
            });
            var gc = 0;
            $.each($(".giftc"), function (i, val) {
                gc = gc + 1;
            });
            if (gc == 1) {
                $(".giftc").find(".choose").addClass("on");
                $.ordernew.giftId = $(".giftc").attr("data-id");
                $.ordernew.giftType = $(".giftc").attr("data-type");
            };
            $.ordernew._bindNext();

            $.ordernew.oDealerLink.on("click", function () {
                $.ordernew.saveStatus();
            });
            $.ordernew.oBrandLoc.on("click", function () {
                $.ordernew.saveStatus();
            });
            $("#carSelector,#btnLogin,#servicecontract").on("click", function () {
                $.ordernew.saveStatus();
            });

            $.ordernew.oSendBtn.click($.ordernew.sendcc);
        },
        saveStatus: function () {
            var data = JSON.stringify({
                ccode: $.ordernew.oCheckCode.val(),
                phone: $.ordernew.oPhone.val(),
                name: $.ordernew.oName.val(),
                color: $.ordernew.oColor.val(),
                time: $.ordernew.oBuyTime.val(),
                type: $.ordernew.oBuyType.val(),
                upcolor: $.ordernew.oUpColor.val()
            });
            setCookie("formvalue", encodeURIComponent(data), 2 * 60);
        },
        //验证方法集合
        validateFn: {
            checkColor: function () {
                return $.ordernew.oColor.CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        if ($.ordernew.oColor.find("option").length == 1 || $.ordernew.oColor.is(":hidden")) {
                            vr.success = true;
                        } else {
                            var value = $.ordernew.oColor.val();
                            if (value.length > 0) {
                                vr.success = true;
                            } else {
                                vr.errMsg = "请选择车身颜色";
                            }
                        }
                        return vr;
                    }
                });
            },
            checkupColor: function () {
                return $.ordernew.oUpColor.CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        if ($.ordernew.oUpColor.find("option").length == 1 || $.ordernew.oUpColor.is(":hidden")) {
                            vr.success = true;
                        } else {
                            var value = $.ordernew.oUpColor.val();
                            if (value.length > 0) {
                                vr.success = true;
                            } else {
                                vr.errMsg = "请选择内饰颜色";
                            }
                        }
                        return vr;
                    }
                });
            },
            checkBuyTime: function () {
                return $.ordernew.oBuyTime.CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        var value = $.ordernew.oBuyTime.val();
                        if (value.length > 0) {
                            vr.success = true;
                        } else {
                            vr.errMsg = "请选择购车时间";
                        }
                        return vr;
                    }
                });
            },
            checkBuyType: function () {
                return $.ordernew.oBuyType.CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        var value = $.ordernew.oBuyType.val();
                        if (value.length > 0) {
                            vr.success = true;
                        } else {
                            vr.errMsg = "请选择购车方式";
                        }
                        return vr;
                    }
                });
            },
            checkDealer: function () {
                return $.ordernew.oDealerLink.CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        var value = $.ordernew.oDealerLink.attr("data-code");
                        vr.errMsg = "请选择至少3家4S店";
                        if (value && value.split(',').length >= 3) {
                            vr.success = true;
                        } else {
                            var dealersCount = $.ordernew.totalDealer;
                            if (dealersCount == 0)
                                vr.success = true;
                            else if (dealersCount < 3) {
                                if (value && value.split(',').length > 0)
                                    vr.success = true;
                                else vr.errMsg = "请选择至少1家4S店";
                            }
                        }
                        return vr;
                    }
                });
            },
            checkCode: function () {
                return $.ordernew.oCheckCode.CheckCheckCode({
                    allowEmpty: $(".bd0").is(":hidden"),
                    emptyTip: "请输入手机确认码",
                    mobile: $.ordernew.oPhone.val()
                });
            },
            checkName: function () {
                return $.ordernew.oName.CheckName({
                    allowEmpty: false,
                    customCheck: function () {
                        var vr = new ValidateResult();
                        if ($.trim($.ordernew.oName.val()).length === 0) {
                            vr.errMsg = "请输入您的姓名";
                        } else if ($.trim($.ordernew.oName.val()).length < 1 || $.trim($.ordernew.oName.val()).length > 16) {
                            vr.errMsg = "请输入1-16字姓名";
                        } else {
                            vr.success = true;
                        }
                        return vr;
                    }
                });
            },
            checkGift: function () {
                return $("#ul_gifts").CheckSelect({
                    customCheck: function () {
                        var vr = new ValidateResult();
                        vr.errMsg = "请选择礼品";
                        if ($.ordernew.isGift) {
                            if ($.ordernew.giftId > 0) {
                                vr.success = true;
                            } else {
                                vr.success = false;
                            }
                        } else {
                            vr.success = true;
                        }
                        return vr;
                    }
                });
            },
            checkPhone: function () {
                return $.ordernew.oPhone.CheckPhone({
                    allowEmpty: false,
                    existPass: false,
                    doExistCheck: !$(".bd0").is(":hidden"),
                    callback: function (err) {
                        var loginmask = $("#loginmask").hide();
                        var url = $("#btnLogin").attr("href");
                        url = url && url.split("&p=")[0];

                        $(window).resize(function () {
                            loginmask.css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height());
                        });

                        if (err && err.indexOf("已存在") > -1) {
                            var phoneNum = $.ordernew.oPhone.val();

                            loginmask.show()
                                .css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height())
                                .find("span").html(phoneNum.replace(phoneNum.substr(3, 4), "****"));

                            $("#btnLogin").attr("href", url + "&p=" + phoneNum);
                        } else {
                            $("#btnLogin").attr("href", url);
                        }
                    }
                });
            }
        },

        validate: function () {
            var success = true;
            $.ordernew.errorTips = new Array();
            for (var f in this.validateFn) {
                if (this.validateFn.hasOwnProperty(f)) {
                    var re = this.validateFn[f]();
                    success = re.IsPass() && success;
                    if (!re.IsPass() && $.ordernew.errorTips && $.trim(re.errMsg) != "")
                        $.ordernew.errorTips.push(re.errMsg);
                }
            }
            return success;
        },
        showError: function () {
            if ($.ordernew.errorTips && $.ordernew.errorTips.length > 0) {
                $.ordernew.errorZone.empty().html($.ordernew.errorTips.join("<br/>")).addClass("errortips");
                $.ordernew.errorTips = new Array();
                setTimeout(function () {
                    $(".errortips").empty().removeClass("errortips");
                }, 2000);
            }
        },
        sendcc: function () {
            var re = $.ordernew.validateFn.checkPhone();
            if (re.IsPass()) {
                if ($.ordernew.oid !== "") {
                    baiduStat.orderreg_code();
                } else {
                    baiduStat.navreg_reg_code();
                }
                var sc = 60;
                $.ajax({
                    type: "POST",
                    url: "/Ajax/CheckCode.ashx",
                    timeout: 30000,
                    data: {
                        mobile: $.trim($.ordernew.oPhone.val()),
                        action: "get"
                    },
                    beforeSend: function () {
                        sc = 60;
                        $.ordernew.oSendBtn.unbind("click").addClass("c-orange").html("<em>" + sc + "</em>秒后重发");
                        var wt = setInterval(function () {
                            if (parseInt(sc, 10) > 1) {
                                sc -= 1;
                                $.ordernew.oSendBtn.find("em").html(sc);
                            } else {
                                clearInterval(wt);
                                $.ordernew.oSendBtn.bind("click", $.ordernew.sendcc).addClass("c-orange").html("重发确认码");
                            }
                        }, 1000);
                    },
                    success: function (data) {
                        if (data && data != "") {
                            if (!data.IsSuccess) {
                                $.ordernew.errorTips.push(data.Msg);
                                $.ordernew.showError();
                            } else {
                                $("#sendccmask").hide();
                                $(window).resize(function () {
                                    $("#sendccmask").css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height());
                                });
                                var phoneNum = $.ordernew.oPhone.val();
                                $("#sendccmask").css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height()).
                                show().find("span").html(phoneNum.replace(phoneNum.substr(3, 4), "****"));
                            }
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                    }
                });
            } else {
                if (!re.IsPass() && $.trim(re.errMsg) != "") {
                    $.ordernew.errorTips.push(re.errMsg);
                }
                $.ordernew.showError();
            }
        },
        submit: function () {
            $.ajax({
                type: "POST",
                url: "/Ajax/CheckGift.ashx",
                data: { cityId: $.ordernew.ccode,
                    giftId: $.ordernew.giftId,
                    giftType: $.ordernew.giftType
                },
                success: function (data) {
                    if (data == "1") {
                        $.ordernew.psubmit();
                    } else {
                        var dn = "#gfit" + $.ordernew.giftType + $.ordernew.giftId;
                        $(dn).remove();
                        alert("所选礼品活动已停止，请重新选择");
                        $.ordernew.giftId = 0;
                        $.ordernew.giftType = 0;
                        $.ordernew.btnSubmit.on("click", function () {
                            $.ordernew.submit();
                            $(".need-list select").bind("change", function () {
                                $.ordernew.validate();
                                return false;
                            });
                        });
                    }
                }
            });
        },
        psubmit: function () {
            if ($.ordernew.validate()) {
                if (!$(".bd0").is(":hidden")) {
                    $.ordernew._registerUser();
                } else {
                    $.ordernew._submitOrder();
                }
            } else {
                $.ordernew.showError();
            }
        },
        _submitOrder: function (osms) {
            $.ordernew.btnSubmit.off("click");
            baiduStat.order_submit();
            var formData = {
                carid: $.ordernew.carid,
                color: $.ordernew.oColor.val(),
                colName: $.trim($("option:selected", $.ordernew.oColor).text()),
                time: $.ordernew.oBuyTime.val(),
                type: $.ordernew.oBuyType.val(),
                dealers: $.ordernew.oDealerLink.attr("data-code"),
                upcolor: $.ordernew.oUpColor.val(),
                brandloc: $.ordernew.oBrandLoc.attr("data-code"),
                city: $.ordernew.ccode,
                name: $.ordernew.oName.val(),
                mname: "",
                url: window.location.href,
                giftId: $.ordernew.giftId,
                giftType: $.ordernew.giftType
            };
            formData.HMCWEBLOG_ID = HMCWEBLOG_ID || "";
            formData.HMCWEBLOG_TRACKER = HMCWEBLOG_TRACKER || "";
            osms && (formData.osms = osms);

            $.ajax({
                type: "POST",
                url: "/Ajax/Submit.ashx",
                data: formData,
                beforeSend: function () { },
                success: function (data) {
                    if (data) {
                        if (typeof ($.ordernew.callback) === "function") {
                            $.ordernew.callback(data);
                        }
                        if (data.IsSuccess) {
                            $('#log_ordersuccess').click();
                        }
                    }
                },
                error: function (err) { },
                complete: function () {
                    $.ordernew._bindNext();
                }
            });

        },
        _registerUser: function () {
            $.ordernew.btnSubmit.off("click");
            var formData = {
                mobile: $.trim($.ordernew.oPhone.val()),
                code: $.trim($.ordernew.oCheckCode.val()),
                pwd: $.trim($.ordernew.oPhone.val()),
                name: $.trim($.ordernew.oName.val()),
                osms: 1
            };
            baiduStat.orderreg_reg();
            formData.HMCWEBLOG_ID = HMCWEBLOG_ID || "";
            formData.HMCWEBLOG_TRACKER = HMCWEBLOG_TRACKER || "";

            $.ajax({
                type: "POST",
                url: "/Ajax/Register.ashx",
                data: formData,
                beforeSend: function () { },
                success: function (data) {
                    if (data) {
                        if (data.IsSuccess) {
                            //修改用户信息后无需重置cookie
                            if (data.Obj && data.Obj.CookieName) {
                                setCookie(data.Obj.CookieName, data.Obj.CookieValue, 60 * 60 * 24 * 7);
                            }
                            setCookie("formvalue", "");
                            $("#oCode").attr("data-code", "").val("");
                            $("#oName").attr("data-code", "").val("");
                            $("#oPhone").attr("data-code", "").val("");
                            $('#log_registersuccess').click();
                            //创建成功，提交订单
                            $.ordernew._submitOrder(1);
                        } else {
                            var loginmask = $("#loginmask").hide();
                            var url = $("#btnLogin").attr("href");
                            url = url && url.split("&p=")[0];

                            $(window).resize(function () {
                                loginmask.css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height());
                            });

                            if (data.Msg && data.Msg.indexOf("已存在") > -1) {
                                var phoneNum = $.ordernew.oPhone.val();

                                loginmask.show()
                                    .css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height())
                                    .find("span").html(phoneNum.replace(phoneNum.substr(3, 4), "****"));

                                $("#btnLogin").attr("href", url + "&p=" + phoneNum);
                            } else {
                                $("#btnLogin").attr("href", url);

                                $.ordernew.errorTips.push(data.Msg);
                                $.ordernew.showError();
                            }
                        }

                    }
                },
                error: function (err) { },
                complete: function () {
                    $.ordernew._bindNext();
                }
            });
        },
        _bindNext: function () {
            $.ordernew.btnSubmit.on("click", function () {
                $.ordernew.submit();
                $(".need-list select").bind("change", function () {
                    $.ordernew.validate();
                    return false;
                });
            });
        },
        openAlertWind: function () {
            $("#oPhone").blur();
            $("#alertMsgLayer").css("display", "block");
        }
        ,closeAlertWind:function() {
            $("#alertMsgLayer").css("display", "none");
        },
        changeUser:function() {
            $.post('/ajax/login.ashx', {
                action: 'out'
            }, function (data, textStatus, xhr) {
                if (data && data.IsSuccess) {
                    window.location.reload();
                }
            });
        },
        clearUserData : function() {
            $("#oName,#oPhone").attr("data-code", "").val("");
        }
    });
})(jQuery);