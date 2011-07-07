<?php
include('action.abs.php');

//分类用户推荐分组ID
define('USER_CATEGORY_RECOMMEND_ID', 1);

class components_mod extends action {
	
	var $titleCanSet = array(2, 6, 7, 8, 9, 10);

	//ID ->　组件类的映射
	var $nameMap = array(
			'1' => 'hotWB',
			'2' => 'star',
			'3' => 'recommendUser',
			'4' => 'concern',
			'5' => 'officialWB',
			'6' => 'hotTopic',
			'7' => 'guessYouLike',
			'8' => 'cityWB',
			'9' => 'pubTimeline',
			'10' => 'todayTopic',
			'11' => 'categoryUser'
		);

	function components() {
		parent :: action();
	}

	function default_action() {
		$components = DS('PageModule.listModules');

		$plugins = DS('Plugins.getList');

		TPL::assign('plugins', $plugins);

		TPL::assign('components', $components);

		$this->_display('components_list');
	}

	/**
	 * 显示组件设置
	 *
	 */
	function config() {
		$id = V('g:id');

		if ($id) {
			$cfg = DS('PageModule.configList', null, true, $id);
			$com = DS('PageModule.getComponent', null, $id);
		}

		TPL::assign('id' , $id);
		TPL::assign('cfg', $cfg);
		TPL::assign('com', $com);

		TPL::assign('titleCanSet', $this->titleCanSet);

		switch ($id) {
			case 11:
				$list =  DS('mgr/userRecommendCom.getById');
				TPL::assign('list', $list);
				
				$itemGroup = APP::N('itemGroups');

				$groups = $itemGroup->getItems(USER_CATEGORY_RECOMMEND_ID);

				TPL::assign('groups', $groups);

				$this->_display('components_config_cate');
			break;

			default:
				$this->_display('components_config');
		}
	}

	/**
	 * 用户分组推荐异步处理接口
	 *
	 */
	function itemgroup() {
		$op = V('p:op'); //操作:add, del, edit

		$item_id = V('p:item_id');
		$item_name = V('p:item_name');
		$id = V('p:id');

		$itemgroup = APP::N('itemGroups');

		$result = '';
		$errno = 0;

		switch ($op){
			case 'add':
					if ($itemgroup->hasItem(USER_CATEGORY_RECOMMEND_ID, $item_id)) {
						$result = false;
						$errno = 11013;
					} else {
						$obj = new stdClass();
						$obj->group_id = USER_CATEGORY_RECOMMEND_ID;
						$obj->item_id = $item_id;
						$obj->item_name = $item_name;

						$result = $itemgroup->addItem($obj);

						if ($result) {
							DS('mgr/userRecommendCom.addRelatedId', '', $item_id, 11, 1);
						}
					}
			break;

			case 'del':
				$g = $itemgroup->getItem($id);

				$result = $itemgroup->delItem($id);

				if ($result && !empty($g)) {
					//维护引用关系
					DS('mgr/userRecommendCom.delRelatedId', '', $g['item_id'], 11, 1);
				}
			break;

			case 'edit':
				$obj = new stdClass();
				$obj->group_id = USER_CATEGORY_RECOMMEND_ID;
				$obj->item_id = $item_id;
				$obj->item_name = $item_name;

				$result = $itemgroup->saveItem($obj, $id);
			break;
		}

		if ($result) {
			DD('components/categoryUser.getGroups');
		}

		APP::ajaxRst($result, $errno);
		exit;
	}

	/**
	 * 设置组件配置
	 *
	 */
	function set() {
		$id = V('p:id');

		$saveTitle = in_array($id, $this->titleCanSet);

		//保存title
		if ($saveTitle) {
			$title = trim(V('p:title', ''));
			DR('PageModule.update', null, array('title' => $title), $id);
		}

		//保存显示条数
		$show_num = V('p:show_num');

		$com = 'components/' . $this->nameMap[$id];

		if ($show_num) {
			$numResult = DR($com . '.config', null, 'show_num', $show_num);
		}

		$cache_key = 'get';

		switch ($id) {
			case 1:
				$cache_key = array('getRepost', 'getComment');
				break;

			case 3:
				$group_id = V('p:group_id');
				$oldId = '';
				$set = false;

				//查询现在使用的
				$old = DS($com . '.config', null, 'group_id');

				if ($old) {
					$oldId = $old[0]['cfgValue'];

					//如果更改了
					if ($oldId && ($oldId != $group_id)) {
						$set = true;
						DS('mgr/userRecommendCom.delRelatedId', '', $oldId, $id, 1);
					}
				} else {
					$set = true;
				}

				if ($set){
					DS($com . '.config', null, 'group_id', $group_id);
					DS('mgr/userRecommendCom.addRelatedId', '', $group_id, $id, 1);
				}

				break;

			case 6:
				$type = V('p:topic_get');
				
				if ($type == 1) {
					$topic_id = '0';
				} else {
					$topic_id = V('p:topic_id');
				}
				DS($com . '.config', null, 'topic_id', $topic_id);

				break;

			
		}

		//清除配置缓存
		DR($com . '.clearCfgCache');

		//清除数据缓存
		if ($cache_key) {
			if (is_array($cache_key)) {
				foreach($cache_key as $key) {
					DD($com . '.' . $key);
				}
			} else {
				DD($com.'.'.$cache_key);
			}
		}

		$this->_succ('操作已成功', array('default_action'));
	}
}
