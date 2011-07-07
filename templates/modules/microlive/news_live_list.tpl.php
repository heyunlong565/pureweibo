<div class="tit-hd">
	<h3>精彩直播</h3>
</div>
<div class="talk-list">
	<?php if ($list):?>
	<?php foreach ($list as $item):?>
	<div class="item">
		<div class="cover">
			<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><img src="<?php echo $item['cover_img'];?>" target="_blank" alt="" /></a>
		</div>
		<div class="info">
			<h4>
			<a href="<?php echo URL('live.details', array('id' => $item['id']));?>" target="_blank"><?php echo F('escape', $item['title']);?></a>
			<?php if ($item['start_time'] <= APP_LOCAL_TIMESTAMP && $item['end_time'] > APP_LOCAL_TIMESTAMP):?>
			<span class="active">(进行中)</span>
			<?php elseif ($item['start_time'] > APP_LOCAL_TIMESTAMP):?>
				<?php if ($item['notice_time'] >= APP_LOCAL_TIMESTAMP):?>
				<a class="icon-remind icon-bg" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', $item['title']);?>,c:<?php echo F('share_weibo', 'live_tips', $item);?>,n:<?php echo $item['notice_time'];?>">提醒我</a>
				<?php endif;?>
			<span class="unplayed">(未开始)</span>
			<?php else:?>
			<span class="finish">(已结束)</span>
			<?php endif;?>
			</h4>
			<p class="time"><?php echo F('format_time.foramt_show_time',$item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$item['end_time']);?></p>
			<p><?php echo F('escape', $item['desc']);?></p>
		</div>
	</div>
	<?php endforeach;?>
	<?php TPL::module('page', array('list' => $list, 'count' => $count, 'limit' => $limit, 'type' => 'live'));?>
	<?php else:?>
	<div class="default-tips">
		<div class="icon-tips all-bg"></div>
		<?php if (USER::get('isAdminAccount')):?>
		<p>还没有在线直播，你可以在 后台管理中心-扩展工具-在线直播 添加设置</p>
		<?php else:?>
		<p>还没有在线直播，你可以看看其他页面。 </p>
		<?php endif;?>
	</div>
	<?php endif;?>
</div>
