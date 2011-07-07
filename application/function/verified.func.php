<?php
/**
 * @file			verified_func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			认证处理函数-Xweibo
 */


/**
 * 用户认证
 *
 * @param array $user
 * @return tool	
 */
function verified($user, $type = 'feed') 
{
	if (V('-:sysConfig/authen_enable') == 1) {	
		/// 加v html
		if ('feed' == $type) {
			$authen_small_icon = V('-:sysConfig/authen_small_icon') ? V('-:sysConfig/authen_small_icon') : AUTH_SMALL_ICON_DEFAULT_NAME;
			$title = V('-:sysConfig/authen_small_icon_title') ? F('escape', V('-:sysConfig/authen_small_icon_title')) : F('escape', V('-:sysConfig/site_name')).'认证';
			$verified_html = '<img src="'.F('fix_url', $authen_small_icon).'" alt="'.$title.'" title="'.$title.'" />';
		} else {
			$authen_big_icon = V('-:sysConfig/authen_big_icon') ? V('-:sysConfig/authen_big_icon') : AUTH_BIG_ICON_DEFAULT_NAME;
			$title = V('-:sysConfig/authen_small_icon_title') ? F('escape', V('-:sysConfig/authen_small_icon_title')) : F('escape', V('-:sysConfig/site_name')).'认证';
			$verified_html = '<div class="vip-card"><img src="'.F('fix_url', $authen_big_icon).'" alt="'.$title.'" title="'.$title.'" /></div>';
		}
		/// 站点特定认证
		if (isset($user['site_v']) && $user['site_v']) {
			return $verified_html;
		}
	} else {
		if ('feed' == $type) {
			$verified_html = '<img src="'.F('fix_url', AUTH_SMALL_ICON_DEFAULT_NAME).'" alt="新浪认证" title="新浪认证" />';
		} else {
			$verified_html = '<div class="vip-card"><img src="'.F('fix_url', AUTH_BIG_ICON_DEFAULT_NAME).'" alt="新浪认证" title="新浪认证" /></div>';
		}
		/// sina认证
		if (isset($user['verified']) && $user['verified']) {
			return $verified_html;
		}
	}
	return false;

}
