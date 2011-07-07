<?php
/**
 * @file			func.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-12-4
 * @Modified By 	Yang.Zhang/2010-12-4
 * @Brief			Description
 */

/**
 * 
 * 设置配置数据
 * @param unknown_type $config
 * @return
 */
function set_ini_file($config)
{
	extract($config);
	
	$app_config = get_ini_file();
	
	$site_name = isset($site_name) ? $site_name : $app_config['site_name'];
	$site_info = isset($site_info) ? $site_info : $app_config['site_info'];
	$app_key = isset($app_key) ? $app_key : $app_config['app_key'];
	$app_secret = isset($app_secret) ? $app_secret : $app_config['app_secret'];
	$cache = isset($cache) ? $cache : null;
	$finish = isset($finish)?$finish : '0';
	$root_path = ROOT_PATH;
	
	$db_port = $_SERVER['HTTP_MYSQLPORT'];
	$db_host = $db_port.'.mysql.sae.sina.com.cn';
	$db_name = 'app_'.$_SERVER['HTTP_APPNAME'];
	$db_passwd = SAE_SECRETKEY;
	$db_user = SAE_ACCESSKEY;
	$db_prefix = 'xwb11_';
	
	/// 生成安装目录
	$local_uri = '';
	if (isset($_SERVER['REQUEST_URI'])){
		$local_uri = $_SERVER['REQUEST_URI'];
	}
	if (empty($local_uri) && isset($_SERVER['PHP_SELF']) ){
		$local_uri = $_SERVER['PHP_SELF'];
	}
	if (empty($local_uri) && isset($_SERVER['SCRIPT_NAME']) ){
		$local_uri = $_SERVER['SCRIPT_NAME'];
	}
	if (empty($local_uri) && isset($_SERVER['ORIG_PATH_INFO']) ){
		$local_uri = $_SERVER['ORIG_PATH_INFO'];
	}
	if (empty($local_uri)){
		//todo　获取不了　可供计算URI的　路径　错误显示
	}

	$uri_array = explode('/', $local_uri);
	$paths = array();
	foreach ($uri_array as $var) {
		if ($var == 'sae_install' || $var == 'uninstall' || strpos($var, '.')) {
			break;
		}
		$paths[] = $var;
	}
	$path_string = implode('/', $paths);
	$path_string = empty($path_string) ? '/' : $path_string.'/';
	
	//echo $path_string;
	$config_file = 'site_name='.urlencode($site_name)
				  .'&path=' . $path_string
				  .'&site_info='.urlencode($site_info)
				  .'&app_key='.urlencode($app_key)
				  .'&app_secret='.urlencode($app_secret)
				  .'&cache='.urlencode($cache)
				  .'&db_host='.urlencode($db_host)
				  .'&db_name='.urlencode($db_name)
				  .'&db_passwd='.urlencode($db_passwd)
				  .'&db_user='.urlencode($db_user)
				  .'&db_prefix='.urlencode($db_prefix)
				  .'&finish='.urlencode($finish);
	
	write_config(CONFIG_DOMAIN,$config_file);
	return true;
}


/**
 * 获取ip
 *
 * @return string
 */
function get_real_ip() {
	/// Gets the default ip sent by the user
	if (!empty($_SERVER['REMOTE_ADDR'])) {
		$direct_ip = $_SERVER['REMOTE_ADDR'];
	}
	/// Gets the proxy ip sent by the user
	$proxy_ip     = '';
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
		$proxy_ip = $_SERVER['HTTP_X_FORWARDED'];
	} else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
		$proxy_ip = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (!empty($_SERVER['HTTP_FORWARDED'])) {
		$proxy_ip = $_SERVER['HTTP_FORWARDED'];
	} else if (!empty($_SERVER['HTTP_VIA'])) {
		$proxy_ip = $_SERVER['HTTP_VIA'];
	} else if (!empty($_SERVER['HTTP_X_COMING_FROM'])) {
		$proxy_ip = $_SERVER['HTTP_X_COMING_FROM'];
	} else if (!empty($_SERVER['HTTP_COMING_FROM'])) {
		$proxy_ip = $_SERVER['HTTP_COMING_FROM'];
	}
	/// Returns the true IP if it has been found, else FALSE
	if (empty($proxy_ip)) {
		/// True IP without proxy
		return $direct_ip;
	} else {
		$is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
		if ($is_ip && (count($regs) > 0)) {
			/// True IP behind a proxy
			return $regs[0];
		} else {
			/// Can't define IP: there is a proxy but we don't have
			/// information about the true IP
			return $direct_ip;
		}
	}
}

