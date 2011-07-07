<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="atme" class="own">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- header -->
            <?php TPL::plugin('include/header');?>
            <!-- end header -->
                <div id="container">
                    <div class="sidebar">
                        <?php TPL::plugin('include/user_preview');?> 
                        <?php TPL::plugin('include/user_menu');?>
                        <!-- 标签 -->
                        <?php TPL::plugin('include/user_tag');?>    
                        <!-- end 标签 -->
                        <?php
                            foreach ($side_modules as $mod) {
                                TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
                            }
                        ?>
                    </div>
                    <div class="main">
                        <?php TPL::plugin('include/input');?>
                        <?php if (empty($list)):?>
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
                                <p>已到最后一页</p>
								<?php else:?>
                                <p>这里会显示含有"@<?php echo $userinfo['screen_name'];?>"的微博。</p>
                                <p>目前，还没有人提到你呢，敬请期待。</p>
								<?php endif;?>
                            </div>
                        <?php else:?>
                        <div class="feed-list"> 
                            <div class="feed-tit">
                                <h3>提到我的</h3>	
                            </div>
                            <?php TPL::plugin('include/feedlist', array('list' => $list));?>
                            <!-- 分页 -->
                            <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                            <!-- end 分页 -->
                        </div>
                        <?Php endif;?>
                    </div>
                </div>
            <?php TPL::plugin('include/footer');?>
    	</div>
    </div>   
</body>
</html>
