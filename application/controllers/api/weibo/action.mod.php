<?php
/**************************************************
*  Created:  2010-06-08
*
*  微博相关操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class action_mod
{

	function action_mod()
	{
		/// 判断是否是程序的api调用
		if (IS_IN_API_REQUEST) {
			/// 设置ip白名单访问，默认不使用ip白名单
			/// 如果要ip白名单, 需要手动填写ip填写,多个ip地址用逗号隔开
			/// 比如：$access_ips = array('192.168.1.100', '192.168.1.101');
			$access_ips = array();
			if (!empty($access_ips)) { 
				$ip = F('get_client_ip');
				if (!in_array($ip, $access_ips)) {
					return RST('', '3010000', 'Ip not allowed to access');
				}
			}

			/// 检查签名
			$api_sign = V(V_API_REQUEST_ROUTE, null); 
			$api_uid = V('p:api_uid');
			$api_time = V('p:api_time');
			/// 检查请求有效时间, 默认相差10分钟
			if ($api_time > API_TIMESTAMP + APP_LOCAL_TIMESTAMP) {
				die(json_encode(RST('', '3010001', 'Access time failure')));
			}
			$m = APP::getRequestRoute(true);
			$check_sign = md5(WB_AKEY.'#'.$api_uid.'#'.$api_time.'#'.WB_SKEY.'#'.$m['function'].'#'.API_KEY);
			if ($api_sign != $check_sign) {
				die(json_encode(RST('', '3010002', 'Signature is not correct')));
			}
			/// 检查用户身份是否已经绑定
			$db = APP :: ADP('db');
			$result = $db->query('SELECT * FROM '.$db->getTable(T_USER_TOKEN).' WHERE uid = '.$api_uid);
			if (empty($result)) {
				/// 是否使用匿名身份(有接口限制) 
				$allow_anonymous = array('getTokenAuthorizeURL');
				/// 是否使用系统默认身份(有接口限制) 
				$allow_others = array();
				if (empty($allow_anonymous) && empty($allow_others)) {
					die(json_encode(RST('', '3010003', 'Does not bind the user')));
				} elseif (in_array($m['function'], $allow_others)) {
					DR('xweibo/xwb.setToken', '', OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
				} elseif (!in_array($m['function'], $allow_anonymous)) {
					die(json_encode(RST('', '3010003', 'Does not bind the user')));
				}
			} else {
				$result = $result[0];
				DR('xweibo/xwb.setToken', '', $result['oauth_token'], $result['oauth_token_secret']); 
			}
		} elseif (!IS_IN_JS_REQUEST) {
			die(json_encode(RST('', '3010004', 'Does not allow access')));	
		}
	}

	/**
	 * 发微博以及发图片微博
	 *
	 *
	 */
	function update()
	{
		/// 发布的内容
		$text = trim(V('p:text'));
		/// 图片
		$pic = V('p:pic');


		if (empty($pic)) {
			/// 调用发布微博api
			$result = DS('xweibo/xwb.update', '', $text);
		} else {
			/// 调用发布图片微博api
			$result = DS('xweibo/xwb.uploadUrlText', '', $text, $pic);
		}

		
		if (is_array($result)) {
			$result['uid'] = USER::uid();
			$result['author'] = true;
		}
		/// 过滤微博
		$result = F('weibo_filter', $result, true);
		$json['html'] = '<LI rel="w:'.$result['id'].'">' . TPL::plugin('include/feed', $result, true, false) . '</LI>';
		$json['data'] = APP::getData('json', 'WBDATA',array());
		APP::ajaxRst($json, 0);
		exit;
	}


	/**
	 * 上传图片
	 *
	 *
	 */
	function upload_pic()
	{
		$callback = V('g:callback','');
		$redirect = 'window.location="'.W_BASE_URL.'js/blank.html?rand='.rand(1,PHP_INT_MAX) . '"';

		if (isset($_FILES['pic'])) {
			$result = DR('xweibo/xwb.uploadPic', '', $_FILES['pic']['tmp_name']);
			$result = $result['rst'];
		} else {
			die("<script language=\"javascript\">$callback(".APP::ajaxRst(false, '1010000', 'Parameter can not be empty', true).");$redirect</script>");
		} 

		if (!empty($result['errno'])) {
			die("<script language=\"javascript\">$callback(".APP::ajaxRst(false, $result['errno'], $result['err'], true).");$redirect</script>");
		}

		$json = array();
		$json['msg'] = $result['pic_id'];
		die("<script language=\"javascript\">$callback(".APP::ajaxRst($json, 0, '', true).");$redirect</script>"); 
	}


	/**
	 * 删除微博
	 *
	 *
	 */
	function destroy()
	{
		/// 要删除微博的id
		$id = V('p:id');

		/// 调用删除微博api
		DS('xweibo/xwb.destroy', '', $id); 
		/// 删除缓存
		DD('xweibo/xwb.getFriendsTimeline');
		DD('xweibo/xwb.getMentions'); 

		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 转发微博
	 *
	 *
	 */
	function repost()
	{
		$id = V('p:id');
		$text = trim(V('p:text'));
		$rtids = V('p:rtids');

		$add = false;

		/// 调用转发微博api
		$result = DS('xweibo/xwb.repost', '', $id, $text);
		/// 过滤微博
		$result = F('weibo_filter', $result, true);
		
		if (is_array($result)) {
			$result['uid'] = USER::uid();
			$result['author'] = true;
		}
		/// 如果勾选了作为某人的评论，调用评论接口
		if (!empty($rtids)) {
			$add = true;
			$rtid_array = explode(',', $rtids);
			foreach ($rtid_array as $var) {
				DR('xweibo/xwb.comment', '', $var, $text);
			}
		}

		/// 获取该微博的转发数和评论数
		$mblog_counts = DR('xweibo/xwb.getCounts', '', $result['retweeted_status']['id']);
		$mblog_counts = $mblog_counts['rst'];

		$json['data'] = array();
		$json['data']['id'] = (string)$result['id'];
		$json['data']['cr'] = $result['created_at'];
		$json['data']['f'] = $result['favorited'] == false ? 0 : 1;
		$json['data']['s'] = $result['source'];
		$json['data']['tx'] = $result['text'];
		$json['data']['tp'] = isset($result['thumbnail_pic']) ? $result['thumbnail_pic'] : '';
		$json['data']['mp'] = isset($result['bmiddle_pic']) ? $result['bmiddle_pic'] : '';  
		$json['data']['op'] = isset($result['original_pic']) ? $result['original_pic'] : ''; 
		$json['data']['u'] = array();
		$json['data']['u']['id'] = (string)$result['user']['id'];
		$json['data']['u']['sn'] = $result['user']['screen_name'];
		$json['data']['u']['p'] = $result['user']['profile_image_url'];
		$json['data']['u']['v'] = $result['user']['verified'] == false ? 0 : 1;
		$json['data']['u']['site_v'] = $result['user']['site_v'];
		//转发微博内容
		if (isset($result['retweeted_status'])) {
			$json['data']['rt'] = array();
			$json['data']['rt']['id'] = (string)$result['retweeted_status']['id'];
			$json['data']['rt']['cr'] = $result['retweeted_status']['created_at'];
			$json['data']['rt']['f'] = $result['retweeted_status']['favorited'] == false ? 0 : 1;
			$json['data']['rt']['s'] = $result['retweeted_status']['source'];
			$json['data']['rt']['tx'] = $result['retweeted_status']['text'];
			$json['data']['rt']['tp'] = isset($result['retweeted_status']['thumbnail_pic']) ? $result['retweeted_status']['thumbnail_pic'] : ''; 
			$json['data']['rt']['mp'] = isset($result['retweeted_status']['bmiddle_pic']) ? $result['retweeted_status']['bmiddle_pic'] : '';
			$json['data']['rt']['op'] = isset($result['retweeted_status']['original_pic']) ? $result['retweeted_status']['original_pic'] : '';
			$json['data']['rt']['u'] = array();
			$json['data']['rt']['u']['id'] = (string)$result['retweeted_status']['user']['id'];
			$json['data']['rt']['u']['sn'] = $result['retweeted_status']['user']['screen_name'];
			$json['data']['rt']['u']['p'] = $result['retweeted_status']['user']['profile_image_url'];
			$json['data']['rt']['u']['v'] = $result['retweeted_status']['user']['verified'] == false ? 0 : 1;
			$json['data']['rt']['u']['site_v'] = $result['retweeted_status']['user']['site_v']; 
		}
		$json['html'] = '<LI rel="w:'.$result['id'].'">' . TPL::plugin('include/feed', $result, true, false) . '</LI>';
		$json['data'] = APP::getData('json', 'WBDATA',array());
		APP::ajaxRst($json, 0);
		exit;
	}


	/**
	 * 上传图片
	 *
	 *
	 */
	/*
	function upload_pic()
	{
		$callback = V('g:callback','');
		$redirect = 'window.location="'.W_BASE_URL.'js/blank.html?rand='.rand(1,PHP_INT_MAX) . '"';

		if (isset($_FILES['pic'])) {
			$result = DR('xweibo/xwb.uploadPic', '', $_FILES['pic']['tmp_name']);
			$result = $result['rst'];
		$json['html'] = '<LI rel="w:'.$result['id'].'">' . TPL::plugin('include/feed', $result, true, false) . '</LI>';
		APP::ajaxRst($json, 0);
		exit;
	}
	*/


	/**
	 * 评论微博
	 *
	 *
	 */
	function comment()
	{
		$id = V('p:id');
		$text = trim(V('p:text'));
		$forward = V('p:forward', null);
		$type = max(V('p:type'), 1);

		$add = false;
		/// 调用评论微博api
		$result = DS('xweibo/xwb.comment', '', $id, $text);
		$result = F('weibo_filter', $result, true);
		
		if ($forward == 1) {
			$add = true;
			/// 作为一条新微博发布
			$ret = DR('xweibo/xwb.repost', '', $id, $text);
			$ret = $ret['rst'];
			if (is_array($ret)) {
				$ret['uid'] = USER::uid();
				$ret['author'] = true;
			}
			/// 过滤微博
			$ret = F('weibo_filter', $ret, true);
			$json = array();
			$json['comment']['id'] = (string)$result['id'];
			$json['comment']['create_at'] = APP::F('format_time', $result['created_at']);
			$json['comment']['text'] = APP::F('format_text', $result['text']);
			$json['comment']['nick'] = $result['user']['screen_name'];
			$json['comment']['uid'] = (string)$result['user']['id'];
			$json['comment']['profileImg'] = $type == 1 ? APP::F('profile_image_url', $result['user']['profile_image_url'], 'comment') : APP::F('profile_image_url', $result['user']['profile_image_url']);
			$json['comment']['v'] = $result['user']['verified'] == false ? 0 : 1; 
			$json['comment']['site_v'] = $result['user']['site_v']; 
			/// 微博内容
			$json['wb'] = array();
			$json['wb']['id'] = (string)$ret['id'];
			$json['wb']['cr'] = $ret['created_at'];
			$json['wb']['f'] = $ret['favorited'] == false ? 0 : 1;
			$json['wb']['s'] = $ret['source'];
			$json['wb']['tx'] = $ret['text'];
			$json['wb']['tp'] = isset($ret['thumbnail_pic']) ? $ret['thumbnail_pic'] : '';
			$json['wb']['mp'] = isset($ret['bmiddle_pic']) ? $ret['bmiddle_pic'] : '';  
			$json['wb']['op'] = isset($ret['original_pic']) ? $ret['original_pic'] : ''; 
			$json['wb']['u'] = array();
			$json['wb']['u']['id'] = (string)$ret['user']['id'];
			$json['wb']['u']['sn'] = $ret['user']['screen_name'];
			$json['wb']['u']['p'] = $ret['user']['profile_image_url'];
			$json['wb']['u']['v'] = $ret['user']['verified'] == false ? 0 : 1;
			$json['wb']['u']['site_v'] = $ret['user']['site_v']; 
			//转发微博内容
			if (isset($ret['retweeted_status'])) {
				$json['wb']['rt'] = array();
				$json['wb']['rt']['id'] = (string)$ret['retweeted_status']['id'];
				$json['wb']['rt']['cr'] = $ret['retweeted_status']['created_at'];
				$json['wb']['rt']['f'] = $ret['retweeted_status']['favorited'] == false ? 0 : 1;
				$json['wb']['rt']['s'] = $ret['retweeted_status']['source'];
				$json['wb']['rt']['tx'] = $ret['retweeted_status']['text'];
				$json['wb']['rt']['tp'] = isset($ret['retweeted_status']['thumbnail_pic']) ? $ret['retweeted_status']['thumbnail_pic'] : ''; 
				$json['wb']['rt']['mp'] = isset($ret['retweeted_status']['bmiddle_pic']) ? $ret['retweeted_status']['bmiddle_pic'] : '';
				$json['wb']['rt']['op'] = isset($ret['retweeted_status']['original_pic']) ? $ret['retweeted_status']['original_pic'] : '';
				$json['wb']['rt']['u'] = array();
				$json['wb']['rt']['u']['id'] = (string)$ret['retweeted_status']['user']['id'];
				$json['wb']['rt']['u']['sn'] = $ret['retweeted_status']['user']['screen_name'];
				$json['wb']['rt']['u']['p'] = $ret['retweeted_status']['user']['profile_image_url'];
				$json['wb']['rt']['u']['v'] = $ret['retweeted_status']['user']['verified'] == false ? 0 : 1;
				$json['wb']['rt']['u']['stie_v'] = $ret['retweeted_status']['user']['site_v']; 
			}
			$json['html'] = '<LI rel="w:'.$ret['id'].'">' . TPL::plugin('include/feed', $ret, true, false) . '</LI>';
		} else {
			$json = array();
			$json['comment']['id'] = (string)$result['id'];
			$json['comment']['create_at'] = APP::F('format_time', $result['created_at']);
			$json['comment']['text'] = APP::F('format_text', $result['text']);
			$json['comment']['nick'] = $result['user']['screen_name'];
			$json['comment']['uid'] = (string)$result['user']['id'];
			$json['comment']['profileImg'] = $type == 1 ? APP::F('profile_image_url', $result['user']['profile_image_url'], 'comment') : APP::F('profile_image_url', $result['user']['profile_image_url']);
			$json['comment']['v'] = $result['user']['verified'] == false ? 0 : 1; 
			$json['comment']['site_v'] = $result['user']['site_v']; 
		}

		$json['data'] = APP::getData('json', 'WBDATA',array());
		APP::ajaxRst($json, 0);
		exit;
	}


	/**
	 * 上传图片
	 *
	 *
	 */
	/*
	function upload_pic()
	{
		$callback = V('g:callback','');
		$redirect = 'window.location="'.W_BASE_URL.'js/blank.html?rand='.rand(1,PHP_INT_MAX) . '"';

		if (isset($_FILES['pic'])) {
			$result = DR('xweibo/xwb.uploadPic', '', $_FILES['pic']['tmp_name']);
			$result = $result['rst'];
			$json['html'] = '<LI rel="w:'.$ret['id'].'">' . TPL::plugin('include/feed', $ret, true, false) . '</LI>';
			APP::ajaxRst($json, '0');
			exit;
		} else {
			$json = array();
			$json['comment']['id'] = (string)$result['id'];
			$json['comment']['create_at'] = APP::F('format_time', $result['created_at']);
			$json['comment']['text'] = APP::F('format_text', $result['text']);
			$json['comment']['nick'] = $result['user']['screen_name'];
			$json['comment']['uid'] = (string)$result['user']['id'];
			$json['comment']['profileImg'] = $type == 1 ? APP::F('profile_image_url', $result['user']['profile_image_url'], 'comment') : APP::F('profile_image_url', $result['user']['profile_image_url']);
			//$json['comment']['sina_v'] = APP::F('filter', $result['user']['screen_name'], 'verify') == false ? 0 : 1;
			APP::ajaxRst($json, 0);
			exit;
		}
	}
	 */


	/**
	 * 删除当前用户的微博评论信息
	 *
	 *
	 */
	function comment_destroy()
	{
		/// 评论id, 支持评论删除
		$id = V('p:id');

		$ids = explode(',', $id);
		$countId = count($ids);
		if ($countId > 1) {
			//批量删除, 目前最多支持20个
			if ($countId > 20) {
				//超过20个, 分组调用批量接口
				$fail = false;
				$errs = array();
				$pagesize = ceil($countId/20);
				for ($p = 1; $p <= $pagesize; $p++) {
					$pos = ($p - 1) * 20;
					$pids = array_slice($ids, $pos, 20);
					$result = DR('xweibo/xwb.commentDestroyBatch', '', $pids);
					if (!empty($result['errno'])) {
						$errs[] = array('id' => $var, 'err' => $result['err']);
						$fail = true;
					}
				}	
				if ($fail === true) {
					APP::ajaxRst(false, '1020602', $errs);
				}
			} else {
				DS('xweibo/xwb.commentDestroyBatch', '', $ids);
			}
		} else {
			DS('xweibo/xwb.commentDestroy', '', $id); 
		}

		/// 删除评论缓存
		DD('xweibo/xwb.getCommentsToMe');
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 回复微博评论信息
	 *
	 *
	 */
	function reply()
	{
		$id = V('p:id');
		$cid = V('p:cid');
		$text = trim(V('p:text'));
		$forward = V('p:forward');
		$type = max(V('p:type'), 1);

		$add = false;
		/// 调用回复评论接口
		$result = DS('xweibo/xwb.reply', '', $id, $cid, $text);
		$result = F('weibo_filter', $result, true);
		
		if ($forward == 1) {
			$add = true;
			//作为一条新微博发布
			$ret = DR('xweibo/xwb.repost', '', $id, $text);
			$ret = $ret['rst'];
			if (is_array($ret)) {
				$ret['uid'] = USER::uid();
				$ret['author'] = true;
			}
			/// 过滤微博
			$ret = F('weibo_filter', $ret, true);
			$json = array();
			$json['comment']['id'] = (string)$result['id'];
			$json['comment']['create_at'] = APP::F('format_time', $result['created_at']);
			$json['comment']['text'] = APP::F('format_text', $result['text']);
			$json['comment']['nick'] = $result['user']['screen_name'];
			$json['comment']['uid'] = (string)$result['user']['id'];
			$json['comment']['profileImg'] = $type == 1 ? APP::F('profile_image_url', $result['user']['profile_image_url'], 'comment') : APP::F('profile_image_url', $result['user']['profile_image_url']);
			$json['comment']['v'] = $result['user']['verified'] == false ? 0 : 1; 
			$json['comment']['site_v'] = $result['user']['site_v']; 
			/// 微博内容
			$json['wb'] = array();
			$json['wb']['id'] = (string)$ret['id'];
			$json['wb']['cr'] = $ret['created_at'];
			$json['wb']['f'] = $ret['favorited'] == false ? 0 : 1;
			$json['wb']['s'] = $ret['source'];
			$json['wb']['tx'] = $ret['text'];
			$json['wb']['tp'] = isset($ret['thumbnail_pic']) ? $ret['thumbnail_pic'] : '';
			$json['wb']['mp'] = isset($ret['bmiddle_pic']) ? $ret['bmiddle_pic'] : '';  
			$json['wb']['op'] = isset($ret['original_pic']) ? $ret['original_pic'] : ''; 
			$json['wb']['u'] = array();
			$json['wb']['u']['id'] = (string)$ret['user']['id'];
			$json['wb']['u']['sn'] = $ret['user']['screen_name'];
			$json['wb']['u']['p'] = $ret['user']['profile_image_url'];
			$json['wb']['u']['v'] = $ret['user']['verified'] == false ? 0 : 1;
			$json['wb']['u']['sina_v'] = $ret['user']['site_v']; 
			//转发微博内容
			if (isset($ret['retweeted_status'])) {
				$json['wb']['rt'] = array();
				$json['wb']['rt']['id'] = (string)$ret['retweeted_status']['id'];
				$json['wb']['rt']['cr'] = $ret['retweeted_status']['created_at'];
				$json['wb']['rt']['f'] = $ret['retweeted_status']['favorited'] == false ? 0 : 1;
				$json['wb']['rt']['s'] = $ret['retweeted_status']['source'];
				$json['wb']['rt']['tx'] = $ret['retweeted_status']['text'];
				$json['wb']['rt']['tp'] = isset($ret['retweeted_status']['thumbnail_pic']) ? $ret['retweeted_status']['thumbnail_pic'] : ''; 
				$json['wb']['rt']['mp'] = isset($ret['retweeted_status']['bmiddle_pic']) ? $ret['retweeted_status']['bmiddle_pic'] : '';
				$json['wb']['rt']['op'] = isset($ret['retweeted_status']['original_pic']) ? $ret['retweeted_status']['original_pic'] : '';
				$json['wb']['rt']['u'] = array();
				$json['wb']['rt']['u']['id'] = (string)$ret['retweeted_status']['user']['id'];
				$json['wb']['rt']['u']['sn'] = $ret['retweeted_status']['user']['screen_name'];
				$json['wb']['rt']['u']['p'] = $ret['retweeted_status']['user']['profile_image_url'];
				$json['wb']['rt']['u']['v'] = $ret['retweeted_status']['user']['verified'] == false ? 0 : 1;
				$json['wb']['rt']['u']['site_v'] = $ret['retweeted_status']['user']['site_v']; 
			}
			$json['html'] = '<LI rel="w:'.$ret['id'].'">' . TPL::plugin('include/feed', $ret, true, false) . '</LI>';
		} else {
			$json = array();
			$json['comment']['id'] = (string)$result['id'];
			$json['comment']['create_at'] = APP::F('format_time', $result['created_at']);
			$json['comment']['text'] = APP::F('format_text', $result['text']);
			$json['comment']['nick'] = $result['user']['screen_name'];
			$json['comment']['uid'] = (string)$result['user']['id'];
			$json['comment']['profileImg'] = $type == 1 ? APP::F('profile_image_url', $result['user']['profile_image_url'], 'comment') : APP::F('profile_image_url', $result['user']['profile_image_url']);
			$json['comment']['v'] = $result['user']['verified'] == false ? 0 : 1; 
			$json['comment']['site_v'] = $result['user']['site_v']; 
		}
		APP::ajaxRst($json, 0);
		exit;
	}


	/**
	 * 关注某人
	 *
	 *
	 */
	function createFriendship()
	{
		$id = V('p:uid');
		//类型, 默认是0, 表示id是用户id, 1表示id是用户昵称
		$type = V('p:type', 0);

		if ($type == 1) {
			DS('xweibo/xwb.createFriendship', '', null, null, $id);
		} else {
			$ids = explode(',', $id);
			$countId = count($ids);
			if ($countId > 1) {
				//批量关注, 目前最多支持20个人
				if ($countId > 20) {
					//超过20个人, 分组调用批量接口
					$errNum = 0;
					$err = array();
					$pagesize = ceil($countId/20);
					for ($p = 1; $p <= $pagesize; $p++) {
						$pos = ($p - 1) * 20;
						$pids = array_slice($ids, $pos, 20);
						$result = DR('xweibo/xwb.createFriendshipBatch', '', $pids);
						if (!empty($result['errno'])) {
							$errNum++;
							array_push($err, array('uid' => $uid, 'err' =>  $result['err']));
						}
					}	
					if ($errNum > 0) {
						APP::ajaxRst(false, '1020804', $err);
					}
				} else {
					$result = DS('xweibo/xwb.createFriendshipBatch', '', $ids);	
				}
			} else {
				DS('xweibo/xwb.createFriendship', '', $id);
			}
		}

		//清除缓存
		DD('xweibo/xwb.getFriendIds');
		DD('xweibo/xwb.getFriends');

		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 取消关注或移除粉丝
	 *
	 *
	 */
	function deleteFriendship()
	{
		$user_id = V('p:id');
		$screen_name = V('p:name');
		$is_follower = V('p:is_follower');

		DS('xweibo/xwb.deleteFriendship', '', $user_id, $screen_name, $is_follower);

		//清除缓存
		if ($is_follower) {
			DD('xweibo/xwb.getFollowers');
		} else {
			DD('xweibo/xwb.getFriendIds');
		}
		
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 发送一条私信
	 *
	 *
	 */
	function sendDirectMessage()
	{
		$id = V('p:id');
		$name = V('p:name');
		$text = V('p:text');

		DS('xweibo/xwb.sendDirectMessage', '', $id, $text, $name);
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 删除一条私信
	 *
	 *
	 */
	function deleteDirectMessage()
	{
		$id = V('p:id');

		DS('xweibo/xwb.deleteDirectMessage', '', $id);
		/// 删除私信缓存
		DD('xweibo/xwb.getDirectMessages');
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 添加收藏
	 *
	 *
	 */
	function createFavorite()
	{
		//要收藏微博的id
		$id = V('p:id');

		DS('xweibo/xwb.createFavorite', '', $id);
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 删除当前用户收藏的微博信息
	 *
	 *
	 */
	function deleteFavorite()
	{
		$id = V('p:id');

		DS('xweibo/xwb.deleteFavorite', '', $id);
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 更改头像
	 *
	 *
	 */
	function updateProfileImage()
	{
		$image = V('p:image');

		DS('xweibo/xwb.updateProfileImage', '', $image);
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 更改资料
	 *
	 *
	 */
	function updateProfile()
	{
		$name = V('p:name');
		$gender = V('p:gender');
		$province = V('p:province');
		$city = V('p:city');
		$description = V('p:description');

		$updata = array('name' =>$name,
						'gender' => $gender,
						'province' => $province,
						'city' => $city,
						'description' => $description);
		DS('xweibo/xwb.updateProfile', '', $updata);
		APP::ajaxRst(true, 0);
		exit;
	}


	/**
	 * 获取未读微博 包括@我的, 新评论，新私信，新粉丝数
	 *
	 *
	 */
	function unread()
	{
		$since_id = V('p:id');

		$json = array();
		if ($since_id && V('-:userConfig/user_newfeed') == 1) {
			$list = array(); 
			//获取新的微博
			$result = DR('xweibo/xwb.getFriendsTimeline', '', 200, null, $since_id);
			$list = $result['rst'];

			/* 前端取消自动插入，暂不需要数据8*/
			$json = null;
			/*
			if ($list) {
				/// 过滤微博
				$list = F('weibo_filter', $list);
				$limit =  V('-:userConfig/user_page_wb') ?  V('-:userConfig/user_page_wb') : (V('-:sysConfig/each_page_wb') == '' ? WB_API_LIMIT : V('-:sysConfig/each_page_wb'));
				if (count($list) > $limit) {
					$list = array_slice($list, 0, $limit);
				}
				$ids = array();
				foreach ($list as $key => $var) {
					$ids[] = $var['id'];
					//如果存在转发微博
					if (isset($var['retweeted_status'])) {
						$ids[] = $var['retweeted_status']['id'];
					}
				}
				//获取该微博的转发数和评论数
				$ids = implode(',', $ids);
				$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
				$batch_counts = $batch_counts['rst'];
				foreach ($batch_counts as $key => $var) {
					$counts[$var['id']]['comments'] = $var['comments'];
					$counts[$var['id']]['rt'] = $var['rt'];
				}

				foreach ($list as $key => $item) {
					$json[$key]['id'] = (string)$item['id'];
					$json[$key]['cr'] = APP::F('format_time',$item['created_at']);
					$json[$key]['f'] = $item['favorited'] == false ? 0 : 1;
					$json[$key]['s'] = $item['source'];
					$json[$key]['tx'] = $item['text'];
					$json[$key]['ftx'] = APP::F('format_text', $item['text']);
					$json[$key]['tp'] = isset($item['thumbnail_pic']) ? $item['thumbnail_pic'] : '';
					$json[$key]['mp'] = isset($item['bmiddle_pic']) ? $item['bmiddle_pic'] : '';
					$json[$key]['op'] = isset($item['original_pic']) ? $item['original_pic'] : '';
					$json[$key]['rts'] = $counts[$item['id']]['rt'];
					$json[$key]['comments'] = $counts[$item['id']]['comments'];
					$json[$key]['u'] = array();
					$json[$key]['u']['id'] = (string)$item['user']['id'];
					$json[$key]['u']['sn'] = $item['user']['screen_name'];
					$json[$key]['u']['p'] = $item['user']['profile_image_url'];
					$json[$key]['u']['v'] = $item['user']['verified'] == false ? 0 : 1;
					$json[$key]['u']['site_v'] = $item['user']['site_v'];
					//转发微博内容
					if (isset($item['retweeted_status'])) {
						$json[$key]['rt'] = array();
						$json[$key]['rt']['id'] = (string)$item['retweeted_status']['id'];
						$json[$key]['rt']['cr'] = $item['retweeted_status']['created_at'];
						$json[$key]['rt']['f'] = $item['retweeted_status']['favorited'] == false ? 0 : 1;
						$json[$key]['rt']['s'] = $item['retweeted_status']['source'];
						$json[$key]['rt']['tx'] = $item['retweeted_status']['text'];
						$json[$key]['rt']['ftx'] = APP::F('format_text',$item['retweeted_status']['text']);
						$json[$key]['rt']['tp'] = isset($item['retweeted_status']['thumbnail_pic']) ? $item['retweeted_status']['thumbnail_pic'] : '';
						$json[$key]['rt']['mp'] = isset($item['retweeted_status']['bmiddle_pic']) ? $item['retweeted_status']['bmiddle_pic'] : '';
						$json[$key]['rt']['op'] = isset($item['retweeted_status']['original_pic']) ? $item['retweeted_status']['original_pic'] : '';
						$json[$key]['rt']['rts'] = $counts[$item['retweeted_status']['id']]['rt'];
						$json[$key]['rt']['comments'] = $counts[$item['retweeted_status']['id']]['comments'];
						$json[$key]['rt']['u'] = array();
						$json[$key]['rt']['u']['id'] = (string)$item['retweeted_status']['user']['id'];
						$json[$key]['rt']['u']['sn'] = $item['retweeted_status']['user']['screen_name'];
						$json[$key]['rt']['u']['p'] = $item['retweeted_status']['user']['profile_image_url'];
						$json[$key]['rt']['u']['v'] = $item['retweeted_status']['user']['verified'] == false ? 0 : 1;
						$json[$key]['rt']['u']['site_v'] = $item['user']['site_v'];
					}
				}
			}
			*/
		}

		//调用未读数接口
		$result = DR('xweibo/xwb.getUnread', '', $since_id);
		if (!empty($result['errno'])) {
			APP::ajaxRst(false, $result['errno'], $result['err']);
			exit;
		}

		$result = $result['rst'];
		//清除缓存
		if (isset($result['new_status']) && $result['new_status'] > 0) {
			//删除'我的首页'缓存
			DD('xweibo/xwb.getFriendsTimeline'); 
		} elseif ($result['comments'] > 0) {
			//删除'我收到的评论'缓存
			DD('xweibo/xwb.getCommentsToMe'); 
		} elseif ($result['dm'] > 0) {
			//删除'我的私信'缓存
			DD('xweibo/xwb.getDirectMessages'); 
		} elseif ($result['mentions'] > 0) {
			//删除'提到我的'缓存
			DD('xweibo/xwb.getMentions'); 
		} elseif ($result['followers'] > 0) {
			//删除'我的粉丝'缓存
			DD('xweibo/xwb.getFollowers'); 
		}

		//新微博
		$feeds = isset($result['new_status']) ? $result['new_status']: 0;
		//@我的微博数
		$mentions = $result['mentions'];
		//评论数
		$comments = $result['comments'];
		//新粉丝数
		$followers = $result['followers'];
		//私信
		$dm = $result['dm'];
		APP::ajaxRst(array('unread' => array($feeds, $mentions, $comments, $followers, $dm), 'data' => $json), 0);
		exit;
	}


	/**
	 * 获取指定微博的评论列表
	 *
	 *
	 */
	function getComments()
	{
		//评论的微博id
		$id = V('p:id');
		//显示评论数
		$count = V('p:count');

		//列表类型, 默认是1，微博列表的某条微博评论列表，2单条微博的详细评论列表
		$type = V('p:type');
		$type = empty($type) ? 1 : $type;

		if (empty($count)) {
			//设置每页显示微博数
			$limit = $type == 2 ? V('-:userConfig/user_page_comment') : 10;
			$count = $limit;
		} else {
			$limit = $count;
		}

		//页码数
		$page = max(V('p:page'), 1);

		$list = DR('xweibo/xwb.getComments', '', $id, $count, $page);
		if (!empty($list['errno'])) {
			APP::ajaxRst(false, $list['errno'], $list['err']);
			exit;
		}
		$list = $list['rst'];

		//过滤过敏评论列表
		$list = APP::F('weibo_filter', $list);

		$json = array();
		if (!empty($list)) {
			if (2 == $type) {
				foreach ($list as $key => $var) {
					if (isset($var['filter_state'])) {
						continue;
					}
					$json[$key]['id'] = (string)$var['id'];
					$json[$key]['create_at'] = APP::F('format_time', $var['created_at']);
					$json[$key]['text'] = APP::F('format_text', $var['text']);
					$json[$key]['nick'] = $var['user']['screen_name'];
					$json[$key]['uid'] = (string)$var['user']['id'];
					$json[$key]['profileImg'] = APP::F('profile_image_url', $var['user']['profile_image_url']);
					$json[$key]['user']['verified'] = $var['user']['verified'];
					$json[$key]['user']['site_v'] = $var['user']['site_v']; 
				}
			} else {
				foreach ($list as $key => $var) {
					if (isset($var['filter_state'])) {
						continue;
					}
					$json[$key]['id'] = (string)$var['id'];
					$json[$key]['create_at'] = APP::F('format_time', $var['created_at']);
					$json[$key]['text'] = APP::F('format_text', $var['text']);
					$json[$key]['nick'] = $var['user']['screen_name'];
					$json[$key]['uid'] = (string)$var['user']['id'];
					$json[$key]['profileImg'] = APP::F('profile_image_url', $var['user']['profile_image_url'], 'comment');
					$json[$key]['user']['verified'] = $var['user']['verified'];
					$json[$key]['user']['site_v'] = $var['user']['site_v']; 
				}
			}
		}

		$comments = DR('xweibo/xwb.getCounts', '', $id);
		$comments = $comments['rst'];

		$json['total'] = !empty($comments) ? $comments[0]['comments']: 0;
		$json['limit'] = $limit;
		APP::ajaxRst($json, 0);
		exit;
	}

	function sinaurl() {
		//获取要查询的ID，以逗号分隔
		$url_id = V('r:id');

		//var_dump($url_id);

		$http = APP::ADP('http');

		$http->setUrl(SINAURL_INFO);
		$http->setData('url=' . $url_id);
		$result = $http->request();

		if ($http->getState() == 200) {
			//APP::ajaxRst(json_decode($result));
			echo $result;
		}
		else {
			APP::ajaxRst(false, -1);
		}
		exit;
	}

	/**
	 * 清除新评论数tip，新粉丝tip，@我tip，新私信tip
	 *
	 * @return string
	 */
	function clearTip()
	{
		//清零类型
		$type = V('g:type', null);

		if ($type == 1) {
			//清零评论tip
			DS('xweibo/xwb.resetCount', '', 1);
		} elseif ($type == 2) {
			//清零@metip
			DS('xweibo/xwb.resetCount', '', 2);
		} elseif ($type == 3) {
			//清零私信tip
			DR('xweibo/xwb.resetCount', '', 3);
		} elseif ($type == 4) {
			//清零粉丝tip
			DR('xweibo/xwb.resetCount', '', 4);
		} else {
			//清零@metip
			DS('xweibo/xwb.resetCount', '', 2);

			//清零评论tip
			DS('xweibo/xwb.resetCount', '', 1);

			//清零粉丝tip
			DR('xweibo/xwb.resetCount', '', 4);

			//清零私信tip
			DR('xweibo/xwb.resetCount', '', 3);
		}

		APP::ajaxRst(true, 0);
		exit;
	}

	/**
	 * 查看某人是否是当用户的粉丝
	 *
	 *
	 */
	function friendShip()
	{
		$t_id = V('p:t_id');
		$t_name = V('p:t_name');
		$s_id = V('p:s_id');
		$s_name = V('p:s_name');

		$result = DR('xweibo/xwb.getFriendship', '', $t_id, $t_name, $s_id, $s_name);
		if (!empty($result['errno'])) {
			APP::ajaxRst(false, $result['errno'], $result['err']);
			exit;
		}

		$result = $result['rst'];
		if ($result['target']['following'] == true) {
			APP::ajaxRst(true, 0);
			exit;
		} else {
			APP::ajaxRst(false, 0);
			exit;
		}
	}

	/// tip的个人显示设置
	function setting()
	{
		$type = V('p:type', 'autoshow');

		$json = array();
		$json['user_page_wb'] = V('-:userConfig/user_page_wb');
		$json['user_page_comment'] = V('-:userConfig/user_page_comment');
		$json['user_newfeed'] =  V('-:userConfig/user_newfeed');
		$json['user_newmsg'] =  V('-:userConfig/user_newmsg');
		if ('autoshow' == $type) {
			$json['user_newfeed'] = 0;
		} else {
			$json['user_newmsg'] = 0;
		}

		$values = json_encode($json);

		DS('common/userConfig.set', '', $values);
		APP::ajaxRst(true, 0);
		exit;
	}

	/// 个人显示设置
	function saveShow()
	{
		$newmsg = (int)V('p:newmsg');
		$feedtotal = (int)V('p:feedtotal');
		$commenttotal = (int)V('p:commenttotal');

		$values = array();
		$values['user_newfeed'] = V('-:userConfig/user_newfeed');
		$values['user_newmsg'] = $newmsg;
		$values['user_page_wb'] = $feedtotal;
		$values['user_page_comment'] = $commenttotal;

		DS('common/userConfig.set', '', $values);
		APP::ajaxRst(true, 0);
		exit;
	}

	/// 保存个人资料
	function saveProfile()
	{
		$p['name']		= trim(V('p:nick'));
		$p['gender']	= trim(V('p:gender'));
		$p['province']	= trim(V('p:province'));
		$p['city']		= trim(V('p:city'));
		$p['description'] = trim(V('p:description'));

		//if (V('p:_debug')) {print_r($p);}

		if (empty($p['name'])) {
			APP::ajaxRst(false, 2010003);exit;
		}
		if (empty($p['gender'])) {
			APP::ajaxRst(false, 2010004);exit;
		}
		if (!is_numeric($p['province'])) {
			APP::ajaxRst(false, 2010005);exit;
		}
		if (!empty($p['city']) && !is_numeric($p['city'])) {
			APP::ajaxRst(false, 2010006);exit;
		}

		DS('xweibo/xwb.updateProfile', '', $p);
		/// 更新显示的昵称
		USER::set('screen_name',	$p['name']);
		//USER::set('description', $p['description']);

		APP::ajaxRst(true, 0);
		exit;
	}

	/// 更新tip显示方式和提醒设置
	function saveNotice()
	{
		$newfeed = (int)V('p:newfeed');
		$notice = array();
		$notice['comment'] = V('p:comment', 0);
		$notice['dm'] = V('p:dm', 0);
		$notice['follower'] = V('p:follower', 0);
		$notice['mention'] = V('p:mention', 0);
		$notice['from_user'] = V('p:from_user');
		$notice['status_type'] = V('p:status_type');

		/// 更新提醒设置
		DS('xweibo/xwb.updateNotice', '', $notice);
		/// 更新显示tip方式设置
		DS('common/userConfig.set', '', 'user_newfeed', $newfeed);
		APP::ajaxRst(true, 0);
		exit;
	}

	/**
	 * 批量获取评论数和转发数
	 *
	 * @param unknown_type
	 * @return unknown
	 */
	function getCounts()
	{
		$ids = V('p:ids');
		
		$uid = USER::uid();
		if (!$uid) {
			if (!defined('WB_USER_OAUTH_TOKEN') || !WB_USER_OAUTH_TOKEN) {
				APP::ajaxRst(true, 0);
				exit;
			}

			DS('xweibo/xwb.setToken', '', 2);

			$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
		} else {
			$batch_counts = DR('xweibo/xwb.getCounts', '', $ids);
		}

		if (!empty($batch_counts['errno'])) {
			APP::ajaxRst(false, $batch_counts['errno'], $batch_counts['err']);
			exit;
		}

		$batch_counts = $batch_counts['rst'];

		if (!empty($batch_counts)) {
			$counts = array();
			foreach ($batch_counts as $key => $var) {
				$counts[(string)$var['id']] = array($var['comments'], $var['rt']);
			}
			APP::ajaxRst($counts, 0);
			exit;
		}
		APP::ajaxRst(true, 0);
		exit;
	}

	/**
	 * 添加标签 
	 *
	 * @return	
	 */
	function createTags()
	{
		$tagName = V('p:tagName');
		
		$ret = DR('xweibo/xwb.createTags', '', $tagName);
		if (!empty($ret['errno'])) {
			APP::ajaxRst(false, $ret['errno'], $ret['err']);
			exit;
		}
		$ret = $ret['rst'];
		$json = array();
		foreach ($ret as $key => $item) {
			$json[$key]['tagid'] = $item['tagid'];	
		}

		APP::ajaxRst(array('data' => $json), 0);
	}

	/**
	 * 删除标签 
	 *
	 * @return	
	 */
	function deleteTags()
	{
		$tag_id = V('p:tag_id');
	
		DS('xweibo/xwb.deleteTags', '', $tag_id);
		APP::ajaxRst(true, 0);
	}

	/**
	 * 添加黑名单 
	 *
	 * @return	
	 */
	function createBlocks()
	{
		$id = V('p:id');
		$name = V('p:name');

		DS('xweibo/xwb.createBlocks', '', $id, $name);
		APP::ajaxRst(true, 0);
	}

	/**
	 * 删黑名单 
	 *
	 * @return	
	 */
	function deleteBlocks()
	{
		$id = V('p:id');
		$name = V('p:name');
	
		DS('xweibo/xwb.deleteBlocks', '', $id, $name);
		APP::ajaxRst(true, 0);
	}

	/**
	 * 获取认证url 
	 *
	 * @return	
	 */
	function getTokenAuthorizeURL()
	{
		$url = V('p:url');
		$oauth_url = DS('xweibo/xwb.getTokenAuthorizeURL', '', $url);
		APP::ajaxRst($oauth_url);
		exit;	
	}

	/**
	 * 从API得到表情数据
	 *　服务端缓存１天
	 *　客户端缓存１小时
	 */
	function emotions()
	{
		$faces = DR('xweibo/xwb.emotions', 86400);
		header('max-age: 3600');
		APP::ajaxRst($faces['rst']);
		exit;
	}

	function getProvinces() {
		$rs = DS('xweibo/xwb.getProvinces', '86400');

		APP::ajaxRst($rs);
		exit;
	}
}