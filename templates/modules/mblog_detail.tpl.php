						<div class="feed-list mblog-list">
						<ul id="xwb_weibo_list_ct">
							<li rel="w:<?php echo $mblog_info['id'];?>">
							 <?php
								$uid = USER::uid();
								$mblog_info['header'] = 0;
								$mblog_info['uid'] = $uid;
								$mblog_info['author'] = true;
								$mblog_info['disable_comment'] = true;
								$mblog_info['is_show'] = $is_show;
								//Xpipe::pagelet('weibo.detail', $mblog_info);
								TPL::module('feed', $mblog_info);
							?>
							</li>
						</ul>
						</div>
						<div class="add-comment" id="topCmtBox">
							<p class="title">发表评论</p>
							<div class="post-comment-main">
								<a href="javascript:;" class="icon-face-choose all-bg" rel="e:ic"></a>
								<div class="comment-r">
									<textarea class="comment-textarea style-normal" id="inputor"></textarea>
									<div>
										<a href="javascript:;" class="general-btn" rel="e:sd"><span>评论</span></a>                       			
										<span class="keyin-tips" id="warn">还可以输入<span>70</span>个字</span>
										<label><input type="checkbox" id="sync">同时发一条微博</label>
									</div>
								</div>
							</div>
						</div>
						<div class="comment-list all-comment"  id="xwb_cmt_list" wbid="<?php echo $mblog_info['id'];?>">
							<ul id="cmtCt"></ul>
							<div class="list-footer hidden" id="pager">
								<div class="page" id="page">
									<a class="general-btn" href="javascript:;" id="first" rel="e:fi"><span>首页</span></a><a class="general-btn" href="javascript:;" id="pre" rel="e:pr"><span>上一页</span></a><a class="general-btn" href="javascript:;" id="next" rel="e:nx"><span>下一页</span></a>
								</div>
							</div>
						</div>	
