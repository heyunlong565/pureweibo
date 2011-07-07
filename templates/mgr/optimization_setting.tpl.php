<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>优化设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：功能设置<span> &gt; </span>优化设置</div>
    <div class="set-wrap">
    	<form action="<?php echo URL('mgr/setting.editRewrite')?>" name="rewrite" method="post">
    	<div class="wrap-inner">
			<h4 class="main-title">请选择是否为您网站中的Xweibo提供Rewrite功能</h4>
            <div class="rewrite">
        		<p class="tips">Rewrite功能将URL 静态化可以提高搜索引擎抓取，开启本功能需要对 Web 服务器增加相应的 Rewrite 规则，且会轻微增加服务器负担。</p>
                <label for="rewrite-open">
                    <input id="rewrite-open" class="radio-same" name="rewrite_way" type="radio" value="1" <?php if($config['rewrite_enable'] == 1) echo 'checked="checked"'; ?> />开启
                </label>
                <br />
                <label for="rewrite-closed">
                    <input id="rewrite-closed" class="radio-same" name="rewrite_way" type="radio" value="0" <?php if($config['rewrite_enable'] == 0) echo 'checked="checked"'; ?> />关闭
                </label>
            </div>
            <div class="rewrite-s">
            	<p class="tips">如果选择了开启Rewrite功能，请将以下代码复制粘贴至Xweibo根目录下的.htaccess文件中；如果选择了关闭，请将已添加的代码删除即可。</p>
                <div class="rewrite-code">
					<p>RewriteEngine on</p>
					<p class="rewrite-t">RewriteCond $1 ^(application/|templates/|cron/|config\.php$)</p>
					<p class="rewrite-t">RewriteRule ^/(.*)$ /deny.php [L]</p>
					<p class="rewrite-t">RewriteCond $1 !^(js/|img/|css/|flash/|var/|robots\.txt$|.+\.php([^A-Za-z0-9_]|$)|crossdomain\.xml$|favicon\.ico$|admin/$)</p>
					<p class="rewrite-t">RewriteRule ^/(.*)$ /index.php/$1?%{QUERY_STRING} [L]</p>
				</div>
            </div>
        	<div class="button button-position"><input type="submit" name="保存修改" value="保存修改" /></div>
		</div>
		</form>
	</div>
</div>
</body>
</html>
