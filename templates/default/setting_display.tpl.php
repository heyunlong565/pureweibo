<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
</head>
<body id="display">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main userinfo">
                    <div class="form xform-normal">
                        <!-- 个人设置 开始-->
                        <?php TPL::plugin('include/user_setting');?>
                        <!-- 个人设置 结束-->
                        <!--显示设置 开始-->
                        <form id="showForm">
                        <div id="showSetting" class="form-body">
                            <div class="form-info">
                                <p>请选择以下情况的显示方式</p>
                            </div>
                            <div class="setting-box">
                                <strong>每页微博显示数量</strong>
                                <p>请选择在我的首页、我的微博、他人的首页、我的收藏、@提到我的页面中，每页显示微博数量</p>
                                <div class="radio-box">
                                    <label><input name="feedtotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 10):?>checked="checked"<?php endif;?> />10条</label>
                                    <label><input name="feedtotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 20):?>checked="checked"<?php endif;?> />20条</label>
                                    <label><input name="feedtotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 30):?>checked="checked"<?php endif;?> />30条</label>
                                    <label><input name="feedtotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 40):?>checked="checked"<?php endif;?> />40条</label>
                                    <label><input name="feedtotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 50):?>checked="checked"<?php endif;?> />50条</label>
                                </div>
                                <strong>每页评论显示数量</strong>
                                <p>请选择在我的评论、单条微博的全部评论页面中，每页显示评论数量</p>
                                <div class="radio-box bottom-line">
                                    <label><input name="commenttotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 10):?>checked="checked"<?php endif;?> />10条</label>
                                    <label><input name="commenttotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 20):?>checked="checked"<?php endif;?> />20条</label>
                                    <label><input name="commenttotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 30):?>checked="checked"<?php endif;?> />30条</label>
                                    <label><input name="commenttotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 40):?>checked="checked"<?php endif;?> />40条</label>
                                    <label><input name="commenttotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 50):?>checked="checked"<?php endif;?> />50条</label>
                                </div>
                            </div>
                            <div class="form-row submit-btn">
                                <a href="#" class="general14-btn" id="trig"><span>保存</span></a>
                            </div>
                        </div>
                        <input type="submit" class="hidden" />
                        </form>
                        <!--显示设置 结束-->
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/mysetting.js"></script>
</body>
</html>
