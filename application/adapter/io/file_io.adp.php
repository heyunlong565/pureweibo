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

class file_io
{
	var $err = "";
	function file_io() {
		
	}

	function adp_init($config=array()) {
		
	}
	
	function write($file, $data, $append = false){
		if (!file_exists($file)){
			if (!$this->mkdir(dirname($file))) return false;
		}
		$len  = false;
		$mode = $append ? 'ab' : 'wb';
		$fp = @fopen($file, $mode);
		if (!$fp) {
			LOGSTR('io', 'fopen file error,file:' . $file);
			exit("Can not open file $file !");
		}
		flock($fp, LOCK_EX);
		$len = @fwrite($fp, $data);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $len;
	}
	
	function read($file) {
		if (!file_exists($file)){
			return false;
		}
		if (!is_readable($file)) {
			LOGSTR('io', 'file can not be read,file:' . $file);
			return false;
		}
		if (function_exists('file_get_contents')){
			return file_get_contents($file);
		}else{
			return (($contents = file($file))) ? implode('', $contents) : false; 
		}
	}
	
	/// get files and dirs not use recursion
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
	
	function mkdir($path) {
		$rst = true;
		if (!file_exists($path)){
			$this->mkdir(dirname($path));
			$rst = @mkdir($path, 0777);
		}
		return $rst;
	}
	
	function rm($path){
		$path = rtrim($path,'/\\ ');
		if ( !is_dir($path) ){ return @unlink($path); }
		if ( !$handle= opendir($path) ){ 
			LOGSTR('io', 'opendir error,dir:' . $path);
			return false; 
		}
		
		while( false !==($file=readdir($handle)) ){
			if($file=="." || $file=="..") continue ;
			$file=$path .DIRECTORY_SEPARATOR. $file;
			if(is_dir($file)){ 
				$this->rm($file);
			} else {
				if(!@unlink($file)){
					LOGSTR('io','delete file error when delete dir,file:'.$file);
					return false;
				}
			}

		}
		closedir($handle);
		if(!rmdir($path)){
			LOGSTR('io', 'delete dir error,dir:'. $path);
			return false;
		}
		return true;
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
