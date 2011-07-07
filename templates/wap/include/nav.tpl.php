<?php
//当前路由
$router = APP::getRuningRoute(true);
$is_top = isset($is_top) ? (bool)$is_top : true;

if (USER::isUserLogin()) {
	$notices = F('sysnotice.getCount');
	
	$ur = DR('xweibo/xwb.getUnread', 'p');
	$ur = $ur['rst'];
	$msgCount = (int)($ur['dm'] + $ur['mentions'] + $ur['comments'] + $notices);
}
?>
<div class="nav"><?php if (USER::isUserLogin()): ?><?php if (in_array($router['class'], array('pub', 'ta', 'celeb'))): ?><a href="<?php echo WAP_URL('index'); ?>">我的首页</a>|<a href="<?php echo WAP_URL('pub')?>">广场</a>|<a href="<?php echo WAP_URL('celeb')?>">名人</a>|<a href="<?php echo WAP_URL('pub.topics')?>">话题</a>|<?php else: ?><a href="<?php echo WAP_URL('index'); ?>">我的首页</a>|<a href="<?php echo WAP_URL('index.messages'); ?>">信息<?php echo $msgCount ? '<span class="r">[' . $msgCount . ']</span>' : ''; ?></a>|<a href="<?php echo WAP_URL('pub')?>">广场</a>|<a href="<?php echo WAP_URL('index.setinfo', 'type=2'); ?>">设置</a>|<?php endif; ?><?php if ($is_top): ?><a href="<?php echo WAP_URL('search')?>">搜索</a><?php else: ?><a href="<?php echo WAP_URL('account.logout'); ?>">退出</a><?php endif; ?><?php else: ?><a href="<?php echo WAP_URL('account.showLogin')?>">登录</a>|<a href="<?php echo WAP_URL('pub')?>">广场</a>|<a href="<?php echo WAP_URL('celeb')?>">名人</a>|<a href="<?php echo WAP_URL('pub.topics')?>">话题</a><?php endif; ?></div>