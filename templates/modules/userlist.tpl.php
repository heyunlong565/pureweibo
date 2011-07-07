									<ul>
										<?php foreach ($list['users'] as $item):?>
										<li rel="u:<?php echo $item['id'];?>,n:<?php echo F('escape', $item['screen_name']);?>">
											<div class="list-content">
												<div class="user-pic">
													<a href="<?php  echo URL('ta', array('id' => $item['id']));?>"><img src="<?php echo APP::F('profile_image_url', $item['profile_image_url']);?>" alt="" /></a>
												</div>
												<div class="content-r">
												<?php $r = APP::getRequestRoute(1);if ($r['function'] == 'fans') {?>
													<?php if (USER::uid() != $userinfo['id']):?>
														<?php if (in_array($item['id'], $fids) || $item['id'] == USER::uid()):?>
															<span class="followed-btn">已关注</span>
														<?php else:?>
															<a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
														<?php endif;?>
													<?php else:?>
														<?php if (in_array($item['id'], $fids)):?>
														<div class="icon-each-follow all-bg" title="已互相关注"></div>
														<a href="javascript:;" id="removeFans" class="hidden" rel="e:dfan">移除粉丝</a>
														<?php else:?>
														<a rel="e:fl,t:1" class="addfollow-btn" href="#">加关注</a>
													<?php endif;?>
														<a href="javascript:;" rel="e:sdm,n:<?php echo F('escape', addslashes($item['screen_name']));?>" id="sendMsg" class="hidden">发私信</a>
													<?php endif;?>

												<?php } else {?>
													<?php if (USER::uid() != $userinfo['id']):?>
														<?php if (in_array($item['id'], $fids) || $item['id'] == USER::uid()):?>
															<span class="followed-btn">已关注</span>
														<?php else:?>
														<a class="addfollow-btn all-bg"  rel="e:fl,t:1" href="#"></a>
														<?php endif;?>
													<?php else:?>
														<?php if (in_array($item['id'], $fids)):?>
														<div class="icon-each-follow all-bg" title="已互相关注"></div>
														<?php endif;?>
														<a href="javascript:;" rel="e:ufl" class="hidden" id="removeFans">取消关注</a>
														<?php if (in_array($item['id'], $fids)):?>
														<a href="javascript:;" rel="e:sdm" class="hidden" id="sendMsg">发私信</a>
														<?php endif;?>
													<?php endif;?>
												<?php }?>
												</div>
												<div class="content-m">
													<a class="u-name" href="<?php echo URL('ta', array('id' => $item['id']));?>">
														<?php echo F('escape', $item['screen_name']);?>
														<?php echo F('verified', $item);?>
													</a>
													<p class="icon-bg <?php if ($item['gender'] == 'f'):?>icon-female<?php elseif ($item['gender'] == 'm'):?>icon-male<?php endif;?>"><?php echo F('escape', $item['location']);?> 粉丝数：<?php echo $item['followers_count'];?>人</p>
													<div class="u-info"><a href="<?php echo URL('ta', array('id' => $item['id']));?>"><?php if (isset($item['status']['text'])):?><?php echo F('format_text', $item['status']['text'], 'comments');?><?php endif;?><?php if (isset($item['status']['created_at'])):?>(<?php echo F('format_time', $item['status']['created_at']);?>)<?php endif;?></a></div>
												</div>
											</div>
										</li>
										<?php endforeach;?>
									</ul>
