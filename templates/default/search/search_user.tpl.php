<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
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
                    <?php TPL::plugin('search/mod_search', array('action'=>'user'));?>
                    <!-- 搜索 结束 -->
                    <div class="tab-box">
                        <div class="tab-s2">
                            <span><a href="<?php echo URL('search','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app',''));?>">综合</a></span>
                            <span class="current"><a href="#">用户</a></span>
                            <span><a href="<?php echo URL('search.weibo','k=' . urlencode(V('r:k','')).'&base_app=' . V('r:base_app',''));?>">微博</a></span>
                            <a hideFocus="true" href="#" rel="e:sd,m:@<?php echo F('escape', addslashes(V('r:k')));?> " class="say-btn" title="发微博">我也说几句</a>
                        </div>
                    </div>
                    <?php if (!isset($data) || !is_array($data) || empty($data)) {?>
                    <div class="search-result">
                        <div class="icon-alert all-bg"></div>
                        <p><strong>找不到符合条件的用户，请输入其他关键字再试</strong></p>
                    </div>
                    <?php } else {?>
                    <div class="title-info">
                        <p>找到的用户如下</p>
                    </div>
                    <!-- 用户列表 开始-->
                    <div class="user-list">
                        <ul>
                        <?php foreach ($data as $item) {?>
                            <li rel="u:<?php echo $item['id'];?>">
                                <div class="list-content">
                                    <div class="user-pic">
                                        <a href="<?php echo URL('ta', 'id=' . $item['id']);?>"><img src="<?php echo $item['profile_image_url']?>" alt="" /></a>
                                    </div>
                                    <div class="content-r">
									<?php if ($item['id'] !== USER::uid()) {?>
                                        <?php if ($item['following']) {?>
                                        <a href="#" class="followed-btn">已关注</a>
                                        <?php } else {?>
                                        <a href="#" rel="e:fl,t:1" class="addfollow-btn">添加关注</a>
                                        <?php }?>
									<?php }?>
                                    </div>
                                    <div class="content-m">
                                        <a class="u-name" href="<?php echo URL('ta', 'id=' . $item['id']);?>"><?php echo htmlspecialchars($item['screen_name']);?></a>
                                        <?php echo F('verified', $item);?>
                                        <p class="icon-bg icon-<?php if ($item['gender'] == 'f') {?>fe<?php }?>male"><?php echo $item['location'];?> 粉丝数：<?php echo $item['followers_count'];?>人</p>
                                        <?php if (isset($item['status'])) {?>
                                        <div class="u-info"><?php echo ($item['description']);?></div>
                                        <?php }?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
                        <!-- 分页 开始-->
                        <?php TPL::plugin('include/page', array('extends'=> $extends, 'list'=> isset($data) ? $data : array(), 'limit'=> isset($each_page)? $each_page : 5));?>
                        <!-- 分页 结束-->
                    </div>
                    <!-- 用户列表 结束-->
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
