<?php
/**************************************************
*  Created:  2010-06-08
*
*  框架配置文件
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

//----------------------------------------------------------------------
if (!defined('IS_DEBUG')){
   define('IS_DEBUG',			'1');	
}
/// 是否在系统初始化的时候执行 session_start();
define('IS_SESSION_START',		TRUE);
/// 是否启用日志 未启用时 写日志操作将被忽略
define('ENABLE_LOG',			TRUE);
/// 是否使用 CACHE 未启用时，缓存操作将被忽略
define('ENABLE_CACHE',			TRUE);
//----------------------------------------------------------------------
// 根据调试状态打开错误信息
if (defined('IS_DEBUG') && IS_DEBUG){
	if (version_compare(PHP_VERSION,'5.0','>=')){
		error_reporting(E_ALL &~ E_STRICT);	
	}else{
		error_reporting(E_ALL);	
	}
	
	@ini_set('display_errors', 1);
}else{
	error_reporting(0); //? E_ERROR | E_WARNING | E_PARSE
	@ini_set('display_errors', 0);
}
//----------------------------------------------------------------------
/// 标识是否在运用程序中的常量 可用于防止某文件被直接从URL调用
define('IN_APPLICATION','XMBLOG');
define('IS_IN_APPLICATION_CODE','if(!defined("IN_APPLICATION")) { exit("Access Denied"); }');
//----------------------------------------------------------------------
/// 应用程序目录
define('P_ROOT',		dirname(__FILE__));
/// function	扩展文件的存放目录
define('P_FUNCTION',	P_ROOT."/function");
/// class		扩展文件的存放目录
define('P_CLASS',		P_ROOT."/class");
/// 系统模块文件的存放目录
define('P_MODULES',		P_ROOT."/controllers");
/// 管理后台模块文件存放目录
define('P_ADMIN_MODULES', P_MODULES . '/mgr');
/// 系统模块文件的存放目录
define('P_COMS',		P_ROOT."/modules");

/// 系统皮肤文件的存放目录
define('P_CSS',			P_ROOT."/../css");
/// 系统语言文件的存放目录
define('P_LANG',		P_ROOT."/languages");
/// 系统适配器文件的存放目录
define('P_ADAPTER',		P_ROOT."/adapter");
/// 系统模板文件的存放目录
define('P_TEMPLATE',	P_ROOT."/../templates");
/// 存放可变数据的目录名
define('P_VAR_NAME',	'var');
/// 系统文件数据（上传数据，缓存数据，字体，LOG 等）的存放目录
define('P_VAR',			P_ROOT."/../". P_VAR_NAME);
/// 系统永久存储的数据目录
define('P_VAR_DATA',	P_VAR."/data");
/// 系统文件缓存的数据目录
define('P_VAR_CACHE',	P_VAR."/cache");
/// 系统上传文件的数据目录
define('P_VAR_UPLOAD',	P_VAR."/upload");

/// 锁文件存放目录
define('P_VAR_LOCK',	P_VAR . '/lock');
/// 用于组合URL 的 VAR 路径
define('P_URL_UPLOAD',	P_VAR_NAME . "/upload" );

/// 
//----------------------------------------------------------------------
/// 适配器文件扩展名
define('EXT_ADAPTER',		".adp.php");
/// 扩展函数文件扩展名
define('EXT_FUNCTION',		".func.php");
/// 扩展类文件扩展名
define('EXT_CLASS',			".class.php");
/// 系统模块文件扩展名
define('EXT_MODULES',		".mod.php");
/// 系统语言文件扩展名
define('EXT_LANG',			".lang.php");
/// 系统模板文件扩展名
define('EXT_TPL',			".tpl.php");
/// 数据组件文件扩展名
define('EXT_COM',			".com.php");
//----------------------------------------------------------------------
/**
系统路由方式选项，目前可选 0,1,2,3 ;  默认为 0
各个入口的路由方式可以自定义
0 表示	从 $_GET[R_GET_VAR_NAME] 中分析模块路由信息
1 表示	从 $_SERVER['PATH_INFO'] 中分析模块路由信息 显式的
2 表示	从 $_SERVER['PATH_INFO'] 中分析模块路由信息 隐式的，需REWRITE配合
3 表示	混合模式，同时支持 0 与 2 模式
*/
//if ( !defined('R_MODE') ) {define('R_MODE',3);} //移到　初始化中根据系统配置定义
/// 模块路由的变量名 , 当 R_MODE 为 0 时 可用
define('R_GET_VAR_NAME',		"m");
/// 系统默认的模块方法
define('R_DEF_MOD_FUNC',		"default_action");
//----------------------------------------------------------------------
/// 约定的适配器初始化接口方法
define('ADP_INIT_FUNC',			"adp_init");
/// 前置模块HOOK 前缀 ， ACTION_BEFORE_PREFIX+模块方法名 命名的成员方法 将在模块执行前 预先被执行
define('ACTION_BEFORE_PREFIX',	"_before_");
/// 后置模块HOOK 前缀 ， ACTION_AFTER_PREFIX+模块方法名 命名的成员方法 将在模块执行完成后被执行
define('ACTION_AFTER_PREFIX',	"_after_");
/// 是否启用页面 hook
define('ENABLE_PAGE_HOOK',		TRUE);
/// 是否启用模块 Action hook
define('ENABLE_ACTION_HOOK',	TRUE);

//----------------------------------------------------------------------
/// 用于存储全局数据的变量名
define('V_GLOBAL_NAME',			"__GG");
/// 用于存储用户配置的全局变量名
define('V_CFG_GLOBAL_NAME',		"cfg");
/// 判断当前请求是否是 API 请求的变量理由; AJAX请求同样被认为是API请求
define('V_API_REQUEST_ROUTE',	"R:api_sign");
/// 判断当前请求是否是 JS 请求的变量理由; 通常 AJAX请求同样被认为是API请求
define('V_JS_REQUEST_ROUTE',	"R:_");

/// 与FLASH同步会话时 FLASH 传递 PHPSESSID 使用的变量路由
define('V_FLASH_PHPSESSID',		'p:_PHPSESSID');

/// 入口名称常量 名
define('ENTRY_CONST_NAME',		'ENTRY_SCRIPT_NAME');
/// 缓存组的KEY前缀
define('GROUP_CACHE_KEY_PRE',	'gCacheKey_');
/// 数据组件的缓存KEY前缀
define('COM_CACHE_KEY_PRE',		'comCache_');
/// 使用XWEIBO写的 cookie 前缀
define('COOKIE_NAME_PRE',		'XWB_');

/// 存储OAUTH 未授权信息的 SESSION 变量名
define('WB_OAUTH_KEYS1',	'XWB_OAUTH_NO_CONFIRM');
/// 存储OAUTH 已授权信息的 SESSION 变量名
define('WB_OAUTH_KEYS2',	'XWB_OAUTH_CONFIRM');
/// 存储用户会话数据的 SESSION 变量名
define('WB_CLIENT_SESSION',	'XWB_CLIENT_SESSION');
/// 存储管理员会话数据的 SESSION 变量名
define('WB_ADMIN_SESSION',	'XWB_ADMIN_SESSION');
//----------------------------------------------------------------------

//----------------------------------------------------------------------
?>
