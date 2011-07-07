<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 人气关注榜模块
 * @author yaoying
 * @version $Id: component_4.pls.php 11437 2011-03-11 08:55:21Z yaoying $
 *
 */
class component_4_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		$rs = DS('components/concern.get', 300);
		if (empty($rs) || !is_array($rs)) {
			$this->_error('components/concern.get 从数据库获取错误：数据为空或者返回错误的非数组数据。');
			return;
	 	}
	 	TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod, 'rs' => $rs));
	}
	
}