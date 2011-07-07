<div class="row">
	<form method="get" action="<?php echo WAP_URL('search');?>">
        <input type="hidden" name='<?php echo WAP_SESSION_NAME;?>' value='<?php echo V('r:'.WAP_SESSION_NAME) ?>'/>
		<span>搜索微博/找人</span>&nbsp;<input type="text" name="k" size="15" />&nbsp;
		<input type="hidden" name="m" value="search"/>
		<input type="submit" value=" 搜索 " />
	</form>
</div>