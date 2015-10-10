/* File Created: 三月 19, 2014 */
(function ($) {
    $.register = {};
    $.extend($.register, {
        oCheckCode: $("#checkcode"),
        oSendBtn: $("#get-yzm"),
        oName: $("#name"),
        oPhone: $("#phone"),
        oPwd: $("#pwd"),
        btnSubmit: $("#submitButton"),
        btnSure: null,
        callback: null,
        errorTips: [],
        errorZone: $(".etzone"),
        backData: null,
        oid: "",
        init: function (options) {
            $.extend($.register, options);
            //点击获取验证码
            $.register.oSendBtn.on("click", $.register.sendcc);
            $.register.btnSubmit.on("click", $.register.submit);

        },
        //验证方法集合
        validateFn: {
            checkPhone: function () {
                return $.register.oPhone.CheckPhone({
                    allowEmpty: false,
                    existPass: false
                });
            },
            checkPwd: function () {
                return $.register.oPwd.CheckTextBox({ allowEmpty: false, emptyTip: "请输入密码",
                    customCheck: function () {
                        var vr = new ValidateResult();
                        if ($.trim($.register.oPwd.val()).length < 6 || $.trim($.register.oPwd.val()).length > 16) {
                            vr.errMsg = "密码需由6-16个数字或字母组成";
                        }
                        else if ($.trim($.register.oPwd.val()) == $.trim($.register.oPhone.val())) {
                            vr.errMsg = "密码和手机号不能相同";
                        } else {
                            vr.success = true;
                        }
                        return vr;
                    }
                });
            },
            checkName: function () {
                return $.register.oName.CheckName({ allowEmpty: false });
            },
            checkCode: function () {
                return $.register.oCheckCode.CheckCheckCode({ allowEmpty: false, mobile: $.register.oPhone.val() });
            }
        },
        validate: function () {
            var success = true;
            $.register.errorTips = new Array();
            for (var f in this.validateFn) {
                if (this.validateFn.hasOwnProperty(f)) {
                    var re = this.validateFn[f]();
                    success = re.IsPass() && success;
                    if (!re.IsPass())
                        $.register.errorTips.push(re.errMsg);
                }
            }
            return success;
        },
        showError: function () {
            $.register.errorZone.empty().html($.register.errorTips.join("<br/>")).addClass("errortips");
            $.register.errorTips = new Array();
            setTimeout(function () {
                $(".errortips").empty().removeClass("errortips");
            }, 2000);
        },
        sendcc: function () {
            var pe = $.register.validateFn.checkPhone();
            if (pe.IsPass()) {
                $.ajax({
                    type: "POST",
                    url: "/Ajax/CheckCode.ashx",
                    timeout: 30000,
                    data: { mobile: $.trim($.register.oPhone.val()), action: "get" },
                    beforeSend: function () {
                        var sc = 60;
                        $.register.oSendBtn.unbind("click").addClass("c-orange").html("<em>" + sc + "</em>秒后重发");
                        var wt = setInterval(function () {
                            if (parseInt(sc, 10) > 1) {
                                sc -= 1;
                                $.register.oSendBtn.find("em").html(sc);
                            } else {
                                clearInterval(wt);
                                $.register.oSendBtn.bind("click", $.register.sendcc).addClass("c-orange").html("发送确认码");
                            }
                        }, 1000);
                    },
                    success: function (data) {
                        if (data && data != "") {
                            if (!data.IsSuccess) {
                                $.register.errorTips.push(data.Msg);
                                $.register.showError();
                            }
                            else {
                                $("#sendccmask").hide();
                                $(window).resize(function () {
                                    $("#sendccmask").css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height());
                                });
                                var phoneNum = $.register.oPhone.val();
                                $("#sendccmask").css("height", ($(document).height() > $(window).height()) ? $(document).height() : $(window).height()).
                                    show().find("span").html(phoneNum.replace(phoneNum.substr(3, 4), "****"));
                            }
                        }
                    },
                    error: function () {
                    }
                });
            } else {
                $.register.errorTips.push(pe.errMsg);
                $.register.showError();
            }
        },
        submit: function () {
            $.register.btnSubmit.off("click");
            if ($.register.validate()) {
                var formData = {
                    mobile: $.trim($.register.oPhone.val()),
                    pwd: $.trim($.register.oPwd.val()),
                    name: $.trim($.register.oName.val()),
                    code: $.trim($.register.oCheckCode.val())
                };
                if ($.register.oid !== "") {
                    baiduStat.orderreg_reg();
                } else {
                    baiduStat.navreg_reg();
                }

                formData.HMCWEBLOG_ID = HMCWEBLOG_ID || "";
                formData.HMCWEBLOG_TRACKER = HMCWEBLOG_TRACKER || "";

                $.ajax({
                    type: "POST",
                    url: "/Ajax/Register.ashx",
                    data: formData,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data) {
                            $.register.backData = data;
                            $.register.submitSuc(data);
                        }
                    },
                    error: function (err) { },
                    complete: function () {
                        $.register.btnSubmit.on("click", $.register.submit);
                    }
                });
            } else {
                $.register.showError();
                $.register.btnSubmit.on("click", $.register.submit);
            }
        },
        after: function () {
            $.register.submitSuc($.register.backData);
        },
        submitSuc: function (data) {
            if (data.IsSuccess) {
                setCookie(data.Obj.CookieName, data.Obj.CookieValue, 60 * 60 * 24 * 7);
                if (typeof ($.register.callback) === "function") {
                    $.register.callback(data);
                }
                $('#log_regsuccess').click();
            } else {
                $.register.errorTips.push(data.Msg);
                $.register.showError();
            }
        }
    });
})(jQuery);