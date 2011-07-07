                                <div class="set-tags">
                                    <p>添加描述自己职业、兴趣爱好等方面的词语，让更多人找到你，让你找到更多同类</p>
                                    <div class="tags-box">
                                        <div class="top tags-bg"></div>
                                        <div class="mid">
                                            <div class="tags-field">
                                                <div class="tags-input">
												<form id="tagForm">
														<input type="text" vrel="_f|ne=w:选择最适合你的词语，多个请用空格分开|checktag" warntip="#tip" class="input-txt blur-txt style-normal" name="tags" id="tagInputor" value="选择最适合你的词语，多个请用空格分开"/><a href="#" class="general14-btn" id="trig"><span>添加标签</span></a>
														<input type="submit" class="hidden" />
														</form>
                                                </div>
												<p class="hidden" id="tip"></p>
                                            </div>
                                            <?php if(is_array($tagsuglist)): ?>
                                            <div class="tags-interest" id="selection">
                                                <div class="select-tags">
                                                    <p>你可能感兴趣的标签(点击直接添加)：</p>
													<?php foreach($tagsuglist as $tag):?>
													<a href="#" rel="e:ct,t:<?php echo $tag['value'];?>" ><span>+</span><?php echo $tag['value'];?></a>
													<?php endforeach;?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="bot tags-bg"></div>
                                    </div>
                                    <div class="tags-title"><p>我已经添加的标签：</p></div>
                                    <div class="tags-area">
                                        <div class="tags-list">
											<ul id="tagList">
											<?php if (is_array($taglist)):?>
											<?php foreach($taglist as $tag):?>
											<?php foreach ($tag as $key => $item):?>
											<li><a href="<?php echo URL('search.user', array('k' => $item, 'ut' => 'tags')); ?>" class="a1"><?php echo F('escape', $item);?></a><a href="#" class="close-icon icon-bg" rel="e:dt,id:<?php echo $key;?>"></a></li>
											<?php endforeach;?>
											<?php endforeach;?>
											<?php endif;?>
											</ul>
                                        </div>
                                    </div>
                                    <div class="tags-title"><p>关于标签：</p></div>
                                    <div class="about-tags-list">
                                        <p>&middot;标签是自定义描述自己职业、兴趣爱好的关键词，让更多人找到你，让你找到更多同类。</p>
                                        <p>&middot;已经添加的标签将显示在“我的微博”页面右侧栏中，方便大家了解你。</p>
                                        <p>&middot;在此查看你自己添加的所有标签，还可以方便地管理，最多可添加10个标签。</p> 
                                        <p>&middot;点击你已添加的标签，可以搜索到有同样兴趣的人。</p>
                                    </div>
                                </div>
