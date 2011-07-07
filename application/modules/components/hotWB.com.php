<?php
/**
* 热门微博排行（热门转发、热门评论）
*
* @version $1.1: hotWB.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

require_once P_COMS . '/PageModule.com.php';

class hotWB extends PageModule{

	var $component_id = COMID_HOTWB;

	function hotWB() {
		parent :: PageModule();
	}


	/*
	 * 获取指定条数的热门微博
	 *
	 */
	function getRepost() {
		$cfg = $this->configList();

		$num = $cfg['show_num'];

		$fw = DR('xweibo/xwb.getHotRepostDaily', null, $num);


		return $fw;
	}

	function getComment() {
		$cfg = $this->configList();

		$num = $cfg['show_num'];

		$list = DR('xweibo/xwb.getHotCommentsDaily', null, $num);

		return $list;
	}
}