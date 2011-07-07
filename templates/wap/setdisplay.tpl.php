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
	<div class="row">
		<a href="<?php echo WAP_URL('index.setinfo', 'type=1'); ?>">修改资料</a>&nbsp;显示
	</div>
	<div class="c">
	<form action="<?php echo WAP_URL('wbcom.saveDisplayset'); ?>" method="post">
		<div>页面字体大小：</div>
		<div>
			<label><input type="radio" name="wap_font_size" value="1" <?php echo V('-:userConfig/wap_font_size', 1) == '1' ? 'checked="checked"' : ''; ?> />小</label>
			<label><input type="radio" name="wap_font_size" value="2" <?php echo V('-:userConfig/wap_font_size') == '2' ? 'checked="checked"' : ''; ?> />中</label>
			<label><input type="radio" name="wap_font_size" value="3" <?php echo V('-:userConfig/wap_font_size') == '3' ? 'checked="checked"' : ''; ?> />大</label>
			<label><input type="radio" name="wap_font_size" value="4" <?php echo V('-:userConfig/wap_font_size') == '4' ? 'checked="checked"' : ''; ?> />超大</label>
		</div>
		<div>微博内容中是否显示缩略图:</div>
		<div>
			<label><input type="radio" name="wap_show_pic" value="1" <?php echo V('-:userConfig/wap_show_pic', 1) == '1' ? 'checked="checked"' : ''; ?> />显示</label>
			<label><input type="radio" name="wap_show_pic" value="0" <?php echo V('-:userConfig/wap_show_pic') == '0' ? 'checked="checked"' : ''; ?> />不显示</label>
		</div>
		<div>我的首页微博显示条数:</div>
		<div>
			<label><input type="radio" name="wap_page_wb" value="5" <?php echo V('-:userConfig/wap_page_wb') == '5' ? 'checked="checked"' : ''; ?> />5</label>
			<label><input type="radio" name="wap_page_wb" value="10" <?php echo V('-:userConfig/wap_page_wb', 10) == '10' ? 'checked="checked"' : ''; ?> />10</label>
			<label><input type="radio" name="wap_page_wb" value="20" <?php echo V('-:userConfig/wap_page_wb') == '20' ? 'checked="checked"' : ''; ?> />20</label>
			<label><input type="radio" name="wap_page_wb" value="30" <?php echo V('-:userConfig/wap_page_wb') == '30' ? 'checked="checked"' : ''; ?> />30</label>
			<label><input type="radio" name="wap_page_wb" value="40" <?php echo V('-:userConfig/wap_page_wb') == '40' ? 'checked="checked"' : ''; ?> />40</label>
			<label><input type="radio" name="wap_page_wb" value="50" <?php echo V('-:userConfig/wap_page_wb') == '50' ? 'checked="checked"' : ''; ?> />50</label>
		</div>
		<div>数值越大消耗流量越多，大于10条部分手机可能无法正常显示</div>
		<input type="submit" value="保存" />
	</form>
	</div>
	<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot', '', false);
	?>
</body>
</html>