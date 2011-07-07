<div class="user-sidebar">
    <div class="sidebar-head"><?php echo F('escape', $mod['title']);?></div>
    <ul>
<?php
	//用户推荐
	$ret = DR('components/recommendUser.get', 300);

	if ($ret['errno']) {
		return;
	}

	$rs = &$ret['rst'];
	
	$uid = USER::uid();
	
	if ($uid) {
		//关注列表
		$flRet = DR('xweibo/xwb.getFriendIds', 'g2/300', null, $uid, null, null, null, 2000);

		$flw = $flRet['errno'] == 0 ? $flRet['rst']: array();
	}
	
	foreach ($rs as $u) {
	$user_img = F('profile_image_url', $u['uid']);
	$nick = F('escape', $u['nickname']);
	$url = URL('ta', array('id' => $u['uid']));
	$followed = $uid ? in_array($u['uid'], $flw['ids']): false;
?>
        <li rel="u:<?php echo $u['uid'];?>">
            <a href="<?php echo $url;?>"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>" /></a>
            <p><a href="<?php echo $url;?>"><?php echo $nick;?></a></p>
<?php if ((int)$u['uid'] !== (int)$uid) {?>
<?php if (!$followed):?>
			<a href="#" class="sub-link" rel="e:fl,t:2">关注他</a>
<?php else:?>
		<em>已关注</em>
<?php endif;?>
<?php }?>
        </li>
<?php
	}
?>
    </ul>
</div>
