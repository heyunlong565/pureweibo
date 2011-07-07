<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博广场 - 页面管理 - 外观设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：外观设置<span> &gt; </span>页面管理<span> &gt; </span><?php echo F('escape', $page['page_name']);?></div>
    <div class="set-wrap">
<?php if(!empty($main_modules)):?>
        <h4 class="main-title"><a class="change-order" id="modifyBtn1" href=""></a><a class="save-order hidden" id="saveBtn1" href=""></a>页面主体（Content）：</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border" id="tblZoom">
            	<colgroup>
						<col class="serial-number"/>
                        <col class="skincategory-name" />
    					<col />
    					<col class="status" />
    					<col class="operate-myindex" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>组件</td>
                        <td>说明</td>
                        <td>状态</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
<?php
	$row_id = 0;
	foreach($main_modules as $m):
?>
                	<tr rel="<?php echo $m['component_id'];?>">
    					<td><span class="range-icon"></span><?php echo ++$row_id;?></td>
    					<td><?php echo F('escape', $m['name']);?></td>
                        <td><?php echo F('escape', $m['desc']);?></td>
                        <td><?php echo $m['in_use'] ? '显示': '隐藏';?></td>
    					<td>
						<?php if ($m['in_use']):?>
							<a href="<?php echo URL('mgr/page_manager.set', array( 'use'=>0, 'page_id' => $page_id, 'c'=>$m['component_id']));?>" class="page-hide">隐藏</a>
						<?php else:?>
							<a href="<?php echo URL('mgr/page_manager.set', array('use'=>1, 'page_id' => $page_id, 'c'=>$m['component_id']));?>" class="page-opt">显示</a>
						<?php endif;?>
						<a href="<?php echo URL('mgr/components.config', array('id'=>$m['component_id']));?>" class="page-set">设置</a></td>
  					</tr>
<?php endforeach;?>
                </tbody>
			</table>
    	</div>
<?php endif;?>
        <h4 class="main-title"><a class="change-order" id="modifyBtn2" href=""></a><a class="save-order hidden" id="saveBtn2" href=""></a>侧边栏（SideBar）：</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border" id="tblZoom2">
            	<colgroup>
						<col class="serial-number"/>
                        <col class="skincategory-name" />
    					<col />
    					<col class="status" />
    					<col class="operate-myindex" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>组件</td>
                        <td>说明</td>
                        <td>状态</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
<?php
	$row_id = 0;
	foreach($side_modules as $m):
?>
                	<tr rel="<?php echo $m['component_id'];?>">
    					<td><span class="range-icon"></span><?php echo ++$row_id;?></td>
    					<td><?php echo F('escape', $m['name']);?></td>
                        <td><?php echo F('escape', $m['desc']);?></td>
                        <td><?php echo $m['in_use'] ? '显示': '隐藏';?></td>
    					<td>
						<?php if ($m['in_use']):?>
							<a href="<?php echo URL('mgr/page_manager.set', array( 'use'=>0, 'page_id' => $page_id, 'c'=>$m['component_id']));?>" class="page-hide">隐藏</a>
						<?php else:?>
							<a href="<?php echo URL('mgr/page_manager.set', array( 'use'=>1, 'page_id' => $page_id, 'c'=>$m['component_id']));?>" class="page-opt">显示</a>
						<?php endif;?>
						<a href="<?php echo URL('mgr/components.config', array('id'=>$m['component_id']));?>" class="page-set">设置</a></td>
  					</tr>
<?php endforeach;?>
                </tbody>
			</table>
    	</div>
    </div>
</div>
</body>
<script>
    var zoom1 = new OrderRowZoom($('#tblZoom')[0], {
        url:'<?php echo URL("mgr/page_manager.savesort", array('page_id' => $page_id, 'pos' => 1));?>',
        modifyBtn : '#modifyBtn1',
        saveBtn   : '#saveBtn1'
    });

    var zoom2 = new OrderRowZoom($('#tblZoom2')[0], {
        url:'<?php echo URL("mgr/page_manager.savesort", array('page_id' => $page_id, 'pos' => 2));?>',
        modifyBtn : '#modifyBtn2',
        saveBtn   : '#saveBtn2',
        paramName : 'ids'
    });
    
</script>
</html>
