<?php
/**
 * @file			set.mod.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-06-08
 * @Modified By:	heli/2010-11-15
 * @Brief			个人设置控制器-Xweibo
 */

class setting_mod {

	var $uInfo	= false;
	var $cfg	= array();
	var $avatarTemp = '';
	var $avatarPath = '';

	function setting_mod(){

		$this->avatarPath	= 'avatarTemp/'.date("Y_m/d/H");
		$this->avatarTemp	= W_BASE_URL.P_URL_UPLOAD.'/'.$this->avatarPath;

		$this->cfg		= array(
			'upload_path'	=> $this->avatarPath,
			'allowed_types' => 'jpg|gif|jpeg|png',
			'max_size'	=> 5*1024*1024);
	}

	/// 默认 ACTION
	function default_action(){
		//$this->profile();
		$this->user();
	}

	/// 个人资料设置
	function user() {
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());

		APP::setData('page', 'setting.user', 'WBDATA');
		
		TPL::assign('U', $uInfo['rst']);
		TPL::display('setting_base');	
	}

	/// 头像设置
	function myface() {
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());
		$uInfo = $uInfo['rst'];

		//print_r(V('s'));exit;
		$uData = array();
		$uData['edit_tab']	= V('g:edit', 'info');
		$uData['avatar']	= APP::F('profile_image_url', $uInfo['profile_image_url'], 'profile');
		$uData['sina_uid']	= $uInfo['id'];
		$uData['nick']		= $uInfo['screen_name'];
		$uData['gender']	= $uInfo['gender'];
		$uData['province']	= $uInfo['province'];
		$uData['city']		= $uInfo['city'];
		$uData['description']	= $uInfo['description'];
		$uData['_uploadPicApi']	= urlencode(URL('setting.upload'));
		$uData['_savePicApi']	= urlencode(URL('setting.saveAvatar'));
		//print_r($uData);exit;
		APP::setData('page', 'setting.myface', 'WBDATA');
		TPL::assign('U', $uData);
		TPL::display('setting_modify_head');
	}

	/// 显示设置
	function show() {
		APP::setData('page', 'setting.show', 'WBDATA');
		TPL::display('setting_display');
	}

	/// 标签设置
	function tag() {
		/// 我的标签
		$taglist = DR('xweibo/xwb.getTagsList', '', USER::uid());

		/// 我感兴趣的标签
		$tagsuglist = DR('xweibo/xwb.getTagsSuggestions');

		APP::setData('page', 'setting.tag', 'WBDATA');

		TPL::assign('taglist', $taglist['rst']);
		TPL::assign('tagsuglist', $tagsuglist['rst']);
		TPL::display('setting_tags');
	}

	/// 提醒设置
	function notice() {
		$notice = DR('xweibo/xwb.getNotice');

		APP::setData('page', 'setting.notice', 'WBDATA');

		TPL::assign('notice', $notice['rst']);
		TPL::display('setting_notice');
	}

	/// 隐私设置
	function privacy() {
		TPL::display('setting_privacy');
	}

	/// 黑名单设置
	function blacklist() {
		$blacklist = DR('xweibo/xwb.getBlocks');
		$blacklist = $blacklist['rst'];

		APP::setData('page', 'setting.blacklist', 'WBDATA');

		TPL::assign('blacklist', $blacklist);
		TPL::display('setting_blacklist');
	}

	/// 帐号设置
	function account() {
		APP::setData('page', 'setting.account', 'WBDATA');
		TPL::display('setting_account');
	}

	/// 个人资料编辑
	function profile(){
		$uInfo = DR('xweibo/xwb.getUserShow', '', USER::uid());

		//print_r(V('s'));exit;
		$uData = array();
		$uData['edit_tab']	= V('g:edit', 'info');
		$uData['avatar']	= APP::F('profile_image_url', $uInfo['profile_image_url'], 'profile');
		$uData['sina_uid']	= $uInfo['id'];
		$uData['nick']		= $uInfo['screen_name'];
		$uData['gender']	= $uInfo['gender'];
		$uData['province']	= $uInfo['province'];
		$uData['city']		= $uInfo['city'];
		$uData['description']	= $uInfo['description'];
		$uData['_uploadPicApi']	= urlencode(URL('setting.upload'));
		$uData['_savePicApi']	= urlencode(URL('setting.saveAvatar'));
		//print_r($uData);exit;
		TPL::assign('U', $uInfo['rst']);
		TPL::display('setting_base');
	}
	function flashURL(){
		$url = V('g:url');
		echo file_get_contents($url);
	}
	/// 图像更改步骤1<#sae#>
	function upload() {

		//if (1) {print_r(V('p'));print_r(V('f'));}
		$this->_chkUid();

		$r = array('w'=>180,'h'=>180, 'url'=>'');
		
		$uploadObj = APP::ADP('upload');
		$fileName = $uploadObj->getName();
		$uploadObj->upload('avatarFile',$fileName);
		$rst = $uploadObj->getUploadFileInfo();
		if ($rst['errcode'] != 0) {
			APP::ajaxRst(false, 40002, $rst['errmsg']); exit;
		}else{
			if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
				$saeimg = APP::ADP('image');
				$saeimg->loadFile($rst['webpath']);
				$imgInfo = $saeimg->getImgInfo();
				if ($imgInfo['width'] > 1024) {
					$saeimg->resize(1024,0,true);
					$saeimg->save($fileName);
				}else if($imgInfo['height'] > 1024){
					$imgObj->resize(0,1024,true);
					$imgObj->save($fileName);
				}
				$r['url'] = URL('setting.flashURL','url='.$rst['webpath']);
			}else{
				$pImg = $rst['savepath'];
				if ( !$this->_chkImgType($pImg) ){
					APP::ajaxRst(false, 40010, 'Bad img type!'); exit;
				}
	
				$imgObj = APP::N('images');
				$imgObj->loadFile($pImg);
				$imgInfo = $imgObj->getImgInfo();
				if ($imgInfo['width'] > 1024 || $imgInfo['height'] > 1024 ) {
					$imgObj->resize(1024,1024,true);
					$imgObj->save($pImg);
				}
				$r['url'] = $rst['webpath'];
			}
			/**/
			APP::ajaxRst($r); exit;
		}
	}

	function _chkImgType($p){
		$ext	= strtolower(end(explode('.', $p)));
		$imtT	= getimagesize($p);
		$rExt	= trim(strtolower(end(explode('/',$imtT['mime'] ))));

		if ($rExt=='jpeg') $rExt='jpg';
		if ($ext=='jpeg')  $ext='jpg';
		return $rExt === $ext;
	}

	/// 图像保存 更新到微博<#sae#>
	function saveAvatar(){
		$this->_chkUid();
		$imgData = V('p:uploadField');
		if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
			$avatarFile = 'avatar_tmp_'.$this->uInfo['sina_uid'];
			file_put_contents(SAE_TMP_PATH.$avatarFile,base64_decode($imgData));
	
			$rst = DS('xweibo/xwb.updateProfileImage', '', SAE_TMP_PATH.$avatarFile);
		}else{
			$avatarFile = P_VAR_UPLOAD.'/'.$this->avatarPath.'/avatar_tmp_'.$this->uInfo['sina_uid'].'.jpg';
			IO::write($avatarFile, base64_decode($imgData));
			$rst = DS('xweibo/xwb.updateProfileImage', '', $avatarFile);
		}
		//$this->_chkApiRst($rst, 40050);
		APP::ajaxRst(true);exit;
		
		
		
	}
	

	/// 用户ID检验
	function _chkUid(){
		if ( !V(V_FLASH_PHPSESSID, false) || !USER::isUserLogin() ){
			APP::ajaxRst(false, 40003, 'UID confirm error ');exit;
		}
	}

	/// 检查API结果 如果有错误直接退出 , 并输出错误代码
	function _chkApiRst($v, $err_code=0){
		if (!is_array($v) || !empty($v['error_code']) || !empty($v['error'])) {
			APP::ajaxRst(false, $err_code, $v['error_code'].":".$v['error']);
			exit;
		}
	}

	/*
	 * 设置个人皮肤
	 */
	function setSkin() {
		$skin_id = trim(V('p:skin_id'));
		if(!is_numeric($skin_id)) {
			exit('{"errno":"30001","err":"参数错误！"}');
		}

		$rs = DS('common/userConfig.set', '', 'user_skin', $skin_id);
		if($rs) {
			exit('{"errno":"30001","err":"保存失败！"}');
		}else{
			F('report','skin', 'http');
			exit('{"rst":true,"errno":0,"err":"保存成功！"}');
		}
	}
}
?>
