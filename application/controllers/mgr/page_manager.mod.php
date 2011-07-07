<?php
include('action.abs.php');
class page_manager_mod extends action {
	var $pm = null;

	function page_manager_mod() {
		parent :: action();
		$this->pm = APP::N('pageManager');
	}

	function default_action() {

		$list = $this->pm->get();

		TPL::assign('pages', $list);

		$this->_display('pagelist');
	}

	/**
	 * 页面组件开关设置
	 *
	 */
	function set() {
		$page_id = V('g:page_id');
		$component_id = V('g:c');
		$use = V('g:use');

		if ($page_id && $component_id){
			$result = $this->pm->onOff($page_id, $component_id, $use);

			if ($result) {
				DD('PageModule.getPageModules');
			}
		}

		APP::redirect(URL('mgr/page_manager.setting', array('id'=>$page_id)), 3);
	}

	/** 
	 * 保存排序
	 *
	 *
	 */
	function savesort() {
		$ids = V('p:ids');
		$page_id = V('g:page_id');
		$pos = V('g:pos');

		$manager = APP::N('pageManager');

		$result = $manager->setSort($ids, $page_id, $pos);

		APP::ajaxRst($result, $result ? 0: 1);
		exit;
	}

	function setting() {
		$page_id = V('g:id');

		if (!$page_id) {
			exit('param page_id missing');
		}

		$page = DS('PageModule.getPage', '', $page_id);

		$list = DS('PageModule.getPageModules', '', $page_id);

		$modules = DR('PageModule.groupByPos', '', $list, null);

		TPL::assign('page_id', $page_id);
		TPL::assign('page', $page);
		TPL::assign('main_modules', isset($modules[1]) ? $modules[1]:null);
		TPL::assign('side_modules', isset($modules[2]) ? $modules[2]:null);

/*
		echo "<pre>";
		var_dump($components);
		echo "</pre>";
		exit;
*/
		$this->_display('page_setting');

	}
}
