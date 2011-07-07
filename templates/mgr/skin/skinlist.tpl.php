<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>皮肤列表 - 皮肤管理 - 外观设置</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo W_BASE_URL;?>js/jquery.min.js'></script>
<script type='text/javascript'>
	window.onload = function() {
		setTab(1,0);
	}

   function setTab(m,n){
		var tli=document.getElementById("skin-menu"+m).getElementsByTagName("li");
		var mli=document.getElementById("skin-main"+m).getElementsByTagName("div");
		for(i=0;i<tli.length;i++){
			tli[i].className=i==n?"current":"";
			 mli[i].style.display=i==n?"block":"none";
		}
	}

	function edit(id, style_id, text){
		$('#skin_id').val(id);
		$('#select_id').val(style_id);
		$('#skin_name').html(text);
		$('#edit').show();
		$('#edit_class').addClass('mask');
	}

	function closeBox() {
		$('#edit').hide();
		$('#edit_class').removeClass('mask');
	}
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：外观设置<span> &gt; </span>皮肤管理<span> &gt; </span>皮肤列表</div>
    <div class="set-wrap">
        <h4 class="main-title">所有可用的皮肤</h4>
		<div class="set-area-int">
			<div class="skinlist-menu">
				<ul id="skin-menu1" class="skin-menu1">
					<li class="current" onclick="setTab(1,0)">全部皮肤</li>
					<?php $i=1;foreach($sort as $value):?>
					<li onclick="setTab(1,<?php echo $i;?>)"><?php echo $value['style_name'];$i++;?></li>
					<!--<li onclick="setTab(1,2)">酷炫类</li>-->
					<?php endforeach;?>
				</ul>
			</div>
			<div class="skin-main" id="skin-main1">
                <div class="block">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border skin-t">
                    	<colgroup>
							<col class="serial-number" />
    						<col class="skin-name" />
    						<col class="skin-category" />
    						<col />
    						<col class="skin-preview" />
                            <col class="skin-status" />
                            <col class="skin-directory"/>
                            <col class="operate-w1" />
    					</colgroup>
						<thead class="td-title-bg">
							<tr>
   					  			<td>编号</td>
   					  			<td>皮肤名称</td>
   					  			<td>类别</td>
   					  			<td>说明</td>
                        		<td>预览图</td>
   					  			<td>状态</td>
   					  			<td>存放目录</td>
   					  			<td>操作</td>
				  			</tr>
              			</thead>
                		<tbody>
							<?php $i=1;foreach($list as $value):?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo $value['name'];?></td>
									<td><?php if($value['skin_group']){echo $value['skin_group']['style_name'];}else{echo '未分类';}?></td>
									<td><?php echo $value['desc'];?></td>
									<td><img src="<?php echo  W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" /></td>
									<td>
									<?php
									if($value['state'] < 1) {echo '已启用';}
									elseif($value['state'] == 1){echo '已禁用';}
									elseif($value['state'] == 2){echo '不兼容';}
									?>
									</td>
									<td><?php echo $value['directory'];?></td>
									<td>
										<?php if(!$value['state']):?>
											<a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="using" href="<?php echo URL('mgr/skin.setSkinState', 'state=1&id=' . $value['skin_id']);?>">禁用</a>
										<?php endif;?>
										<?php if($value['state'] == 1):?>
											<a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="forbidden" href="<?php echo URL('mgr/skin.setSkinState', 'state=0&id=' . $value['skin_id']);?>">启用</a>
										<?php endif;?>
										<?php if($value['state'] == 2):?>
											无法操作
										<?php endif;?>
									</td>
								</tr>
							<?php endforeach;?>

						</tbody>
					</table>
                </div>
			<?php if($sort):?>
				<?php foreach($sort as $value):?>
                <div>
                	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-border skin-t">
                    	<colgroup>
							<col class="serial-number" />
    						<col class="skin-name" />
    						<col class="skin-category" />
    						<col />
    						<col class="skin-preview" />
                            <col class="skin-status" />
                            <col class="skin-directory" />
                            <col class="operate-w1" />
    					</colgroup>
						<thead class="td-title-bg">
							<tr>
   					  			<td>编号</td>
   					  			<td>皮肤名称</td>
   					  			<td>类别</td>
   					  			<td>说明</td>
                        		<td>预览图</td>
   					  			<td>状态</td>
   					  			<td>存放目录</td>
   					  			<td>操作</td>
				  			</tr>
              			</thead>
                		<tbody>
						<?php if(isset($skin_sort_list[$value['style_id']])):?>
							<?php $i=1;foreach($skin_sort_list[$value['style_id']] as $value):?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><?php echo $value['name'];?></td>
									<td><?php if($value['skin_group']){echo $value['skin_group']['style_name'];}else{echo '未分类';}?></td>
									<td><?php echo $value['desc'];?></td>
									<td><img src="<?php echo W_BASE_URL . 'css/' . $value['directory'] . '/' . SKIN_PRE_PIC;?>" width="51" height="38" /></td>
									<td>
									<?php
									if($value['state'] < 1) {echo '已启用';}
									elseif($value['state'] == 1){echo '已禁用';}
									elseif($value['state'] == 2){echo '不兼容';}
									?>
									</td>
									<td><?php echo $value['directory'];?></td>
									<td>
										<?php if(!$value['state']):?>
											<a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a><a href="<?php echo URL('mgr/skin.setSkinState', 'state=1&id=' . $value['skin_id']);?>" class="using">禁用</a>
										<?php endif;?>
										<?php if($value['state'] == 1):?>
											<a class="change-icon" title="编辑" href="javascript:edit('<?php echo $value['skin_id'];?>','<?php echo $value['style_id'];?>','<?php echo $value['name'];?>')" >编辑</a>
                                            <a class="forbidden" href="<?php echo URL('mgr/skin.setSkinState', 'state=0&id=' . $value['skin_id']);?>">启用</a>
										<?php endif;?>
										<?php if($value['state'] == 2):?>
											无法操作
										<?php endif;?>
									</td>
								</tr>
							<?php endforeach;?>
						  <?php else:?>
								<tr>
                                	<td colspan="8" class="no-data">尚没有任何记录</td>
                                </tr>
						  <?php endif;?>
						</tbody>
					</table>
                </div>
				<?php endforeach;?>
				<?php endif;?>
             </div>
             <p class="slect-skin">设置默认皮肤：</p>
             <form action="<?php echo URL('mgr/skin.setSkinDefault');?>" method="post">
                 <label for="skin-slect-default">
                    <select name="skin_default_id" class="skin-slect-default">
						<?php foreach($list as $value):?>
							<?php if($value['state'] < 1):?>
								<option value="<?php echo $value['skin_id'];?>" <?php if($sysconfig['skin_default'] == $value['skin_id']){echo 'selected=selected';}?>><?php echo $value['name'];?></option>
							<?php endif;?>
						<?php endforeach;?>
                    </select><span class="slect-skin-tips">(注：未启用以及不兼容的皮肤都不能设为默认皮肤)</span>
                 </label>
                 <div class="button skin-position"><input type="submit" name="确定" value="确定" /></div>
             </form>  
    	</div>
    </div>
