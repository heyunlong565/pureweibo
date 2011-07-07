<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>皮肤类别 - 皮肤管理 - 外观设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：<span>外观设置</span> &gt; <span>皮肤管理</span> &gt; <span>皮肤类别</span></div>
    <div class="set-wrap">
        <h4 class="main-title"><a class="add-new-category" href="javascript:add();"></a><a class="change-order" href="" id="modifyBtn"></a><a class="save-order hidden" href="" id="saveBtn"></a>可用的皮肤类别</h4>
		<div class="set-area-int">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border" id="tblZoom">
            	<colgroup>
						<col class="serial-number"/>
    					<col />
    					<col class="operate-w2"/>
    			</colgroup>
                <thead class="td-title-bg">
  					<tr>
    					<td>编号</td>
    					<td>名称</td>
    					<td>操作</td>
  					</tr>
                </thead>
                <tbody>
					<?php if($list):?>
					  <?php $i=1;foreach($list as $value):?>
						<tr rel="<?php echo $value['style_id'];?>">
							<td><span class="range-icon"></span><?php echo $i++;?></td>
							<td><?php echo $value['style_name'];?></td>
							<td><a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['style_id'];?>','<?php echo $value['style_name'];?>')">编辑</a>
                            <a class="del-icon" title="删除" href="javascript:confirmDel('<?php echo URL('mgr/skin.delSkinSort', 'id=' . $value['style_id']);?>');">删除</a></td>
						</tr>
					  <?php endforeach;?>
					<?php else:?>
						<tr><td colspan="3" class="no-data">没有任何记录</td></tr>
					<?php endif;?>
                </tbody>
			</table>
    	</div>
    </div>

<div class="pop-float fixed-pop" id="edit" style="display:none">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox('edit');"></a>编辑皮肤类别的名称</h4>
            <div class="add-float-content">
            	<form id="mdySkinForm" action="<?php echo URL('mgr/skin.editSkinSort');?>" method="post"  name="operate-newskin">					
            		<div class="float-info">
            			<label>
            				<p>分类名称：</p>
            				<input id="mdyInputor" name="style_name" class="input-box pop-w8" vrel="_f|ne|nw|sz=max:5,m:长度不多于5个汉字或10个字母" warntip="#mdyTip" type="text" value=""/><span id="mdyTip" class="a-error hidden">验证错误提示</span>
            			</label>
            		</div>
                    <div class="float-button">
						<input type="hidden" name="style_id" id="style_id" value="" />
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox('edit');"/></span>
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

<div class="pop-float fixed-pop" id="add" style="display:none">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox('add');"></a>添加新的皮肤类别</h4>
            <div class="add-float-content">
            	<form id="addSkinClsForm" action="<?php echo URL('mgr/skin.addSkinSort');?>" method="post"  name="add-newskin">
            		<div class="float-info">
            			<label>
            				<p>分类名称：</p>
            				<input id="addInputor" name="style_name" class="input-box pop-w8" warntip="#asTip" vrel="_f|ne|nw|sz=max:5,m:长度不多于5个汉字或10个字母" type="text" value=""/><span id="asTip" class="a-error hidden">验证错误提示</span>
                            <p class="tips">最多输入5个汉字或10个字母，最多可创建5个皮肤主题分类</p>
            			</label>
            		</div>
                    <div class="float-button">
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox('add');"/></span>
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

</div>
<div id="edit_class"></div>
<script type="text/javascript">
	function add() {
		$('#add').show();
		$("input[warntip='#asTip']").val('');
		$('#addInputor').focus();
		$('#edit_class').addClass('mask');
	}

	function edit(id, text) {
		$('#style_id').val(id);
		$('#mdyInputor').val(text);
		$('#edit').show();
		$('#mdyInputor').focus();
		$('#edit_class').addClass('mask');
	}

	function closeBox(o) {
		$('#asTip').cssDisplay(false);
		if(o == 'add'){
			$('#add').hide();
		}else{
			$('#edit').hide();
		}
		$('#edit_class').removeClass('mask');
	}
	
    var zoom = new OrderRowZoom($('#tblZoom')[0], {
        url:'<?php echo URL('mgr/skin.setSkinSortOrderById');?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'style_ids'
    });
    
    
    new Validator({
        form : '#addSkinClsForm'
    });
    
    new Validator({
        form : '#mdySkinForm'
    });    
</script>
</body>
</html>
