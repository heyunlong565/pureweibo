<?php
class live_pls {


	/**
	 * 在线直播首页列表
	 */
	function liveIndexList() {
		$page = V('g:page', 1);
		$limit = 20;

		$list = array();
		$last_item = array();
		$list_member = array();
		$list = DS('microLive.getLiveList', 'g0/1800', $page, $limit);
		if ($list) {
			$last_item = array_shift($list);
			$uids = $last_item['guest'];
			$list_member = array();
			if ($uids) {
				$ulist = DR('microLive.getLiveUsersBatchShow', '', $uids);
				if (empty($ulist['errno'])) {
					$list_member = $ulist['rst'];
				}
			}
		}

		$difference = '';
		/// 未开始
		if (isset($last_item['start_time']) && $last_item['start_time'] > APP_LOCAL_TIMESTAMP) {
			$difference_time = $last_item['start_time'] - APP_LOCAL_TIMESTAMP;
			$difference_date = floor($difference_time / 86400);
			$difference_hour = floor($difference_time % 86400 / 3600);
			$difference_minutes = floor($difference_time % 86400 % 3600 / 60);
			$difference_seconds = floor($difference_time % 86400 % 3600 % 60);
			if ($difference_date != 0) {
				$difference = $difference_date.'天';
			}
			if ($difference_hour != 0) {
				$difference .= $difference_hour.'小时';
			}
			if ($difference_minutes != 0) {
				$difference .= $difference_minutes.'分';
			}
			$difference .= $difference_seconds.'秒';
		}
		/// 获取活动总记录数
		TPL::module('microlive/news_live', array('list' => $list, 
					'list_member' => $list_member, 
					'last_item' => $last_item, 
					'difference' => $difference
				)
		);

		$last_start_time = isset($last_item['start_time']) ? $last_item['start_time'] : '';
		$last_item_status = isset($last_item['state']) ? $last_item['state'] : '';
		return array('starttime'=> $last_start_time, 'status' => $last_item_status, 'nowtime' => APP_LOCAL_TIMESTAMP);
	}

	/**
	 * 在线直播列表页列表
	 */
	function liveList() {
		$page = V('g:page', 1);
		$limit = 20;

		$list = $last_item = array();
		$list = DS('microLive.getLiveList', 'g0/1800', $page, $limit);

		/// 获取活动总记录数
		$count = DS('microLive.getCount', 'g0/1800', $page);
		TPL::module('microlive/news_live_list', array('list' => $list, 'count' => $count, 'limit' => $limit));
	}

	/**
	 * 在线直播首页的在线直播基本信息
	 */
	function liveBaseInfo($params) {
		$info = $params['info'];
		TPL::module('microlive/side_live_base_info', array('info' => $info));
	}

	/**
	 * 在线直播首页的主持人列表
	 */
	function liveBaseMaster($params) {
		$info = empty($params['info']) ? '' : $params['info'];
		$uids = isset($info['master']) ? $info['master'] : '';

		$list_member = array();
		$list_fans = array();
		$listFans = array();
		if ($uids) {
			$ulist = DR('microLive.getLiveUsersBatchShow', '', $uids);
			if (empty($ulist['errno'])) {
				$list_member = $ulist['rst'];
			}
			/// 与主持人的关注关系
			$list_fans = DR('xweibo/xwb.getFriendIds', null, USER::uid(), null, null, -1, 5000);
			$listFans = array();
			if (empty($list_fans['errno'])) {
				$listFans = $list_fans['rst']['ids'];
			}
			/*
			$list_fans = DR('xweibo/xwb.getFriendshipsBatchExists', '', $uids);
			if (empty($list_fans['errno'])) {
				$list_fans = $list_fans['rst'];
				foreach ($list_fans as $var) {
					$listFans[$var['id']] = $var['result'];
				}
			}
			 */
		}

		TPL::module('microlive/side_live_base_master', array('ulist' => $list_member, 'listFans' => $listFans));
	}

