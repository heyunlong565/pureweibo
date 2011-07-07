<div class="pub-feed-list">
    <div class="column-title">
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="feed-list">
    <?php
		//官方微博
		//$rs = DS('components/officialWB.addUser', null, '11007');
		
		$rs = DR('components/officialWB.get', 300);

		if ($rs['errno'] == 0) {
			TPL::plugin('include/feedlist', array('list' => $rs['rst']));
		} else {
	?>
	<div class="int-box load-fail icon-bg">系统繁忙，微博列表获取不正常，请<a href="#" rel="e:rl">刷新</a>再试!</div>
	<?php 
		}
	?>
	<ul>
	</div>
<?php
	//list 内的用户
	$rs = DR('components/officialWB.getUsers', 300);

	if ($rs['errno'] == 0 && !empty($rs['rst']) && $rs['rst']['users']) {
?>
	<div class="more-mbloger">
        <span>官方成员：</span>
		<div class="content">

<?php	
		foreach ($rs['rst']['users'] as $u) {
			if (empty($u)) continue;
			
			$nick = F('escape', $u['screen_name']);
			$profile_url = URL('ta', array('id' => $u['id']));
?>
        <a href="<?php echo $profile_url;?>"><?php echo $nick;?></a>
<?php
		}
?>
		</div>
    </div>
<?php
	}
?>
</div>