<?php
/**
 * 模块pipe基础类
 * @author yaoying
 * @version $Id: component_abstract.pls.php 10966 2011-03-01 11:38:00Z yaoying $
 *
 */
class component_abstract_pls {
	
	/**
	 * component参数，使用run方法进行传入
	 * @var unknown_type
	 */
	var $mod = array();
	
	/**
	 * 在前台运行一个模块
	 * @param array $mod
	 */
	function run($mod){
		$this->mod = $mod;
	}
	
	/**
	 * 输出一个模块错误信息
	 * @param string $msg
	 * @param bool $force 强制输出？否的话受到IS_DEBUG限制
	 */
	function _error($msg = '未填写问题原因', $force = false){
		if(true != $force && (!defined('IS_DEBUG') || !IS_DEBUG)){
			return null;
		}
		$title = isset($this->mod['title']) ? F('escape', (string)$this->mod['title']) : '未知模块';
		$component_id = isset($this->mod['component_id']) ? (int)$this->mod['component_id'] : -999;
		echo "<div class='int-box load-fail icon-bg'>{$title}（模块ID：{$component_id}）遇到问题：{$msg}</div>";
	}
	
}