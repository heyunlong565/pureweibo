<?php
	/**
	 * 微博列表包含<ul>
	 * @param $list array 微博数组
	 */
if(!is_array($list) || empty($list)){
?>
<div class="int-box load-fail icon-bg">该模块下没有微博，<a href="#" rel="e:rl">刷新</a>试试？</div>
<?php
}else{
?>
<div>
<ul id="xwb_weibo_list_ct">

<?php
	/// 过滤微博
	$list = F('weibo_filter', $list);
	foreach ($list as $wb) {	/// 过滤掉过敏的原创微博
		if ((isset($wb['filter_state']) && !empty($wb['filter_state'])) || (isset($wb['user']['filter_state']) && !empty($wb['user']['filter_state']))) {
			continue;	
		}
	
		//是否显示用户头像, 0 不显示1 显示用户头像
		$wb['header'] = isset($header) ? $header: 1;
		$wb['uid'] 	  = USER::uid();
		$wb['author'] = isset($author) ? $author : TRUE;

		echo '<li rel="w:'.$wb['id'].'">';
			TPL::module('feed', $wb);
		echo '</li>';
	}
}
?>
</ul>
</div>