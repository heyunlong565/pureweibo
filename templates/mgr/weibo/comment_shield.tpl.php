<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论屏蔽 - 微博 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin/mgr.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script>
function confirmDisable(url, data) {

	Xwb.ui.MsgBox.confirm('提示','确认要屏蔽该评论吗?',function(id){ 
		if(id == "ok"){
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
	});

}
</script>
</head>
<body  class="main-body">
	<div class="path"><p>当前位置：内容管理<span>&gt;</span><a href="<?php echo URL('mgr/weibo/disableComment.commentList'); ?>">评论</a><span>&gt;</span>屏蔽评论列表</p></div>
    <div  class="main-cont">
        <h3 class="title">屏蔽指定评论</h3>
		<div class="set-area">
			<p class="tips-desc">请输入要屏蔽的评论所属微博详细页网址，此微博全部评论信息将显示在下方，即可对评论进行屏蔽。<a href="<?php echo URL('mgr/weibo/disableComment.commentList');?>">返回屏蔽评论列表</a></p>
			<div class="operate-cont">
            	<div class="form-s2">
				<form method="post" action="<?php echo URL('mgr/weibo/disableComment.search')?>" id="postForm">
            	<div class="item">
            		<label><strong>微博地址</strong></label>
                	<input name="url" class="ipt-txt form-el-w200" type="text" value="<?php echo V('r:url');?>" />
                    <a class="general-btn" href="#this" onclick="$('#postForm')[0].submit();"><span>搜索</span></a>
           		</div>
				</form>
                </div>
            </div>
			<?php if (V('r:url', false) !== false) {?>
            <table class="table" cellpadding="0" cellspacing="0" border="0" width="100%">
                <colgroup>
                    <col />
                    <col class="h-w150"/>
                    <col class="h-w150" />
                    <col class="h-w150" />
                </colgroup>
                <thead class="tb-tit-bg">
                <tr>
                    <th><div class="th-gap">评论内容</div></th>
                    <th><div class="th-gap">作者</div></th>
                    <th><div class="th-gap">发布时间</div></th>
                    <th><div class="th-gap">操作</div></th>
                </tr>
                </thead>
                <tfoot class="tb-tit-bg">
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
<a href="javascript:delConfirm('<?php echo URL('mgr/weibo/disableComment.resume', 'id=' . $row['id'] . '&type=2', 'admin.php');?>','确认要恢复该评论吗?')">恢复被屏蔽的评论</a>
                    <?php } else {?>
                        <a class="icon-shield" href="javascript:confirmDisable('<?php echo URL('mgr/weibo/disableComment.disable', 'id=' . $row['id'], 'admin.php');?>',{'id':'<?php echo $row['id'];?>','text':'<?php echo $row['text']?>','user':'<?php echo $row['user']['screen_name'];?>','created_at':'<?php echo date('Y-m-d H:i:s', strtotime($row['created_at']));?>'})">屏蔽该评论</a>
                    <?php }?>
                    
                    </td>
                </tr>
                <?php }} else {?>
                    <?php if (V('r:url','') !== '') {?>
                <tr><td colspan="4"><p class="no-data">该微博没有相关评论</p></td></tr>
                    <?php } else {?>
                <tr><td colspan="4"><p class="no-data">尚没有添加任何关键字</p></td></tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
            <?php }?>
        </div>
    </div>
</body>
</html>
