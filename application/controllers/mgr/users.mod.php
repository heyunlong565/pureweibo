<?php
include('action.abs.php');
class users_mod extends action {
	function users_mod() {
		parent :: action();
	}

    /*
     * 用户解，封禁操作
     */
	function ban() {
		$is_ban = (int)V('g:ban',0);
        $sina_uid = (int)V('g:id',0);
		$p = V('g:p','');

        //如果为封禁操作
        if($sina_uid) {
			if($is_ban) {
				$rs = DR('mgr/userCom.getBanByUid', '', $sina_uid);
				if($rs['rst']) {
					$this->_error('该用户已被封禁！', URL('mgr/users.search'));
                }

				if($p == 'ban') {
					$rs = DR('xweibo/xwb.getUserShow', '', $sina_uid);		//屏蔽站外用户
					if(!$rs['rst']) {
						$this->_error('该用户不存在！', URL('mgr/users.search'));
					}
					$nickname = $rs['rst']['screen_name'];
				}else{
					$rs = DR('mgr/userCom.getByUid', '', $sina_uid);		//屏蔽站内用户
					if(!$rs['rst']) {
						$this->_error('该用户不存在！', URL('mgr/users.search'));
					}
					$nickname = $rs['rst']['nickname'];
				}

                $data = array(
                               'sina_uid' => $sina_uid,
                               'ban_time' => APP_LOCAL_TIMESTAMP,
							   'nick' => $nickname
						);
				$rs = DR('mgr/userCom.saveBan', '', $data);
                if(!$rs['rst']) {
                     $this->_error('操作失败！', URL('mgr/users.search'));
                }
             }else{      //为解禁操作
				 $rs = DR('mgr/userCom.getBanByUid', '', $sina_uid);
                 if(!$rs['rst']) {
                     $this->_error('该用户已解禁！', URL('mgr/users.search'));
                 }

				 $rs = DR('mgr/userCom.delBan', '', $sina_uid);
                 if(!$rs['rst']) {
                     $this->_error('操作失败！', URL('mgr/users.search'));
                 }
             }
		}
        if($p == 'ban') {
			$this->_succ('操作已成功', array('getBanUser'));
		}else{
			$this->_succ('操作已成功', array('search'));
		}
	}

   /*
    * 用户认证操作（给用户加V）
    */
	function authentication() {
		$is_v = (int)V('g:v',0);
        $id = V('g:id',0);
        $nick = urldecode(V('g:nick',0));

        
        if($id) {
             if($is_v && $nick) {		//授予认证操作
				  $rs = DR('mgr/userCom.getVerifyById', '', $id);
                  if($rs['rst']) {
						$this->_error('该用户已被认证！', URL('mgr/users.search'));
                  }

                  $data = array(
                                  'sina_uid' => $id,
                                  'nick' => $nick,
                                  'add_time' => APP_LOCAL_TIMESTAMP,
                                  'operator' => USER::uid(),
                   );

				  $rs = DR('mgr/userCom.saveVerify', '', $data);
                  if(!$rs['rst']) {
                        $this->_error('操作失败！', URL('mgr/users.search'));
                  }
              }else{      //取消认证操作
				  $rs = DR('mgr/userCom.getVerifyById', '', $id);
                  if(!$rs['rst']) {
						$this->_error('该用户已取消认证！', URL('mgr/users.search'));
                  }

				  $rs = DR('mgr/userCom.delVerify', '', $id);
                  if(!$rs['rst']) {
                        $this->_error('操作失败！', URL('mgr/users.search'));
                  }
              }
         }
		// 清除缓存
		DD('mgr/userCom.getUseBanByName');

        $this->_succ('操作已成功', array('search'));
	}

	/*
    * 搜索用户
    */
	function search() {
		$nickname = urldecode(V('r:keyword', ''));
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = ($page -1) * $each;

		$rss = $rs = "";
		$rss = DR('mgr/userCom.getByName', '', $nickname, $offset, $each);

        foreach($rss['rst'] as $value) {
            //调用微博个人资料接口
			//$userinfo = DR('xweibo/xwb.getUserShow', '', $value['sina_uid']);
            //$value['userinfo'] = $userinfo['rst'];
                                    
            //搜索是否为加V用户
			$rst = DR('mgr/userCom.getVerifyById', '', $value['sina_uid']);
            if($rst['rst']) {
				$value['is_verify'] = 1;
            }else{
				$value['is_verify'] = 0;
			}

            //搜索是否为封禁用户
			$rst = DR('mgr/userCom.getBanByUid', '', $value['sina_uid']);

            if($rst['rst']) {
				$value['is_ban'] = 1;
            }else{
				$value['is_ban'] = 0;
			}

            $rs[$value['sina_uid']] = $value;

        }

		$rss = DR('mgr/userCom.getByName', '', $nickname);
        $count = count($rss['rst']);

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);

		TPL :: assign('num', $num);
		TPL :: assign('pager', $pager->makePageForKeyWord('',array('keyword'=>urlencode($nickname))));
		TPL :: assign('count', $count);
		TPL :: assign('nickname', $nickname);
        TPL :: assign('list', $rs); 
        TPL :: display('mgr/user/user_list', '', 0, false);
	}

	/*
	 * 搜索所有站内，外用户
	 */
	function searchAllBanUser() {
		$nickname = trim(V('p:keyword', ''));
		//$userinfo = DR('xweibo/xwb.getUserShow', null, null, null, $nickname);
		if(empty($nickname)) {
			TPL :: display('mgr/user/users_ban_search', '', 0, false);
			exit;
		}

		$rs = $rss = $rst = '';
		$rss = DR('xweibo/xwb.searchUser', null, array('q' => $nickname,'count' => 10,'page' => 1));
		if (!$rss['errno'] && is_array($rss['rst'])) {
			foreach($rss['rst'] as $value) {
				//搜索是否为封禁用户
				$rst = DR('mgr/userCom.getBanByUid', '', $value['id']);
				if($rst['rst']) {
					$value['is_ban'] = 1;
				}else{
					$value['is_ban'] = 0;
				}
				$rs[] = $value;
			}
		}
		TPL :: assign('list', $rs);
        TPL :: display('mgr/user/users_ban_search', '', 0, false);
	}

	/*
	 * 搜索站内禁封用户
	 */
	function getBanUser() {
		$nickname = urldecode(trim(V('r:keyword', '')));
		$page = (int)V('g:page', 1);
		$each = (int)V('g:each', 15);
		$offset = ($page -1) * $each;
		$num = $offset;

		$rs = DR('mgr/userCom.getUseBanByName', null, $nickname, $offset, $each);

		$rss = DR('mgr/userCom.getUseBanByName', null, $nickname);
        $count = count($rss['rst']);

		$pager = APP :: N('pager');
		$page_param = array('currentPage'=> $page, 'pageSize' => $each, 'recordCount' => $count, 'linkNumber' => 10);
		$pager->setParam($page_param);
		
		TPL :: assign('pager', $pager->makePageForKeyWord('',array('keyword'=>urlencode($nickname))));
		TPL :: assign('list', $rs['rst']);
		TPL :: assign('num', $num);
        TPL :: display('mgr/user/users_ban', '', 0, false);
	}
}
