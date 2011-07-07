<?php
/*
 * 外部引入的相关参数
$param = array('list' => $list,
					'limit'=>$limit, 
					'uid' => $userinfo['id'], 
					'author'=>1, //是否显示作者名
					'header'=>1, //是否显示头像
					'show_filter_type'=>false, //是否显示过滤选项
					'empty_msg'=> F('escape', $userinfo['screen_name']) . '还没有开始发微博，请等待。',
					'not_found_msg' => '找不到符合条件的微博，返回查看<a href="' . URL('index') . '">全部微博</a>',
					'list_title'=>F('escape', $userinfo['screen_name']) . '的微博',
					'filter_type'=>$filter_type,
					'show_page' => false,    //是否显示分页，默认为是
					'show_list_title' => true,   //是否显示list_title，默认为true（该选项会覆盖$show_filter_type）
					'show_unread_tip' => true,	//是否显示 有新微博提示，默认是true
					);
*/
?>
									<?php
									$filter_uid = isset($uid)?'&id=' . $uid:'';
									if (!isset($show_filter_type)) {
										$show_filter_type = true;
									}
									if (!isset($header)) {
										$header = 1;
									}
									if (!isset($author)) {
										$author = 1;
									}
									if(!isset($show_page)){
										$show_page = true;
									}
									if(!isset($show_list_title)){
										$show_list_title = true;
									}
									$show_unread_tip = isset($show_unread_tip) ? $show_unread_tip : true;
									$show_feed_refresh = isset($show_feed_refresh) ? $show_feed_refresh : false;
									?>
									<div class="feed-list <?php if (!in_array($header, array(1,2,3))){echo 'mblog-list';}?>">
										<?php if ($show_unread_tip):?>
										<a class="new-feed hidden" href="<?php echo URL('index');?>" id="new_wb_tips">有新微博，点击查看</a>
										<?php endif;?>
										<?php if ($show_list_title && (!empty($list) || !empty($filter_type))):?>
										<div class="feed-tit">
											<?php if ($show_filter_type){?>

											<?php if (USER::isUserLogin()):?>
											<div class="feed-filter">
											<?php if (empty($filter_type)):?>
												<strong>全部</strong>|
											<?php else:?>
												<a href="<?php echo URL(APP::getRequestRoute(), isset($uid)?'id='.$uid:'');?>">全部</a>|
											<?php endif;?>
											<?php if ($filter_type == 1):?>
												<strong>原创</strong>|
											<?php else:?>
												<a href="<?php echo URL(APP::getRequestRoute(), 'filter_type=1'. $filter_uid);?>">原创</a>|
											<?php endif;?>
											<?php if ($filter_type == 2):?>
												<strong>图片</strong>|
											<?php else:?>
												<a href="<?php echo URL(APP::getRequestRoute(), 'filter_type=2'. $filter_uid);?>">图片</a>| 
											<?php endif;?>
											<?php if ($filter_type == 3):?>
												<strong>视频</strong>|
											<?php else:?>
											<a href="<?php echo URL(APP::getRequestRoute(), 'filter_type=3'. $filter_uid);?>">视频</a>|
											<?php endif;?>
											<?php if ($filter_type == 4):?>
												<strong>音乐</strong>
											<?php else:?>
												<a href="<?php echo URL(APP::getRequestRoute(), '&filter_type=4' . $filter_uid);?>">音乐</a>
											<?php endif;?>
											</div>
											<?php endif;?>
											<?php }?>
											
											<?php if ($show_feed_refresh):?>
											<div class="feed-refresh hidden">
												<a href="#">有<em></em>条新微博，点击查看</a>
											</div>
											<?php endif;?>										
											<h3><?php echo $list_title;?></h3>
										
										</div>
										<?php endif;?>
														
										<?php if (empty($list)) :?>
											<div class="default-tips" id="emptyTip">
												<div class="icon-tips all-bg"></div>
												<?php if (V('g:page', 1) > 1):?>
													<p>已到最后一页</p>
												<?php elseif (empty($filter_type)):?>
													<p><?php if (isset($empty_msg)){echo $empty_msg;}?></p>
												<?php else:?>
													<p><?php if (isset($not_found_msg)){echo $not_found_msg;}?></p>
												<?php endif;?>
											</div>
										<?php else:?>
											<!-- 微博列表 -->
											<?php TPL::module('feedlist', array('list' => $list, 'header' => $header, 'author' => $author));?>
											<!-- end 微博列表 -->
											<?php if (USER::isUserLogin() && $show_page):?>
											<?php TPL::module('page', array('list' => $list, 'limit' => $limit));?>
											<?php endif;?>
										<?php endif;?>
										
									</div>
