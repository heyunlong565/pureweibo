<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论屏蔽 - 微博管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script>
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td > input[type=checkbox]');
			});

function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td > input[type=checkbox]');
	if (!v) {
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/disableComment.resume', 'id=', 'admin.php');?>' + v;
	confirmDel(url, '确认要恢复所有选中的评论吗?');
}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博管理<span> &gt; </span>评论屏蔽</div>
    <div class="set-wrap">
        <h4 class="main-title">屏蔽评论列表</h4>
		<div class="set-area-int">
			<div class="user-list-box1">
				<p class="serch-tips">请通过关键字查找已经被屏蔽的评论，然后采取相应的操作。您也可以直接<a href="<?php echo URL('mgr/weibo/disableComment.search');?>">屏蔽指定的评论</a>。</p>
				<form method="post" action="<?php echo URL('mgr/weibo/disableComment.commentList');?>">
            	<div class="serch-user">
            		<span><strong>搜索包含以下关键字的评论：</strong></span>
                	<input name="keyword" class="input-box box-address-width" type="text" value="<?php echo V('r:keyword');?>" />
                	<span class="serch-btn"><input type="submit" value="搜索" /></span>
           		</div>
				</form>
			</div>
			<div class="user-list">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
            		<colgroup>
						<col class="checkbox-tab"/>
                        <col class="serial-number" />
    					<col />
    					<col class="common-w1"/>
    					<col class="s-time"/>
                        <col class="s-time" />
    					<col class="user-name" />
    					<col class="operate-w7" />
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
    						<td></td>
                            <td>编号</td>
    						<td>评论内容</td>
    						<td>作者</td>
                    		<td>发布时间</td>
                            <td>屏蔽时间</td>
                    		<td>操作者</td>
    						<td>操作</td>
  						</tr>
                	</thead>
                	<tfoot class="tfoot-bg">
                    	<tr>
                    		<td colspan="8">
                            	<div class="pre-next">
								<?php if (is_array($list) && !empty($list)) { ?>
								<?php if (isset($pager)) {echo $pager;}?>
								<?php }?>
								</div>
                            	<input class="select-all" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                                <a href="javascript:delSelectedConfirm()">恢复所选的评论</a></td>
                   		</tr>
                    </tfoot>
                    <tbody id="recordList">
					<?php if (is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
  						<tr>
    						<td><input name="1" type="checkbox" value="<?php echo $row['kw_id'];?>" /></td>
    						<td><?php echo $offset + $key + 1;?></td>
                            <td><?php echo htmlspecialchars($row['comment']);?></td>
    						<td><?php echo htmlspecialchars($row['user']);?></td>
                            <td><?php echo $row['publish_time'];?></td>
    						<td><?php echo date('Y-m-d H:i:s', $row['add_time']);?></td>
                            <td><?php echo htmlspecialchars($row['admin_name']);?></td>
    						<td><a href="javascript:confirmDel('<?php echo URL('mgr/weibo/disableComment.resume', 'id=' . $row['kw_id'], 'admin.php');?>','确认要恢复该评论吗?')">取消屏蔽</a></td>
                        </tr>
					<?php }} else {?>
						<tr><td colspan="8" class="no-data">尚没有任何被屏蔽项</td></tr>
					<?php }?>
                    </tbody>
                </table>
				
            </div>
        </div>       
    </div>
</div>
</body>
</html>
