<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
<?php TPL::plugin('wap/include/top_logo', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => true), false); ?>
<?php TPL::plugin('wap/include/my_preview', $uInfo, false); ?>
<?php TPL::plugin('wap/include/msg_common', '', false); ?>
<div class="c">
我的私信 <a href="<?php echo WAP_URL('wbcom.sendMsgFrm'); ?>">发私信</a>
<div class="s"></div>
<?php if (!empty($list)): ?>
	<?php foreach ($list as $message): ?>
	<table>
    	<tbody>
        	<tr>
            	<td>
            	<?php if ($message['sender_id'] == USER::uid()): ?><a href="<?php echo WAP_URL('index'); ?>">我</a></a>发送给<a href="<?php echo WAP_URL('ta', 'id=' . $message['recipient_id']); ?>"><?php echo F('verified', $message['recipient']); ?></a><?php else: ?><a href="<?php echo WAP_URL('ta', 'id=' . $message['sender_id']); ?>"><?php echo F('verified', $message['sender']); endif; ?></a> <?php echo F('escape', $message['text'], ENT_QUOTES); ?> <?php echo F('format_time', $message['created_at']); ?><?php if ($message['sender_id'] != USER::uid()): ?> <a href="<?php echo WAP_URL('wbcom.sendMsgFrm', array('rid' => $message['sender_id'], 'rname' => $message['sender']['screen_name'])); ?>">回复<?php echo $message['sender']['gender'] == 'f' ? '她' : '他'; ?></a><?php endif; ?> <a href="<?php echo WAP_URL('wbcom.delMsgAlert', 'id=' . $message['id']); ?>">删除</a>
            	</td>
            </tr>
        </tbody>
    </table>
    <div class="s"></div>
	<?php endforeach; ?>
<?php else: ?>
	<?php if (V('g:page', 1) > 1):?>
	<p>已到最后一页</p>
	<?php else: ?>
	<p>您还没有收到评论</p>
	<?php endif; ?>
	<div class="s"></div>
<?php endif; ?>
</div>
<?php TPL::plugin('wap/include/pager', array('ctrl' => APP::getRuningRoute(false), 'list' => $list, 'page' => $page), false); ?>
<?php TPL::plugin('wap/include/search', '', false); ?>
<?php TPL::plugin('wap/include/nav', array('is_top' => false), false); ?>
<?php TPL::plugin('wap/include/foot', '', false); ?>
</body>
</html>