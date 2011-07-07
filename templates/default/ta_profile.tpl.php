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
                    <?php echo F('verified', $userinfo, 'profile');?>
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
                                <a href="<?php  echo URL('ta',array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="<?php echo F('escape', $item['screen_name']);?>" /></a>
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
                    <?php $fids = isset($fids) ? $fids : false;?>
                    <?php TPL::plugin('include/user_head', array('userinfo' => $userinfo, 'fids' => $fids));?>     
                    <?php TPL::plugin('include/login_banner');?>
                    
                    <?php if (empty($list)):?>
                        <div class="default-tips">
                            <div class="icon-tips all-bg"></div>
							<?php if (V('g:page', 1) > 1):?>
							<p>已到最后一页</p>
							<?php else:?>
                            <p><?php echo F('escape', $userinfo['screen_name']);?>还没有开始发微博，请等待。</p>
							<?php endif;?>
                        </div>
                    <?php else:?>
                    <div class="feed-list mblog-list">
                        <div class="feed-tit">
                            <h3><?php echo F('escape', $userinfo['screen_name']);?>的微博</h3>
                        </div>
                        <!-- 微博列表 -->
                        <?php TPL::plugin('include/feedlist', array('list' => $list, 'header' => '0', 'author' => false));?>
                        <!-- end 微博列表 -->
                        <?php if (USER::isUserLogin()):?>
                        <?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
                        <?php endif;?>
                    </div>
					<?php endif;?>
                    <?php 
                        $isCome = DS('mgr/userCom.getByUid','p',$userinfo['id']);
                    ?>
                    <?php if (!USER::isUserLogin()):?>
                    <div class="weibo-notice">
                        <!-- 用户未登录显示 开始-->
                        <p class="login-notice">本页仅显示了“<?php echo F('escape', $userinfo['screen_name']);?>”的最近20条微博，<a href="#" rel="e:lg">登录</a>之后可以查看Ta的所有微博</p>
                        <!-- 用户未登录显示 结束-->
    
                        <?php if (empty($isCome)):?>
                        <!-- 对方未登录过此微博显示 开始-->
						<p class="copyright"><?php echo F('escape', $userinfo['screen_name']);?>未登录<?php echo F('escape', V('-:sysConfig/site_name'));?>，此处信息均来自新浪微博，Power By <a class="icon-weibo icon-bg" href="http://t.sina.com.cn/" target="_blank">新浪微博</a></p>
                        <!-- 对方未登录过此微博显示 结束-->
                        <?php endif;?>
                    </div>
                    <?php else:?>
                        <?php if (empty($isCome)):?>
                        <div class="weibo-notice">
                            <!-- 对方未登录过此微博显示 开始-->
                            <p class="copyright"><?php echo F('escape', $userinfo['screen_name']);?>未登录<?php echo F('escape', V('-:sysConfig/site_name'));?>，此处信息均来自新浪微博，Power By <a class="icon-weibo icon-bg" href="http://t.sina.com.cn/" target="_blank">新浪微博</a></p>
                            <!-- 对方未登录过此微博显示 结束-->
                        </div>
                        <?php endif;?>
                    <?php endif;?>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
<!-- report -->
<script src="<?php echo F('report', 'ta', 'src', $userinfo['id']);?>"></script>
