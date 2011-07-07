								<div class="user-list user-list-mode">
									<p class="result">这个活动参与者<span>(共<?php echo $event_info['join_num']*1;?>人)</span></p>
                                    <ul>
									<?php if (is_array($members)) {foreach($members as $row) {?>
										<?php
											$mid = $row['sina_uid'];
										?>
                                        <li rel="u:<?php echo $mid;?>">
                                            <div class="list-content">
                                                <div class="user-pic">
                                                    <a href="<?php echo URL('ta', 'id=' .$mid)?>"><img alt="" src="<?php echo $users_info[$mid]['profile_image_url']?>"></a>
                                                </div>
                                                <div class="content-r">
												<?php if ($mid != USER::uid()) {?>
												<?php if (!empty($listFans) && in_array($mid, $listFans)) {?>
												<span class="followed-btn">已关注</span>
												<?php } else {?>
                                                    <a href="#" class="addfollow-btn" rel="e:fl,t:1">加关注</a>
												<?php }}?>
                                                </div>
                                                <div class="content-m">
                                                    <a href="<?php echo URL('ta', 'id=' .$mid)?>" class="u-name"><?php echo htmlspecialchars($users_info[$mid]['screen_name']);?></a><span class="loc"><?php echo $users_info[$mid]['location'];?></span>
													<?php if (USER::uid() == $event_info['sina_uid'] || USER::aid()) {?>
														<span class="phone">联系方式：<?php echo htmlspecialchars($row['contact']);?></span>
													<?php }?>
                                                    <div class="u-info"><a href="#" class="black"><?php echo htmlspecialchars($users_info[$mid]['description']);?></a></div>
                                                </div>
                                            </div>
                                        </li>
<?php }}?>
                                    </ul>
                                    <!-- 分页 开始-->
                                    <div class="list-footer">
										<?php TPL::module('page', array('list' => $members, 'count' => $count, 'limit' => $limit, 'type' => 'event'));?>
									</div>
                                    <!-- 分页 结束-->
                                </div>
