<?php
/**
* 如果Xweibo运行于SAE环境，则自动在这个函数里定义相关的常量
* 
* 如果已安装成功，返回 TRUE　，如果未安装　返回 FALSE
*/
function sae_set_global_define() {
	
	$content = IO::read(CONFIG_DOMAIN);
	$site_base_info = array();
	parse_str($content, $site_base_info);
	

	if($site_base_info['app_key']&&$site_base_info['app_secret']){
		/// 产品安装路径
		define('W_BASE_URL_PATH',		$site_base_info['path']);
		/// 微博 APP_KEY
		define('WB_AKEY' , 					$site_base_info['app_key']);
		/// 微博 SECRET_KEY
		define('WB_SKEY' , 					$site_base_info['app_secret']);

		define('WB_USER_SITENAME',			$site_base_info['site_name']);
		define('WB_USER_SITEINFO',			$site_base_info['site_info']);
		define('WB_USER_NAME' , 			$site_base_info['user_name']);
		define('WB_USER_EMAIL' , 			$site_base_info['user_email']);
		define('WB_USER_QQ' , 				$site_base_info['user_qq']);
		define('WB_USER_MSN' , 				$site_base_info['user_msn']);
		define('WB_USER_TEL' , 				$site_base_info['user_tel']);
		define('SYSTEM_SINA_UID' , 			$site_base_info['sina_id']);
		define('WB_USER_OAUTH_TOKEN' , 		$site_base_info['user_oauth_token']);
		define('WB_USER_OAUTH_TOKEN_SECRET' , $site_base_info['user_oauth_token_secret']);
		return true;
	}else{
		return false;
	}
	
}