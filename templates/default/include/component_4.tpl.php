<div class="top10 top10-attention">
    <div class="sidebar-head"><?php echo F('escape', $mod['title']);?></div>
    <ul>
<?php
	// 人气关注榜
	$rs = DS('components/concern.get', 300);

	$count = 1;

	if (!empty($rs)) {
		foreach ($rs as $u) {

		
		$nick = F('escape', $u['nickname']);
		$profile_url = URL('ta', array('id' => $u['uid']));
?>
         <li>
            <div class="ranking<?php if($count<4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
            <span><?php echo number_format($u['sort_num']);?></span>
            <a href="<?php echo $profile_url;?>"><?php echo $nick;?></a>
        </li>
<?php
		$count++;
		}
	}
?>
</ul>
</div>