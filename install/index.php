<?php
/**
 * @file			index.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-07-08
 * @Modified By:	heli/2010-11-15
 * @Brief			Xweibo安装程序
 */


@ini_set('display_errors', 1);
error_reporting(E_ALL);
@ini_set('magic_quotes_runtime', 'Off');
define('XWEIBO_ACCESS', true);

define('ROOT_PATH', dirname(__FILE__).'/../');
define('XWEIBO_VERSION', '2.0');
define('XWEIBO_DB_PREFIX', 'xwb20_');
define('XWEIBO_SCRPIT_DB_PREFIX', 'xwb_');
define('XWEIBO_PROJECT', 'xwb');
define('XWEIBO_MAX_UPLOAD_FILE_SIZE',	'2');
define('XWEIBO_CHARSET','utf-8');
define('XWEIBO_DB_CHARSET','utf8');
define('XWEIBO_DB_STRUCTURE_FILE_NAME', 'structure.2.0.sql');
// 反馈上报接口地址
define('XWEIBO_FEEDBACK_URL', 'http://admin_dev.x.weibo.com/xapi.php');
include_once ROOT_PATH.'/user_config.php';
include_once ROOT_PATH.'/install/libs/func.php';

$install_lang = 'zh_cn';
include_once ROOT_PATH.'/install/lang/'.$install_lang.'.php';

if (file_exists(ROOT_PATH.'/var/data/install.lock')) {
	show_msg($_LANG['xwb_installed'], '2');
}

$step = empty($_REQUEST['step']) ? 0 : $_REQUEST['step'];
$allow_action = array('license', 'check', 'setConfig', 'setApp', 'setDb', 'create', 'db_exists', 'done');

$method = empty($_GET['method']) ? $allow_action[$step] : $_GET['method'];

