<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>页首页脚设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script type="text/javascript">
	function add(o) {
		$('#add_link').show();
		$('#add_action').val(o);
		$("input[warntip='#nameTip1']").val('');
		$("input[warntip='#linkTip1']").val('http://');
		$('#edit_class').addClass('mask');
	}

	function closeBox(o) {
		$('#nameTip1').cssDisplay(false);
		$('#nameTip2').cssDisplay(false);
		$('#linkTip1').cssDisplay(false);
		$('#linkTip2').cssDisplay(false);
		if(o == 'add'){
			$('#add_link').hide();
		}else{
			$('#edit_link').hide();			
		}
		$('#edit_class').removeClass('mask');
	}

	function edit(id,action) {
		$('#edit_link').show();
		$('#edit_class').addClass('mask');
		$('#edit_id').val(id);
		$('#edit_action').val(action);
		$.ajax({
                url: "<?php echo URL('mgr/setting.getLinkById');?>",
				type: 'get',
                dataType:"json",
                data : {id:id, action:action},
                success : function(ret){
					$('#edit_name').val(ret.rst.link_name);
					$('#edit_address').val(ret.rst.link_address);
				}
		});
	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：功能设置<span> &gt; </span>页首页脚设置</div>
    <div class="set-wrap">
		<div class="wrap-inner">
    		<h4 class="main-title"><a class="add-new-link" href="javascript:add('head');"></a>页首链接列表</h4>
    		<div class="set-area-int">
        		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
					<colgroup>
						<col class="link-name" />
    					<col />
    					<col class="operate-w2" />
    				</colgroup>
  					<thead class="td-title-bg">
                		<tr>
    						<td>链接文字</td>
    						<td>链接</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tbody>
  						<?php if($head_link):?>
							<?php foreach($head_link as $key=>$value):?>
								<tr>
									<td><?php echo $value['link_name'];?></td>
									<td><a href="<?php echo $value['link_address'];?>" target="_blank"><?php echo $value['link_address'];?></a></td>
									<td><a class="change-icon" title="编辑" href="javascript:edit('<?php echo $key;?>','head')">编辑</a><a class="del-icon" title="删除" href="javascript:confirmDel('<?php echo URL('mgr/setting.delLink','action=head&id='.$key);?>');">删除</a></td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
                	</tbody>
				</table>
        	</div>
        </div>
        <div class="wrap-inner">
        	<h4 class="main-title"><a class="add-new-link" href="javascript:add('foot');"></a>页脚链接列表</h4>
        	<div class="set-area-int">
        		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            		<colgroup>
						<col class="link-name" />
    					<col />
    					<col class="operate-w2" />
    				</colgroup>
                	<thead class="td-title-bg">
  						<tr>
    						<td>链接文字</td>
    						<td>链接</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tbody>
  						<?php if($foot_link):?>
							<?php foreach($foot_link as $key=>$value):?>
								<tr>
									<td><?php echo $value['link_name'];?></td>
									<td><a href="<?php echo $value['link_address'];?>" target="_blank"><?php echo $value['link_address'];?></a></td>
									<td><a class="change-icon" title="编辑" href="javascript:edit('<?php echo $key;?>','foot')">编辑</a><a class="del-icon" title="删除" href="javascript:confirmDel('<?php echo URL('mgr/setting.delLink','action=foot&id='.$key);?>');">删除</a></td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
                	</tbody>
				</table>
        	</div>
        </div>
	</div>
</div>
<div class="pop-float fixed-pop" style="display:none" id="add_link">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
			<h4><a class="clos" href="javascript:closeBox('add');"></a>添加新的链接</h4>
			<div class="add-float-content">
				<form action="<?php echo URL('mgr/setting.editLink');?>" method="post" id="form1"  name="add-newlink">
					<div class="float-info">
						<label>
							<p>链接文字：</p>
							<input name="link_name" class="input-box pop-w1" type="text" warntip="#nameTip1" vrel="sz=max:6,m:长度不要超过6个字|ne=m:不能为空" value=""/><span id="nameTip1" class="a-error hidden">验证错误提示</span>
                    		<p class="tips">链接文字的长度不得超过6</p>
						</label>
					</div>
					<div class="float-info">
						<label for="link-address">
							<p>链接：</p>
							<input name="link_address" class="input-box pop-w2" type="text" value="" warntip="#linkTip1" vrel="sz=max:255,m:长度不要超过255个字|ne=m:不能为空"/><span class="a-error hidden" id="linkTip1"></span>
						</label>
					</div>
					<div class="float-button">
						<input type="hidden" name="action" id="add_action" value="" />
						<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
						<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox('add');" /></span>
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
<div class="pop-float fixed-pop" style="display:none" id="edit_link">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
			<h4><a class="clos" href="javascript:closeBox('edit');"></a>修改链接</h4>
			<div class="add-float-content">
				<form action="<?php echo URL('mgr/setting.editLink');?>" method="post" id="form2" name="changes-newlink">
					<div class="float-info">
						<label for="link-text">
							<p>链接文字：</p>
							<input name="link_name" id="edit_name" class="input-box pop-w1" type="text" value="" warntip="#nameTip2" vrel="sz=max:6,m:长度不要超过6个字|ne=m:不能为空"/><span class="a-error hidden" id="nameTip2"></span>
                            <p class="tips">链接文字的长度不得超过6</p>
						</label>
					</div>
					<div class="float-info">
						<label for="link-address">
							<p>链接：</p>
							<input name="link_address" id="edit_address" class="input-box pop-w2" type="text" value="" warntip="#linkTip2" vrel="sz=max:255,m:长度不要超过255个字|ne=m:不能为空"/><span class="a-error hidden" id="linkTip2"></span>
						</label>
					</div>
					<div class="float-button">
						<input type="hidden" name="id" id="edit_id" value="" />
						<input type="hidden" name="action" id="edit_action" value="" />
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
<div id="edit_class"></div>
<script type="text/javascript">
var valid = new Validator({
	form: '#form1'
});

var valid2 = new Validator({
	form: '#form2'
});
</script>
</body>
</html>