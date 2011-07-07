<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论屏蔽 - 微博管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
<script>
function confirmDisable(url, data) {
	if (!confirm('确认要屏蔽该评论吗?')) {
		return;
	}
	$.post(url, data,function(data) {
						try {
							if (data.rst) {
								window.location.href = '<?php echo URL('mgr/weibo/disableComment.commentList', '', 'admin.php')?>';
							} else {
								alert(data.err);
							}
						} catch (e) {
						
						}
					});
}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博管理<span> &gt; </span>评论屏蔽</div>
    <div class="set-wrap">
        <h4 class="main-title">屏蔽指定评论</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请输入要屏蔽的评论所属微博详细页网址，此微博全部评论信息将显示在下方，即可对评论进行屏蔽。<a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>">返回屏蔽评论列表</a></p>
				<form method="post" action="<?php echo URL('mgr/weibo/disableComment.search')?>">
            	<div class="serch-user">
            		<span><strong>微博地址：</strong></span>
                	<input name="url" class="input-box box-address-width" type="text" value="<?php echo V('g:url');?>" />
					<span class="serch-btn"><input name="" type="submit" value="搜索" /></span>
           		</div>
				</form>
				<?php if (V('r:url', false) !== false) {?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border shi-position">
					<colgroup>
    					<col />
    					<col class="nikename"/>
                        <col class="s-time" />
    					<col class="operate-w9" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
   					  	<td>评论内容</td>
   					  	<td>作者</td>
   					  	<td>发布时间</td>
   					  	<td>操作</td>
				  	</tr>
              		</thead>
              		<tfoot class="tfoot-bg">
					<tr>
						<td colspan="4">
                        <div class="pre-next">
						<?php if (isset($pager)) {echo $pager;}?>
						<!--
                        	<form name="form" id="form"><div style="float:left;">
                            	<a class="pre" href="">上一页</a><a class="next" href="">下一页</a></div>
						    	<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
						      		<option>1/2</option>
                              		<option>2/2</option>
					        	</select>
				        	</form>
						-->
                        </div>
                        </td>
					</tr>
              		</tfoot>
                	<tbody>
					<?php $d = F('get_filter_cache', 'comment'); ?>
					<?php if (isset($info) && is_array($info) && !empty($info)) {foreach ($info as $row) {?>
                    <tr>
   					  	<td><?php echo htmlspecialchars($row['text']);?></td>
   					  	<td><?php echo htmlspecialchars($row['user']['screen_name']);?></td>
   					  	<td><?php echo  date('Y-m-d H:i:s', strtotime($row['created_at']));?></td>
						<td class="opration">
						<?php if (isset($d[(string)$row['id']])) {?>
<a href="javascript:confirmDel('<?php echo URL('mgr/weibo/disableComment.resume', 'id=' . $row['id'] . '&type=2', 'admin.php');?>','确认要恢复该评论吗?')">恢复被屏蔽的评论</a>
						<?php } else {?>
							<a href="javascript:confirmDisable('<?php echo URL('mgr/weibo/disableComment.disable', 'id=' . $row['id'], 'admin.php');?>',{'id':'<?php echo $row['id'];?>','text':'<?php echo $row['text']?>','user':'<?php echo $row['user']['screen_name'];?>','created_at':'<?php echo date('Y-m-d H:i:s', strtotime($row['created_at']));?>'})">屏蔽该评论</a>
						<?php }?>
						</td>
					</tr>
					<?php }} else {?>
					<tr><td colspan="4" class="no-data">没有搜索到数据</td></tr>
					<?php }?>
					</tbody>
				</table>
				<?php }?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
