<div class="program-list">
                    	<div class="tit-hd">
                        	<a href="<?php echo URL('live');?>" class="more">更多&gt;&gt;</a>
                            <h3>直播列表</h3>
                        </div>
                        <div class="bd">
                        	<ul>
								<?php if ($list):?>
								<?php foreach ($list as $item):?>
                            	<li>
									<p><a href="<?php echo URL('live.details', 'id='.$item['id']);?>" target="_blank"><?php echo F('escape', $item['title']);?></a>
									<?php if ($item['start_time'] <= APP_LOCAL_TIMESTAMP && $item['end_time'] > APP_LOCAL_TIMESTAMP):?>
									<span class="active">(进行中)</span>
									<?php elseif ($item['start_time'] > APP_LOCAL_TIMESTAMP):?>
									<span class="unplayed">(未开始)</span>
									<?php else:?>
									<span class="finish">(已结束)</span>
									<?php endif;?>
									</p>
                                    <p><span class="label">主持人：</span>
									<span class="emcee">
									<?php 
									$master_list = explode(',', $item['master']);
									foreach ($master_list as $var):
									?>
									<?php echo empty($var) ? '' : F('escape', $list_member[$var]['screen_name']);?>
									<?php endforeach;?>
									</span></p>
										<p><span class="label">时&nbsp;&nbsp;&nbsp;&nbsp;间：</span><span class="time"><?php echo F('format_time.foramt_show_time', $item['start_time']);?></span></p>
                                </li>
								<?php endforeach;?>
								<?php endif;?>
                            </ul>
                        </div>
                    </div>
