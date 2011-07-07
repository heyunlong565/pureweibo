<?php 
	//热门话题列表

	$ret = DR('components/hotTopic.get', 300);

	if ($ret['errno'] != 0) {
		return;
	}
?>

<div class="top10">
    <div class="sidebar-head"><?php echo F('escape', $mod['title']);?></div>
    <ul>

<?php
	
	$count = 1;

	$rs = &$ret['rst'];

	if (!empty($rs)) {
		foreach ($rs as $row) {
		
		$topic = F('escape', $row['topic']);

		$url = URL('search.weibo', array('k' => isset($row['query']) ? $row['query']: $row['topic']));
?>
         <li>
            <div class="ranking<?php if ($count < 4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
            <a href="<?php echo $url;?>"><?php echo $topic;?></a>
        </li>
<?php 
		$count++;
		}
	}
?>
	</ul>
</div>