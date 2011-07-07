<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="comments">
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
                            <h3>我的评论</h3>
                        </div>                
                        
                        <div class="comment-list" id="xwb_cmt_list">
                            <div class="tab-s2">
                                <span><a href="<?php echo URL('index.comments');?>">收到的评论</a></span>
                                <span class="current"><a href="javascript:void(0)">发出的评论</a></span>
                            </div>
                        <?php if (empty($list)):?>
                            <!-- comments list empty tip -->
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
                                <p>已到最后一页</p>
								<?php else:?>
                                <p>暂时还没有发表任何评论</p>
								<?php endif;?>
                            </div>
                            <!-- end comments list empty tip -->
                        <?php else:?>
                        <!-- comments list -->
                            <div class="list-handle">
                                <!-- 
                                <span class="total">143条</span>
                                -->
                                <label><input type="checkbox" rel="e:sa" />全选</label><em>|</em><a href="javascript:;" rel="e:da">删除</a>
                            </div>
                            <ul id="cmtCt">
                                <?php if ($list):?>
                                <?php foreach ($list as $item):?>
                                <?php 
                                    if (isset($item['filter_state']) && ($item['filter_state'] / 10) < 1) {
                                        continue;	
                                    }
                                ?>
                                <?php if (!isset($item['status'])) { continue;};?>
                                <li rel="c:<?php echo $item['id'];?>,w:<?php echo $item['status']['id'];?>">
                                    <label class="checkbox"><input type="checkbox" rel="cdl" /></label>
                                    <div class="comment-list-main">
                                        <div class="user-pic">
                                            <a href="<?php  echo URL('ta',array('id' => $item['user']['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['user']['profile_image_url']);?>" alt="" title="<?php echo F('escape', $item['user']['screen_name']);?>" /></a>
                                        </div>
                                        <div class="comment-c">
                                            <p class="c-info"><?php echo APP::F('format_text', $item['text']);?>&nbsp;(<?php echo APP::F('format_time', $item['created_at']);?>)</p>
                                            <div class="c-for">
                                                <a class="icon-del icon-bg hidden" href="javascript:;" rel="e:dl">删除</a>
                                                <p>评论<a href="<?php  echo URL('ta',array('id' => $item['status']['user']['id']));?>"><?php echo F('escape', $item['status']['user']['screen_name']);?><?php echo F('verified', $item['status']['user']);?></a>的微博：<a href="<?php  echo URL('show',array('id' => $item['status']['id']));?>"><?php echo APP::F('format_text', $item['status']['text'], 'comment');?></a></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
        
                            <div class="list-handle">
                                <!--
                                <span class="total">143条</span>
                                -->
                                <label><input type="checkbox" rel="e:sa" />全选</label><em>|</em><a href="javascript:;" rel="e:da">删除</a>
                            </div>
                            <!-- 分页 -->
                            <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                            <!-- end 分页 -->
                        </div>
                        <!-- end comments list -->
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <?php TPL::plugin('include/footer');?>
            <!-- end footer -->
        </div>
    </div>
</body>
</html>
