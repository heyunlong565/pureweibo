<?php
	$ret = DR('components/pubTimeline.get', 60);

	if ($ret['errno']) {
		return;
	}
	
	$list = &$ret['rst'];

	//如果数据为空，则不输出
	if (empty($list)) {
		return ;
	}
?>
<div class="pub-feed-list">
    <div class="column-title">
        <div></div>
		<a class="icon-change" href="<?php echo URL('pub.look');?>">更多>></a>
        <h3><?php /*随便看看*/ echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="feed-list">
    <?php

		TPL::plugin('include/feedlist', array('list' => $list));
	?>
	</div>
</div>