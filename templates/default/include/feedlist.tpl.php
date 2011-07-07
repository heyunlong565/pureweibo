<?php
	/**
	 * 微博列表包含<ul>
	 *
	 * @param $list array 微博数组
	 *
	 *
	 */
?>
<ul id="xwb_weibo_list_ct">
<?php

$uid = USER::uid();

/// 过滤微博
$list = F('weibo_filter', $list);

if (!isset($author)) {
	$author = true;
}
foreach ($list as $wb) {
	/// 过滤掉过敏的原创微博
	if (isset($wb['filter_state']) && ($wb['filter_state'] / 10) < 1) {
		continue;	
	}
	//是否显示用户头像
	// 0 不显示
	// 1 显示用户头像
	$wb['header'] = isset($header) ? $header: 1;
	
	$wb['uid'] = $uid;

	$wb['author'] = $author;

	echo '<li rel="w:'.$wb['id'].'">';
	
	TPL::plugin('include/feed', $wb);

	echo '</li>';
}
?>
</ul>
