<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/xwbapi.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/xwb.min.js"></script>
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
                    <input class="search-input"  type="text" value="搜索微博/找人"  id="xwb_inputor"/>
                </form>
				<span class="user-link">
			<?php
				$uid = User::uid();
				if ($uid) {
			?>
                <a href="<?php echo URL('index');?>"><?php echo F('escape', USER::get('screen_name'));?></a>
                <a href="<?php echo URL('setting');?>">设置</a>
                <a href="<?php echo URL('index','skinset=1');?>">模板</a>|
                <?php
				if (USER::get('isAdminAccount')){
					echo '<a href="'.W_BASE_URL_PATH.'admin.php"  target="_blank">管理中心</a>';
				}
				?>
                <a href="<?php echo URL('account.logout');?>">退出</a>
                
			<?php
				} else {
			?>
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
    	<a class="logo" href="<?php echo URL('pub');?>"><?php 
    			if (V('-:sysConfig/logo',false)){
    				//echo   W_BASE_URL_PATH;
					echo '<img id="logo" src="'.F('fix_url', V('-:sysConfig/logo')).'"/>';
				}else{
					echo '<img id="logo" src="'.W_BASE_URL_PATH.WB_LOGO_DEFAULT_NAME.'"/>';
				}
    		?></a>

        <div class="menu">
        	<ul>
            	<li><a hideFocus="true" class="menu-pub" href="<?php echo URL('pub');?>">微博广场</a></li>
                <li><a hideFocus="true" class="menu-user" href="<?php echo URL('search.recommend');?>">名人堂</a></li>
                <li><a hideFocus="true" class="menu-home" href="<?php echo URL('index');?>">我的首页</a></li>
                <li><a hideFocus="true" class="menu-weibo" href="<?php echo URL('index.profile');?>">我的微博</a></li>
            </ul>
            <div class="menu-bg skin-bg"></div>
            <div class="menu-arrow skin-bg"></div>
        </div>

    </div>
</div>
