<?php
/**************************************************
*  Created:  2010-10-18
*
*  后台Action基类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class action {
		var $userInfo = array();
		function action() {
			//判断用户是否登录			
			if (!USER::isUserLogin()) {
				exit('<script>window.top.location.href = "' . URL('account.sinaLogin','cb=login&loginCallBack=' . urlencode(URL('mgr/admin.login', '', 'admin.php')), 'index.php'). '"</script>');
				//APP :: redirect(URL('account.gloCheckLogin', '', 'index.php'), 3);
			}

			//判断管理员是否登录
			if (!$this->_isLogin() && !($this->_getModule() == 'admin' && in_array($this->_getAction() , array('login', 'authcode')) )) {
				exit('<script>window.top.location.href = "' . URL('mgr/admin.login', '', 'admin.php'). '"</script>');
				//APP :: redirect(URL('mgr/admin.login', 'admin.php'), 3);
			}

			TPL :: assign('admin_root', $this->_getUserInfo('__CLIENT_ADMIN_ROOT'));
			TPL :: assign('real_name', $this->_getUserInfo('screen_name'));
			TPL :: assign('admin_id', $this->_getUid());
			
		}

		/**
		 * 用户是否已登录
		 */
		function _isLogin() {
			return USER::isAdminLogin();
		}

		/**
		 * 得到当前登录用户ID
		 * @return int
		 */
		function _getUid() {
			return USER::aid();
		}

		/**
		 * 得到登录用户信息
		 */
		function _getUserInfo($key = '') {
			return USER::get($key);
		}

		/**
		 * 得到控制器名称
		 * @return string
		 */
		function _getController() {
				$router_str = APP::getRuningRoute(true);
				return trim($router_str['path'], '/\\');
		}

		/**
		 * 得到模块名称
		 * @return string
		 */
		function _getModule() {
				$router_str = APP::getRuningRoute(true);
				return $router_str['class'];
		}

		/**
		 * 复到action名称
		 * @return string
		 */
		function _getAction() {
				$router_str = APP::getRuningRoute(true);
				return $router_str['function'];
		}

		/**
		 * 跳转
		 */
		function _redirect($action, $module = false, $controller = false) {
			if (!$action) {
				return;
			}
			$module = $module ? $module : $this->_getModule();
			$controller = $controller ? $controller : $this->_getController();
			$path = $controller . '/' . $module . '.' . $action;
			header('Location:' . APP::mkModuleUrl($path, '', 'admin.php'));
			exit;
		}

		/**
		 * 当前请求方法
		 */
		function _requestMethod() {
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
		 * 操作成功后跳转
		 * @param $msg String 要显示的消息
		 * @param $url String|Array 显示消息3秒后跳转的地址,如果该参数为数据则为路由方式,其中下标为0表示action,1表示module,2表示controller,
		 */
		function _succ($msg, $url = null) {
			if (is_array($url)) {
				if (empty($url[0])) {
					APP :: tips(array('msg'=> $msg, 'tpl' => 'error', 'baseskin'=>false));
				}
				$module = isset($url[1]) ? $url[1]: $this->_getModule();;
			TPL :: assign($this->userInfo);

				$controller = isset($url[2]) ? $url[2] : $this->_getController();
				$url = URL( $controller . '/' . $module . '.' . $url[0]);
			}
			if (!$url) {
				APP :: tips(array('msg'=> $msg, 'tpl' => 'error','baseskin'=>false));
			}
			APP :: tips(array('msg'=> $msg, 'tpl' => 'mgr/success', 'timeout'=>3, 'location' => $url, 'baseskin'=>false));
		}

		/**
		 * 操作成功后跳转
		 * @param $msg String 要显示的消息
		 * @param $url String|Array 显示消息3秒后跳转的地址,如果该参数为数据则为路由方式,其中下标为0表示action,1表示module,2表示controller,
		 */
		function _error($msg, $url = null) {
			if (is_array($url)) {
				if (empty($url[0])) {
					APP :: tips(array('msg'=> $msg, 'tpl' => 'error', 'baseskin'=>false));
				}
				$module = isset($url[1]) ? $url[1]: $this->_getModule();
				$controller = isset($url[2]) ? $url[2] : $this->_getController();
				$url = URL( $controller . '/' . $module . '.' . $url[0]);
			}

			$param = array(
						'msg'=> $msg,
						'tpl' => 'mgr/error',
						'baseskin'=>false
					);

			if ($url) {
				$param += array(
					'timeout'=>3,
					'location' => $url
				);
			}
			APP :: tips($param);
		}

		/**
		 * 当前请求是否为POST方法
		 */
		function _isPost() {
			if (strtolower($this->_requestMethod()) == 'post') {
				return true;
			}
			return false;
		}

		/**
		 * 当前请求是否为GET方法
		 *
		 */
		function _isGet() {
			if (strtolower($this->_requestMethod()) == 'get') {
				return true;
			}
			return false;
		}

		function _display($tpl) {
			TPL :: display('mgr/' . $tpl, '', 0, false);
		}
}
