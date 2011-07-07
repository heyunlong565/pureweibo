<?php
	/**
	 * 可能感兴趣的人模块模板
	 * 需要参数参见component_7_pls
	 * @version $Id$
	 */
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}

if(!function_exists('getRecommendReason')){
	function getRecommendReason($reason) 
	{			
		static $texts = array(
			'topic' => '你们有相同的话题',
			'area'  => '你们在同一个地区',
			'tag'   => '你们有相同的标签'
		);
		return isset($texts[$reason]) ? $texts[$reason]: '';
	}
}

?>

<div class="user-list-s1">
	<div class="hd"><h3><?php echo F('escape', $mod['title']);?></h3></div>
	<!-- <p>有鼠标滑过头像，会有惊喜发现</p> -->
	<div class="bd">
		<ul>
		<?php
			if (!empty($rs)) 
			{
		
				foreach ($rs as $row) 
				{
					$u 			 = &$row['user'];		
					$nick 		 = F('escape', $u['screen_name']);
					$profile_url = URL('ta', array('id' => $u['id']));
					$img 		 = $u['profile_image_url'];
					$reasonText  = getRecommendReason($row['reason']);	//理由

					$description = F('escape', $u['description']);
					if(!F('user_action_check',array(2,3),$u['id']))
					{
		?>

					<li>
						<a href="<?php echo $profile_url;?>" class="user-pic" title="<?php echo $nick;?>"><img src="<?php echo $img;?>" alt="<?php echo $nick;?>" <?php if ($reasonText):?>title="<?php echo $reasonText;?>"<?php endif;?> /></a>
					<div class="user-info">

						<p class="name"><a href="<?php echo $profile_url;?>"><?php echo $nick;?></a></p>
						<?php if (isset($followedList[(string)$u['id']])):?>
							<em>已关注</em>
						<?php else: ?>
							<a class="addfollow-btn" rel="e:fl,u:<?php echo $u['id'];?>,t:2" href="#">加关注</a>
						<?php endif;?>
						<p class="txt"><?php echo $reasonText;?></p>
						</div>

						
					</li>
		<?php
					}
				}
			}
		?>
		</ul>
	</div>
</div>
