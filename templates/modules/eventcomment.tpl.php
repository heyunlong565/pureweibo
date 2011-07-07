<div class="add-comment add-comment-dash">
<p class="title title-small">关于<a href="<?php echo URL('search.weibo', array('k' => $info['title']));?>"><?php echo F('escape', $info['title']);?></a>的讨论</p>
	<div class="post-comment-main">
		<div class="icon-face-choose all-bg" rel='e:ic'></div>
		<div class="comment-r">
		<textarea class="comment-textarea style-normal" id="inputor">#<?php echo F('escape', $info['title']);?>#</textarea>
			<div>
				<a class="general-btn" href="javascript:;" rel="e:sd,eid:<?php echo  $info['id'] ;?>,a:event"><span>发布</span></a>
				<span id="warn" class="keyin-tips">还可以输入140个字</span>
			</div>
		</div>

	</div>
</div>