/**
 * 
 * 保存用户设置数据
 * @param $key 保存的key
 * @return
 */
function read_config($key){
	$s = new SaeStorage();
	return $s->read(SAE_DOMAIN,md5($key));
}
/**
 * 
 * 读取用户数据
 * @param $key 保存的key
 * @param $value 要保存的数据
 * @return
 */
function write_config($key,$value){
	$s = new SaeStorage();
	$result = $s->write( SAE_DOMAIN , md5($key) , $value );
	if($result){
		return $result;
	}else{
		return false;
	}
}
/**
 * 
 * 获取配置文件
 * @return
 */
function get_ini_file(){
	$content = read_config(CONFIG_DOMAIN);
	$site_base_info = array();
	parse_str($content, $site_base_info);
	return $site_base_info;
}
/**
 * 检查app的真确性
 *
 * @param unknown_type
 * @return unknown
 */
function check_app($app_key, $app_secret)
{
	global $_LANG;
	
	include_once "oauth.class.php";
	include_once "saeproxy_http.php";

	$http = new saeproxy_http();
	$http -> adp_init();
	$url = 'http://api.t.sina.com.cn/oauth/request_token';
	$sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
	$consumer = new OAuthConsumer($app_key, $app_secret);
	$request = OAuthRequest::from_consumer_and_token($consumer, null, 'GET', $url, null);
	$request->sign_request($sha1_method, $consumer, null);
	$http_url = $request->to_url();
	$http->setUrl($http_url);
	$result = $http->request();
	$code = $http->getState();
	if ($code != '200') {
		/// 记录错误日志
		install_log('url: '.$http_url." \r\ncode: ".$code." \r\nret: ".$result);
		show_msg($_LANG['app_key_error']);
	}
	return true;
}
/**
 * 写错误日志
 *
 *
 */
function install_log($msg)
{
	show_msg($msg);
}
/**
 * 错误提示信息
 *
 * @param unknown_type
 * @return unknown
 */
function show_msg($msg, $type = 1)
{
	global $_LANG;
	include 'templates/error.php';
	exit;
}
/**
 * 创建数据库
 *
 * @param unknown_type
 * @return unknown
 */
function create_db($db_host, $db_user, $db_passwd, $db_name)
{
	global $_LANG, $xwb_isError;

	/// 注册错误处理方法
	//register_shutdown_function('error', $_LANG['database_exists_error']);

	$link = @mysql_connect($db_host.':'.$_SERVER['HTTP_MYSQLPORT'], $db_user, $db_passwd);

	$xwb_isError = 0;
	
	if (!$link) {
		/// 错误日志
		install_log("sql:  \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		show_msg($_LANG['database_connect_error']);
	}

    if (mysql_select_db($db_name, $link) === false)
    {
        $sql = "CREATE DATABASE $db_name DEFAULT CHARACTER SET " . XWEIBO_DB_CHARSET;
        if (mysql_query($sql, $link) === false)
        {
			$errno = mysql_errno($link);
			$error = mysql_error($link);
			/// 错误日志
			install_log('sql: '.$sql." \r\nerrno: ".$errno." \r\nerror: ".$error);
			if ($errno == 1064) {
				show_msg($_LANG['database_create_1064_error']);
			} elseif ($errno == 1044 || $errno == 1045) {
				show_msg($_LANG['database_create_1044_error']);
			} else {
				show_msg($_LANG['database_create_error']);
			}
        }
    }
    mysql_close($link);
}

/**
 * 创建数据库资源
 *
 * @param unknown_type
 * @return unknown
 */
function db_resource($db_host = null, $db_user = null, $db_passwd = null, $db_name = null, $ajax = false)
{
	global $_LANG;
	$link = @mysql_connect($db_host.':'.$_SERVER['HTTP_MYSQLPORT'], $db_user, $db_passwd);
	if (!$link) {
		/// 错误日志
		install_log("sql: \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		if ($ajax) {
			die($_LANG['database_connect_error']);
		}
		show_msg($_LANG['database_connect_error'], 'index.php?step=3');
	}
	if (!mysql_select_db($db_name, $link)) {
		if ($ajax) {
			return '-1';
			//die($_LANG['database_exists_error']);
		}
		show_msg($_LANG['database_exists_error']);
	}
	mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $link);
	return $link;
}


