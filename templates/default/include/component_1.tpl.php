<div class="hot-mblog" id="hot_mblog">
    <div class="tab-s2">
        <span class="current"><a href="javascript:;">热门转发</a></span>
        <span><a href="javascript:;">热门评论</a></span>
    </div>
<?php
	// 热门转发评论
	$repost = DR('components/hotWB.getRepost', 300);
	$comments = DR('components/hotWB.getComment', 300);
?>
    <div class="hot-mblog-body feed-list">
        <?php 
			if ($repost['errno'] == 0) {
				TPL::plugin('include/feedlist', array('list' => $repost['rst'], 'header' => 2));
			} else {
				echo '<div class="int-box load-fail icon-bg">获取热门微博信息失败，请<a href="#" rel="e:rf">刷新</a>再试!</div>';
			}
		?>
    </div>
	
	<div class="hot-mblog-body feed-list hidden">
		<?php 
			if ($comments['errno'] == 0) {
				TPL::plugin('include/feedlist', array('list' => $comments['rst'], 'header' => 3));
			} else {
				echo '<div class="int-box load-fail icon-bg">获取热门微博信息失败，请<a href="#" rel="e:rf">刷新</a>再试!</div>';
			}
		?>
	</div>
</div>