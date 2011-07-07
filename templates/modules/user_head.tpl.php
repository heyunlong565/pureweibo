<?php
if (USER::isUserLogin() && USER::uid() != $userinfo['id']) {
	//获取相互关系
	$friendship = DR('xweibo/xwb.getFriendship', '', $userinfo['id']);
	$friendship = $friendship['rst'];
	
	//我是否关注了ta
	$followed = $friendship['source']['following'] ? 1 : 0;

	//他是否关注了我
	$followedBack = $friendship['source']['followed_by'] ? 2: 0;

	/// 是否加入黑名单
	$isBlocks = DR('xweibo/xwb.existsBlocks', '', V('g:id'), V('g:name'));

	if ($isBlocks['errno'] == 0) {
		$isBlocks = $isBlocks['rst'];
		$blocked = $isBlocks['result'] ? 1 : 0;
	} else {
		$isBlocks = array();;
		$blocked = 0;
	}

	/*
	/// 是否关注了ta
	$isFriends = DR('xweibo/xwb.existsFriendship', '', USER::uid(), $userinfo['id']);
	$isFriends = $isFriends['rst'];

	/// 是否加入黑名单
	$isBlocks = DR('xweibo/xwb.existsBlocks', '', V('g:id'), V('g:name'));

	if ($isBlocks['errno'] == 0) {
		$isBlocks = $isBlocks['rst'];
		$blocked = $isBlocks['result'] ? 1 : 0;
	} else {
		$isBlocks = array();;
		$blocked = 0;
	}

	//我是否关注了他
	$followed = $isFriends['friends'] ? 1: 0;
	
	//他是否关注了我
	$followedBack = in_array($userinfo['id'], $fids) ? 2: 0;
	*/
}

$userDomain = DR('mgr/userCom.getByUid', FALSE, $userinfo['id']);
$userDomain = isset($userDomain['rst']['domain_name']) ? $userDomain['rst']['domain_name']  : '';
?>
<div class="user-head">
    <div class="user-head-pic">
    	<img src="<?php echo APP::F('profile_image_url', $userinfo['profile_image_url'], 'profile');?>" alt="" />
    </div>
    <div class="user-head-c" rel="u:<?php echo $userinfo['id'];?>">
		<h3>
			<?php echo F('escape', $userinfo['screen_name']);?>
			<?php echo F('verified', $userinfo);?>
		</h3>
        <div class="user-url">
	        <?php if( USED_PERSON_DOMAIN && $userDomain ) : ?>
	        	<a href="<?php echo W_BASE_HTTP.W_BASE_URL.$userDomain;?>"><?php echo W_BASE_HTTP.W_BASE_URL.$userDomain;?></a>
	        <?php elseif( USED_PERSON_DOMAIN ) : ?>
	        	<a href="<?php echo W_BASE_HTTP.W_BASE_URL.$userinfo['id'];?>"><?php echo W_BASE_HTTP.W_BASE_URL.$userinfo['id'];?></a>
	        <?php else: ?>
	        	<a href="<?php echo URL('ta', 'id='.$userinfo['id']);?>"><?php echo W_BASE_HTTP.URL('ta', 'id='.$userinfo['id']);?></a>
	        <?php endif ?>
        </div>
        
        <p class="icon-bg <?php if ($userinfo['gender'] == 'f'):?>icon-female<?php elseif ($userinfo['gender'] == 'm'):?>icon-male<?php endif;?>"><?php echo F('escape', $userinfo['location']);?></p>
        <p><?php echo F('escape', $userinfo['description']);?></p>
		<?php if ($userinfo['id'] != USER::uid()):?>
        <div class="opera-area">
			<?php if (USER::isUserLogin()):?>
				<?php if (!$blocked):?>
					<span class="opera-area-r">
						<?php if ($followedBack):?>
							<a href="javascript:;" rel="e:sdm,n:<?php echo $userinfo['screen_name'];?>" id="xwb_sndmsg">发私信</a>
							|
						<?php endif;?>
						<a href="#" id="at_ta" rel="e:sd,m:对 @<?php echo $userinfo['screen_name'];?> 说\:">@<?php if ($userinfo['gender'] == 'f'):?>她<?php elseif ($userinfo['gender'] == 'm'):?>他<?php endif;?></a>
						<?php if ($followed):?>|<a class="more-opera icon-bg" href="#" rel="e:mop" id="more_oper">更多</a><?php endif;?>
					</span>
					<?php if (!$followed):?>
						<a href="#" rel="e:fl,t:3" class="skin-bg addfollow-btn">加关注</a>
					<?php elseif ($followedBack):?>
						<div class="operated-box">
							<div class="icon-each-follow all-bg ">相互关注</div>
							<em>|</em>
							<a class="cancel" rel="e:ufl,t:3" href="#">取消</a>
						</div>
						<div class="more-list hidden" id="more_list">
							<a class="icon-blacklist icon-bg" href="#" rel="e:abl,u:<?php echo $userinfo['id'];?>,nick:<?php echo F('escape', addslashes($userinfo['screen_name']));?>,gender:<?php echo $userinfo['gender'];?>">加入黑名单</a>
						</div>
					<?php else:?>
						<div class="operated-box">
							<span class="followed-btn">已关注</span>
							<em>|</em>
							<a class="cancel" rel="e:ufl,t:3" href="#">取消</a>
						</div>
						<div class="more-list hidden" id="more_list">
							<a class="icon-blacklist icon-bg" href="#" rel="e:abl,u:<?php echo $userinfo['id'];?>,nick:<?php echo F('escape', addslashes($userinfo['screen_name']));?>,gender:<?php echo $userinfo['gender'];?>">加入黑名单</a>
						</div>
					<?php endif;?>
				<?php else:?>
					<div class="operated-box">
						<span class="icon-black">已加入黑名单</span>
						<em>|</em>
						<a class="cancel" href="#" rel="e:dbl,u:<?php echo $userinfo['id'];?>,m:确定将TA从你的黑名单移除？">取消</a>
					</div>
				<?php endif;?>
			<?php else:?>
				<a href="#"  rel="e:fl,t:1" class="skin-bg addfollow-btn">加关注</a>
			<?php endif;?>
        </div>
		<?php else:?>
		<div class="opera-area">
			<span class="opera-area-r">
				<a href="#" rel="e:sd,format:-1" class="icon-bg icon-post-weibo">我要发微博</a>
			</span>
		</div>
		<?php endif;?>
    </div>
</div>
