<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关键字过滤 - 微博管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博管理<span> &gt; </span>关键字过滤</div>
    <div class="set-wrap">
        <h4 class="main-title">添加关键字</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入要验证的关键字（多个可用半角逗号隔开）<a href="<?php echo URL('mgr/weibo/keyword.keywordList','', 'admin.php');?>">返回关键字列表</a></p>
                <form action="<?php echo URL('mgr/weibo/keyword.add');?>" method="post">
            		<textarea class="input-box keyword-width"  name="keywords" cols="" rows=""></textarea>
                    <label class="keyword-tips" for="keyword"><span class="key-tip-icon">关键字设置会消耗大量的系统资源，请尽量不要设置过多的关键字</span></label>
                    <div class="button keyword-btn-position"><input type="submit" value="提交"/></div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
