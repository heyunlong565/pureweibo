<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理</a><span> &gt; </span>插件设置<span> &gt; </span>用户首页聚焦位</div>
    <div class="set-wrap">
        <div class="home-focus">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
            	<form method="post" id="form1" enctype="multipart/form-data" action="<?php echo URL('mgr/plugins.save', array('id' => 2));?>">
                	<div class="focus-set">
                    	<p>标题：</p>
                    	<label for="focus-title">
                        	<input type="text" name="title" class="input-box home-focus-w" value="<?php echo F('escape', $cfg['title']);?>">
                        </label>
                    </div>
                    <div class="focus-set">
                    	<p>内容：（建议字数不超过74字，超过部分前端将不会显示）</p>
                        <label for="focus-content">
                        	<textarea rows="" cols="" class="input-box focus-con-w" vrel="sz=max:200,ww,m:不允许超过200个字符。" warntip="#textTips" name="text"><?php echo F('escape', $cfg['text']);?></textarea>
							<span class="a-error hidden" id="textTips"></span>
                        </label>
                    </div>
                    <div class="focus-set">
						<label for="focus-bg">请选择背景图片:
							<input type="file" name="bg" onchange="" name="focus-bg" value="" class="botton-file">
						</label>
						<p class="tips">请选择PNG格式的本地图片文件；<br>为显示美观，图片大小建议为560*122。如不选择背景图片，将使用默认的背景图片。</p>
                    </div>
                    <div class="focus-set">
                    	<label for="operate-focus">操作设置：
                        	<select name="oper" id="oper">
							<?php if ($cfg['oper'] == 1):?>
                            	<option value=1 selected>发布微博</option>
                                <option value=2>跳转到其他页面</option>
							<?php else: ?>
								<option value=1>发布微博</option>
                                <option value=2 selected>跳转到其他页面</option>
							<?php endif;?>
                            </select>
                        </label>
                        <div class="focus-topic">
                    		<p>话题：</p>
                    		<label for="f-topic">
                        		<input type="text" class="input-box" name="topic" id="topic" value="<?php echo F('escape', $cfg['topic']);?>">
                        	</label>
                        </div>
                        <div class="focus-link">
                    		<p>链接：</p>
                    		<label for="l-link">
                        		<input type="text" class="input-box" name="link" id="link" size=40 value="<?php echo F('escape', $cfg['link']);?>">
                        	</label>
                        </div>
                    </div>
                    <div class="focus-set">
                    	<p>按钮的文字：</p>
                    	<label for="focus-btn">
                        	<input type="text" class="input-box" name="btnTitle" vrel="sz=min:1,max:5,m:最多只能五个字|ne=m:不能为空" warntip="#btnTips" value="<?php echo F('escape', $cfg['btnTitle']);?>">
							<span class="a-error hidden" id="btnTips"></span>
                        </label>
                    </div>
                    <!--div class="focus-set">
                   	  <p>效果预览：</p>
						<img width="560" height="89" src="<?php echo W_BASE_URL;?>css/admin/focus_pre.png">
						<div id="preview_loading" class="preview_loading">正在上传图片，请稍候...</div>
                    </div-->
                	<div class="button ad-btnposition"><input type="submit" value="提交" name="ad"></div>
                </form>
    		</div>
        </div>
    </div>
</div>
<script type="text/javascript">
var valid = new Validator({
	form: '#form1'
});

$('#oper').change(function(e) {
	var $topic = $('#topic'),
		$link = $('#link');

	if (this.value == 1)
	{
		$link.attr('disabled', 'true');
		$topic.removeAttr('disabled');
		if (e)
		{
			$topic.focus();
		}
	}
	else {
		$topic.attr('disabled', 'true');
		$link.removeAttr('disabled');
		if (e)
		{
			$link.focus();
		}
	}
}).change();
</script>
</body>
</html>