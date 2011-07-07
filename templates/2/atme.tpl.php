<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
</head>
<body id="atme" class="own">
	<div id="wrap">
		<div class="wrap-in">
			<!-- 头部 开始-->
			<?php TPL::plugin('include/header');?>
            <!-- 头部 结束-->
			<div id="container">
				<div class="extra">
					<!-- 站点导航 开始 -->
					<?php Xpipe::pagelet('common.siteNav');?>
					<!-- 站点导航 结束 -->
				</div>
				<div class="content">
					<div class="main-wrap">
						<div class="main">
                        	<div class="main-bd">
                                <!-- 微博发布框 开始-->
                                <!-- 微博发布框 结束-->
								<?php Xpipe::pagelet('weibo.input');?>
                                <!-- 微博列表 开始-->
								<?php
								$param = array(
									'not_found_msg' => '找不到符合条件的微博，返回查看<a href="'. URL('index') . '">全部微博</a>',
									'list_title'=>'提到我的',
									'empty_msg' => '目前，还没有人提到你呢，敬请期待。',
									);
								Xpipe::pagelet('weibo.atme', $param );
								?>
								<!-- 微博列表 结束-->
                            </div>
						</div>
						<div class="aside">
							<!-- 用户信息 开始-->
							<?php Xpipe::pagelet('common.userPreview');?>
							<!-- 用户标签 开始-->
							<?php Xpipe::pagelet('common.userTag');?>
							<?php Xpipe::pagelet('common.sideComponents', array('type'=>2) );?>
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
