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
	$templates = array('error_busy', 'error_force','error_rest');
	$index = rand(0, sizeof($templates) - 1);
	TPL::display($templates[$index]);
	exit;
}

