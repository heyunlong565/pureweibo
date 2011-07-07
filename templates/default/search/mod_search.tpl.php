<div class="mod-search">
	<div class="search-area">
	<form method="post" id="searchForm" action="<?php echo isset($action) ? URL('search.' . $action) : URL('search');?>">
			<div class="search-block">
				<input type="text" class="input-txt" value="<?php echo htmlspecialchars(V('r:k', ''));?>" name="k"  id="k" />
				<a href="#" id="searchBtn" class="s-btn skin-bg">搜索</a>
			</div>
			<div class="search-field">
<!--
				<label for="allsite"><input type="radio" id="allsite" name="base_app" value="0" <?php if (V('r:base_app') == '0' || !V('r:base_app', false)) {?>checked="checked"<?php }?> />本站及新浪微博</label>
				<label for="site"><input type="radio" id="site" name="base_app" value="1" <?php if (V('r:base_app') == '1') {?>checked="checked"<?php }?> />仅本站</label>
-->
			</div>
		</form>
	</div>
</div>
