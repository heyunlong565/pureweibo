<?php
/**************************************************
*  Created:  2010-06-08
*
*  微博广场
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/
class pub_mod
{
	function default_action() {
		$uid = USER::uid();
		
		if (!$uid) {
			DR('xweibo/xwb.setToken', '', 2);
		}

		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);

		TPL :: assign('main_modules', isset($modules[1]) ? $modules[1]: array());
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());

		APP::setData('page', 'pub', 'WBDATA');

		TPL :: display('pub');
	}

	/**
	 * 随便看看
	 *
	 */
	function look() {
		$modules = DS('PageModule.getPageModules', /*'g1/300'*/'', 1, 1);
		TPL :: assign('side_modules', isset($modules[2]) ? $modules[2]: array());


		$list = DR('xweibo/xwb.getPublicTimeline', '', null, false);
		TPL :: assign('list', $list);

		TPL :: display('looklook');
	}

	/**
	 * 话题排行榜
	 *
	 */
	function topics() {
		$baseApp = null;
		
		$uid = USER::uid();

		if (!$uid) {
			if (!defined('WB_USER_OAUTH_TOKEN') || !WB_USER_OAUTH_TOKEN) {
				APP::redirect(URL('index.account'), 4);
			} else {
				DR('xweibo/xwb.setToken', '', 2);
			}
		}
		
		//小时排行
		$hours = DR('xweibo/xwb.getTrendsHourly', 300);
		if ($hours['errno'] != 0) {
			$hours['rst']['trends'] = array();
		}

		//日排行
		$days = DR('xweibo/xwb.getTrendsDaily', 600);
		if ($days['errno'] != 0) {
			$days['rst']['trends'] = array();
		}

		//周排行
		$weeks = DR('xweibo/xwb.getTrendsWeekly', 3600);
		if ($weeks['errno'] != 0) {
			$weeks['rst']['trends'] = array();
		}

		DR('xweibo/xwb.setToken', '', 1);

		TPL :: assign('hours', current($hours['rst']['trends']));
		TPL :: assign('days', current($days['rst']['trends']));
		TPL :: assign('weeks', current($weeks['rst']['trends']));

		TPL :: display('pub_topic');
	}
}
