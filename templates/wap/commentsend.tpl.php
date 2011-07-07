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
<?php TPL::plugin('wap/include/my_preview', '', false); ?>
<?php TPL::plugin('wap/include/msg_common', '', false); ?>
<div class="c">
<a href="<?php echo WAP_URL('index.messages', 'type=2&ctype=1'); ?>">收到的评论</a> 发出的评论
<div class="s"></div>
<?php if (!empty($list)): ?>
	<?php foreach ($list as $comment): ?>
	<table>
    	<tbody>
        	<tr>
            	<td>
            	<?php if ($comment['status']['user']['id'] != USER::uid()): ?><a href="<?php echo WAP_URL('ta', 'id=' . $comment['status']['user']['id']); ?>"><?php echo F('verified', $comment['status']['user']); ?></a><?php else: ?>我<?php endif; ?>的微博:<?php echo F('escape', mb_strlen($comment['status']['text'], 'utf-8') > 15 ? mb_substr($comment['status']['text'], 0, 15, 'utf-8') . '...' : $comment['status']['text']); ?><br />
            	<?php if (isset($comment['reply_comment']) && !empty($comment['reply_comment'])): ?>
            	--<?php if ($comment['reply_comment']['user']['id'] == USER::uid()): ?>我<?php else: ?><a href="<?php echo WAP_URL('ta', 'id=' . $comment['reply_comment']['user']['id']); ?>"><?php echo F('verified', $comment['reply_comment']['user']); ?></a><?php endif; ?>: <?php echo F('escape', $comment['reply_comment']['text']); ?><br />
            	<?php endif; ?>
            	--<a href="<?php echo WAP_URL('index.profile'); ?>">我</a>: <?php echo F('format_text', $comment['text']); ?> <?php echo F('format_time', $comment['created_at']); ?> <a href="<?php echo WAP_URL('wbcom.delCommentAlert', 'cid=' . $comment['id']); ?>">删除</a>
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
