<?php
/**
 * 单条微博格式化
 * @param $user array 该条微博的用户信息
 * @favorited boolean 是否被收藏了
 * 
 */

$id = (string)$id;

//当前路由
$router_str = APP::getRuningRoute(false);

//是否显示缩略图
$show_pic = ($router_str == 'show.default_action' || $router_str == 'show.repos' ? 1 : V('-:userConfig/wap_show_pic', 1));

//简化的JSON数据对象
$json_element = array(
	'cr' => $created_at, //create time
	'f' => isset($favorited) ? 1: 0, //is favorited
	's' => $source, //来源
	'tx' => $text //文本内容
);
if (isset($thumbnail_pic)) {
	$json_element['tp'] = $thumbnail_pic;
	$json_element['mp'] = $bmiddle_pic;
	$json_element['op'] = $original_pic;
}

$json_element['u'] = array(
	'id' => (string)$user['id'], //用户ID
	'sn' => $user['screen_name'], //显示的名称
	'p' => $user['profile_image_url'],
	'v' => $user['verified'] ? 1: 0
);


// xxx前发表
$format_time = F('format_time', $created_at);

//用户头像
$user_img = &$user['profile_image_url'];

//用户昵称
$nick = F('escape', $user['screen_name']);

//格式化后的内容
$text = F('format_text', $text);

//对text进行是搜索化处理 暂不处理
if(V('r:m') == 'search' || V('r:m') == 'search.weibo' || V('r:m') == 'ta.mention') {
    $text = F('wap_search_highlight', V('r:k'), $text);
}

$profile_url = WAP_URL('ta', array('id' => (string)$user['id'], 'name' => $user['screen_name']));

//微博链接
$repos_link = WAP_URL('show.repos', array('id' => $id));
$comment_link = WAP_URL('show', array('id' => $id));

//用户头像
if (!isset($header)) {
	$header = 1;
}

if (!isset($disable_comment)) {
	$disable_comment = false;
}

