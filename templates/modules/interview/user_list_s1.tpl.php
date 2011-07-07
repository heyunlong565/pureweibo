<?php if ( is_array($masterList) ) { ?>
<div class="user-list-s1">
	<div class="hd"><h3>微博主持人</h3></div>
	<div class="bd">
		<ul>
			<?php 
				foreach ($masterList as $aMaster) 
				{ 
					$userInfo = F('user_filter', $aMaster, TRUE);
			?>
			<li rel="u:<?php echo $aMaster['id']; ?>" >
	           	<a class="user-pic" href="<?php echo URL('ta', array('id'=>$aMaster['id'])); ?>"><img src="<?php echo $aMaster['profile_image_url']; ?>" alt="" /></a>
	           	<div class="user-info">
	            	<p class="name"><a href="<?php echo URL('ta', array('id'=>$aMaster['id'])); ?>"><?php echo $aMaster['screen_name'].F('verified', $userInfo); ?></a></p>
	         	<?php if ( $aMaster['id'] == USER::uid() ) { ?>
	         		<span>&nbsp;</span>
				<?php } else if ( isset($friendList[$aMaster['id']]) ) { ?>
	         		<span class="followed-btn">已关注</span>
	         	<?php } else { ?>
	         		<a href="#" class="addfollow-btn" rel="e:fl,t:1" >加关注</a>
	         	<?php } ?>
	         		<p class="txt">官方主持人</p>
	         	</div>
            </li>
      		<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>