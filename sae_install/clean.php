<?php

//权限检验
$secret = md5(SAE_ACCESSKEY.SAE_SECRETKEY);
if(!isset($_REQUEST['secret']) || empty($_REQUEST['secret']) || trim($_REQUEST['secret']) !== $secret) exit;

/*
$s = new SaeStorage;

define('SAE_DOMAIN', 'xweibo');
define('CONFIG_DOMAIN',     'config');

//删除storage中对应的配置文件
$filename = md5('config');
$s->delete(CONFIG_DOMAIN,$filename);
$s->delete(SAE_DOMAIN,$filename);
*/
//清空MC


$mc = @memcache_init();
if($mc) $mc->flush();
