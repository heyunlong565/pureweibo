<!--活动列表-->
<?php
///缺少样式
//var_dump($events);
?>
<div class="recent-event">
    <div class="hd">
        <h3><?php echo isset($mod['newTitle'])?$mod['newTitle']:'活动列表';?></h3>
    </div>
    <div class="bd">
        <ul>
			<?php
			if(empty($events)){
				echo '记录为空';
			}
			else
				foreach($events as $row):
				?>
				<li>
					<a class="tit-event" href="<?php echo URL('event.details','eid=' . $row['id']);?>"><?php echo F('escape', $row['title']);?></a>
					<p>时间：</p>
					<p><?php echo F('format_time.foramt_show_time',$row['start_time']);?> -</p>
					<p><?php echo F('format_time.foramt_show_time',$row['end_time']);?></p>
				</li>
				<?php
				endforeach;
				?>
        </ul>
    </div>
</div>
