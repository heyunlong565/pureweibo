<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>组件设置<span> &gt; </span>组件列表</div>
    <div class="set-wrap">
        <h4 class="main-title">页面模块</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            	<colgroup>
						<col class="serial-number"/>
                        <col class="caption" />
    					<!--col class="quote-page" /-->
    					<col />
    					<col class="operate-w8" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>显示位置</td>
                        <!--td>引用页面</td-->
                        <td>组件标题</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
<?php
	
	function component_type($type) {
		$tName = '';
		switch ($type) {
			case 1:
				$tName = '模块';
			break;

			case 2:
				$tName = '挂件';
			break;
		}

		return $tName;
	}

	function component_pos($type) {
		$tName = '';

		switch ($type) {
			case 1:
				$tName = '页面主体（Content）';
			break;

			case 2:
				$tName = '侧边栏（Sidebar）';
			break;
		}

		return $tName;
	}

	$row = 1;
	foreach ($components as $com) {
		$pages = DS('PageModule.getQuotePages', '', $com['component_id']);

?>
		<tr>
			<td><?php echo $row;?></td>
			<td><?php echo component_pos($com['component_type']);?></td>
			<!--td>
			<?php
				if (!empty($pages)) {
					$pstr = array();

					foreach ($pages as $p) {
						array_push($pstr, F('escape', $p['page_name']));
					}

					echo join(',', $pstr);
				}
			?>
			</td-->
			<td><?php echo component_type($com['component_type']);?> - <?php echo F('escape', $com['name']);?>(<?php echo F('escape', $com['title']);?>)</td>
			<td><a class="page-set" href="<?php echo URL('mgr/components.config', array('id' => $com['component_id']));?>">设置</a></td>
		</tr>
<?php 
		$row++;
	}
?>
                </tbody>
			</table>
    	</div>
        <h4 class="main-title">功能插件</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            	<colgroup>
						<col class="serial-number"/>
                        <col class="caption" />
    					<col class="quote-page" />
    					<col />
    					<col class="operate-plugin" />
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>插件名称</td>
                        <td>状态</td>
                        <td>简介</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
<?php
	$row = 1;
	foreach ($plugins as $p) {
?>
                	<tr>
    					<td><?php echo $row;?></td>
    					<td><?php echo F('escape', $p['title']);?></td>
                        <td><?php if($p['in_use']):?>已<?php else:?>未<?php endif;?>开启</td>
                        <td><?php echo F('escape', $p['desc']);?></td>
    					<td>
                        	<?php if (!$p['in_use']):?>
								<a class="plugin-on" href="<?php echo URL('mgr/plugins.setStatus', array('id' => $p['plugin_id'], 'inuse' => 1));?>">开启插件</a>
							<?php else:?>
								<a class="plugin-off" href="<?php echo URL('mgr/plugins.setStatus', array('id' => $p['plugin_id'], 'inuse' => 0));?>">关闭插件</a>
							<?php endif;?>
                            <a class="page-set" href="<?php echo URL('mgr/plugins.config', array('id' => $p['plugin_id']));?>">设置</a>
                            </td>
  					</tr>
<?php
	$row++;
	}
?>
                </tbody>
			</table>
    	</div>
    </div>
</div>
</body>
</html>
