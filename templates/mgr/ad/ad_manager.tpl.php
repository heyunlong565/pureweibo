<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>广告位列表 - 广告管理 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>组件管理</span> &gt; <span>广告管理</span> &gt; <span>广告位列表</span>
	</div>
	<div class="set-wrap">

<h4 class="main-title"> 广告位列表</h4>
		<div class="set-area-int">
        	
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
					<colgroup>
						<col class="num" />
    					<col class="pos"/>
    					<col class="range"/>
						<col class="status"  />
						<col class="mod" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
						<th><div class="td-inside">编号</div></th>
						<th><div class="td-inside">广告位</div></th>
   					  	<th><div class="td-inside">广告投放范围</div></th>
						<th><div class="td-inside">广告位状态</div></th>
   					  	<th><div class="td-inside">操作</div></th>
				  	</tr>
              		</thead>
              		
                	<tbody>
					<?php if (isset($data) && is_array($data)) {foreach($data as $index => $row) {?>
				  	<tr>
   					  	<td><?php echo $index + 1;?></td>
   					  	<td><?php echo $row['name'];?></td>
   					  	<td><?php echo $row['description'];?></td>
   					  	<td><?php echo $row['using']?'启用中':'已禁用';?></td>
						<td class="mod-td">
								
									<a href="javascript:delConfirm('<?php echo URL('mgr/ad.stateChg', 'id='. $row['id'] . '&state='.(int)!(int)$row['using'] , 'admin.php')?>', '确认要改变该状态吗?')" class="using"><?php echo $row['using']?'禁用':'启用';?></a>
									<a href="<?php echo URL('mgr/ad.edit', 'id='. $row['id'] , 'admin.php')?>" class="page-set">设置</a>
								
						</td>
					</tr>
					<?php }}?>
					</tbody>
				</table>
            </div>
			
     
   </div>
</div>
</body>
</html>
