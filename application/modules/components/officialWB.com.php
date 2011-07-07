<?php
/**
* 官方微博 获取设定的官方用户的微博
*
* @version $1.1: officialWB.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

class officialWB extends PageModule{

	var $component_id = 5;

	function officialWB() {
		parent :: PageModule();
	}

	/**
	 * 获取listid
	 *
	 */
	function getListId() {
		$cfg = $this->configList();

		if (empty($cfg['list_id'])) {
			DR('xweibo/xwb.setToken', '', 2);
			//不存在，创建list
			$rs = DR('xweibo/xwb.createUserLists', null, SYSTEM_SINA_UID, '官方微博'.time('Ymd'));

			if ($rs['errno'] == 0) { //创建成功
				$this->config('list_id', $rs['rst']['id']);
				$this->clearCfgCache();

				DR('xweibo/xwb.setToken', '', 1);

				return $rs['rst']['id'];

			} else { //失败

				return false;
			}

		} else {
			return $cfg['list_id'];
		}
	}

	/**
	 * 获取list内的所有用户
	 *
	 */
	function getUsers() {
		return DR('xweibo/xwb.getUserListsMember', null, SYSTEM_SINA_UID, $this->getListId());
	}

	/**
	 * 将用户添加到官方列表
	 *
	 */
	function addUser($uid) {
		DR('xweibo/xwb.setToken', '', 2);

		$rs = DR('xweibo/xwb.createUserListsMember', null, SYSTEM_SINA_UID, $this->getListId(), $uid);

		//清除缓存
		if ($rs['errno'] == 0) DD('components/officialWB.getUsers');

		return $rs;
	}

	/**
	 * 删除组内用户
	 * 
	 * @param $uid int 要删除的用户ID
	 *
	 */
	function delUser($uid) {
		DR('xweibo/xwb.setToken', '', 2);

		$rs = DR('xweibo/xwb.deleteUserListsMember', null, SYSTEM_SINA_UID, $this->getListId(), $uid);

		DR('xweibo/xwb.setToken', '', 1);

		return $rs;
	}


	/**
	 * 获取list内用户最新的N条微博
	 *
	 */
	function get($num = null) {
		if (!$num) {
			$cfg = $this->configList();
			$num = $cfg['show_num'];
		}

		$rs = DR('xweibo/xwb.getUserListIdStatuses', null, SYSTEM_SINA_UID, $this->getListId(), $num, 1);

		//成功返回
		if ($rs['errno'] == 0) {
			//如果返回的条数大于指定条数，切减
			$rst = &$rs['rst'];

			if (count($rst) > $num) {
				$rs['rst'] = array_slice($rst, 0, $num);
			}
			
		}

		return $rs;
	}
}