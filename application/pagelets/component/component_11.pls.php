<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 多用户组tab模块
 * @author yaoying
 * @version $Id: component_11.pls.php 11912 2011-03-23 08:43:59Z yaoying $
 *
 */
class component_11_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		//$cid = (int)V('g:cid', 0);
		$category = DR('components/categoryUser.getGroups', 'g1/0', (int)$mod['id']);
		
		$category = isset($category['rst']['groups']) && is_array($category['rst']['groups']) ? $category['rst']['groups'] : array();
		
		if (empty($category) ){
			$this->_error('components/categoryUser.getGroups 从数据库中获取失败或者无数据');
			return;
		}
		/*
		if ($cid == 0 || !isset($category[$cid])) {
			reset($category);
			$cid = key($category);
		}
		
		if (!$cid) {
			$this->_error('cid不存在');
			return;
		}
		*/

		foreach ($category as $cid=>$ctg) {
			$users = DR('components/categoryUser.get', 'g1/300', $cid);
			
			
			if(!is_array($users['rst'])){
				$this->_error('components/categoryUser.get返回错误的非数组类型数据。错误信息：'. $users['err']. '(Errno: '. $users['errno']. ')');
				return ;
			}
			
			$users = $users['rst'];

			// 转换
			$data = array();
			$uid = USER::uid();
			if ($uid) {
				$ids = DR('xweibo/xwb.getFriendIds', 'p1', $uid, null, null, -1, 5000);
				$ids = isset($ids['rst']['ids']) && is_array($ids['rst']['ids']) ? $ids['rst']['ids'] : array();
			} else {
				$ids = array();
			}
			
			foreach($users as $item){
				$data[] = array (
					'id' => $item['uid'],
					'profile_image_url' => F('profile_image_url', $item['uid']),
					'screen_name' => $item['nickname'],
					'description' => $item['remark'],
					'following' => in_array($item['uid'], $ids) ? true : false
					);
			}
			
			$data = F('user_filter', $data);
			$all_users[$cid] = $data;
		}
		$requestRoute = APP::getRequestRoute(true);
		$route = isset($requestRoute['class']) ? $requestRoute['class'] : 'pub';
		
		$page_id = (int)V('g:page_id');
		
		TPL::module('recommendUser', array('base_url' => URL($route, 'page_id='. $page_id. '&cid='), 'title'=> $mod['title'], 'cid' => $cid, 'category' => $category, 'users' => $all_users));
		return array('cls'=>'category_user');
	}
	
	
}
