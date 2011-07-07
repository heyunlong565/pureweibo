<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 微博频道模块
 * @author yaoying
 * @version $Id: component_5.pls.php 11525 2011-03-14 07:43:17Z yaoying $
 *
 */
class component_5_pls extends component_abstract_pls{
	
	function run($mod){
		$mod['param']['list_id']  = isset($mod['param']['list_id']) && !empty($mod['param']['list_id']) ? $mod['param']['list_id'] : FALSE;
		$mod['param']['show_num'] = isset($mod['param']['show_num']) ? (int)$mod['param']['show_num'] : 1;
		$mod['param']['page_type'] = isset($mod['param']['page_type']) && ($mod['param']['page_type'] != 0) ? 1 : 0;
		$mod['param']['page'] = (($mod['param']['page_type'] == 1) && USER::isUserLogin()) ? (int)V('g:page', 1) : 1;
		
		parent::run($mod);
		
		if(false == $mod['param']['list_id']){
			$this->_error('ListId为空');
			return ;
		}
		
		$userList = DR('components/officialWB.getUsers', 'g/300', $mod['param']['list_id']);
		//减轻API负担：几个api调用时，进行依赖性分级。若api A不正常或者为空，则B可以不运行
		if (/*$userList['errno'] == 0 && */isset($userList['rst']['users']) && is_array($userList['rst']['users']) && !empty($userList['rst']['users'])){
			$weiboList = DR('components/officialWB.get', 'g/300', $mod['param']['show_num'], $mod['param']['list_id'], $mod['param']['page']);
		}else{
			if(isset($userList['err']) && false !== strpos(strtolower($userList['err']), 'exist')){
				$weiboList = RST(array(), -999999, 'API返回不存在用户列表。');
			}else{
				$weiboList = RST(array(), $userList['errno'], '获取components/officialWB.getUsers失败或为空，故不再获取微博列表。components/officialWB.getUsers错误信息：'. $userList['err']);
			}
		}
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'weiboList' => $weiboList, 'userList' => $userList));
		if ($weiboList['errno'] == 0 && is_array($weiboList['rst'])) {
			return array('cls'=>'wblist', 'list' =>F('format_weibo',$weiboList['rst']));
		}
		
	}
	
}