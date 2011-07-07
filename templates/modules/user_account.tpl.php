						<div id="showSetting" class="form-body">
                            <div class="form-info">
                                <p>您已经将新浪微博帐号与本网站绑定使用，您可以在本页面取消此绑定关系。</p>
                            </div>
                        </div>
                        <div class="tags-title"><p><strong>微博帐号：<?php echo USER::uid();?></strong></p></div>
                        <div class="account-set">
                            <div class="logo-pic">
                                <div class="logo1">
									<?php 
                                        if (V('-:sysConfig/logo',false)){
                                            echo '<img src="'.W_BASE_URL_PATH.V('-:sysConfig/logo').'"/>';
                                        }else{
                                            echo '<img src="'.W_BASE_URL_PATH.WB_LOGO_DEFAULT_NAME.'"/>';
                                        }
                                    ?>
                            	</div>
                                <div class="logo2"><img src="<?php echo W_BASE_URL_PATH;?>var/data/logo/sina_logo.png" alt="" /></div>
                                <div class="icon-two-way"></div>
                            </div>
                            <div class="btn-area">
                                <a href="<?php echo URL('account.unBind')?>" class="general14-btn" id="unbind"><span>取消绑定</span></a>
							</div>
						</div>
                        <div class="tags-title"><p>关于绑定：</p></div>
                        <div class="about-tags-list">
                            <p>&middot;将新浪微博帐号绑定网站之后，您可以在此网站上使用微博功能，并能与新浪微博共享数据。</p>
                            <p>&middot;取消绑定后，您将无法继续在本网站使用微博相关功能。</p>
                            <p>&middot;当前正在使用新浪微博，如需修改密码，请<a href="http://login.sina.com.cn/member/security/password.php" target="_blank">点击</a>此处。</p>
                        </div>
