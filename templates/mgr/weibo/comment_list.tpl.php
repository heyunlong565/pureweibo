<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论屏蔽 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
$(function() {
			bindSelectAll('#selectAll','#recordList > tr > td input[type=checkbox]');
			});

function delSelectedConfirm() {
	var v = getSelectedValues('#recordList > tr > td input[type=checkbox]');
	if (!v) {
		Xwb.ui.MsgBox.alert('提示','最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/disableComment.resume', 'id=', 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的评论吗?');
}
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span>评论</p></div>
    <div  class="main-cont">
        <h3 class="title">屏蔽评论列表</h3>
		<div class="set-area">
			<p class="tips-desc">您也可以直接<a href="<?php echo URL('mgr/weibo/disableComment.search');?>">屏蔽指定的评论</a>。</p>
<!--
			<div class="operate-cont">
            	<div class="form-s2">
                    <form method="post" action="<?php echo URL('mgr/weibo/disableComment.commentList');?>" id="postForm">
                    <div class="item">
                        <label><strong>搜索包含以下关键字的评论</strong></label>
                        <input name="keyword" class="ipt-txt form-el-w200" type="text" value="<?php echo V('r:keyword');?>" />
                        <a class="general-btn" href="#this" onclick="$('#postForm')[0].submit();"><span>搜索</span></a>
                    </div>
                    </form>
                </div>
			</div>
			-->
            <table class="table" cellpadding="0" cellspacing="0" width="100%" border="0">
                <colgroup>
                    <col class="h-w50"/>
                    <col class="h-w60" />
                    <col />
                    <col class="h-w90"/>
                    <col class="h-w140"/>
                    <col class="h-w140" />
                    <col class="h-w90" />
                    <col class="h-w90" />
                </colgroup>
                <thead class="tb-tit-bg">
                    <tr>
                        <th><div class="th-gap"></div></th>
                        <th><div class="th-gap">编号</div></th>
                        <th><div class="th-gap">评论内容</div></th>
                        <th><div class="th-gap">作者</div></th>
                        <th><div class="th-gap">发布时间</div></th>
                        <th><div class="th-gap">屏蔽时间</div></th>
                        <th><div class="th-gap">操作者</div></th>
                        <th><div class="th-gap">操作</div></th>
                    </tr>
                </thead>
                <tfoot class="tb-tit-bg">
                    <tr>
                        <td colspan="8">
                            <div class="pre-next">
                            <?php if (is_array($list) && !empty($list)) { ?>
                            <?php if (isset($pager)) {echo $pager;}?>
                            <?php }?>
                            </div>
                            <input class="ipt-checkbox" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                            <a href="javascript:delSelectedConfirm()">恢复所选的评论</a>
                        </td>
                            
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
                        <td><a class="icon-unshield" href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableComment.resume', 'id=' . $row['kw_id'], 'admin.php');?>','确认要恢复该评论吗?')">取消屏蔽</a></td>
                    </tr>
                <?php }} else {?>
                    <tr><td colspan="8"><p class="no-data">尚没有任何被屏蔽项</p></td></tr>
                <?php }?>
                </tbody>
            </table>
        </div>       
    </div>
</body>
</html>
