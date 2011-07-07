<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class disableWeibo_mod extends action {

	function disableWeibo_mod() {
		parent :: action();
	}

	/**
	 * 微博列表
	 */
	function weiboList() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;
		$offset *= $each;
		$rst = DR('xweibo/disableItem.getDisabledByKeyword', '', 1, $keyword, $each, $offset);
		TPL::assign('list', $rst['rst']);

		$rst = DR('xweibo/disableItem.getCount');
		$count = $rst['rst'];
		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		$pager->setVarExtends(array('keyword' => $keyword));
		TPL :: assign('pager', $pager->makePage());

		TPL::assign('offset', $offset);
		TPL :: assign('states', array('0'=>'正常','1'=>'暂停使用'));
		TPL :: display('mgr/weibo/weibo_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的微博
	 */
	function resume() {
		$id = V('r:id');
		$type = V('r:type', false);
		if ($type) {
			$rst = DR('xweibo/disableItem.resumeByItem', '', $id, 1);
			DS('xweibo/weiboCopy.disabled', '', $id, 1);
		} else {
			$wb_ids = DS('xweibo/disableItem.getDisabledItems', '', 1, $id);
			$ids = array();
			foreach ($wb_ids as $key=>$v) {
				$ids[] =  $key;
			}
			if (sizeof($ids)) {
				DS('xweibo/weiboCopy.disabled', '', $ids, 0);
			}
			$rst = DR('xweibo/disableItem.resume', '', $id);
		}
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
		}
		$this->_redirect('weiboList');
	}

	/**
	 * 屏蔽一微博
	 */
	function disable() {
		$ajax = V('g:ajax', false);
		$id = V('g:id', false);
		if (!$id){
			if ($ajax) {
				APP::ajaxRst(false, '1', '缺少参数');
			}
			return;
		}
		
		DR('xweibo/xwb.setToken','', 2);
		$rst = DR('xweibo/xwb.getStatuseShow','', $id);
		$data = $rst['rst'];
		if (isset($data['error_code']) && $data['error_code']) {
			return;
		}
		$values = array(
				'type' => 1,
				'item' => $data['id'],
				'comment' => $data['text'],
				'user' => $data['user']['screen_name'],
				'publish_time' => date('Y-m-d H:i:s', strtotime($data['created_at'])),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_name' => $this->_getUserInfo('screen_name'),
				'admin_id' => $this->_getUid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);
		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems', 'g1/0', 1);
			DR('xweibo/weiboCopy.disabled', '', $id, 1);
			//APP::ajaxRst(true);
			if ($ajax) {
				APP::ajaxRst(true);
			}
			$this->_succ('已成功屏蔽微博', array('weiboList'));
			exit;
		}
		
		if ($ajax) {
			APP::ajaxRst(false, '2','屏蔽微博失败,可能该微博已经在屏蔽列表');
		}
		$this->_error('屏蔽微博失败,可能该微博已经在屏蔽列表', array('weiboList'));
		//APP::ajaxRst(false, 2122202, '屏蔽微博失败,可能该微博已经在屏蔽列表');
	}

	function search() {
		$url = V('r:url');
		if ($url) {
			if (preg_match('!id(-|=)(\d+)!', $url, $match)) {
				$key = $match[2];
				//$key = '639989215';
				DR('xweibo/xwb.setToken','', 2);
				$rst = DR('xweibo/xwb.getStatuseShow','', $key);
				$data = $rst['rst'];
				if (!isset($data['error_code'])) {
					TPL :: assign('info', $data);
				}
			}
		}
		// 列表
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('g:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;

		$rst = DR('xweibo/disableItem.getDisabledByKeyword', 1, $keyword, $each, $offset);
		TPL::assign('list', $rst['rst']);

		$rst = DR('xweibo/disableItem.getCount');
		$count = $rst['rst'];

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		TPL :: assign('pager', $pager->makePage());
		
		TPL :: assign('states', array('0'=>'正常','1'=>'暂停使用'));




		TPL :: display('mgr/weibo/weibo_shield', '', 0, false);
	}
}
