<?php
/*
 * 外部引入的相关参数
$param = array('title' => $title, //发布框上边的标题，默认是 '有什么新鲜事告诉大家？'
					'show_face'=>true, //是否显示表情按钮，默认是ture，显示，false不显示
					'show_upload_pic' => true, //是否显示上传图片按钮，默认是true，显示，false不显示 
					'show_video'=>true,//是否显示视频按钮，默认是true，显示，false不显示
					'show_music'=>true，//是否显示音乐按钮，默认是true，显示，false不显示
					'show_trends'=>true，//是否显示话题按钮，默认是true，显示，false不显示
					);
*/
?>
<div class="post-box" id="publish_box">
	<?php
	//var_dump($_SERVER);
	$title = isset($title) ? $title : '有什么新鲜事告诉大家？';
	$show_face = isset($show_face) ? $show_face : true;
	$show_upload_pic = isset($show_upload_pic) ? $show_upload_pic : true;
	$show_video = isset($show_video) ? $show_video : true;
	$show_music = isset($show_music) ? $show_music : true;
	$show_trends = isset($show_trends) ? $show_trends : true;
	$trends = isset($trends) ? '#'.$trends.'#' : '';
	?>
	<div class="post-title"><?php echo $title;?></div>
    <div class="key-tips" id="xwb_word_cal">您还可以输入<span>140</span>字</div>
	<div class="post-textarea" id="focusEl"><div class="inner"><textarea id="xwb_inputor"><?php echo $trends;?></textarea></div></div>
    <div class="add-area">
		<?php if ($show_face):?>
        <a class="icon-face icon-bg" href="#" rel="e:ic">表情</a>
		<?php endif;?>
		<?php if ($show_upload_pic):?>
        <span class="pic_uploading hidden" id="xwb_upload_tip">正在上传..</span>
        <span class="pic-name hidden" id="xwb_photo_name"><a class="icon-close-btn icon-bg" href="#" ></a></span>
        <div class="share-upload-pic" id="uploadBtn">
            <form class="upload-pic"  method="post"  enctype="multipart/form-data" id="xwb_post_form" action="" target="" id="xwb_imgupload_form">
                <input type="file" name="pic" id="xwb_img_file" value="" />
            </form>
            <a class="icon-pic icon-bg" href="#" id="xwb_btn_img">图片</a>
        </div>
        
		<?php endif;?>
		<?php if ($show_video):?>
        <a class="icon-video icon-bg" href="#" id="xwb_btn_vd" rel="e:vd">视频</a>
		<?php endif;?>
		<?php if ($show_music):?>
        <a class="icon-music icon-bg" href="#" id="xwb_btn_ms" rel="e:ms">音乐</a>
		<?php endif;?>
		<?php if ($show_trends):?>
        <a class="icon-topic icon-bg" href="#" id="xwb_btn_tp" rel="e:tp">话题</a>
		<?php endif;?>
    </div>
    <div class="share-btn <?php if (!USER::isUserLogin()){?>share-btn-disable<?php }?>" rel="e:sd"></div>
    <div class="post-success all-bg hidden" id="xwb_succ_mask"></div>
	<div class="account-notbind load-fail icon-bg <?php if (USER::isUserLogin()){?>hidden<?php }?>">您需要绑定新浪微博帐号后才可以发布，<a href="<?php echo URL('account.login','loginCallBack='.W_BASE_HTTP.URL(APP::getRequestRoute()))?>">现在就去绑定</a></div>
</div>
