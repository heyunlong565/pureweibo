<?php 
	$headerModel 		= V('-:sysConfig/'.HEADER_MODEL_SYSCONFIG ); 
	$customHeader 		= 2;
	$interfaceHeader 	= 3; 
	if ( $customHeader==$headerModel ) 	// 输入页头Html模式
	{ 
		echo V('-:sysConfig/'.HEADER_HTMLCODE_SYSCONFIG );
	}
	else if ( $interfaceHeader==$headerModel ) 	// 接口调用页头
	{ 
		// for more
	}
	else {	// 默认页面
?>

<div id="header">
	<div class="hd-in">
		<h1 class="logo">
			<a href="<?php echo URL('pub');?>" title="Xweibo">
				<img src="<?php echo F('get_logo_src','web');?>" id="logo" alt="" />
			</a>
		</h1>
		<div class="hd-xad"></div>
	</div>
</div>



<?php }?>
