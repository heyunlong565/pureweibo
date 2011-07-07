<!-- 自定义皮肤 -->
<div class="skin-set" id="skinSet">
	<div id="colorSelector" style="display:none;"><div style="background-color: #0000ff"></div></div>
	<div id="csArea" class="cp-parent"  style="display:none;">
		<div class="cp-oper"><span class="txt" id="cltitle">主链接色</span><span class="c-view" id="cRealColor"><span style="background:#0082cb;"></span></span><label>#<input value="" class="input-txt" id="colorshow" /></label></div>
		<a href="#" class="btn-close" rel="e:closeCls"></a>
	</div>
	<style type="text/css"></style>
	<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/extra/colorpicker.js"></script>
	<link type="text/css" href="<?php echo W_BASE_URL;?>css/colorpicker/colorpicker.css" rel="stylesheet">
	<div class="tab-s5">
        <div class="tab-s5-in" id="switcherItem">
			<?php
			
			foreach($skinSort as $k=>$sort):
			?>
			<span class="<?php if((!defined('SKIN_CONSTUM_PATH')&&(defined('SKIN_CONSTUM_STYLEID')&&SKIN_CONSTUM_STYLEID==$k))||(!defined('SKIN_CONSTUM_STYLEID')&&!defined('SKIN_CONSTUM_PATH')&&$k==0)) echo 'current';?>"><a href="javascript:;"><?php echo $sort['name']?></a></span>
			<?php
			endforeach;
			?>
			<span class="<?php if(defined('SKIN_CONSTUM_PATH')) echo 'current';?>" id="custom"><a href="javascript:;">自定义皮肤</a></span>
            
			<div class="btn-area">
                <a href="#" class="general-btn highlight" rel="e:save"><span>保存</span></a>
                <a href="#" class="general-btn" rel="e:cancel"><span>取消</span></a>
            </div>
        </div>
    </div>
    
    
    <div class="skin-set-in" id="switcherCom">
        <div  class="skin-list <?php if(defined('SKIN_CONSTUM_PATH')||(!defined('SKIN_CONSTUM_PATH')&&defined('SKIN_CONSTUM_STYLEID')&&SKIN_CONSTUM_STYLEID!=0)) echo 'hidden';?>">
			<?php
			foreach($allSkin as $skin):
			
			?>
			<a class="<?php if((!defined('SKIN_CONSTUM_DIR')&&!defined('SKIN_CONSTUM_PATH')&&$skin['directory']=='skin_default')||(defined('SKIN_CONSTUM_DIR')&&SKIN_CONSTUM_DIR==$skin['directory'])) echo 'current'?>" rel="e:cs,id:<?php echo $skin['skin_id']?>,sk:<?php echo $skin['directory']?>" href="javascript:;"><img width='92' height='48' src="<?php echo $skin['thumbnail']?>" alt="" /><span><em><?php echo $skin['name']?></em></span></a>
			
			
			<?php
			endforeach;
			?>
        </div>
		<?php
		foreach($skinSort as $k=>$sort):
			if($k!=0):
		?>
			<div class="skin-list <?php if(defined('SKIN_CONSTUM_PATH')||!defined('SKIN_CONSTUM_STYLEID')||(!defined('SKIN_CONSTUM_PATH')&&defined('SKIN_CONSTUM_STYLEID')&&SKIN_CONSTUM_STYLEID!=$k)) echo 'hidden'?>">
				<?php
				foreach($sort['skins'] as $skin):
				?>
				<a class="<?php if((!defined('SKIN_CONSTUM_DIR')&&!defined('SKIN_CONSTUM_PATH')&&$skin['directory']=='skin_default')||(defined('SKIN_CONSTUM_DIR')&&SKIN_CONSTUM_DIR==$skin['directory'])) echo 'current'?>" rel="e:cs,id:<?php echo $skin['skin_id']?>,sk:<?php echo $skin['directory']?>" href="javascript:;"><img width='92' height='48' src="<?php echo $skin['thumbnail']?>" alt="" /><span><em><?php echo $skin['name']?></em></span></a>
				<?php
				endforeach;
				?>
			</div>
		<?php
			endif;
		endforeach;
		?>
		<?php
				$colorAlpha=array('#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb','#e7f2fb');
				
				$eachPage=10;
				$margeEach=-300;
				
				
				$colorPage=array();
				$i=0;
				foreach($colorConf as $color){
					$colorPage[$i/$eachPage][]=$color;
					$i++;
				}
				$index=1;
				$pageCount=count($colorPage);
				
				if(isset($customSkin)){
					if(isset($customSkin['colorid'])){
						$nowPage=(int)$customSkin['colorid']/$eachPage+1;
					}
					else{
						$nowPage=1;
					}
				}
				else{
					$nowPage=1;
				}
				//var_dump($nowPage);
				$margeStart=0;
				$margeStart+=($nowPage-1)*$margeEach;
		?>
		<div class="skin-custom <?php if(!defined('SKIN_CONSTUM_PATH')) echo 'hidden'?> ">
			<div class="skin-setbg">
				<div class="upload-pic">
					<img rel='<?php if(isset($customSkin['bg'])) echo 'u:1'?>' src="<?php if(isset($customSkin['bg'])) echo $customSkin['bg']; else echo W_BASE_URL.'img/upload_pic.png'?>" alt="" id="previewImg"/>
					<a href="#" class="icon-del-pic <?php if(!isset($customSkin['bg'])) echo 'hidden';?>" id="closeImg" title="删除背景"></a>
				</div>	
				<div class="oper-area">
					<div class="frm-row">
						<form id="xwb_back_form" target="" action="<?php echo URL('setting.skinBGUpload');?>" enctype="multipart/form-data" method="post">
					        <input type="file" value="上传图片" id="xwb_back_file" name="skinbg" />
					    </form>
					</div>

					<h5>设置背景图</h5>
					<div class="setbg-way">
						<label for="bg-repeat" rel="e:bgLevel"><input type="checkbox" <?php if(isset($customSkin['tiled'])&&$customSkin['tiled']=='1') echo 'checked=checked'?> id="bg-repeat" />背景平铺</label>
					</div>
					<div class="setbg-way">
						<label for="bg-fixed"  rel="e:bgStrong"><input type="checkbox" <?php if(isset($customSkin['fixed'])&&$customSkin['fixed']=='1') echo 'checked=checked'?> id="bg-fixed" />背景固定</label>
					</div> 
					<div class="btn-align-bg" id="align">
						<a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='1') echo 'cur'?>" rel="e:bgPlace,w:1">居左</a>
						<a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='2') echo 'cur'?>" rel="e:bgPlace,w:2">居中</a>
						<a href="#" class="<?php if(isset($customSkin['align'])&&$customSkin['align']=='3') echo 'cur'?>" rel="e:bgPlace,w:3">居右</a>
					</div>
				</div>
			</div>	
			
			<div class="skin-setcolor" id="skin_setcolorArea">
				<div class="preview-box">
					<div class="pb-main">
						<div class="pb-post-box">
							<div class="pb-post-btn"></div>
						</div>
						<div class="pb-list">
							<div class="pb-user-pic"></div>
							<div class="pb-con">
								<div class="c1"></div>	
								<div class="c2"></div>	
							</div>
						</div>
						<div class="pb-list">
							<div class="pb-user-pic"></div>
							<div class="pb-con">
								<div class="c1"></div>	
								<div class="c2"></div>	
							</div>
						</div> 
					</div>
					<div class="pb-aside">
						<div class="bg"></div>
						<div class="pb-user-con">
							<div class="pb-user-pic"></div>
							<div class="pb-user-info">
								<p class="ui1"></p>
								<p class="ui2"></p>
							</div>
						</div>
						<div class="pb-block">
							<div></div>
							<p></p>
						</div>
						<div class="pb-more"></div>
						<div class="pb-block">
							<div></div>
							<p></p>
						</div> 
						<div class="pb-more"></div>
					</div>
				</div>
			
				<div class="color-scheme">
					<p>你还可以选择配色方案，丰富背景和字体颜色</p>
					<div class="color-draw">
						<div class="color-area" id="color-area">
							<?php
							if(isset($customSkin)&&isset($customSkin['colors'])){
								$autoColor=TRUE;
								$printColor=explode(',',$customSkin['colors']);
							}
							if(isset($autoColor)&&$autoColor&&count($printColor)==5):
							?>
							<a href="#" rel="e:cls,t:0" key="<?php echo $printColor[0]?>" class="cur" title="主链接色"><span style="background:#<?php echo $printColor[0]?>;"></span></a>
							<a href="#" rel="e:cls,t:1" key="<?php echo $printColor[1]?>" title="辅链接色"><span style="background:#<?php echo $printColor[1]?>;"></span></a>
							<a href="#" rel="e:cls,t:2" key="<?php echo $printColor[2]?>" title="主背景色"><span style="background:#<?php echo $printColor[2]?>;"></span></a>
							<a href="#" rel="e:cls,t:3" key="<?php echo $printColor[3]?>" title="标题字体色"><span style="background:#<?php echo $printColor[3]?>;"></span></a>
							<a href="#" rel="e:cls,t:4" key="<?php echo $printColor[4]?>" title="主文字色"><span style="background:#<?php echo $printColor[4]?>;"></span></a>
							<?php
							else:
							?>
							<a href="#" rel="e:cls,t:0" key="0082cb" class="cur" title="主链接色"><span style="background:#0082cb;"></span></a>
							<a href="#" rel="e:cls,t:1" key="44b1da" title="辅链接色"><span style="background:#44b1da;"></span></a>
							<a href="#" rel="e:cls,t:2" key="8dd7f5" title="主背景色"><span style="background:#8dd7f5;"></span></a>
							<a href="#" rel="e:cls,t:3" key="000" title="标题字体色"><span style="background:#000;"></span></a>
							<a href="#" rel="e:cls,t:4" key="444" title="主文字色"><span style="background:#444;"></span></a>
							<?php
							endif;
							?>
						</div>
						<div class="pages">
							<?php
							//var_dump($nowPage);
							?>
							<!--<a href="#" class="arrow-l-s1 arrow-l-s1-disabled" rel="e:slide,t:prev" id="prev"></a>-->
							<!--<span id="slidePage"><?php /*echo $nowPage;*/?>/<?php /*echo $pageCount*/?></span>-->
							<!--<a href="#" class="arrow-r-s1"   rel="e:slide,t:next" id="next"></a>-->
						</div>
					</div>
					
					<div class="scheme-select">
						
						<ul id="scheme-select" style="margin-left:<?php echo 0;?>px;">
							<?php
							
							foreach($colorPage as $k=>$page):
							?>
							<li>
								
								<?php
								
								foreach($page as $color):
								?>
								<div  rel="e:clbs,t:<?php echo $index;?>,w:<?php echo implode('-',$color);?>" class="c-box <?php if(isset($customSkin)&&isset($customSkin['colorid'])&&(int)$customSkin['colorid']==$index) echo 'cur'?>">
								
								<?php
								foreach($color as $i=>$c):
								?>
									<span class="c-bg" style="background:<?php echo $c; ?>;"></span>
								<?php
								endforeach;
								?>
									
								</div> 
								
								<?php
								$index++;
								endforeach;
								?>
							</li>
							<?php
							endforeach;
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
