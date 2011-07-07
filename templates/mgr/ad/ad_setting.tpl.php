<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告位管理 - 广告流程管理 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
function ad_submit(action, type) {
	form = $('#ad_from').get(0);
	if (type == 'preview') {
		form.action = action;
		form.target = '_blank';
	} else {
		form.action = '';
		form.target = '';
	}
}
	function insert() {
		$.get('<?php echo URL('mgr/ad.getAd','aid='.$data['id'], 'admin.php')?>', function(data) {
				if (!data) {
				delConfirm('<?php echo URL('mgr/ad.adSetCode','', 'admin.php')?>','您可能没有设置“广告标识码”,是否现在进入设置页？');
				return;
				}
			$input = $('#code_input');
			$input.val(data);
		});
	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span><a href="">组件管理</a></span> &gt; <span>广告管理</span> &gt; <span><?php echo $data['name'];?></span>
	</div>
	<div class="set-wrap">

	<h4 class="main-title"><?php echo $data['name'];?>设置</h4>
		<div class="set-ad">

			<div class="set-area-int">
            	<form id="ad_from" action="" method="post">
        			<div class="code-area">
                		<p class="chinaz-tips">
							<?php if (defined('AD_UNION') && AD_UNION == 1) {?>
							<a href="javascript:insert();">嵌入ChinaZ广告代码</a>
							<?php }?>
							请输入广告代码：
						</p>
                        <label for="ad-code-t">
                        	<textarea id="code_input" name="content" class="input-box sub-ad" cols="" rows=""><?php echo htmlspecialchars($data['content']);?></textarea>
                        </label>
                	</div>
					<?php if (in_array($data['flag'], array('global_left', 'global_right'))) {?>
					<div class="set1">
        				<p class="title">话题获取方式：</p>
                		<div class="login-radio">
                    		<label for="topic_get">
                				<input name="topic_get" type="radio" value="1" <?php if (!isset($config['topic_get']) || $config['topic_get'] == '1') {?>checked="checked"<?php }?> />刷新展现
                        	</label><br />
                        	<label for="topic_get">
                				<input name="topic_get" type="radio" value="2" <?php if (isset($config['topic_get']) && $config['topic_get'] == '2') {?>checked="checked"<?php }?>/>按天展现<span class="sub-tips">(如果某个用户点击了广告上的关闭按钮，那么在当天将不再向用户展现)</span>
                        	</label>
                        </div>
                    </div>
                	<?php }?>
                	<div class="button operate-area"><input type="submit" value="预览" onclick="ad_submit('<?php echo URL($data['page']=='global'?'index':$data['page'] ,($data['page'] =='ta' ?'id=1076590735':'') . '#ad_' .$data['flag'], 'index.php');?>', 'preview')" /><input type="submit" value="提交" onclick="ad_submit('', 'save');" /></div>


					<input type="hidden" name="flag" value="<?php echo $data['flag'];?>" />
					<input type="hidden" name="page" value="<?php echo $data['page'];?>" />
					<input type="hidden" name="id" value="<?php echo $data['id'];?>" />
                </form>
    		</div>
        </div>
			
     
   </div>
</div>
</body>
</html>
