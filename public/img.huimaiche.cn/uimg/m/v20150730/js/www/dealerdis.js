/* File Created: 三月 19, 2014 */
(function ($) {
    $.dealerdis = {};
    $.extend($.dealerdis, {
        callback: null,
        init: function (options) {
            $.extend($.dealerdis, options);
            $.dealerdis.submit();
        },
        submit: function () {
            if (window.navigator.geolocation) {
                var options = {
                    enableHighAccuracy: true
                };
                window.navigator.geolocation.getCurrentPosition(function (position) {
                    if (position) {
                        //经纬度如果是google的数据还需要转成百度的
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        $.dealerdis.setData(longitude + "," + latitude);
                    } else {
                        $.dealerdis.setData();
                    }
                }, function (error) {
                    $.dealerdis.setData();
                }, options);
            } else {
                $.dealerdis.setData();
            }
        },
        setData: function (loc) {
            var formData = { ccode: $.dealerdis.ccode, carid: $.dealerdis.carid };
            if (loc)
                formData.location = loc;
            $.ajax({
                type: "POST",
                url: "/Ajax/CalDealerDistance.ashx",
                data: formData,
                success: function (data) {
                    if (data) {
                        if (typeof ($.dealerdis.callback) == "function") {
                            $.dealerdis.callback(data);
                        }
                    }
                }
            });

        }
    });
})(jQuery);