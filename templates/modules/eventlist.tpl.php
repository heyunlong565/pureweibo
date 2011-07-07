<?php if (is_array($list) && !empty($list)):?>
	<?php foreach ($list as $item):?>
	<div class="event-list" rel="eid:<?php echo $item['id'];?>,m:<?php echo F('share_weibo', 'event_attend', $item);?>,m1:<?php echo F('share_weibo', 'event', $item);?>,other:<?php echo $item['other'] ;?>">
		<div class="cover">
		<a href="<?php echo URL('event.details', 'eid='.$item['id']);?>"><img src="<?php echo $item['pic'];?>" alt="活动封面" /></a>
			<div class="cover-bg"></div>
		</div>
		<div class="event-info">
		<h3><a href="<?php echo URL('event.details', 'eid='.$item['id']);?>"><?php echo F('escape', $item['title']);?></a></h3>
			<div class="info-item">
				<div class="item-l">时　　间：</div>
				<div class="item-c"><?php echo F('format_time.foramt_show_time',$item['start_time']);?> - <?php echo F('format_time.foramt_show_time',$item['end_time']);?></div>
			</div>
			<div class="info-item">
				<div class="item-l">地　　点：</div>
				<div class="item-c"><?php echo F('escape', $item['addr']);?></div>
			</div>
			<div class="info-item">
				<div class="item-l">发<i></i>起<i></i>者：</div>
				<div class="item-c"><a href="<?php echo URL('ta', array('id' => $item['sina_uid']));?>"><?php echo F('escape', $item['nickname']);?></a><?php if (isset($item['realname']) && !empty($item['realname'])):?>(<?php echo F('escape', $item['realname']);?>)<?php endif;?></div>
			</div>
			<div class="info-item">
				<div class="item-l">联系方式：</div>
				<div class="item-c"><?php echo $item['phone'];?></div>
			</div>
			<div class="info-item">
				<div class="item-l">状　　态：</div>
				<?php if ($item['state_num'] == 4):?>
				<div class="item-c warn">
				关闭
				</div>
				<?php elseif ($item['state_num'] == 5):?>
				<div class="item-c warn">
				封禁
				</div>
				<?php elseif ($item['state_num'] == 6):?>
				<div class="item-c">
				已完成
				</div>
				<?php elseif ($item['state_num'] == 1):?>
				<div class="item-c">
				推荐
				</div>
				<?php elseif ($item['state_num'] == 2 || $item['state_num'] == 3):?>
				<div class="item-c">
				正常进行中
				</div>
				<?php endif;?>	
			</div>
			<div class="info-item">
				<div class="item-l">参加人数：</div>
				<div class="item-c"><a href="<?php echo URL('event.member', 'eid='.$item['id']);?>"><?php echo $item['join_num'];?></a></div>
			</div>
			<?php if ('hot' == $type):?>
				<a class="share icon-bg" href="#" rel="e:sd">分享到我的微博</a>
				<?php if (isset($join_list[$item['id']]) && $join_list[$item['id']] != ''):?>
					<a class="has-join-btn" href="#">已参加</a>
				<?php elseif (($item['state_num'] == 2 
				|| $item['state_num'] == 3 
				|| $item['state_num'] == 1) 
				&& $item['sina_uid'] != USER::uid()):?>
					<a class="join-btn" href="#" rel="e:join">我要参加</a>
				<?php else:?>
					<a class="join-btn-disabled" href="#">我要参加</a>
				<?php endif;?>
			<?php elseif ('create' == $type):?>
				<div class="oper-event">
				<?php if ($item['state_num'] != 4 && $item['sina_uid'] == USER::uid()):?>
					<a href="#" rel="e:clsevt,id:<?php echo $item['id'];?>" >关闭</a>
				<?php else:?>
					<span>关闭</span>
				<?php endif;?>
				|
				<?php if (($item['state_num'] == 2 
				|| $item['state_num'] == 3 
				|| $item['state_num'] == 1) 
				&& $item['sina_uid'] == USER::uid()):?>
					<a href="<?php echo URL('event.modify', 'eid='.$item['id']);?>">编辑</a>
				<?php else:?>
					<span>编辑</span>
				<?php endif;?>
				|
				<a href="#"  rel="e:delevt,id:<?php echo $item['id'];?>">删除</a>
				</div>
			<?php endif;?>
		</div>
	</div>
	<?php endforeach;?>                                	
	<?php TPL::module('page', array('list' => $list, 'count' => $count, 'limit' => $limit, 'type' => 'event'));?>
<?php else:?>
<div class="default-tips">
	<div class="icon-tips all-bg"></div>
	<?php if ('create' == $type):?>
		<p>我没有发起过活动</p>
	<?php elseif ('attend' == $type):?>
		<p>我没有参加过活动</p>
	<?php else:?>
		<p>暂时没有任何活动</p>
	<?php endif;?>
</div>
<?php endif;?>
