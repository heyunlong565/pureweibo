<?php

include(P_ADMIN_MODULES . '/action.abs.php');
class disableComment_mod extends action {

	function disableComment_mod() {
		parent :: action();
	}

	/**
	 * 微博列表
	 */
	function commentList() {
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$keyword = V('r:keyword', null);

		$offset = $page - 1 >= 0 ? $page - 1: 0;
		$offset *= $each;
		$rst = DR('xweibo/disableItem.getDisabledByKeyword', '', 2, $keyword, $each, $offset);
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
		TPL :: display('mgr/weibo/comment_list', '', 0, false);
	}

	/**
	 * 恢复被屏蔽的回复
	 */
	function resume() {
		$id = V('r:id');
		// 得到微博ID
		//$rst = DR('xweibo/disableWeibo.getDisabledWeiboId', '', $id);
		//$rst['rst'];
		$type = V('r:type', false);
		if ($type) {
			$rst = DR('xweibo/disableItem.resumeByItem', '', $id, 2);
		} else {
			$rst = DR('xweibo/disableItem.resume', '', $id);
		}
		if ($rst['rst'] && $rst['rst'] > 0) {
			// 删除缓存
			DD('xweibo/disableItem.getDisabledItems');
		}
		$this->_redirect('commentList');
	}

	/**
	 * 屏蔽一微博
	 */
	function disable() {
		$values = array(
				'type' => 2,
				'item' =>V('p:id'),
				'comment' => V('p:text'),
				'user' => V('p:user'),
				'publish_time' => V('p:created_at'),
				'add_time' =>APP_LOCAL_TIMESTAMP,
				'admin_name' => $this->_getUserInfo('screen_name'),
				'admin_id' => $this->_getUid()
				);
		$rst = DR('xweibo/disableItem.save', '', $values);

		// 添加成功则更新缓存
		if ($rst['rst'] > 0) {
			DD('xweibo/disableItem.getDisabledItems');
			APP::ajaxRst(true);
			exit;
		}
		APP::ajaxRst(false, 2122203, '屏蔽回复失败,可能已经被屏蔽');
	}

	function search() {
		$url = V('r:url');
		if ($url) {
			$url = urldecode($url);
			if (preg_match('!id(-|=)(\d+)!', $url, $match)) {
				$page = V('g:page', 1);
				if ($page < 1) {
					$page = 1;
				}
				$each = 15;
				$key = $match[2];

				$sum = V('g:sum', false);
				if (!$sum) {
					$rst = DR('xweibo/xwb.getCounts', '', $key);
					$sum = $rst['rst'][0]['comments'];
				}

				$pager = APP :: N('pager');
				$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $sum, 'linkNumber' => 10);
				$pager->setParam($page_param);
				$varExtends = array(
							'sum' => $sum,
							'url' => urlencode($url)
							);
				$pager->setVarExtends($varExtends);
				TPL :: assign('pager', $pager->makePage());
				//$key = '639989215';
				DR('xweibo/xwb.setToken','', 2);
				$rst = DR('xweibo/xwb.getComments','', $key, $each, $page);
				$data = $rst['rst'];
				if (!isset($data['error_code'])) {
					TPL :: assign('info', $data);
				}
			}
		}
		TPL :: display('mgr/weibo/comment_shield', '', 0, false);
	}
}
