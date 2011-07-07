<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加管理员用户 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script type="text/javascript">
	function add(id) {
		$('#add_admin').show();
		$('#uid').val(id);
		$('#edit_class').addClass('mask');
	}

	function closeBox() {
		$('#add_admin').hide();
		$('#edit_class').removeClass('mask');
	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>帐号管理</span> &gt; <span>添加管理员用户</span></div>
    <div class="set-wrap">
        <h4 class="main-title">添加管理员用户</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索用户，然后选择相应的添加操作。</p>
            	<div class="serch-user">
                	<form action="" method="post">
            			<span><strong>搜索包含以下昵称的用户：</strong></span>
                		<span><input name="keyword" class="input-box box-address-width" type="text" /></span>
                		<span class="serch-btn"><input name="" type="submit" value="搜索" /></span>
                    </form>
           		</div>
				<?php if($this->_isPost() && !V('r:keyword', false)):?>
					<div class="serch-results-no">请输入昵称</div>
				<?php elseif(!V('r:keyword', false)):?>

				<?php elseif(isset($list)):?>
                  <ul class="serch-results">
					<?php $i=1;foreach($list as $value):?>
                	<?php if($i==1):$i++;?><li class="result-line-no"><?php else:?><li class="result-line"><?php endif;?>
                    	<div class="results-l">
                        	<p class="results-name"><?php echo $value['nickname'];?></p>
                            <p><span><?php echo $value['userinfo']['location'];?></span><span>粉丝数：<?php echo $value['userinfo']['followers_count'];?>人</span></p>
                        </div>
                        <div class="results-r">
							<a href="javascript:add('<?php echo $value['sina_uid'];?>')" >添加管理员权限</a>
                        </div>
                    </li>
					<?php endforeach;?>
				  </ul>
				<?php else:?>
					 <div class="serch-results-no">该用户不存在或者未开通本站微博</div>
				<?php endif;?>
            </div>
    	</div>
    </div>
</div>
<div class="pop-float fixed-pop" id="add_admin" style="display:none">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox();"></a>为管理员设置初始密码：</h4>
            <div class="add-float-content">
            	<form id="pwdForm" action="<?php echo URL('mgr/admin.add');?>" method="post">
            		<div class="float-info">
            			<label for="add-initial-password">
            				<p>密码：</p>
            				<input name="pwd" class="input-box float-newuser" vrel="_f|ne|sz=min:3,max:8,m:密码长度为6-16位|pw" type="password" value="" warntip="#nameTip" /><span class="a-error hidden" id="nameTip"></span>
            			</label>
                        <p class="password-tips">密码由6-16位的数字、字母、半角 “.” “-” “?” 和下划线组成</p>
            		</div>
                    <div class="float-button">
						<input name="uid" type="hidden" id="uid" value=""/>
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox();" /></span>
                    </div>
              </form>
			</div>
		</div>
		<div class="pop-inner-bg"></div>
	</div>
	<div class="pop-b">
		<div></div>
	</div>
</div>
<div id="edit_class"></div>
<script>
    new Validator({form:'#pwdForm'});
</script>
</body>
</html>
