@extends('layouts.m_master')
@section('title')
@parent
@stop
@section('content')


<div>
<div class="header" data-position="fixed">
    <a href="javascript:" id="btnback" class="turnback">
        <i class="i-back"></i>返回</a>
    <h1>
    </h1>
</div>



<div data-role="content">
    <div id="wrapper">
        <div id="scroller">
            <div class="pick">
                <div class="pick-cars">
                    <div>
                        <ul id="pick-car">
                            @if (count($demands))
                            @foreach ($demands as $demand)

                            <li><a href="{{ URL::to('demand/show/'.$demand->id) }}">
                                    <img src="/{{ $demand->thumb }}" alt="">
                                    <h3>{{ $demand->title }}</h3></a>
                            </li>
                            @endforeach
                            @endif

                        </ul>
                        <div id="pullUp" onclick="myLoad();" style="display:none">
                            加载更多
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var EncodeURI = function(unzipStr, isCusEncode) {
        if (isCusEncode) {
            var zipArray = new Array();
            var zipstr = "";
            var lens = new Array();
            for (var i = 0; i < unzipStr.length; i++) {
                var ac = unzipStr.charCodeAt(i);
                zipstr += ac;
                lens = lens.concat(ac.toString().length);
            }
            zipArray = zipArray.concat(zipstr);
            zipArray = zipArray.concat(lens.join("O"));
            return zipArray.join("N");
        } else {
            //return encodeURI(unzipStr);
            var zipstr = "";
            var strSpecial = "!\"#$%&'()*+,/:;<=>?[]^`{|}~%";
            var tt = "";

            for (var i = 0; i < unzipStr.length; i++) {
                var chr = unzipStr.charAt(i);
                var c = StringToAscii(chr);
                tt += chr + ":" + c + "n";
                if (parseInt("0x" + c) > 0x7f) {
                    zipstr += encodeURI(unzipStr.substr(i, 1));
                } else {
                    if (chr == " ")
                        zipstr += "+";
                    else if (strSpecial.indexOf(chr) != -1)
                        zipstr += "%" + c.toString(16);
                    else
                        zipstr += chr;
                }
            }
            return zipstr;
        }
    }
    var StringToAscii = function(str){
        return str.charCodeAt(0).toString(16);
    }
    $(document).ready( function () {
        $.ajax({
            type: "POST",
            url: "/Ajax/DynamicState.ashx",
            success: function (data) {
                //登录地址
                var url=window.location.href;
                var transferUrl=data.TransferUrl.replace(/\{0\}/g,EncodeURI(url));
                var loginUrl=data.LoginUrl.replace(/\{0\}/g,EncodeURI(transferUrl));
                if (data) {
                    if (data.IsLogin) {
                        $(".nlg").remove();
                        $(".lg").remove();
                        //更新头和尾
                    //    $("#divhead").append('<strong class="header-uname nlg"><a href="http://i.m.huimaiche.com/index.aspx" >我的车</a> </strong><a href="javascript:" id="toplogout"  class="header-cancel ui-btn-right nlg">退出</a>');
                        $(".footer").prepend(new EJS({ url: '/Include/footbar-logined.html', cache: false }).render({LocCityCode:201,UserCenterDomain:"i.m.huimaiche.com",LoginUrl:loginUrl}));
                        $("#toplogout").on("click", function () {
                            $.post('/ajax/login.ashx', {
                                action: 'out'
                            }, function(data, textStatus, xhr) {
                                if (data && data.IsSuccess) {
                                    window.location.reload()
                                }
                            });
                        });


                    } else {
                        //注册地址
                        var url=window.location.href;
                        var transferUrl=data.TransferUrl.replace(/\{0\}/g,EncodeURI(url));
                        var registerUrl=data.RegisterUrl.replace(/\{0\}/g,EncodeURI(transferUrl))

                        $(".nlg").remove();
                        $(".lg").remove();
                        $("#divhead").append(' <a  href="'+loginUrl+'" data-hmclog="{pageid: 1, eventid: 41}" class="header-cancel btnre ui-btn-right lg">登录</a>');
                        $(".footer").prepend(new EJS({ url: '/Include/footbar-nologin.html', cache: false })
                            .render({LoginUrl:loginUrl,RegisterUrl:registerUrl}));
                    }
                }
            },
            error: function (err) { }
        });

        $("#btnSureButton").click(function(){
            $("#vmask").hide();
        });
    })
</script>

<script type="text/javascript">
    var cookie = readcookie("guideshowed");
    if (!cookie || cookie != "1") {
        $.ajax({
            type: "POST",
            url: "/Ajax/GetGuideStatus.ashx",
            data: {
                refer: document.referrer,
            },
            success: function (data) {
                if (typeof data !== "undefined" && data.CanShow) {
                    $('#guidemask').show();

                    var guide = new Swiper('#div_guide', {
                        autoplay:3000,
                        pagination: '#guide-pointer',
                        loop: true,
                        grabCursor: true,
                        paginationClickable: true,
                        calculateHeight: true
                    });
                    window.onorientationchange = function () {
                        var guide = new Swiper('#div_guide', {
                            calculateHeight: true
                        });
                    };

                    setCookie("guideshowed", "1", 30 * 24 * 3600);
                } else if (typeof data !== "undefined" && !data.CanShow) {
                    setCookie("guideshowed", "1");
                }
            }
        });
    }

    $(".guide-close").click(function () {
        $("#guidemask").hide();
    });
</script>

</div>

@stop
