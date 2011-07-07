<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 话题微博模块
 * @author yaoying
 * @version $Id: component_12.pls.php 11504 2011-03-14 04:02:53Z yaoying $
 *
 */
class component_12_pls extends component_abstract_pls{
	
	function run($mod){
		$mod['param']['page_type'] = isset($mod['param']['page_type']) && ($mod['param']['page_type'] != 0) ? 1 : 0;
		$mod['param']['page'] = ($mod['param']['page_type'] == 1) ? (int)V('g:page', 1) : 1;
		$mod['param']['source']	  = isset($mod['param']['source']) ? $mod['param']['source'] : 0;
		$mod['param']['show_num'] = isset($mod['param']['show_num']) 	? (int)$mod['param']['show_num'] : 15;
		
		parent::run($mod);
		
		$rs = DR('components/todayTopic.getTopicWB', 'g/300', $mod['param']);
		if ($rs['errno']) {
			$this->_error('components/todayTopic.getTopicWB 返回API错误：'. $rs['err']. '('. $rs['errno']. ')');
			return;
	 	}elseif(!is_array($rs['rst']) || empty($rs['rst'])){
			$this->_error('components/todayTopic.getTopicWB 返回错误的非数组数据类型或者返回数据为空');
			return;
	 	}
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'rs' => $rs));
		return array('cls'=>'wblist', 'list' =>F('format_weibo',$rs['rst']) );
	}
	
	
}