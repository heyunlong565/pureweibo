<?php
/**
 * @file			show.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			单条微博控制器-Xweibo
 */

class show_mod {

	function show_mod()
	{
	}

	/**
	 * 某人的单条微博的评论列表
	 *
	 *
	 */
	function default_action()
	{
		$id = V('g:id');

		if (empty($id)) {
			//提示访问的页面不存在，跳转到首页
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的页面不存在'));
		}

		//调用单条微博的详细信息接口
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		if ($mblog_info['errno']) {
			APP::tips(array('tpl' => 'e404', 'msg'=> '您要访问的页面不存在'));
		}
		$mblog_info = $mblog_info['rst'];

		/// 过滤过敏微博
		$mblog_info = APP::F('weibo_filter', $mblog_info, true);
		if (empty($mblog_info)) {
			APP::tips(array('tpl' => 'e404', 'msg'=> '您要访问的页面不存在'));
		} elseif (isset($mblog_info['filter_state']) && ($mblog_info['filter_state'] == 3)) {
			APP::tips(array('tpl' => 'e403', 'msg'=> '该微博已被删除或屏蔽'));
		}

		//获取个人资料
		$userinfo = DR('xweibo/xwb.getUserShow', '', $mblog_info['user']['id']);
		$userinfo = $userinfo['rst'];
		/// 过滤过敏用户
		$userinfo = F('user_filter', $userinfo, true);

		if (empty($userinfo)) {
			APP::tips(array('tpl' => 'e404', 'msg' => '抱歉你所访问的用户不存在'));
		}

		$ids = array();
		$ids[] = (string)$mblog_info['id'];
		if (isset($mblog_info['retweeted_status']['id'])) {
			$ids[] = (string)$mblog_info['retweeted_status']['id'];
		}


		/// 右侧模块数据
		$modules = DS('PageModule.getPageModules', '', 2, 1);

		TPL::assign('id', $id);
		TPL::assign('userinfo', $userinfo);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]: array());
		TPL::assign('mblog_info', $mblog_info);
		TPL::assign('uid', USER::uid()); 
		TPL::display('mblog_detail');
	}
}
?>
