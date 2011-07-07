<div class="tab-s3">
<span class="person-current"><a href="<?php echo URL('setting.user');?>">个人资料</a></span>
<span class="modify-current"><a href="<?php echo URL('setting.myface');?>">修改头像</a></span>
<span class="display-current"><a href="<?php echo URL('setting.show');?>">显示设置</a></span>
<span class="blacklist-current"><a href="<?php echo URL('setting.blacklist');?>">黑名单</a></span>
<span class="warn-current"><a href="<?php echo URL('setting.notice');?>">提醒设置</a></span>
<?php if ( USER::uid() && (V('-:sysConfig/login_way', 1)!=1) && USER::get('site_uid')) { ?>
<span class="account-current"><a href="<?php echo URL('setting.account');?>">帐号设置</a></span>
<?php }?>
</div>
