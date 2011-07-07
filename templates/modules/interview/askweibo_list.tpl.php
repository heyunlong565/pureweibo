<div class="feed-list">
	<!--feed标题，信息过滤-->
	<div class="feed-tit">
		<div class="feed-refresh hidden">
			<a href="#">有<span></span>条新微博，点击查看</a>
    	</div>
		<h3>网友提问</h3>
	</div>
                            
	<!-- 提问微博列表  开始-->
	<?php if( $wbList['askCnt']<=0 ){ ?>
		<div class="default-tips" id="emptyTip">
			<div class="icon-tips all-bg"></div>
			<p>暂时没有微博</p>
		</div>
		<ul id="xwb_weibo_list_ct"></ul>
	<?php } else { ?>

	<ul id="xwb_weibo_list_ct">
	<?php
		$currentUid = USER::uid();
		foreach ($wbList['askList'] as $aWbTmp)
		{
			if ( isset($aWbTmp['askWb']['id']) ) 
			{
				$wb			= $aWbTmp['askWb'];
				$wb['uid'] 	= $currentUid;
				
				echo '<li rel="w:'.$wb['id'].'">';
					TPL::module('feed', $wb);
				echo '</li>';
			}
		}
	}
	?>
	</ul>
	<!-- 提问微博列表  结束-->

	<!-- 分页 开始-->
	<?php TPL::module('page', array('list'=>$wbList['askList'], 'count'=>$wbList['askCnt'], 'limit'=>$limit, 'type'=>'event'));?>
	<!-- 分页 结束-->
</div>