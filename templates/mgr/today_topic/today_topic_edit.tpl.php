	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
            <h4><a id="pop_close" class="clos" href=""></a>添加新话题</h4>
            <div class="add-float-content">
            	<form id="pop_form" action="<?php echo URL('mgr/weibo/todayTopic.edit', '', 'admin.php');?>" method="post"  name="add-newlink">
            		<div class="float-info">
            			<label for="link-text">
            				<p>话题内容：</p>
            				<input name="topic" class="input-box pop-w1" type="text" value="<?php echo isset($info['topic'])? $info['topic'] : '';?>" vrel="_f|ne=m:请输入话题名称|sz=max:15,m:15个汉字以内" warntip="#mdyTip"/><span class="a-error hidden" id="mdyTip">错误提示</span>
            			</label>
						<?php if ((int)V('g:topic_id', 0) === 2 || isset($info) && (int)$info['topic_id'] === 2) {?>
						<label for="link-text">
            				<p>生效时间：</p>
            				<input name="ext1" class="input-box pop-w1" type="text" vrel="_f|dt" warntip="a-error" value="<?php echo  date('Y/m/d H:i', isset($info['ext1'])?$info['ext1'] : time());?>"/><span class="a-error hidden"></span>
            			</label>
						<?php }?>
            		</div>
                    <div class="float-button">
                    	<span class="float-button-y"><input type="submit" value="确定" /></span>
                    	<span class="float-button-n"><input id="pop_cancel" type="button" name="取消" value="取消" /></span>
                    </div>
					<input type="hidden" name="topic_id" value="<?php echo isset($info['topic_id']) ? $info['topic_id'] : V('g:topic_id');?>">
					<input type="hidden" name="id" value="<?php echo isset($info['id']) ? $info['id'] : '';?>" />
                </form>
            </div>
		</div>
		<div class="pop-inner-bg"></div>
	</div>
	<div class="pop-b">
		<div></div>
	</div>
