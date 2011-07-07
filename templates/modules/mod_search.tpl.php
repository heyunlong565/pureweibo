<?php
$router_str = APP::getRuningRoute(false);
if ($router_str == 'search.recommend') {
	$router_str = 'search.user';
}
?>
<div class="mod-search">
	<div class="search-area">
		<form method="get" id="searchForm" action="">
		<div class="cate-bar">
			<span><?php echo ($router_str != 'search.weibo') ? '<a href="' . URL('search.weibo', array('k' => V('r:k', ''), 'base_app' => V('r:base_app', '0'))) . '">微博</a>' : '微博'; ?></span><span><?php echo ($router_str != 'search.user') ? '<a href="' . URL('search.user', array('k' => V('r:k', ''), 'base_app' => V('r:base_app', '0'))) . '">用户</a>' : '用户'; ?></span>
		</div>
		<div class="search-block">
			<span class="radius">
				<span class="radius-right">
					<input type="text" class="input-txt" value="<?php echo htmlspecialchars(V('r:k', ''));?>" name="k"  id="k" />
					<input type="hidden" name="m" value="<?php echo $router_str;?>">
					<a href="#" id="searchBtn" class="s-btn skin-btn">搜索</a>
				</span>
			</span>
		</div>
		<?php if ($router_str == 'search.user'): ?>
		<input type="hidden" name="base_app" value="<?php echo V('r:base_app', '0'); ?>" />
		<div class="search-field">
			<label for="nick"><input type="radio" id="nick" name="ut" value="nick" <?php echo V('r:ut', 'nick') == 'nick' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> />昵称</label>
			<label for="sintro"><input type="radio" id="sintro" name="ut" value="sintro" <?php echo V('r:ut', '') == 'sintro' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> />简介</label>
			<label for="tags"><input type="radio" id="tags" name="ut" value="tags" <?php echo V('r:ut', '') == 'tags' ? 'checked="checked"' : ''; ?> <?php if (trim(V('r:k', '')) !== ''): ?>onclick="javascript:$('#searchForm').submit();"<?php endif; ?> />标签</label>
		</div>
		<?php else: ?>
		<div class="search-field" rel="subject:<?php echo htmlspecialchars(V('r:k', ''));?>">
			<p>
				<span class="icon-join"><a hideFocus="true" href="#" rel="e:sd,m:#<?php echo F('escape', addslashes(V('r:k')));?>#" title="发微博">参与该话题</a></span>
				<?php
				$sina_uid = USER::uid();
				$add_result = DR('xweibo/xwb.isSubjectFollowed', FALSE, $sina_uid, V('r:k'));
				if ($add_result['errno'] == 0):
				?>
					<span class="icon-follow"><a href="javascript:;" rel="e:addSubject">关注该话题</a></span>
				<?php
				elseif($add_result['errno'] == 1):
				?>
					<span>已关注(<a href="javascript:;" rel="e:delSubject">取消关注</a>)</span>
				<?php
				endif;
				?>
				<!--span class="icon-join"><a href="">参与该话题</a></span><span>已关注(<a href="">取消关注</a>)</span-->
			</p>
		</div>
		<?php endif; ?>
		</form>
	</div>
</div>