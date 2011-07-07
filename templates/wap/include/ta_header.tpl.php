<div class="u-intro">
		<table>
			<tr>
				<td class="u-img" valign="top"><img src="<?php echo APP::F('profile_image_url', $userinfo['profile_image_url'], 'index')?>" alt="" /></td>
				<td>
					<div><?php echo F('verified', $userinfo)?>
					
					&nbsp;
					<?php
					if($userinfo['gender']=='m'):
					?>
					男
					<?php
					else:
					?>
					女
					<?php
					endif;
					?>
					/<?php
					echo $userinfo['location']
					?>
					
					</div>
					<div><?php
					$des = F('escape',$userinfo['description']);
					echo mb_strlen($des) > 20 ? mb_substr($des,0,20,'utf8')."..." : $des;
					?></div>
					<div>
						<a href="<?php echo WAP_URL('ta.profile',"id={$userinfo['id']}&name={$userinfo['screen_name']}")?>">详细资料</a>
						<?php
						    if(USER::isUserLogin()) {
								$fids = DR('xweibo/xwb.getFriendIds', 'p', USER::uid(), null, null, -1, 5000);
								$fids = $fids['rst']['ids'];
								//var_dump($fids);
							    }
							    else {
								$fids=array();
							    }
						?>
						
						<?php
						$genderChar=($userinfo['gender']=='m'?'他':'她');
						if(in_array($userinfo['id'],$fids)):
						?>
						<a href="<?php echo WAP_URL('wbcom.cancelFollowAlert','id='.$userinfo['id'])?>">取消关注</a>
						<?php
						elseif($userinfo['id']==USER::uid()):
						?>
						我自己
						<?php
						else:
						?>
						<a href="<?php echo WAP_URL('wbcom.addFollow','id='.$userinfo['id'])?>">关注<?php echo $genderChar?></a>                
						<?php
						endif;
						?>
						
					</div>
				</td>
			</tr>
		</table>
	</div>
        <div class='c'>
		<?php
		if(V('g:m')=='ta'):
		?>
		<span>微博[<?php echo $userinfo['statuses_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta',"id={$userinfo['id']}&name={$userinfo['screen_name']}")?>">微博[<?php echo $userinfo['statuses_count']?>]</a>
		<?php
		endif;
		?>
		
		
		
		<?php
		if(V('g:m')=='ta.follow'):
		?>
		<span>关注[<?php echo $userinfo['friends_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.follow',"id={$userinfo['id']}")?>">关注[<?php echo $userinfo['friends_count']?>]</a>
		<?php
		endif;
		?>
		

		<?php
		if(V('g:m')=='ta.fans'):
		?>
		<span>粉丝[<?php echo $userinfo['followers_count']?>]</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.fans',"id={$userinfo['id']}")?>">粉丝[<?php echo $userinfo['followers_count']?>]</a>
		<?php
		endif;
		?>
		
		
		<?php
		if(V('g:m')=='ta.mention'):
		?>
		<span>@<?php echo $genderChar;?>的</span>
		<?php
		else:
		?>
		<a href="<?php echo WAP_URL('ta.mention',"k=".urlencode($userinfo['screen_name']))?>">@<?php echo $genderChar;?>的</a>
		<?php
		endif;
		?>
		
		
		
		
		
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	