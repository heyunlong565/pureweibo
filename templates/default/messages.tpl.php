<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="messages" class="own">
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
                        <a class="btn-send-mes" href="#" rel="e:sdm">发私信</a>	
                        <h3>我的私信</h3>
                    </div>
                    
                    <?php if (empty($list)):?>
                        <div class="default-tips">
                            <div class="icon-tips all-bg"></div>
							<?php if (V('g:page', 1) > 1):?>
							<p>已到最后一页</p>
							<?php else:?>
                            <p>还没有收到或发出任何私信</p>
							<?php endif;?>
                        </div>
                    <?php else:?>
                        <div class="comment-list all-comment message-list">
                            <ul id="messageList">
                                <?php foreach ($list as $item):?>
                                <li rel="m:<?php echo $item['id'];?>">
                                    <div class="<?php if ($item['sender']['id'] == USER::uid()):?>sendbyme <?php endif;?>message-part">
                                        <div class="user-pic">
                                            <a href="<?php if ($item['sender']['id'] == USER::uid()):?><?php echo URL('index');?><?php else:?><?php echo URL('ta',array('id' => $item['sender']['id']));?><?php endif;?>"><img src="<?php echo APP::F('profile_image_url', $item['sender']['profile_image_url']);?>" alt="" /></a>
                                        </div>
                                        <div class="comment-c">
                                            <p class="c-info">
                                            <?php if ($item['sender']['id'] == USER::uid()):?>
                                                <a href="<?php echo URL('index');?>"> 我</a>发送给<a href="<?php  echo URL('ta',array('id' => $item['recipient']['id']));?>"><?php echo $item['recipient']['screen_name'];?></a>
                                            <?php else:?>
                                                <a href="<?php  echo URL('ta',array('id' => $item['sender']['id']));?>"><?php echo $item['sender']['screen_name'];?></a>
                                            <?php endif;?>
                                            <?php echo APP::F('format_text', $item['text']);?>  (<?php echo APP::F('format_time', $item['created_at']);?>) </p>
                                            <div class="c-for">
                                                <?php if ($item['sender']['id'] != USER::uid()):?>
                                                <a class="icon-reply icon-bg" href="javascript:;" rel="e:rm,n:<?php echo $item['sender']['screen_name']?>,u:<?php echo $item['sender']['id'];?>">回复</a>
                                                <?php endif;?>
                                                <a class="icon-del icon-bg hidden" id="del" href="javascript:;" rel="e:dm">删除</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
    
                            <!-- 分页 -->
                            <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                            <!-- end 分页 -->
                        </div>
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

