<?php
/**
 * @file			xauthCookie.adp.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			通用的　基于　COOKIE　的账号适配器模板文件
 */
// ----------------------------------------------------------------------------------

/// 你的站名称，不以 网字结尾  ,　不要超过　10个汉字，20　个字母
define('XAUTH_SITE_NAME',			'你的网站名称');
/// 你的网站登录地址 如下所示，如果你的网站能根据参数判断，并在登录后跳回　Xweibo　用户体验将会更好 
define('XAUTH_SITE_LOGIN_URL',		'http://yourDomain/login.php');
/// 你的网站注册地址 Xweibo　会自动添加　XAUTH_SITE_CALLBACK_NAME　参数，
define('XAUTH_SITE_REG_URL',		'http://yourDomain/register.php');
/// XWEIBO跳转到你的登录或者注册URL的时候会自动添加名称如下的参数，其值为XWEIBO广场首页地址
define('XAUTH_SITE_CALLBACK_NAME',	'referer');
// ----------------------------------------------------------------------------------

/// 是否启用　SCRIPT　方式同步账号登录状态,类ucenter，当你的网站与XWEIBO根域名不相同时，需要启用　
define('XAUTH_SITE_UC_ENABLE',		false);
/// XAUTH_SITE_UC_ENABLE　启用时，已绑定用户，在XWEIBO通过SINA登录，XWEIBO将通过SCRIPT的方式，给这个接口发送请求，有三个参数 _xauthAction _xauthTK _xauthSG (这些参数名是可定制的)
define('XAUTH_SITE_UC_API_URL',		'http://yourDomain/xwb_server.php');
/// 访问　XAUTH_SITE_UC_API_URL　接口时的操作类型名称，启用　XAUTH_SITE_UC_ENABLE 时可用
define('XAUTH_SITE_UC_ACTION_NAME',	'_xauthAction');
// ----------------------------------------------------------------------------------

/// TOKEN　的数据格式可选值，json,query
define('XAUTH_TK_DATA_FORMAT',		'query');
/// TOKEN　加密方式，如果为空　则表示明文，可选值为：dzauth (DZ 的加密解密函数,可扩展为　des　等)
define('XAUTH_TK_DATA_ENCRIPTION',	'');
/// TOKEN　加密或者签名时使用的　KEY，[重要]
define('XAUTH_TK_DATA_ENCRIPT_KEY',	'XWEIBO_KEY_2010');
/// TOKEN  明文内容所用的字符集
define('XAUTH_TK_DATA_CHARSET',		'UTF-8');
// ----------------------------------------------------------------------------------

/// TOKEN　签名方法,为空则不使用签名,　可选值：　能够生成　HASH　值的　全局函数如: md5,crc32 , 当　XAUTH_TK_DATA_ENCRIPTION　为空（TOKEN　为明文）时，必须为非空
define('XAUTH_TK_DATA_SIGN_FUNC',	'md5');
/// TOKEN  签名格式 签名值＝ XAUTH_TK_DATA_SIGN_FUNC(sprintf(XAUTH_TK_DATA_SIGN_FORMAT,TOKEN,XAUTH_TK_DATA_ENCRIPT_KEY))
define('XAUTH_TK_DATA_SIGN_FORMAT',	"%s###%s");
// ----------------------------------------------------------------------------------

/// 存储　TOKEN 的 COOKIE 名 , 同时也是　api/uc.php　接受的 TOKEN 参数名
define('XAUTH_CK_DATA_NAME',	'_xauthTK');
/// 存储　TOKEN 签名的 COOKIE 名,  同时也是　api/uc.php　接受的 TOKEN 签名参数名
define('XAUTH_CK_SIGN_NAME',	'_xauthSG');

