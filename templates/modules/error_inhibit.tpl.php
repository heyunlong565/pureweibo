<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>禁止登录 - Powered By X微博</title>
<link rel="stylesheet" href="<?php echo W_BASE_URL ?>css/default/error.css" type="text/css" />
</head>
<body id="error">
	<div id="wrap">
    	<div class="error err-inhibit">
        	<div class="error-con">
            	<p>对不起，你已经被禁止登录了！</p>
                <p><!--<a href="javascript:history.go(-1);">返回上一页</a>-->
				<a href="<?php echo URL('account.logout'); ?>">退出登录，并回到首页</a>
				</p>
            </div>
        </div>
    </div>
</body>
</html>
