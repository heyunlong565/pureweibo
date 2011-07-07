<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo', '', false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	TPL::plugin('wap/include/my_preview', $uInfo, false);
	?>
    <div class="row"><span>修改资料</span>&nbsp;<a href="<?php echo WAP_URL('index.setinfo', 'type=2'); ?>">显示</a></div>
    <form method="post" action="<?php echo WAP_URL('wbcom.saveInfo'); ?>">
	    <div class="c"><span class="r">*</span>昵称:<input type="text" name="nick" value="<?php echo F('escape', $uInfo['screen_name'], ENT_QUOTES); ?>" /></div>
	    <div class="c"><span class="r">*</span>性别:<input type="radio" name="gender" value="m" <?php echo (!isset($uInfo['gender']) || $uInfo['gender'] != 'f') ? 'checked="checked"' : ''; ?> />男&nbsp;<input type="radio" name="gender" value="f" <?php echo (isset($uInfo['gender']) && $uInfo['gender'] == 'f') ? 'checked="checked"' : ''; ?> />女</div>
	    <div class="c">一句话介绍(不能超过70个字):<br /><textarea rows="2" name="description"><?php echo F('escape', $uInfo['description'], ENT_QUOTES); ?></textarea><br /><input type="submit" value="保存" /></div>
    </form>
	<?php
	TPL::plugin('wap/include/search', '', false);
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>
