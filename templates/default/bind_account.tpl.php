<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />

</head>
<body id="bind-account">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main bind-info">
                    <p class="letter-bind-weibo">登录成功，继续操作需绑定新浪微博帐号</p>
					<div class="account-set">
						<div class="logo-pic">
							<div class="logo1">
								<?php 
									if (V('-:sysConfig/logo',false)){
										echo '<img src="'.W_BASE_URL_PATH.V('-:sysConfig/logo').'"/>';
									}else{
										echo '<img src="'.W_BASE_URL_PATH.WB_LOGO_DEFAULT_NAME.'"/>';
									}
								?>
            				</div>
							<div class="logo2"><img src="<?php echo W_BASE_URL_PATH;?>var/data/logo/sina_logo.png" alt="" /></div>
							<div class="icon-two-way"></div>
						</div>
						<div class="btn-area"><a href="#" rel="e:lg,t:bind" class="btn-sina-bind-l"></a></div>
					</div>
                    <div class="bind-con">
                        <dl>
                            <dt>为什么要进行帐号绑定？</dt>
                            <dd><?php echo USER::get('site_name');?>微博基于新浪微博开发，您需要绑定一个新浪微博帐号，方可使用全部功能</dd>
                        </dl>
                        <dl>
                            <dt>每次登录都需要绑定吗？</dt>
                            <dd>不需要，您只需要绑定一次，之后就可以直接进入<?php echo USER::get('site_name');?>微博了！</dd>
                        </dl>
                        <dl>
                            <dt>没有新浪微博帐号怎么办？</dt>
                            <dd>点击这里注册，只需1分钟！<br />
                                <a  href="<?php echo SINA_WB_REG_URL;?>">注册新浪微博帐号</a></dd>
                        </dl>
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
