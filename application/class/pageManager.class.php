<?php
class pageManager {
	var $db = null;

	function pageManager() {
		$this->db = APP::ADP('db');
		$this->db->setTable(T_PAGES);
	}

	/** 
	 * 设置页面中某一组件的开关状态
	 *
	 */
	function onOff($page_id, $component_id, $on = null) {
		$sql = 'update ' . $this->db->getTable(T_PAGE_MANAGER) . ' set in_use=' . (int)$on . ' where page_id=' . $page_id . ' and component_id=' . $component_id;

		return $this->db->execute($sql);
	}

	/**
	 * 根据ID获取页面
	 * @param $page_ids array|int|null 
	 *
	 */
	function get($page_ids = null) {

		$sql = 'select * from ' . $this->db->getTable();

		if (!is_null($page_ids)) {
			if (is_array($page_ids)) {
				$sql .= ' where page_id in(' . join(',', $page_ids) .')';
			} elseif (is_int($page_ids)) {
				$sql .= ' where page_id=' . $page_ids;
			}
		}

		return $this->db->query($sql);
	}

	/**
	 * 设置组件的排序
	 *
	 */
	function setSort($component_ids, $page_id, $pos) {
		if (empty($component_ids)) {
			return false;
		}

		$db = $this->db;

		$sql = 'update ' . $db->getTable(T_PAGE_MANAGER) . ' set ';

		$findstr = join(',', $component_ids);

		$sql .= 'sort_num=find_in_set(component_id, "' . $db->escape($findstr) . '")';
		$sql .= ' where page_id=' . (int) $page_id . ' and position='.(int)$pos;

		return $db->execute($sql);

	}

}