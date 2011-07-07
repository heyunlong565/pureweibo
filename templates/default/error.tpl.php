<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<?php if ($timeout):?>
<!--<meta http-equiv='Refresh' content='{$timeout};URL={$url}'>
--><?php endif;?>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- header -->
            <?php include APP::tplFile('header');?>
            <!-- end header -->
            <div id="container" class="single">
                <div class="main">
                    <div class="error-box">
                        <div class="title-box">
                            <h3>错误提示</h3>
                        </div>
                        <div class="error-c">
                            <div class="icon-error all-bg"></div>
                            <div class="error-r">
                                <strong>
                                <?php if ($msg):?>
                                <?php echo implode('<br />', $msg);?>
                                <?php else:?>
                                抱歉，您要访问的页面不存在或已经被删除。
                                <?php endif;?>
                                </strong>
                                <p>请检查输入的网址是否正确<br /><br />
                                <a href="<?php echo URL('index');?>">返回首页</a></p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- footer -->
            <?php include APP::tplFile('footer');?>
            <!-- end footer -->
        </div>
    </div> 
</body>
</html>
