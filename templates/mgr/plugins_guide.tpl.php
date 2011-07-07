<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 插件设置 - 登录后引导关注</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo W_BASE_URL;?>js/admin_lib.js" type="text/javascript"></script>
<script>
$(function() {
	
<?php 
$htmls = array();
foreach($list as $g) {
	if ($g['group_id'] == 4)
	{
		continue;
	}
	array_push($htmls, '{val:'. $g['group_id'] . ', text:\'' . F('escape', $g['group_name']) . '\'}');
}
	echo 'var optHtmls = [', join(',', $htmls) ,'];', "\r\n";
?>
	var editId = '';

	var box = new ui.cateBox({
		onViewReady: function() {
			this.setOptions(optHtmls);
		},
		complete: function(mode, result) {
			var data = {
				op: mode
			};

			data['item_id'] = this.select();
			data['item_name'] = this.content();

			if (editId)
			{
				data['id'] = editId;
			}

			$.ajax({
				url: '<?php echo URL("mgr/plugins.itemgroup");?>',
				data: data,
				type: 'post',
				dataType: 'json',
				cache: false,
				success: function(ret) {
					window.location.reload();
				}
			});
		}
	});


	$('#panel').click(function(e) {
		var $target = $(e.target);
		var rel = $target.attr('rel');

		if (rel)
		{

			switch (rel)
			{
			case 'add':
				editId = '';
				box.show();
				box.reset();
			break;

			case 'edit':
			case 'del':
				var $row = $target.closest('TR');
				var vals = $row.attr('rel').split(',');
				var id = vals[0];

				if (rel == 'edit')
				{
					editId = id;
					box.edit(vals[2], vals[1]);
					box.show();
				} else {
					if (confirm('确定要删除这个类别吗？'))
					{
						$.ajax({
							url: '<?php echo URL("mgr/plugins.itemgroup");?>',
							data: {id: id, op:'del'},
							type: 'post',
							dataType: 'json',
							cache: false,
							success: function(ret) {
								if (ret.errno == 0)
								{
									$row.remove();
								}
							}
						});
					}
				}

			break;
			
			}


			e.preventDefault();
		}
	});

	//自动关注开关
	function autoFollowSet() {
		var $radio = $(this);

		if ($radio.val() == '1')
		{
			$('#followList').css('visibility', '');
		} else {
			$('#followList').css('visibility', 'hidden');
		}
	}

	$('input[name=auto_follow]').click(autoFollowSet);

});
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件列表<span> &gt; </span>插件设置<span> &gt; </span>登录后引导关注</div>
    <div class="set-wrap">
        <div class="login-guide" id="panel">
<form name="form1" method="post" action="<?php echo URL('mgr/plugins.save', array('id'=> $id));?>">
<h4 class="main-title">自动关注设置</h4>
<div class="set-area-int">
	<div class="automatic">
	<p class="matic-yn">是否开启自动关注：</p>
	<p class="matic-yn">
    <label for="matic">
		<input id="matic" class="radio-same" name="auto_follow" type="radio" value="1"<?php echo $auto ? ' checked':'';?> />是
	</label>
	<span class="matic-yes" id="followList"<?php echo !$auto ? ' style="visibility:hidden;"':'';?>>
		自动关注的用户列表：
		<select name="autoFollowId">
		<?php foreach($list as $g) {
			if ($g['group_id'] == 3) {
				$selected = $g['group_id'] == $autoFollowId ? ' selected': '';
				echo '<option value="'.$g['group_id'].'"'.$selected.'>'.F('escape', $g['group_name']).'</option>';
			}
		}
		?>
		</select>
	</span>
    </p>
    <p>
	<label for="matic1">
		<input id="matic1" class="radio-same" name="auto_follow" type="radio" value="0"<?php echo !$auto ? ' checked':'';?>/>否
	</label>
    </p>
</div>
</div>
            <h4 class="main-title"><a href="#" class="add-category" rel="add"></a>登录后引导关注</h4>
			<div class="set-area-int">
        		<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table-border">
					<colgroup>
                        <col class="guide-list" />
    					<col />
    					<col class="operate-w2" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
   					  	<td>类别名称</td>
   					  	<td>类别使用的用户列表</td>
   					  	<td>操作</td>
				  	</tr>
              		</thead>
                	<tbody>
<?php 
	if (!empty($groups)):

	function getUserListName($list, $item_id) {

		foreach ($list as $g) {
			if ($g['group_id'] == $item_id) {
				return $g['group_name'];
			}
		}

		return false;
	}
?>

	<?php foreach($groups as $r):?>
                    <tr rel="<?php echo $r['id'],',', $r['item_id'], ',', F('escape', $r['item_name']);?>">
   					  	<td><?php echo F('escape', $r['item_name']);?></td>
   					  	<td><?php echo F('escape', getUserListName($list, $r['item_id']));?></td>
						<td><a class="change-icon" title="编辑" href="#" rel="edit">编辑</a><a class="del-icon" title="删除" href="#" rel="del">删除</a></td>
					</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="3" class="no-data">还没有记录哦，<a href="#" rel="add">请点击添加</a></td>
	</tr>
<?php endif;?>
					</tbody>
				</table>
    		</div>
			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<div class="button guide-btn"><input name="" type="submit" value="提交" /></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
