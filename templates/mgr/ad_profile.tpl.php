<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>组件列表 - 组件设置 - 组件管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin_lib.js"></script>
<script>

function InputBox(parent) {
	this.$_parent = parent;

	this.$_win = null;

	this._callback = null;

	this._cancle = this.hide;

	this._init(parent);
}
InputBox.prototype = {
	_init: function(p) {
		var html = [
		'<div class="pop-float fixed-pop" style="display:none">',
		'	<div class="pop-t">',
		'		<div></div>',
		'	</div>',
		'	<div class="pop-m">',
		'		<div class="pop-inner">',
		'		<form id="form1" name="form1" method="post">',
		'			<h4><a href="javascript:;" class="clos"></a>推广信息</h4>',
		'			<div class="add-float-content">',
		'				<div class="float-info">',
		'					<p>信息内容：</p>',
		'					<input type="text" value="" class="input-box pop-w10" id="text" name="input_text" warntip="#textErr"><span id="textErr" class="a-error hidden"></span>',
		'				</div>',
		'				<div class="float-info">',
		'					<p>链接：</p>',
		'					<input type="text" value="" class="input-box pop-w10" id="link" name="input_link" warntip="#linkErr"><span id="linkErr" class="a-error hidden"></span>',
		'				</div>',
		'				<div class="float-button">',
		'					<span class="float-button-y"><input type="button" value="确定" name="input_ok"></span>',
		'					<span class="float-button-n"><input type="button" value="取消" name="input_cancle"></span>',
		'				</div>',
		'			</div>',
		'		</form>',
		'		</div>',
		'		<div class="pop-inner-bg"></div>',
		'	</div>',
		'	<div class="pop-b">',
		'		<div></div>',
		'	</div>',
		'</div>'
		].join('');

		var win = this.$_win = $(html).appendTo(document.body);

		var self = this;

		//回调
		$('input[name=input_ok]', win).click(function() {
			self._callback && self._callback($('input[name=input_text]', win).val(), $('input[name=input_link]', win).val());
		});

		$('input[name=input_cancle]', win).add('.clos', win).click(function() {
			self._cancle && self._cancle();
		});

		return this;
	},
	
	onOk: function(callback) {
		this._callback = callback;

		return this;
	},

	onCancle: function(cancle) {
		this._cancle = cancle;

		return this;
	},


	show: function() {
		//定位
		/*
		this.$_win.css({
			'left': (this.$_parent.width()-this.$_win.width())/2,
			'top': '100px'
		});
		*/
		this.$_win.show();
		$('input[name=input_text]', this.$_win).focus();

		return this;
	},

	hide: function() {
		this.$_win.hide();

		return this;
	},

	set: function(text, link) {
		$('input[name=input_text]', this.$_win).val(text || '');
		$('input[name=input_link]', this.$_win).val(link || '');

		return this;
	},

	setTitle: function(title) {
		$('.clos', this.$_win).next().eq(0).text(title);

		return this;
	}
}

