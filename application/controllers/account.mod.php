<?php
/**
 * @file			account.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	xionghui/2010-11-15
 * @Brief			帐号相关操作
 */

class account_mod {
	var $accAdapter ;
	function account_mod(){
		/// 根据配置获取帐号适配器
		$this->accAdapter = APP::ADP('account');
	}

	function rst(){
		echo $this->accAdapter->syncLogout(0);
	}
		
	/// 绑定引导页
	function bind(){		
		TPL::display('bind_account');
	}
	
	/// 退出登录
	function logout($eUrl=false){
		/// 上报
		F('report', 'logout', 'http');

		$site_uid = USER::get('site_uid');

		/// 清空SESSION 
		USER::uid(0);
		USER::resetInfo();
		
		/// 退出地址
		$exitUrl = $eUrl ? $eUrl : URL('pub');
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		if ($login_way==1){
			APP::redirect($exitUrl,4);
		}else{
			//　发送退出通知到其它应用
			$syncLogoutScript = $this->accAdapter->syncLogout($site_uid);
			//var_dump( F('escape', $syncLogoutScript));exit;
			if ($syncLogoutScript){
				echo  $syncLogoutScript,"\n";
			}
			APP::redirect($exitUrl,4);
		}
	}
	
	/// 显示登录 页面
	function login(){
		if (USER::isUserLogin()){
			APP::redirect(URL('pub'), 3);exit;
		}
		// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
		$login_way = V('-:sysConfig/login_way', 1)*1;
		$use_sina_login = ($login_way == 1 || $login_way == 3);
		$use_site_login = ($login_way == 2 || $login_way == 3);
		
		// 如果可使用附属站登录，则获取相关信息
		if ($use_site_login){
			   $site_info = $this->accAdapter->getInfo();
			   TPL::assign('site_info', $site_info); 
		}
		
		TPL::assign('use_sina_login', $use_sina_login);   
		TPL::assign('use_site_login', $use_site_login);  
		
		TPL::display('login');
	}
	
	/// 初始化附属站信息,并根据附属站同步登录信息
	function initSiteInfo(){
		$isInit = USER::get('initSiteInfo');
		if ($isInit) {
			//return true;
		}
		
		//----------------------
		// 防止出现　SINA_UID　为非　０ , token 为空 的中断异常情况
		$token		= USER::getOAuthKey(true);
		$sina_uid	= USER::uid() ;
		if ($sina_uid && empty($token)){
			USER::uid(0);
			USER::resetInfo();
		}
		//----------------------
		
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		$site_uid	= USER::get('site_uid');
		$site_uname = 'Guest';
		$site_name	= 'NoneSite';
		if ($login_way == 2 || $login_way == 3) {
			$sUser = $this->accAdapter->getInfo();
			if (is_array($sUser)){
				$GLOBALS[V_CFG_GLOBAL_NAME]['siteInfo'] = $sUser;
				$site_uid	= $sUser['site_uid'];
				$site_uname = $sUser['site_uname'];
				$site_name	= $sUser['site_name']; 
			}
			
			//　从  附属站　同步到  Xweibo  
			if (!empty($site_uid) && !USER::isUserLogin()){
				 $user = $this->getBindInfo($site_uid, 'uid');
				 if (!empty($user) && is_array($user) && !empty($user['access_token']) && !empty($user['token_secret']) ){
				 	 $this->_setSinaLoginSession(array(
				 	   		'oauth_token'=> $user['access_token'],
				 	   		'oauth_token_secret'=> $user['token_secret'],
				 	   ));
				 }
			}
			
			//　从 Xweibo　同步到附属站
			if ($sina_uid && empty($site_uid)) {
			    $user = $this->getBindInfo($sina_uid, 'sina_uid');	
				 //var_dump($user);exit;
				 if (!empty($user) && is_array($user) ){
				 	  $site_uid = $user['uid'];
				 }
			}
			
		}
		USER::set('initSiteInfo',	'1');
		USER::set('site_uid',	$site_uid);
		USER::set('site_uname', $site_uname);
		USER::set('site_name',	$site_name);
	}
	
	/// 检查状态状态，全局使用, 是一个 preDoAction
	function gloCheckLogin(){
		$uid = USER::uid();
		//var_dump($uid);exit;
		$login_way = V('-:sysConfig/login_way', 1)*1; 
		// 未登录
		if (!$uid){
			if (USER::get('site_uid') && 1!=$login_way){
				$this->bind();exit;
			}else{
				$this->_goLogin();exit;
			}
		}else{
			return true;
		}
	}
	
