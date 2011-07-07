<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html id="index" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理中心</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin.js"></script>
<script>
$(function(){
	admin.index.init();
});
</script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div class="logo"></div>
		<div class="menu">
        	<a href="#" id="function"></a>
            <a href="#" id="operations"></a>
            <a href="#" id="quise"></a>
            <a href="#" id="sub-unit"></a>
            <a href="#" id="account"></a>
        </div>
		<div class="log-info">
        	<span>欢迎回来：<?php echo $real_name;?></span>
            <em>|</em>
            <a href="<?php echo URL('mgr/admin.logout');?>">退出系统</a>
            <a class="back-home" href="index.php" target="_blank">微博首页</a>
        </div>
	</div>
	<div id="container">
	  <div class="sidebar">
			<div class="sub-menu">
            	<h3 class="sidebar-title-top">功能设置</h3>
				<div class="sub-menu-info">
                	<a href="<?php echo URL('mgr/setting.editIndex');?>" target="mainframe">站点设置</a>
                    <a href="<?php echo URL('mgr/setting.getlink');?>" target="mainframe">页首页脚设置</a>
					<a href="<?php echo URL('mgr/setting.editRewrite');?>" target="mainframe">优化设置</a>
                    <a href="<?php echo URL('mgr/setting.editUser');?>" target="mainframe">用户登录设置</a>
                </div>
			</div>
			<div class='sub-menu'>
				<h3>用户管理</h3>
				<div class="sub-menu-info">
                	<a href="<?php echo URL('mgr/users.search');?>" target="mainframe">用户列表</a>
                	<a href="<?php echo URL('mgr/user_recommend.getReSort');?>" target="mainframe">用户推荐管理</a>
                	<a href="<?php echo URL('mgr/users.searchAllBanUser');?>" target="mainframe">用户封禁管理</a>
                </div>
				<h3 class="sub-menu-titleline">微博管理</h3>
				<div class="sub-menu-info">
					<a href="<?php echo URL('mgr/weibo/todayTopic.category');?>" target="mainframe">话题推荐管理</a>
					<a href="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>" target="mainframe">微博屏蔽</a>
					<a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>" target="mainframe">评论屏蔽</a>
					<a href="<?php echo URL('mgr/weibo/disableUser.userList');?>" target="mainframe">用户屏蔽</a>
					<a href="<?php echo URL('mgr/weibo/keyword.keywordList');?>" target="mainframe">关键字过滤</a>
                </div>
                <h3 class="sub-menu-titleline">认证管理</h3>
				<div class="sub-menu-info">
                	<a href="<?php echo URL('mgr/user_verify.search');?>" target="mainframe">认证用户列表</a>
                    <a id="topicList" href="<?php echo URL('mgr/user_verify.webAuthenWay');?>" target="mainframe">认证设置</a>
                </div>
			</div>
			<div class='sub-menu'>
				<h3>皮肤管理</h3>
				<div class="sub-menu-info">
                    <a id="topicList" href="<?php echo URL('mgr/skin.getAllSkin');?>" target="mainframe">皮肤列表</a>
                	<a href="<?php echo URL('mgr/skin.getAllSkinSort');?>" target="mainframe">皮肤类别</a>
                </div>
                <h3 class="sub-menu-titleline">页面管理</h3>
                <div class="sub-menu-info">
                	<a href="<?php echo URL('mgr/page_manager');?>" target="mainframe">页面设置</a>
                </div>
			</div>
			<div class='sub-menu'>
				<h3>组件设置</h3>
				<div class="sub-menu-info">
                	<a href="<?php echo URL('mgr/components');?>" target="mainframe">组件列表</a>
                </div>
			</div>
			<div class='sub-menu'>
				<h3>帐号管理</h3>
				<div class="sub-menu-info">
				    <a href="<?php echo URL('mgr/admin.repassword','id=' . $admin_id);?>" target="mainframe">修改密码</a>
                	<?php if($admin_root):?><a href="<?php echo URL('mgr/admin.search');?>" target="mainframe">添加管理员用户</a><?php endif;?>
                    <a id="userlist" href="<?php echo URL('mgr/admin.userlist');?>" target="mainframe">管理员用户列表</a>
                </div>
			</div>
		</div>
		<div class="main">
            <iframe id="mainframe" width="100%" name="mainframe" frameborder="0" src="#"  scrolling="yes"></iframe>
		</div>
	</div>
</div>

<script type="text/javascript">
var update_url = '<?php echo WB_UPGRADE_CHK_URL;?>';
var version = '<?php echo WB_VERSION;?>';

if (update_url && version)
{
	checkNewVer(update_url, version);
}
</script>
</body>
</html>