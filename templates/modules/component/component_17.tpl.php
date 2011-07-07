<?php
	/**
	 * 微博广场模块
	 * 需要参数参见component_17_pls
	 * @author yaoying
	 * @version $Id: component_17.tpl.php 10863 2011-02-28 07:11:07Z yaoying $
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
?>

<div class="pub-feed-list">
    <div class="column-title">
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
		<?php Xpipe::pagelet('component/component_common.hotWB_getComment', $mod); ?>
    </div>
</div>