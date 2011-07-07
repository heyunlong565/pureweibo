<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>帐号管理</span> &gt; <span>修改密码</span></div>
    <div class="set-wrap">
        <h4 class="main-title">修改密码</h4>
		<div class="set-area-int">
        	<div class="adminname-show">
            	<p><span>帐号：</span><?php echo $info['sina_uid'];?></p>
                <p><span>昵称：</span><?php echo $nick;?></p>
            </div>
            <div class="change-password">
            <form action="" method="post">
            	<label for="">
                	<p><span>*</span>请输入您需要设置的新密码：</p>
                	<input name="pwd" class="input-box float-newuser" type="password" />
                </label>
                <label for="">
                	<p><span>*</span>请再输入一次新密码：</p>
                	<input name="re_pwd" class="input-box float-newuser" type="password" />
                </label>
				<input name="id" type="hidden" value="<?php echo $info['id'];?>" />
                <div class="button password-btn-position"><input name="" type="submit" value="提交" /></div>
            </form>
            </div>
    	</div>
    </div>
</div>
</body>
</html>
