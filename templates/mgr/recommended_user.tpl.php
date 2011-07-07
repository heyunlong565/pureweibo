<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户推荐管理 - 用户管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script type="text/javascript">
	function add(o) {
		if(o == 'list') {
			$("input[warntip='#nameTip']").val('');
			$('#add_list').show();
		}
		$('#edit_class').addClass('mask');
	}

	function closeBox(o) {
		$("#nameTip").cssDisplay(false);
		if(o == 'list'){
			$('#add_list').hide();
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
</script>

</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>用户管理<span> &gt; </span>用户推荐管理</div>
    <div class="set-wrap">
        <h4 class="main-title"><a class="add-list" href="javascript:add('list');"></a>可用的用户列表</h4>
		<div class="set-area-int">
            <div class="user-list">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
                    <colgroup>
						<col class="serial-number" />
    					<col />
    					<col class="common-w1" />
    					<col class="operate-w4" />
    				</colgroup>
					<thead class="td-title-bg">
                    <tr>
						<td>编号</td>
   					  	<td>名称</td>
   					  	<td>类型</td>
   					  	<!--<td>组件应用情况</td>-->
   					  	<td>操作</td>
				  	</tr>
              		</thead>
                	<tbody>
					<?php $i=1;foreach($list as $value):?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $value['group_name'];?></td>
							<td><?php if($value['native']){echo "内置";}else{echo "自定义";}?></td>
							<td>
								<a class="view-list" href="<?php echo URL('mgr/user_recommend.getUserById','group_id=' . $value['group_id']);?>">查看成员</a>
								<?php if(!$value['native']) {
									echo '<a class="del-icon" href="javascript:confirmDel(\'' . URL('mgr/user_recommend.delReSortById','id=' . $value['group_id']) . '\');"> 删除</a>';
								}?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
            </div>
        </div> 
    </div>
    
<div class="pop-float fixed-pop" id="add_list" style="display:none">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox('list');"></a>添加新的列表</h4>
            <div class="add-float-content">
            	<form action="<?php echo URL('mgr/user_recommend.addReSort');?>" method="post"  name="changes-newlink" id="form1">
            		<div class="float-info">
            			<label>
            				<p>列表名称：</p>
            				<input name="name" class="input-box pop-w3" type="text" warntip="#nameTip" vrel="sz=max:8,m:长度不要超过8个字|ne=m:不能为空" value=""/><span class="a-error hidden" id="nameTip"></span>
            			</label>
            		</div>
                    <div class="float-button">
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox('list');"/></span>
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
var valid = new Validator({
	form: '#form1'
});
</script>
</body>
</html>
