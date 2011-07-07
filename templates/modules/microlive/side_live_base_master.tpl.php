<!-- 在线主持人 开始-->
<div class="user-list-s1">
	<div class="hd"><h3>微博主持人</h3></div>
	<div class="bd">
		<ul>
			<?php if ($ulist):?>
			<?php foreach ($ulist as $item):?>
			<li>
				<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>" class="user-pic"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></a>
				<div class="user-info">
					<p class="name"><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a></p>
					<?php if (!empty($listFans) && in_array($item['id'], $listFans) || USER::uid() == $item['id']):?>
						<em>已关注</em>
					<?php else:?>
						<a rel="e:fl,t:2" class="addfollow-btn" title="加关注" href="#">加关注</a>
					<?php endif;?>
					<p class="txt">官方主持人</p>
				</div>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
	</div>
</div>
<!-- 在线主持人 结束-->
