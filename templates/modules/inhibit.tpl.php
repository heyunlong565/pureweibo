<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body>
	<div id="wrapper">  
    	<div class="wrapper-in">  	
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
			<!-- 头部 结束-->
            <div id="container" class="single">
                <div class="main">
                    <div class="inhibit">
                            <div class="inhibit-icon"></div>
                            <div class="inhibit-txt">
                                <p><strong>登录失败!</strong></p>
                                <p>原因：您已经被禁止访问此网站</p>
                            </div>
                    </div>
                    
                </div>
            </div>
			<!-- 底部 开始-->
			<?php TPL::module('footer');?>
			<!-- 底部 结束-->
        </div>
    </div>  
</body>
</html>
