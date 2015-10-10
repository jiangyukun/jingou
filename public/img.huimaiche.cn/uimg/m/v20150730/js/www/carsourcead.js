/* File Created: 四月 29, 2015 */
var adprocessor = {
    adshow_3: function (adlist) {
        if (adlist.length > 0) {
            var html = "", tpl = "<div class=\"line\"></div><div class=\"cele2015-ad\"><a href=\"{0}\"><img src=\"{1}\"></a></div>";
            var ccode = 201;
            if ($.cardetail && $.cardetail.ccode) {
                ccode = $.cardetail.ccode;
            }
            html += tpl.replace("{0}", adlist[0].adHref + "?ccode=" + ccode).replace("{1}", adlist[0].adSrc);
            $("div[data-adcode='" + 3 + "']").replaceWith(html);
        }
    }
};