switch ($method) {
	case 'license':
		include_once ('templates/index.php');
		break;
	case 'check':
		$disabled = true;

		$env_vars = check_env($disabled);

		$dir_file_vars = check_dir($disabled);

		$func_vars = check_func($disabled);

		include_once ('templates/step-1.php');
		break;
	case 'setApp':
		if (!get_db_cookie()) {
			show_msg($_LANG['not_allow_step_ship']);
		}
		include_once ('templates/step-2.php');
		break;
	case 'check_app':
		if (!get_db_cookie()) {
			show_msg($_LANG['not_allow_step_ship']);
		}
		$site_name = isset($_POST['site_name']) ? trim($_POST['site_name']) : null;
		$site_info = isset($_POST['site_info']) ? trim($_POST['site_info']) : null;
		$app_key = isset($_POST['app_key']) ? trim($_POST['app_key']) : null;
		$app_secret = isset($_POST['app_secret']) ? trim($_POST['app_secret']) : null;

		$config = array('WB_USER_SITENAME' => $site_name,
						'WB_USER_SITEINFO' => $site_info,
						'WB_AKEY' => $app_key,
						'WB_SKEY' => $app_secret
						);

		if (empty($app_key) || empty($app_secret)) {
			show_msg($_LANG['app_key_empty']);
		}

		$http = false;
		if (check_app($app_key, $app_secret, $http)) {
			if ((WB_AKEY && WB_AKEY  != $app_key) || (WB_SKEY && WB_SKEY != $app_secret)) {
				$config = array_merge($config, array('XWB_INSTALL_COVER' => 2));
			}
			// 向服务器上报反馈信息，以便发现问题
			
			$app_key = $app_key;
			$router = 'install';
			$data = json_encode($config);
			$time = time();

			$data = array(
					'K' => $app_key,
					'A' => $router,
					'P' => $data,
					'T' => $time,
					'F' => md5(sprintf('#%s#%s#%s#%s#%s#', $app_key, $router, $data, $time, $app_secret))
					);
			$http->setUrl(XWEIBO_FEEDBACK_URL);
			$http->setData($data);
			$http->request('post');

			/// 保存到user_config
			set_userConfig($config);
			header('Location: ./index.php?method=create');
			exit;
		} else {
			include_once ('templates/step-2.php');
		}
		break;
	case 'setConfig':
		if (MC_HOST) {
			$cache = 1;
			$mc_host_array = explode(':', MC_HOST);
			$mc_host = $mc_host_array[0];
			$mc_port = $mc_host_array[1];
		}
		include_once ('templates/step-3.php');
		break;
	case 'setDb':
		if (!function_exists('mysql_connect')) {
			show_msg($_LANG['mysql_connect']);
		}
		$db_host = isset($_POST['db_host']) ? trim($_POST['db_host']) : null;
		$db_user = isset($_POST['db_user']) ? trim($_POST['db_user']) : null;
		$db_passwd = isset($_POST['db_passwd']) ? trim($_POST['db_passwd']) : null;
		$db_name = isset($_POST['db_name']) ? trim($_POST['db_name']) : null;
		$db_prefix = isset($_POST['db_prefix']) ? trim($_POST['db_prefix']) : null; 
		$db_prefix = empty($db_prefix) ? XWEIBO_DB_PREFIX : (strpos($db_prefix, '_') === false ? $db_prefix.'_' : $db_prefix);
		$cover = isset($_POST['cover']) ? trim($_POST['cover']) : 1;
		$cache = isset($_POST['cache']) ? trim($_POST['cache']) : null;
		$mc_host = isset($_POST['mc_host']) ? trim($_POST['mc_host']) : null;
		$mc_port = isset($_POST['mc_port']) ? trim($_POST['mc_port']) : null;

		$error_msg = array();
		if (empty($db_host) || empty($db_name) || empty($db_user)) {
			$error_msg[] = $_LANG['database_info_empty'];
		}

		if ($cache == 1) {
			if (empty($mc_host) || empty($mc_port)) {
				$error_msg[] = $_LANG['memcache_info_empty'];
			}
			check_mc_connect($mc_host, $mc_port);
		}

		if (!empty($error_msg)) {
			show_msg(implode(', ', $error_msg));
		}

		if (check_db_connect($db_host, $db_user, $db_passwd)) {

			$config = array('DB_HOST' => $db_host,
				'DB_USER' => $db_user,
				'DB_PASSWD' => $db_passwd,
				'DB_NAME' => $db_name,
				'DB_PREFIX' => $db_prefix,
				'XWB_INSTALL_COVER' => $cover);
			if ($cache == 1) {
				$config = array_merge($config, array('MC_HOST' => $mc_host.':'.$mc_port));
			}
			set_userConfig($config);
			set_db_cookie($db_host, $db_user, $db_passwd);
			header('Location: ./index.php?step=3');
		}
		break;
	case 'backup':
		set_time_limit(0);
		backup_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		echo 'finish';
		break;
	case 'db_exists':
		$db_host = trim($_POST['db_host']);
		$db_user = trim($_POST['db_user']);
		$db_passwd = trim($_POST['db_passwd']);
		$db_name = trim($_POST['db_name']);
		$ret = db_exists($db_host, $db_user, $db_passwd, $db_name);
		die($ret);
		break;
	case 'create':
		if (!function_exists('mysql_connect')) {
			show_msg($_LANG['mysql_connect']);
		}
		$db_host = DB_HOST; 
		$db_user = DB_USER; 
		$db_passwd = DB_PASSWD;
		$db_name = DB_NAME; 
		$db_prefix = DB_PREFIX; 
		$db_prefix = empty($db_prefix) ? XWEIBO_DB_PREFIX : (strpos($db_prefix, '_') === false ? $db_prefix.'_' : $db_prefix);

		if (!get_db_cookie($db_host, $db_user, $db_passwd)) {
			show_msg($_LANG['not_allow_step_ship']);
		}

		$cover = XWB_INSTALL_COVER; 

		$ret = action_dbs($db_host, $db_user, $db_passwd, $db_name, $db_prefix, $cover);
		if ($ret === true) {
			header('Location: ./index.php?method=done');
			exit;
		}
		header('Location: ./index.php?step=4&method=view');
		exit;
		break;
	case 'view':
		if (!get_db_cookie()) {
			show_msg($_LANG['not_allow_step_ship']);
		}
		$table_list = get_tables_list();
		include_once ('templates/step-4.php');
		break;
	case 'done':
		if (!get_db_cookie()) {
			show_msg($_LANG['not_allow_step_ship']);
		}
		set_config_env();

		$paths = explode('/', $_SERVER['SCRIPT_NAME']);
		foreach ($paths as $var) {
			if ($var == 'install' || $var == 'uninstall' || strpos($var, '.php')) {
				continue;
			}
			$urls[] = $var;
		}
		$string_path = implode('/', $urls);
		//修改css文件
		modifly_css_file($string_path);

		$index_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path;
		$admin_url = 'http://'.$_SERVER['HTTP_HOST'].$string_path.'/admin.php?m=mgr/active_admin.active&app_key='.urlencode(WB_AKEY).'&app_secret='.urlencode(WB_SKEY);
		include_once ('templates/finish.php');
		break;
		default:
			include_once ('templates/index.php');
}
?>
