<?php
/**************************************************
*  Created:  2010-06-08
*
*  文件IO操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class saefile_io
{
	var $err = "";
	var $storage;
	function saefile_io() {
		$this->storage = new SaeStorage();
	}
	
	function adp_init($config=array()) {
		
	}
	
	function write($file, $data, $append = false){
		$len = $this->storage->write(SAE_DOMAIN,md5($file),$data);
		return $len;
	}
	
	function read($file) {
		return $this->storage->read(SAE_DOMAIN,md5($file));
	}
	function ls($dir,$r=false,$info=false) {
		if (empty($dir)) $dir = '.';
		if(!file_exists($dir) || !is_dir($dir)){return false;}
		$fs = array();
		$ds = array($dir);
		while(count($ds)>0){
			foreach($ds as $i=>$d){
				unset($ds[$i]);
				$handle = opendir($d);
				while (false !== ($item = readdir($handle))) {
					if ($item == '.' || $item == '..') continue;
					$fp = ( $d=='.' || $d=='.\\' ||  $d=='./'  ) ? $item :  $d.DIRECTORY_SEPARATOR.$item;
					$t =  is_file($fp) ? 'f' : (is_dir($fp) ? 'd' : 'o');
					if (is_dir($fp) && $r) { $ds[]=$fp; }
					$fs[] = ($info ? array($t,$fp,$this->info($fp)) : array($t,$fp));
				}
			}
		}
		return $fs;
	}
	function info($path=".",$key=false) {
		$path = realpath($path);
		if (!$path) false;
		$result = array(
			"name"		=> substr($path, strrpos($path, DIRECTORY_SEPARATOR)+1),
			"location"	=> $path,
			"type"		=> is_file($path) ? 1 : (is_dir($path) ? 0 : -1),
			"size"		=> filesize($path),
			"access"	=> fileatime($path),
			"modify"	=> filemtime($path),
			"change"	=> filectime($path),
			"read"		=> is_readable($path),
			"write"		=> is_writable($path)
			);
		clearstatcache();
		return $key ? $result[$key] : $result;
	}
}
?>