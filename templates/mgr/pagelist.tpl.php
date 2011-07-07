<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>页面设置 - 页面管理 - 外观设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：外观设置<span> &gt; </span>页面管理<span> &gt; </span>页面设置</div>
    <div class="set-wrap">
        <h4 class="main-title">页面列表</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            	<colgroup>
						<col class="serial-number"/>
                        <col class="skincategory-name" />
    					<col class="rec-type" />
    					<col />
    					<col class="operate-w8" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>页面名称</td>
                        <td>类别</td>
                        <td>说明</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
<?php if (!empty($pages)):?>
	<?php
		$row_id = 0;
		foreach($pages as $p): 
		$row_id++;
	?>
                	<tr>
    					<td><?php echo $row_id;?></td>
    					<td><?php echo F('escape', $p['page_name']);?></td>
                        <td><?php echo $p['native']?'内置':'自定义';?></td>
                        <td><?php echo F('escape', $p['desc']);?></td>
    					<td><a href="<?php echo URL('mgr/page_manager.setting', array('id'=>$p['page_id']));?>" class="page-set">设置</a></td>
  					</tr>
	<?php endforeach;?>
<?php endif;?>
                </tbody>
			</table>
            <p class="page-tips">*温馨提示：<br />Xweibo当中只有部分页面支持设置，如果某个页面设置之后，它的子页面会自动应用这些设置。 譬如，“我的微博”、“我的粉丝”属于“我的首页”的子页面，也会应用“我的首页”的设置。</p>
    	</div>
    </div>
</div>
</body>
</html>
