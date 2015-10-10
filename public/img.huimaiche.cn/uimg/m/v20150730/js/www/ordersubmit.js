/* File Created: 三月 19, 2014 */
(function ($) {
    $.aftersubmit = {};
    $.extend($.aftersubmit, {
        callback: null,
        init: function (options) {
            $.extend($.aftersubmit, options);
            if ($.aftersubmit.o.length > 0) {
                $.aftersubmit.submit();
            }
        },
        submit: function () {
            var formData = {
                o: $.aftersubmit.o
            };
            if (HMCWEBLOG_ID)
                formData.HMCWEBLOG_ID = HMCWEBLOG_ID;
            if (HMCWEBLOG_TRACKER)
                formData.HMCWEBLOG_TRACKER = HMCWEBLOG_TRACKER;
            $.ajax({
                type: "POST",
                url: "/Ajax/Submit.ashx",
                data: formData,
                success: function (data) {
                    if (data) {
                        $.aftersubmit.submitSuc(data);
                    }
                },
                error: function (err) { }
            });
        },
        submitSuc: function (data) {
            //提交成功
            if (data.IsSuccess) {
                baiduStat.order_subSuc();
                pageChange(data.RedirUrl);
            } else {
                if (data.Msg) {
                    $.login.errorTips.push(data.Msg);
                    $.login.showError();
                    setTimeout(function () {
                        if (data.Obj && data.Obj.DefaultUrl != "") {
                            pageChange(data.Obj.DefaultUrl);
                        } else {
                            pageChange();
                        }
                    }, 3000);
                }
            }
            if (typeof ($.aftersubmit.callback) === "function") {
                $.aftersubmit.callback(data);
            }
        }
    });
})(jQuery);