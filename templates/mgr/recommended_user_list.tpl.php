<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户推荐管理 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户管理<span> &gt; </span><?php echo $group_name;?>管理</div>
    <div class="set-wrap">
        <h4 class="main-title" id="title_list"><a class="add-new-user" href="javascript:add('user');"></a><a class="change-order" href="" id="modifyBtn"></a><a class="save-order hidden" href="" id="saveBtn"></a><?php echo $group_name;?></h4>
		<div class="set-area-int">
            <div class="user-list">
				<?php if($userlist):?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border" id="tblZoom">
            		<colgroup>
						<col class="checkbox-tab"/>
                        <col class="serial-number" />
    					<col class="user-name" />
    					<col />
    					<col class="rec-user-remarks" />
    					<col class="operate-w2" />
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
    						<td class="checkbox-tab"></td>
                            <td>编号</td>
    						<td>昵称</td>
    						<td>微博地址</td>
                    		<td>备注</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tfoot>
                    	<tr>
                    		<td colspan="6">
                            	<input name="slectALL" id="selectAll" class="select-all" type="checkbox" value="" />全选
                                <a class="del-all" href="javascript:delSelectId('<?php echo URL('mgr/user_recommend.delAllUserById','group_id=' . $group_id );?>');">将所选用户从列表中删除</a></td>
                   		</tr>
                    </tfoot>
                	<tbody class="order-main" id="recordList">
						<?php $i=1;foreach($userlist as $value):?>
							<tr rel="<?php echo $value['uid'];?>">
								<td><span class="range-icon"></span><div class="default"><input name="uids" type="checkbox" value="<?php echo $value['uid'];?>" /></div></td>
								<td><?php echo $i++;?></td>
								<td><?php echo $value['nickname'];?></td>
								<td><a href="<?php echo $value['http_url'];?>" target="_blank"><?php echo $value['http_url'];?></a></td>
								<td><?php echo $value['remark'];?></td>
								<td>
                                	<a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['uid']?>','<?php echo $value['group_id']?>','<?php echo $value['nickname']?>','<?php echo $value['remark']?>')">编辑</a>
                                    <a class="del-icon" title="删除" href="javascript:confirmDel('<?php echo URL('mgr/user_recommend.delUserById','group_id=' . $value['group_id'] . '&uid=' . $value['uid']);?>');">删除</a>
                                </td>
							</tr>
						<?php endforeach;?>
                	</tbody>
				</table>
				<?php elseif($group_id):?>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            		<colgroup>
						<col class="checkbox-tab"/>
                        <col class="serial-number" />
    					<col class="user-name" />
    					<col />
    					<col class="rec-user-remarks" />
    					<col class="operate-w1" />
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
    						<td></td>
                            <td>编号</td>
    						<td>昵称</td>
    						<td>微博地址</td>
                    		<td>备注</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tbody class="no-data">
							<tr>
								<td colspan="6" class="no-data">没有数据，请<a href="javascript:add('user');">添加新成员</a></td>
							</tr>
                	</tbody>
				</table>
				<?php endif;?>
            </div>
        </div>
    </div>
    
<div class="pop-float fixed-pop" style="display:none" id="add_user">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox('user');"></a>添加新成员</h4>
            <div class="add-float-content">
            	<form id="addReUsrForm" action="<?php echo URL('mgr/user_recommend.addReUser');?>" method="post"  name="add-newlink">
            		<div class="float-info">
            			<label for="link-text">
            				<p><span>*</span>请输入新成员的昵称：</p>
            				<input name="nickname" class="input-box pop-w4" type="text" value="" vrel="_f|ne|sz=max:10,m:不能多于10个汉字" warntip="#nickTip" /><span class="a-error hidden" id="nickTip"></span>
            			</label>
            		</div>
            		<div class="float-info">
            			<label for="link-address">
            				<p><span>*</span>您对新成员的一句话备注(限10字)：</p>
            				<input name="remark" class="input-box pop-w4" type="text" value="" vrel="_f|ne|sz=max:10,m:不能多于10个汉字" warntip="#remarkTip" /><span class="a-error hidden" id="remarkTip"></span>
            			</label>
            		</div>
                    <div class="float-button">
                    	<input name="group_id" type="hidden" value="<?php echo $group_id;?>"/>
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox('user');" /></span>
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
<div class="pop-float fixed-pop" style="display:none" id="edit_user">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox()"></a>编辑成员备注</h4>
            <div class="add-float-content">
            	<form id="mdyUsrForm" action="<?php echo URL('mgr/user_recommend.setUserRemark');?>" method="post"  name="">
            		<div class="float-info">
            			<p>成员的昵称：</p>
                        <label><span class="name" id="username"></span></label>
            		</div>
            		<div class="float-info">
            			<label for="remark">
            				<p>您对新成员的一句话备注(限10字)：</p>
            				<input name="remark" id="remark" class="input-box pop-w4" type="text" value="" vrel="_f|ne|sz=max:10,m:不能多于10个汉字" warntip="#mdyTip" /><span class="a-error hidden" id="mdyTip"></span>
            			</label>
            		</div>
                    <div class="float-button">
                    	<input name="group_id" type="hidden" id="user_group_id" value=""/>
						<input name="uid" type="hidden" id="user_uid" value=""/>
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox();" /></span>
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
	function add(o) {
		$('#add_user').show();
		$("input[warntip='nickTip']").val('');
		$("input[warntip='remarkTip']").val('');
		$('#edit_class').addClass('mask');
	}

	function closeBox(o) {
		$("#nickTip").cssDisplay(false);
		$("#remarkTip").cssDisplay(false);
		$("#mdyTip").cssDisplay(false);
		if(o == 'user'){
			$('#add_user').hide();
		}else{
			$('#edit_user').hide();
		}
		$('#edit_class').removeClass('mask');
	}

	function edit(id, group_id, name, text) {
		$('#user_uid').val(id);
		$('#user_group_id').val(group_id);
		$('#username').html(name);
		$('#remark').val(text);
		$('#edit_user').show();
		$('#edit_class').addClass('mask');
	}

	$(function() {
		bindSelectAll('#selectAll','#recordList > tr > td > div > input[type=checkbox]');
	});

	function delSelectId(url) {
		var $checkbox = $('#recordList > tr > td > div > input[type=checkbox]:checked');
		var ids;
		for (var i=0; i<$checkbox.length; i++) {
			if(ids)
				ids += ','+$checkbox.eq(i).val();
			else
				ids = $checkbox.eq(i).val();
		}
		//alert(url+'&uids='+ids);
		if(ids)
			confirmDel(url+'&uids='+ids, '您确定要删除这些数据吗？');
		else
			window.location.href="#";
	}
	
    var zoom = new OrderRowZoom($('#tblZoom')[0], {
		param:{group_id:<?php echo $group_id;?>},
        url:'<?php echo URL('mgr/user_recommend.userSortById');?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'uids'
    });
    new Validator({form:'#addReUsrForm'});
    new Validator({form:'#mdyUsrForm'});
</script>
</body>
</html>
