<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 热门话题列表模块
 * @author yaoying
 * @version $Id: component_6.pls.php 15335 2011-05-05 05:19:26Z qiping $
 *
 */
class component_6_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		$ret = DR('components/hotTopic.get', 'g/300', $mod['param']);
		if($ret['errno'] != 0){
			//$this->_error('components/hotTopic.get 返回API失败：'. $ret['err']. '('. $ret['errno']. ')');
			return ;
		}elseif(!is_array($ret['rst'])){
			$this->_error('components/hotTopic.get 返回错误的非数组类型数据。');
			return;
	 	}elseif(empty($ret['rst'])){
			//$this->_error('components/hotTopic.get 无数据。');
			return;
	 	}
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'rs' => $ret['rst']));
		
	}
	
}
