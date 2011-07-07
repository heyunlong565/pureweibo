<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 活动列表模块
 * @author yaoying
 * @version $Id: component_17.pls.php 10863 2011-02-28 07:11:07Z yaoying $
 *
 */
class component_18_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		$type=$mod['param']['event_list_type'];
		$showNum=$mod['param']['show_num'];
		if($type==1){
			$events = DS('events.eventSearch', 'g0/1800', '', 8, '', false, 0, $showNum);
			//$events = DS('events.eventSearch', '','', 1, '', false, 0, $showNum);	
		}
		elseif($type==2){
			//$events = DS('events.eventSearch', '','', '', '', false, 0, $showNum);
			$events = DS('events.eventSearch', 'g0/1800','', 1, '', false, 0, $showNum);
			
		}
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod,'events'=>$events));
	}
	
}