/**
 * 检查app key是否一样
 *
 * @param unknown_type
 * @return unknown
 */
function check_app_key($link, $db_name, $db_prefix = null)
{
	mysql_select_db($db_name, $link);
	mysql_query('SET NAMES '.XWEIBO_DB_CHARSET, $link);

	if ($db_prefix) {
		$table_name = $db_prefix.'sys_config';
	} else {
		$sql = "show tables like '%sys_config'";
		$result = mysql_query($sql, $link);
		$list = array();
		$table_name = false;
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if (empty($row[0])) {
				return '10000';
			}
			$sql = 'SELECT value FROM '.$row[0].' WHERE `key` = "wb_version"';
			$ret = mysql_query($sql, $link);
			$fields_rows = mysql_fetch_assoc($ret);
			if ($fields_rows) {
				$table_name = $row[0];
				break;
			}
			return '10000';
		}
	}
	if ($table_name) {
		$app_config = get_ini_file();
		$sql = 'SELECT * FROM '.$table_name;
		$ret = mysql_query($sql, $link);
		if (!$ret) {
			return '10000';
		}
		while($rows = mysql_fetch_assoc($ret)) {
			if ($rows['key'] == 'app_key') {
				$app_key = $rows['value'];
			}
			if ($rows['key'] == 'app_secret') {
				$app_secret = $rows['value'];
			}
		}
		if (!empty($app_key) && !empty($app_secret) && !empty($app_config['app_key']) && !empty($app_config['app_secret'])) {
			if ($app_key != $app_config['app_key'] || $app_secret != $app_config['app_secret']) {
				return '10001';
			}
		}
		set_ini_file($app_config);
	}

	return '10002';

	mysql_close();
}

/**
 * 创建表并且返回表的列表
 *
 * @param unknown_type
 * @return unknown
 */