/// 存储　TOKEN 的 COOKIE 有效域
define('XAUTH_CK_DOMAIN',	'');
/// 存储　TOKEN 的 COOKIE 有效路径
define('XAUTH_CK_PATH',		'/');
/// 存储　TOKEN 的 COOKIE 有周期，如：APP_LOCAL_TIMESTAMP+3600*30 , 0为浏览器周期
define('XAUTH_CK_EXP',		'0');
// ----------------------------------------------------------------------------------

// 已绑定你的网站的用户的使用SINA帐号，登录，退出时，是不是要同步到你的网站
define('XAUTH_SYNC_USER_STATUS',	true);


// ----------------------------------------------------------------------------------
class xauthCookie_account {
	function xauthCookie_account() {
	}
	/**
	* 初始化的时候会调用此方法
	*/
	function adp_init($config=array()) {
		if (!XAUTH_TK_DATA_ENCRIPTION && !XAUTH_TK_DATA_SIGN_FUNC){
			$this->_warning('XAUTH_TK_DATA_ENCRIPTION XAUTH_TK_DATA_SIGN_FUNC 不能同时为空，为保证安全，使用明文TOKEN必须启用签名');
		}
	}
	/**
	 *  获取网站的相关信息  数组 ，这些信息会在各登录模板信息中体现
	 *  site_name	你的网站名称
	 *  reg_url		你的网站注册地址，你的网站可以通过参数判断，来自Xweibo的注册返回到Xweibo
	 *  login_url	你的网站登录地睛，你的网站可以通过参数判断，来自Xweibo的登录返回到Xweibo
	 *  user_name	当前登录的　用户名　(在你的网站上的名字)
	 *  user_id		当前登录的　用户ID　(在你的网站上的ID)
	 */
	function getInfo(){
		//$xwb_home_url = W_BASE_HTTP.URL('pub');//这是 Xweibo　广场的地址
		return  array(
				'site_name'=>	XAUTH_SITE_NAME , 
				'site_uid'=>	$user['site_uid'],
				'site_uname'=>	F('xwb_iconv', $user['site_uname'], XAUTH_TK_DATA_CHARSET, 'UTF-8'),
				'reg_url'=>		XAUTH_SITE_REG_URL, 
				'login_url'=>	XAUTH_SITE_LOGIN_URL);
	}
	/**
	* 你的网站访问　api/uc.php　的请求将全部被定向到这个方法 
	* 你可以在这里处理你的网站发过来的请求,
	* 比如:当用户在你的网站里登录、退出时，你可以向　api/uc.php 发送一个请求通知XWEIO，某某登录、退出了
	* 当你的网站域名与Xweibo部署的域名不是同一根域时　可以使用　SCRIPT 的方式访问此API以达到同步的目的
	* 或者你的网站有其它消息需要通知xweibo也可以在此实现
	*/
	function acceptSyncMessage(){
		
	}
	/**
	* Xweibo　通过　SINA　账号　登录时，如果发现当前账户已绑定　第三方网站账号
	* 则Xweibo会通过调用此方法
	* 
	* @param mixed $site_uid　当前SINA账号绑定的第三方网站账号ID
	* @param mixed $sina_uid　当前登录的SINA账号ID
	* @return mixed 可以为空，或者一段JS SCRIPT
	* 注：此方法如果返回　script　将在用户登录后被执行　(跨域名整合时可用，类ucenter通信) 
	*/
	function syncLogin($site_uid,$sina_uid=0){
		if (!XAUTH_SYNC_USER_STATUS){return '';}
	}
	/**
	* Xweibo　退出时，如果发现当前账户已绑定　第三方网站账号
	* 则Xweibo会通过调用此方法
	* 
	* @param mixed $site_uid　当前SINA账号绑定的第三方网站账号ID
	* @return mixed 可以为空，或者一段JS SCRIPT
	* 注：此方法如果返回　script　将在退出后被执行　(跨域名整合时可用，类ucenter通信) 
	*/
	function syncLogout($site_uid=0){
		if (!XAUTH_SYNC_USER_STATUS){return '';}
	}
	
