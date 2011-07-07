<?php
/**
* @desc 查看TA的页面时，未登录提示
* 
*/

// 用户ID，如果未登录将为空
$uid = USER::uid();
if ($uid){
	return false;
 }else {
	// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
	$login_way = V('-:sysConfig/login_way', 1)*1;
	$siteLogin	= FALSE;
	// 如果可使用附属站登录，则获取相关信息
	if ($login_way == 2 || $login_way == 3){
		$accAdapter = APP::ADP('account'); 
		$site_info	= $accAdapter->getInfo();
		$siteLogin	= $site_info['site_uid'];
		//print_r($site_info);
	}

	//附属站已登录, 需绑定
	if ($siteLogin){
	?>
		<!-- 已登录，未绑定 开始-->
		<div class="login-tips">
			<a class="btn-sina-bind-s"  rel="e:lg"  href="<?php echo URL('account.sinaLogin','cb=bind');?>"></a>
			<p class="guide-reg">还没有新浪微博帐号？<a href="<?php echo SINA_WB_REG_URL;?>">立即注册</a></p>
			<p class="tips-txt">为什么要绑定新浪微博?
				<?php echo V('-:sysConfig/site_name');?>博微博基于新浪微博开发，您需要绑定一个新浪微博帐号，方可使用全部功能</p>
		</div>
		<!-- 已登录，未绑定 结束-->
	<?php } else { 
		//未登录
		if ($login_way == 2 || $login_way == 3){		
	?>
		<!-- 使用网站帐号登录 开始-->
		<div class="login-tips">
			<a class="btn-login"  rel="e:lg" href="<?php echo URL('account.siteLogin','cb=login');?>"></a>
			<p class="guide-reg">还没有微博帐号？<a href="<?php echo $site_info['reg_url'];?>">立即注册</a></p>
			<p class="tips-txt">为什么要登录注册？<?php echo V('-:sysConfig/site_name');?>为每一位用户提供不同的服务，登录才能记住你的喜好。</p>
		</div>
		<!-- 使用网站帐号登录 结束-->
	    <?php } else { ?>
		<!-- 使用新浪微博帐号登录 开始-->
		<div class="login-tips">
			<a class="btn-sina-login"  rel="e:lg"  href="<?php echo URL('account.sinaLogin','cb=login');?>"></a>
			<p class="guide-reg">还没有新浪微博帐号？<a href="<?php echo SINA_WB_REG_URL;?>">立即注册</a></p>
			<p class="tips-txt">为什么要用新浪微博登录？<?php echo V('-:sysConfig/site_name');?>基于新浪微博开发，您需要使用新浪微博帐号登录，方可使用全部功能</p>
		</div>
		<!-- 使用新浪微博帐号登录 结束-->
	    <?php
	    }
	}
 }
?>
