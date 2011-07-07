                    <?php if (!USER::isUserLogin()):?>
                    <div class="weibo-notice">
                        <!-- 用户未登录显示 开始-->
                        <p class="login-notice">本页仅显示了“<?php echo F('escape', $userinfo['screen_name']);?>”的最近20条微博，<a href="#" rel="e:lg">登录</a>之后可以查看Ta的所有微博</p>
                        <!-- 用户未登录显示 结束-->
    
                        <?php if (isset($userinfo['is_localsite_user']) && $userinfo['is_localsite_user'] == 0):?>
                        <!-- 对方未登录过此微博显示 开始-->
						<p class="copyright"><?php echo F('escape', $userinfo['screen_name']);?>未登录<?php echo F('escape', V('-:sysConfig/site_name'));?>，此处信息均来自新浪微博，Powered By <a href="http://weibo.com/" target="_blank">新浪微博</a></p>
                        <!-- 对方未登录过此微博显示 结束-->
                        <?php endif;?>
                    </div>
                    <?php else:?>
                        <?php if (isset($userinfo['is_localsite_user']) && $userinfo['is_localsite_user'] == 0):?>
                        <div class="weibo-notice">
                            <!-- 对方未登录过此微博显示 开始-->
                            <p class="copyright"><?php echo F('escape', $userinfo['screen_name']);?>未登录<?php echo F('escape', V('-:sysConfig/site_name'));?>，此处信息均来自新浪微博，Powered By <a href="http://weibo.com/" target="_blank">新浪微博</a></p>
                            <!-- 对方未登录过此微博显示 结束-->
                        </div>
                        <?php endif;?>
                    <?php endif;?>