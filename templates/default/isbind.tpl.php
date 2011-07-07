<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>oauth授权 - Powered By X微博</title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<style type="text/css">
body, p, h1{ margin:0; padding:0;}
em{ font-style:normal;}
body {font:12px/1.5 Tahoma, Geneva, sans-serif;}
a:link, a:visited {color:#0082cb;text-decoration:none;}
a:hover {color:#0082cb;text-decoration:underline;}
#wrapper {margin:0 auto;width:510px;overflow:hidden;}
.oauth-box {background:url(<?php echo W_BASE_URL;?>css/bgimg/oauth_bg.png) no-repeat;height:400px;padding:0 40px;width:430px;}
.oauth-box .header {padding-top:11px;overflow:hidden;}
.oauth-box .header h1 {background:url(<?php echo W_BASE_URL;?>css/bgimg/sina_logo.png) no-repeat;height:47px;width:136px;text-indent:-9999px;}
.oauth-box .header h1 a {display:block;height:47px;width:136px;outline:none;}
.oauth-box .header .agreement {float:right;margin-top:30px;}
.isbound-con {margin-top:120px;text-align:center;}
.isbound-con p {line-height:1.8;}
.isbound-con p em {color:#0082cb;}
</style>
</head>
<body>
	<div id="wrapper">
		<div class="oauth-box">
			<div class="header">
				<a href="http://login.sina.com.cn/regagreement.html" target="_blank" class="agreement">新浪网络服务使用协议</a>
				<h1><a href="http://t.sina.com.cn" target="_blank" title="新浪微博">新浪微博</a></h1>
			</div>
			<div class="isbound-con">
				<p><strong>您的<em><?php echo $user_name; ?></em>新浪微博帐号已绑定过了，换个帐号试试吧</strong></p>
				<p>[<span  id='time_sec'>5</span>]秒后自动跳转，如果浏览器没有反应，请<a href="<?php echo $sina_login_url ;?>">点击这里</a></p>
			</div>
		</div>
	</div>
<script language='javascript' type='text/javascript'> 
var URL ; 
function jumpTimeout(url,timeout){ 
	URL =url; 
	for(var i=timeout;i>=0;i--){ 
		window.setTimeout('doUpdate(' + i + ')', (timeout-i) * 1000); 
	} 
} 

function doUpdate(num){ 
	document.getElementById('time_sec').innerHTML = num; 
	if(num == 0) { window.location=URL; } 
}

jumpTimeout("<?php echo $sina_login_url ;?>", 5);
</script>

</body>
</html>