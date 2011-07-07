<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title', false, V('g:skinset', false)? '模板设置' : false);?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
    
</head>
<body id="home" class="own">
	<!-- skin -->
    <?php 
		if(trim(V('g:skinset')) == 1) {
			TPL::plugin('include/user_skin');
		}
	?>
    <!-- end skin -->
	<div id="wrapper">
    	<div class="wrapper-in">
    <!-- header -->
    <?php TPL::plugin('include/header');?>
    <!-- end header -->
        <div id="container">
        	<div class="sidebar">
				<?php TPL::plugin('include/user_preview');?> 
                <?php TPL::plugin('include/user_menu');?>    
				<!-- 标签 -->
				<?php TPL::plugin('include/user_tag');?>    
				<!-- end 标签 -->

				<?php
					foreach ($side_modules as $mod) {
						TPL::plugin('include/component_' . $mod['component_id'], array('mod' => $mod));
					}
				?>

            </div>
            <div class="main">
            	<?php TPL::plugin('include/input');?>
				<?php if (empty($list)):?>
					<!-- 初始化页面 -->
					<div class="index-default">
					<?php if (V('g:page', 1) > 1):?>
						<div class="default-tips">
							<div class="icon-tips all-bg"></div>
							<p>已到最后一页</p>
						</div>
					<?php else:?>
						<div class="default-tips">
							<div class="icon-tips all-bg"></div>
							<p>您还没有微博信息。</p>
							<p>想看更多微博？<br />你可以<a href="<?php echo URL('search.recommend');?>">关注更多的人</a>，或者在<a href="javascript:$('#publish_box textarea').focus(),void(0);">上方输入框</a>里，说说身边的新鲜事儿。</p>
						</div>
						<div class="hot-user">
							<h4>名人推荐</h4>
							<ul id="userlist">
								<?php 
									$toplist = DS('components/star.get', 300);
								?>
								<?php if ($toplist):?>
								<?php foreach ($toplist as $item):?>
								<li rel="u:<?php echo $item['uid'];?>">
									<div class="user-pic"><a href="<?php  echo URL('ta',array('id' => $item['uid']));?>"><img src="<?php echo APP::F('profile_image_url', $item['uid']);?>" alt="" title="<?php echo htmlspecialchars($item['nickname']);?>" /></a></div>
									<div class="hot-r"><a href="<?php  echo URL('ta',array('id' => $item['uid']));?>"><?php echo htmlspecialchars($item['nickname']);?></a><br /><a href="#" rel="e:fl,t:2" name="follow">关注他</a></div>
								</li>
								<?php endforeach;?>
								<?php endif;?>
							</ul>
							<div class="btn-area"><a class="general-btn" href="javascript:;" id="followall-btn"><span>全部关注</span></a></div>
						</div>
						<?php endif;?>
					</div>
					<!-- end 初始化页面 -->
				<?php
					else:
						//聚焦位
						$fc = DS('Plugins.get', 'g1/86400', 2);

						// 手动关闭后有cookie['fc_ad']
						if ($fc['in_use'] && !isset($_COOKIE['fc_ad'])) {
							$ct = DS('dsIndexFocus.get', 0);
				?> 
				<div style="background: url(<?php echo F('fix_url', ($ct['bg_pic']? $ct['bg_pic']: 'var/data/index/ad_pic.jpg'));?>) no-repeat scroll 0% 0% transparent;" class="ad-pic" id="focus_index">
					<div class="ad-pic-con">
						<h3><?php echo F('escape', $ct['title']);?></h3>
						<p><?php echo F('escape', $ct['text']);?></p>
					</div>
					<a title="点击关闭" href="#" rel="e:cls,cn:fc_ad" class="icon-close-btn icon-bg"></a>
					<a class="ad-pic-btn" rel="e:do,op:<?php echo $ct['oper'];?>,tp:<?php echo $ct['topic'];?>,ln:<?php echo urlencode($ct['link']);?>" href="#"><?php echo F('escape', $ct['btnTitle']);?></a>
				</div>
				<?php
						};
				?>
				<div class="feed-list" id="xwb_weibo_list">
					<a class="new-feed" href="<?php echo URL('index');?>" id="new_wb_tips" style="display:none;">有新微博，点击查看</a>
					<div class="feed-tit">
							<h3>我的首页</h3>
					</div> 
					<!-- 微博列表 -->
					<?php
						TPL::plugin('include/feedlist', array('list' => $list));
					?>
					<!-- end 微博列表 -->
					<!-- 分页 -->	
					<?php TPL::plugin('include/page', array('list' => $list, 'limit' => $limit));?>
					<!-- end 分页 -->
				</div>
				<?php endif;?>
            </div>
        </div>
        <!-- footer -->
		<?php TPL::plugin('include/footer');?>
        <!-- end footer -->
<?php if (empty($list)):?>
<script type="text/javascript">
//批量关注
$('#followall-btn').click(function(e){ 
	var $list = $('#userlist>li');

	if (!$list.length)
	{
		return;
	}

	var ids = [];
	
	$list.each(function(i, ele) {
		var id = $(ele).attr('rel').split(':')[1]
		ids.push(id);
	});
	
	Xwb.request.follows(ids.join(','), 0, function(e){ 
		if (e.isOk())
		{
			$list.find('a[name=follow]').replaceWith('<em>已关注</em>');
			var mb = Xwb.use('msgbox');
			mb.tipOk('关注成功！');
		}
	});
});
</script>
<?php elseif ($fc['in_use']):?>
<script type="text/javascript">
$('#focus_index').each(function(){
	Xwb.use('indexFocus', {view: this}).getView();
});
</script>
<?php endif;?>
	</div>
</div>
    
</body>
</html> 
<!-- report -->
<img src="<?php echo F('report');?>" class="hidden"/>
