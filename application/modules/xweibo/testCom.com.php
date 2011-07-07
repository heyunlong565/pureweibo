<?php
class testCom {
	var $ver;
	function testCom(){
		echo 'testCom 被初始化了.......<hr color=red>',"\n";
	}
	function set($v){
		$this->ver = $v;
	}
	function v(){
		return RST($this->ver);
	}
	
	function get($n=10){
		echo 'testCom.get 被调用了...',"\n";
		if ($n<1){
			return RST(false,$errno=100004,$err='参数 $n 不能小于1');
		}else{
			$rst = range(1,$n);
			return RST($rst,$errno=0,$err='');
		}
		
	}
}

?>