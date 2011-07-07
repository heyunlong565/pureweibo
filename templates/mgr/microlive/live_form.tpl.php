<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线直播列表 - 组件扩展</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo W_BASE_URL;?>css/colorpicker/colorpicker.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.css" />

<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/extra/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin/microlive.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL ?>js/datepick/jquery.datepick-zh-CN.js"></script>
</head>
<body class="main-body">
<div class="path"><p>当前位置：扩展工具<span>&gt;</span><a href="<?php echo URL('mgr/wb_live');?>">在线直播列表</a><span>&gt;</span><?php if (isset($live['id']) && !empty($live['id'])):?>编辑<?php else:?>新建<?php endif;?>在线直播</p></div>
    <div class="main-cont">
        <h3 class="title"><?php if (isset($live['id']) && !empty($live['id'])):?>编辑<?php else:?>新建<?php endif;?>在线直播</h3>
		<div class="set-area">
        	<div class="form-area">
    		 <form method="post" id="submitForm" action="<?php echo URL('mgr/wb_live.saveLive');?>">
    		    <input type="hidden" name="id" value="<?php echo isset($live['id']) ? $live['id'] : '';?>" />
                <div class="form-row">
                    <label for="live-tit" class="form-field">标题</label>
                    <div class="form-cont">
                        <input id="live-tit" vrel="_f|ne|sz=max:40,m:不多于20个字" warntip="#titleTip" class="input-txt" name="title" value="<?php echo isset($live['title']) ? F('escape', $live['title']) : '';?>" type="text" /><span class="tips-error hidden" id="titleTip"></span>
                        <p class="form-tips">（限20个汉字）</p>
                    </div>
                </div>
                <div class="form-row">
                    <label for="live-tit" class="form-field">话题</label>
                    <div class="form-cont">
                        <input id="live-tit" vrel="_f|ne|sz=max:40,m:不多于20个字,ww" warntip="#tleTip" class="input-txt" name="trends" value="<?php echo isset($live['trends']) ? F('escape', $live['trends']) : '';?>" type="text" /><span class="tips-error hidden" id="tleTip"></span>
                        <p class="form-tips">（限20个汉字）</p>
                    </div>
                </div>
                <div class="form-row">
                    <label for="declare" class="form-field">直播简介</label>
                    <div class="form-cont">
                    <textarea vrel="_f|ne|sz=max:280,m:不多于140个字,ww" id="declare" warntip="#descTip" name="desc" class="input-area area-s4" ><?php echo isset($live['desc']) ? F('escape', $live['desc']) : '';?></textarea><span class="tips-error hidden" id="descTip"></span>
                        <p class="form-tips">（限140个汉字）</p>
                    </div>
                </div>
                <div class="form-row">
                    <label for="code" class="form-field">视频代码框<span class="form-tips">（可不选）</span></label>
                    <div class="form-cont">
                        <textarea  id="code" name="code" class="input-area area-s2 code-area"><?php echo isset($live['code']) ? F('escape', $live['code']) : '';?></textarea>
                        <div class="video-prev">
                        <!-- <img src="<?php //echo W_BASE_URL.'img/video_img.png';?>" alt="" /> -->
                        </div>
                        <p class="form-tips">（建议视频大小为316*246px）</p>
                    </div>
                </div>
                
                <div class="form-row">
                    <label for="start-time" class="form-field">开始时间</label>
                    <div class="form-cont">
                        <div class="input start">
                            <input type="text" name="start_date" class="input-txt form-el-w100" id="start_date" value="<?php echo date('Y-m-j',isset($live['start_time'])?$live['start_time']:time());?>" vrel="ne=m:请填写开始时间|chkdate" warntip="#startTip"/>
                        
                             <select name="start_h" id="start_h" class="hour">
                            <?php
                                $start_h = '';
                                $start_m = '';
                                if(isset($live['start_time'])){
                                    $start_h = date('G',$live['start_time']);
                                    $start_m = date('i',$live['start_time']);
                                }
        
                                for($i=0; $i < 24; $i++):
                            ?>
                                <option value="<?php echo $i;?>"<?php if($start_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
                            <?php endfor;?>
                
                            </select>
                            <select name="start_m" id="start_m" class="min">
                            <?php
                                for($i=0; $i < 60; $i++):
                            ?>
                                <option value="<?php echo $i;?>"<?php if($start_m == $i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
                            <?php
                                endfor;
                            ?>
                            </select>
                        </div>
                    </div>
                    <span class="tips-error hidden" id="startTip"></span>
                </div>
                
                
                <div class="form-row">
                    <label for="end-time" class="form-field">结束时间</label>	
                    <div class="form-cont">
                        <div class="input end">
                            <input type="text" name="end_date" class="input-txt form-el-w100" id="end_date" value="<?php echo date('Y-m-j',isset($live['end_time'])?$live['end_time']:time());?>" vrel="ne=m:请填写结束时间" warntip="#endTip" />
                        
                            <select name="end_h" id="end_h" class="hour">
                            <?php
                                $end_h = '';
                                $end_m = '';
                                if(isset($live['end_time'])){
                                    $end_h = date('G',$live['end_time']);
                                    $end_m = date('i',$live['end_time']);
                                }
                                for($i=0; $i < 24; $i++):
                            ?>
                                <option value="<?php echo $i;?>"<?php if($end_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
                            <?php endfor;?>
                            </select>
                            <select name="end_m" id="end_m" class="min">
                        
                            <?php
                                for($i=0; $i < 60; $i++):
                            ?>
                                <option value="<?php echo $i;?>"<?php if ($end_m==$i):?> selected<?php endif;?>><?php echo sprintf("%02d", $i);?></option>
                            <?php
                                endfor;
                            ?>
                            </select>
                        </div>
                    </div>
                    <span class="tips-error hidden" id="endTip"></span>
                </div>
                
                <div class="form-row">
                    <label class="form-field">提醒时间</label>
                    <div class="form-cont">
					<input type="text" vrel="ne|int" warntip="#remindTip" name="notice_time" onchange="$('#noticeTimeSpan').html(this.value);" class="input-txt form-el-w100" value="<?php echo isset($live['notice_time']) ? ($live['start_time'] - $live['notice_time']) / 60 : 5;?>" /> 分
                        <span class="form-tips">直播开始前<span id="noticeTimeSpan"><?php echo isset($live['notice_time']) ? ($live['start_time'] - $live['notice_time']) / 60 : 5;?></span>分钟提醒用户</span>
                    </div>
                    <span class="tips-error hidden" id="remindTip"></span>
                </div>
                
                <div class="slice-line"></div>
                
                <div class="form-row">
                    <label for="compere" class="form-field">主持人</label>
                    <div class="form-cont table-cont">
                    	<table class="add-table" cellpadding="0">
                        	<tr>
                            	<th class="pic">头像</th>
                                <th>昵称</th>
                                <th class="operate">操作</th>
                            </tr>
							<?php if (isset($master_list) && !empty($master_list)):?>
							<?php $i = 1;?>
							<?php foreach($master_list as $item):?>
							<tr>
                            	<td><span class="user-pic"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></span></td>
                                <td onclick="MicroAdmin.edit(this)"><p title="点击编辑" class="text"><?php echo $item['screen_name'];?></p><input value="<?php echo $item['screen_name'];?>" type="text" class="input-txt txt-s1 hidden" id="_holder" vrel="_f|<?php if($i == 1):?>ne=m:须指定首个主持人|<?php endif;?>username" warntip="#masterTip"><input type="hidden" name="master[]" id="master" value="<?php echo $item['id'];?>" /><span class="tips-error hidden" id="masterTip"></span></td></td>
                                <td><a class="icon-edit" href="#" onclick="MicroAdmin.edit(this);return false;">编辑</a><a class="icon-del" href="#" onclick="MicroAdmin.del(this);return false;">删除</a></td>
                            </tr>
							<?php $i++;?>
							<?php endforeach;?>
							<?php endif;?>
                            <tr id="addCol">
                                <td><span class="user-pic"><img src="<?php echo W_BASE_URL;?>img/user_img_default.png" alt="" /></span></td>
                                <td><input type="text"  class="input-txt txt-s1" warntip="#masterRequire" vrel="userrequire=m:须添加至少一个主持人"/><span class="tips-error hidden" id="masterRequire"></span></td>
                                <td><a href="javascript:;" class="icon-add" onclick="MicroAdmin.add(this, 'master');return false;">添加</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-row">
                    <label for="compere" class="form-field">嘉宾</label>
                    <div class="form-cont table-cont">
                    	<table class="add-table" cellpadding="0">
                        	<tr>
                            	<th class="pic">头像</th>
                                <th>昵称</th>
                                <th class="operate">操作</th>
                            </tr>
							<?php if (isset($guest_list) && !empty($guest_list)):?>
							<?php $i = 1;?>
							<?php foreach($guest_list as $item):?>
							<tr>
                            	<td><span class="user-pic"><img src="<?php echo $item['profile_image_url'];?>" alt="" /></span></td>
                                <td onclick="MicroAdmin.edit(this)"><p title="点击编辑" class="text"><?php echo $item['screen_name'];?></p><input value="<?php echo $item['screen_name'];?>" type="text" class="input-txt txt-s1 hidden" id="_holder" vrel="_f|<?php if($i == 1):?>ne=m:须指定首个嘉宾|<?php endif;?>username" warntip="#masterTip"><input type="hidden" name="guest[]" id="guest" value="<?php echo $item['id'];?>" /><span class="tips-error hidden" id="masterTip"></span></td></td>
                                <td><a class="icon-edit" href="#" onclick="MicroAdmin.edit(this);return false;">编辑</a><a class="icon-del" href="#" onclick="MicroAdmin.del(this);return false;">删除</a></td>
                            </tr>
							<?php $i++;?>
							<?php endforeach;?>
							<?php endif;?>
                            <tr id="addCol">
                                <td><span class="user-pic"><img src="<?php echo W_BASE_URL;?>img/user_img_default.png" alt="" /></span></td>
                                <td><input type="text"  class="input-txt txt-s1" warntip="#guestRequire" vrel="userrequire=m:须添加至少一个嘉宾"/><span class="tips-error hidden" id="guestRequire"></span></td>
                                <td><a href="javascript:;" class="icon-add" onclick="MicroAdmin.add(this, 'guest');return false;">添加</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <input type="hidden" name="banner_img" id="bannerImg" value="<?php echo isset($live['banner_img']) ? $live['banner_img'] : W_BASE_HTTP.''.W_BASE_URL.'img/live_bg_960.png';?>" vrel="pic=f:banner,c:外观" warntip="#bannerTip"/>
                <input type="hidden" name="cover_img" id="coverImg" value="<?php echo isset($live['cover_img']) ? $live['cover_img'] : W_BASE_HTTP.''.W_BASE_URL.'img/live_logo_120.jpg';?>" vrel="pic=f:cover,c:封面" warntip="#coverTip"/>
                <input type="hidden" name="backgroup_img" value="<?php echo isset($live['backgroup_img']) ? $live['backgroup_img'] : W_BASE_HTTP.''.W_BASE_URL.'img/live_bg_main.jpg';?>" id="backgroundImg" vrel="pic=f:background,c:背景" warntip="#bkTip"/>
                <input type="hidden" name="backgroup_style" value="<?php echo isset($live['backgroup_style']) ? $live['backgroup_style'] : '';?>" id="backgroundStyle" />
                <input type="hidden" name="custom" value="<?php if (isset($live['custom_color']) && !empty($live['custom_color'])):?>1<?php else:?>0<?php endif;?>" id="custom" />
                <input type="hidden" name="bkcolor" id="bkcolor" value="<?php echo isset($live['custom_color']) ? $live['custom_color'] : '';?>"/>
                <input type="hidden" name="linkcolor" id="linkcolor" value="<?php echo isset($live['custom_color']) ? $live['custom_color'] : '';?>"/>
                <input type="hidden" name="color" id="color" value="<?php echo isset($live['backgroup_color']) ? $live['backgroup_color'] : '01';?>"/>
              </form>

                <div class="slice-line"></div>
                <div class="form-row">
                  <form target="" action="<?php echo URL('mgr/wb_live.upload');?>" method="post" enctype="multipart/form-data">
				  <input type="hidden" name="thumb" value="0" />
                    <label for="banner" class="form-field">外观设置</label>
                    <div class="form-cont">
                        <input type="file" class="btn-file" value="上传banner"  id="banner" name="pic" onchange="MicroAdmin.upload(this)"/>
                        <p class="form-tips">建议图片尺寸960*120px</p>
                        <div class="banner-prev"><img src="<?php if (isset($live['banner_img'])):?><?php echo F('fix_url',$live['banner_img']); else: echo W_BASE_URL.'img/live_bg_960.png';?><?php endif;?>" title="banner" /></div>
                    </div>
                    <span class="tips-error hidden" id="bannerTip"></span>
                   </form> 
                </div>
                <div class="form-row">
                     <form action="<?php echo URL('mgr/wb_live.upload');?>" method="post" enctype="multipart/form-data">
					 <input type="hidden" name="thumb" value="1" />
                        <label for="cover" class="form-field">封面</label>
                        <div class="form-cont">
                            <input type="file" class="btn-file" value="上传banner" name="pic" id="cover" onchange="MicroAdmin.upload(this)"/>
                            <p class="form-tips">图片尺寸120*120px</p>
                            <div class="cover-prev"><img src="<?php if (isset($live['cover_img'])):?><?php echo F('fix_url',$live['cover_img']); else: echo W_BASE_URL.'img/live_logo_120.jpg';?><?php endif;?>" title="banner" /></div>
                        </div>
                        <span class="tips-error hidden" id="coverTip"></span>
                    </form>
                </div>
                <div class="form-row">
                  <form action="<?php echo URL('mgr/wb_live.upload');?>" method="post" enctype="multipart/form-data">
				  <input type="hidden" name="thumb" value="0" />
                    <label for="background" class="form-field">背景</label>
                    <div class="form-cont">
                        <input type="file" class="btn-file" value="上传banner" name="pic" id="background" onchange="MicroAdmin.upload(this)"/>
                        <div class="bg-prev">
                            <img src="<?php if (isset($live['backgroup_img'])):?><?php echo F('fix_url',$live['backgroup_img']); else: echo W_BASE_URL.'img/live_bg_main.jpg';?><?php endif;?>" title="banner" />
                            <select name="backgroup_style">
                                <option value="1" <?php if ((isset($live['backgroup_style']) && $live['backgroup_style'] != 2) || !isset($live['backgroup_style'])):?>selected="selected"<?php endif;?>>平铺</option>
                                <option value="2" <?php if (isset($live['backgroup_style']) && $live['backgroup_style'] == 2):?>selected="selected"<?php endif;?>>居中</option>
                            </select>
                        </div>
                    </div>
                    <span class="tips-error hidden" id="bkTip"></span>
                  </form>
                </div>
                <div class="form-row" id="colorPanel">
                    <label for="compere" class="form-field">颜色</label>
                     <div class="form-cont">
                     	<label><input type="radio" id="chkBanner" <?php if ((isset($live['custom_color']) && empty($live['custom_color'])) || !isset($live['custom_color'])):?>checked="checked"<?php endif;?> rel="e:st,v:0" name="style"/>外观方案</label>
                        <div class="color-slt" id="color_stl_0">
                            <a <?php if ((isset($live['backgroup_color']) && $live['backgroup_color'] == '01') || !isset($live['backgroup_color'])):?> class="on"<?php endif;?> href="#" rel="e:a,v:01"><span class="color01"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '02'):?> class="on"<?php endif;?> href="#" rel="e:a,v:02"><span class="color02"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '03'):?> class="on"<?php endif;?> href="#" rel="e:a,v:03"><span class="color03"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '04'):?> class="on"<?php endif;?> href="#" rel="e:a,v:04"><span class="color04"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '05'):?> class="on"<?php endif;?> href="#" rel="e:a,v:05"><span class="color05"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '06'):?> class="on"<?php endif;?> href="#" rel="e:a,v:06"><span class="color06"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '07'):?> class="on"<?php endif;?> href="#" rel="e:a,v:07"><span class="color07"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '08'):?> class="on"<?php endif;?> href="#" rel="e:a,v:08"><span class="color08"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '09'):?> class="on"<?php endif;?> href="#" rel="e:a,v:09"><span class="color09"><em></em></span></a>
                            <a <?php if (isset($live['backgroup_color']) && $live['backgroup_color'] == '10'):?> class="on"<?php endif;?> href="#" rel="e:a,v:10"><span class="color10"><em></em></span></a>
                        </div>
                     	<label><input type="radio" id="chkCustom" name="style" <?php if (isset($live['custom_color']) && !empty($live['custom_color'])):?>checked="checked"<?php endif;?> rel="e:st,v:1" />自定义</label>
                        <div class="color-slt" id="color_stl_1">
							<?php if (isset($live['custom_color']) && !empty($live['custom_color'])):?>
							<?php $color = explode(',', $live['custom_color']);?>
							<?php else:?>
							<?php $color = array();?>
							<?php endif;?>
                            <div class="color-define" id="colorpickerA"><a href="#" rel="e:b"><span class="color" style="<?php if (isset($color[0])):?>background-color:<?php echo $color[0];?><?php endif;?>"><em></em></span></a><span>背景色</span></div>
                            <div class="color-define" id="colorpickerB"><a href="#" rel="e:b"><span class="color" style="<?php if (isset($color[1])):?>background-color:<?php echo $color[1];?><?php endif;?>"><em></em></span></a><span>链接色</span></div>
                        </div>
                    </div>
                </div>
                 <div class="btn-area"><a href="#" id="preview" rel="e:pr" class="general-btn btn-s2"><span>预览</span></a><a href="#" id="submitBtn" class="general-btn"><span>保存</span></a></div>
            </div>
			</form>
        	
    	</div>
    </div>
