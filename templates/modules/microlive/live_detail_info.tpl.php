<!-- 视频 开始-->
<?php if ( isset($liveInfo['code']) && !empty($liveInfo['code']) ) {?>
<div class="video-cont">
	<?php echo $liveInfo['code'];?>
</div>
<?php } ?>
<!-- 视频 结束-->

<!-- 直播简介 开始-->
<div class="live-intro">
	<div class="tit-hd">
		<?php if ($liveInfo['start_time'] <= APP_LOCAL_TIMESTAMP && $liveInfo['end_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="going">(进行中)</span>
		<?php elseif ($liveInfo['start_time'] > APP_LOCAL_TIMESTAMP):?>
		<span class="not-started">(未开始)</span>
		<?php else:?>
		<span class="closed">(已结束)</span>
		<?php endif;?>
		<h3>直播简介</h3>
	</div>
	<div class="bd">
		<div class="info">
			<p>
				<span class="label">直播时间：</span>
				<span class="time"><?php echo F('format_time.foramt_show_time',$liveInfo['start_time']);?> - <?php echo F('format_time.foramt_show_time',$liveInfo['end_time']);?></span>
			</p>
			<p><?php echo F('escape', $liveInfo['desc']);?></p>
			<span class="icon-mic icon-bg"></span>
		</div>
		<a href="#" class="btn-recommend" rel="e:sd,m:<?php echo F('share_weibo', 'live', $liveInfo);?>">推荐给好友</a>
	</div>
</div>
<!-- 直播简介 结束-->