</div>
<div class="pop-float fixed-pop" id="edit" style="display:none">
	<div class="pop-t">
		<div></div>
	</div>
	<div class="pop-m">
		<div class="pop-inner">
        	<h4><a class="clos" href="javascript:closeBox();"></a>修改皮肤所属的类别</h4>
            <div class="add-float-content">
            	<form action="<?php echo URL('mgr/skin.editSkin');?>" method="post"  name="add-newlink">
            		<p class="skin-name-tips">皮肤名称：<span id="skin_name"></span></p>
            		<div class="float-info">
            			<label for="skin-slect-default">所属类别：
                    		<select name="style_id" id="select_id" class="skin-slect-default">
								<?php foreach($sort as $value):?>
									<option value="<?php echo $value['style_id'];?>" ><?php echo $value['style_name'];?></option>
								<?php endforeach;?>
                    		</select>
                 		</label>
            		</div>
                    <div class="float-button">
						<input type="hidden" name="id" id="skin_id" value="" />
                    	<span class="float-button-y"><input type="submit" name="确定" value="确定" /></span>
                    	<span class="float-button-n"><input type="button" name="取消" value="取消" onclick="closeBox();" /></span>
                    </div>
                </form>
            </div>
    	</div>
		<div class="pop-inner-bg"></div>
	</div>
	<div class="pop-b">
		<div></div>
	</div>
</div>
<div id="edit_class"></div>
</body>
</html>
