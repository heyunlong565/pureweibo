<?php
/**
 * @file			index.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-12-3
 * @Modified By 	Yang.Zhang/2010-12-3
 * @Brief			Description
 */
 
error_reporting(E_ALL);

define('ROOT_PATH', dirname(__FILE__).'/../');

include_once ROOT_PATH.'/sae_install/libs/func.php';

define('SAE_DOMAIN', 'xweibo');
define('CONFIG_DOMAIN',     'config');



define('XWEIBO_VERSION', '1.1.0');
define('XWEIBO_DB_PREFIX', 'xwb11_');
define('XWEIBO_SCRPIT_DB_PREFIX', 'xwb_');
define('XWEIBO_PROJECT', 'xwb');
define('XWEIBO_MAX_UPLOAD_FILE_SIZE',	'2');
define('XWEIBO_CHARSET','utf-8');
define('XWEIBO_DB_CHARSET','utf8');

$install_lang = 'zh_cn';
include_once ROOT_PATH.'/sae_install/lang/'.$install_lang.'.php';

$step = empty($_REQUEST['step']) ? 0 : $_REQUEST['step'];
$allow_action = array('license',  'setApp', 'setConfig', 'create', 'db_exists', 'done');
$method = empty($_GET['method']) ? $allow_action[$step] : $_GET['method'];

if(!checkDB()){
	show_msg('请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE MySQL</a>管理页面初始化mysql!');
	exit;
}
if(!checkDomain()){
	show_msg('请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE Domain</a>管理页面删除创建为"'.SAE_DOMAIN.'"的domian!');
	exit;
}

if(checkInstall()){
	show_msg('安装程序已经安装,如果需要重新安装,请在<a href="http://sae.sina.com.cn/?m=myapp" target="_blank">SAE Domain</a>管理页面删除"'.SAE_DOMAIN.'"!');
	exit;
}

switch ($method){
	case 'license'://文档文件
		include_once ('templates/index.php');
		break;
	case 'setApp':
		include_once ('templates/step-1.php');
		break;
	case 'check_app':
		$site_name = trim($_POST['site_name']);
		$site_info = trim($_POST['site_info']);
		$app_key = trim($_POST['app_key']);
		$app_secret = trim($_POST['app_secret']);

		$config = array('site_name' => $site_name,
						'site_info' => $site_info,
						'app_key' => $app_key,
						'app_secret' => $app_secret
						);
		
		if (empty($app_key) || empty($app_secret)) {
			show_msg($_LANG['app_key_empty']);
		}
		set_ini_file($config);
		if (check_app($app_key, $app_secret)) {
			header('Location: ./index.php?step=2');
			exit;
		} else {
			include_once ('templates/step-1.php');
		}
		break;
	case 'setConfig':
		$site_config = get_ini_file();
		@extract($site_config);
		include_once ('templates/step-2.php');
		break;
	case 'create':
		if (!function_exists('mysql_connect')) {
			show_msg($_LANG['mysql_connect']);
		}
		$cache = isset($_POST['cache']) ? $_POST['cache'] : 0;
		$cover = isset($_POST['cover']) ? trim($_POST['cover']) : 1;
		
		

		$config = array('cache' => $cache);
		set_ini_file($config);
		
		$site_config = get_ini_file();
		@extract($site_config);
		
		$ret = action_dbs($db_host, $db_user, $db_passwd, $db_name, $db_prefix, $cover);
		header('Location: ./index.php?step=3&method=view');
		exit;
		break;
	case 'view':
		$table_list = get_tables_list();
		
		$site_config = get_ini_file();
		@extract($site_config);
		
		include_once ('templates/step-3.php');
		break;
	case 'done':
		$finish = '1';
		$config = array('finish' => $finish);
		set_ini_file($config);
		
		$site_config = get_ini_file();
		@extract($site_config);
		
		$paths = explode('/', $_SERVER['SCRIPT_NAME']);
		foreach ($paths as $var) {
			if ($var == 'sae_install' || $var == 'uninstall' || strpos($var, '.')) {
				continue;
			}
			$urls[] = $var;
		}
		$string_path = implode('/', $urls);
		$index_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path;
		$admin_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path.'/admin.php?m=mgr/active_admin.active&app_key='.urlencode($app_key).'&app_secret='.urlencode($app_secret);


		include_once ('templates/finish.php');
		break;
	default:
		include_once ('templates/index.php');
		break;
		
}