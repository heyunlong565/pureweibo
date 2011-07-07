<div class="emcee-list">
	<div class="tit-hd">
		<h3>主持人</h3>
	</div>
	<div class="bd">
		<ul>
			<?php if ($master_list):?>
			<?php foreach ($master_list as $item):?>
			<li rel="u:<?php echo $item['id'];?>">
				<a class="user-pic" href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<p>
					<a class="user-name" href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a>
				</p>
				<a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</div>

<div class="user-sidebar">
	<div class="tit-hd">
		<h3>特邀嘉宾</h3>
	</div>
	<ul>
		<?php if ($guest_list):?>
		<?php foreach ($guest_list as $item):?>
			<li rel="u:<?php echo $item['id'];?>">
			<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<p><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?><?php echo F('verified', $item);?></a></p>
			</li>
		<?php endforeach;?>
		<?php endif;?>
	</ul>
	<a href="javascript:;" class="general-btn" rel="e:followall"><span>全部关注</span></a>
</div>
