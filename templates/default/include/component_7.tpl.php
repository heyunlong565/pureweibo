<?php
	/**
	 * 可能感兴趣的人
	 */
	$uid = User::uid();
	
	//未登录，不使用
	if (!$uid) {
		return;
	}

	
	$ret = DR('components/guessYouLike.get', 60);

	if ($ret['errno']) {
		return;
	}

	$rs = &$ret['rst'];
?>
<div class="user-sidebar">
	<div class="sidebar-head"><?php echo F('escape', $mod['title']);?></div>
	<!-- <p>有鼠标滑过头像，会有惊喜发现</p> -->
	<ul>
<?php
	if (!empty($rs)) {
		
		function getRecommendReason($reason) {			
			$texts = array(
				'topic' => '你们有相同的话题',
				'area' => '你们在同一个的地区',
				'tag'  => '你们有相同的标签'
			);

			return isset($texts[$reason]) ? $texts[$reason]: '';
		}

		foreach ($rs as $row) {
		$u = &$row['user'];		

		$nick = F('escape', $u['screen_name']);
		$profile_url = URL('ta', array('id' => $u['id']));
		$img = $u['profile_image_url'];

		//理由
		$reasonText = getRecommendReason($row['reason']);
?>
		<li>
			<a href="<?php echo $profile_url;?>" title="<?php echo $nick;?>"><img src="<?php echo $img;?>" alt="<?php echo $nick;?>" <?php if ($reasonText):?>title="<?php echo $reasonText;?>"<?php endif;?> /></a>
			<p><a href="<?php echo $profile_url;?>"><?php echo $nick;?></a></p>
			<a class="sub-link" rel="e:fl,u:<?php echo $u['id'];?>,t:2" href="#">关注他</a>
		</li>
<?php
		}
	}
?>
	</ul>
</div>
