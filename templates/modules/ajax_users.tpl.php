<ul>
<?php
$uid = USER::uid();
if ($uid) {
	$ids = DR('xweibo/xwb.getFriendIds', '', $uid, null, null, -1, 5000);
	$ids = $ids['rst']['ids'];
} else {
	$ids = array();
}
for ($i=0, $count=count($users); $i< $count; $i+=2) {?>
	<li>
	<?php for ($j=0; $j<2; $j++) {?>
		<?php 
		if (!isset($users[$i+$j])) break;
		$item = $users[$i+$j];
		$row = array (
				'id' => $item['uid'],
				'profile_image_url' => F('profile_image_url', $item['uid']),
				'screen_name' => $item['nickname'],
				'description' => $item['remark'],
				'following' => in_array($item['uid'], $ids) ? true : false
				);

?>
                                    <div class="famous<?php if ($j==1) {echo ' famous-r';}?>" rel="u:<?php echo $row['id'];?>">
                                    
                                    	<div class="user-pic">
                                            <input type="checkbox" rel="e:ck"/><a href="<?php echo URL('ta', 'id=' . $row['id'] . '&name='. urlencode($row['screen_name']));?>"><img src="<?php echo $row['profile_image_url']?>" alt="<?php echo htmlspecialchars($row['screen_name']);?>的头像" /></a>
                                        </div>
                                        <div class="btn-box">
											<?php if ($row['id'] != $uid) {?>
											<?php if ($row['following']) {?>
												<span class="followed-btn">已关注</span>
											<?php } else {?>
												<a class="addfollow-btn"  rel="e:fl,t:1" href="#">加关注</a></li>
											<?php }?>
											<?php }?>
										</div>
                                        <div class="u-box">
                                        	<a class="u-name" href="<?php echo URL('ta', 'id=' . $row['id'] . '&name=' . urlencode($row['screen_name']));?>#"><?php echo htmlspecialchars($row['screen_name']);?></a>
											<?php echo F('verified', $row);?>
                                            <div class="u-info"><?php echo htmlspecialchars($row['description']);?></div>
                                        </div>
                                        
                                    </div>
	
                                <?php }?>   
								</li>
<?php }?>
</ul>
