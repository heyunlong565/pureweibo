<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $userinfo['screen_name']));?></title>
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
                    <?php TPL::plugin('include/user_preview', array('uInfo' => $userinfo));?> 
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
                        <h3><?php if ($uid == $userinfo['id']):?>我<?php else:?><?php echo F('escape', $userinfo['screen_name']);?><?php endif;?>的微博</h3>
                        
                    </div>
                    
                    <div class="feed-list mblog-list"  id="content">
                    <ul>
                    <li rel="w:<?php echo $mblog_info['id'];?>">
                    <?php
                        $uid = USER::uid();
                        $mblog_info['header'] = 0;
                        $mblog_info['uid'] = $uid;
                        $mblog_info['author'] = true;
						$mblog_info['disable_comment'] = true;
                        TPL::plugin('include/feed', $mblog_info);
                    ?>
                    </li>
                    </ul>
                    </div>
                    <div class="add-comment" id="topCmtBox">
                        <p class="title">发表评论</p>
                        <div class="post-comment-main">
                            <a href="javascript:;" class="icon-face-choose all-bg" rel="e:ic"></a>
                            <div class="comment-r">
                                <textarea class="comment-textarea" id="inputor"></textarea>
                                <div>
                                    <a href="javascript:;" class="general-btn" rel="e:sd"><span>评论</span></a>                       			
                                    <span class="keyin-tips" id="warn">还可以输入<span>140</span>个字</span>
                                    <label><input type="checkbox" id="sync">同时发一条微博</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-list all-comment" id="xwb_cmt_list" wbid="<?php echo $mblog_info['id'];?>">
                        <ul id="cmtCt">
                        </ul>
                        <div class="list-footer hidden" id="pager">
                            <div class="page" id="page">
                                <a class="general-btn" href="javascript:;" id="pre" rel="e:pr"><span>上一页</span></a><a class="general-btn" href="javascript:;" id="next" rel="e:nx"><span>下一页</span></a>
                            </div>
                        </div>
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
