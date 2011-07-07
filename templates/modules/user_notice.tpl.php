					<div id="showSetting" class="form-body">
                        <div class="form-info">
                            <p>设置您想要的提醒方式，随时随地接收微博的更新。</p>
                        </div>
                        <form id="noticeForm">
                        <div class="setting-box">
<!--
                        	<strong>微博小黄签提醒显示位置</strong>
                            <div class="radio-box">
							<label><input name="newfeed" value="0" <?php if (V('-:userConfig/user_newfeed') == '' || V('-:userConfig/user_newfeed') == '0'):?>checked="checked"<?php endif;?> type="radio" />在页面顶部显示提示信息</label>
                                <label><input name="newfeed" value="1" <?php if (V('-:userConfig/user_newfeed') == '1'):?>checked="checked"<?php endif;?> type="radio" />在网页右下角使用气泡显示提示信息，网页打开期间始终可见</label>
                            </div>
-->
                            <strong>哪些内容通过微博小黄签提示我</strong>
                            <div class="checkbox-box">
							<label><input name="comment" value="1" <?php if ($notice['comment'] == 1):?>checked="checked"<?php endif;?> type="checkbox" />新评论提醒</label>
                                <label><input name="follower" value="1" <?php if ($notice['follower'] == 1):?>checked="checked"<?php endif;?> type="checkbox" />新增粉丝提醒</label>
                                <label><input name="dm" value="1" <?php if ($notice['dm'] == 1):?>checked="checked"<?php endif;?> type="checkbox" />新私信提醒</label>
                                <label><input name="mention" value="1" <?php if ($notice['mention'] == 1):?>checked="checked"<?php endif;?> type="checkbox" />@提到我提醒</label>
                                <label><input name="notice" value="1" <?php if (V('-:userConfig/user_newnotice') == 1):?>checked="checked"<?php endif;?> type="checkbox" />新通知提醒</label>
                            </div>
                            <strong>设置哪些@提到我的微博计入@提醒数字中</strong>
                            <p>微博的作者是：</p>
                            <div class="radio-box">
                            	<label><input name="from_user" value="0" <?php if ($notice['from_user'] == 0):?>checked="checked"<?php endif;?> type="radio" />所有人</label>
                                <label><input name="from_user" value="1" <?php if ($notice['from_user'] == 1):?>checked="checked"<?php endif;?> type="radio" />关注的人</label>
                            </div>
                            <p>微博的类型是：</p>
                            <div class="radio-box bottom-line">
                            	<label><input name="status_type" value="0" <?php if ($notice['status_type'] == 0):?>checked="checked"<?php endif;?> type="radio" />所有微博</label>
                                <label><input name="status_type" value="1" <?php if ($notice['status_type'] == 1):?>checked="checked"<?php endif;?> type="radio" />原创的微博</label>
                            </div>
                        </div>
                        <div class="form-row submit-btn">
							<a href="#" id="trig" class="general14-btn"><span>保存</span></a>
						</div>
					    </form>
                    </div>
