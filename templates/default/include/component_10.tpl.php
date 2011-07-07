<?php
	/**
	 * 今日话题模块
	 *
	 *
	 */
//	 DD('components/todayTopic.get');
	 $rs = DR('components/todayTopic.get', '300');

	 if ($rs['errno']) {
		 return;
	 }

	 $today = &$rs['rst'];

     //如果没有关键字，直接退出
	 if (!$today['keyword']) {
		 return;
	 }

	 $uid = USER::uid();
?>
<div class="hot-topic">
	<div class="column-title">
		<h3><?php echo F('escape', $mod['title']);?></h3>
		<span class="theme">大家都在聊<a hideFocus="true" href="<?php echo URL('search.weibo', array('k' => $today['keyword']));?>"><?php echo F('escape', $today['keyword']);?></a></span>
		<a hideFocus="true" title="我也说几句" href="#" rel="e:sd,m:<?php echo $today['keyword']?'#'.addslashes($today['keyword'].'#'):'';?>" class="say-btn">我也说几句</a>
	</div>
<?php

if ($today['errno'] == 0) {

	if (!empty($today['data']['rst'])) {

?>
	<div class="column-body" id="xwb_today_topic">
<?php
		
		$uid = USER::uid();
		
		//关注列表
		if ($uid) {
			$flRet = DR('xweibo/xwb.getFriendIds', 'g2/300', null, $uid, null, null, null, 2000);
			$flw = $flRet['errno'] == 0 ? $flRet['rst']: array();
		}
			
		foreach ($today['data']['rst'] as $tp) {
			$user = &$tp['user'];

			$showFollow = true;
			$followed = false;
			
			if ($uid) {
				if ($uid != $user['id']) {
					//关注检查
					$followed = !empty($flw) ? in_array($user['id'], $flw['ids']): false;
				} else {
					$showFollow = false;
				}
			}
			
			//昵称
			$nick = F('escape', $user['screen_name']);
			
			$user_img = F('profile_image_url', $user['id']);
			
			$profile_url = URL('ta', array('id' => $user['id'], 'name' => $user['screen_name']));
			
			$text = F('format_text', $tp['text']);
?>
		<div class="column-item next" rel="u:<?php echo $user['id'];?>">
<?php if ($showFollow):?>
			<?php if ($followed):?>
				<span class="followed-btn">已关注</span>
			<?php else: ?>
				<a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
			<?php endif;?>
<?php endif;?>
			<a href="<?php echo $profile_url;?>" class="side user-pic"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>的头像" /></a>
			<div class="content">
				<a href="<?php echo $profile_url;?>" class="nick"><?php echo $nick;?></a>
				<p class="info icon-bg icon-<?php if ($user['gender'] == 'f'):?>female<?php else:?>male<?php endif;?>"><span class="location"><?php echo $user['location'];?></span><span class="fans">粉丝<span><?php echo $user['followers_count'];?></span>人</span></p>
				<p class="feedback"><?php echo $text;?></p>
			</div>
		</div>
<?php
		}
?>
	</div>
<?php
	} else {
?>
<div class="column-body" style="height:50px;">
	<div class="int-box load-fail icon-bg">此话题暂无相关内容。</div>
</div>
<?php
	}
} else {
?>
<div class="column-body" style="height:50px;">
	<div class="int-box load-fail icon-bg">获取热门微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!</div>
</div>
<?php 
}
?>
</div>