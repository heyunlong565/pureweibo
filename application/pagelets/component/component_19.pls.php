<?php

require_once dirname(__FILE__). '/component_abstract.pls.php';
/**
 * 本地关注排行榜
 * @author yaoying
 * @version $Id: component_17.pls.php 10863 2011-02-28 07:11:07Z yaoying $
 *
 */
class component_19_pls extends component_abstract_pls{
	
	function run($mod){
		parent::run($mod);
		$showNum=$mod['param']['show_num'];
		$list=DR('UserFollow.getLocalFollowTop','g/86400',$showNum);
		$ids=array();
		foreach($list['rst'] as $row){
			$ids[]=$row['friend_uid'];
			$counts[]=$row['count'];
			
		}
		//如果未登录，使用内置的token访问
		if (!USER::uid()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
		$batch_info = DR('xweibo/xwb.getUsersBatchShow', '', implode(',', $ids));
		$i=0;
		$list=array();
		if(!empty($batch_info)&&isset($batch_info['rst'])&&is_array($batch_info['rst'])){
			foreach($batch_info['rst'] as $row){
				$list[$i]['screen_name']=$row['screen_name'];
				$list[$i]['followers_count']=$row['followers_count'];
				$list[$i]['sina_uid']=$row['id'];
				$i++;
			}
			
		}
		
		if(defined('XWB_PARENT_RELATIONSHIP')&&XWB_PARENT_RELATIONSHIP){
			foreach($list as $k=>$v){
				$list[$k]['followers_count']=$counts[$k];
			}
		}
		else{
			$list=array_sort($list,'followers_count',SORT_DESC);
		}
		
		TPL::module('component/component_' . $mod['component_id'], array('mod' => $mod,'list'=>$list));
	}
	
}
