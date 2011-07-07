<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo F('web_page_title');?></title>
<link rel="shortcut icon" href="<?php echo W_BASE_URL;?>favicon.ico" />
<link href="<?php echo W_BASE_URL;?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo W_BASE_URL;?>css/<?php echo SKIN_CSS_PATH;?>/skin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/swfobject.js"></script>
<script type="text/javascript" >
<?php if (!empty($U)) { ?>
var _userInfo = <?php echo json_encode($U);?>;
<?php }else{ ?>
alert('无法获取用户信息');
<?php }?>
</script>
</head>
<body id="modify">
	<div id="wrapper">
    	<div class="wrapper-in">
            <!-- 头部 开始-->
            <?php TPL::plugin('include/header');?>
            <!-- 头部 介绍-->
            <div id="container" class="single">
                <div class="main userinfo">
                    <div class="form xform-normal">
                        <!-- 个人设置 开始-->
                        <?php TPL::plugin('include/user_setting');?>
                        <!-- 个人设置 结束-->
                        <!--修改头像 开始-->
                        <div id="picture" class="form-body modify-face">
                            <div class="form-info">
                                <p>请点击“浏览”按钮，选择你电脑中的图片作为微博头像</p>
                            </div>
                            <script type="text/javascript">
                            var imageSize = '<?php echo MAX_UPLOAD_FILE_SIZE;?>';
                            var flashvars={
                                        uidUrl:_userInfo.avatar,
                                        tmpUrl:_userInfo._uploadPicApi,
                                        imgUrl:_userInfo._savePicApi,
                                        imageSize:imageSize,
                                        _PHPSESSID:'<?php echo session_id();?>',
                                        _PHPSESSUID:_userInfo.sina_uid,
                                        uploadField:'avatarFile',
                                        jsFunc:"jsFun",
                                        background:"0xffffff"
                                        };
                            var params = {
                                        AllowScriptAccess:"always",
                                        wmode:"opaque"
                                        };
                            swfobject.embedSWF("<?php echo W_BASE_URL;?>flash/face.swf", "avatarSwf", "650", "450", "9.0.0", "<?php echo W_BASE_URL;?>flash/expressInstall.swf",flashvars,params);
                            function jsFun(returnCode){
                                var errText = '';
                                switch(+returnCode) {
                                    case 40012:
                                        errText = '你的图片文件超出'+imageSize+'M或宽高超出2880像素，请选择文件和尺寸较小的图片';
                                        break;
                                    case 40013:
                                        errText = '图片文件类型错误';
                                        break;
                                    case 40001:
                                    case 40002:
                                    case 40003:
                                    case 40050:
                                        errText = '保存头像出错';
                                        break;
                                    case 40010:
                                        errText = '损坏的图片文件（扩展名与图片类型不相符）';
                                        break;
                                    case 40051:
                                        // 开始上传
                                        Xwb.ui.MsgBox.getTipBox().autoHide = false;
                                        Xwb.ui.MsgBox.tipWarn('正在上传...');
                                        break;
                                    case 0:
                                        errText = '修改头像成功';
                                        Xwb.ui.MsgBox.success('', errText, function(){
                                            location.href = Xwb.request.mkUrl('index');
                                        });
                                        
                                        // 按不按确定都跳转
                                        setTimeout(function() {
                                            location.href = Xwb.request.mkUrl('index');
                                        },3000);
                                        return;
                                }
                                if(errText){
                                    Xwb.ui.MsgBox.getTipBox().display(false);
                                    Xwb.ui.MsgBox.alert('', errText);
                                }
                            }
                            </script>
                            <div id='avatarSwf'></div>
                        </div>
                        <!--修改头像 结束-->
                    </div>
                </div>
            </div>
            <!-- 底部 开始-->
            <?php TPL::plugin('include/footer');?>
            <!-- 底部 结束-->
        </div>
    </div>
</body>
</html>
