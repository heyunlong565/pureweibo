<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title','','错误提示');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<?php APP::setData('page', 'e403', 'WBDATA'); ;?>
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
								<p><strong><?php echo implode(',', $msg);?></strong></p>
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
