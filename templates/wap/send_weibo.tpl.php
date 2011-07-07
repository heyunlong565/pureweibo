<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
	<div class="send">
		<form method="post" action="<?php echo WAP_URL('wbcom.postWB'); ?>">
			<span>微博内容:</span><br />
			<textarea id="content" name="content" rows="5" cols="10"></textarea>
			<div><input type="submit" value="发布" /></div>
		</form>
	</div>
	<div class="hint">
		注:<br />
		1、微博内容中两个#之间的文字将作为本条微博的标签.如:我好#幸福#呀.<br />
		2、自动分条发布仅限于小于420字的纯文字微博,140个字以上将自动分条发布,图文微博在发布时只保留文字内容.
	</div>
	</div>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>
