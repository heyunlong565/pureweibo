<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
</head>
<body>
<?php
	//记录是否可以设置标题
	$titleSet = in_array($id, $titleCanSet);
	
	if ($titleSet) { //标题字数限制
		$titleValids = array();

		array_push($titleValids, 'ne=m:不能为空');
	}

	//标示show_num类型
	// 1: 用户数 2:微博数
	$num_type = '';

	switch ($id) {
		case '1':
		case '5':
		case '8':
		case '9':
		case '10':
			$num_type = '微博';
		break;

		case '6':
			$num_type = '话题';
		break;
		
		default: 
			$num_type = '用户';
	}
?>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>组件设置<span> &gt; </span><?php echo F('escape', $com['name']);?>(<?php echo F('escape', $com['title']);?>)</div>
    <div class="set-wrap">
		<div class="sub-set02">
        	<h4 class="main-title">设置</h4>
			<div class="set-area-int">
        		<form name="config" id="form1" action="<?php echo URL('mgr/components.set');?>" method="post">
			<?php if ($titleSet): ?>
				<div class="set2">
					<div class="sub-set-l">组件显示的标题：</div>
					<div class="sub-set-r"><input class="input-box" vrel="<?php echo join('|', $titleValids);?>" type="text" warntip='#titleErr' name="title" value="<?php echo F('escape', $com['title']);?>"/>
					<span class="a-error hidden" id="titleErr"></span>
					</div>
				</div>

			<?php 
				endif;
				
				if ($id == 2) { //名人推荐

			?>
			<div class="set1">
				<div class="sub-set-l">组件使用的用户列表：</div>
				<div class="sub-set-r"><a href="<?php echo URL('mgr/user_recommend.getUserById', array('group_id'=>1));?>">名人推荐用户列表</a></div>
			</div>

			<?php

				} elseif ($id == 3) {

					$rs = DR('mgr/userRecommendCom.getById');
					$default_group = 2;
			?>
			<div class="rec-userlist">
				<label for="rec-userlist">组件使用的用户列表：
					<select name="group_id">
				<?php
					foreach ($rs['rst'] as $row) {
						if (!$row['native'] || $row['group_id'] == $default_group) {
							echo '<option value="'.$row['group_id'].'"'.($cfg['group_id']==$row['group_id'] ? ' selected':'').'>' . F('escape', $row['group_name']) . '</option>';
						}
					}
				?>
					</select>
				</label>
			</div>

			<?php

				} elseif ($id == 5) { //官方微博

			?>
			<div class="set1">
				<div class="sub-set-l">组件使用的用户列表：</div>
				<div class="sub-set-r"><a href="<?php echo URL('mgr/user_recommend.getUserById', array('group_id' => 4));?>">官方微博用户列表</a></div>
			</div>
			<?php

				} elseif ($id == 6) { //热门话题

				 $list = DR('xweibo/topics.getCategoryByType');
				 $topic_id = $cfg['topic_id'];
				 $default_id = 1;
			?>
			<div class="set1">
				<div class="sub-set-l">话题获取方式：</div>
				<div class="sub-set-r">
					<label for="topic_get1">
						<input class="radio-same" type="radio" value="1" name="topic_get" id="topic_get1" <?php if (!$topic_id):?>checked<?php endif;?>>使用新浪微博提供的热门话题
					</label>
					<br/>
					<label for="topic_get2">
						<input class="radio-same" type="radio"<?php if ($topic_id):?> checked<?php endif;?> value="2" name="topic_get" id="topic_get2">自定义话题列表
					</label>
					<div class="defined-topic">
						<label for="topic_id">请选择组件使用的话题列表：
							<select name="topic_id">
							<?php
								foreach($list['rst'] as $row):
								if (!$row['native'] || $row['topic_id'] == $default_id) {
							?>
								<option value="<?php echo $row['topic_id'];?>"<?php if($row['topic_id']==$topic_id):?> selected<?php endif;?>><?php echo F('escape', $row['topic_name']);?></option>
							<?php 
								}
								endforeach;
							?>
							</select>
						</label>
					</div>
				</div>
			</div>

			<?php
				} elseif ($id == 10) { //今日话题

			?>
				<div class="set1">
					<div class="sub-set-l">组件使用的话题列表：</div>
					<div class="sub-set-r"><a href="<?php echo URL('mgr/weibo/todayTopic.topicList', array('category'=>2));?>">今日话题列表</a></div>
				</div>

			<?php

				}
			
				if (isset($cfg['show_num'])):
			?>
                	<div class="set1">
                		<div class="sub-set-l">组件显示的<?php echo $num_type;?>数量：</div>
                    	<div class="sub-set-r">
                    		<label for="number2">
			<?php
				//建议
				$showNumSugg = '';

				$valids = array();

				switch ($id) {
					case 2:
					case 3:
					case 1:
					case 5:
					case 6:
						$showNumSugg = '设置范围3至20之间';
						array_push($valids, 'bt=min:3,max:20,m:范围为3-20');
					break;

					default:
						$showNumSugg = '设置范围3至10之间';
						array_push($valids, 'bt=min:3,max:10,m:范围为3-10');
				}

				if (in_array($id, array(2,3,7))) {
					$showNumSugg .= ',推荐为3的倍数';
				}

				array_push($valids, 'int=m:只能输入数字');
				array_push($valids, 'ne=m:不能为空');

			?>
                    			<input class="input-box" name="show_num" type="text"<?php echo !empty($valids) ? 'vrel='.join('|', $valids):''?> value="<?php echo $cfg['show_num'];?>" warntip="#showNumErr"/><span id="showNumErr" class="a-error hidden"></span><?php if ($showNumSugg):?><p class="sub-tips">（<?php echo $showNumSugg;?>）</p><?php endif;?>
                       		</label>
                    	</div>
                	</div>
			<?php endif; ?>	
					<input type="hidden" name="id" value="<?php echo $id;?>"/>
                	<div class="button"><input id="submitBtn" type="submit" value="提交" /></div>
            	</form>
    		</div>
        </div>
    </div>
</div>
<script type="text/javascript">
var valid = new Validator({
	form: '#form1'
});
</script>
</body>
</html>