	/// 默认动作
	function default_action(){
		$this->_goLogin();
	}
	/// 自动跳转 
	function _goLogin(){
		// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
		$login_way = V('-:sysConfig/login_way', 1)*1;
		switch ($login_way) {
			case 2 :
				$goUrl = $this->accAdapter->goLogin(W_BASE_HTTP.URL('pub'));
				break;
			case 1 :
			case 3 :
			default:
				$goUrl = URL('account.login');
				break;
		}
		APP::redirect($goUrl, 4);
	}
	
	/// 用SINA帐号进行登录,根据 V('g:cb'); 决定授权后 的动作
	function sinaLogin(){
		$cb = V('g:cb', 'login');
		$callbackOpt = $cb ? 'cb='.$cb : 'cb=login';
		
		$isPop = V('g:popup');
		if ($isPop) {
			$callbackOpt .= '&popup=1';
		}
		
		///　登录后的跳转URL
		$loginCallBack = V('g:loginCallBack', '');
		if ($loginCallBack) {
			$loginCallBack = '&loginCallBack='.urlencode($loginCallBack);
		}
		
		$oauthCbUrl = W_BASE_HTTP.URL('account.oauthCallback', $callbackOpt).$loginCallBack;
		
		$oauthUrl	 = DS('xweibo/xwb.getTokenAuthorizeURL', '', $oauthCbUrl);
		$oauthUrl	.= '&from=xweibo&xwb_'.$callbackOpt;
		APP::redirect($oauthUrl, 3);
	}
	
	/// 使用 附属网站登录
	function siteLogin(){
		  $goUrl = $this->accAdapter->goLogin(W_BASE_HTTP.URL('pub'));
		  $this->logout($goUrl);      
	}
	
	/// 检查是否第一次登录
	function _initFirstLoginUser($uInfo){
		 $sina_uid = $uInfo['id'];
		 $user = $this->getBindInfo($sina_uid, 'sina_uid');
		 if (!is_array($user)){
		 	die('DB ERROR...');
		 }
		 //第一次登录，用户信息入库 将引导用户关注
		 if (empty($user) || !isset($user['sina_uid'])){
            $inData = array();
            $inData['first_login']	= APP_LOCAL_TIMESTAMP;
			$inData['sina_uid']	= $uInfo['id'];
			$inData['nickname']	= $uInfo['screen_name'];
			$r = DR('mgr/userCom.insertUser', '', $inData);  
			return true;
		 }else{
		 	 //var_dump($user);exit;
		 	 USER::set('site_uid', $user['uid']);
		 }
		 
		 return false;
	}
	
	/// 从 Oauth 登录回来后 分别对各需求进行处理
	function oauthCallback(){
		$oauth_verifier = V('r:oauth_verifier','');
		//非法访问，或者 Oauth 返回错误
		if(empty($oauth_verifier)){
			//APP::tips(); TODO
			die('oauth_verifier error!');
		}

		$site_uid = USER::get('site_uid');
		$callbackOpt = V('g:cb', 'login');
		
		$last_key = DS('xweibo/xwb.getAccessToken','',$oauth_verifier);
	   	$uInfo = $this->_setSinaLoginSession($last_key);
		

		/// 上报
		F('report', 'login', 'http');

		//--------------------------------------------------------
		switch ($callbackOpt) {
			// 安装时的用户身份获取
			case 'install'	: 
				break;
				
			// 绑定时的用户身份获取
			case 'bind'		: 
				//print_r($uInfo);
				// 将绑定的信息入库
				$inData = array();
				$inData['sina_uid']		= $uInfo['id'];
				$inData['nickname']		= $uInfo['screen_name'];
				$inData['uid']			= $site_uid;
				$inData['access_token']	= $last_key['oauth_token'];
				$inData['token_secret']	= $last_key['oauth_token_secret'];
				
				$user = $this->getBindInfo($uInfo['id'], 'sina_uid'); 
				if (!empty($user) && is_array($user)  ){
					if (empty($user['access_token']) || empty($user['token_secret']) || empty($user['uid']) ){
					   $r = DR('mgr/userCom.insertUser', '', $inData, $uInfo['id']);
					}else{
						//重复绑定
						$this->isBinded($uInfo['screen_name']);
					}
				}else{
					$inData['first_login'] 	= APP_LOCAL_TIMESTAMP; 
					$r = DR('mgr/userCom.insertUser', '', $inData);
				}
				
				//登录回调
				$loadUrl = V('g:loginCallBack', false);
				if (!$loadUrl) {

					//检查是否第一次登录并引导用户
					$isFirst = $this->_initFirstLoginUser($uInfo);
					if ($isFirst) {
						$firstPlugin = DS('Plugins.get', 'g1/86400', 4);

						if ($firstPlugin['in_use'])
							$loadUrl = URL('welcome');
					}
				}				
				$this->_onlogin($loadUrl);
				break;
			
			// 登录时的用户身份获取
			case 'login'	: 
			default 		:
				//设置同步　登录退出状态，在 footer　中输出JS通知 
				USER::set('syncLoginScript', 1);
				//登录回调
				$loadUrl = V('g:loginCallBack', false);
				//检查是否第一次登录并引导用户
				$isFirst = $this->_initFirstLoginUser($uInfo);
				if (!$loadUrl) {
					if ($isFirst) {
						$firstPlugin = DS('Plugins.get', 'g1/86400', 4);

						if ($firstPlugin['in_use'])
							$loadUrl = URL('welcome');
					}
				}				
				$this->_onlogin($loadUrl);
				break;
		}
	}
	