$(function() {
	var box = new InputBox($('div.personal-extend'));

	var errNodes = {
		'text': box.$_win.find('#textErr'),
		'link': box.$_win.find('#linkErr')
	};

	var mode = 'add';
	var link_id = '';
	var target;

	var $text = box.$_win.find('#text'),
		$link = box.$_win.find('#link');

	var checkInput = function() {
		var text = $text.val(),
			link = $link.val();

		var errno = 0;

		if (!text || byteLen(text) > 40)
		{
			errNodes.text.text('必选项,不能超过20个中文40个英文。').removeClass('hidden');
			errno |= 1;
		} else {
			errNodes.text.addClass('hidden');
		}

		if (!link || link.length > 255)
		{
			errNodes.link.text('必选项,不能超过255字符。').removeClass('hidden');
			errno |= 2;
		} else {
			errNodes.link.addClass('hidden');
		}

		return errno;
	}

	box.onOk(function(title, link) {
		if (checkInput())
		{
			return;
		}

		var data = {
			title: title,
			link: link,
			op: mode,
			link_id: link_id
		}

		$.ajax({
			url: "<?php echo URL('mgr/plugins.save', array('id' => 3));?>", 
			data: data,
			type: 'post',
			dataType: 'json',
			success: function(ret) {
				if (mode == 'add')
				{
					if (ret.errno == 0)
					{ //成功
						var html = ['<tr><td>',
							title,
							'</td><td><a target="_blank" href="',
							link,
							'">',
							link,
							'</a></td><td><a rel="mod:'+ret.rst+'" class="change-icon" title="编辑" href="javascript:;">编辑</a><a class="del-icon" title="删除" href="javascript:;" rel="del:',
							ret.rst,
							'">删除</a></td></tr>'].join('');
						$(html).appendTo(box.$_parent.find('table>tbody'));
						
						if ($('#no_exists').length)
						{
							$('#no_exists').remove();
						}

						box.hide();
					} else { //失败
						alert('发生错误，添加失败');
					}
				} else {
					if (ret.errno == 0)
					{
						if (!target)
						{
							return;
						}
						var $td = $(target).closest('TR').find('TD');
						$td.eq(0).text(title);
						$td.eq(1).html('<a target="_blank" href="'+link+'">'+link+'</a>');
						box.hide();
					} else {
						alert('发生错误，修改失败');
					}
				}
				target = null;
			}
		});
	});

	$('div.personal-extend').click(function(e) {
		var $target = $(e.target);
		var rel = $target.attr('rel');

		if (!rel)
		{
			return;
		} else {
			var tmp = rel.split(':');
			var op = tmp[0];
			var v = tmp[1] || '';
		}

		target = e.target;

		switch (op)
		{
		case 
			'add':
			mode = 'add';
			link_id = '';
			$.each(errNodes, function(i, o) {
				o.addClass('hidden');
			});
			box.setTitle('添加新的推广信息').set().show();
			break;

		case 'mod':
			mode = 'mod';
			link_id = v;
			var $tr = $target.closest('TR');
			var $td = $tr.find('TD');

			box.setTitle('编辑新的推广信息')
			.set($td.eq(0).text(), $td.eq(1).text())
			.show();

			break;

		case 'del':
			var $tr = $target.closest('TR');
			if (confirm('确定要删除这条信息吗？'))
			{
				$.ajax({
					url: "<?php echo URL('mgr/plugins.save', array('id' => 3));?>",
					data: {
						link_id: v,
						op: 'del'
					},
					type: 'post',
					dataType: 'json',
					success: function(ret) {
						if (ret.rst)
						{
							$tr.remove();
						} else {
							alert('删除失败');
						}
					}
				});
			}
			target = null;
			break;
		
		}
	});

});
</script>
</head>
<body>
<div class="main-wrap">
	<div class="path"><span class="path-icon"></span>当前位置：组件管理<span> &gt; </span>插件设置<span> &gt; </span>个人资料推广位</div>
    <div class="set-wrap">
		<div class="personal-extend">
			<h4 class="main-title"><a class="add-extend" rel="add" href="javascript:;"></a>推广信息列表</h4>
			<div class="set-area-int">
        		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-border">
					<colgroup>
                        <col class="extend-con" />
    					<col />
    					<col class="operate-w2" />
    				</colgroup>
                    <thead class="td-title-bg">
					<tr>
   					  	<td>推广信息内容</td>
   					  	<td>链接</td>
   					  	<td>操作</td>
				  	</tr>
              		</thead>
                	<tbody>
<?php 
	if (empty($list)) {
?>
                    <tr id="no_exists">
   					  	<td class="extend-tacit" colspan="3">还没有记录哦，请<a href="#" rel="add">点击添加</a></td>
				  	 </tr>
<?php
	} else {
		foreach ($list as $row) {
?>
                    <tr>
   					  	<td><?php echo F('escape', $row['title']);?></td>
   					  	<td><a href="<?php echo F('escape', $row['link']);?>" target="_blank"><?php echo F('escape', $row['link']);?></a></td>
						<td><a href="javascript:;" title="编辑" class="change-icon" rel="mod:<?php echo $row['link_id'];?>">编辑</a><a rel="del:<?php echo $row['link_id'];?>" href="javascript:;" title="删除" class="del-icon">删除</a></td>
					</tr>
<?php
		}
	} 
?>
					</tbody>
				</table>
                <a class="return" href="<?php echo URL('mgr/components');?>">返回组件列表</a>
    		</div>
		</div>
    </div>
</div>
<div id="pop_mask" class="mask hidden"></div>
</body>
</html>
