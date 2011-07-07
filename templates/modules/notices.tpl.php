						<?php if (empty($list)):?>
							<div class="default-tips">
								<div class="icon-tips all-bg"></div>
								<?php if (V('g:page', 1) > 1):?>
								<p>已到最后一页</p>
								<?php else:?>
								<p>还没有收到任何通知</p>
								<?php endif;?>
							</div>
						<?php else:?>
						<div class="sys-notice">
							<ul>
								<?php foreach ($list as $item):?>
								<li>
									<div class="user-pic">
										<img src="<?php echo W_BASE_URL ?>img/system_pic.png" alt="" />
									</div>
									<div class="sys-con">
										<h3><span>管理员</span>：<?php echo htmlspecialchars($item['title']); ?></h3>
										<p><?php echo nl2br($item['content']); ?></p>
										<div class="ft">
											<div class="sys-date"><?php echo date("Y-m-d H:i:s", $item['available_time']) ?></div>
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