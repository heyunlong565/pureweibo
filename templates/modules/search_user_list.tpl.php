						<ul>
						<?php
						
						$userTmp=$data;
						$data=array();
						foreach($userTmp as $row){
							if(isset($row['filter_state']) && !in_array(2,$row['filter_state'])){
								$data[]=$row;
							}
						}
						unset($userTmp);
						?>
						<?php
						if(empty($data)):
						?>
						<div class="search-result">
							<div class="icon-alert all-bg"></div>
							<p><strong>找不到符合条件的用户，请输入其他关键字再试</strong></p>
						</div>
						<?php
						endif;
						?>
                        <?php foreach ($data as $item) { ?>
                            <li rel="u:<?php echo $item['id'];?>">
                                <div class="list-content">
                                    <div class="user-pic">
                                        <a href="<?php echo URL('ta', 'id=' . $item['id']);?>"><img src="<?php echo $item['profile_image_url']?>" alt="" /></a>
                                    </div>
                                    <div class="content-r">
									<?php if ($item['id'] !== USER::uid()) {?>
                                        <?php if ($item['following']) {?>
                                        <a href="#" class="followed-btn">已关注</a>
                                        <?php } else {?>
                                        <a href="#" rel="e:fl,t:1" class="addfollow-btn">添加关注</a>
                                        <?php }?>
									<?php }?>
                                    </div>
                                    <div class="content-m">
                                        <a class="u-name" href="<?php echo URL('ta', 'id=' . $item['id']);?>"><?php echo htmlspecialchars($item['screen_name']);?></a>
                                        <?php echo F('verified', $item);?>
                                        <p class="icon-bg icon-<?php if ($item['gender'] == 'f') {?>fe<?php }?>male"><?php echo $item['location'];?> 粉丝数：<?php echo $item['followers_count'];?>人</p>
                                        <?php if (trim($item['description']) !== ''): ?><div class="u-info">简介：<?php echo htmlspecialchars($item['description']); ?></div><?php endif; ?>
                                        <?php if (V('r:ut') === 'tags'): ?><p class="tag" rel="u:<?php echo $item['id'];?>">标签：<?php echo htmlspecialchars(V('r:k')); ?> <a href="#" rel="e:allTag">查看该用户的所有标签</a></p><?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul>
