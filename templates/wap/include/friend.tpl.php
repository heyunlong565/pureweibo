 <table>
    	<tbody>
        	<tr>
                    <?php
		    
		    
                    //$ta_href=V('s:PHP_SELF','wap.php')."?m=ta&id={$id}";
		    if($userinfo['id']==USER::uid()) {
		     $ta_href=WAP_URL('index');
		    }
		    else {
		     $ta_href=WAP_URL('ta',"id={$userinfo['id']}");
		    }
            
            
		    
                    ?>
            	<td><a href="<?php echo $ta_href;?>"><img src="<?php echo $userinfo['face'];?>" alt="userName" /></a></td>
                <td><a href="<?php echo $ta_href;?>"><?php echo F('verified', $userinfo)?></a><br />粉丝<?php echo $userinfo['followers_count']?>人<br />
                <?php
                $genderChar=($userinfo['gender']=='m'?'他':'她');
                ?>
                
                <?php
		//var_dump($fids['ids']);
                if(in_array($userinfo['id'],$fids)):
                ?>
		
                已关注
		
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
                </td>
            </tr>
        </tbody>
    </table>
   
