<?php
/**************************************************
*  Created:  2010-06-08
*
*  eaccelerator缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class eaccelerator_cache
{
	
	function eaccelerator_cache() {

	}

	function adp_init($config=array()) {

	}

	function get($key) {
		return eaccelerator_get($key);
	}

	function set($key, $value, $ttl = 0) {
		return eaccelerator_put($key, $value, $ttl);
	}

	function delete($key) {
		return eaccelerator_rm($key);
	}

}

?>