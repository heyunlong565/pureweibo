<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base target="_blank" />
	<title><?php echo F('escape', $unit_name);?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL;?>css/component/content_unit/base.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL;?>css/component/content_unit/skin.css" />
	<script src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/base/xwbapp.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/mod/xwbrequestapi.js"></script>
	<script src="<?php echo W_BASE_URL;?>js/mod/wbshowframe.js"></script>
	<script type="text/javascript">
	$(function(){
		var lock = false ;
		$('.follow').each(function(){
			$(this).click(function(){
					var uid = $(this).attr('rel');
					if( ! Xwb.cfg.uid ){ // 未登录...
						window.open( Xwb.request.mkUrl('ta', '', 'id='+uid) );
						return;
					}
					var self=$(this);
					if (lock) retuen;
					lock=true;
					Xwb.request.follow(uid, 0, function( ed ){
			        if( ed.isOk() || ed.getCode() == '1020805'){
			    				self.html('已关注');
			        }else {
			            if(ed.getCode() == '1020806'){
			                //如果该用户一天超过500次关注行为，弹窗提示
			               if(confirm('你今天已经关注了足够多的人，先去看看他们在说些什么吧？') == true ){
			                        window.open( Xwb.request.mkUrl('ta', '', 'id='+uid) );
			                };
			            }else alert(ed.getMsg());
			        }
			     lock=false;
			    });
			    return false;
			});
		});
	})
	</script>
</head>
<body>
<div id="showCt" class="weibo-follow <?php if ($skin):?>skin<?php echo $skin;?><?php endif;?>" style="height:<?php echo $height;?>px; <?php if ($width):?>width:<?php echo $width;?>px<?php endif;?>">
	<div id="showCtInner" class="<?php if ($show_border):?>weibo<?php else:?>weibo-noborder<?php endif;?>">
		<?php if ($show_title):?>
		<div class="weibo-title">
			<a href="#" class="title" title=""><?php echo F('escape', $unit_name);?></a>
		</div>
		<?php endif;?>
		<div class="weibo-main">
			<a href="#this" class="arrow-up arrow-icon" id="upSlider">
				<img id="arrowUp" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
			<div class="weibo-list">
				<ul>
					<?php if ($userlist):?>
					<?php foreach ($userlist as $item):?>
					<?php 
						$profile_image_url = isset($item['profile_image_url']) ? $item['profile_image_url'] : $item['uid']; 
					?>
					<li>
					<a class="user-pic" href="<?php echo $item['http_url'];?>" title="" target="_blank">
							<img src="<?php echo F('profile_image_url', $profile_image_url);?>" alt="" />
						</a>
						<p class="name"><a href="<?php echo $item['http_url'];?>" target="_blank"><?php echo F('escape', $item['nickname']);?></a></p>
						<?php
						
						if(USER::isUserLogin()):
						?>
							<?php
							if(in_array($item['uid'],$fids)):
							?>
							<span>已关注</span>
							<?php
							elseif(USER::uid()==$item['uid']):
							?>
							<span >我自己</span>
							<?php
							else:
							?>
							<a class="follow" href="javascript:;" rel='<?php echo $item["uid"];?>'>加关注</a>	
							<?php
							endif;
							?>
						<?php
						else:
						?>
						<a class="follow" href="javascript:;" rel='<?php echo $item["uid"];?>'>加关注</a>	
						<?php
						endif;
						?>
						
					</li>
					<?php endforeach;?>
					<?php else:?>
					<div>该用户列表没有数据，请到用户管理中添加用户。</div>
					<?php endif;?>
				</ul>
			</div>
			<a href="#this" class="arrow-down arrow-icon" id="downSlider">
				<img id="arrowDown" class="arrow-icon" height="4" width="8" src="<?php echo W_BASE_URL;?>css/component/content_unit/bgimg/transparent.gif" alt="arrow-up" />
			</a>
		</div>
		<?php if ($show_logo):?>
		<div class="xweibo">
			<a href="<?php echo W_BASE_HTTP . W_BASE_URL_PATH;?>" target="_blank">
				<img src="<?php echo F('get_logo_src','output');?>" alt="Xweibo"/>
			</a>
		</div>
		<?php endif;?>
	</div>
	<script type='text/javascript'>
		if(!window.Xwb)Xwb={};
		Xwb.cfg={	
			basePath :	'<?php echo W_BASE_URL;?>',
			uid: 		'<?php echo USER::uid(); /*sina uid*/?>'
		}
		Xwb.request.init(Xwb.cfg.basePath);
	</script>
</div>
</body>
</html>


