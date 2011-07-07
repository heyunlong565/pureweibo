<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 热门转发和热门评论模块
 * @author yaoying
 * @version $Id: component_1.pls.php 10863 2011-02-28 07:11:07Z yaoying $
 *
 */
class component_1_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod));
	}
	
}