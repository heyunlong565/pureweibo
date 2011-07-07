<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, V('g:skinset', false)? '模板设置' : false);?></title>
<?php TPL::plugin('include/css_link');?>
<?php
if(trim(V('g:skinset')) == 1):
?>
<link href="<?php echo W_BASE_URL ?>css/default/skin_set.css" rel="stylesheet" type="text/css" />
<?php
endif;
?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="home" class="own">
	<?php 
		if(trim(V('g:skinset')) == 1) {
			Xpipe::pagelet('common.userSkin');
		}
	?>
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav'); ?>
					<!-- 站点导航 结束 -->
				</div>
				<div class="content">
					<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                                <!-- 微博发布框 开始-->
								<?php Xpipe::pagelet('weibo.input'); ?>
                                <!-- 微博发布框 结束-->
                                <!-- 微博列表 开始-->                	
                                
				<?php if (empty($list) && empty($filter_type)):?>
					<!-- 初始化页面 -->
					<div class="index-default">
					<?php if (V('g:page', 1) > 1):?>
						<div class="default-tips">
							<div class="icon-tips all-bg"></div>
							<p>已到最后一页</p>
						</div>
					<?php else:?>
						<div class="default-tips">
							<div class="icon-tips all-bg"></div>
							<p>您还没有微博信息。</p>
							<p>想看更多微博？<br />你可以<a href="<?php echo URL('search.recommend');?>">关注更多的人</a>，或者在<a href="javascript:$('#publish_box textarea').focus(),void(0);">上方输入框</a>里，说说身边的新鲜事儿。</p>
						</div>
						<?php Xpipe::pagelet('user.hotUser'); ?>
						<?php endif;?>
					</div>
					<!-- end 初始化页面 -->
				<?php
					else:
						//聚焦位
						$fc = DS('Plugins.get', 'g1/86400', 2);

						// 手动关闭后有cookie['fc_ad']
						if ($fc['in_use'] && !isset($_COOKIE['fc_ad'])) {
							$ct = DS('dsIndexFocus.get', 0);
				?> 
				<div style="background: url(<?php echo F('fix_url', ($ct['bg_pic']? $ct['bg_pic']: 'var/data/index/ad_pic.png'));?>) no-repeat scroll 0% 0% transparent;" class="ad-pic" id="focus_index">
					<div class="ad-pic-con">
						<h3><?php echo F('escape', $ct['title']);?></h3>
						<p><?php echo F('escape', $ct['text']);?></p>
					</div>
					<a title="点击关闭" href="#" rel="e:cls,cn:fc_ad" class="icon-close-btn icon-bg"></a>
					<a class="ad-pic-btn" rel="e:do,op:<?php echo $ct['oper'];?>,tp:<?php echo $ct['topic'];?>,ln:<?php echo urlencode($ct['link']);?>" href="#"><?php echo F('escape', $ct['btnTitle']);?></a>
				</div>
				<?php
						};
				?>
				<?php
				$param = array('list' => $list,
					'limit'=>$limit, 
					'not_found_msg' => '找不到符合条件的微博，返回查看<a href="'. URL('index') . '">全部微博</a>',
					'list_title'=>'我的首页',
					'filter_type'=>$filter_type);
				Xpipe::pagelet('weibo.weiboList', $param );
				?>

				<?php endif;?>
				<!-- 微博列表 结束-->
                            </div>
                        </div>
						<div class="aside">
							<!-- 用户信息 开始-->
							<?php Xpipe::pagelet('common.userPreview');?>
							<?php //Xpipe::pagelet('common.userMenu');?>
							<!-- 用户标签 开始-->
							<?php TPL::module('user_tag');?>    
							<?php Xpipe::pagelet('common.sideComponents', array('type'=>2) );?>
							<!-- 关注的话题 -->
							<?php Xpipe::pagelet('common.subjectFollowed',USER::uid()); ?>
							<!-- 关注的话题 -->	
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 开始 -->
			<?php TPL::module('footer');?>
			<!-- 尾部 结束 -->
		</div>
	</div>
	<?php TPL::module('gotop');?>
</body>
</html>
<!-- report -->
<img src="<?php echo F('report');?>" class="hidden"/>
