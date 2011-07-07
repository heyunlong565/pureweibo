<?php
/**************************************************
*  Created:  2010-06-08
*
*  帐号相关操作
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

class welcome_mod {
	/// 获取绑定信息
	function default_action() {
		$autoFollow = DS('common/sysConfig.get', '', 'guide_auto_follow');

		TPL::assign('autoFollow', $autoFollow);

		if ($autoFollow) { //自动关注
			$followId = DS('common/sysConfig.get','', 'guide_auto_follow_id');
			$result = DR('mgr/userRecommendCom.getUserById', '', $followId);

			$rst = '';

			if ($result['errno'] == 0) {
				$rst = &$result['rst'];

				if (count($rst) > 3) {
					$rst = array_slice($rst, 0, 3);
				}
				
				if (!empty($rst)) {
					$ids = array();

					foreach ($rst as $row) {
						array_push($ids, $row['uid']);
					}

					$result = DR('xweibo/xwb.createFriendshipBatch', '', $ids);

					//清除缓存
					DD('xweibo/xwb.getFollowerIds');
					DD('xweibo/xwb.getFollowers');

				}

			}

			TPL::assign('data', $rst);
		}

		TPL::display('guide');
	}
	
}
?>
