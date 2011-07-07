<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的活动 - Powered By X微博</title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="events">
	<div id="wrap">
		<div class="wrap-in">
			<?php TPL::plugin('include/header');?>
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
                            	<div class="events-title">
                                	<h3>活动</h3>
                                </div>
                                <div class="tab-s2">
								<span><span><a href="<?php echo URL('event');?>">热门推荐</a></span></span>
								<span class="current"><span><a href="<?php echo URL('event.mine');?>">我的活动</a></span></span>
                                </div>
                                <div class="tab-s4">
								<a <?php if ($type == 'attend'):?>class="current"<?php endif;?> href="<?php echo URL('event.mine', 'type=attend');?>">我参加的</a><a <?php if ($type != 'attend'):?>class="current"<?php endif;?> href="<?php echo URL('event.mine', 'type=create');?>">我发起的</a>
                                </div>
                                <div class="event-box">
									<?php Xpipe::pagelet('event.eventlist', array('type' => $type));?>
                                </div>
                            </div>
						</div>
						<div class="aside">
						<div class="launch-event-btn"><a href="<?php echo URL('event.create');?>">发起活动</a></div>
                            <!--最新活动 开始-->
							<?php Xpipe::pagelet('event.sideNewsEvents');?>
                            <!--最新活动 结束-->
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 开始 -->
			<?php TPL::module('footer');?>
			<!-- 尾部 结束 -->
		</div>
	</div>
</body>
</html>
