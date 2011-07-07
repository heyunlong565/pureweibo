<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 随便看看模块
 * @author yaoying
 * @version $Id: component_9.pls.php 10966 2011-03-01 11:38:00Z yaoying $
 *
 */
class component_9_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		$ret = DR('components/pubTimeline.get', 'g/60', $mod['param']);
		if ($ret['errno']) {
			$this->_error('components/pubTimeline.get 错误：'. $ret['err']. '('. $ret['errno']. ')');
			return;
		}elseif(!is_array($ret['rst'])){
			$this->_error('components/pubTimeline.get返回错误的非数组类型数据！');
			return;
		//如果数据为空，则不输出
	 	}elseif(empty($ret['rst'])){
	 		$this->_error('components/pubTimeline.get没有数据');
	 		return;
	 	}
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'list' => $ret['rst']));
		return array('cls'=>'wblist', 'list' =>F('format_weibo',$ret['rst']) );
	}
	
	
}