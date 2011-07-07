<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微博屏蔽 - 微博 - 运营管理</title>
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
		alert('最少选中其中一项');
		return;
	}
	var url = '<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=', 'admin.php');?>' + v;
	delConfirm(url, '确认要恢复所有选中的关键字吗?');
}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博<span> &gt; </span>微博屏蔽</div>
    <div class="set-wrap">

        <h4 class="main-title">屏蔽微博列表</h4>
		<div class="set-area-int">
        	<div class="user-list-box1">
				<p class="serch-tips">请通过关键字查找已经被屏蔽的微博，然后采取相应的操作。您也可以直接<a href="<?php echo URL('mgr/weibo/disableWeibo.search');?>">屏蔽指定的微博</a>。</p>
				<form method="post" action="<?php echo URL('mgr/weibo/disableWeibo.weiboList');?>">
            	<div class="serch-user">
            		<span><strong>搜索包含以下关键字的微博：</strong></span>
                	<input name="keyword" class="input-box box-address-width" type="text" value="<?php echo V('r:keyword');?>" />
                	<span class="serch-btn"><input type="submit" value="搜索" /></span>
           		</div>
				</form>
			</div>

			<div class="user-list">
            	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
            		<colgroup>
						<col class="checkbox-tab" />
                        <col class="operate-w12" />
    					<col />
    					<col class="operate-w9" />
                        <col class="operate-w9" />
    					<col class="operate-w9" />
    					<col class="operate-w9" />
    				</colgroup>
                    <thead class="td-title-bg">
  						<tr>
    						<th><div class="td-inside"></div></th>
                            <th><div class="td-inside">编号</div></th>
    						<th><div class="td-inside">微博内容</div></th>
    						<th><div class="td-inside">作者</div></th>
                            <th><div class="td-inside">屏蔽时间</div></th>
                    		<th><div class="td-inside">操作者</div></th>
    						<th><div class="td-inside">操作</div></th>
  						</tr>
                	</thead>
                	<tfoot class="tfoot-bg">
                    	<tr>
                    		<td colspan="7">
							
                            	<div class="pre-next">
								<?php if (is_array($list) && !empty($list)) { ?>
								<?php echo $pager;?>
								<?php }?>	
								</div>
                            	<input class="select-all" name="slectALL" id="selectAll" type="checkbox" value="" />全选
                                <a href="javascript:delSelectedConfirm()">恢复所选的微博</a>
								</td>
                   		</tr>
                    </tfoot>
					<tbody id="recordList">
					<?php if (is_array($list) && !empty($list)) {foreach ($list as $key => $row) {?>
  						<tr>
    						<td><input name="1" type="checkbox" value="<?php echo $row['kw_id']?>" /></td>
    						<td><?php echo $offset + $key + 1;?></td>
                            <td><?php echo htmlspecialchars($row['comment'])?></td>
    						<td><?php echo htmlspecialchars($row['user']);?></td>
    						<td><?php echo date('Y-m-d H:i:s', $row['add_time']);?></td>
                            <td><?php echo htmlspecialchars($row['admin_name']);?></td>
    						<td><a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableWeibo.resume', 'id=' . $row['kw_id'], 'admin.php');?>','确认要恢复该微博吗');">取消屏蔽</a></td>
                        </tr>
					<?php }} else {?>
						<tr><td colspan="7"><p class="no-data">搜索不到任何数据</p></td></tr>
					<?php }?>
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
</div>
</body>
</html>
