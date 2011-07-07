<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/pub.css" rel="stylesheet" type="text/css" />
</head>
<body id="pub">
	<div id="wrapper">    
    	<div class="wrapper-in">	
			<?php TPL::plugin('include/header');?>
            <div class="tab-s1">
                <span class="cut"><a hideFocus="true" href="<?php echo URL('pub');?>">广场首页</a></span>
                <span><a hideFocus="true" href="<?php echo URL('pub.look');?>">随便看看</a></span>
                <span class="current"><a hideFocus="true" href="<?php echo URL('pub.topics');?>">话题排行榜</a></span>
                <div class="tab-l"></div>
                <div class="tab-r"></div>
            </div>
            <div id="container" class="single">
                <div class="main">
                    
                    <!-- 话题排行榜 开始-->
                    <div class="ranking-topic">
                        <div class="r-t-con">
                            <div class="r-t-item">
                                <div class="top10">
                                    <div class="sidebar-head">1小时话题榜</div>
                                    <ul>
									<?php

										if (!empty($hours)){
										
											$count = 0;

											foreach ($hours as $row) {
												$count++;
									?>
                                         <li>
                                            <div class="ranking<?php if ($count<4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
                                            <a href="<?php echo URL('search.weibo', array('k' => $row['query']));?>"><?php echo F('escape', $row['name']);?></a>
                                        </li>
									<?php
											}
										}
									?>
                                    </ul>
                                </div>
                            </div>
                            <div class="r-t-item">
                                <div class="top10">
                                    <div class="sidebar-head">今日话题榜</div>
                                    <ul>
                                         <?php

										if (!empty($days)){
										
											$count = 0;

											foreach ($days as $row) {
												$count++;
									?>
                                         <li>
                                            <div class="ranking<?php if ($count<4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
                                            <a href="<?php echo URL('search.weibo', array('k' => $row['query']));?>"><?php echo F('escape', $row['name']);?></a>
                                        </li>
									<?php
											}
										}
									?>
                                    </ul>
                                </div>
                            </div>
                            <div class="r-t-item last-item">
                                <div class="top10">
                                    <div class="sidebar-head">本周话题榜</div>
                                    <ul>
                                     <?php

										if (!empty($weeks)){

											$count = 0;

											foreach ($weeks as $row) {
												$count++;
									?>
                                         <li>
                                            <div class="ranking<?php if ($count<4):?> r-<?php echo $count;?><?php endif;?> skin-bg"><?php echo $count;?></div>
                                            <a href="<?php echo URL('search.weibo', array('k' => $row['query']));?>"><?php echo F('escape', $row['name']);?></a>
                                        </li>
									<?php
											}
										}
									?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 话题排行榜 结束-->
                    
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
