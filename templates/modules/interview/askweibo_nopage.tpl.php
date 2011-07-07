<div class="title-box">
	<h3>网友提问<span>(共有<em class="que-num"><?php echo $wbList['askCnt']; ?></em>个问题)</span></h3>
</div>

<div class="feed-list ask-list">
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
</div>