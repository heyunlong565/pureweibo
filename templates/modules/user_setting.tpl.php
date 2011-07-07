<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/mod/mysetting.js"></script>
<div class="tab-s3">
<?php if (HAS_DIRECT_UPDATE_PROFILE):?>
<span class="person-current"><span><a href="<?php echo URL('setting.user');?>">个人资料</a></span></span>
<?php else:?>
<span class="person-current"><span><a href="<?php echo URL('setting.tag');?>">个人资料</a></span></span>
<?php endif;?>
<span class="modify-current"><span><a href="<?php echo URL('setting.myface');?>">修改头像</a></span></span>
<span class="display-current"><span><a href="<?php echo URL('setting.show');?>">显示设置</a></span></span>
<span class="blacklist-current"><span><a href="<?php echo URL('setting.blacklist');?>">黑名单</a></span></span>
<span class="warn-current"><span><a href="<?php echo URL('setting.notice');?>">提醒设置</a></span></span>
<?php if ( USER::uid() && (V('-:sysConfig/login_way', 1)!=1) && USER::get('site_uid')) { ?>
<span class="account-current"><span><a href="<?php echo URL('setting.account');?>">帐号设置</a></span></span>
<?php }?>
<?php if ( USED_PERSON_DOMAIN ) { ?>
<span class="host-current"><span><a href="<?php echo URL('setting.domain');?>">个性域名</a></span></span>
<?php }?>
</div>
