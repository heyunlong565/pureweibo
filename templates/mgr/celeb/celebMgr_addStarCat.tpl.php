
				<form action="<?php echo URL('mgr/celeb_mgr.saveStarCat');?>" method="post"  name="add-newlink" id="catfrm">
					<input type="hidden" name="id" value="<?php echo isset($info['id']) ? $info['id'] : ''; ?>" />
					<input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>" />
            		<div class="pop-form">
                    	<div class="form-row">
            				<label for="name">分类名</label>
            				<div class="form-cont">
            					<input name="name" class="input-txt" type="text" value="<?php echo isset($info['name']) ? htmlspecialchars($info['name']) : ''; ?>" vrel="_f|sz=max:20,m:多于10个汉字|ne=m:不能为空,ww" warntip="#errTip"/><span id="errTip" class="tips-error hidden"></span>
            				</div>
                        </div>
                        <div class="form-row">
            				<label for="sort">排序值</label>
            				<div class="form-cont">
            				<input name="sort" class="input-txt" type="text" value="<?php echo isset($info['sort']) ? (int)$info['sort'] : '0'; ?>" vrel="_f|sz=max:4,m:不能大于4位数|ne=m:不能为空" warntip="#sortTip"/><span id="sortTip" class="tips-error hidden"></span>
            				</div>
            			</div>
                    	<div class="btn-area">
							<a class="general-btn btn-s2" id="pop_ok" href="#"><span>确定</span></a>
							<a class="general-btn" id="pop_cancel" href="#"><span>取消</span></a>
                    	</div>
                    </div>
                </form>

