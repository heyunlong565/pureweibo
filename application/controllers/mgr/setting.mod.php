<?php
include('action.abs.php');
class setting_mod extends action{
	function setting_mod() {
		parent :: action();
	}

	/*
	* 上传logo
	*/
	function uploadLogo() {
		if ($this->_isPost()) {
			$file = V('f:logo');
			$state = 200;
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 500 * 1024) {
					$state = '上传LOGO的大小不能超过500K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 200 || $info[1] > 65) {
					$state = '上传的图片长宽(200x65)超过限制，请重新选择';
					break;
				}

				//上传文件
				$file_obj = APP::ADP('upload');
				$file_arr = explode('.', WB_LOGO_PREVIEW_FILE_NAME);
				if (!$file_obj->upload('logo', array_shift($file_arr), P_VAR_NAME, 'png')) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . WB_LOGO_PREVIEW_FILE_NAME;
					break;
				}
				//获取上传文件的信息
				$logo = $file_obj->getUploadFileInfo();
				break;			
			}
			//var_dump($logo);exit;
			echo '<script>parent.uploadFinished("' . $state. '","' . F('fix_url', $logo['savepath']) . '");</script>';
		}
	}
	
	/*
	* 上传地址图标
	*/
	function uploadIcon() {
		if ($this->_isPost()) {
			$file = V('f:address_icon');
			$state = 200;
			while ($file && $file['tmp_name']) {
				if ($file['size'] > 50 * 1024) {
					$state = '上传LOGO的大小不能超过500K';
					break;
				}
				$info = getimagesize($file['tmp_name']);
				if ($info[2] != 3) {
					$state = '上传的图片文件不为PNG格式，请重新选择';
					break;
				}
				if ($info[0] > 10 || $info[1] > 10) {
					$state = '上传的图片长宽(186x50)超过限制，请重新选择';
					break;
				}
				if (!move_uploaded_file($file['tmp_name'], P_VAR . WB_ICON_PREVIEW_FILE_NAME)) {
					$state = '复制文件时出错,上传失败' . $file['tmp_name'] . '===' . P_VAR . WB_ICON_PREVIEW_FILE_NAME;
					break;
				}
				$icon = W_BASE_URL . P_VAR_NAME .WB_ICON_PREVIEW_FILE_NAME;
				break;
			}
			echo '<script>parent.uploadFinished("' . $state. '","' . $icon . '");</script>';
		}
	}
	
	/*	
	* 站点设置提交
	*/
	function editIndex() {
		if ($this->_isPost()) {
			$file_logo = V('p:logo');
			$file_icon = V('p:address_icon');
			$logo = $icon = '';
		
			if ($file_logo) {
				if(XWB_SERVER_ENV_TYPE == "sae") {
					$file_arr = explode('.', WB_LOGO_PREVIEW_FILE_NAME);
					$file_content = IO::read(array_shift($file_arr));
					$url = IO::write(P_VAR . WB_LOGO_FILE_NAME, $file_content);
					$logo = $url;
				}elseif(is_file(P_VAR . WB_LOGO_PREVIEW_FILE_NAME)) {
					$file_content = IO::read(P_VAR . WB_LOGO_PREVIEW_FILE_NAME);
					IO::write(P_VAR . WB_LOGO_FILE_NAME, $file_content);
					$logo = P_VAR_NAME .WB_LOGO_FILE_NAME;
				}
			}

			$data = array(
				'logo' => $logo,	//logo图标
				'address_icon' => $icon,	//网站地址图标
				'third_code' => V('p:third_code', ''),//网站第三方统计代码
				'site_record' => htmlspecialchars(trim(V('p:site_record', ''))),//网站备案信息代码
				'site_name' => htmlspecialchars(trim(V('p:site_name', ''))),//网站名称
				);
			foreach($data as $key=>$value) {
				$result = DR('common/sysConfig.set', '', $key, $value);
				if($result['errno']) {
					$this->_error('配置失败',  array('editIndex'));
				}
			}
			$this->_succ('已经成功保存你的配置', array('editIndex'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');
		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('setting');
	}
	
	/*	
	* 优化设置
	*/
	function editRewrite() {
		if ($this->_isPost()) {
			$result = DR('common/sysConfig.set', '', 'rewrite_enable', V('p:rewrite_way', '0'));
			
			if($result['errno']) {
				$this->_error('配置失败',  array('editRewrite'));
			}

			$this->_succ('已经成功保存你的配置', array('editRewrite'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');

		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('optimization_setting');
	}	
	
	/*	
	* 用户登录管理
	*/
	function editUser() {
		if ($this->_isPost()) {			

			$result = DR('common/sysConfig.set', '', 'login_way', V('p:login_way', 1));	//登录方式1.仅使用新浪帐号直接登录 2.仅使用原有站点帐号登录 3。使用新浪帐号与原有站点帐号并存方式登录
			
			if($result['errno']) {
				$this->_error('配置失败',  array('editUser'));
			}

			$this->_succ('已经成功保存你的配置', array('editUser'));
			exit;
		}
		
		$d = DR('common/sysConfig.get');

		if ($d['rst']) {
			TPL::assign('config', $d['rst']);
		}
		$this->_display('login_setting');
	}

	/*
	* 获取页首页脚设置
	*/
	function getLink() {
		//获取页首设置
		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'],true);
		TPL::assign('head_link', $head_link);

		//获取页脚设置
		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'],true);
		TPL::assign('foot_link', $foot_link);

		$this->_display('header_setting');
	}

	/*
	* 根据id获取相应的链接数据
	*/
	function getLinkById() {
		$id = (int)V('g:id', 0);
		$action = V('g:action', '');
		
		if(!$id || !$action) {
			$this->_error('参数错误！',  array('getLink'));
		}
		
		//获取页首设置
		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'],true);

		//获取页脚设置
		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'],true);

		if($action == 'head') {
			$data = $head_link[$id];
		}

		if($action == 'foot') {
			$data = $foot_link[$id];
		}

		if($id) {
			APP::ajaxRst($data);
			exit;
		}

		TPL::assign('data', $data);
		$this->_display('header_setting');
	}

	/*
	* 编辑,添加页首页脚设置
	*/
	function editLink() {
		$action = V('p:action', '');
		$link = htmlspecialchars(V('p:link_address', ''));
		$name = htmlspecialchars(V('p:link_name', ''));
		$id = (int)V('p:id', 0);

		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'], true);
		$head_count = count($head_link);

		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'], true);
		$foot_count = count($foot_link);

		//判断链接地址是否以http开头
		if (!preg_match('#^http://#sm', $link)) {
			$link = 'http://' . $link;
		}

		//添加,编辑首页链接
		if ($action == 'head') {
			//获取页首设置
			if(!$link || !$name) {
				$this->_error('链接名称或地址不能为空',  array('getLink'));
			}

			$data = array(
							'link_name' => $name,
							'link_address' => $link
					);
			
			if($id) {
				$head_link[$id] = $data;
			}else{
				if($head_count) {
					$head_link[] = $data;
				}else{
					$head_link[1] = $data;
				}
			}

			if(count($head_link) > 5) {
				$this->_error('页首链接数不能多于5个',  array('getLink'));
			}
			$result = DR('common/sysConfig.set', '', 'head_link', json_encode($head_link));
		}


		//添加,编辑页尾链接
		if ($action == 'foot') {
			//获取页首设置
			if(!$link || !$name) {
				$this->_error('链接名称或地址不能为空',  array('getLink'));
			}

			$data = array(
							'link_name' => $name,
							'link_address' => $link
					);

			if($id) {
				$foot_link[$id] = $data;
			}else{
				if($foot_count) {
					$foot_link[] = $data;
				}else{
					$foot_link[1] = $data;
				}
			}

			if(count($foot_link) > 5) {
				$this->_error('页尾链接数不能多于5个',  array('getLink'));
			}
			$result = DR('common/sysConfig.set', '', 'foot_link', json_encode($foot_link));
		}

		if($result['errno']) {
			$this->_error('配置失败',  array('getLink'));
		}

		$this->_succ('已经成功保存你的配置', array('getLink'));
		exit;
	}

	/*
	* 删除页首页脚设置
	*/
	function delLink() {
		$action = V('g:action', '');
		$id = (int)V('g:id', 0);

		$d = DR('common/sysConfig.get','','head_link');
		$head_link = json_decode($d['rst'], true);

		$d = DR('common/sysConfig.get','','foot_link');
		$foot_link = json_decode($d['rst'], true);

		if(!$id) {
			$this->_error('不能删除该项！',  array('getLink'));
		}

		if ($action == 'head') {
			unset($head_link[$id]);
			$result = DR('common/sysConfig.set', '', 'head_link', json_encode($head_link));
		}

		if ($action == 'foot') {
			unset($foot_link[$id]);
			$result = DR('common/sysConfig.set', '', 'foot_link', json_encode($foot_link));
		}

		if($result['errno']) {
			$this->_error('配置失败',  array('getLink'));
		}

		$this->_succ('已经成功保存你的配置', array('getLink'));
		exit;
	}
}
?>