<link href="<?php echo W_BASE_URL; ?>css/default/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL; ?>css/default/<?php define('SKIN_CSS_PATH', 'skin_default'); echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL; ?>css/default/app.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<?php 
	if ($interview['custom_color'])
	{ 
		$customs = explode(',', $interview['custom_color']);
?>
	html { background-color:<?php echo isset($customs[0])?$customs[0]:'#8DD7F5'; ?>;}
	a,
	a:hover,
	.feed-list .feed-info span a,
	.feed-list .feed-info p a,
	.gotop .txt,
	#footer .ft-con a { color:<?php echo isset($customs[1]) ? $customs[1] : '' ;?>;}
<?php } ?>

.wrap-in { background:url(<?php echo $interview['backgroup_img'];?>) <?php if ($interview['backgroup_style'] == 2):?>no-repeat center top<?php endif;?>;}
</style>