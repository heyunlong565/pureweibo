<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<link href="<?php echo W_BASE_URL ?>css/default/pub.css" rel="stylesheet" type="text/css" />
<?php TPL::plugin('include/js_link');?>
</head>
<body id="events">
	<div id="wrap">
		<div class="wrap-in">
			<?php TPL::plugin('include/header');?>
			<div id="container">
				<div class="content">
					<div class="main">
						<div class="events-title">
							<h3><?php LO('events__defaultAction__event');?></h3>
						</div>
						<div class="tab-s2">
							<span class="current"><span><a href="#"><?php LO('events__defaultAction__hotRec');?></a></span></span>
							<span><span><a href="<?php echo URL('event.mine');?>"><?php LO('events__defaultAction__myEvent');?></a></span></span>
						</div>
						<div class="event-box">
							<?php Xpipe::pagelet('event.eventlist', array('type' => 'hot'));?>
						</div>
					</div>
				</div>
				<div class="aside">
				<div class="launch-event"><a class="btn-launch-event" href="<?php echo URL('event.create');?>"><?php LO('events__common__create');?></a></div>
                            <!--最新活动 开始-->
							<?php Xpipe::pagelet('event.sideNewsEvents');?>
                            <!--最新活动 结束-->
						<?php echo F('show_ad', 'sidebar', '');?>
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
