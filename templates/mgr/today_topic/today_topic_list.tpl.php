<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题推荐管理 - 微博管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script>
function openPop(url) {
	var p = {
		'url': url,
		'onsubmit' : function (o, w) {
						if (o.topic.value == '') {
							alert('话题不能为空');
							return false;
						}
						return true;
					}
		}
	var popWin = new popWindow(p);
	popWin.open();
};
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td > div > input[type=checkbox]');
			});
function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td > div > input[type=checkbox]');
	if (!v) {
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/todayTopic.delete', 'id=', 'admin.php');?>' + v;
	confirmDel(url, '确认要恢复所有选中的关键字吗?');
}
<?php
if ($category['sort'] == '1') {
	// 允许排序
	echo 'var sort_allow = true;';
}
?>

</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博管理<span> &gt; </span><?php echo $category['topic_name']?>管理</div>
    <div class="set-wrap">
        <h4 class="main-title">
			<a class="add-new-topic" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'topic_id=' . V('g:category'));?>');"></a>
<?php if ($category['sort']): ?>
			<a class="change-order" href="#" id="modifyBtn"></a>
			<a class="save-order hidden" href="#" id="saveBtn"></a>
<?php endif;?>
			<?php echo $category['topic_name']?>
		</h4>
		<div class="set-area-int">
            <div class="user-list" id="userList">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border" id="tblZoom">
            		<colgroup>
						<col class="checkbox-tab" />
                        <col class="serial-number" />
    					<col />
    					<col class="t-time" />
    					<col class="operate-w2" />
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
                        	<td></td>
    						<td>编号</td>
    						<td>话题内容</td>
                    		<td><?php if (V('g:category') == '1') {?>添加<?php } else {?>生效<?php }?>时间</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tfoot class="tfoot-bg">
                    	<tr>
                    		<td colspan="5">
                            	<div class="pre-next">
									<?php echo isset($pager)?$pager:'';?>
								</div>
                            	<input class="select-all" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                                <a class="del-all" href="javascript:delSelectedConfirm()">将所选话题从列表中删除</a>
							</td>
                   		</tr>
                    </tfoot>
                	<tbody class="order-main" id="recordList">
					<?php if (!empty($list) && is_array($list)) { foreach($list as $key => $row) {?>
  						<tr rel="<?php echo $offset + $row['id'];?>">
    						<td>
								<span class="range-icon"></span>
								<div class="default"><input name="1" type="checkbox" value="<?php echo $row['id'];?>" /></div>
							</td>
                            <td><?php echo $offset + $key +1;?></td>
    						<td><?php echo htmlspecialchars($row['topic']);?></td>
    						<td><?php echo date('Y-m-d H:i:s', $row[V('g:category') == '1' ?'date_time':'ext1']);?></td>
    						<td>
								<a class="change-icon" title="编辑" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'id=' . $row['id']);?>')">编辑</a>
								<a class="del-icon" title="删除" href="javascript:confirmDel('<?php echo URL('mgr/weibo/todayTopic.delete', 'id=' . $row['id']);?>')">删除</a></td>
  						</tr>
					<?php  }} else {?>
						<tr><td colspan="5" class="no-data">尚没有数据，请<a href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.edit', 'topic_id=' . V('g:category'));?>');">添加新话题</a></td></tr>
					<?php }?>
                	</tbody>
				</table>
            </div>
        </div>
    </div>
</div>
<div class="pop-float fixed-pop" id="pop_window"></div>
<div id="pop_mask" class="mask hidden"></div>
<script type="text/javascript">

<?php if ($category['sort']): ?>
var zoom = new OrderRowZoom($('#tblZoom')[0], {
        url:'<?php echo URL('mgr/weibo/todayTopic.saveOrder', array('lid' => $category['topic_id']));?>',
        modifyBtn : '#modifyBtn',
        saveBtn   : '#saveBtn',
        paramName : 'ids'
    });
<?php endif;?>
</script>

</body>
</html>
