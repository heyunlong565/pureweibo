<div class="site-nav">
	<div class="nav-bd">
		
	<?php 
		// 定义二级导航的逻辑
		function sonNavHtm(&$sonNavList, &$pageList)
		{
			echo '<ul>';
			foreach ($sonNavList as $aSonNav) 
			{
				if (!isset($aSonNav['data']) ||$aSonNav['data']['in_use'] != '1') continue;
				$sonPageId  = $aSonNav['data']['page_id'];
				//$uri = array();
				//if (isset($pageList[$sonPageId]) && $pageList[$sonPageId]['native'] == '0') {
					$uri = array(
						'page_id' => $sonPageId,
						'navId' => $aSonNav['data']['id']
						);
				//}
				if ($sonPageId == -1) {
					$sonUrl = $aSonNav['data']['url'];
				} else {
					$sonUrl 	= isset($pageList[$sonPageId]['url']) ? URL($pageList[$sonPageId]['url'], $uri) : '#';
				}
				//var_dump($aSonNav['data']['is_blank']);
				//$target  	= $aSonNav['data']['is_blank'] ? ' target="_blank" ' : '';
				//var_dump(strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH));
				//var_dump($aSonNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH));
				if($aSonNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH)){
					$target='target="_blank"';	
				}
				else{
					$target='';
				}
				//var_dump($target);
				$selected = $aSonNav['data']['id'] == V('g:navId')?' cur':'';
				echo "<li><a href='$sonUrl' $target class='cur-common $selected'>{$aSonNav['data']['name']}</a></li>";
			}
			echo '</ul>';
		}
		
		
		$pageList = DR('PageModule.getPagelistByType');
		$navList  = DR('Nav.getNavList', FALSE, TRUE);
		$first = true;
		foreach ($navList as $id => $aNav)
		{
			if (!isset($aNav['data']) || $aNav['data']['in_use'] != '1') continue;
			$selected = $aNav['data']['id'] == V('g:navId')?' cur':'';
			echo '<div class="nav-block' . ($first?' first':''). '">';
			$first = false;
			$pageId  = $aNav['data']['page_id'];
			if ($pageId == '-1') {
				$pageUrl = $aNav['data']['url'];
				if (strpos($pageUrl, 'http://') === false) {
					$pageUrl = 'http://' . $pageUrl;
				}
			} else {
				$p = array('page_id' => $pageId, 'navId' => $aNav['data']['id']);
				$pageUrl = isset($pageList[$pageId]['url']) ? URL($pageList[$pageId]['url'], $p) : '#';
			}
			//$target  = $aNav['data']['is_blank'] ? ' target="_blank" ' : '';
			//var_dump($aNav['data']['page_id']	);
			if($aNav['data']['page_id']==-1&&!strpos($aSonNav['data']['url'],W_BASE_HTTP . W_BASE_URL_PATH)){
					$target='_blank';	
				}
			else{
				$target='';
			}
			if (20 == $id) {	// 微博广场  ?>
				<h3><a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class="<?php echo $selected;?>"><s></s><?php echo $aNav['data']['name']; ?></a></h3>
			
			<?php } elseif (23 == $id) { // 名人堂 ?>
				<h3><a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class="<?php echo $selected;?>"><s></s><?php echo $aNav['data']['name']; ?></a></h3>
			
			<?php } elseif (21 == $id) { // 我的首页  ?>
				<h3>
					<a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class="<?php echo $selected;?>"><s></s><?php echo $aNav['data']['name']; ?></a>
					<a href="<?php echo URL('index')?>" class="square hidden" id="newWb"><span><span id="t">10</span></span></a>
				</h3>
				<ul>
					<li>
						<a href="<?php echo URL('index.profile');?>" class="<?php echo APP::getRequestRoute() == 'index.profile'?' cur':''?>">我的微博</a>
					</li>
					<li>
						<a href="<?php echo URL('index.atme');?>" class="<?php echo APP::getRequestRoute() == 'index.atme'?' cur':''?>">提到我的</a>
						<a href="<?php echo URL('index.atme');?>" class="square hidden" id="referMe"><span><span id="t">8</span></span></a>
					</li>
					<li>
						<a href="<?php echo URL('index.comments');?>" class="<?php echo APP::getRequestRoute() == 'index.comments'?' cur':''?>">我的评论</a>
						<a href="<?php echo URL('index.comments');?>" class="square hidden" id="myCmt"><span><span id="t">99+</span></span></a>
					</li>
					<li>
						<a href="<?php echo URL('index.messages');?>" class="<?php echo APP::getRequestRoute() == 'index.messages'?' cur':''?>">我的私信</a>
						<a href="<?php echo URL('index.messages');?>" class="square hidden" id="myMsg"><span><span id="t">88</span></span></a>
					</li>
					<li>
						<a href="<?php echo URL('index.notices');?>" class="<?php echo APP::getRequestRoute() == 'index.notices'?' cur':''?>">我的通知</a>
						<a href="<?php echo URL('index.notices');?>" class="square hidden" id="myNotice"><span><span id="t">10</span></span></a>
					</li>
					<li><a href="<?php echo URL('index.favorites');?>" class="<?php echo APP::getRequestRoute() == 'index.favorites'?' cur':''?>">我的收藏</a></li>
				</ul>
			<?php } else { // 其它定义的  ?>
				<h3><a href="<?php echo $pageUrl; ?>" <?php echo $target;?> class=" <?php echo $selected;?>"><s></s><?php echo $aNav['data']['name']; ?></a></h3>
					
			<?php } 
			if (isset($aNav['son'])) { // 二级导航
					sonNavHtm($aNav['son'], $pageList); 
				} 
			echo '</div>';
		} ?>
			
		<div class="nav-block">
			<form class="search-box skin-bg" onsubmit="return false" id="xwb_search_form">
				<input class="search-btn skin-bg" type="submit" value="" id="xwb_trig"/>
				<input class="search-input"  type="text" value="搜微博/找人"  id="xwb_inputor"/>
			</form>
		</div>
		<div class="nav-block last">
			<?php if (USER::isUserLogin()): ?>
			<a href="<?php echo URL('index','skinset=1');?>" class="person<?php echo APP::getRequestRoute() == 'index' && V('g:skinset')?' cur':''?>">换肤</a>
			<a href="<?php echo URL('setting');?>" class="person<?php echo APP::getRequestRoute() == 'setting'?' cur':''?>">设置</a>
			<?php endif; ?>
			<?php
			$plugins = DS('Plugins.get','',5);
			if ($plugins['in_use']) {
			?>
			<a href="#" onclick="Xwb.use('feedback').display(true);return false;">意见反馈</a>
			<?php }?>
			<?php
				if (USER::get('isAdminAccount')){
					echo '<a href="'.W_BASE_URL_PATH.'admin.php" class="manage" target="_blank">管理中心</a>';
				}
			?>
			<?php if (USER::isUserLogin() || USER::get('site_uid') ): ?>
			<a href="<?php echo URL('account.logout');?>">退出</a>
			<?php endif; ?>
		</div>
				
	</div>
</div>
<?php if ($plugins['in_use']) { ?>
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
