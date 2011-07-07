<?php
/**************************************************
*  Created:  2010-11-25
*
*  weibo皮肤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/


/**
 * weibo皮肤选择
 *
 * @param string $skinCssDirName
 * @param int $skin_id
 * @param array $skin_list
 * @param array $route
 * @return array
 */
function selectSkin($skinCssDirName, $skin_id, $skin_list, $route)
{
	if (!$skinCssDirName){
		switch($route['class']) {
			case 'index':
				$skin_id = USER::cfg('user_skin');
				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
			case 'ta':
				if(trim(V('g:id',0))) {
					$sina_uid = trim(V('g:id',0));
				}else{
					$user_info = DR('xweibo/xwb.getUserShow', '', null, null, urldecode(V('g:name','')), false);
					if($user_info['rst']) {
						$sina_uid = $user_info['rst']['id'];
					}
				}
				if(isset($sina_uid)) {
					$skin_rst = DR('common/userConfig.get', '', 'user_skin', $sina_uid);
					$skin_id = $skin_rst['rst'];
					
				}
				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
			case 'show':
				if (!USER::uid()){
					break;
				}
				$id = trim(V('g:id',0));
				if(isset($id)) {
					$mblog_rst = DR('xweibo/xwb.getStatuseShow', '', $id);
					$mblog_info = $mblog_rst['rst'];
				}
			
				if(isset($mblog_info['user']['id'])) {
					$skin_rst = DR('common/userConfig.get', '', 'user_skin', $mblog_info['user']['id']);
					$skin_id = $skin_rst['rst'];
				}

				if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
					$skinCssDirName =  $skin_list[$skin_id]['directory'];
				}
				break;
		}
	}
	
	if (!$skinCssDirName){
		$skin_id = USER::sys('skin_default');
		if($skin_id && isset($skin_list[$skin_id]) && $skin_list[$skin_id] && !$skin_list[$skin_id]['state']) {
			$skinCssDirName =  $skin_list[$skin_id]['directory'];
		}
		if (!$skinCssDirName){
			$skinCssDirName = SITE_SKIN_CSS_PRE . SITE_SKIN_TYPE;
		}
	}
	$user_skin_config['skin_id'] = $skin_id;
	$user_skin_config['skinCssDirName'] = $skinCssDirName;

	return $user_skin_config;
}

