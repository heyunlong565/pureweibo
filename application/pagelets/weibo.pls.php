<?php 
class weibo_pls {
	/**
	 * 微博发布框  
	 */
	function input($params = array()) 
	{
		TPL::module('input', $params);
		
		// 发微薄时要回传给 php的参数
		if ( isset($params['ext_xwbAdditive']) )  {
			return array('cls'=>'input', 'params'=>$params['ext_xwbAdditive']);
		} 
		
		return array('cls'=>'input');
	}

	/**
	 * 他的微博列表
	 *@param $userinfo array 微博接口返回的用户资料
	 */
	function userTimelineList($userinfo) {
		$id = V('g:id');
		$name = V('g:name');
		$count = $page = $limit = null;
		$filter_type = V('g:filter_type');
		if (USER::isUserLogin()) {
			//过滤类型
			/// 页码数
			$page = max(V('g:page'), 1);
			$oauth = true;
			/// 设置每页显示微博数
			$limit = V('-:userConfig/user_page_wb');
			$count = $limit;
		} else {
			$oauth = false;
		}
		
		/// 调用获取当前用户所关注用户的最新微博信息api
		$list = DR('xweibo/xwb.getUserTimeline', '', $userinfo['id'], null, $userinfo['screen_name'], null, null, $count, $page, $filter_type, $oauth);
		$list = $list['rst'];
		$param = array('list' => $list,
					'limit'=>$limit, 
					'uid' => $userinfo['id'], 
					'header'=>0,
					'author'=>0,
					'show_unread_tip' => false,
					'empty_msg'=> F('escape', $userinfo['screen_name']) . '还没有开始发微博，请等待。',
					'not_found_msg' => '找不到符合条件的微博，返回查看<a href="' . URL('index') . '">全部微博</a>',
					'list_title'=>$userinfo['id'] == USER::uid()?'我的微博':F('escape', $userinfo['screen_name']) . '的微博',
					'filter_type'=>$filter_type);
		TPL::module('weibolist', $param);
		return array('cls'=>'wblist', 'list' =>F('format_weibo',$list));
	}

	function atme($param =array()) {
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;
		$filter_type = V('g:filter_type');

		$result = DR('xweibo/xwb.getMentions', CACHE_MENTIONS, $count, $page);
		$list = $result['rst'];
		$param['list'] = $list;
		$param['limit'] = $limit;
		$param['author']=1;
		$param['show_filter_type'] = false;
		TPL::module('weibolist', $param);
		return array('cls'=>'wblist', 'list' => F('format_weibo',$list));
	}

	/**
	 * 评论列表
	 *@param $params array('type'=>'to'|'by','count'=>int,'page'=>int)
	 */
	function comments($params) {
		extract($params, EXTR_SKIP);
		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		//$limit = WB_API_LIMIT;//V('-:userConfig/user_page_comment');
		$limit = V('-:userConfig/user_page_comment');
		$count = $limit;
		$type = isset($type) ? $type : 'to';
		if ($type === 'to') {
			$result = DR('xweibo/xwb.getCommentsToMe', CACHE_COMMENT_TO_ME, $count, $page);
		} else {
			$result = DR('xweibo/xwb.getCommentsByMe', '', $count, $page);
		}

		$list = array();
		if (empty($result['errno'])) {
			$list = $result['rst'];
			/// 过滤微博
			$list = F('weibo_filter', $list);
		}
		$params = array(
			'limit' => $limit,
			'page' => $page,
			'list' => $list,
			'uid' => USER::uid(),
			'type' => $type,
		);
		TPL::module('comment', $params);
	}

	/**
	 * 使用已存在的微博列表数据显示列表
	 *@param $param 微博列表
	 */
	function weiboList($param) {
		TPL::module('weibolist', $param);
		return array('cls'=>'wblist', 'list' =>F('format_weibo',$param['list']) );
	}

	function weiboOnly($param) {
		TPL::module('feedlist', $param);
		return array('cls'=>'wblist', 'list' =>F('format_weibo',$param['list']) );
	}

	function detail($param) {
		TPL::module('mblog_detail', $param);
		return array('cls'=>'wblist', 'list' =>F('format_weibo',array($param['mblog_info']), USER::aid()?false:true));
	}
	
}
?>
