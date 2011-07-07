<div class="column-body">
	<?php 
		if (isset($users) && is_array($users)) { 
			$uid = USER::uid();
			foreach ($users as $row) {
	?>
	<div class="column-item" rel="u:<?php echo $row['id'];?>">
		<div class="item-pic">
			<a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name='. urlencode($row['screen_name']));?>" class="user-pic" title="<?php echo htmlspecialchars($row['screen_name']);?>"><img src="<?php echo $row['profile_image_url']?>" alt="<?php echo htmlspecialchars($row['screen_name']);?>的头像" /></a>
			<?php if ($row['id'] != $uid) {?>
			<?php if ($row['following']) {?>
			<span class="followed-btn">已关注</span>
			<?php } else {?>
			<a class="addfollow-btn"  rel="e:fl,t:1" href="#">加关注</a></li>
			<?php }?>
			<?php }?>
		</div>
		<a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name=' . urlencode($row['screen_name']));?>" class="nick" title="<?php echo htmlspecialchars($row['screen_name']);?>">
		<?php echo htmlspecialchars($row['screen_name']);?>
		<?php echo F('verified', $row);?>
		</a>
		<span class="info"><?php echo htmlspecialchars($row['description']);?></span>
	</div>
	<?php }}?>
</div>
