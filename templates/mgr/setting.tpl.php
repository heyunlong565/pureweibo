<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站点设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/admin_lib.js'></script>
<script>
	window.onload = function() {
		$('#preview_loading').hide();
	}


	function preview(o) {
		$('#preview_loading').show();
		$('#logo_form').submit();
	}
	
	function uploadFinished(state, url) {
		$('#logo_form').get(0).reset();

		$('#preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}
		$('#logo_preview').attr('src', url);
		$('#logo').val(url);

	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：功能设置<span> &gt; </span>站点设置</div>
    <div class="set-wrap">
    	<form action="" name="form1" method="post" id="this_form">
        <div class="wrap-inner">
        	<h4 class="main-title">站点信息设置</h4>
    		<div class="set-area-int">
            	<div class="site-info-a">
            	<label for="site-name">
            		<p>网站名称：<span>（网站名称将显示在页面底部）</span></p>
            		<input name="site_name" class="input-box site-box-w" vrel="sz=max:10,m:请缩减至十个字内|ne=m:不能为空" warntip="#nameTip" type="text" value="<?php echo $config['site_name']; ?>" />
					<span class="a-error hidden" id="nameTip"></span>
            	</label>
            	</div>
            	<div class="site-info-a">
            	<label for="beian-info">
            		<p>网站备案信息代码：<span>（备案信息将显示在页面底部）</span></p>
            		<input name="site_record" class="input-box site-box-w" vrel="sz=max:30,m:最多30个中文或60个英文字母" type="text" warntip="#codeErr" value="<?php echo $config['site_record']; ?>" />
					<span class="a-error hidden" id="codeErr"></span>
            	</label>
            	</div>
            	<div class="site-info-b">
            	<label for="statistics">
            		<p>网站第三方统计代码：</p>
                	<textarea name="third_code" class="input-box site-box-area" cols="10" rows="10"><?php echo $config['third_code']; ?></textarea>
            	</label>
            	</div>
				<input type="hidden" name="logo" id="logo" value="<?php echo $config['logo'];?>" />
        	</div>
        </div>
		</form>
		<form id="logo_form" target="logo_upload" method="post" action="<?php echo URL('mgr/setting.uploadLogo')?>" enctype="multipart/form-data">
        <div class="wrap-inner">
        	<h4 class="main-title">请选择需要在网站中使用的LOGO图案</h4>
        	<div class="set-area-int">
            	<div class="site-info-b">
					<label for="logo">选择图片：
						<input type="file" class="botton-file" id="upload_file" value="<?php echo $config['logo']; ?>" name="logo" onChange="preview(this)"/>
					</label>
					<p class="tips">请选择PNG格式的本地图片文件，文件大小不超过500KB，图片大小不超过200*65；为显示美观，请使用透明底素材</p>
					<div class="logo_preview">
						<p>效果预览：</p>
						<img id="logo_preview" src="<?php echo $config['logo'] ? F('fix_url', $config['logo']) : W_BASE_URL . WB_LOGO_DEFAULT_NAME;?>" />
						<div class="preview_loading" id="preview_loading">正在上传图片，请稍候...</div>
					</div>
					<iframe name="logo_upload" style="display:none;"></iframe>
				</div>
        	</div>
        </div>
		</form>
        <div class="button button-position"><input type="submit" id="submitBtn" name="保存修改" value="保存修改" /></div>
    </div>
</div>
<script type="text/javascript">
var valid = new Validator({
	form: '#this_form',
	trigger: '#submitBtn'
});
</script>
</body>
</html>
