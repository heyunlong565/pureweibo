
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
            <h4><a id="pop_close" class="clos" href=""></a>添加新的话题列表</h4>
            <div class="add-float-content">
            	<form id="addTopicForm" action="<?php echo URL('mgr/weibo/todayTopic.addCategory','', 'admin.php');?>" method="post"  name="changes-newlink">
            		<div class="float-info">
            			<label>
            				<p>话题列表名称：</p>
            				<input name="topic_name" class="input-box pop-w6" vrel="_f|ne=m:请输入话题名称|sz=max:15,m:15个汉字以内" warntip="#nameTip" type="text" value="<?php echo isset($info['topic_name'])? $info['topic_name']:'';?>"/><span class="a-error hidden" id="nameTip"></span>
            			</label>
            		</div>
                    <div class="float-button">
                    	<span class="float-button-y"><input type="submit" value="确定" /></span>
                    	<span class="float-button-n"><input id="pop_cancel" type="button" value="取消" /></span>
                    </div>
					<?php if (isset($info['topic_id'])) {?>
					<input type="hidden" name="topic_id" value="<?php echo $info['topic_id'];?>">
					<?php  }?>
                </form>
            </div>
    	</div>
		<div class="pop-inner-bg"></div>
	</div>
	<div class="pop-b">
		<div></div>
	</div>
<script>
    new Validator({
        form : '#addTopicForm'
    });
</script>