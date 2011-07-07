						<div class="feed-list">
                            <!--feed标题，信息过滤-->
                            <div class="feed-tit">
                                <div class="talk-tab">
                                	<span <?php if (!isset($wbList['allList'])){ echo 'class="cur"'; } ?> ><span>
                                		<a href="<?php echo URL('interview', array('id'=>$interview['id'])) ?>">我的问题</a>
                                	</span></span>
                                	<span <?php if (isset($wbList['allList'])){ echo 'class="cur"'; } ?> ><span>
                                		<a href="<?php echo URL('interview', array('id'=>$interview['id'], 'type'=>'all')); ?>">所有问题</a>
                                	</span></span>
                                </div>
                                <div class="feed-refresh hidden">
                                    <a href="#">有<span></span>条新微博，点击查看</a>
                                </div>
                            </div>
                            
                            <!-- 我的问题微博列表  开始-->
                            <?php if( $wbList['myCnt']<=0 ){ ?>
                            	<div class="default-tips" id="emptyTip">
									<div class="icon-tips all-bg"></div>
									<p>暂时没有微博</p>
								</div>
								<ul id="xwb_weibo_list_ct"></ul>
							<?php } else { ?>
							
								<ul id="xwb_weibo_list_ct">
								<?php
									$currentUid = USER::uid();
									foreach ($wbList['myList'] as $aWbTmp)
									{
										if ( isset($aWbTmp['askWb']['id']) ) 
										{
											$wb			= $aWbTmp['askWb'];
											$wb['uid'] 	= $currentUid;
											
											echo '<li rel="w:'.$wb['id'].'">';
												TPL::module('interview/feed_withAnswer', $wb);
											echo '</li>';
										}
									}
								}
								?>
								</ul>
							<!-- 我的问题微博列表  结束-->
							
                            <!-- 分页 结束-->
                           <?php TPL::module('page', array('list'=>$wbList['myList'], 'count'=>$wbList['myCnt'], 'limit'=>$limit, 'type'=>'event'));?>
                            <!-- 分页 结束-->
                        </div>