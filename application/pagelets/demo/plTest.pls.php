<?php
/**
 * @file			plTest.pls.php
 * @CopyRight		(C)1996-2099 SINA Inc.
 * @Project			Xweibo
 * @Author			xionghui <xionghui1@staff.sina.com.cn>
 * @Create Date:	2011-01-25
 * @Modified By:	xionghui/2011-01-25
 * @Brief			pagelet　测试文件
 */


class plTest_pls {
	function plTest_pls() {
		$this->debug = !V('G:nodebug',false);
	}
	
	function default_action() {
		echo "reach xpipe";
	}
	
	
	function test($title){
		
		if ($this->debug) usleep(1000000*1.5);//debug
		
		//TPL::module 可调用不同布局的公共模块，通常是　pagelet　模板
		TPL::module('demo/pipeModule',array('title'=>$title));
		return array('cfg_test'=>'cfg_test','test_data'=>'data');
	}
	
	function pg($title=''){
	   
	   	//TPL::plugin　可调用同一布局下的不同布局模板，或者 不通用的　pagelets
	   	TPL::plugin('demo/inc/pipePlug');
	   	
	   	if ($this->debug) usleep(1000000*1);//debug
		return 138138;
	}
	
	
	

}