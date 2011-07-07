<?php
/**************************************************
*  Created:  2010-06-08
*
*  框架初始化文件
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
require_once dirname(__FILE__).'/../user_config.php';
require_once 'cfg.php';
require_once dirname(__FILE__).'/../config.php';
require_once 'compat.php';
require_once 'core.php';
//----------------------------------------------------------------------
/// 初始化全局数据
$GLOBALS[V_GLOBAL_NAME] = array();
$GLOBALS[V_GLOBAL_NAME]['TPL'] 	= array();
$GLOBALS[V_GLOBAL_NAME]['LANG'] = array();
$GLOBALS[V_GLOBAL_NAME]['STATIC_STORE'] = array();

/// 初始化可通过 V('-:****'); 访问的部分变量
$GLOBALS[V_CFG_GLOBAL_NAME]['userConfig']	= array();
$GLOBALS[V_CFG_GLOBAL_NAME]['sysConfig']	= array();
$GLOBALS[V_CFG_GLOBAL_NAME]['session']		= array();
$GLOBALS[V_CFG_GLOBAL_NAME]['siteInfo']		= array('site_name'=>'Nosite', 'site_uid'=>'','site_uname'=>'','reg_url'=>'', 'login_url'=>'');
//----------------------------------------------------------------------
/// 与　FLASH　同步会话,让 FLASH 传递 PHPSESSID
if (defined('V_FLASH_PHPSESSID') && V(V_FLASH_PHPSESSID,false) ){
	session_id(V(V_FLASH_PHPSESSID));
}
//----------------------------------------------------------------------
if (defined('IS_SESSION_START') && IS_SESSION_START ){
	session_start();
}
//----------------------------------------------------------------------

//----------------------------------------------------------------------
