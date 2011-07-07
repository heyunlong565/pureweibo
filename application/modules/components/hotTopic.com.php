<?php
/**
* ���Ż���
*
* @version $1.1: hotTopic.com.php,v 1.0 2010/10/23 22:04:00 $
* @package xweibo
* @copyright (C) 2009 - 2010 sina.com.cn
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* @author guoliang <g17254172@gmail.com>
*
*/

require_once P_COMS . '/PageModule.com.php';

class hotTopic extends PageModule{

	var $component_id = 6;

	function hotTopic() {
		parent :: PageModule();

		//���δ��¼��ʹ�ù���Ա��token����
		if (!USER::uid()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
	}

	/**
	 * 
	 *
	 */
	function get() {
//		$this->clearCfgCache();
		$cfg = $this->configList();
		
		$topic_id = $cfg['topic_id'];

		$show_num = $cfg['show_num'] > 0? (int)$cfg['show_num']: 10;

		//��ʾʹ�ñ��������б�
		if ($topic_id > 0) {
			//$db = $this->db;
			//$rs = $db->query('select * from ' . $db->getTable(T_COMPONENT_TOPIC) . ' where topic_id=' . (int)$topic_id . ' order by sort_num asc limit '. $show_num);
			$rs = DR('xweibo/topics.getTopicByCty', '', $topic_id, $show_num);

			return $rs;

		} else { //����ʹ������API
			$rs =DR('xweibo/xwb.getTrendsDaily');

			if ($rs['errno'] == 0) {
				$tmp = array();
				$count = 0;

				foreach (current($rs['rst']['trends']) as $row) {
					if (++$count > $show_num) {
						break;
					}

					array_push($tmp, array('topic' => $row['name'], 'query' => $row['query']));
				}

				return RST($tmp);
			}

			return $rs;

		}

	}
}