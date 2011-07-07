<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="error">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main">
                    <div class="error-box">
                        <div class="error-force-bg">
                            <div class="error-force-con">
                                <p>爱微博、爱把微博整空白</p>
                                <p>爱在你的网页让你等待</p>
                                <p>我不是什么网络错误</p>
                                <p>也不是什么外星人来袭</p>
                                <p>我只是在等待API的宠幸</p>
                                <p>我和你一样，希望API给点力</p>
                                <p><a href="javascript:window.location.reload()">再刷新看看</a></p>
                            </div>
                        </div>
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
