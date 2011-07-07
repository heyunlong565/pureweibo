<?php
function err404($msg = '') {
	ob_clean();
	//$funDebug = 1;
	if (defined('IS_DEBUG') && IS_DEBUG) {
		trigger_error($msg);
		exit;
	}
	APP::tips(array('tpl' => 'e404', 'msg' => '你访问的页面不存在'));
	exit;
}

