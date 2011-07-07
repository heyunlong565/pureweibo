<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body>
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
                    <div class="title-box">
                        <h3 class=""><?php if ($uid != $userinfo['id']): ?><?php echo F('escape', $userinfo['screen_name'])?><?php endif;?>我的关注（<?php echo empty($userinfo['friends_count']) ? 0 : $userinfo['friends_count'];?>）</h3>
    
                    </div>
                    <?php if (empty($list['users'])):?>
                        <!-- follow empty tip -->
                        <?php if ($uid == $userinfo['id']):?>
                            <!-- wo tip -->
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
                                <p>已到最后一页</p>
								<?php else:?>
								<p>还没找到想要关注的人？</p>
								<p>在这里找找<a href="<?php echo URL('search.recommend');?>">可能感性趣的人</a>，赶紧关注他们开始微博之旅吧。 </p>
								<?php endif;?>
                            </div>
                            <!-- end wo tip -->
                        <?php else:?>
                            <!-- ta tip -->
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
                                <p>还没发现值得关注的人呢~ </p>
                            </div>
                            <!-- end ta tip -->
                        <?php endif;?>
                        <!-- end follow empty tip -->
                    <?php else:?>
                        <!-- follow list -->
                        <div class="user-list">
                            <ul id="user_list">
                                <?php if ($list):?>
                                <?php
                                    foreach ($list['users'] as $item):
                                    $isFans = in_array($item['id'], $fids);
                                ?>
                                <li>
                                    <div class="list-content">
                                        <div class="user-pic">
                                            <a href="<?php  echo URL('ta', array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="" title="<?php echo F('escape', $item['screen_name']);?>"/></a>
                                        </div>
                                        <div class="content-r">
                                            <?php if ($uid != $userinfo['id']):?>
                                                <?php if (in_array($item['id'], $fids) || $item['id'] == $uid):?>
                                                <span class="icon-followed icon-bg">已关注</span>
                                                <?php else:?>
                                                <a class="addfollow-btn all-bg"  rel="<?php echo $item['id']?>" href="#"></a>
                                                <?php endif;?>
                                            <?php else:?>
                                                <?php if (in_array($item['id'], $fids)):?>
                                                <div class="icon-each-follow all-bg" title="已互相关注"></div>
                                                <?php endif;?>
                                                <a href="javascript:;" rel="<?php echo $item['id']?>" style="display:none" class="forjs-cancel-att">取消关注</a>
                                                <?php if (in_array($item['id'], $fids)):?>
                                                <a href="javascript:;" style="display:none" rel="<?php echo F('escape', $item['screen_name']);?>" class="forjs-private">发私信</a>
                                                <?php endif;?>
                                            <?php endif;?>
    
                                        </div>
                                        <div class="content-m">
                                            <a class="u-name" href="<?php  echo URL('ta', array('id' => $item['id']));?>" title="<?php echo F('escape', $item['screen_name']);?>">
                                                <?php echo F('escape', $item['screen_name']);?>
												<?php echo F('verified', $item)?>
                                            </a>
                                            <p class="icon-bg <?php if ($item['gender'] == 'f'):?>icon-female<?php elseif ($item['gender'] == 'm'):?>icon-male<?php endif;?>"><?php echo $item['location'];?> 粉丝数：<?php echo $item['followers_count'];?>人</p>
                                            <div class="u-info"><?php if (isset($item['status']['text'])):?><?php echo F('format_text', $item['status']['text']);?><?php endif;?></div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                            <!-- 分页 -->
                            <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                            <!-- end 分页 -->
                        </div>
                        <!-- end follow list -->
                    <?php endif;?>
                </div>
            </div>
            <!-- footer -->
            <?php TPL::plugin('include/footer');?>
            <!-- end footer -->
        </div>
    </div>
</body>
</html>
