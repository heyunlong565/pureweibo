<?php if ( is_array($guestList) ) { ?>
<div class="user-sidebar">
	<div class="tit-hd">
    	<h3>特邀嘉宾</h3>
	</div>
	
	<ul>
		<?php 
			foreach ($guestList as $aGuest) 
			{ 
				$userInfo = F('user_filter', $aGuest, TRUE);
		?>
		<li rel="u:<?php echo $aGuest['id']; ?>" >
	        <a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>"><img src="<?php echo $aGuest['profile_image_url']; ?>" alt="" /></a>
	        <p><a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>" title="<?php echo $aGuest['screen_name']; ?>"><?php echo $aGuest['screen_name'].F('verified', $userInfo); ?></a>
	        </p>
        </li>
        <?php } ?>
	</ul>
	<a href="#" rel="e:followall" class="general-btn"><span>全部关注</span></a>
</div>
<?php } ?>