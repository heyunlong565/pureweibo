<?php 
if(!defined('IN_APPLICATION')){
	exit('ACCESS DENIED!');
}
?>

<div id="header">
	<div class="nav">
    	<div class="inner-nav" id="xwbInnerNav">
			<?php
				$header = "";
				$header = json_decode(V('-:sysConfig/head_link'),true);
				if($header){
					$count = count($header);
					$i = 1;
			?>
        	<span class="defined-link">
			<?php foreach($header as $value){ ?>
				<a target="_blank" href="<?php echo $value['link_address'];?>"><?php echo $value['link_name'];?></a>
				<?php if($i < $count) echo '|'; $i++;}?>
			</span>
			<?php }?>
        	<div class="nav-right">
            	<form class="search-box skin-bg" onsubmit="return false" id="xwb_search_form">
                	<input class="search-btn skin-bg" type="submit" value="" id="xwb_trig"/>
                    <input class="search-input"  type="text" value="搜微博/找人"  id="xwb_inputor"/>
                </form>
				<span class="user-link">
			<?php
				$uid = User::uid();

				$plugins = DS('Plugins.get','',5);
				if ($uid) {
			?>
                <a href="<?php echo URL('index');?>"><?php echo F('escape', USER::get('screen_name'));?></a>
                <a href="<?php echo URL('setting');?>">设置</a>
                <a href="<?php echo URL('index','skinset=1');?>">换肤</a>|
				<?php if ($plugins['in_use']) {?>
				<a href="#" onclick="Xwb.use('feedback').display(true);return false;">用户反馈</a>|
				<?php }?>
                <?php
				if (USER::get('isAdminAccount')){
					echo '<a class="manage" href="'.W_BASE_URL_PATH.'admin.php"  target="_blank">管理中心</a>|';
				}
				?>
                <a href="<?php echo URL('account.logout');?>">退出</a>
                
			<?php
				} else {
			?>
				<?php if ($plugins['in_use']) {?>
				<a href="#" onclick="Xwb.use('feedback').display(true);return false;">用户反馈</a>
				<?php }?>
				<?php
				   if (V('-:sysConfig/login_way', 1)!=1 && USER::get('site_uid')){
				?>
				<a href="<?php echo URL('account.bind', '');?>" rel="e:lg">绑定SINA微博</a>
				<a href="<?php echo URL('account.logout');?>">退出</a>
				<?php
				   }else{
				?>
				 
				<a href="<?php echo URL('account.login');?>" rel="e:lg">登录</a>
			<?php
				   }
				}
			?>
			</span>
            </div>
        </div>
        <div class="nav-bg"></div>
    </div>

    <!-- <div class="xad"><?php //echo $ad_header;?></div> -->

    <div class="inner-header">
    	<a class="logo" href="<?php echo URL('pub');?>">
				<img src="<?php echo F('get_logo_src','web');?>" id="logo" alt="" />
    	</a>
    	
        <div class="menu">
        	<ul  class="main-menu">
        	<?php 
        		$pageList = DR('PageModule.getPagelistByType');
				$navList  = DR('Nav.getNavList', FALSE, TRUE);
				$is_first = true;
				foreach ($navList as $id => $aNav)
				{
					if (!isset($aNav['data']) || $aNav['data']['in_use'] != '1') {continue;}
					$pageId  = $aNav['data']['page_id'];
					if ($pageId == '-1') {
						$pageUrl = $aNav['data']['url'];					
					} else {
						$p = array(
							'page_id' =>$pageId,
							'nav_id' => $aNav['data']['id']
						);
						$pageUrl = isset($pageList[$pageId]['url']) ? URL($pageList[$pageId]['url'], $p) : '#';
					}
					//$target  = $aNav['data']['is_blank'] ? ' target="_blank" ' : '';
					if (1 == $id) {	// 微博广场  ?>
						<li class="menu-pub <?php echo $is_first?'class="menu-first"':''; if (V('g:nav_id')==$aNav['data']['id']) { echo ' menu-custom';}?>"><a hideFocus="true" <?php echo $target; ?> href="<?php echo $pageUrl;?>"><?php echo $aNav['data']['name']; ?></a>
					
					<?php } elseif (2 == $id) { // 名人堂 ?>
						<li class="menu-user <?php echo $is_first?'class="menu-first"':''; if (V('g:nav_id')==$aNav['data']['id']) { echo ' menu-custom';}?>"><a hideFocus="true" <?php echo $target; ?> href="<?php echo $pageUrl;?>"><?php echo $aNav['data']['name']; ?></a>
					
					<?php } elseif (3 == $id) { // 我的首页  ?>
						<li class="menu-home <?php echo $is_first?'class="menu-first"':'';if (V('g:nav_id')==$aNav['data']['id']) { echo ' menu-custom';}?>"><a hideFocus="true" <?php echo $target; ?> href="<?php echo $pageUrl; ?>"><?php echo $aNav['data']['name']; ?></a>
					
					<?php } elseif (4 == $id) { // 我的微博  ?>
						<li class="menu-weibo <?php echo $is_first?'menu-first':'';if (V('g:nav_id')==$aNav['data']['id']) { echo ' menu-custom';}?>"><a hideFocus="true"  <?php echo $target; ?> href="<?php echo $pageUrl;?>"><?php echo $aNav['data']['name']; ?></a>
					<?php } else { ?>
						<li  class="<?php echo $is_first?'menu-first':'';if (V('g:nav_id')==$aNav['data']['id']) { echo ' menu-custom';}?>"><a  hideFocus="true" href="<?php echo $pageUrl; ?>" ><?php echo $aNav['data']['name']; ?></a>
					<?php }?>
					<?php
					if (isset($aNav['son']) && is_array($aNav['son'])) {
						?>
						<ul class="sub-pubmenu hidden">
						<?php
						foreach ($aNav['son'] as $row) {
							if (!isset($row['data']) || $row['data']['in_use'] != '1') {continue;}
							$pid = $row['data']['page_id'];
							$uri = array();
								//if (isset($pageList[$pid]) && $pageList[$pid]['native'] == '0') {
									$uri = array(
											'page_id' => $pid,
											'navId' => $row['data']['id']
											);
								//}
								if ($pid == '-1') {
									$sonUrl = $row['data']['url'];
								} else {
									$sonUrl 	= isset($pageList[$pid]['url']) ? URL($pageList[$pid]['url'], $uri) : '#';
								}
								//$target  	= $row['data']['is_blank'] ? ' target="_blank" ' : '';
								if($aNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH)){
										$target='_blank';	
									}
								else{
									$target='';
								}
								$selected = $row['data']['id'] == V('g:navId')?' cur-custom':'';
								echo "<li><a href='$sonUrl' $target class='cur-common $selected'>{$row['data']['name']}</a></li>";
						}
						?>
						</ul>
						<span class="sub-arrow"></span>
						<?php
					}

						$is_first = false;
					?>
						</li><!-- 公用闭合LI -->
			<?php } ?>
