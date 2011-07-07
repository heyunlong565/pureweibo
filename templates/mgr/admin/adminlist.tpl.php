<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员用户列表 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：帐号管理<span> &gt; </span>管理员用户列表</div>
    <div class="set-wrap">
        <h4 class="main-title">管理员用户列表</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            	<colgroup>
					<col class="serial-number"/>
                    <col class="admin-name" />
    				<col />
    				<col class="t-time" />
    				<col class="operate-adminlist" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>管理员昵称</td>
                        <td>微博地址</td>
                        <td>添加时间</td>
    					<td>操作</td>
  					</tr>
                </thead>
              	<tfoot class="tfoot-bg">
					<tr>
						<td colspan="5">
                        <div class="pre-next">
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
							<td><?php if(isset($value['userinfo']['nickname'])) echo $value['userinfo']['nickname'];?></td>
							<td><a href="<?php echo URL('ta', 'id='.$value['sina_uid'] ,'index.php');?>" target="_blank"><?php echo $value['http_url'];?></a></td>
							<td><?php echo date('Y-m-d H:i:s', $value['add_time']);?></td>
							<td><a class="view-weibo" href="<?php echo URL('ta', 'id='.$value['sina_uid'] ,'index.php');?>" target="_blank">查看微博</a>
								<?php if($admin_root && $value['id'] != $admin_id):?>
									<a class="cancel-ext" href="javascript:if(confirm('您确定取消<?php echo $value['userinfo']['nickname'];?>的管理员权限吗？')) {window.location.href='<?php echo URL('mgr/admin.del', 'id=' . $value['id']);?>'}">取消管理员权限</a>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					<?php endif;?>
                </tbody>
			</table>
    	</div>
    </div>
</div>
</body>
</html>
