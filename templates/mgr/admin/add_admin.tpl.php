<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加管理员用户 - 帐号管理</title>
<link href="<?php echo W_BASE_URL;?>css/admin/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo W_BASE_URL;?>js/admin-all.js"></script>
<script type="text/javascript">
var HtmlDemo=[ '<form id="pwdForm" action="<?php echo URL('mgr/admin.add');?>" method="post">',
            	'	<div class="pop-form">',
            	'		<div class="form-row">',
            	'			<label for="add-initial-password">密码</label>',
            	'			<div class="form-cont">',
            	'				<input name="pwd" class="input-txt" vrel="_f|ne|sz=min:6,max:16,m:长度为6-16位|pw" type="password" value="" warntip="#nameTip" /><span class="tips-error hidden" id="nameTip"></span>',
				'       	<p class="form-tips">由6-16位的数字、字母、半角 "." "-" "?" 和下划线组成</p>',
            	'			</div>',
            	'		</div>',
                '    	<div class="btn-area">',
				'			<input name="uid" type="hidden" id="uid" value=""/>',
				'			<a href="#" class="general-btn btn-s2" id="pop_ok"><span>确定</span></a>',
				'			<a href="#" class="general-btn" id="pop_cancel"><span>取消</span></a>',
                '    	</div>',
                '    </div>',
              '</form>'].join('');

	function add(id) {
		Xwb.use('MgrDlg',{
			modeHtml:HtmlDemo,
			formMode:true,
			valcfg:{
				form:'#pwdForm',
				trigger:'#pop_ok',
				validators : {
				 'pw': function(elem, v, data, next){
						    var reg = /^[a-zA-Z-0-9\.\-_\?]+$/;
						    if(v){
						    	if(!data.m && data.m !== 0)
						        	data.m = '非法字符';
						    	this.report(reg.test(v), data);
						    } else this.report(true, data);
						    next();
				 }
				}
			},
			dlgcfg:{
				cs:'add-admin win-fixed',
				onViewReady:function(View){
					var self=this;
					$(View).find('#pop_cancel').click(function(){
						self.close();
					})
				},
				destroyOnClose:true,
				title:'添加管理员'
			},
			afterDisplay:function(){
					this.dlg.jq("#uid").val(id);
			}
		})
	}
</script>
</head>
<body class="main-body">
	<div class="path"><p>当前位置：系统设置<span>&gt;</span>添加管理员</p></div>
    <div class="main-cont">
        <h3 class="title">添加管理员</h3>
		<div class="set-area">
        	<p class="tips-desc">请输入昵称搜索用户，然后选择相应的添加操作。</p>
        	<div class="operate-cont">
				<div class="form-s2">
                	<form action="" method="post" id="SearchFrom">
                    	<div class="item">
                        	<label><strong>搜索包含以下昵称的用户</strong></label>
                            <input name="keyword" class="ipt-txt form-el-w200" type="text" />
                            <a href="javascript:$('#SearchFrom').submit();" class="general-btn"><span>搜索</span></a>
                        </div>
                    </form>
           		</div>
            </div>
        
            <?php if($this->_isPost() && !V('r:keyword', false)):?>
                <div class="search-results-no">请输入昵称</div>
            <?php elseif(!V('r:keyword', false)):?>

            <?php elseif(isset($list)):?>
              <ul class="search-results">
                <?php $i=1;foreach($list as $value):?>
                <?php if($i==1):$i++;?><li class="first"><?php else:?><li class="result-line"><?php endif;?>
                    <div class="results-l">
                        <p class="results-name"><?php echo $value['nickname'];?></p>
                        <p><span><?php echo $value['userinfo']['location'];?></span><span>粉丝数：<?php echo $value['userinfo']['followers_count'];?>人</span></p>
                    </div>
                    <div class="results-r">
                        <a href="javascript:add('<?php echo $value['sina_uid'];?>')" >添加管理员权限</a>
                    </div>
                </li>
                <?php endforeach;?>
              </ul>
            <?php else:?>
                 <div class="search-results-no">该用户不存在或者未开通本站微博</div>
            <?php endif;?>
            
    	</div>
    </div>

</body>
</html>
