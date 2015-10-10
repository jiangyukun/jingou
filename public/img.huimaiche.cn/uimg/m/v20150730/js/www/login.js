/* File Created: 三月 19, 2014 */
(function ($) {
    $.login = {};
    $.extend($.login, {
        oPhone: null,
        oPwd: null,
        btnSubmit: null,
        callback: null,
        ucDomain: "",
        errorTips: [],
        errorZone: $(".etzone"),
        init: function (options) {
            $.login.oPhone = $("#phone");
            $.login.oPwd = $("#pwd");
            $.login.btnSubmit = $("#submitButton");
            $.extend($.login, options);
            $.login.btnSubmit.on("click", $.login.submit);
        },
        //验证方法集合
        validateFn: {
            checkPhone: function () {
                return $.login.oPhone.CheckTextBox({
                    allowEmpty: false, emptyTip: "请输入账号"
                });
            },
            checkPwd: function () {
                return $.login.oPwd.CheckTextBox({ allowEmpty: false, emptyTip: "请输入密码"});
            }
        },
        validate: function () {
            var success = true;
            $.login.errorTips = new Array();
            for (var f in this.validateFn) {
                if (this.validateFn.hasOwnProperty(f)) {
                    var re = this.validateFn[f]();
                    success = re.IsPass() && success;
                    if (!re.IsPass())
                        $.login.errorTips.push(re.errMsg);
                }
            }
            return success;
        },
        showError: function () {
            $.login.errorZone.empty().html($.login.errorTips.join("<br/>")).addClass("errortips");
            $.login.errorTips = new Array();
            setTimeout(function () {
                $(".errortips").empty().removeClass("errortips");
            }, 2000);
        },
        submit: function () {
            if ($.login.validate()) {
                var formData = {
                    mobile: $.login.oPhone.val(),
                    pwd: $.login.oPwd.val()
                };
                if ($.login.oid)
                    formData.o = $.login.oid;
                $.ajax({
                    type: "POST",
                    url: "/Ajax/Login.ashx",
                    data: formData,
                    beforeSend: function () {
                        $.login.btnSubmit.unbind("click");
                    },
                    success: function (data) {
                        if (data) {
                            $.login.submitSuc(data);
                        }
                    },
                    error: function (err) { },
                    complete: function () {
                        $.login.btnSubmit.on("click", $.login.submit);
                    }
                });
            } else {
                $.login.showError();
            }
        },
        submitSuc: function (data) {
            if (data.IsSuccess) {
                setCookie(data.Obj.CookieName, data.Obj.CookieValue, 60 * 60 * 24 * 7);
                if (typeof ($.login.callback) === "function") {
                    $.login.callback(data);
                }
                $('#log_loginsuccess').click();
            } else {
                $.login.errorTips.push(data.Msg);
                $.login.showError();
            }
        }
    });
})(jQuery);