							<form id="userinfoForm">
                            <div id="infomation" class="form-body">
                                <div class="form-info">
									<span class="tab-s4">
										<a href="javascript:void(0)" class="current">基本资料</a>
										<a href="<?php echo URL('setting.tag');?>">个人标签</a>
									</span>
                                    <span class="tips"><em>*</em>为必填项</span>
                                </div>
								<div class="form-con">
									<div class="form-row">
										<label for="nick" class="form-field"><span>*</span> 昵称：</label>
										<input name="nick" vrel="_f|sinan|ne=m:请输入昵称|sz=min:4,max:20,ww,m:大于4个字母，不超过20个字母或10个汉字" warntip="#tip_nick" class="input-a style-normal" id="nick" tipOk="#nickOk" value="<?php echo $U['screen_name'];?>" type="text" />
                                        <span class="tips-wrong hidden" id="tip_nick"></span>
                                        <span class="tips-ok hidden" id="nickOk"></span>
									</div>
									<div class="form-row">
										<span class="form-field"><span>*</span> 所在地：</span>
										<select name="province" id="province" preval="<?php echo $U['province'];?>" vrel="_f|ne=m:请选择所在地"  warntip="#tip_city"><option value="">省/直辖市</option></select>
										<select name="city" id="city" preval="<?php echo $U['city'];?>"><option value="">城市/地区</option></select>
                                        <span class="tips-wrong hidden" id="tip_city">请选择所在地</span>
                                        <span class="tips-ok hidden" id="nickOk"></span>
									</div>
									<div class="form-row">
										<span class="form-field"><span>*</span> 性别：</span>
										<label for="male"><input id="male" type="radio" name="gender" <?php if ($U['gender'] == 'm' || $U['gender'] == ''):?>checked="checked"<?php endif;?> value="m"/> 男</label>
										<label for="female"><input id="female" type="radio" name="gender" value="f" <?php if ($U['gender'] == 'f'):?>checked="checked"<?php endif;?>/> 女</label>
									</div>
									<div class="form-row">
										<label for="description" class="form-field">一句话介绍：</label>
										<textarea class="style-normal" name="description" id="description" vrel="_f=ch:1|sz=max:140"><?php echo $U['description'];?></textarea>
									</div>
									<div class="form-row submit-btn">
										<a href="#" class="general14-btn" id="trig"><span>保存</span></a>
									</div>
								</div>
                            </div>
                       </form>
