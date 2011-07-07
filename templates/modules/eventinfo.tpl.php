<div class="event-list">
	<div class="cover">
	<a href="#"><img src="<?php echo $info['pic'];?>" alt="活动封面" /></a>
		<div class="cover-bg"></div>
	</div>
	<div class="event-info" rel="eid:<?php echo $info['id'] ;?>,m:<?php echo F('share_weibo', 'event_attend', $info);?>,m1:<?php echo F('share_weibo', 'event', $info);?>,other:<?php echo $info['other'] ;?>">
	<h3><a href="#"><?php echo F('escape', $info['title']);?></a></h3>
		<div class="info-item">
			<div class="item-l">时　　间：</div>
			<div class="item-c"><?php echo F('format_time.foramt_show_time',$info['start_time']);?> - <?php echo F('format_time.foramt_show_time',$info['end_time']);?></div>
		</div>
		<div class="info-item">
			<div class="item-l">地　　点：</div>
			<div class="item-c"><?php echo F('escape', $info['addr']);?></div>
		</div>
		<div class="info-item">
			<div class="item-l">发<i></i>起<i></i>者：</div>
			<div class="item-c"><a href="<?php echo URL('ta', array('id' => $info['sina_uid']));?>"><?php echo F('escape', $info['nickname']);?></a><?php if (isset($info['realname']) && !empty($info['realname'])):?>(<?php echo F('escape', $info['realname']);?>)<?php endif;?></div>
		</div>
		<div class="info-item">
			<div class="item-l">联系方式：</div>
			<div class="item-c"><?php echo $info['phone'];?></div>
		</div>
		<div class="info-item">
			<div class="item-l">状　　态：</div>
			<?php if ($info['state_num'] == 4):?>
			<div class="item-c warn">
			关闭
			</div>
			<?php elseif ($info['state_num'] == 5):?>
			<div class="item-c warn">
			封禁
			</div>
			<?php elseif ($info['state_num'] == 6):?>
			<div class="item-c">
			已完成
			</div>
			<?php elseif ($info['state_num'] == 1):?>
			<div class="item-c">
			推荐
			</div>
			<?php elseif ($info['state_num'] == 2 || $info['state_num'] == 3):?>
			<div class="item-c">
			正常进行中
			</div>
			<?php endif;?>
		</div>
		<div class="info-item">
			<div class="item-l">参加人数：</div>
			<div class="item-c"><a href="<?php echo URL('event.member', 'eid='.$info['id']);?>"><?php echo $info['join_num'];?></a></div>
		</div>
		<a class="share icon-bg" href="#"  rel='e:sd'>分享到我的微博</a>
		<?php if (isset($join_list[$info['id']]) && $join_list[$info['id']] != ''):?>
			<a class="has-join-btn" href="#">已参加</a>
		<?php elseif (($info['state_num'] == 2 
		|| $info['state_num'] == 3 
		|| $info['state_num'] == 1) 
		&& $info['sina_uid'] != USER::uid()):?>
			<a class="join-btn" href="#" rel='e:join'>我要参加</a>
		<?php else:?>
			<a class="join-btn-disabled" href="#">我要参加</a>
		<?php endif;?>
	</div>
</div>
<div class="overview">
	<h4>活动简介:</h4>
	<p><?php echo F('escape', $info['desc']);?></p>
</div>
<div class="user-sidebar">
<div class="sidebar-head sidebar-head-sty">这个活动的参加者：<span>共<a href="<?php echo URL('event.member', 'eid='.$info['id']);?>"><?php echo $info['join_num'];?></a>人</span></div>
	<ul>
		<?php foreach ($list_member as $item):?>
		<li rel="u:<?php echo $item['id']; ?>">
		<a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><img alt="<?php echo F('escape', $item['screen_name']);?>" src="<?php echo $item['profile_image_url'];?>"></a>
		<p><a href="<?php echo URL('ta', 'id='.$item['id'].'&name='.$item['screen_name']);?>"><?php echo F('escape', $item['screen_name']);?></a></p>
		<?php if (!empty($listFans) && in_array($item['id'], $listFans) || USER::uid() == $item['id']):?>
			<em>已关注</em>
		<?php else:?>
			<a rel="e:fl,t:2" class="sub-link" href="#">加关注</a>
		<?php endif;?>
		</li>
		<?php endforeach;?>
	</ul>
</div>
