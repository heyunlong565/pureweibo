<?php
/**
* @param uInfo　用户信息
* @desc 用户信息块，可能有四种状态，未登录时有三种
* 
*/
// 用户ID，如果未登录将为空
$uid = USER::uid();
if ($uid){
    $isTa		= isset($uInfo) && is_array($uInfo);
    //$rs = DS('xweibo/xwb.verifyCredentials') ;
    //var_dump($rs);
    //$rs = F('user_filter', DS('xweibo/xwb.verifyCredentials'), true);
    //var_dump($rs);
    $uInfo		= $isTa ? $uInfo : F('user_filter', DS('xweibo/xwb.verifyCredentials'), true);
    $uName      = F('escape', $uInfo['screen_name']);
    $location   = F('escape', $uInfo['location']);
    $desc       = F('escape', $uInfo['description']);  
    $pic        = F('profile_image_url', $uInfo['profile_image_url']);
    $link       = $isTa ? URL('ta', array('id'=>$uInfo['id'], 'name'=>$uInfo['screen_name'])) : URL('index');
    
  	$pl = DS('Plugins.get', 'g1/86400', 3);
	$adProfile = $pl['in_use'] ? DS('plugins/adProfile.get', 86400): false;
?>


<div class="user-preview">
    <div class="user-info">
        <a class="user-pic" href="<?php echo $link;?>"><img src="<?php echo $pic;?>" title="<?php echo $uName;?>" /></a>
        <div class="user-intro">
			<strong>
				<?php echo $uName;?>
				<?php echo F('verified', $uInfo);?>
			</strong>
            <p class="icon-bg icon-<?php echo ($uInfo['gender'] == 'm' || $uInfo['gender'] == '') ? 'male' : 'female';?>"><?php echo $location;?></p>
        </div>
    </div>
    <!-- 用户关注、粉丝、微博信息总数 开始-->
    <?php TPL::plugin('include/user_total', array('uInfo'=>$uInfo));?> 
    <p><?php echo $desc;?></p>
</div>  
<?php  
	if ($adProfile && is_array($adProfile)){
    	$l =  $adProfile[array_rand ($adProfile)];
	?>  
	<!-- 推广区 开始-->
	<div class="bulicity skin-bg">
		<a target="_blank" href="<?php echo $l['link'];?>"><?php echo F('escape', $l['title']);?></a>
	</div>
	<!-- 推广区 结束-->

<?php }?>

<?php 
 }else {
	// 1 使用新浪帐号登录，2 使用附属站帐号登录 3 可同时使用两种帐号登录
	$login_way = V('-:sysConfig/login_way', 1)*1;
	$siteLogin	= 0;
	
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
		<!--已登录 开始-->
		<div class="account-login">
			<h3>HI,<?php echo $site_info['site_uname'];?></h3>
			<p>您已经成功登陆！要使用<?php echo $site_info['site_name'];?>微博功能，您需要绑定新浪微博帐号。</p>
			<div class="login-btn-area"><a rel="e:lg" href="<?php echo URL('account.sinaLogin','cb=bind');?>" class="btn-sina-bind-s"></a></div>
			<em><a href="<?php echo SINA_WB_REG_URL;?>">注册微博帐号</a></em>
		</div>
		<!--已登录 结束-->
	<?php } else { 
		//未登录
		if ($login_way == 2 || $login_way == 3){		
	?>
		<!--未登录-站长 开始-->
		<div class="account-login">
			<div class="user-login-title"><span>登录之后更精彩</span></div>
			<div class="login-btn-area"><a rel="e:lg" href="<?php echo URL('account.siteLogin','cb=login');?>" class="btn-login"></a></div>
			<em><a href="<?php echo $site_info['reg_url'];?>">注册帐号</a></em>
		</div>
		<!--未登录-站长 结束--> 
	    <?php } else { ?>
		<!--未登录-普通用户 开始-->
		<div class="account-login">
			<div class="user-login-title"><span>登录之后更精彩</span></div>
			<div class="login-btn-area"><a rel="e:lg" href="<?php echo URL('account.sinaLogin','cb=login');?>" class="btn-sina-login"></a></div>
			<em><a href="<?php echo SINA_WB_REG_URL;?>">注册微博帐号</a></em>
		</div>
		<!--未登录-普通用户 结束-->
	    <?php
	    }
	}
 }
?>