	/**
	* 通过此方法，获取当前登录的第三方网站的用户
	*  user_name	当前登录的　用户名　(在你的网站上的名字)
	*  user_id		当前登录的　用户ID　(在你的网站上的ID)
	*/
	function _getUser(){
		$user = $this->_getToken();
		if (!$user || !is_array($user) || !isset($user['uid']) || !isset($user['username'])){
	    	return array('site_uid'=>0, 'site_uname'=>'Guest');
		}else{
			return array('site_uid'=>$user['uid'], 'site_uname'=>$user['username'] );
		}
	}
	
	/**
	* 获取当前请求中存在的TOKEN信息
	* @param string $opt = (local|request)
	* @return mixed 分析后有的有效TOKEN信息，如果签名不通过，或者过期将返回 false
	*/
	function _getToken($opt='local'){
		//XAUTH_SITE_UC_ACTION_NAME
		if ($opt=='local'){
			$tokenStr = V('c:'.XAUTH_CK_DATA_NAME,false);
			$signStr =  V('c:'.XAUTH_CK_SIGN_NAME,'');
		}else{
			$tokenStr = V('g:'.XAUTH_CK_DATA_NAME,false);
			$signStr =  V('g:'.XAUTH_CK_SIGN_NAME,'');
		}
		if ($tokenStr && $this->_chkSign($tokenStr, $signStr)){
			return $this->_tokenArrData($tokenStr);
		}
		return false;
	}
	
	/**
	* 设置一个本地TOKEN
	* 
	* @param mixed $tokenArrData
	*/
	function _setLocalToken($tokenArrData){
		//XAUTH_CK_DATA_NAME
		
	}
	
	/**
	* 设置一个COOKIE
	* 
	* @param mixed $k
	* @param mixed $v
	*/
	function _setCookie($k, $v){
		$this->_p3p();
		setcookie($k, $v, );
	}
	
	/**
	* 检查签名
	* 
	* @param mixed $string　被签名内容
	* @param mixed $signStr 签名串
	* @return 检查通过，返回　true 否则返回　false
	*/
	function _chkSign($string,$signStr){
		return $signStr == $this->_sign($string);
	}
	
	/**
	* 根据配置的签名算法生成签名　
	* 注：本类所有　_tk_sign_* 方法都可以被配置为签名方法
	* 
	* @param string $signStr 待签名的字符串
	* @return string ，签名后的字符串,如果　XAUTH_TK_DATA_SIGN_FUNC　为空，则直接返回原串
	*/
	function _sign($signStr){
		//签名方法,如果为空直接返回明文字符串
		if (XAUTH_TK_DATA_SIGN_FUNC){
			//本类所有　_tk_sign_* 方法都可以被配置为签名方法
			$signFunc = '_tk_sign_'.XAUTH_TK_DATA_SIGN_FUNC;
			if (method_exists($this, $signFunc)){
				$signStr = sprintf(XAUTH_TK_DATA_SIGN_FORMAT, $signStr, XAUTH_TK_DATA_ENCRIPT_KEY);
				return $this->$signFunc($signStr);
			}else{
				$this->_warning('无法在本类中找到你配置的签名方法['.$signFunc.']');
			}
		}
		return $signStr;		
	}
	
	/**
	* md5　的md5签名方法
	* 
	* @param mixed $str 被签名的字符串
	* @return string 签名后的字符串
	*/
	function _tk_sign_md5($str){
		return md5($str);
	}
	
	/**
	* crc32　的HASH签名方法
	* 
	* @param mixed $str 被签名的字符串
	* @return string 签名后的字符串
	*/
	function _tk_sign_crc32($str){
		return crc32($str);
	}
	
