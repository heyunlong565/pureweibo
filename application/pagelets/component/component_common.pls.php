<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 各类模块通用pipe
 * @author yaoying
 * @version $Id: component_common.pls.php 11480 2011-03-14 01:04:13Z yaoying $
 *
 */
class component_common_pls extends component_abstract_pls{
	
	/**
	 * 获取热门微博
	 */
	function hotWB_getComment($mod){
		//目前没有基于APPKEY的热门微博信息，故强制设置为0
		$mod['param']['source'] = 0;
		
		parent::run($mod);
		
		$comments = DR('components/hotWB.getComment', 'g/300', $mod['param']);
		if ($comments['errno'] == 0 && !empty($comments['rst'])) {
			$header = isset($mod['header']) ? $mod['header'] : null;
			TPL::module('feedlist', array('list' => (array)$comments['rst'], 'header' => $header));
			return array('cls'=>'wblist', 'list' =>F('format_weibo',$comments['rst']) );
		}elseif($comments['errno'] == 0) {
			$this->_show('还没有热门微博。');
			return ;
		}else{
			if(defined('IS_DEBUG') && IS_DEBUG){
				$this->_error('components/hotWB.getComment 返回API错误：'. $comments['err']. '('. $comments['errno']. ')');
			}else{
				$this->_show('获取热门微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!');
			}
			return ;
		}
	}
	
	/**
	 * 获取热门转发
	 */
	function hotWB_getRepost($mod){
		//目前没有基于APPKEY的热门微博信息，故强制设置为0
		$mod['param']['source'] = 0;
		
		parent::run($mod);
		
		$repost = DR('components/hotWB.getRepost', 'g/300', $mod['param']);
		if ($repost['errno'] == 0 && !empty($repost['rst'])) {
			$header = isset($mod['header']) ? $mod['header'] : null;
			TPL::module('feedlist', array('list' => (array)$repost['rst'], 'header' => $header));
			return array('cls'=>'wblist', 'list' =>F('format_weibo',$repost['rst']) );
		}elseif($repost['errno'] == 0) {
			$this->_show('还没有热门微博。');
			return ;
		}else{
			if(defined('IS_DEBUG') && IS_DEBUG){
				$this->_error('components/hotWB.getRepost 返回API错误：'. $repost['err']. '('. $repost['errno']. ')');
			}else{
				$this->_show('获取热门微博信息失败，请<a href="#" rel="e:rl">刷新</a>再试!');
			}
			return ;
		}
	}
	
	function _show($msg){
		echo '<div class="int-box load-fail icon-bg">'. $msg. '</a></div>';
	}
	
}