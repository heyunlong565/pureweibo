<?php
//$Id: success.tpl.php 13631 2011-04-16 08:29:16Z yaoying $
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>转发成功 - <?php echo F('web_page_title');?></title>
<link href="<?php echo W_BASE_URL ?>css/component/retweet/retweet.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="retweet">
	<div id="wrap">
		<div class="wrap-in">
        	<div class="retweet">
            	<div class="retweet-in">
                    <div class="hd">
                    	<a class="logo-pic" href="<?php echo URL('pub');?>" target="_blank">
                            <img src="<?php 
                                if (V('-:sysConfig/logo',false)){
                                   echo F('fix_url', V('-:sysConfig/logo'));
                                }else{
                                   echo W_BASE_URL. WB_LOGO_DEFAULT_NAME;
                                }
                             ?>" alt="" />
                        </a>
                    </div>
                    <div class="bd">
                    	<div class="succeed">
                            <h3>转发成功！</h3>
                            <?php if(!empty($relateUidData)): ?>
                            <p><a href="<?php echo URL('index.profile');?>" target="_blank">去我的微博</a>看看，或<a href="javascript:window.close();">点击这里</a>关闭窗口</p>
                            <?php else: ?>
                            <p><span id="timer">3</span>秒后窗口自动关闭，<a href="javascript:window.close();">点击这里</a>立即关闭</p>
                            <script>
                                var ms = 3;
                                setTimeout(function(){
                                    ms--;
                                    document.getElementById('timer').innerHTML = ms;
                                    if(ms == 0)
                                        window.close();
                                    else setTimeout(arguments.callee, 1000);
                                }, 1000);
                            </script>
                            <div class="go-weibo-btn"><a href="<?php echo URL('index.profile');?>" target="_blank">去我的微博</a></div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if(!empty($relateUidData)): 
                        		$user_nick = F('escape', $relateUidData['screen_name']);
                        		$user_profile_url = URL('ta', array('id' => (string)$relateUidData['id'], 'name' => $relateUidData['screen_name']));
                        		$location_text = F('format_text', $relateUidData['location']);
                        		$description_text = F('format_text', $relateUidData['description']);
                        ?>
                        <div class="retweet-msg">
                            <a class="user-pic" href="<?php echo $user_profile_url;?>" target="_blank"><img alt="<?php echo $user_nick;?>的头像" src="<?php echo $relateUidData['profile_image_url']; ?>" /></a>
                            <?php if($relateUidData['id'] != USER::uid()): ?>
                        	    <?php if(!$friendshipExist): ?>
                                <a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
                                <?php else: ?>
                                <span class="followed-btn">已关注</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="msg-content">
                                <a title="<?php echo $user_nick;?>" class="nick" href="<?php echo $user_profile_url;?>" target="_blank"><?php echo $user_nick;?><?php echo F('verified', $relateUidData);?></a>
                                <p><?php echo $location_text; ?></p>
                                <p><?php echo $description_text; ?></p>
                            </div>                        
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>
