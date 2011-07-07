<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/form.css" rel="stylesheet" type="text/css" />
</head>
<body id="blacklist">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
            <div id="container" class="single">
                <div class="main userinfo">
                    <div class="form xform-normal">
                        <!-- 个人设置 开始-->
                        <?php TPL::plugin('include/user_setting');?>
                        <!-- 个人设置 结束-->
                        <!--个人资料 开始-->
                        <div id="infomation" class="form-body">
                            <div class="form-info">
                                <p>被加入黑名单的用户将无法关注你、评论你。如果你已经关注他，也会自动解除关系。</p>
                            </div>
							<?php if (empty($blacklist)):?>
                            <div class="blacklist-con">
                                <p>还没有人被你拉入黑名单呢。</p>
                            </div>
							<?php else:?>
                            <div class="blacklist-con">
                                <p>已被您加入黑名单的用户：</p>
                                <?php 
									foreach ($blacklist as $item):
									$id = $item['blocked_user']['user']['id'];
								?>
                                <div class="blacklist" rel="u:<?php echo $id;?>">
                                    <span class="operate"><a href="#" rel="e:dbl">解除</a></span>
                                    <span class="date"><?php echo $item['blocked_user']['add_time'];?></span>
                                    <span class="username"><a href="<?php echo URL('ta', array('id' => $id, 'name' => $item['blocked_user']['user']['screen_name']));?>"><?php echo F('escape', $item['blocked_user']['user']['screen_name']);?></a></span>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </div>
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
