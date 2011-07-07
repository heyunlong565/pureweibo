<div id="eventfrm" class="form-area">
		<div class="form-item">
		<input type="hidden" name="id" value="<?php echo isset($event['id'])? $event['id']:'';?>"/>
			<label for="evt-tit"><em>*</em>活动标题：</label>
			<input class="input style-normal" type="text" warntip="#titleTip" vrel="_f=ch:1|ne=m:请填写活动标题|sz=max:40,ww,m:不能超过20个汉字" value="<?php echo isset($event['title']) ? F('escape', $event['title']) : '';?>" name="title" id="evt-tit">
			<span id="titleTip" class="tips-wrong hidden" style="">请填写活动标题</span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
			<label for="evt-way">联系方式：</label>
            <input class="input style-normal" type="text" warntip="#phoneTip" vrel="_f=ch:1" value="<?php echo isset($event['phone']) ? F('escape', $event['phone']) : '';?>" name="phone" id="evt-way">
			<span id="phoneTip" class="tips-wrong hidden" style="">请填写联系电话</span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
			<label for="evt-contact">联系人：</label>
            <input class="input style-normal" type="text" warntip="#realTip" vrel="_f=ch:1" value="<?php echo isset($event['realname']) ? F('escape', $event['realname']) : '';?>" name="realname" id="evt-contact">
			<span id="realTip" class="tips-wrong  hidden" style="">请填写真实姓名</span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
			<label for="evt-spot"><em>*</em>活动地点：</label>
            <input class="input style-normal" type="text" warntip="#addrTip" vrel="_f=ch:1|ne=m:请填写活动地点|sz=max:60,ww,m:不能超过30个汉字" value="<?php echo isset($event['addr']) ? F('escape', $event['addr']) : '';?>" name="addr" id="evt-spot">
			<span id="addrTip" class="tips-wrong hidden" style="">请填写活动地点</span>
            <span class="tips-ok hidden"></span>
		</div>

		<div class="form-item">
			<label for="start_date"><em>*</em>开始时间：</label>
            <input class="input start style-normal" type="text" warntip="#startTip" vrel="_f=ch:1|ne=m:请填写开始时间|chkdate" value="<?php echo date('Y-m-j',isset($event['start_time'])?$event['start_time']:time());?>" id="start_date" name="start_date">
			 <select class="hour" id="start_h" name="start_h">
			<?php
				$start_h = '';
				$start_m = '';
				if(isset($event['start_time'])){
					$start_h = date('G',$event['start_time']);
					$start_m = date('i',$event['start_time']);
				}

				for($i=0; $i < 24; $i++):
			?>

				<option value="<?php echo $i;?>"<?php if($start_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
			<?php endfor;?>

			</select>
			<select class="min" id="start_m" name="start_m">
			<?php
				for($i=0; $i < 60; $i++):
			?>
				<option value="<?php echo $i;?>"<?php if($start_m == $i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
			<?php
				endfor;
			?>
			</select>
<span id="startTip" class="tips-wrong hidden"></span>
</div>
<div class="form-item">
	<label for="end_date"><em>*</em>结束时间：</label>
    <input class="input start style-normal" type="text" warntip="#endTip" vrel="_f=ch:1|ne=m:请填写结束时间" value="<?php echo date('Y-m-j',isset($event['end_time'])?$event['end_time']:time()+86400);?>" id="end_date" name="end_date">
			<select class="hour" id="end_h" name="end_h">
				<?php
					$end_h = '';
					$end_m = '';
					if(isset($event['end_time'])){
						$end_h = date('G',$event['end_time']);
						$end_m = date('i',$event['end_time']);
					}
					for($i=0; $i < 24; $i++):
				?>
					<option value="<?php echo $i;?>"<?php if($end_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
				<?php endfor;?>
			</select>
			<select class="min" id="end_m" name="end_m">
				<?php
					for($i=0; $i < 60; $i++):
				?>
					<option value="<?php echo $i;?>"<?php if ($end_m==$i):?> selected<?php endif;?>><?php echo sprintf("%02d", $i);?></option>
				<?php
					endfor;
				?>
			</select>
			<span id="endTip" class="tips-wrong hidden"></span>
		</div>
		<div class="form-item">
			<label for="cost">人均费用：</label>
			<div class="money">
			<span class="f-radio">
			<label class="free" for="s1"><input type="radio" <?php if(!isset($event['cost']) || !$event['cost']){ echo 'checked="checked"';}?> value="0" name="a1" id="s1">免费</label>
				<input type="radio" value="1" <?php if(isset($event['cost']) && $event['cost']>0){ echo 'checked="checked"';}?> vrel="cost" name="a1" id="s2">
				<input vrel="_f=ch:1" type="text" value="<?php echo isset($event['cost']) && $event['cost']>0 ? $event['cost'] : '';?>" name="cost" id="cost" class="input input-sort style-normal <?php if (isset($event['cost']) && $event['cost'] > 0):?>style-disabled<?php endif;?>" >
				元
			</span>
			</div>
			<span id="costTip" class="tips-wrong hidden">请填写人均费用</span>
		</div>
		<div class="form-item">
			<label for="cost">其他要求：</label>
			<span class="f-check f-checks"><input name="other" value="2" <?php if (isset($event['other']) && $event['other'] == 2):?>checked="checked"<?php endif;?> type="checkbox"/>要求参与者填写联系方式和简单说明</span>
		</div>
		<div class="form-item">
			<label for="evt-intro"><em>*</em>活动介绍：</label>
			<textarea warntip="#descTip" vrel="_f=ch:1|ne=m:请填写活动介绍|sz=max:2000,m:最多2000字" rows="" cols="" name="desc" class="input input-area style-normal" id="evt-intro"><?php echo isset($event['desc']) ? F('escape', $event['desc']) : '';?></textarea>
			<span id="descTip" class="tips-wrong hidden" style="">请填写活动介绍</span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
			<label>封面：</label>
			<div class="cover-area">
				<div class="cover-pic">
					<span class="hidden" id="uploading">上传中...</span>
						<img id="cover_img" src="<?php if (isset($event['pic'])):?><?php echo F('fix_url',$event['pic']); else: echo W_BASE_URL;?>img/event_cover.jpg<?php endif;?>">
					<span class="loading hidden" id="pic_loading"></span>
				</div>
				<input type="hidden" id="event_pic" name="event_pic">
				<form target="xwb_upload_frame_5" method="post" enctype="multipart/form-data" id="uploadImg" name="uploadImg">
					<input type="file" id="upload_pic" name="pic">
				<input type="hidden" name="callback"></form>
				<p>请上传小于1M的JPG、PNG、GIF格式图片，尺寸为120*120PX</p>
			</div>
		</div>


		<div class="operate-area">
			<a id="create" href="#" class="btn-ffirm">确认</a>
		</div>

</div>
