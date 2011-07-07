<?php
/**************************************************
*  Created:  2010-10-27
*
*  文件说明
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class userCom {

	/*
	 * 插入或更新一条用户登录数据
     * @param array() $data		用户数据数组
	 * @param int $id		sina_uid
     * @return boolean
	 */
	function insertUser($data, $id = '') {
		if(!is_array($data)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}
		
		$this->_cleanCache();
		$db = APP :: ADP('db');
		$db->setTable(T_USERS);
		$rs = $db->save($data, $id, '', 'sina_uid');
		
		return RST($rs);
	}

	/*
	* 根据用户名称获取用户数据
    * @param string $nickname
    * @param int $offset
    * @param int $each
    * @return array()
	*/
	function getByName($nickname, $offset = 0, $each = 0) {
		if (!is_numeric($offset) || !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($nickname);

		$where = $limit = "";
		if($keyword) {
			$where = ' WHERE `nickname` LIKE "%' . $keyword . '%" ';
		}

		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `first_login` DESC ' . $limit;
		return RST($db->query($sql));
	}

	/**
	* 根据sina_uid称获取用户数据
    * @param int $sina_uid
    * @return array()
	*/
	function getByUid($sina_uid) {
		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
	
		$db = APP :: ADP('db');
		$sina_uid = $db->escape($sina_uid);

		$where = " WHERE `sina_uid` = '" . $sina_uid . "'"; 

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `sina_uid` DESC ';
		return RST($db->getRow($sql));
	}

	/**
	* 根据附属站 uid称获取用户数据
    * @param int $sina_uid
    * @return array()
	*/
	function getBySiteUid($site_uid) {
		if (!is_numeric($site_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
	
		$db = APP :: ADP('db');
		$site_uid = $db->escape($site_uid);

		$where = " WHERE `uid` = '" . $site_uid . "'";

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USERS. $where . ' ORDER BY `sina_uid` DESC ';
		return RST($db->getRow($sql));
	}
	
 	/**
	* 获取所有的用户加V用户
    * @param int $offset
    * @param int $each
    * @return boolean
	*/
	function getAllVerify($offset = 0, $each = 0) {
		if (!is_numeric($offset) || !is_numeric($each)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}
                                
		$db = APP :: ADP('db');

		$limit = "";
		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}
		
		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_VERIFY. ' ORDER BY `id` ' . $limit;
		return RST($db->query($sql));
	}
	
	/**
	 * 得到一key/value对应的认证用户列表,其中key为sina_uid,value为用户昵称
	 * @return array
	 */
	function getVerify() {
		$db = APP::ADP('db');
		$sql = 'SELECT * FROM ' . $db->getTable(T_USER_VERIFY);
		$rst = $db->query($sql);
		if ($rst === false) {
			return RST(false);
		}
		$data = array();
		for ($i=0,$count=count($rst); $i<$count; $i++) {
			$data[(string)$rst[$i]['sina_uid']] = $rst[$i]['nick'];
		}
		return RST($data);
	}

	/**
	* 根据用户id获取被禁封用户
    * @param int $sina_uid
    * @return array
	*/
	function getUseBanById($sina_uid) {
		if(empty($sina_uid)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN . ' WHERE `sina_uid` = "' . $sina_uid . '"  ORDER BY `sina_uid` DESC';
		return RST($db->getRow($sql));
	}

	/**
	* 根据用户昵称获取被禁封用户
    * @param string $name
    * @return array
	*/
	function getUseBanByName($name, $offset = 0, $each = 0) {
		$where = '';
		$db = APP :: ADP('db');
		$name = $db->escape($name);
		if($name) {
			$where = ' WHERE `nick` like "%' . $name . '%"';
		}

		$limit = "";
		if($each) {
			$limit =  ' LIMIT ' . $offset . ',' . $each;
		}

		$db = APP :: ADP('db');

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN . $where . ' ORDER BY `ban_time` DESC ' . $limit;
		return RST($db->query($sql));
	}

	/**
	* 根据用户id获取用户是否加V
    * @param int $sina_uid
    * @return boolean
	*/
	function getVerifyById($sina_uid) {
		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($sina_uid);

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_VERIFY. ' WHERE `sina_uid` = "' . $keyword . '" ORDER BY `sina_uid` DESC ';
		if($db->getOne($sql)) {
			return RST(true);
		}else{
            return RST(false);
		}
	}

    /*
     * 存储用户加v
     * @param int $id
     * @param array $data
     * @return boolean
     */
	function saveVerify($data, $id = '') {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_VERIFY);
		$this->_cleanCache();
		$db->save($data, $id = '');
		return RST(true);
	}

    /*
     * 删除用户加v
     * @param int $id
     * @return boolean
     */
	function delVerify($id) {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_VERIFY);
		$this->_cleanCache();
		return RST($db->delete($id, '', 'sina_uid'));
	}

	/**
	* 根据sina_uid获取用户是否为封禁用户
    * @param int $sina_uid
    * @return boolean
	*/
	function getBanByUid($sina_uid) {
		if(empty($sina_uid)) {
			return RST(false, $errno=1210000, $err='Parameter can not be empty');
		}

		if (!is_numeric($sina_uid)) {
			return RST(false, $errno=1210002, $err='Parameter must be a number');
		}

		$db = APP :: ADP('db');
		$keyword = $db->escape($sina_uid);

		$sql = 'SELECT * FROM ' . $db->getPrefix() . T_USER_BAN. ' WHERE `sina_uid` = ' . $keyword . ' ORDER BY `sina_uid` DESC ';
		if($db->getOne($sql)) {
             return RST(true);
		}else{
             return RST(false);
		}
	}

    /*
     * 存储禁封用户
     * @param int $id
     * @param array $data
     * @return boolean
     */
	function saveBan($data, $id = '') {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_BAN);
		$this->_cleanCache();
        return RST($db->save($data, $id));
	}


    /*
     * 删除禁封用户
     * @param int $id
     * @return boolean
     */
	function delBan($id) {
		$db = APP :: ADP('db');
		$db->setTable(T_USER_BAN);
		$this->_cleanCache();
		return RST($db->delete($id, '', 'sina_uid'));
	}

	/*
	 * 清除缓存
	 */
	function _cleanCache() {
		DD('mgr/userCom.getByUid');
		DD('mgr/userCom.getByName');
		DD('mgr/userCom.getBySiteUid');
		DD('mgr/userCom.getAllVerify');
		DD('mgr/userCom.getVerify');
		DD('mgr/userCom.getUseBanById');
		DD('mgr/userCom.getUseBanByName');
		DD('mgr/userCom.getVerifyById');
		DD('mgr/userCom.getBanByUid');
	}
}
