<div id="picture" class="form-body">
									
	<?php if( $domain_name=USER::get('domain_name') ): ?>
	<div id="domainOk" class="domain-cont">
		<div class="success-wrap" style="width:70%">
			<div class="success">
				<span class="success-icon"></span>
				<p>你已经设置个性域名</p>
    			<p class="overhead-info">您的个性化域名是：<a href="<?php echo W_BASE_HTTP.W_BASE_URL.$domain_name; ?>" id="domainUrl" ><?php echo W_BASE_HTTP.W_BASE_URL.$domain_name; ?></a></p>
			</div>
			<p><a id="addFavLink" class="icon-fav" href="javascript:void(0);">加入收藏夹</a><a href="javascript:void(0);" id="showCopyDiv" class="icon-invite hidden">邀请朋友关注我</a></p>
			<div class="set-domain hidden" style="margin-top:30px;" id="copyDiv">
				<div class="input-wrap">
                    <input type="text" class="input style-normal" id="u_domain" value="<?php echo W_BASE_HTTP.W_BASE_URL.'i/'.$domain_name; ?>">
					<a href="javascript:void(0);" class="search-host" id="copyToClipboard">复制连接</a>
				</div>
				<p class="example">我将以上连接发给亲朋好友，他们接受邀请后会成为你的粉丝。</p>
			</div>
		</div>
	</div>
	
	<?php else: ?> 
	<div id="domainOk" class="domain-cont hidden">
		<div class="success-wrap" style="width:70%">
			<div class="success">
				<span class="success-icon"></span>
				<p>你已经设置个性域名</p>
    			<p class="overhead-info">您的个性化域名是：<a href="<?php echo W_BASE_HTTP.W_BASE_URL; ?>" id="domainUrl"><?php echo W_BASE_HTTP.W_BASE_URL; ?></a></p>
			</div>
			<p><a href="javascript:void(0);" class="icon-fav">加入收藏夹</a><a href="javascript:void(0);" id="showCopyDiv" class="icon-invite hidden">邀请朋友关注我</a></p>
			<div class="set-domain hidden" style="margin-top:30px;" id="copyDiv">
				<div class="input-wrap">
                    <input type="text" class="input style-normal" id="u_domain" value="">
					<a href="javascript:void(0);" class="search-host" id="copyToClipboard">复制连接</a>
				</div>
				<p class="example">我将以上连接发给亲朋好友，他们接受邀请后会成为你的粉丝。</p>
			</div>
		</div>
	</div>
	
	<div id="domainSet" class="domain-cont">
		<div class="desc">
			<p>记得自己的微博客地址是什么吗？设置个性域名，让朋友更容易记住！</p>
			<ul>
				<li><span>可以输入6至20位的英文或数字（必须包含英文字符）</span></li>
				<li><span>保存后不得修改！</span></li>
			</ul>
		</div>
		<form id="domainForm">
		<div class="set-domain">
			<h4>设置个性域名</h4>
			<p class="example">域名预览：<span id="domainPreview"><?php echo W_BASE_HTTP.W_BASE_URL; ?></span></p>
			<div class="input-wrap">
                <input type="text" vrel="_f=ch:1|ne|domain" warntip="#errTip" class="input style-normal" name="domain" id="domain" maxlength="30">
				<a href="#" class="search-host" id="domainTrig">确定</a>
			</div>
            <span class="wrong-txt tips-wrong hidden" id="errTip">域名已经被占用！</span>
			<input class="hidden" type="submit" value=""/>
		</div>
	    </form>
	</div>
	<?php endif; ?>
                   						
</div>