function create_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix)
{
	global $_LANG;
	$fp = fopen(ROOT_PATH.'/sae_install/data/structure_1.1.sql', 'r');
	$sql_items = fread($fp, filesize(ROOT_PATH.'/sae_install/data/structure_1.1.sql'));
	fclose($fp);

	/// 删除SQL行注释
	$sql_items = preg_replace('/^\s*(?:--|#).*/m', '', $sql_items);
	/// 删除SQL块注释
	$sql_items = preg_replace('/^\s*\/\*.*?\*\//ms', '', $sql_items);
	/// 代替表前缀
	$keywords = 'CREATE\s+TABLE(?:\s+IF\s+NOT\s+EXISTS)?|'
			  . 'DROP\s+TABLE(?:\s+IF\s+EXISTS)?|'
			  . 'ALTER\s+TABLE|'
			  . 'UPDATE|'
			  . 'REPLACE\s+INTO|'
			  . 'DELETE\s+FROM|'
			  . 'INSERT\s+INTO|'
			  .	'LOCK\s+TABLES';
	$pattern = '/(' . $keywords . ')(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$pattern = '/(UPDATE.*?WHERE)(\s*)`?' . XWEIBO_SCRPIT_DB_PREFIX . '(\w+)`?(\s*\.)/i';
	$replacement = '\1\2`' . $db_prefix . '\3`\4';
	$sql_items = preg_replace($pattern, $replacement, $sql_items);

	$sql_items = str_replace("\r", '', $sql_items);
	$query_items = explode(";\n", $sql_items);

	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	$sign = true;
	
	foreach ($query_items as $var) {
		$var = trim($var);

		if (empty($var)) {
			continue;
		}

		$sign = mysql_query($var, $link);
		if (!$sign) {
			/// 错误日志
			install_log('sql: '.$var." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		}
	}


	mysql_close($link);
	if (!$sign) {
		show_msg($_LANG['tables_create_error']);
	}
}

/**
 * 罗列表列表
 *
 * @param unknown_type
 * @return unknown
 */
function get_tables_list()
{
	global $_LANG;
	$config_info = get_ini_file();
	@extract($config_info);

	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	/// 罗列表
	$sql = 'SHOW tables';
	$result = mysql_query($sql, $link);
	$list = array();
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		if (!preg_match("/$db_prefix.+/i", $row[0])) {
			continue;
		}
		$list[] = $row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return $list;

}
/**
 * 处理数据库和数据
 *
 * @param unknown_type
 * @return unknown
 */
function action_dbs($db_host, $db_user, $db_passwd, $db_name, $db_prefix, $cover, $admin_name = null, $admin_passwd = null)
{
	if (2 == $cover) {
		/// 覆盖安装
		create_db($db_host, $db_user, $db_passwd, $db_name);

		create_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix);

		init_site_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
	} else {
		/// 升级安装
		
		/// 检查数据库是否存在, appkey是否跟之前的一致
		$ret = db_exists($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		if ('10001' == $ret || '10000' == $ret) {
			$ver = '0';
		} else {
			/// 检查之前安装的版本号
			$ver = check_version($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		}

		if ('1' == $ver) {
			/// 相同版本
			return true;
		} else {
//			/// 先备份数据
//			$link = db_resource($db_host, $db_user, $db_passwd, $db_name, true);
//			$sql = 'SHOW tables';
//			$result = mysql_query($sql, $link);
//			$list = array();
//			$db_prefix = $db_prefix;
//			$tables = array();
//			$sql_dump = '';
//			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
//				if (!preg_match("/$db_prefix.+/i", $row[0])) {
//					continue;
//				}
//				$sql_dump .= backup_data_sql($link, $row[0]);
//				$tables[] = $row[0];
//			}
//			/// 生成备份数据表的sql文件
//			$file_name = 'sae_install_'.$db_name.'_data_backup.sql';
//			$fp = fopen(ROOT_PATH.'/var/data/'.$file_name, 'wb+');
//			if ($fp == false) {
//				die($_LANG['datadir_access']);
//			}
//			if (fwrite($fp, $sql_dump) === false) {
//				die($_LANG['xweibo_uninstall_backup_error']);
//			}
//			fclose($fp);

			/// 查询不到版本信息，就覆盖安装
			create_db($db_host, $db_user, $db_passwd, $db_name);

			create_tables($db_host, $db_user, $db_passwd, $db_name, $db_prefix);

			init_site_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix);
		} 
	}
}
/**
 * 备份数据表sql语句
 *
 * @param unknown_type
 * @return unknown
 */
function backup_data_sql($link, $table)
{
	$sql_dump = '';
	$sql = 'SELECT * FROM '.$table;
	$result = mysql_query($sql, $link);
	$field_key = array();
	$field_value = array();
	$field_value_string = array();
	while($row = mysql_fetch_assoc($result)) {
		if (empty($row)) {
			continue;
		}
		foreach ($row as $key => $var) {
			$field_key[$key] = "`".$key."`";
			$field_value[$key] = "'".mysql_real_escape_string($var)."'";
		}
		$field_value_string[] = '('.implode(', ', $field_value).')';
	}

	if (!empty($field_value_string)) {
		$sql_dump .= "INSERT INTO $table (".implode(', ', $field_key).")VALUES".implode(',', $field_value_string)."\r\n";
	}
	return $sql_dump;
}

/**
 * 初始化网站信息
 *
 * @param unknown_type
 * @return unknown
 */
function init_site_data($db_host, $db_user, $db_passwd, $db_name, $db_prefix = 'xwb_')
{
	global $_LANG;

	$site_config = get_ini_file();
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name);
	$table = $db_prefix.'sys_config';
	$sql = "INSERT INTO $table (`key`,`value`)VALUES('site_name','".mysql_real_escape_string($site_config['site_name'])."'),('wb_version','".mysql_real_escape_string(XWEIBO_VERSION)."'),('app_key', '".mysql_real_escape_string($site_config['app_key'])."'),('app_secret', '".mysql_real_escape_string($site_config['app_secret'])."')";
	if (mysql_query($sql, $link) == false) {
		/// 错误日志
		install_log('sql: '.$sql." \r\nerrno: ".mysql_errno($link)." \r\nerror: ".mysql_error($link));
		show_msg($_LANG['add_admin_errno']);
	}

	mysql_close($link);
}
/**
 * 检测安装使用的数据是否已经存在
 *
 * @param unknown_type
 * @return unknown
 */
function db_exists($db_host, $db_user, $db_passwd, $db_name, $db_prefix = null)
{
	global $_LANG;
	$link = @mysql_connect($db_host.':'.$_SERVER['HTTP_MYSQLPORT'], $db_user, $db_passwd);
	if (!$link) {
		/// 错误日志
		install_log("sql: \r\nerrno: ".mysql_errno()." \r\nerror: ".mysql_error());
		return '-1';
	}
	$sql = 'show databases';
	$result = mysql_query($sql);
	$list = array();
	while ($row = mysql_fetch_assoc($result)) {
		if ($db_name == $row['Database']) {
			$ret = check_app_key($link, $db_name, $db_prefix);
			if ($ret == '10001' || $ret == '10000') {
				return $ret;
			}
			return '1';
		}
	}
	return '0';
}
/**
 * 检测之前安装xweibo的版本
 *
 * @param unknown_type
 * @return unknown
 */
function check_version($db_host, $db_user, $db_passwd, $db_name, $db_prefix = null)
{
	$link = db_resource($db_host, $db_user, $db_passwd, $db_name, true);
	if ($link == '-1') {
		return '0';
	}
	if ($db_prefix) {
		$table_name = $db_prefix.'sys_config';
	} else {
		$sql = "show tables like '%sys_config'";
		$result = mysql_query($sql, $link);
		$list = array();
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			if (empty($row[0])) {
				return '0';
			}
			$sql = 'SELECT value FROM '.$row[0].' WHERE `key` = "wb_version"';
			$ret = mysql_query($sql, $link);
			$fields_rows = mysql_fetch_assoc($ret);
			if ($fields_rows) {
				$table_name = $row[0];
				break;
			}
			return '0';
		}
	}

	$sql = 'SELECT value FROM '.$table_name.' WHERE `key` = "wb_version"';
	$ret = mysql_query($sql, $link);
	if ($ret) {
		$row = mysql_fetch_assoc($ret);
		if ($row['value'] != XWEIBO_VERSION) {
			return $row['value'];
		}
		return '1';
	}
	return '0';

	mysql_close();
}
/**
 * 
 * 是否已安装
 * @return true 已经安装 false 未安装
 */
function checkInstall(){
	$content = get_ini_file();
	if($content){
		if($content['finish']){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
/**
 * 
 * 判断domain是否有设置
 * @return
 */
function checkDomain(){
	$s = new SaeStorage();
	$result = $s->write(SAE_DOMAIN,'test','test' );
	if($result){
		$s->delete( SAE_DOMAIN,'test');
		return true;
	}else{
		return false;
	}
}
/**
 * 判断是否开启mysql
 */
function checkDB(){
	if(SAE_ACCESSKEY){
		return true;
	}else{
		return false;
	}
}
?>