<?php
/**
 * 单条微博格式化
 * @param $user array 该条微博的用户信息
 * @favorited boolean 是否被收藏了
 * 
 */

	$id = (string)$id;

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

	$profile_url = URL('ta', array('id' => (string)$user['id'], 'name' => $user['screen_name']));

	//微博链接
	$link = URL('show', array('id' => $id));
 
	//用户头像
	if (!isset($header)) {
		$header = 1;
	}

	if (!isset($disable_comment)) {
		$disable_comment = false;
	}

	if ($header == 1):
?>
	<div class="user-pic">
	<a href="<?php echo $profile_url;?>"><img width="50" height="50" src="<?php echo $user_img;?>" alt="<?php echo $nick;?>" title="<?php echo $nick;?>" /></a>
	<!-- 在线直播 主持人和嘉宾的区别 -->
	<?php if (isset($user['live_user_type']) && $user['live_user_type'] == 'master'):?>
	<span class="emcee-mark">主持人</span>
	<?php elseif (isset($user['live_user_type']) && $user['live_user_type'] == 'guest'):?>
	<span class="guest-mark">嘉宾</span>
	<?php endif;?>
	<!-- end -->
	</div>
<?php elseif ($header == 2): //热门转发?>
	<div class="hot-total">
		<strong id="hotNum"></strong>
		<em>转发</em>
	</div>
<?php elseif ($header == 3): //热门评论?>
	<div class="hot-total">
		<strong id="hotNum"></strong>
		<em>评论</em>
	</div>
<?php endif;?>
	<div class="feed-content">
		<p class="feed-main">
<?php /*默认显示*/ if (!isset($author) || $author):?>
<a href="<?php echo $profile_url;?>" title="<?php echo $nick;?>"><?php echo $nick;?><?php echo F('verified', $user);?></a>：<?php endif;?><?php echo $text;?></p>
	<?php if (isset($thumbnail_pic)): ?>
		<div class="preview-img">
			<div class="feed-img">
				<img class="zoom-move" src="<?php echo $thumbnail_pic;?>" rel="e:zi,fw:0"/>
			</div>
		</div>
	<?php endif;?>
<?php
// 图片内容
/*
		<div class="box-style" style="display:none">
			<div class="box-t skin-bg"><span class="skin-bg"></span></div>
			<div class="box-content">


			<div class="show-img">
				<p>
					<a href="#" class="icon-piup icon-bg">收起</a>
					<a href="#" class="icon-src icon-bg">查看原图</a>
					<a href="#" class="icon-trunleft icon-bg">向左转</a>
					<a href="#" class="icon-trunright icon-bg">向右转</a>
				</p>


				<div><img alt="" src="../img/50c36080t882adeda566c&amp;690.jpg"></div>
			</div>

			</div>
			<div class="box-b skin-bg"><span class="skin-bg"></span></div>
			<span class="box-arrow skin-bg"></span>
		</div>
*/
?>
	<?php 
		//	<!-- 转发微博内容部分 -->
		if (isset($retweeted_status)): 
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
				$rtLink = URL('show', array('id' => $rt['id']));
			}

	?>
		<?php if ($isFilter):?>
		<div class="box-style">
			<div class="box-t skin-bg"><span class="skin-bg"></span></div>
			<div class="forward box-content">
				<p>
				<?php echo $errmsg;?>
				</p>
			</div>
			<div class="box-b skin-bg"><span class="skin-bg"></span></div>
			<span class="box-arrow skin-bg"></span>
		</div>
		<?php else:?>
		<div class="box-style">
			<div class="box-t skin-bg"><span class="skin-bg"></span></div>
			<div class="forward box-content">
				<p><a href="<?php echo URL('ta',array('id' => $rtUser['id']));?>">@<?php echo $rtNick;?><?php echo F('verified', $rtUser);?></a>：<?php echo $rtText;?>
				<span><a href="<?php echo $rtLink;?>" id="lk_fw">原文转发</a>|<a href="<?php echo $rtLink;?>" id="lk_cm">原文评论</a></span>
				</p>
			<?php if (!empty($rt['thumbnail_pic'])): ?>
				<div class="preview-img">
					<div class="feed-img "><img class="zoom-move"  src="<?php echo $rt['thumbnail_pic'];?>" rel="e:zi,fw:1"/></div>
				</div>
			<?php endif;?>
			</div>
			<div class="box-b skin-bg"><span class="skin-bg"></span></div>
			<span class="box-arrow skin-bg"></span>
		</div>
		<?php endif;?>
	<?php 
		endif; 
		//end 转发微博内容部分
	?>
	<div class="feed-info"><p><a href="#" rel="e:an" class="reply">回答</a>|
	<?php if ($uid == $user['id']):?><a href="#" rel="e:dl">删除</a>|<?php endif;?><a href="#" rel="e:fw" id="fw">转发</a><?php if ($favorited):?>|<a href="#" rel="e:ufr,t:1">取消收藏</a><?php else:?>|<a href="#" rel="e:fr">收藏</a><?php endif;?>|<a href="javascript:;"<?php if (!$disable_comment):?> rel="e:cm"<?php endif;?> id="cm">评论</a>
	</p><span><a href="<?php echo $link;?>"><?php echo $format_time;?></a> 来自 <?php echo $source;?></span>
	
	<?php if (isset($is_show) && $is_show && USER::uid()){ // 举报功能，只有在微博详细也才显示  ?>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" rel="e:rs">举报</a>
	<?php } ?>
	
	<?php if (isset($is_show) && $is_show && USER::aid()){?> ｜ <?php if (isset($filter_state) && is_array($filter_state) && in_array(3, $filter_state)) {?><span>已屏蔽</span><?php } else {?> <a href="#" rel="e:blm">屏蔽该微博</a><?php }}?>
    </div>
  </div>
<?php
//</li>
//将每条微博的内容保存到一个对象，最后以json格式输出到页面
	$json = APP::getData('json', 'WBDATA', array());

	if (!isset($json[$id])) {
		$json[$id] = $json_element;
		APP::setData('json', $json, 'WBDATA');
	}
?>

<?php if (isset($is_show) && $is_show && USER::uid()){ // 举报功能，只有在微博详细也才显示  ?>
<?php } ?>