	/**
	 * 侧栏在线直播列表
	 */
	function sideNewsLive($params) {
		$liveInfo = $params['liveInfo'];
		$list = array();
		$list_member = array();
		$ulist = array();

		$limit = 5;
		$live_id = empty($liveInfo['id']) ? '' : $liveInfo['id'];
		$list = DS('microLive.getLiveList', 'g0/1800', 1, $limit, 'id != "'.$live_id.'"');
		if ($list) {
			foreach ($list as $var) {
				$ids[] = $var['master'];
			}
			$ids = implode(',', $ids);
			$ulist = DR('microLive.getLiveUsersBatchShow', '', $ids);
			if (empty($ulist['errno'])) {
				$ulist = $ulist['rst'];
				foreach ($ulist as $var) {
					$list_member[$var['id']] = $var;
				}
			}
		}

		TPL::module('microlive/side_news_live', array('list' => $list, 'list_member' => $list_member));
	}

	/**
	 * 在线直播详细页面侧栏主持人，嘉宾列表
	 */
	function usersList($params) {
		/// 主持人
		$info = $params['liveInfo'];
		$masters = $info['master']; 
		$master_uids = array();
		$guest_uids = array();
		$uids = array();
		if ($masters) {
			$master_uids = explode(',', $masters);
		}
		/// 嘉宾
		$guests = $info['guest']; 
		if ($guests) {
			$guest_uids = explode(',', $guests);
		}
		$uids = array_merge($master_uids, $guest_uids);
		$master_list = array();
		$guest_list = array();
		if ($uids) {
			$ulist = DR('microLive.getLiveUsersBatchShow', '', implode(',', $uids));
			if (empty($ulist['errno'])) {
				$ulist = $ulist['rst'];
				foreach ($ulist as $key => $var) {
					if (in_array($var['id'], $master_uids)) {
						$master_list[] = $var;
					}

					if (in_array($var['id'], $guest_uids)) {
						$guest_list[] = $var;
					}
				}
			}
		}

		TPL::module('microlive/live_detail_users', array('master_list' => $master_list, 'guest_list' => $guest_list));
	}

	/**
	 * 在线直播详细页 指定在线直播的视频，介绍信息
	 */
	function liveDetailsInfo($params) {
		$liveInfo = array();
		$liveInfo = $params['liveInfo'];
		TPL::module('microlive/live_detail_info', array('liveInfo' => $liveInfo));
	}

	/**
	 * 在线直播详细页 在线直播微博列表
	 */
	function liveWblist($infos) {
		$id = V('g:id');
		$page = V('g:page', 1);
		$limit = 20;
		$wb_id_array = DS('microLive.getMicroLiveWbs', 'g0/1800', $id, 1, $page, $limit);
		$total = DS('microLive.getCount', 'g0/1800', $id);

		$list = array();
		$news_list = array();
		if ($wb_id_array ) {
			$wb_ids = array();
			$wids = array();
			foreach ($wb_id_array as $var) {
				$wb_ids[] = $var['wb_id'];
				$wids[$var['wb_id']] = array('type' => $var['type'], 'state' => $var['state']);
			}
			$list = DR('xweibo/xwb.getStatusesBatchShow', '', implode(',', $wb_ids));
			if (empty($list['errno'])) {
				$list = $list['rst'];
				foreach ($list as $var) {
					if (isset($var['estate']) && $var['estate'] == 'deleted') {
						/// 如果该微博已经被删除，也删除该直播的微博信息
						DR('microLive.deleteLiveWb', '', $id, $var['id']);
						continue;
					}
					/// 区分发微博者是主持人，嘉宾还是网友
					if ('2' == $wids[$var['id']]['type']) {
						$var['user']['live_user_type'] = 'master';
					} elseif ('3' == $wids[$var['id']]['type']) {
						$var['user']['live_user_type'] = 'guest';
					}
					$news_list[] = $var;
				}
			}
		}

		$info = $infos['liveInfo'];
		$list_title = $info['state'] == 'E' ? '直播内容<span class="close">(已结束)</span>' : '直播内容<span>(共有'.$total.'条)</span>';
		$params = array();
		$params['list'] = $news_list;
		$params['list_title'] = $list_title;
		$params['limit'] = $limit;
		$params['author']=1;
		$params['show_filter_type'] = false;
		$params['show_list_title'] = true;
		$params['show_unread_tip'] = false;
		$params['show_feed_refresh'] = true;
		$params['empty_msg'] = '暂时没有相关的话题微博';
		TPL::module('microlive/live_detail_wb', array('params' => $params));

		return array('cls'=>'wblist', 'list' => F('format_weibo',$news_list), 'liveid' => $info['id'], 'wb_id' => !empty($news_list) ? $news_list[0]['id'] : '');
	}
}
?>