</body>
<script> 
    gReqUserUrl = '<?php echo URL('mgr/wb_live.getUserShow');?>';
    gUsrImgUrl  = '<?php echo W_BASE_URL;?>img/user_img_default.png';
    gPreviewUrl = '<?php echo URL('mgr/wb_live.preview');?>';

	$('#start_date,#end_date').attr('readonly', 'true').datepick({
	    onSelect: function (dates) { 
	
	        if (this.id == 'start_date') { 
	            $('#end_date').datepick('option', 'minDate', dates[0] || null); 
	        } 
	        else { 
	            $('#start_date').datepick('option', 'maxDate', dates[0] || null); 
	        } 
	    },
	    
	    minDate : new Date(),
	    dateFormat :'yyyy-mm-dd'
	});
	
    $('#colorpickerA').css('position', 'relative').ColorPicker({
        appendTo:'#colorpickerA',
    	onShow: function (colpkr) {
    	     $(colpkr).css({left:-20,top:-175}).fadeIn(500).ColorPickerSetColor($('#colorpickerA').find('a span').css('backgroundColor'));
    	    styleUI.actionMgr.doAct($(this).find('a')[0], this);
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    hex = '#'+ hex;
    		$('#colorpickerA').find('a span').css('backgroundColor', hex);
    		$('#bkcolor').val(hex);
    	}
    });
    
    $('#colorpickerB').css('position', 'relative').ColorPicker({
        appendTo:'#colorpickerB',
    	onShow: function (colpkr) {
    	    $(colpkr).css({left:-20,top:-175}).fadeIn(500).ColorPickerSetColor($('#colorpickerB').find('a span').css('backgroundColor'));
    	    styleUI.actionMgr.doAct($(this).find('a')[0], this);
    	},
    	onHide: function (colpkr) {
    		$(colpkr).fadeOut(500);
    		return false;
    	},
    	onChange: function (hsb, hex, rgb) {
    	    hex = '#'+ hex;
    		$('#colorpickerB').find('a span').css('backgroundColor', hex);
    		$('#linkcolor').val(hex);
    	}
    });
    
    // 外观选择项点击
    var styleUI = new Xwb.ui.Base({
        view : $('.form-area')[0],
        actionMgr:true,
        onactiontrig:function(e){
            var src = $(e.src);
            var panel = src.closest('.color-slt');
            switch(e.data.e){
                // 外观
                case 'a':
                    $('#color_stl_0,#color_stl_1').find('.on').removeClass('on');
                    //panel.find('.on').removeClass('on');
                    src.addClass('on');
                    $('#color').val(e.get('v'));
                    $('#chkBanner').attr('checked',true);
                    $('#custom').val(0);
                break;
                // 自定义
                case 'b':
                    $('#color_stl_0,#color_stl_1').find('.on').removeClass('on');
                    //panel.find('.on').removeClass('on');
                    src.addClass('on');
                    $('#chkCustom').attr('checked',true);
                    $('#color').val(src.find('span').attr('className'));
                    $('#custom').val(1);
                break;
                // radio
                case 'st':
                    var v = e.get('v');
                    function setColorRadio(idx, selIdx) {
                        var $colors = $('#color_stl_' + idx).find('a');
                        $colors.eq(selIdx||0)
                            .addClass('on');
                    }
                    $('#color_stl_0,#color_stl_1').find('a').removeClass('on');
                    setColorRadio(v);
                    $('#custom').val(v);
                    e.preventDefault(false);
                break;
            }
        }
    });
    
    styleUI.getView();

    $('.bg-prev select').change(function(){
        $('#backgroundStyle').val(this.value);
    });

    $('#preview').click(function(){
        var url = Xwb.util.appendParam(gPreviewUrl, Xwb.util.formQuery('#submitForm') );
        window.open(url);
    });

	/**
	 * 返日期的格式化字符串所表示的日期对象.
	 * @param {String} str 日期的格式化字符串,如2009/02/15
	 * @param {String} 格式, mm/dd/yy或dd/mm/yy或yy/mm/dd,中间分隔符不限定
	 * @return {Date} 格式化字符串所表示的日期对象
	 * @see CC#dateFormat
	 */
	 function dateParse(str, fmt){
	  if(!fmt){
	    return new Date(str);
	  }
	  var arr = [0,0,0];
	  var sep = fmt.charAt(2);
	  var ss = fmt.split(sep);
	  var tar = str.split(sep);
	  var cc = '';
	  for(var i=0,len=ss.length;i<len;i++){
	    if(ss[i]=='mm')
	      arr[0] = tar[i];
	    else if(ss[i]=='dd')
	      arr[1]=tar[i];
	    else arr[2]=tar[i];
	  }
	  return new Date(arr.join('/'));
	 }
			 
    var validator = Xwb.use('Validator', {
        form:'#submitForm',
        trigger:'#submitBtn',
        
        // override，查找提示元素的方法
        getWarnTip : function(elem, tipSelector){
            // 
            if(tipSelector === '#masterTip')
                return $(elem).parent('tr').find(tipSelector);

            return Xwb.ax.ValidationMgr.prototype.getWarnTip.apply(this, arguments);
        },
        
        validators :{
            // 对于新增的主持人，检测规则为:如果元素为空，忽略；如果不为空，必须存在用户
            username : function(elem, v, data, next){
                var self = this;
                if(v){
                    MicroAdmin.checkInput(elem, function(b){
                        self.report(b, data);
                        next();
                    });
                }else {
                    // 检测至少一个非空
                    var pass = false;
                    var tbl = $(elem).closest('table');
                    var holders = tbl.find('#_holder');
                    if(!holders.length){
                        tbl.find('.icon-add').onclick();
                        var hd = tbl.find('#_holder')[0];
                        MicroAdmin.edit(hd);
                        $(hd).closest('td').find('.tips-error').cssDisplay(true);
                    }else {
                        
                    }
                    
                    this.report(pass, data);
                    next();
                }
            },
            pic : function(elem, v, data, next){
                if(!v){
                    data.m = '请上传'+data.c+'图片。';
                }
                this.report(v, data);
                next();
            },
            // 用于检测至少要输入一个用户
            userrequire : function(elem, v, data, next){
                var pass = false;
                var tbl = $(elem).closest('table');
                var holders = tbl.find('#_holder');
                if(!holders.length){
                    this.report(false, data);
                }else {
                    holders.each(function(){
                        if($(this).val()){
                            pass = true;
                            return false;
                        }
                    });
                    this.report(pass, data);
                }
                next();
            },
			// 日期检查
			chkdate : function(elem, v, data, next){
			    var result = true;
			    var start = dateParse(v, 'yy-mm-dd');
			    start = new Date(
			        (start.getMonth()+1) +'/' + 
			        start.getDate() +'/' +
			        start.getFullYear()+' '+
			        $('#start_h').val()+':'+
			        $('#start_m').val()
			    );
			    var end   = dateParse($('#end_date').val(), 'yy-mm-dd');
			    end = new Date(
			        (end.getMonth()+1) +'/' + 
			        end.getDate() +'/' +
			        end.getFullYear()+' '+
			        $('#end_h').val()+':'+
			        $('#end_m').val()
			    );
			    if(start > end){
			        data.m = '开始时间不能晚于结束时间';
			        result = false;
			    }
			    this.report(result, data);
			    next();
			}
        }
    });
    
    MicroAdmin.validator = validator;
</script>
</html>