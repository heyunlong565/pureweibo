<div class="list-footer">
    <div class="page">
		<?php
		 $limit = isset($limit) ? $limit : null;
		 if (isset($extends)) {
			 DS('common/pager.setVarExtends', '', $extends);
		 }
		 echo DS('common/pager.getPageList', '', $list, $limit);
		?>
    </div>
    <a href="#" class="icon-gotop skin-bg">返回顶部</a>
</div>
