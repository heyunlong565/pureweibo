<?php
/*
* 工具类库的使用
*/
class demoCls{
	var $rnd = 0;
	function demoCls($v=0) {
		$this->rnd = $v ? $v : rand(1000,9999);
	}
	
	function info() {
		return "I'am in demoCls , rnd=".$this->rnd;
	}
}
