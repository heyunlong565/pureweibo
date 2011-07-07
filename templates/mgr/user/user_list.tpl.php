<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

$(function(){
	new Validator({
		form: '#searchUser'
	});
});

//-->
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户管理<span> &gt; </span>用户列表</div>
    <div class="set-wrap">
    <h4 class="main-title">用户列表</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入昵称搜索用户，然后选择相应的添加操作</p>
            	<div class="serch-user">
            		<form action="<?php echo URL('mgr/users.search');?>" id="searchUser" method="post">
            			<span><strong>搜索包含以下昵称的用户：</strong></span>
                		<span><input name="keyword" class="input-box box-address-width" type="text" vrel="sz=max:10,m:请限制在10个中文或20个英文以下。|ne" warntip="#nameTip"/></span>
                		<span class="serch-btn"><input name="" type="submit" value="搜索" /></span>
						<span class="a-error hidden" id="nameTip"></span>
                    </form>
           		</div>
            </div>
            <div class="user-list">
				<p><?php if($nickname):?>您的搜索结果如下：<?php else:?>已成功开通了本站微博的用户总计<span><?php echo $count;?></span>个，列表如下：<?php endif;?></p>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
                    <colgroup>
						<col class="serial-number" />
    					<col />
    					<col class="t-time" />
    					<col class="common-w1" />
    					<col class="common-w1" />
                        <col class="operate-w3" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
						<td>编号</td>
   					  	<td>昵称</td>
   					  	<td>开通时间</td>
   					  	<td>是否认证</td>
   					  	<td>是否封禁</td>
   					  	<td>操作</td>
				  	</tr>
              		</thead>
              		<tfoot class="tfoot-bg">
					<tr>
						<td colspan="6">
                        <div class="pre-next">
                        	<!--<form name="form" id="form"><div style="float:left;">
                            	<a class="pre" href="">上一页</a><a class="next" href="">下一页</a></div>
						    	<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
						      		<option>1/2</option>
                              		<option>2/2</option>
					        	</select>
				        	</form>-->
							<?php echo $pager;?>
                        </div>
                        </td>
					</tr>
              		</tfoot>
                	<tbody>
					<?php if($list):?>
					 <?php foreach($list as $value):?>
						<tr>
							<td><?php echo ++$num;?></td>
							<td><?php echo $value['nickname'];?></td>
							<td><?php echo date('Y-m-d H:i:s', $value['first_login']);?></td>
							<td><?php if($value['is_verify']){echo '是';}else{echo '否';}?></td>
							<td><?php if($value['is_ban']){echo '是';}else{echo '否';}?></td>
							<td>
								<a href="<?php  echo URL('ta', 'id='.$value['sina_uid'], 'index.php');?>" class="view-weibo" target="_blank">查看微博</a>
								<?php if($value['is_ban']):?><a href="<?php echo URL('mgr/users.ban', 'id=' . $value['sina_uid'] . '&ban=0');?>" class="unban">解禁</a><?php else:?><a href="<?php echo URL('mgr/users.ban', 'id=' . $value['sina_uid'] . '&ban=1');?>" class="ban">封禁</a><?php endif;?>
								<?php if($value['is_verify']):?><a href="<?php echo URL('mgr/users.authentication', 'id=' . $value['sina_uid'] . '&v=0');?>" class="renzheng-n">取消认证</a><?php else:?><a href="<?php echo URL('mgr/users.authentication', 'id=' . $value['sina_uid'] . '&nick=' . urlencode($value['nickname']) . '&v=1');?>" class="renzheng-y">授予认证</a><?php endif;?>
							</td>
						</tr>
					 <?php endforeach;?>
					<?php else:?>
						<tr><td colspan="6" class="no-data">没有搜索到任何记录</td></tr>
                    <?php endif;?>
					</tbody>
				</table>
            </div>
           
        </div>
    </div>
</div>
</body>
</html>
