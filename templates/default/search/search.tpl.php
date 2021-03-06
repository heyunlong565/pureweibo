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
<body id="search">
	<div id="wrapper">    	
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
            <div id="container">
                <div class="sidebar">
                <?php
                foreach ($side_modules as $mod) {
                    TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
                }
                ?>
                </div>
                <div class="main">
                    <!-- 搜索 开始 -->
                    <?php TPL::plugin('search/mod_search');?>
                    <!-- 搜索 结束 -->
                    <div class="tab-box">
                        <div class="tab-s2">
                            <span class="current"><a href="#">综合</a></span>
                            <span><a href="<?php echo URL('search.user','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app',''));?>">用户</a></span>
                            <span><a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app',''));?>">微博</a></span>
                            <a hideFocus="true" href="#" rel="e:sd,m:#<?php echo F('escape', addslashes(V('r:k')));?>#" class="say-btn" title="发微博">我也说几句</a>
                        </div>
                    </div>
    
                    <?php if ((!isset($users) || empty($users)) && (!isset($list) || empty($list))) {?>
                    <div class="search-result">
                        <div class="icon-alert all-bg"></div>
                        <p><strong>找不到符合条件的用户与微博</strong></p>
                    </div>	
                    <?php } else {?>
    
                    <div class="title-info">
                    <?php if (isset($users) && !empty($users)) {?>
                        <p class="more"><a href="<?php echo URL('search.user','k=' . urlencode(V('r:k','')));?>">查看全部</a></p>
                    <?php }?>
                        <p>找到的用户如下</p>
                    </div>
                    <?php if (!isset($users) || empty($users)) {?>
                    <div class="search-result">
                        <div class="icon-alert all-bg"></div>
                        <p><strong>找不到符合条件的用户，请输入其他关键字再试</strong></p>
                    </div>
                    <?php } else {?>
                    <div class="fame-box">
                        <!-- 名人推荐 开始-->
                        <div class="fame-list">
                            <?php TPL::plugin('search/mod_fame_list', array('users' => isset($users)? $users : array()));?>
                        </div>
                        <!-- 名人推荐 结束-->
                    </div>
                    <?php }?>
                    <div class="title-info">
                    <?php if (isset($list) && !empty($list)) {?>
                        <p class="more">
                            <a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')));?>">查看更多</a>
                        </p>
                    <?php }?>
                        <!-- <p>搜索到微博<strong><?php echo isset($total_count_maybe) ? $total_count_maybe : '0';?></strong>条</p> -->
                    	<p>找到的微博如下</p>
                    </div>
                    <?php if (!isset($list) || empty($list)) {?>
                    <div class="search-result">
                        <div class="icon-alert all-bg"></div>
                        <p><strong>找不到符合条件的微博，请输入其他关键字再试</strong></p>
                    </div>
                    <?php } else {?>
                    <!-- 微博列表 开始-->
                    <div class="feed-list" id="xwb_weibo_list">
                    <?php TPL::plugin('include/feedlist', array('list'=> isset($list) ? $list : array()));?>
                    <?php TPL::plugin('include/page', array('list'=> isset($list) ? $list : array(), 'limit'=> isset($each_page)? $each_page : 5));?>
                    </div>
    
                    <?php }?>
                    <!-- 微博列表 结束-->
                    <?php }?>
                </div>
            </div>
             <!-- 底部 开始-->
                <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
