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
<body id="user-recommend">
	<div id="wrapper">    	
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
            <div id="container">
                <div class="sidebar">
				<!-- 用户信息 开始-->
				<?php TPL::plugin('include/user_preview');?>
				<!-- 用户信息 结束-->
                <?php
                foreach ($side_modules as $mod) {
                    TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
                }
                ?>
                </div>
                <div class="main">
                    <!-- 找人 开始 -->
                    <?php TPL::plugin('search/mod_find');?>
                    <!-- 找人 结束 -->
                    <?php if (isset($suggestions)) {?>
                    <div class="recom-star">
						<div class="column-title">
							<a class="icon-change icon-bg" href="javascript:window.location.reload()">换一批</a>							
							<h3>你可能感兴趣的人</h3>
						</div>
                        <ul class="interest-list">
                        <?php if (is_array($suggestions)) {foreach ($suggestions as $item) {?>
                            <li rel="u:<?php echo $item['user']['id'];?>">
                                <a class="user-pic" href="<?php echo URL('ta', 'id=' . $item['user']['id'] . '&name=' . urlencode($item['user']['screen_name']));?>"><img src="<?php echo $item['user']['profile_image_url'];?>" alt="" /></a>
                                <p><a href="<?php echo URL('ta', 'id=' . $item['user']['id'] . '&name=' . urlencode($item['user']['screen_name']));?>" title="<?php echo F('escape', $item['user']['screen_name']);?>"><?php echo F('escape', $item['user']['screen_name']);?></a></p>
                                <?php if ($item['user']['following']) {?>
                                <span class="followed-btn">已关注</span>
                                <?php } else {?>
                                <a class="addfollow-btn" rel="e:fl,t:1" href="#">加关注</a></li>
                                <?php }?>
                        <?php }}?>
                        </ul>
                    </div>
                    <?php }?>
                    <div class="recom-star">
                        <?php TPL::plugin('include/recommendUser', array('base_url' => URL('search.recommend', 'cid='), 'cid' => (int)V('g:cid', false)));?>
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
