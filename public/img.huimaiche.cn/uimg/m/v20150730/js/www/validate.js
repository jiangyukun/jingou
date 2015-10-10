/* 验证类 File Created: 十一月 27, 2013 */
//验证工具类
(function ($) {
    $.extend(
        {
            CheckMobile: function (mobile) {
                var regMobile1 = /^1[3,4,5,7,8]{1}\d{9}$/;
                if (regMobile1.test(mobile)) {
                    return true;
                }
                else {
                    return false;
                }
            },
            RemoveSpecialChar: function (input) {
                input = input.replace(/'/gi, '').replace(/"/gi, '').replace(/</gi, '').replace(/>/gi, '').replace(/\//gi, '').replace(/\\/gi, '').replace(/\./gi, '');
                while (input.indexOf(" ") > -1) {
                    input = input.replace(" ", "");
                }
                while (input.indexOf("&") > -1) {
                    input = input.replace("&", "");
                }
                while (input.indexOf("\\") > -1) {
                    input = input.replace("\\", "");
                }
                return input;
            }
        });
})(jQuery);

////////////////////////////////////////验证结果类//////////////////////////////////////
function ValidateResult() {
    this.success = false;
    this.errMsg = "";
}
ValidateResult.prototype.IsPass = function () {
    return this.success;
};

////////////////////////////////////////////////验证处理类/////////////////////////////////
function ErrorHandler(opts) {
    var defaults = {
        ctl: null, //需要验证的控件
        errorTip: "", //验证错误提示
        style: "", //样式
        tipDirection: "down", //提示标签显示方向（右，下）
        pass: false, //验证是否通过
        callback: null//回调方法
    };
    this.options = $.extend(defaults, opts);
    if (typeof (this.options.callback) === "function") {
        this.handle = function () {
            this.options.callback(this.options.errorTip);
        };
    } else {
        this.handle = function () {
            this.htmlTmp = "<div  class=\"error\">CONTENT</div>";
            if (this.options.ctl) {
                var tip = $(".error", this.options.ctl.parent().parent());
                if (this.options.pass) {
                    if (tip.length > 0) {
                        tip.hide();
                    }
                } else {
                    if (tip.length == 0) {
                        this.htmlTmp = this.htmlTmp.replace("STYLE", this.options.style).replace("CONTENT", this.options.errorTip);
                        this.options.ctl.parent().parent().append(this.htmlTmp);
                    } else {
                        $(tip).html( this.options.errorTip);
                        tip.show();
                    }
                }
            }
        };
    }
}


////////////////////////////////////////验证业务逻辑类///////////////////////////////////////////////
(function ($) {
    //检查手机号
    $.fn.CheckPhone = function(opt) {
        if (typeof (event)!=="undefined" ) {
            try {
               event.preventDefault();
            } catch(e) {}
        }
        var defaults = {
            allowEmpty: false,//是否允许为空
            defaultValue: "请输入手机号",//缺省文字
            emptyTip: "手机号码不能为空",//空值提示
            errorTip: "请输入正确的手机号码",//错误提示
            callback: null,//回调
            style: "", //附加样式
            tipDirection: "down",//显示方向，右边或者底部
            customCheck: null,//外部定制验证逻辑
            existPass: true,//存在此手机号才通过
            doExistCheck:true//是否验证手机号存在
        };
        var options = $.extend(defaults, opt);
        var phone = this.val();
        var result = new ValidateResult();
        if (typeof(options.customCheck) === "function") {
            result = options.customCheck();
        } else {
            result = new ValidateResult();
            if ($.trim(phone) == "" || $.trim(phone) == options.defaultValue) {
                result.success = options.allowEmpty;
                result.errMsg = (options.allowEmpty ? "" : options.emptyTip);
                if (typeof options.callback === "function") {
                     options.callback(result.errMsg );
                  }
            } else if (!$.CheckMobile(phone)) {
                result.errMsg = options.errorTip;
                 if (typeof options.callback === "function") {
                      options.callback(result.errMsg );
                   }
            } 
            else if(options.doExistCheck){
                $.ajax({
                    type: "POST",
                    url: "/Ajax/Validate.ashx",
                    timeout: 2000,
                    async: false,
                    data: { mobile: $.trim(phone) },
                    success: function(data) {
                        if (data && data != "") {
                            if (options.existPass) {
                                if (data.IsSuccess) {
                                    result.success = true;
                                } else {
                                    result.success = false;
                                    result.errMsg = "此手机号码不存在";
                                }
                            } else if (!options.existPass) {
                                if (!data.IsSuccess) {
                                    result.success = true;
                                } else {
                                    result.success = false;
                                    result.errMsg = "此手机号码已存在";
                                }
                            }
                        }
                    },
                    error: function() { result.success = true; },
                    complete: function() {
                         if (typeof options.callback === "function") {
                                options.callback(result.errMsg );
                           }
                        return result;
                    }
                });
            }else{
                result.success = true;
            }
        }
          return result;
    };
    //检查用户名
    $.fn.CheckName = function (opts) {
         if (typeof (event)!=="undefined" ) {
             try {
               event.preventDefault();
            } catch(e) {}
        }
        var defaults = {
            emptyTip: "姓名不能为空",
            errorTip: "姓名需由2-6个汉字组成",
            callback: null,
            style: "", //附加样式
            tipDirection: "down",//显示方向，右边或者底部
            customCheck:null//外部定制验证逻辑
        };
        var options = $.extend(defaults, opts);
        var user = this.val();
        var result =new ValidateResult();
        if (typeof(options.customCheck) === "function") {
            result = options.customCheck();
        } else {
            result = new ValidateResult();
            user = $.RemoveSpecialChar(user);
            if (user == "") {
                result.errMsg = options.emptyTip;
            } else {
                if (user.length > 16 || user.length < 2) {
                    result.errMsg = options.errorTip;
                } else result.success = true;
            }
        }
        if (typeof options.callback === "function") {
            options.callback(result.errMsg );
        }
        return result;
    };
    //检查验证码
    $.fn.CheckCheckCode = function (opts) {
         if (typeof (event)!=="undefined" ) {
             try {
               event.preventDefault();
            } catch(e) {}
        }
        var defaults = {
            emptyTip: "请输入确认码",
            callback: null,
            style: "", //附加样式
            tipDirection: "down",//显示方向，右边或者底部
            customCheck:null,//外部定制验证逻辑
            source:0
        };
        var options = $.extend(defaults, opts);
        var code = this.val();
        var result =new ValidateResult();
        if (typeof(options.customCheck) === "function") {
            result = options.customCheck();
        } else {
            result = new ValidateResult();
            if (!options.allowEmpty && ($.trim(code) == "" || $.trim(code) ==options.emptyTip)) {
                result.errMsg = options.emptyTip;
            } else {
                 result.success = true;
            }
        }
        if (typeof options.callback === "function") {
            options.callback(result.errMsg );
        }
        return result;
    };
    //验证下拉选择框是否选择
    $.fn.CheckSelect = function (opts) {
         if (typeof (event)!=="undefined" ) {
             try {
               event.preventDefault();
            } catch(e) {}
        }
        var defaults = {
            emptyTip: "请选择",
            callback: null,
            style: "", //附加样式
            tipDirection: "down",//显示方向，右边或者底部
            customCheck:null//外部定制验证逻辑
        };
        var options = $.extend(defaults, opts);
        var code = this.val();
         var result =new ValidateResult();
        if (typeof(options.customCheck) === "function") {
            result = options.customCheck();
        } else {
            result = new ValidateResult();
            if ($.trim(code)== "") {
                result.errMsg = options.emptyTip;
            } else result.success = true;
        }
       if (typeof options.callback === "function") {
             options.callback(result.errMsg );
        }
        return result;
    };
    //验证文本框输入
    $.fn.CheckTextBox = function (opts) {
         if (typeof (event)!=="undefined" ) {
              try {
               event.preventDefault();
            } catch(e) {}
        }
        var defaults = {
            emptyTip: "请输入",
            callback:null,
            style: "", //附加样式
            tipDirection: "down",//显示方向，右边或者底部
            customCheck:null//外部定制验证逻辑
        };
        var options = $.extend(defaults, opts);
        var code = this.val();
        var result = new ValidateResult();
         result = new ValidateResult();
        if (typeof(options.customCheck) === "function") {
            result = options.customCheck();
        } else {
            if ($.trim(code) == "") {
                result.errMsg=options.emptyTip;
            } else result.success=true;
        }
       if (typeof options.callback === "function") {
             options.callback(result.errMsg );
        }
        return result;
    };

})(jQuery);
