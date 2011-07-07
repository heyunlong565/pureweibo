						<!-- 访谈内容 开始-->  
                        <div class="title-box">
                        <?php if ( isset($isMaster) ) {?>
                        	<div class="feed-refresh hidden">
                           		<a href="#">有<span></span>条新微博，点击查看</a>
                           	</div>
                        	<h3>访谈内容<span>(共有<em class="que-num"><?php echo $wbList['allAskCnt']; ?></em>个问题 <em class="rep-num"> <?php echo $wbList['answerCnt']; ?></em>个回复)</span></h3>
                        <?php } else { ?>
                        	<h3>访谈内容<span class="close">(已结束，共 <?php echo $wbList['answerCnt']; ?>个回复)</span></h3>
                        <?php } ?>
                        </div>
                        
						<div class="feed-list talk-alllist">
                        	<!-- 问答列表 开始 -->
                            <?php if( $wbList['answerCnt']<=0 ){ ?>
								<div class="default-tips" id="emptyTip">
									<div class="icon-tips all-bg"></div>
									<p>暂时没有微博</p>
								</div>
								<ul id="xwb_weibo_list_ct"></ul>
							<?php } else 
								{ 
									echo '<ul id="xwb_weibo_list_ct">';
									$curUid = 'false';	// 设置为特殊字符，目的不显示删除链接
									
									foreach ($wbList['answerList'] as $aWbTmp)
									{
										// 评论微博
										if ( isset($aWbTmp['comWb']) )
										{
											$wb			= $aWbTmp['comWb'];
											$wb['uid'] 	= $curUid;
										
											echo '<div class="emcee-com"><div class="talk-content" rel="w:'. $wb['id'].'">';
			                                    TPL::module('feed', $wb);
											echo '<div class="emcee-icon"></div></div></div>';
											continue;
										}
										
										
										// 问答微博开始
										if (isset($aWbTmp['askWb']) || isset($aWbTmp['answerWb']))
										{										
											echo '<div class="inte-list">';
											
											// 问微博
											if ( isset($aWbTmp['askWb']) )
											{
												$wb			= $aWbTmp['askWb'];
												$wb['uid'] 	= $curUid;
											
												echo '<div class="talk-content fans-ask" rel="w:'. $wb['id'].'">';
				                                    TPL::module('feed', $wb);
												echo '<div class="ask-icon"></div></div>';
											}
											
											// 答微博
											if ( isset($aWbTmp['answerWb']) && is_array($aWbTmp['answerWb']) )
											{
												foreach ($aWbTmp['answerWb'] as $wb)
												{
													$wb['uid'] = $curUid;
													
													echo '<div class="talk-content guest-reply" rel="w:'. $wb['id'].'">';
				                                    TPL::module('feed', $wb);
													echo '<div class="reply-icon"></div></div>';
												}
											}
											
											echo '</div>';
										}
									}
									echo '</ul>';
								}
								?>
                            
                            <!-- 分页 结束-->
                            <?php 
                            	if ( isset($limit) ) 
                            	{
                            		TPL::module('page', array('list'=>$wbList['answerList'], 'count'=>$wbList['answerCnt'], 'limit'=>$limit, 'type'=>'event'));
                            	}?>
                            <!-- 分页 结束-->
                        </div>
						<!-- 访谈内容 结束-->