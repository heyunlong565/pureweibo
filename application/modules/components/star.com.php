<?php
/**
* 名人推荐（明星）
*
* @version $1.1: star.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class star extends PageModule{

	var $component_id = 2;

	function star() {
		parent :: PageModule();
	}

	/*
	 * 获取名人列表
	 */
	function get($num = 6) {
		$cfg = $this->configList();

		$db = $this->db;

		$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERS) . ' where group_id=' . (int)$cfg['group_id'] . ' order by sort_num asc limit ' . (int)$cfg['show_num']);

		return RST($rs);
	}
}