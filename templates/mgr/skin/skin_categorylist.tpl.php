<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>皮肤类别 - 皮肤管理 - 界面管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
</head>
<body class="main-body">
    <div class="main-cont">
        <h3 class="title"><a class="general-btn" href="javascript:add();"><span>添加新类别</span></a><a class="general-btn" href="" id="modifyBtn"><span>修改排序</span></a><a class="general-btn hidden" href="" id="saveBtn"><span>保存排序</span></a>可用的皮肤类别</h3>
		<div class="set-area">
        	<table  class="table" id="tblZoom" cellpadding="0" cellspacing="0" width="100%" border="0">
            	<colgroup>
						<col class="h-w70"/>
    					<col />
    					<col class="h-w130"/>
    			</colgroup>
                <thead class="tb-tit-bg">
  					<tr>
    					<th><div class="th-gap">编号</div></th>
    					<th><div class="th-gap">名称</div></th>
    					<th><div class="th-gap">操作</div></th>
  					</tr>
                </thead>
                <tfoot class="tb-tit-bg"></tfoot>
                <tbody>
					<?php if($list):?>
					  <?php $i=1;foreach($list as $value):?>
						<tr rel="<?php echo $value['style_id'];?>">
							<td><span class="icon-range"></span><?php echo $i++;?></td>
							<td><?php echo $value['style_name'];?></td>
							<td><a class="icon-edit" title="编辑" href="javascript:edit('<?php echo $value['style_id'];?>','<?php echo $value['style_name'];?>')">编辑</a>
                            <a class="icon-del" title="删除" href="javascript:delConfirm('<?php echo URL('mgr/skin.delSkinSort', 'id=' . $value['style_id']);?>');">删除</a></td>
						</tr>
					  <?php endforeach;?>
					<?php else:?>
						<tr><td colspan="3"><p class="no-data">没有任何记录</p></td></tr>
					<?php endif;?>
                </tbody>
			</table>
    	</div>
    </div>
<script type="text/javascript">
	var addHtmlMode=[' <form id="addSkinClsForm" action="<?php echo URL('mgr/skin.addSkinSort');?>" method="post"  name="add-newskin">',
		            	' 	<div class="pop-form skin-class">',
		            	' 		<div class="form-row">',
		            	'			<label>分类名称</label>',
		            	'			<div class="form-cont">',
		            	'				<input id="addInputor" name="style_name" class="input-txt" warntip="#asTip" vrel="_f|ne|sinan|sz=max:10,m:不能超过5个字,ww" type="text" value=""/><span id="asTip" class="tips-error hidden">验证错误提示</span>',
						'            <p class="form-tips">最多输入5个汉字或10个字母<br />最多可创建5个皮肤主题分类</p>',
		            	'			</div>',
		            	'		</div>',
		                '    	<div class="btn-area">',
                    	'			<a href="#" class="general-btn btn-s2" id="submitBtn"><span>确定</span></a>',
                    	'			<a href="#" class="general-btn" id="pop_cancel"><span>取消</span></a>',
		                '   	 </div>',
		                '    </div>',
                	'</form>'].join('');
                	
    var editHtmlMode=['<form id="mdySkinForm" action="<?php echo URL('mgr/skin.editSkinSort');?>" method="post"  name="operate-newskin">',		
		            	' 	<div class="pop-form">',
		            	' 		<div class="form-row">',	
		            	'			<label for="mdyInputor">分类名称</label>',
		            	'			<div class="form-cont">',
		            	'			<input id="mdyInputor" name="style_name" class="input-txt" vrel="_f|ne|sinan|sz=max:10,m:不能超过5个字,ww" warntip="#mdyTip" type="text" value=""/><span id="mdyTip" class="tips-error hidden">验证错误提示</span>',
						'            <p class="form-tips">最多输入5个汉字或10个字母<br />最多可创建5个皮肤主题分类</p>',
		            	'			</div>',
		            	'		</div>',
		                '    	<div class="btn-area">',
						'			<input type="hidden" name="style_id" id="style_id" value="" />',
                    	'			<a href="#" class="general-btn btn-s2" id="submitBtn"><span>确定</span></a>',
                    	'			<a href="#" class="general-btn" id="pop_cancel"><span>取消</span></a>',
		                '    	</div>',
		                '    </div>',
                	'</form>'].join('');
                	
	function add() {
		Xwb.use('MgrDlg',{
			modeHtml:addHtmlMode,
			formMode:true,
			valcfg:{
				form:'AUTO',
				trigger: '#submitBtn'
			},
			dlgcfg:{
				cs:'add-skin win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
				},
				destroyOnClose:true,
				actionMgr:false,
				title:'添加新的皮肤类别'
			}
		})
	}

	function edit(id, text) {
		
	 Xwb.use('MgrDlg',{
			modeHtml:editHtmlMode,
			formMode:true,
			valcfg:{
				form:'AUTO',
				trigger: '#submitBtn'
			},
			dlgcfg:{
				cs:'add-skin win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					});
					$(View).find('#style_id').val(id);
					$(View).find('#mdyInputor').val(text);
				},
				destroyOnClose:true,
				actionMgr:false,
				title:'编辑皮肤类别的名称'
			}
		})
	}

	
    var zoom = new OrderRowZoom($('#tblZoom')[0], {
        url:'<?php echo URL('mgr/skin.setSkinSortOrderById');?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'style_ids'
    });   
</script>
</body>
</html>
