<?php 
	/**
	 * 本站最新开通微博的用户列表
	 * 需要参数参见component_15_pls
	 * @version $Id: component_15.tpl.php 14573 2011-04-26 06:28:14Z linyi1 $
	 */
	if(!defined('IN_APPLICATION')){
		exit('ACCESS DENIED!');
	}
	
?>

<div class="user-sidebar">
    <div class="hd"><h3><?php echo F('escape', $mod['title']);?></h3></div>
	<div class="bd">
    <ul>
	<?php
		$uid = USER::uid();
		
		foreach ($userList as $u) {
			$user_img = F('profile_image_url', $u['sina_uid']);
			$nick = F('escape', $u['nickname']);
			$url = URL('ta', array('id' => $u['sina_uid']));
	?>
        <li rel="u:<?php echo $u['sina_uid'];?>">
            <a href="<?php echo $url;?>"><img src="<?php echo $user_img;?>" alt="<?php echo $nick;?>" /></a>
            <p><a href="<?php echo $url;?>"><?php echo $nick;?></a></p>
			<?php if ((string)$u['sina_uid'] !== (string)$uid) {?>
				<?php if (!isset($followedList[(string)$u['sina_uid']])):?>
				<a href="#" class="sub-link" rel="e:fl,t:2">加关注</a>
				<?php else:?>
				<em>已关注</em>
				<?php endif;?>
			<?php } else {?>
				<em>&nbsp;</em>
			<?php }?>
        </li>
	<?php } ?>
    </ul>
	</div>
</div>
