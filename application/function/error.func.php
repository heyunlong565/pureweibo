<?php
function error($msg = '', $display = false) {
	ob_clean();
	if (defined('IS_DEBUG') && IS_DEBUG || $display) {
		//@todo 显学错误贪睡 
		TPL::assign('msg', $msg);
		//TPL::display('');
		echo $msg;
		exit;
	}
	
	if (Xpipe::isRunning()) {
		echo '<div class="api-error"><p>' . ($msg ? $msg : '服务器忙，请<a href="javascript:window.location.reload()">刷新</a>重试') . '</p></div>';
	} else {
		//$templates = array('error_busy', 'error_force','error_rest');
		//$index = rand(0, sizeof($templates) - 1);
		//TPL::display($templates[$index]);
		TPL::module('error_busy');
	}
	exit;
}