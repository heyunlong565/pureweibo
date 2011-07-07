<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题推荐管理 - 微博管理 - 运营管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script src="<?php echo W_BASE_URL;?>js/mgr.js"></script>
</head>
<script>
function openPop(url) {
	var p = {
		'url': url,
		'onsubmit' : function (o, w) {
						if (o.topic_name.value == '') {
							$('#nameTip').text('不能为空').removeClass('hidden');
							return false;
						}
						return true;
					}
		}
	var popWin = new popWindow(p);
	popWin.open();
};
</script>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：运营管理<span> &gt; </span>微博管理<span> &gt; </span>话题推荐管理</div>
    <div class="set-wrap">
    <h4 class="main-title"><a class="add-topic-list" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.addCategory');?>');"></a>可用的话题列表</h4>
		<div class="set-area-int">
            <div class="user-list">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border">
					<colgroup>
						<col class="serial-number"/>
                        <col />
    					<col class="rec-topic" />
    					<col class="operate-w11" />
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
					<?php if (!empty($data) && is_array($data)) foreach($data as $key => $item) {?>
				  	<tr>
   					  	<td><?php echo ++$key;?></td>
   					  	<td><?php echo htmlspecialchars($item['topic_name']);?></td>
   					  	<td><?php echo $item['native'] == 1 ? '内置':'自定义';?></td>
   					  	<!--<td><?php echo implode(',', $item['apps']);?></td>-->
						<td>
							<a class="view-topic" href="<?php echo URL('mgr/weibo/todayTopic.topicList','category=' . $item['topic_id'], 'admin.php');?>">查看话题</a>
<!--
							<a class="change-icon" href="javascript:openPop('<?php echo URL('mgr/weibo/todayTopic.addCategory','id=' . $item['topic_id'], 'admin.php');?>');">编辑</a>
-->
							<?php if ($item['native'] != 1) {?>
							<a class="del-icon" href="<?php echo URL('mgr/weibo/todayTopic.delCategory', 'id=' . $item['topic_id'], 'admin.php');?>">删除</a>
							<?php }?>
						</td>
					</tr>
					<?php } else {?>
					<tr><td colspan="5">尚没有数据</td></tr>
					<?php }?>
					</tbody>
				</table>
            </div>
        </div>   
    </div>
</div>
<div id="pop_window" class="pop-float  fixed-pop hidden"></div>
<div id="pop_mask" class="mask hidden"></div>
</body>
</html>
