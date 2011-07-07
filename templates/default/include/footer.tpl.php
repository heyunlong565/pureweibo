<script type='text/javascript'>
if(!window.Xwb)Xwb={};
Xwb.cfg={	basePath :	'<?php echo W_BASE_URL;?>',
			routeMode:  <?php echo R_MODE;?>,
			routeVname: '<?php echo R_GET_VAR_NAME;?>',
			loginCfg : 	<?php echo V('-:sysConfig/login_way', 1);?>,
			
			wbList: 	<?php echo json_encode(APP::getData('json', 'WBDATA',array()));?>, 
	
			authenCfg:	'<?php echo V("-:sysConfig/authen_enable"); /*用户认证方式 1.使用站点特定的认证 0.使用新浪名人认证*/?>',

			authenTit:	'<?php echo addslashes(V("-:sysConfig/authen_small_icon_title")); /*站点认证小图标提示文字*/?>',

			webName:	'<?php echo addslashes(V("-:sysConfig/site_name")); /*本站名*/?>',

			uid: 		'<?php echo USER::uid(); /*sina uid*/?>', 

			siteUid:	'<?php echo USER::get('site_uid'); /*第三方UID*/?>',

			siteUname:	'<?php echo addslashes(USER::get('site_uname')); /* 第三方用户名 */?>',

			siteName:	'<?php echo addslashes(USER::get('site_name')); /* 第三方站点名 */?>',

			siteReg:	'<?php echo V('-:siteInfo/reg_url'); /* 第三方注册链接 */?>',
			remind: <?php /*新评论等提醒方式*/ echo V('-:userConfig/user_newfeed')?1:0;?>,
			maxid: '<?php echo APP::getData('maxid', 'WBDATA', '');?>',
			page: '<?php /*当前所在的页*/ $page = APP::getData('page', 'WBDATA'); echo !empty($page) ? $page: APP::getRequestRoute();?>',
			akey: '<?php /*appkey 上报用*/ echo WB_AKEY;?>'
};
</script>
<div id="footer">
<?php
	$pl = DS('Plugins.get', 'g1/86400', 1);

	$ad_footer = $pl['in_use'] ? V('-:sysConfig/ad_footer','') : false;

	if ($ad_footer) :
?>
<div class="xad"><?php echo $ad_footer;?></div>
<?php endif; ?>
	<div class="footer-defined">
		<em class="site-name"><?php echo V('-:sysConfig/site_name');?>
		<?php 
		if (V('-:sysConfig/site_record',false)){
		?>
		<a target="_blank" href="http://www.miibeian.gov.cn/ ">备案号：<?php echo V('-:sysConfig/site_record');?></a>
		<?php
		}
		?>
		</em>
		<?php
			$foot = "";
			$foot = json_decode(V('-:sysConfig/foot_link'),true);
			if($foot){
				$count = count($foot);
				$i = 1;
				foreach($foot as $value){ ?>
					<a target="_blank" href="<?php echo $value['link_address'];?>" target="_blank"><?php echo $value['link_name'];?></a>
					<?php if($i < $count) echo '|'; $i++;}?>
		<?php }?>		
	</div>
	<span>Powered By <a href="http://x.weibo.com/" target="_blank">Xweibo</a> 1.1</span> <span>Running On <a href="http://sae.sina.com.cn" target="_blank"><img src="http://sae.sina.com.cn/static/image/poweredby/117X12px.gif" title="Powered by Sina App Engine" /></a></span>
</div>
<?php
// 同步登录状态到附属站点  
$site_uid		= USER::get('site_uid');
$loginScript	= USER::get('syncLoginScript');
//var_dump(array($site_uid, $loginScript));
if ( $site_uid && $loginScript){
	$accAdapter = APP::ADP('account');
	$syncLogoutScript = $site_uid ? $accAdapter->syncLogin($site_uid) : '';
	//echo F('escape', $syncLogoutScript);
	if (!empty($syncLogoutScript)){
		echo $syncLogoutScript;
	}
	USER::set('syncLoginScript',0);
}

/// 第三方统计代码
if (V('-:sysConfig/third_code')){
	echo '<span class="hidden">'.V('-:sysConfig/third_code').'</span>';
}
?>
