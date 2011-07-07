<?php
/**
 * @file			report.func.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			heli <heli1@staff.sina.com.cn>
 * @Create Date:	2010-11-15
 * @Modified By:	heli/2010-11-15
 * @Brief			Xweibo统计上报处理方法
 */

function report($type = 'idx', $way = 'src', $tauid = null)
{
	$params = array();
	$params['akey'] = WB_AKEY;
	$params['pjt'] = WB_PROJECT;
	$params['ver'] = WB_VERSION;
	$params['random'] = mt_rand();
	switch ($type) {
		case 'idx':
		case 'me':
		case 'ta':
		case 'pub':
			$params['xt'] = 'pv';
			$params['p'] = $type;
			if (USER::uid()) {
				$params['uid'] = USER::uid();
			} elseif (isset($_COOKIE['x3w4b'])) {
				$params['uid'] = $_COOKIE['x3w4b'];
			}
			if ($tauid) {
				$params['taid'] = $tauid;	
			}
			break;
		case 'login':
		case 'logout':
			$params['xt'] = $type;
			$params['akey'] = WB_AKEY;
			$params['uid'] = USER::uid();
			$params['ip'] = F('get_client_ip');
			break;
		case 'skin':
			$params['xt'] = $type;
			$params['uid'] = USER::uid();
			break;
		case 'register':
			$params['xt'] = $type;
			$params['name'] = WB_USER_SITENAME;
			$params['content'] = WB_USER_SITEINFO;
			$params['uname'] = WB_USER_NAME;
			$params['em'] = WB_USER_EMAIL;
			$params['qq'] = WB_USER_QQ;
			$params['msn'] = WB_USER_MSN;
			$params['tel'] = WB_USER_TEL;
			$params['domain'] = V('s:HTTP_HOST');
			break;
	}

	if ($params) {
		$params = http_build_query($params);
		$url = 'http://beacon.x.weibo.com/a.gif?'.$params; 

		/// 如果是后端上报，使用http类发http请求
		if ($way == 'http') {
			$http = APP::ADP('http');
			$http->setUrl($url);
			$http->request();
			return true;
		}
		return $url;
	}
	return false;
}