	/**
	* 根据TOKEN数据生成，特定格式(query|json)的，字符串TOKEN
	* 如果配置了加密算法，将返回加密后的字符串
	* @param mixed $tokenData
	*/	
	function _tokenString($tokenData){
		$tkStr = '';
		switch (strtolower(XAUTH_TK_DATA_FORMAT)) {
			case 'query':
				$tkStr = http_build_query($tokenData);
				break;
			case 'json':
				$tkStr = json_encode($tokenData);
				break;
			default:
				$this->_warning('账号适配器配置 [XAUTH_TK_DATA_FORMAT] 错误');
			break;
		}
		if (empty($tkStr)){
			$this->_warning('TOKEN为空，或者无法将TOKEN数据转换成['.XAUTH_TK_DATA_FORMAT.']格式的字符串');
		}
		return $this->_encrypt($tkStr, 'encode');
	}
	
	/**
	* 根据　TOKEN　串，解密，并还原为TOKEN　数组
	* 
	* @param mixed $tokenStr
	* @return mixed
	*/
	function _tokenArrData($tokenStr){
		$tokenStr = $this->_encrypt($tokenStr, 'decode');
		$rst = false;
		switch (strtolower(XAUTH_TK_DATA_FORMAT)) {
			case 'query':
				parse_str($tokenStr, $rst);
				break;
			case 'json':
				$rst = json_decode($tokenStr);
				break;
			default:
				$this->_warning('账号适配器配置 [XAUTH_TK_DATA_FORMAT] 错误');
			break;
		}
		if (empty($tkStr)){
			$this->_warning('TOKEN为空，或者无法将TOKEN数据转换成['.XAUTH_TK_DATA_FORMAT.']格式的字符串');
		}
		return $rst;
	}
	
	/**
	* 加密，解释方法, 本类所有　_tk_encrypt_* 方法都可以被配置为加密函数
	* 
	* @param mixed $string 明文字符串
	* @param mixed $operation 操作类型　可选值：　encode(加密)|decode(解密)
	* @return string 加密或者解密后的字符串,如果　XAUTH_TK_DATA_ENCRIPTION 配置为空，则直接返回明文 $string
	*/
	function _encrypt($string, $operation='encode'){
		//加密方法,如果为空直接返回明文字符串
		if (XAUTH_TK_DATA_ENCRIPTION){
			//本类所有　_tk_encrypt_* 方法都可以被配置为加密函数
			$encFunc = '_tk_encrypt_'.XAUTH_TK_DATA_ENCRIPTION;
			if (method_exists($this, $encFunc)){
				return $this->$encFunc($string, $operation);
			}else{
				$this->_warning('无法在本类中找到你配置的加密解密方法['.XAUTH_TK_DATA_ENCRIPTION.']');
			}
		}else{
			return $string;
		}  
	}
	
	
	/**
	* dzauth　的加密，解密方法，本类所有　_tk_encrypt_* 方法都可以被配置为加密函数 
	* 即：　XAUTH_TK_DATA_ENCRIPTION　的值
	* 
	* @param mixed $string 明文字符串
	* @param mixed $operation 操作类型　可选值：　encode(加密)|decode(解密)
	* @return string 加密或者解密后的字符串
	*/
	function _tk_encrypt_dzauth($string, $operation='encode'){
	 	$operation	= strtoupper($operation);
	 	$expiry		= 0;
		$ckey_length = 4;

		$key	= XAUTH_TK_DATA_ENCRIPT_KEY;
		$keya	= md5(substr($key, 0, 16));
		$keyb	= md5(substr($key, 16, 16));
		$keyc	= $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + APP_LOCAL_TIMESTAMP : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - APP_LOCAL_TIMESTAMP > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	/**
	* 发送一个P3P的头，使用SCRIPT互相通知登录状态时，可用
	*/
	function _p3p(){	
		static $isSet = false;
		if (!$isSet){
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			$isSet = true;
		}
	}
	/**
	* 抛一个错误，并退出
	* 
	* @param mixed $str　错误信息
	*/
	function _warning($str){
		trigger_error($str, E_USER_ERROR);
		exit;
	}
}