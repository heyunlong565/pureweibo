						<div id="infomation" class="form-body">
                            <div class="form-info">
                                <p>被加入黑名单的用户将无法关注你、评论你。如果你已经关注他，也会自动解除关系。</p>
                            </div>
							<?php if (empty($blacklist)):?>
                            <div class="blacklist-con">
                                <p>还没有人被你拉入黑名单呢。</p>
                                <p><strong>如何将某个用户加入自己的黑名单？</strong>进入某个用户的微博，在 @他 旁边的“更多”下拉框中可以进行设置。</p>
                            </div>
							<?php else:?>
                            <div class="blacklist-con">
                                <p>已被您加入黑名单的用户：</p>
                                <?php 
									foreach ($blacklist as $item):
									$id = $item['blocked_user']['user']['id'];
								?>
                                <div class="blacklist" rel="u:<?php echo $id;?>">
                                    <span class="operate"><a href="#" rel="e:dbl">解除</a></span>
                                    <span class="date"><?php echo $item['blocked_user']['add_time'];?></span>
                                    <span class="username"><a href="<?php echo URL('ta', array('id' => $id, 'name' => $item['blocked_user']['user']['screen_name']));?>"><?php echo F('escape', $item['blocked_user']['user']['screen_name']);?></a></span>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <?php endif;?>
                        </div>
