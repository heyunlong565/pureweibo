<?php
	/**
	 * 随便看看模块模板
	 * 需要参数参见component_9_pls
	 * @version $Id$
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<div class="pub-feed-list">
    <div class="column-title">
        <div></div>
		<a class="icon-change" href="<?php echo URL('pub.look');?>">更多&gt;&gt;</a>
        <h3><?php /*随便看看*/ echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
    <?php
		TPL::module('feedlist', array('list' => $list));
	?>
	</div>
</div>
