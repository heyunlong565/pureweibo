<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<title>页面设置 - 页面模块 - 界面管理</title>

<link type="text/css" rel="stylesheet" href="<?php echo W_BASE_URL;?>css/admin/admin.css" media="screen" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript">
	var pageID= <?php echo $page_id;?>;
</script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/pagesetting.js"></script>
</head>

<body class="main-body">
	<div class="path"><p>当前位置：界面管理<span>&gt;</span><a href="<?php echo URL('mgr/page_manager') ?>">页面设置</a><span>&gt;</span><?php echo $page['page_name'];?>设置</p></div>
	<div class="main-cont">
		<h3 class="title"><?php echo $page['page_name'];?>设置</h3>
		<div class="drag-area clear">
			<div class="caption-box"><span>logo位置</span></div>
			<div class="drag-area-left" id="left">
			<?php if (!$page['native'] ||  $page['page_id'] == '1') {?>
				<?php if (isset($main_modules) && is_array($main_modules) && !empty($main_modules)) { foreach($main_modules as $m) { ?>
				<div class="drag-box" data="<?php echo $m['id']; ?>">
					<h4>
						<span>
						<?php if (16 != $m['component_id'] ) { // 微博发布框不用设置 ?>
						<a href="javascript:openPop('<?php echo URL('mgr/page_manager.editComponentView', array('page_id'=>$page_id, 'id'=>$m['id'])).'\' ,\''.$m['title'].'设置\','.$m['component_id'] ;?>);" >设置</a>
						<?php } ?>
						
						<?php if(empty($m['isNative'])) { ?>
							<a href="javascript:delConfirm('<?php echo URL('mgr/page_manager.delComponent', array('page_id'=>$page_id, 'pmId'=>$m['id']));?>');" title="删除">删除</a>
						<?php } ?>
						</span>

						<?php echo F('escape', $m['newTitle']);?>
						<em style='color:#707070'> — <?php echo F('escape',$m['name'])?></em>
					</h4>
				</div>
				<?php }?>


			<?php } else {?>
				<p class="no-data">
					您添加的页面还没有内容,您可以添加一些模块
				</p>
			<?php }?>
			<a class="general-btn" href="javascript:newPop('<?php echo URL('mgr/page_manager.componentCategory', array('page_id'=>$page_id, 'componentType'=>1));?>','添加新组件','692');"><span>添加主体模块</span></a>
			<?php } else {?>
				<p class="no-data">
					该页面没有可以添加模块
				</p>
			<?php }?>
			</div>

			<div class="drag-area-right" id="right" >
				<div class="caption-box"><span>个人信息</span></div>
				<?php if (isset($side_modules) && is_array($side_modules) && !empty($side_modules)) {foreach($side_modules as $m) {?>
					<div class="drag-box"  data="<?php echo $m['id']; ?>">
						<h4>
						<span>
						<a href="javascript:openPop('<?php echo URL('mgr/page_manager.editComponentView', array('page_id'=>$page_id, 'id'=>$m['id'])).'\',\''.$m['title'].'设置\','.$m['component_id'] ;?>);" >设置</a>
						<?php if(empty($m['isNative'])) { ?>
							<a href="javascript:delConfirm('<?php echo URL('mgr/page_manager.delComponent', array('page_id'=>$page_id, 'pmId'=>$m['id']));?>');" title="删除">删除</a>
						<?php } ?>
						</span>
						<?php echo F('escape', $m['name']);?>
						</h4>
					</div>
				<?php }} else {?>
				<p class="no-data">
					您添加的页面还没有内容,您可以添加一些模块
				</p>
				<?php }?>
				<a class="general-btn" href="javascript:newPop('<?php echo URL('mgr/page_manager.componentCategory', array('page_id'=>$page_id, 'componentType'=>2));?>','添加新组件','692');"><span>添加右侧模块</span></a>
			</div>
		</div>
		<p>
			<a class="general-btn btn-s2" target="_blank" href="<?php echo URL("{$page['url']}", array('page_id'=>$page_id), 'index.php');?>"><span>预览</span></a>
			<a class="general-btn" href="javascript:;" id="saveSort"><span>保存</span></a>
		</p>
	</div>
</body>
</html>
