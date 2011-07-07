<?php if (empty($list)):?>
							<div class="default-tips">
								<div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
								<p>已到最后一页</p>
								<?php else:?>
								<p>还没有收到或发出任何私信</p>
								<?php endif;?>
							</div>
						<?php else:?>
						<div class="comment-list all-comment message-list">
							<ul id="messageList">
								<?php foreach ($list as $item):?>
								<li rel="m:<?php echo $item['id'];?>">
									<div class="<?php if ($item['sender']['id'] == USER::uid()):?>sendbyme <?php endif;?>message-part">
										<div class="user-pic">
											<a href="<?php if ($item['sender']['id'] == USER::uid()):?><?php echo URL('index');?><?php else:?><?php echo URL('ta',array('id' => $item['sender']['id']));?><?php endif;?>"><img src="<?php echo APP::F('profile_image_url', $item['sender']['profile_image_url']);?>" alt="" /></a>
										</div>
										<div class="comment-c">
											<p class="c-info">
											<?php if ($item['sender']['id'] == USER::uid()):?>
												<a href="<?php echo URL('index');?>"> 我</a>发送给<a href="<?php  echo URL('ta',array('id' => $item['recipient']['id']));?>"><?php echo F('escape', $item['recipient']['screen_name']);?></a>
											<?php else:?>
												<a href="<?php  echo URL('ta',array('id' => $item['sender']['id']));?>"><?php echo F('escape', $item['sender']['screen_name']);?><?php echo F('verified', $item['sender']); ?></a>
											<?php endif;?>
											<?php echo APP::F('format_text', $item['text'], 'feed', $item['sender']['id']);?>  (<?php echo APP::F('format_time', $item['created_at']);?>) </p>
											<div class="c-for">
												<?php if ($item['sender']['id'] != USER::uid()):?>
												<a class="icon-reply icon-bg" href="javascript:;" rel="e:rm,n:<?php echo $item['sender']['screen_name']?>,u:<?php echo $item['sender']['id'];?>">回复</a>
												<?php endif;?>
												<a class="icon-del icon-bg hidden" id="del" href="javascript:;" rel="e:dm">删除</a>
											</div>
										</div>
									</div>
								</li>
								<?php endforeach;?>
							</ul>
			
									<!-- 分页 -->
									<?php TPL::module('page', array('list' => $list, 'limit' => $limit));?>
									<!-- end 分页 -->
						</div>
						<?php endif;?>
