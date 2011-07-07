<?php
/**************************************************
*  Created:  2010-06-08
*
*  框架兼容类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
//JSON LIB
if (!function_exists('json_decode')){
	function json_decode($s, $ass = false){
		$assoc = ($ass) ? 16 : 32;
		$gloJSON = APP::N('servicesJSON', $assoc);

		return $gloJSON->decode($s);
	}
}

if (!function_exists('json_encode')){
	function json_encode($s){
		$gloJSON = APP::O('servicesJSON');

		return $gloJSON->encode($s);
	}
}

if (!function_exists('hash_hmac')) {
	function hash_hmac($algo, $data, $key, $raw = false) {
		if (empty($algo)) {
			return false;
		}
		switch ($algo) {
			case 'md5':
				return mhash(MHASH_MD5, $data, $key);
				break;
			case 'sha1':
				return mhash(MHASH_SHA1, $data, $key);
				break;
		}
	}
}

if (!function_exists('array_combine')) {
	function array_combine( $keys, $values ) {
	   if( !is_array($keys) || !is_array($values) || empty($keys) || empty($values) || count($keys) != count($values)) {
		 trigger_error( "array_combine() expects parameters 1 and 2 to be non-empty arrays with an equal number of elements", E_USER_WARNING);
		 return false;
	   }
	   $keys = array_values($keys);
	   $values = array_values($values);
	   $result = array();
	   foreach( $keys as $index => $key ) {
		 $result[$key] = $values[$index];
	   }
	   return $result;
	}
}

if (!function_exists('file_get_contents')) {
   function file_get_contents($filename) {	
		$isUrl = count(explode("://",$filename)) > 1;
		if ($isUrl){
			$http = APP::ADP('http');
			$http->setUrl($filename);
			return $http->request();
		}else{
			return IO::read($filename);
		}
	}
}



if (!function_exists('http_build_query')) { 
	function http_build_query($data, $prefix='', $sep='', $key='') { 
	    $ret = array(); 
	    foreach ((array)$data as $k => $v) { 
	        if (is_int($k) && $prefix != null) { 
	            $k = urlencode($prefix . $k); 
	        } 
	        if ((!empty($key)) || ($key === 0))  $k = $key.'['.urlencode($k).']'; 
	        if (is_array($v) || is_object($v)) { 
	            array_push($ret, http_build_query($v, '', $sep, $k)); 
	        } else { 
	            array_push($ret, $k.'='.urlencode($v)); 
	        } 
	    } 
	    //if (empty($sep)) $sep = ini_get('arg_separator.output'); 
	    $sep = '&';
		return implode($sep, $ret);
	}
}

if (!function_exists('mb_strwidth')) {
	function mb_strwidth($str, $encoding) {
		$str = F('xwb_iconv', $encoding, 'gbk');
		return strlen($str);
	}
}

/// Xweibo 为适应SAE的可兼容　ini_set　
function xwb_ini_set($var,	$value){
	if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
		//todo
	}else{
		return ini_set($var,$value);
	}
}

/// Xweibo 为适应SAE的可兼容　ini_get　
function xwb_ini_get($k){
	if (strtolower(XWB_SERVER_ENV_TYPE)==='sae'){
		//todo
	}else{
		return ini_get($var,$value);
	}
}
