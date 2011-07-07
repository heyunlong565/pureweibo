<?php
/**************************************************
*  Created:  2010-06-08
*
*  头像url
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

/**
 * profile image url
 *
 * @param string $url
 * @param string $type
 * @return string
 */
function profile_image_url($url, $type = 'index')
{
	if (strpos($url, 'http') === false) {
		$id = $url % 4 + 1;
		if ($type == 'index') {
			$size = 50;
		} elseif ($type == 'comment') {
			$size = 30;
		} elseif ($type == 'profile') {
			$size = 180;
		}
		$url = 'http://tp'.$id.'.sinaimg.cn/'.$url.'/'.$size.'/'.date('Ymd', APP_LOCAL_TIMESTAMP);
		return $url;
	} else {
		switch ($type) {
			case 'comment':
				$urls = explode('/', $url);
				$urls[4] = 30;
				$url_new = implode('/', $urls);
				break;
			case 'profile':
				$urls = explode('/', $url);
				$urls[4] = 180;
				$url_new = implode('/', $urls);
				break;
			default:
				$url_new = $url;
		}
		return $url_new;
	}
}