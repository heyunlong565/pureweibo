<?php 

	/**
	 * 明星推荐列表模块模板
	 * 需要参数参见component_2_pls
	 * @version $Id$
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>
<div class="user-recommed">
    <div class="title-box">
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="user-list-wrap">
<?php
	
	//关注列表
	$uid = USER::uid();
	$i = 1;
	foreach ($rs as $star) {
		$is_odd = ($i & 1) ? true : false;
		$star['uid'] = isset($star['uid']) ? $star['uid'] : $star['id'];
		$nick = isset($star['screen_name']) ? F('escape', $star['screen_name']) : F('escape', $star['nickname']);
		$user_img = isset($star['profile_image_url']) ? F('profile_image_url', $star['profile_image_url']) : F('profile_image_url', $star['uid']);
		if(isset($star['remark'])){
			$remark = F('escape', $star['remark']);
		}elseif(isset($star['description'])){
			$remark = F('escape', $star['description']);
		}else{
			$remark = '';
		}
		
		$profile_url = URL('ta', array('id' => $star['uid']));
?>
		<div class="user-item" rel="u:<?php echo $star['uid'];?>">
			<div class="user-pic">
				<a href="<?php echo $profile_url;?>"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>的头像" /></a>
			</div>

			<?php if (!isset($followedList[(string)$star['uid']])):?>
                <a class="addfollow-btn" rel="e:fl,t:1" href="#">加关注</a>
			<?php else:?>
				<span class="followed-btn">已关注</span>
			<?php endif;?>

			<div class="user-info">
				<a class="u-name" href="<?php echo $profile_url;?>"><?php echo $nick; echo F('verified', $star); ?></a>
				<?php if (isset($star['location']) && isset($star['gender'])) {?>
				<span class="icon-bg <?php echo $star['gender'] == 'f' ? 'icon-female' : 'icon-male'; ?>"><?php echo $star['location']; ?></span>
				<?php }?>
		        <p><?php echo mb_strwidth($remark, 'UTF-8') > 30 ? mb_substr($remark, 0, 13, 'UTF-8') . '...' : $remark; ?></p>
			</div>
        </div>
<?php
		$i++;
	}
?>
	<?php if (count($rs) %2 !== 0) {?>
		<div class="user-item"></div>
	<?php }?>

	</div>
</div>
