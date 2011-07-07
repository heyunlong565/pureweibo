<?php if (USER::isUserLogin()):?>
<?php
$myself = true; 
if (isset($userinfo) && !empty($userinfo)) {
	$myself = $userinfo['id'] == USER::uid() ? $myself : false;
	$name = $userinfo['screen_name'];
	/// 获取标签
	$taglist = DR('xweibo/xwb.getTagsList', '', $userinfo['id']);
} else {
	$name = '我';
	/// 获取标签
	$taglist = DR('xweibo/xwb.getTagsList', '', USER::uid());
}
$taglist = $taglist['rst'];
?>
<?php if ($myself || (!$myself && !empty($taglist))):?>
<div class="user-tag">
	<div class="hd">
	<h3><?php echo F('escape', $name);?>的标签</h3>
	</div>
	<div class="bd">
		<?php if ($taglist):?>
		<?php foreach($taglist as $tag):?>
			<?php foreach ($tag as $key => $item):?>
				<a href="<?php echo URL('search.user', array('k' => $item, 'ut' => 'tags'));?>"><?php echo $item;?></a>
			<?php endforeach;?>
		<?php endforeach;?>
		<?php else:?>
			<p>你还没有设置标签。<br /><a href="<?php echo URL('setting.tag');?>">立即添加</a></p>
		<?php endif;?>
	</div>
	<?php if ($myself):?>
	<div class="tag-set">
		<a href="<?php echo URL('setting.tag');?>">设置</a>
	</div>
	<?php endif;?>
</div>
<?php endif;?>
<?php endif;?>