	/// 输出一段JS，通知程序关闭　登录绑定窗口，并跳转到指定页面,或者直接跳转; $goUrl 为 false　则刷新当前页
	function _onlogin($goUrl=false){
			
		if (V('g:popup', false)) {
			$loadUrl = $goUrl ? '"'.addslashes($goUrl).'"' : 'false' ;
			echo '<script>try{window.opener.loginCallback('.$loadUrl.');}catch(e){window.location.href="'. W_BASE_URL . '"}</script>';
		} else {
			$loadUrl = $goUrl ? $goUrl : URL('index') ;
			APP::redirect($loadUrl,3);
		}
		exit;
	}
	
	/// 设置会话信息
	function _setSinaLoginSession($token){
		USER::setOAuthKey($token, true);
		DS('xweibo/xwb.setToken');
		$uInfo = DS('xweibo/xwb.verifyCredentials');
	   //print_r($uInfo);exit;
		USER::uid($uInfo['id']);
		USER::set('sina_uid',		$uInfo['id']);
		USER::set('screen_name',	$uInfo['screen_name']);
		USER::set('description',	$uInfo['description']);
		
		//检查当前帐号是否是　管理员 
		if ($this->_chkIsAdminAcc($uInfo['id'])){
			USER::set('isAdminAccount',	$uInfo['id']);
		}
		
		//封禁检查
		$this->_chkIsForbidden($uInfo['id']);
		return $uInfo;
	}
	
	/// 检查是否是管理员
	function _chkIsAdminAcc($sina_uid){
		$adm = $rs = DS('mgr/adminCom.getAdminByUid','', $sina_uid);
		return (!empty($adm));
	}
	
	/// 检查　用户　是否被封禁
	function _chkIsForbidden($sina_uid){
		$isLoginForbidden = false;
		$uInfo = DS('mgr/userCom.getUseBanById','',$sina_uid);
		//　在封禁表中找到记录,此用户被封禁
		if (!empty($uInfo) && is_array($uInfo) && isset($uInfo['sina_uid']) ){
			$isLoginForbidden = $uInfo['sina_uid'];
			USER::set('isLoginForbidden', $isLoginForbidden);
		}
		
		if ($isLoginForbidden){
			$this->_resetClientSess();
			$this->_onlogin(URL('account.inhibit'));		   
		}
	}
	
	/// 重置前端用户相关的SESSION
	function _resetClientSess(){
		USER::setOAuthKey(array(),	false);
		USER::setOAuthKey(array(),	true);
		USER::uid('');
		USER::set('sina_uid',		'');
		USER::set('screen_name',	'');
		USER::set('description',	'');
	}
	
	///　封禁页面
	function inhibit(){
		
		TPL::display('inhibit');
		exit;
	}
	
	///　重复绑定页面
	function isBinded($user_name){
		$this->_resetClientSess();
		TPL::assign('user_name',		$user_name);
		TPL::assign('sina_login_url',	URL('account.sinaLogin','cb=bind&popup=1'));
		TPL::display('isbind');
		exit;
	}
	
	/// 接受来自第三方的登录通知
	function acceptSyncMessage(){
		$this->accAdapter->acceptSyncMessage();
	}
	
	/// 禁止访问
	function deny(){
		APP::deny();
	} 
	
	/// 解除绑定
	function unBind(){
		$sina_uid = USER::uid();
		if ($sina_uid){
			$inData = array('access_token'=>'', 'token_secret'=>'', 'uid'=>0);	
			$r = DR('mgr/userCom.insertUser', '', $inData, $sina_uid);
			$this->logout();
		}else{
			APP::deny('未登录用户不能解除绑定.');			
		}
		
	}
	
	/// 获取绑定信息
	function getBindInfo($v, $vField='sina_uid'){
		$com =  $vField == 'sina_uid' ? 'mgr/userCom.getByUid' : 'mgr/userCom.getBySiteUid';
	    return DS($com,'p',$v);
	}
	
}
