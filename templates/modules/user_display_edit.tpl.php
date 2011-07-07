					<form id="showForm">
                        <div id="showSetting" class="form-body">
                            <div class="form-info">
                                <p>请选择以下情况的显示方式</p>
                            </div>
                            <div class="setting-box">
                                <strong>每页微博显示数量</strong>
                                <p>请选择在我的首页、我的微博、他人的首页、我的收藏、@提到我的页面中，每页显示微博数量</p>
                                <div class="radio-box">
                                    <label><input name="feedtotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 10):?>checked="checked"<?php endif;?> />10条</label>
                                    <label><input name="feedtotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 20):?>checked="checked"<?php endif;?> />20条</label>
                                    <label><input name="feedtotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 30):?>checked="checked"<?php endif;?> />30条</label>
                                    <label><input name="feedtotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 40):?>checked="checked"<?php endif;?> />40条</label>
                                    <label><input name="feedtotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_wb') == 50):?>checked="checked"<?php endif;?> />50条</label>
                                </div>
                                <strong>每页评论显示数量</strong>
                                <p>请选择在我的评论、单条微博的全部评论页面中，每页显示评论数量</p>
                                <div class="radio-box bottom-line">
                                    <label><input name="commenttotal" value="10" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 10):?>checked="checked"<?php endif;?> />10条</label>
                                    <label><input name="commenttotal" value="20" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 20):?>checked="checked"<?php endif;?> />20条</label>
                                    <label><input name="commenttotal" value="30" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 30):?>checked="checked"<?php endif;?> />30条</label>
                                    <label><input name="commenttotal" value="40" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 40):?>checked="checked"<?php endif;?> />40条</label>
                                    <label><input name="commenttotal" value="50" type="radio" <?php if ( V('-:userConfig/user_page_comment') == 50):?>checked="checked"<?php endif;?> />50条</label>
                                </div>
                            </div>
                            <div class="form-row submit-btn">
                                <a href="#" class="general14-btn" id="trig"><span>保存</span></a>
                            </div>
                        </div>
                        <input type="submit" class="hidden" />
                        </form>
