<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', F('escape', $userinfo['screen_name']));?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="weibo_user">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
            <div id="container">
                <div class="sidebar">
                    <div class="user-preview">
                        <div class="v-verified all-bg"></div>
                        <!-- 用户关注、粉丝、微博信息总数 开始-->
                        <?php TPL::plugin('include/user_total', array('uInfo' => $userinfo));?>    
                        <!-- 用户关注、粉丝、微博信息总数 结束-->
                    </div>
					<!-- 标签 -->
					<?php TPL::plugin('include/user_tag', array('userinfo'=> $userinfo));?>    
					<!-- end 标签 -->
    
                    <!-- fans -->
                    <div class="user-sidebar">
                    <div class="sidebar-head"><?php echo F('escape', $userinfo['screen_name']);?>粉丝（<?php echo $userinfo['followers_count'];?>）</div>
                        <ul>
                            <?php if ($followers):?>
                            <?php foreach ($followers as $item):?>
                            <li>
                                <a href="<?php  echo URL('ta',array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="<?php echo htmlspecialchars($item['screen_name']);?>" /></a>
                                <p><a href="<?php echo URL('ta',array('id' => $item['id']));?>"><?php echo F('escape', $item['screen_name']);?></a></p>
                            </li>
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                        <?php if ($userinfo['followers_count'] > 9):?>
                            <a href="<?php echo URL('ta.fans', 'id='.$userinfo['id']);?>" class="more-user">更多</a>
                        <?php endif;?>
                    </div>
                    <!-- end fans -->
                              
                </div>
                <div class="main">
                    <?php TPL::plugin('include/user_head', array('userinfo' => $userinfo, 'fids' => $fids));?>     
                    <div class="user-list">
                         <div class="tit-s1">
                         <h3><?php echo F('escape', $userinfo['screen_name']);?>的关注(<?php echo $userinfo['friends_count'];?>)</h3>
                        </div>
                        <?php if (empty($list['users'])):?>
                            <!-- ta tip -->
                            <div class="default-tips">
                                <div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
                                <p>已到最后一页</p>
								<?php else:?>
                                <p><?php echo F('escape', $userinfo['screen_name']);?>还没有关注任何人</p>
								<?php endif;?>
                            </div>
                            <!-- end tip -->
                        <?php else:?>
                        <ul>
                            <?php foreach ($list['users'] as $item):?>
                            <li rel="u:<?php echo $item['id'];?>">
                                <div class="list-content">
                                    <div class="user-pic">
                                        <a href="<?php  echo URL('ta', array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="" /></a>
                                    </div>
                                    <div class="content-r">
                                        <?php if (in_array($item['id'], $fids) || $item['id'] == USER::uid()):?>
                                            <span class="followed-btn">已关注</span>
                                        <?php else:?>
                                            <a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
                                        <?php endif;?>
                                    </div>
                                    <div class="content-m">
                                        <a class="u-name" href="<?php echo URL('ta', array('id' => $item['id']));?>">
                                            <?php echo F('escape', $item['screen_name']);?>
                                            <?php echo F('verified', $item);?>
                                        </a>
                                        <p class="icon-bg <?php if ($item['gender'] == 'f'):?>icon-female<?php elseif ($item['gender'] == 'm'):?>icon-male<?php endif;?>"><?php echo F('escape', $item['location']);?> 粉丝数：<?php echo $item['followers_count'];?>人</p>
                                        <div class="u-info"><a href="<?php echo URL('ta', array('id' => $item['id']));?>"><?php if (isset($item['status']['text'])):?><?php echo F('format_text', $item['status']['text'], 'comments');?><?php endif;?><?php if (isset($item['status']['created_at'])):?>(<?php echo F('format_time', $item['status']['created_at']);?>)<?php endif;?></a></div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
    
        
        
    <div class="pop-window send-window fixed-window hidden ">
    	<div class="pop-t"></div>
        <div class="pop-content">
        	<h4 class="pop-title x-bg"><a class="icon-close-btn icon-bg" href="#"></a>&nbsp;发私信</h4>
            <div class="send-box">
               
                <div class="field"><label>发私信给:</label><input type="text" /><em class="warn warn-pos">她还没有关注你,暂时不能发私信</em></div>
                <div class="field"><label>私信内容:</label><textarea></textarea></div>
                <div class="field pad">
                  <div class="icon-face-choose all-bg fl"></div>
                  <div class="fr">
                    <span class="tips fl">说明:长度不能超过300个字</span>
                    <em class="warn fl hidden">这里是提示信息</em>
                    <a class="general-btn highlight fl" href="javascript:;"><span>发送</span></a>
                  </div>
                </div>
             </div>
        </div>
        <div class="pop-b"></div>
        <div class="pop-tl all-bg"></div>
        <div class="pop-tr all-bg"></div>
        <div class="pop-bl all-bg"></div>
        <div class="pop-br all-bg"></div>
    </div>
    
    <div class="shade-div hidden"></div>
</body>
</html>

