<?php
/**
* 同城微博
*
* @version $1.1: topdayTopic.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/
require_once P_COMS . '/PageModule.com.php';

//今日话题列表ID
define('TODAY_TOPIC_LISTID', 2);

class todayTopic extends PageModule{

	var $component_id = 10;

	var $cfg_cache_time = 300;
	
	var $keyworld_cache_time = 60;

	function topdayTopic() {
		parent :: PageModule();
	}

	/*
	 * 获取当前使用的关键字
	 */
	function getKeyword($group_id, $time = null) {
		$db = $this->db;

		if (!$time) {
			$time =APP_LOCAL_TIMESTAMP;
		}

		$rs = $db->getOne('select topic from ' . $db->getTable(T_TODAY_TOPICS) . ' where effect_time<='.$time . ' and group_id=' . $group_id . ' order by effect_time desc limit 1');

		return RST($rs);
	}

	/**
	 * 获取与今日话题相关的微博
	 *
	 * @return array array('keyword' => 'xxx', 
	 */
	function get() {

		$cfg = $this->configList();

		//$kw_group = &$cfg['group_id'];

		//最多显示Ｎ条, 普通用户接口返回最多２０条
		$show_num = &$cfg['show_num'];

/*
		$kw = DR('components/todayTopic.getKeyword', $this->keyworld_cache_time, $kw_group);
		$kw = $kw['rst'];
*/		

		//话题列表
		$topics = DS('xweibo/topics.getTopicByCty', '', TODAY_TOPIC_LISTID);
		if (empty($topics)) {
			return RST(false, 11002, '关键字列表为空');
		}

		//根据生效时间排序
		function sortTopicByTime(&$b, &$a) {
			return $b['ext1'] - $a['ext1'];
		}

		uasort($topics, 'sortTopicByTime');

		$now = time();

		$kw = '';

		//计算当前的关键字
		foreach ($topics as $i => $tp) {

			if ($tp['ext1'] - $now >= 0) {
				$kw = $tp['topic'];

				if (isset($topics[$i+1])) {
					$kw = $topics[$i+1]['topic'];
				}

				break;
			}
		}

		if (!$kw) {
			$last = end($topics);
			$kw = $last['topic'];
		}

		$list = DR('xweibo/xwb.searchStatuse', null, array('q' => $kw, 'rpp' => $show_num, 'page' => 1), false);

		//结果集处理:　只要show_num条内容
		if ($list['errno'] == 0) {
			if ( count($list['rst']) > $show_num ) {
				$list['rst'] = array_slice($list['rst'], 0, $show_num);
			}

			$errno = 0;
		} else {
			$errno = $list['errno'];
		}


		return RST(array(
			'errno' => $errno,
			'keyword' => $kw,
			'data' => $list
		));

	}
}