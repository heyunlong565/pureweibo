<div class="user-total-box">
    <div class="first">
	<p><a id="xwb_user_total_follow" class="user-total <?php if (strlen($uInfo['friends_count']) >= 7):?>longnumber<?php endif;?>" href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.follow');?><?php else:?><?php echo URL('ta.follow', 'id='.$uInfo['id']);?><?php endif;?>"><?php echo $uInfo['friends_count'];?></a></p>
	<a href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.follow');?><?php else:?><?php echo URL('ta.follow', 'id='.$uInfo['id']);?><?php endif;?>">关注</a>
    </div>
    <div>
	<p><a id="xwb_user_total_fans" class="user-total <?php if (strlen($uInfo['followers_count']) >= 7):?>longnumber<?php endif;?>" href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.fans');?><?php else:?><?php echo URL('ta.fans', 'id='.$uInfo['id']);?><?php endif;?>"><?php echo $uInfo['followers_count'];?></a></p>
	<a href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.fans');?><?php else:?><?php echo URL('ta.fans', 'id='.$uInfo['id']);?><?php endif;?>">粉丝</a>
    </div>
    <div>
	<p><a id="xwb_user_total_wb" class="user-total <?php if (strlen($uInfo['statuses_count']) >= 7):?>longnumber<?php endif;?>" href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.profile');?><?php else:?><?php echo URL('ta.profile', 'id='.$uInfo['id']);?><?php endif;?>"><?php echo $uInfo['statuses_count'];?></a></p>
	<a href="<?php if (USER::uid() == $uInfo['id']):?><?php echo URL('index.profile');?><?php else:?><?php echo URL('ta.profile', 'id='.$uInfo['id']);?><?php endif;?>">微博</a>
    </div>
</div>
