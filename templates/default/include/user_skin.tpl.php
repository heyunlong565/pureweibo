<?php
	$rs = "";
	$all_skin_list = $skin_list = $sort_list = array();
	//DD('mgr/skinCom.getSkinById');DD('mgr/skinCom.getSkinSortById');

	$rs = DS('mgr/skinCom.getSkinById', 86400);
	if(isset($rs)) {
		foreach($rs as $value) {
			if($value['state']) {
				continue;
			}

			$skin_list[$value['style_id']][$value['skin_id']] = $value;
			if($value['skin_id'] == V('-:sysConfig/skin_default', 0)) {
				array_unshift($all_skin_list, $value);
			}elseif($value['directory'] == SITE_SKIN_CSS_PRE.SITE_SKIN_TPL_DIR){
				array_unshift($all_skin_list, $value);
			}else{
				$all_skin_list[] = $value;
			}

		}
	}
//var_dump(V('-:sysConfig/skin_default'));exit;
	$rs = DS('mgr/skinCom.getSkinSortById', 86400);
	if(isset($rs)) {
		foreach($rs as $value) {
			$sort_list[$value['style_id']] = $value;
		}
	}
?>
<div class="set-skin" id="xwbSkinSet">
    <div class="tab-s5">
                <div class="tab-s5-in" id="tabItems">
					<span class="current"><a href="#" hideFocus="true">全部模板</a></span>
					<?php if(isset($sort_list)):?>
						<?php foreach($sort_list as $key=>$value):?>
							<?php if(isset($skin_list[$key])):?><span><a href="#" hideFocus="true"><?php echo $value['style_name'];?></a></span><?php endif;?>
						<?php endforeach;?>
					<?php endif;?>
                    <div class="btn-area">
                        <a href="#" class="general-btn highlight" rel="e:sv"><span>保存</span></a>
                        <a href="#" class="general-btn" rel="e:cc"><span>取消</span></a>
                    </div>
                </div>
     </div>
         <div class="set-skin-in" id="tabPanels">
              <div class="skin-list">
				<?php if(isset($all_skin_list)):?>
    			   <?php foreach($all_skin_list as $value):?>
    					<?php if($value['skin_id'] == SKIN_ID):?>
    			            <a class="current" href="#" rel="e:cs,id:<?php echo $value['skin_id'];?>,sk:<?php echo $value['directory'];?>"><img src="<?php echo  W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" alt="" /><span><em><?php echo $value['name'];?></em></span></a>
    					<?php else:?>
    						<a href="#" rel="e:cs,id:<?php echo $value['skin_id'];?>,sk:<?php echo $value['directory'];?>"><img src="<?php echo  W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" alt="" /><span><em><?php echo $value['name'];?></em></span></a>
    					<?php endif;?>
    			   <?php endforeach;?>
				<?php endif;?>
             </div>

		<?php if(isset($skin_list)):?>
    	    <?php foreach($skin_list as $key=>$style):if($skin_list[$key] && $key){ ?>
    			<div class="skin-list hidden">
    		   <?php foreach($style as $value):?>
    				<?php if($value['skin_id'] == SKIN_ID):?>
    						<a class="current" href="#" rel="e:cs,id:<?php echo $value['skin_id'];?>,sk:<?php echo $value['directory'];?>"><img src="<?php echo  W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" alt="" /><span><em><?php echo $value['name'];?></em></span></a>
    				<?php else:?>
    						<a href="#" rel="e:cs,id:<?php echo $value['skin_id'];?>,sk:<?php echo $value['directory'];?>"><img src="<?php echo  W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" alt="" /><span><em><?php echo $value['name'];?></em></span></a>
    				<?php endif;?>	
    		   <?php endforeach;?>
    			</div>
    	   <?php } endforeach;?>
		<?php endif;?>
	  </div>
</div>