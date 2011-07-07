<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/pub.css" rel="stylesheet" type="text/css" />
</head>
<body id="weibo_login">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single ">
                <div class="main">
                    <div class="weibo-login-info">
                        <div class="icon-head"></div>
                        <div class="weibo-login-con">
                            <p>您还没有登录，请选择登录方式：</p>
                        </div>
                    </div>
                    <div class="weibo-login-area">
                        <?php 
                        $tips = '';
                        if ($use_site_login) {
                        	$tips = $site_info['site_name'].'';
                        ?>
                        <a href="<?php echo URL('account.siteLogin','cb=login');?>" class="btn-web-account bind-btn-bg"><?php echo $site_info['site_name'];?>登录</a><span><a href="<?php echo $site_info['reg_url'];?>">注册帐号</a></span>
                        <?php 
                        }
                        if ($use_sina_login) {
                        	$tips = empty($tips) ? '新浪微博帐号' : $tips.'或新浪微博帐号'; 
                        ?>
                        <a rel="e:lg,t:sinaLogin" href="<?php echo URL('account.sinaLogin','cb=login');?>" class="btn-sina-account bind-btn-bg">新浪微博帐号登录</a><span><a target="_blank" href="<?php echo SINA_WB_REG_URL;?>">开通微博</a></span>
                        <?php 
                        }?>
                        <p class="tips">提示：您可以使用<?php echo $tips;?>登录本网站</p>
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?> 
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
