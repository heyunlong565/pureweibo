<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<p>您尚未开通<?php echo F('escape', $site_name); ?>，绑定新浪微博账号可立即开通。</p>
<form action="<?php echo WAP_URL('account.doLogin'); ?>" method="post">
新浪微博账号:<br/><input type="text" name="account" size="30" value=""/>
<br/>
密码:<br/><input type="password" name="password" size="30" value=""/><br/>
<input type="hidden" name="backURL" value="" />
<input type="hidden" name="loginType" value="2" />
<input type="submit" name="submit" value="绑定" /><br/>
</form>
</body>
</html>