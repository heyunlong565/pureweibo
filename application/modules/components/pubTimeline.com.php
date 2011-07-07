<?php
/**
* 随便看看
*
* @version $1.1: pubTimeline.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class pubTimeline extends PageModule{

	var $component_id = 9;

	function pubTimeline() {
		parent :: PageModule();
	}

	function get() {
	
		$cfg = $this->configList();
		
		$num = $cfg['show_num'];

		$list = DR('xweibo/xwb.getPublicTimeline', '', null, false);

		return RST($this->random($list['rst'], $num), $list['errno'], $list['err']);
	}
}