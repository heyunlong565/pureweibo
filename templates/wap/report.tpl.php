<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
	<?php
	if($withid):
	?>
	
	<div class='c'>
		<div>举报用户:<?php echo $info['user']['screen_name']?></div>
		<div>举报原因:</div>
		<form method="post" action="<?php echo WAP_URL('show.reportSpamResult')?>">
		<input type="hidden" name="cid" value="<?php echo $info['id']?>"/>
		<textarea id="content" name="content" rows="5" cols="10"></textarea>
		<div><input type="submit" value="提交" /></div>
		</form>
	</div>
	<div class='c'>
		<div>
			举报内容:<br />
			<?php
			echo $info['text'];
			?>
		</div>
		
	<?php
	else:
	?>
	<div>对不起，请选择特定的微博再进行举报！</div>
	<?php
	endif;
	?>
	<br/>
		<div>
			
			如果您在微博中发现有色情、暴力或者其它违规的内容,请提交上述信息,我们将尽快处理.您的隐私会得到严格的保护.每周还将有机会获得我们送出的精美礼品.<br />
			举报电话:4006900000 听到提示音后按2键(按当地市话标准计费)
		</div>
	</div>
		<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
	?>
</body>
</html>
