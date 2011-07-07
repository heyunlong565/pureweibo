<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo F('web_page_title');?></title>
	<link rel="stylesheet" href="<?php echo W_BASE_URL;?>css/wap/base.css" type="text/css" />
</head>
<body <?php F('wap_font_set'); ?>>
	<?php
	TPL::plugin('wap/include/top_logo','',false);
	TPL::plugin('wap/include/nav', array('is_top' => true), false);
	?>
	
	<div class="ta">
    	<form method='post' id='search_box' action="<?php echo WAP_URL('search');?>">
        <div class="g">输入关键字：</div>
		<input type="hidden" name='<?php echo WAP_SESSION_NAME;?>' value='<?php echo V('r:'.WAP_SESSION_NAME) ?>'/>
        <input type="text" name='k' value="<?php echo  htmlspecialchars(V('r:k','')) ;?>" /><br />
	    <input type="hidden" name='m' value='search'/>
        <input type="submit" name='search_sina' value="搜索本站及新浪微博"/>
	    <input type="submit" name='search_app' value="搜索本站" />
        </form>
    </div>
	<?php
	if(V('r:k',null)):
	?>
	<?php
		$m=V('g:m');
	?>
<div class="row">
<?php
	if($m=='search'):
?>
<span>全部</span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search','k='.V('r:k')."&base_app=".$base_app)?>">全部</a>&nbsp;
<?php
endif;
?>

<?php
if($m=='search.user'):
?>
<span>用户</span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search.user','k='.V('r:k')."&base_app=".$base_app)?>">用户</a>&nbsp;
<?php
endif;
?>

<?php
if($m=='search.weibo'):
?>
<span>微博</span>&nbsp;
<?php
	else:
?>
<a href="<?php echo WAP_URL('search.weibo','k='.V('r:k')."&base_app=".$base_app)?>">微博</a>&nbsp;
<?php
endif;
?>
</div>

<?php
if($m=='search'||$m=='search.user'):
?>
   
    <div class="g row">找到的用户如下：</div>
    <?php
    if(empty($users)) {
	if(V('g:page')>1) {
		echo '<div class="c">返回上一页</div>';
	}
	else {
		echo '<div class="c">没有符合条件的用户，请输入其他关键字再试 </div>';	
	}
	
    }
    else {
	TPL::plugin('wap/include/friendList',array('list'=>$users),false); 
    }
       
    ?>

<?php
endif;
?>    
    
<?php
if($m=='search'||$m=='search.weibo'):
?>

    
    <div class="g row">找到的微博如下：</div>
    <?php
    if(empty($list)) {
	if(V('g:page')>1) {
		echo '<div class="c" 无其他结果,<a href="'.URL('search',"k=".V('g:k')."&&base_app=".V('g:base_app')).'">返回第一页</a></div>';
		
	}
	else {	
		echo '<div class="c">没有符合条件的微博，请输入其他关键字再试 </div>';
	}
    }
    else {
	TPL::plugin('wap/include/feedlist', array("list"=>$list), false);
    }
	
?>
<?php
endif;
?>

<div class="pages">
<?php
TPL::plugin('wap/include/pager', array('ctrl' => V('g:m'),'query'=>array('base_app'=>isset($base_app)?$base_app:0,'k'=>V('r:k')), 'list' => isset($list)?$list:$users, 'page' => V('g:page',1)), false); 
?>
</div>

<?php
endif;
?>

<?php
	TPL::plugin('wap/include/nav', array('is_top' => false), false);
	TPL::plugin('wap/include/foot',"",false);
?>

</body>
</html>
