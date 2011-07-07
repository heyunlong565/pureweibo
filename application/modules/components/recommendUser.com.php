<?php
/**
* 推荐用户
*
* @version $1.1: concern.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class recommendUser extends PageModule{

	var $component_id = 3;

	function recommendUser() {
		parent :: PageModule();
	}

	/*
	 * 查询可选的用户组
	 *
	 */
	function getUserGroups() {
		$db = $this->db;
		$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERGROUPS) . ' order by group_id asc');

		return RST($rs);
	}

	/*
	 * 获取推荐用户列表
	 *
	 */
	function get() {
		$cfg = $this->configList();
		
		$list = DR('mgr/userRecommendCom.getUserById', '', (int)$cfg['group_id']);

		$show_num = isset($cfg['show_num']) ? $cfg['show_num'] : 0;

		if ($list['errno'] == 0) {
			if ($show_num && count($list['rst']) > $show_num) {
				$list['rst'] = array_slice($list['rst'], 0, $show_num);
			}
		}
		
		return $list;
		//$db = $this->db;

		//$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_USERS) . ' where group_id=' . (int)$cfg['group_id'] . ' order by sort_num desc limit ' . $cfg['show_num']);

		//return RST($rs);
	}
}