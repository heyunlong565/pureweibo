<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 专题banner模块
 * @author yaoying
 * @version $Id: component_13.pls.php 10890 2011-02-28 11:06:34Z yaoying $
 *
 */
class component_13_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		if(!isset($mod['param']['src']) || empty($mod['param']['src'])){
			$this->_error('无图片');
			return ;
		}
		
		if(!isset($mod['param']['link']) || empty($mod['param']['link']) || $mod['param']['link'] == 'http://'){
			unset($mod['param']['link']);
		}
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod));
		
	}
	
	
}