<?php
	/**
	 * 当前站点最新微博模块
	 * 需要参数参见component_14_pls
	 * @version $Id: component_14.tpl.php 10890 2011-02-28 11:06:34Z yaoying $
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<div class="pub-feed-list">
    <div class="column-title">
        <div></div>
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
    
	<div class="feed-list">
    <?php
		TPL::module('feedlist', array('list' => $list));
	?>
	</div>
</div>
