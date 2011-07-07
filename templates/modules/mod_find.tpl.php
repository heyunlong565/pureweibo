<div class="mod-find">
	<div class="find-area">
		<form method="post" id="searchForm" action="<?php echo URL('search.user');?>">
			<div class="find-block">
				<input type="text" class="input-txt" name="k" value="" id="k" />
				<a id="searchBtn" class="s-btn skin-btn">找人</a>
			</div>
			<div class="find-field">
				<label for="allsite"><input type="radio" id="allsite" name="base_app" value="0" <?php if (V('r:base_app') == '0' || !V('r:base_app', false)) {?>checked="checked"<?php }?> />本站及新浪微博</label>
				<label for="site"><input type="radio" id="site" name="base_app" value="1" <?php if (V('r:base_app') == '1') {?>checked="checked"<?php }?> />仅本站</label>
			</div>
			<div class="find-tips hidden" id="searchTip">
				<span>请输入搜索条件！</span>
			</div>
		</form>
	</div>
</div>
