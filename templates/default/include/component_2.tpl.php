<div class="fame-list">
    <div class="column-title">
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="column-body">
<?php
/**
 * 名人推荐
 */

	$uid = USER::uid();
	
	//明星推荐列表
	$ret = DR('components/star.get', 300);

	if ($ret['errno']) {
		return;
	}

	$rs = &$ret['rst'];
	
	//关注列表
	if ($uid) {
		 $flRet = DR('xweibo/xwb.getFriendIds', 'g2/300', null, $uid, null, null, null, 2000);

		 $flw = $flRet['errno'] == 0 ? $flRet['rst']: array();
	}
	
	foreach ($rs as $star) {
	
	//判断用户是否已经关注明星
	$isFlw = $uid ? in_array($star['uid'], $flw['ids']): false;
	$user_img = F('profile_image_url', $star['uid']);
	$nick = F('escape', $star['nickname']);
	$remark = F('escape', $star['remark']);
	$profile_url = URL('ta', array('id' => $star['uid']));
?>
        <div class="column-item" rel="u:<?php echo $star['uid'];?>">
            <div class="item-pic">
                <a href="<?php echo $profile_url;?>" class="user-pic"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>的头像" /></a>
<?php if ($uid != $star['uid']):?>
			<?php if (!$isFlw):?>
                <a class="skin-bg addfollow-btn" rel="e:fl" href="javascript:;">加关注</a> 
			<?php else:?>
				<span class="followed-btn">已关注</span>
			<?php endif;?>
<?php endif;?>
            </div>                            
            <a href="<?php echo $profile_url;?>" class="nick"><?php echo $nick;?></a>
            <span class="info"><?php echo $remark;?></span>
        </div>
<?php
	}
?>
	</div>
</div>