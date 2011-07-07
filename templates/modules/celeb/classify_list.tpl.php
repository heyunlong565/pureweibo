<?php
//分类目录 （目前用于名人堂）
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<div class="classify-list">
<ul>
    <?php if (isset($sort_list) && is_array($sort_list) && !empty($sort_list)) {foreach($sort_list as $key=>$rs):?>
    <li>
        <div class="main-tag skin-bg"><a href="<?php echo URL('celeb.starSortList', 'id='.$key);?>" title="<?php echo F('escape',strip_tags($rs['name']));?>"><?php echo strip_tags($rs['name']);?></a></div>
        <p class="taglinks">
            <?php foreach($rs['data'] as $value):?>
                <?php if(!isset($value['status']) || !$value['status']){continue;} ?>
                <a href="<?php echo URL('celeb.starChildSortList', 'id='.$value['id']);?>"  style="<?php if(isset($value['color'])) echo 'color:'.$value['color'];?>"><?php echo strip_tags($value['name']);?></a>
            <?php endforeach;?>
        </p>
    </li>
    <?php endforeach;} else {?>
		<?php if (USER::aid()) {?>
			名人堂还没有内容，请到<b>后台管理中心</b>-<b>用户管理</b>-<a href="<?php echo URL('mgr/admin.index','#4,4', 'admin.php');?>">名人管理</a>中添加设置
		<?php } else {?>
			名人堂还没有内容，等待管理员添加，你可以访问其他页面碰碰运气
		<?php }?>
	<?php }?>
</ul>
</div>
