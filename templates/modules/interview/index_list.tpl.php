<!-- 精彩访谈 开始-->
                            	<?php if ( !empty($last) ) { ?>
                                <div class="tit-hd">
                                	<h3>精彩访谈</h3>
                                </div>
                                <div class="talk-newest">
                                	<div class="bd">
                                    	<div class="item">
                                        	<div class="cover">
                                            	<a href="<?php echo URL('interview', array('id'=>$last['id']) ); ?>" target="_blank"><img src="<?php echo $last['cover_img']; ?>" alt="<?php echo $last['title']; ?>" /></a>
                                            </div>
                                            <div class="info">
                                           		<?php if ( isset($last['notice']) && $last['notice'] ) { ?><a class="icon-remind icon-bg" href="#" rel="e:remind,u:<?php echo USER::uid();?>,t:<?php echo F('escape', "在线访谈 \"{$last['title']}\" 即将开始");?>,c:<?php echo F('share_weibo', 'interview_tips', $last);?>,n:<?php echo $last['notice'];?>">提醒我</a> <?php } ?>
                                            	<h4><a href="<?php echo URL('interview', array('id'=>$last['id']) ); ?>" target="_blank"><?php echo $last['title']; ?></a>
                                            		<?php if ($last['status']=='P'){echo '<span class="unplayed">(未开始)</span>'; } elseif ($last['status']=='E'){ echo '<span class="finish">(已结束)</span>'; } else {echo '<span class="active">(进行中)</span>';}?>
                                            	</h4>
                                                <p class="time"><?php echo date($last['dateFormat'], $last['start_time']).'-'.date($last['dateFormat'], $last['end_time'])?></p>
                                            	<p><?php echo $last['desc']; ?></p>
                                            </div>
                                        </div>
                                        <?php if ( is_array($last['guest']) ) { ?>
                                        <div class="guests-list">
                                        	<div class="list-hd">
                                            	<h4>特邀嘉宾</h4>
                                            </div>
                                        	<div class="list-bd" id="scrollor">
                                            	<ul>
                                            		<?php foreach ($last['guest'] as $aGuest) { ?>
                                                	<li>
                                                    	<a class="user-pic" href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>">
                                                    	<img src="<?php echo $aGuest['profile_image_url']; ?>" alt="<?php echo $aGuest['screen_name']; ?>" /></a>
                                                    	<p><a href="<?php echo URL('ta', array('id'=>$aGuest['id'])); ?>"><?php echo $aGuest['screen_name'] . F('verified', $aGuest); ?></a></p>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <a href="#" class="arrow-l-s2 arrow-l-s2-disabled">左</a>
                                            <a href="#" class="arrow-r-s2 <?php if ( count($last['guest'])<6 ) { echo 'arrow-r-s2-disabled'; }?>">右</a>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                                 <?php } ?>
                                <!-- 精彩访谈 结束-->
                                
                                
                                <!-- 更多 开始 -->
                                <?php if ( is_array($list) ) { ?>
                                <div class="tit-hd">
                                	<?php if ( $count>$limit+1 ) {?>
                          		    <a href="<?php echo URL('interview.page'); ?>" class="more">更多&gt;&gt;</a>
                          		    <?php } ?>
                                	<h3>更多推荐</h3>
                                </div>
                                
                                <div class="talk-list">
                                	<?php foreach ($list as $aRecord) {?>
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
                                    <?php } ?>                              
                                </div>
                                <?php } 
                                
                                // 没有访谈时显示提示
                                if ( empty($last) && empty($list) ) { 
                                ?>
								<div class="default-tips">
									<div class="icon-tips all-bg"></div>
									<?php if (USER::get('isAdminAccount')):?>
									<p>还没有在线访谈，你可以在 后台管理中心-扩展工具-在线访谈 添加设置</p>
									<?php else:?>
									<p>还没有在线访谈，你可以看看其他页面。 </p>
									<?php endif;?>
								</div>
                                <?php } ?>
                                <!-- 更多 结束 -->