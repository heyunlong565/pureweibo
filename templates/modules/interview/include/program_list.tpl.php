<?php if ( is_array($interviewList) ) { ?>
<div class="program-list">
	<div class="tit-hd">
		<a href="<?php echo URL('interview.page'); ?>" class="more">更多&gt;&gt;</a>
		<h3>访谈列表</h3>
	</div>
	
	<div class="bd">
		<ul>
			<?php foreach ($interviewList as $aInterview) { ?>
			<li>
				<p><a href="<?php echo URL('interview', array('id'=>$aInterview['id']) ); ?>" target="_blank"><?php echo $aInterview['title']; ?></a>
					<?php if ($aInterview['status']=='P'){echo '<span class="unplayed">(未开始)</span>'; } elseif ($aInterview['status']=='E'){ echo '<span class="finish">(已结束)</span>'; } else {echo '<span class="active">(进行中)</span>';}?>
				</p>
              	<p><span class="label">主持人：</span>
              		<?php 
              			if ( is_array($aInterview['master']) ) 
              			{
              				foreach ($aInterview['master'] as $aMaster)
              				{
              		?>
              		<span class="emcee"><?php echo $aMaster['screen_name']; ?></span>
              		<?php } } ?>
              	</p>
              	<p><span class="label">时&nbsp;&nbsp;&nbsp;&nbsp;间：</span><span class="time"><?php echo date('Y年m月d日 H:i', $aInterview['start_time'])?></span></p>
        	</li>
        	 <?php } ?>
      	</ul>
 	</div>
</div>
 <?php } ?>