<?php
/**************************************************
*  Created:  2010-06-08
*
*  memcached缓存
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class memcache_cache
{
	var $enable;
	var $obj;
	var $keyPre;

	function memcache_cache() {
	}

	function adp_init($config=array()) {
		if(!empty($config['servers'])) {
			$this->obj = new Memcache;

			$servers = explode(' ', trim($config['servers']));

			$connect = false;

			foreach ($servers as $server) {
				if (empty($server)) {
					continue;
				}

				$param = explode(':', $server);

				$connect = $connect || @$this->obj->addServer($param[0], $param[1], $config['pconnect']);

			}

			$this->enable = $connect ? true : false;
			$this->keyPre = $config['keyPre'];
		}
	}

	function get($key) {
		$key = $this->_feaKey($key);
		return $this->obj->get($key);
	}

	function set($key, $value, $ttl = 0) {
		$key = $this->_feaKey($key);
		return $this->obj->set($key, $value, MEMCACHE_COMPRESSED, $ttl);
	}

	function delete($key) {
		$key = $this->_feaKey($key);
		return $this->obj->delete($key);
	}
	
	function _feaKey($key) {
		return $this->keyPre . $key;
	}	
}

?>