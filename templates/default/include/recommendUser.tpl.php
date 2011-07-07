<?php

//初次使用向导
if (isset($guide) && $guide) {
	$groups = DR('plugins/loginGuide.get', '');

	$category = array();

	if (!empty($groups)) {
		foreach ($groups as $g) {
			$category[$g['item_id']] = $g['item_name'];
		}
	}
} else { //名人堂分类用户推荐
	$category = DR('components/categoryUser.getGroups', 0);
	$category = $category['rst']['groups'];
}

if (empty($category) ){
	return;
}


if (!isset($cid) || !is_int($cid) || !isset($category[$cid])) {
	reset($category);
	$cid = key($category);
}

if (!$cid) {
	return;
}

//$users = DR('mgr/userRecommendCom.getUserById', 'g0', $cid);
$users = DR('components/categoryUser.get', 'g0/300', $cid);
$users = $users['rst'];

// 转换
$data = array();
$uid = USER::uid();
if ($uid) {
	$ids = DR('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
	$ids = $ids['rst']['ids'];
} else {
	$ids = array();
}
for ($i=0,$count=count($users); $i< $count; $i++) {
	$item = $users[$i];
	$data[] = array (
				'id' => $item['uid'],
				'profile_image_url' => F('profile_image_url', $item['uid']),
				'screen_name' => $item['nickname'],
				'description' => $item['remark'],
				'following' => in_array($item['uid'], $ids) ? true : false
				);
}
$data = F('user_filter', $data);
?>
	<div class="fame-list">
		<div class="column-title">
			<h3><?php echo isset($title) ? $title: '分类用户推荐';?></h3>
		</div>
		<div class="tab-s4">
		<?php if (is_array($category)) { foreach($category as $key =>$item) {?>
			<a <?php if ($key == $cid) {?>class="current" name="starRecommend"<?php }?> href="<?php echo $base_url . $key?>#starRecommend"><?php echo $item?></a>
		<?php }}?>
		</div>
		<?php TPL::plugin('search/mod_fame_list', array('users' => $data));?>
	</div>
