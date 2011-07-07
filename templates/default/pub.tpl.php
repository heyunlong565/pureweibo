<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, USER::uid()?false:'');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/pub.css" rel="stylesheet" type="text/css" />
</head>
<body id="pub">
	<div id="wrapper">    	
    	<div class="wrapper-in">
			<?php TPL::plugin('include/header');?>
            <div class="tab-s1">
                <span class="current"><a hideFocus="true" href="<?php echo URL('pub');?>">广场首页</a></span>
                <span class="cut"><a hideFocus="true" href="<?php echo URL('pub.look');?>">随便看看</a></span>
                <span><a hideFocus="true" href="<?php echo URL('pub.topics');?>">话题排行榜</a></span>
                <div class="tab-l"></div>
                <div class="tab-r"></div>
            </div>
            <div id="container">
                <div class="sidebar">
                    <!-- 用户信息 开始-->
                    <?php TPL::plugin('include/user_preview');?>
                    <!-- 用户信息 结束-->
                    
                    
    
    <?php
        foreach ($side_modules as $mod) {
            //echo $mod['component_id'];
            TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
        }
    ?>
                              
                </div>
                <div class="main">
                    <?php
                        /* main 模块代码生成 */
                        foreach ($main_modules as $mod) {
                    //		include 'include/component.'.$mod['component_id'].'.php';
                            TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
                        }
                    ?>
                </div>
            </div>
			<?php TPL::plugin('include/footer');?>
        </div>
    </div>
	
</body>
</html>
<!-- report -->
<script src="<?php echo F('report', 'pub');?>"></script>