<!--            	<li><a hideFocus="true" class="menu-pub" href="<?php echo URL('pub');?>">微博广场</a></li>-->
<!--                <li><a hideFocus="true" class="menu-user" href="<?php echo URL('search.recommend');?>">名人堂</a></li>-->
<!--                <li><a hideFocus="true" class="menu-home" href="<?php echo URL('index');?>">我的首页</a></li>-->
<!--                <li><a hideFocus="true" class="menu-weibo" href="<?php echo URL('index.profile');?>">我的微博</a></li>-->
            </ul>
			<div class="menu-bg">
                <span class="r-bg"></span>
                <span class="l-bg"></span>
            </div>
        </div>

    </div>
</div>
<?php if ($plugins['in_use']) {?>
<!-- 用户反馈 -->
<div class="win-pop win-feedback win-fixed hidden" id="feedbackBox">
	<div class="win-t"><div></div></div>
	<div class="win-con">
		<div class="win-con-in">
			<h4 class="win-tit x-bg">用户反馈</h4>
			<div class="win-box">
				<div class="win-box-inner">
					<form id="fbForm" method="post" action="<?php echo URL('feedback.save');?>">
						<p>有意见？有想法？那就来吧！</p>
						<div class="feedback-box">
							<div class="user-info">
								<img src="<?php echo USER::isUserLogin() ? F('profile_image_url', USER::uid(),'index') : W_BASE_URL. 'css/default/bgimg/icon_guest.png';?>" alt="" />
								<p><?php echo  USER::isUserLogin() ? USER::get('screen_name'):'匿名';?></p>
							</div>
							<div class="fill-textarea">
								<textarea class="style-normal" name="content" warntip="#feedbackTip" vrel="ne=m:请输入意见内容"></textarea>
							</div>
						</div>
						<div class="feedback-box">
							<div class="input-title"><span>联系方式：</span></div>
							<div class="input-area">
								<div class="input-field"><input type="text" vrel="_ft|ft|mail" warntip="#feedbackTip" class="input-define style-normal" name="mail" value="邮箱地址"/></div>
								<div class="input-field"><input type="text" warntip="#feedbackTip" class="input-define style-normal" vrel="_ft|ft|int|radio" name="qq" value="QQ" /></div>
								<p>请留下您的联系方式，方便我们及时反馈信息给您</p>
								<div class="btn-area">
									<a class="general-btn" href="#" id="trig"><span>提交</span></a>
								</div>
                                <span class="tips-wrong hidden" id="feedbackTip">请输入意见内容</span>
								<input type="submit" class="hidden" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="win-con-bg"></div>
	</div>
	<div class="win-b"><div></div></div>
	<a class="icon-close-btn icon-bg" href="#" id="xwb_cls" title="关闭"></a>
</div>
<?php }?>