if (isset($retweeted_status)) {
	/// 是否过滤或屏蔽
	$isFilter = false;
	if (!empty($retweeted_status['filter_state'])) {
		$isFilter = true;
		/// 过滤的原因
		$errno = $retweeted_status['filter_state'];
		$errmsg = '';
		switch (true) {
			case in_array(1, $errno):
				$errmsg = '内容有错！';
				break;
			case in_array(2, $errno):
				$errmsg = '该用户已经被屏蔽';
				break;
			case in_array(3, $errno):
			case in_array(4, $errno):
				$errmsg = '原微博已被屏蔽';
				break;
		}
	} else {
		//原微博内容
		$rt = &$retweeted_status;

		//原创用户信息
		$rtUser = &$rt['user'];

		//转发消息JSON部分
		$json_element['rt'] = array(
			'cr' => $rt['created_at'],
			'f' => $rt['favorited'],
			'id' => (string)$rt['id'],
			's' => $rt['source'],
			'tx' => $rt['text'],
			'fl' => $rtUser['following'] ? 1: 0,
			'sn' => $rtUser['screen_name'],
			'u' => array(
				'id' => (string)$rtUser['id'],
				'sn' => $rtUser['screen_name'],
				'v' => $rtUser['verified']? 1: 0,
				'p' => $rtUser['profile_image_url']
			)
		);

		if (isset($rt['thumbnail_pic'])) {
			$json_element['rt']['tp'] = $rt['thumbnail_pic'];
			$json_element['rt']['mp'] = $rt['bmiddle_pic'];
			$json_element['rt']['op'] = $rt['original_pic'];
		}

		//创始用户昵称
		$rtNick = F('escape', $rtUser['screen_name']);

		//原创内容
		$rtText = F('format_text', $rt['text']);

		//原文链接
		$rtReposLink = WAP_URL('show.repos', array('id' => $rt['id']));
		$rtCommentLink = WAP_URL('show', array('id' => $rt['id']));
	}
}
?>
<?php if ($router_str != 'index.profile'): ?><a href="<?php echo WAP_URL('ta', 'id=' . $user['id']); ?>"><?php echo F('verified', $user); ?></a>&nbsp;<?php endif; ?><?php if (isset($retweeted_status)): ?><span class="atme">转发了&nbsp;<a href="<?php echo WAP_URL('ta', 'id=' . $retweeted_status['user']['id']); ?>">@<?php echo F('verified', $retweeted_status['user']); ?></a>&nbsp;的微博：</span><?php if ($isFilter): echo '<span class="g">(' . $errmsg . ')</span>'; else: ?><span class="con"><?php echo $rtText; ?></span><?php if (isset($rt['thumbnail_pic']) && $show_pic): ?><div><a href="<?php echo WAP_URL('wbcom.viewPhoto', 'id=' . $rt['id'] . '&v=1'); ?>"><img src="<?php echo $rt['thumbnail_pic']; ?>" alt="[图片]" /></a></div><?php endif; ?><?php printf('%s<a href="' . $rtReposLink . '">原文转发[' . $rt['counts']['rt'] . ']</a>&nbsp;<a href="' . $rtCommentLink . '">原文评论[' . $rt['counts']['comments'] . ']</a>%s', isset($rt['thumbnail_pic']) ? ($show_pic ? '<div><a href="' . WAP_URL('wbcom.viewPhoto', 'id=' . $rt['id']) . '&v=1' . '">原图</a>&nbsp;' : '&nbsp;[<a href="' . WAP_URL('wbcom.viewPhoto', 'id=' . $rt['id'] . '&v=0') . '">图片</a>]&nbsp;') : '&nbsp;', isset($rt['thumbnail_pic']) ? ($show_pic ? '</div>' : '') : '&nbsp;'); ?><?php endif; ?><div><span class="g">转发理由<?php endif; ?><?php if ($router_str != 'index.profile' || isset($retweeted_status)): ?>：<?php endif; ?><?php if (isset($retweeted_status)): ?></span><?php endif; ?><?php echo $text; ?><?php if (isset($thumbnail_pic) && $show_pic): ?><div><a href="<?php echo WAP_URL('wbcom.viewPhoto', 'id=' . $id . '&v=1'); ?>"><img src="<?php echo $thumbnail_pic; ?>" alt="[图片]" /></a></div><?php endif; ?><?php printf('%s<a href="' . $repos_link . '">转发[' . $counts['rt'] . ']</a>&nbsp;<a href="' . $comment_link . '">评论[' . $counts['comments'] . ']</a>%s%s', isset($thumbnail_pic) ? ($show_pic ? '<div><a href="' . WAP_URL('wbcom.viewPhoto', 'id=' . $id . '&v=1') . '">原图</a>&nbsp;' : '&nbsp;[<a href="' . WAP_URL('wbcom.viewPhoto', 'id=' . $id . '&v=0') . '">图片</a>]&nbsp;') : '&nbsp;', ($router_str != 'index.favorites' ? '&nbsp;<a href="' . WAP_URL('wbcom.addFav', 'mid=' . $id) . '">收藏</a>' : '&nbsp;<a href="' . WAP_URL('wbcom.delFavAlert', 'mid=' . $id) . '">取消收藏</a>') . ((USER::uid() == $user['id']) ? '&nbsp;<a href="' . WAP_URL('wbcom.delWBAlert', 'mid=' . $id) . '">删除</a>' : '') . (($router_str == 'show.default_action' || $router_str == 'show.repos') ? '&nbsp;<a href="' . WAP_URL('show.reportSpam', 'id=' . $id) . '">举报</a>' : ''), isset($thumbnail_pic) ? ($show_pic ? '</div>' : '') : '&nbsp;'); ?><?php echo (isset($thumbnail_pic) && $show_pic) ? '<div>' : '&nbsp;'; ?><span class="g"><?php echo $format_time; ?>&nbsp;来自<?php echo strip_tags($source); ?></span><?php echo (isset($thumbnail_pic) && $show_pic) ? '</div>' : ''; ?><?php echo isset($retweeted_status) ? '</div>' : ''; ?>