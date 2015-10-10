<?

function ismobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;

    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if (isset ($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array(
            'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg',
            'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone',
            'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb',
            'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}


if(ismobile())
{
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>请登录</title>
    </head>
    <body>
    <script>
        window.parent.location.href="/auth/login?id="+Math.random();
    </script>

    </body>
    </html>

    <?
    exit();
}else{?>




@extends('layouts.master')
@section('title')
    @parent
@stop
@section('content')
        <style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
                color: #b0bec5;
                font-weight: 100;
			}

			.container {
				text-align: center;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}
		</style>
        <div class="page-error">
		<div class="container">
			<div class="content">
				<div class="title">请先登录</div>
                <div id="ShowDiv"></div>
			</div>
		</div></div>
    <script type="text/javascript">
        var secs = 1; //倒计时的秒数
        for(var i=secs;i>=0;i--)
        {
            window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000);
        }
        function doUpdate(num)
        {
            document.getElementById('ShowDiv').innerHTML = num+'秒后自动跳转到登录页面' ;
          //  if(num == 0) { window.location = "/auth/login?refe="+window.location.href; }
            if(num == 0) { window.location = "/auth/login" ;}
        }
    </script>
@stop


<?}?>