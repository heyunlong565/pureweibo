<?php
/**
 * @file			ta.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			'ta的'控制器-Xweibo
 */

class ta_mod
{

	function ta_mod()
	{
	}

	/**
	 * ta的首页
	 *
	 *
	 */
	function default_action()
	{
		$id = V('g:id');
		$name = V('g:name');

		if (USER::isUserLogin()) {
			if (empty($id) && empty($name)) {
				/// 提示不存在	
				APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
			}

			//如果是自己，跳转到首页
			if ($id == USER::uid() || ($name && USER::v('screen_name') == $name)) {
				APP::redirect('index', 2);
				exit;	
			}
			/// 调用微博个人资料接口
			$userinfo = DR('xweibo/xwb.getUserShow', 'p', null, $id, $name);
			/// 过滤过敏用户
			$userinfo = F('user_filter', $userinfo['rst'], true);
			if (empty($userinfo)) {
				/// 提示不存在	
				APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
			} elseif (isset($userinfo['filter_state']) && $userinfo['filter_state'] == 2) {
				/// 屏蔽用户
				APP::tips(array('tpl' => 'e403', 'msg' => '该用户已经给屏蔽了'));
			}

			/// 获取ta的粉丝列表前9条数据
			$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9);
			$followers = $followers['rst'];
			
			/// 页码数
			$page = max(V('g:page'), 1);

			/// 设置每页显示微博数
			$limit = V('-:userConfig/user_page_wb');
			$count = $limit;

			/// 调用获取当前用户所关注用户的最新微博信息api
			$list = DR('xweibo/xwb.getUserTimeline', '', $userinfo['id'], null, null, null, null, $count, $page);
			$list = $list['rst'];
			
			/// 获取当前用户的粉丝列表id
			$fids = DR('xweibo/xwb.getFollowerIds', '', USER::uid(), null, null, -1, 5000);
			$fids = $fids['rst'];

			TPL::assign('fids', $fids['ids']);
			TPL::assign('limit', $limit);
		} else {
			if (empty($name)) {
				DS('xweibo/xwb.setToken', '', 2);
				/// 调用微博个人资料接口
				$userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name);
				/// 提示不存在
				//APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
			} else {
				/// 调用微博个人资料接口
				$userinfo = DR('xweibo/xwb.getUserShow', '', null, null, $name, false);
			}
			/// 过滤过敏用户
			$userinfo = F('user_filter', $userinfo['rst'], true);
			if (empty($userinfo)) {
				/// 提示不存在	
				APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
			} elseif (isset($userinfo['filter_state']) && $userinfo['filter_state'] == 2) {
				/// 屏蔽用户
				APP::tips(array('tpl' => 'e403', 'msg' => '该用户已经给屏蔽了'));
			}

			/// 获取当前用户的最新微博信息
			$list = DR('xweibo/xwb.getUserTimeline', '', null, null, $userinfo['screen_name'], null, null, null, null, false);
			$list = $list['rst'];

			/// 获取前9位优质粉丝信息
			$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9, false);
			$followers = $followers['rst'];
		}

		//页面代号
		APP::setData('page', 'ta', 'WBDATA');
	
		TPL::assign('uid', USER::uid());
		TPL::assign('list', $list);
		TPL::assign('userinfo', $userinfo);
		TPL::assign('followers', $followers['users']);
		TPL::display('ta_profile');
	}

	/**
	 * ta的关注列表
	 *
	 *
	 */
	function follow()
	{
		$id = V('g:id');
		$name = V('g:name');
		if (empty($id) && empty($name)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的页面不存在'));
		}

		/// 如果是自己，跳转到首页
		if (($name && $name == USER::v('screen_name')) || $id == USER::uid()) {
			APP::redirect('index.follow', 2);
		}

		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', '', $id, null, $name);
		//过滤过敏用户
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			/// 提示不存在	
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
		}

		/// 光标开始位置
		$start_pos = V('g:start_pos');
		/// 下一个光标开始位置
		$end_pos = V('g:end_pos');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}

		/// 调用获取当前用户关注对象列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFriends', '', $userinfo['id'], null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['friends_count'];
		/// 过滤关注列表
		$list['users'] = F('user_filter', $list['users']);

		/// 获取前9位优质粉丝信息
		$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9);
		$followers = $followers['rst'];

		/// 获取当前用户的关注列表id
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst'];

		TPL::assign('list', $list);
		TPL::assign('limit', $limit);
		TPL::assign('uid', USER::uid());
		TPL::assign('userinfo', $userinfo);
		TPL::assign('followers', $followers['users']);
		TPL::assign('fids', $fids['ids']);
		TPL::display('ta_follow');
	}


	/**
	 * ta的粉丝列表
	 *
	 *
	 */
	function fans()
	{
		$id = V('g:id');
		$name = V('g:name');
		if (empty($id) && empty($name)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的页面不存在'));
		}
		
		/// 调用微博个人资料接口
		$userinfo = DR('xweibo/xwb.getUserShow', '', $id, '', $name);
		//过滤过敏用户
		$userinfo = F('user_filter', $userinfo['rst'], true);
		if (empty($userinfo)) {
			/// 提示不存在	
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
		}

		/// 如果是自己，跳转到首页
		if (($name && $name == USER::v('srceen_name')) || $id == USER::uid()) {
			APP::redirect('index.fans', 2);
		}

		/// 光标开始位置
		$start_pos = V('g:start_pos');
		/// 下一个光标开始位置
		$end_pos = V('g:end_pos');

		/// 页码数
		$page = max(V('g:page'), 1);

		/// 设置每页显示微博数
		$limit = WB_API_LIMIT;
		$count = $limit;

		if (empty($end_pos) && empty($start_pos)) {
			$cursor = -1;
		} elseif (!empty($start_pos)) {
			$cursor = $start_pos;
		} elseif (!empty($end_pos)) {
			$cursor = $end_pos;
		}

		/// 调用获取ta的粉丝列表及最新一条微博信息api
		$list = DR('xweibo/xwb.getFollowers', '', $userinfo['id'], null, null, $cursor, $count);
		$list = $list['rst'];
		$list['x_total'] = $userinfo['followers_count'];
		/// 过滤粉丝列表
		$list['users'] = F('user_filter', $list['users']);
	
		/// 获取当前用户的关注列表id
		$fids = DR('xweibo/xwb.getFriendIds', '', USER::uid(), null, null, -1, 5000);
		$fids = $fids['rst'];

		/// 获取前9位优质粉丝信息
		$followers = DR('xweibo/xwb.getMagicFollowers', '', $userinfo['id'], 9);
		$followers = $followers['rst'];

		TPL::assign('list', $list);
		TPL::assign('uid', USER::uid());
		TPL::assign('userinfo', $userinfo);
		TPL::assign('limit', $limit);
		TPL::assign('followers', $followers['users']);
		TPL::assign('fids', $fids['ids']);
		TPL::display('ta_fans');
	}

	function profile()
	{
		$this->default_action();
	}

}
