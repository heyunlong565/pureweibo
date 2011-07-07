<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<?php TPL::plugin('include/css_link');?>
<?php TPL::plugin('include/js_link');?>
<script src="<?php echo W_BASE_URL;?>js/mod/bufferedweibolist.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mod/interview.js"></script>
</head>

<body id="talk-index">
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
                	<div class="talk-hd"><img src="<?php echo ( isset($config['banner_img'])?$config['banner_img']:W_BASE_URL.'img/talk_pic_800.png'); ?>" alt="" /></div>
					<div class="main-wrap">
                        <div class="main">
                            <div class="main-bd">
                            	<!-- 精彩访谈 开始-->
                                <div class="tit-hd">
                                	<h3>精彩访谈</h3>
                                </div>
                                <!-- 精彩访谈 结束-->
                                
                                <div class="talk-list">
		                        <?php 
		                        	if ( is_array($list) )
		                        	{
		                        		foreach ($list as $aRecord) 
		                        		{
		                        ?>
	                            <div class="item">
	                            	<div class="cover">
	                                	<a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><img src="<?php echo $aRecord['cover_img']; ?>" alt="<?php echo $aRecord['title']; ?>" /></a>
	                                </div>
	                                <div class="info">
									<?php if ( isset($aRecord['notice']) && $aRecord['notice'] ) { ?><a class="icon-remind icon-bg" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', "在线访谈 \"{$aRecord['title']}\" 即将开始");?>,c:<?php echo F('share_weibo', 'interview_tips', $aRecord);?>,n:<?php echo $aRecord['notice'];?>">提醒我</a> <?php } ?>
	                                	<h4><a href="<?php echo URL('interview', array('id'=>$aRecord['id']) ); ?>" target="_blank"><?php echo $aRecord['title']; ?></a>
	                                       	<?php if ($aRecord['status']=='P'){echo '<span class="unplayed">(未开始)</span>'; } elseif ($aRecord['status']=='E'){ echo '<span class="finish">(已结束)</span>'; } else {echo '<span class="active">(进行中)</span>';}?>
	                                    </h4>
	                                    <p class="time"><?php echo date($aRecord['dateFormat'], $aRecord['start_time']).'-'.date($aRecord['dateFormat'], $aRecord['end_time'])?></p>
	                                    <p><?php echo $aRecord['desc']; ?></p>
	                                </div>
	                            </div>  
	                            <?php } } else { ?>  
									<div class="default-tips">
										<div class="icon-tips all-bg"></div>
										<?php if (USER::get('isAdminAccount')):?>
										<p>还没有在线访谈，你可以在 后台管理中心-扩展工具-在线访谈 添加设置</p>
										<?php else:?>
										<p>还没有在线访谈，你可以看看其他页面。 </p>
										<?php endif;?>
									</div>
                                <?php } ?>                              
                            	</div>
                            	
	                            <!-- 分页 结束-->
	                            <?php TPL::module('page', array('list'=>$list, 'count'=>$count, 'limit'=>$limit, 'type'=>'event'));?>
	                            <!-- 分页 结束-->
                            </div>
                        </div>
						<div class="aside">
							<!-- 用户信息 开始-->
							<?php Xpipe::pagelet('common.userPreview');?>
							<!-- 用户信息 结束-->
							
							<!-- ad180 开始 -->
							<div class="xad-box xad-box-p3">
								<a href="#" class="icon-close-btn icon-bg"></a>
							</div>
							<!-- ad180 结束 -->
							<!-- 主持人 开始-->
							 <?php Xpipe::pagelet('interview.baseMasterList', array( 'masterList'=>$userlist, 'friendList'=>$friendList ) );?>
							<!-- 主持人 结束-->
                            
                            <!-- 关于 开始-->
							<?php TPL::module('interview/about_live', array( 'about' => isset($config['desc'])?$config['desc']:'' ) ); ?>
							<!-- 关于 结束-->
                            
                            <!-- 联系方式 开始-->
							<?php TPL::module('interview/live_contact', array('contact'=>isset($config['contact'])?$config['contact']:'' )); ?>
							<!-- 联系方式 结束-->
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 开始 -->
			<?php TPL::module('footer'); ?>
			<!-- 尾部 结束 -->
		</div>
	</div>
    
	<!-- 返回顶部 开始-->
	<?php TPL::module('gotop'); ?>
	<!-- 返回顶部 结束-->
    
</body>
</html>
