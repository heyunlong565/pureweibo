<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 今日话题模块
 * @author yaoying
 * @version $Id: component_10.pls.php 12897 2011-04-11 10:10:15Z zhenquan $
 *
 */
class component_10_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		/*
		$rs = DR('components/todayTopic.get', 'g/300', $mod['param']);
		
		if ($rs['errno']) {
			$this->_error('components/todayTopic.get 返回错误：'. $rs['err']. '('. $rs['errno']. ')');
			return;
	 	}
	 	
	 	//如果没有关键字，直接退出
		$today = &$rs['rst'];
		if (!$today['keyword']) {
			$this->_error('无关键字。');
			return;
		}
		
		if($today['errno'] == 0 && is_array($today['data']['rst']) && !empty($today['data']['rst'])){
			$followedList = $this->_generateFollowedList($today['data']['rst']);
		}else{
			$today['data']['rst'] = array();
			$followedList = array();
		}
		*/
		$kw = $mod['param']['topic'];
		$source = $mod['param']['source'];
		$show_num = $mod['param']['show_num'];
		if (USER::isUserLogin()/* && $source*/) {
			$list = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => $kw, 'rpp' => $show_num, 'page' => 1));
		} else {
			$list = DR('xweibo/xwb.searchStatuse', null, array('base_app' => $source, 'q' => $kw, 'rpp' => $show_num, 'page' => 1), false);
		}
		//结果集处理:　只要show_num条内容
		if ($list['errno'] == 0) {
			if ( count($list['rst']) > $show_num ) {
				$list['rst'] = array_slice($list['rst'], 0, $show_num);
			}

			$errno = 0;
			$err = '';
		} else {
			$errno = $list['errno'];
			$err = $list['err'];
		}

		$today = array(
			'errno' => $errno,
			'err' => $err,
			'keyword' => $mod['param']['topic'],
			'data' => $list
		);
		$followedList = $this->_generateFollowedList($today['data']['rst']);
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'today' => $today, 'followedList' => $followedList));
		return array('cls'=>'wblist', 'list' =>F('format_weibo', $today['data']['rst']) );
		
	}
	
	/**
	 * 生成本组件内的用户rst数组资源内已经关注的用户数组，类型为：
	 * <pre>
	 * array((string)已关注用户id1 => 1, (string)已关注用户id2 => 1, ......);
	 * </pre>
	 * 模板内可通过以下方法判断用户是否已经关注了某用户：
	 * <pre>
	 * isset($followedList[(string)$user['id']]);
	 * array_key_exists((string)$user['id'], $followedList);
	 * </pre>
	 * @param array $rst 本组件内生成的用户rst数组资源
	 * @return array
	 */
	function _generateFollowedList($rst){
		$uid = USER::uid();
		$flw = $followedList = array();
		if ($uid) {
			$flRet = DR ( 'xweibo/xwb.getFriendIds', 'p1', $uid, null, null, null, 5000 );
			$flw = ($flRet ['errno'] == 0) ? (array)$flRet['rst'] : array();
		}
		if(empty($flw)){
			return $followedList;
		}
		
		foreach($rst as $tp){
			if(in_array($tp['user']['id'], $flw['ids'])){
				$followedList[(string)$tp['user']['id']] = 1;
			}
		}
		
		return $followedList;
		
	}
	
	
}
