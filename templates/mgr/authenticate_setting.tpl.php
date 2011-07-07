<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>认证设置 - 认证管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script>

	function submit() {
		$('#this_form').submit();
	}

	function bigPreview(o) {
		$('#big_preview_loading').show();
		$('#big_form').submit();
	}

	function smallPreview(o) {
		$('#small_preview_loading').show();
		$('#small_form').submit();
	}

	function uploadFinished(state, url) {
		$('#big_preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}

		$('#big_logo_preview').attr('src', url + '?r=' + Math.random());
		$('#big_file').val(url);
	}

	function uploadSmallFinished(state, url) {
		$('#small_preview_loading').hide();
		if (state != '200') {
			alert(state);
			return;
		}

		$('#small_logo_preview').attr('src', url);
		$('#small_file').val(url);
	}

	function icon(o) {
		if(o) {
			$('#update_form').show();
		}else{
			$('#update_form').hide();
		}
	}
</script>
<?php if($sysconfig['authen_enable'] == 1):?><script>window.onload = function() {$('#update_form').show();}</script><?php endif;?>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>认证管理<span> &gt; </span>认证设置</div>
    <div class="set-wrap">
        <h4 class="main-title">认证设置</h4>
		<div class="set-area-int">
        	<form action="<?php echo URL('mgr/user_verify.webAuthenWay');?>" method="post" name="authenticate" id="this_form">
			<div class="authenticate">
				<p class="auth-title">认证方式设置:</p>
				<p class="radio-auth">
                    <label>
                		<input name="authen" class="radio-same" type="radio" value="0" <?php if($sysconfig['authen_enable'] == 0) echo 'checked="checked"';?> onclick="icon(0);"/>使用新浪名人认证
                	</label>
                </p>
                <p class="radio-auth">
                	<label>
            			<input name="authen" class="radio-same" type="radio" value="1" <?php if($sysconfig['authen_enable'] == 1) echo 'checked="checked"';?> onclick="icon(1);"/>使用站点自定义认证
                	</label>
                </p>
			</div>
			<input type="hidden" name="big_file" id="big_file" value="<?php echo $sysconfig['authen_big_icon'];?>" />
			<input type="hidden" name="small_file" id="small_file" value="<?php echo $sysconfig['authen_small_icon']; ?>" />
			
            <div class="authenticate-img" id="update_form" style="display:none">
				<div class="icon-alt">
                	<div class="sle-auth-img">设置认证说明：</div>
            		<input class="input-box icon-alt-w" name="alt" type="text" value="<?php echo $sysconfig['authen_small_icon_title'];?>"/>
                </div>
			</form>
				<div class="auth-box">
            		<div class="sle-auth-img">请选择认证图标：</div>
                	<div class="auth-img">
						<form id="big_form" method="post" target="logo_upload" action="<?php echo URL('mgr/user_verify.uploadAuthBigIcon')?>" enctype="multipart/form-data">
                    	<p class="trr">
							<label for="logo">大图标：
								<input type="file" class="botton-file" value="<?php echo $sysconfig['authen_big_icon']; ?>"  name="big" onChange="bigPreview(this)"/>
							</label>
							<iframe name="logo_upload" style="display:none;"></iframe>
						</p>
                    	</form>
						<form id="small_form" method="post" target="logo_upload" action="<?php echo URL('mgr/user_verify.uploadAuthSmallIcon')?>" enctype="multipart/form-data">
                    	<p>
							<label for="logo">小图标：
								<input type="file" class="botton-file" value="<?php echo $sysconfig['authen_small_icon']; ?>"  name="small" onChange="smallPreview(this)"/>
							</label>
							<iframe name="logo_upload" style="display:none;"></iframe>
						</p>
                    	</form>
                	</div>
                	<div class="effect-preview">
                		<div class="pre-view">效果预览：</div>
                        <div>
                		<div class="preview-big">
							<img id="big_logo_preview" src="<?php echo $sysconfig['authen_big_icon'] ? F('fix_url', $sysconfig['authen_big_icon']) :  W_BASE_URL . AUTH_BIG_ICON_DEFAULT_NAME;?>" />
							<div class="preview_loading" id="big_preview_loading" style="display:none">正在上传图片，请稍候...</div>
						</div>
                		<div class="preview-small">
							<img id="small_logo_preview" src="<?php echo $sysconfig['authen_small_icon'] ? F('fix_url', $sysconfig['authen_small_icon']) :  W_BASE_URL . AUTH_SMALL_ICON_DEFAULT_NAME;?>" title="<?php echo $sysconfig['authen_small_icon_title'];?>" />
							<div class="preview_loading" id="small_preview_loading" style="display:none">正在上传图片，请稍候...</div>
						</div>
                        </div>
            		</div>
                
				</div>
            	<p class="tips">* 请选择PNG格式的本地图片文件，文件大小不能超过100KB；<br />* 大图标大小不能超过100*30，小图标大小不能超过12*12；为显示美观，建议使用透明底素材。</p>
        	</div>
			<div class="button authenticate-position">
            	<input type="button" name="保存修改" value="保存修改" onclick="submit();"/>
            </div>
		</div>
	</div>
</div>
</body>
</html>
