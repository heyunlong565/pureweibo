<?php
/**************************************************
*  Created:  2011-03-10
*
*  API接口交互类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author guanghui <guanghui1@staff.sina.com.cn>
*
***************************************************/
class wbcom_mod extends action
{
	function wbcom_mod()
	{
		parent::action();
	}
	
	/**
	* 自动截断字符串
	* 
	* @param string $content  字符串
	* @param int $len 需要的长度
	*/
	function _autoCut($content, $len = 140)
	{
		$len *= 2;
		$text = $content;
		if ($this->_getFixStrlen($content) > $len) {
			$text = '';
			$mb_len = mb_strlen($content, 'UTF-8');
			for ($i = 0; $i < $mb_len; $i++) {
				$char = mb_substr($content, $i, 1, 'UTF-8');
				
				if ($this->_getFixStrlen($text . $char) <= $len) {
					$text .= $char;
				} else {
					break;
				}
			}
		}
		
		return $text;
	}
	
	/**
	* 返回字符串占位长度
	* 一个中文字符的占位是2，英文字符是1
	* 
	* @param mixed $str
	*/
	function _getFixStrlen($str)
	{
		return (strlen($str) + mb_strlen($str, 'UTF-8')) / 2;
	}
	
	/**
	* 发表微博页面
	* 
	*/
	function sendWBFrm()
	{
		$this->_display('send_weibo');
	}
	
	/**
	* 发表新微博
	* 
	*/
	function postWB()
	{
		$content = trim(V('p:content', ''));
		$len = strlen($content);
		if ($len == 0) {
			$this->_showErr('请输入微博内容', $this->_getBackURL());
		}
		
		$contentLen = $this->_getFixStrlen($content);
		
		//420字限制
		if ($contentLen > 840) {
			$this->_showErr('不能超过420个字', $this->_getBackURL());
		}
		
		if ($contentLen > 280) {
			//将内容组成微博数组
			$j =  0;
			$wbArr = array(0 => ''); //微博数组
			$mb_len = mb_strlen($content, 'utf-8');
			for ($i = 0; $i < $mb_len; $i++) {
				$char = mb_substr($content, $i, 1, 'utf-8');

				if ($this->_getFixStrlen($wbArr[$j] . $char) > 280) {
					$j++;
					$wbArr[$j] = '';
				}
				
				$wbArr[$j] .= $char;
			}
		} else {
			$wbArr = array(0 => $content); //微博数组
		}
		
		foreach ($wbArr as $wb) {
			DR('xweibo/xwb.update', '', $wb);
			sleep(1);
		}
		
		$this->_showErr('发表成功，立即返回前一页', $this->_getBackURL());
	}
	
	/**
	* 转发微博
	* 
	*/
	function reposWB()
	{
		$content = trim(V('p:content'));
		$mid = V('p:mid');
		$is_com = V('p:is_com', false);
		$is_comment = $is_com ? 1 : 0;  //是否同时评论
		
		if (empty($mid)) {
			APP::redirect('index', 2);
		}
		
		if ($content !== '') {
			$content = $this->_autoCut($content, 140);
		}
		
		$result = DR('xweibo/xwb.repost', '', $mid, $content, $is_comment);
		if (!empty($result['errno'])) {
			$this->_showErr('转发失败，请重试', URL('show.repos', 'id=' . $mid));
		}
		
		APP::redirect('index', 2);
	}
	
	/**
	* 发表评论
	* 
	*/
	function comment()
	{
		$content = trim(V('p:content'));
		$mid = V('p:mid');
		$is_repos = V('p:is_repos', false);
		$is_repos = $is_repos ? 1 : 0;  //是否同时转发
		
		if (empty($mid)) {
			APP::redirect('index', 2);
		}
		
		if ($content === '') {
			$this->_showErr('评论内容不能为空', $this->_getBackURL());
		}
		
		$content = $this->_autoCut($content);
		
		if ($is_repos) {
			$result = DR('xweibo/xwb.repost', '', $mid, $content, $is_repos); //评论并转发
		} else {
			$result = DR('xweibo/xwb.comment', '', $mid, $content);  //评论
		}
		
		if (!empty($result['errno'])) {
			$this->_showErr('评论失败，请重试', $this->_getBackURL());
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 加关注
	* 
	*/
	function addFollow()
	{
		$id = V('g:id', 0);
		if (!empty($id)) {
			$rt = DR('xweibo/xwb.createFriendship', '', $id);
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 取消关注或移除粉丝
	* 
	*/
	function deleteFriendship()
	{
		$user_id = V('g:id');
		$is_follower = V('g:is_follower');
		
		if (!empty($user_id)) {
			DR('xweibo/xwb.deleteFriendship', '', $user_id, '', $is_follower);
		}

		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 显示解除关注提示
	* 
	*/
	function cancelFollowAlert()
	{
		$id = V('g:id');
		if (empty($id)) {
			APP::redirect('index', 2);
		}
		
		TPL::assign('title', '取消关注');
		TPL::assign('msg', '确定要取消对此人的关注吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.deleteFriendship', 'id=' . $id . '&is_follower=0'));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 显示解除粉丝提示
	* 
	*/
	function cancelFanAlert()
	{
		$id = V('g:id');
		if (empty($id)) {
			APP::redirect('index', 2);
		}
		
		TPL::assign('title', '解除粉丝');
		TPL::assign('msg', '确定要解除此人对你的关注吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.deleteFriendship', 'id=' . $id . '&is_follower=1'));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 添加收藏
	* 
	*/
	function addFav()
	{
		$mid = V('g:mid');
		if (empty($mid)) {
			$this->_showErr('参数错误', $this->_getBackURL());
		}
		
		$result = DR('xweibo/xwb.createFavorite', '', $mid);
		if (!empty($result['errno'])) {
			$this->_showErr('添加收藏失败', $this->_getBackURL());
		} else {
			$this->_showErr('添加收藏成功', URL('index.favorites'));
		}
	}
	
	/**
	* 取消收藏警告页面
	* 
	*/
	function delFavAlert()
	{
		$mid = V('g:mid');
		
		TPL::assign('title', '取消收藏');
		TPL::assign('msg', '确定要取消对此微博的收藏吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.delfav', 'mid=' . $mid));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 取消收藏
	* 
	*/
	function delfav()
	{
		$mid = V('g:mid');
		if (!empty($mid)) {
			DR('xweibo/xwb.deleteFavorite', '', $mid);
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 删除微博警告页面
	* 
	*/
	function delWBAlert()
	{
		$mid = V('g:mid');
		
		TPL::assign('title', '删除微博');
		TPL::assign('msg', '确定要删除这条微博吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.delWB', 'mid=' . $mid));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 删除微博
	* 
	*/
	function delWB()
	{
		$mid = V('g:mid');
		if (!empty($mid)) {
			DS('xweibo/xwb.destroy', '', $mid);
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 删除评论警告页面
	* 
	*/
	function delCommentAlert()
	{
		$cid = V('g:cid');
		
		TPL::assign('title', '删除评论');
		TPL::assign('msg', '确定要删除这条评论吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.delComment', 'cid=' . $cid));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 删除评论
	* 
	*/
	function delComment()
	{
		$cid = V('g:cid');
		if (!empty($cid)) {
			DR('xweibo/xwb.commentDestroy', '', $cid);
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
	
	/**
	* 回复评论页面
	* 
	*/
	function replyComment()
	{
		$mid = V('g:mid');
		$cid = V('g:cid');
		$reply_user = V('g:reply_user');
		
		if (empty($mid) || empty($cid) || empty($reply_user)) {
			$this->_showErr('参数错误', $this->_getBackURL());
		}
		
		TPL::assign('backURL', $this->_getBackURL(true));
		TPL::assign('mid', $mid);
		TPL::assign('cid', $cid);
		TPL::assign('reply_user', $reply_user);
		$this->_display('reply_comment');
	}
	
	/**
	* 回复评论
	* 
	*/
	function sendReplyComment()
	{
		$mid = V('p:mid');
		$cid = V('p:cid');
		$reply_user = V('p:reply_user');
		$content = trim(V('p:content'));
		
		if (empty($mid) || empty($cid) || empty($reply_user)) {
			$this->_showErr('参数错误', $this->_getBackURL());
		}
		
		if (empty($content)) {
			$this->_showErr('回复内容不能为空', URL('wbcom.replyComment', array('mid' => $mid, 'cid' => $cid, 'reply_user' => $reply_user)));
		}
		
		$reply_str = '回复@' . $reply_user . ':';
		$content = $this->_autoCut($content, (140 - ceil($this->_getFixStrlen($reply_str) / 2)));
		
		$rp_rst = DR('xweibo/xwb.reply', '', $mid, $cid, $content);
		
		$rt = V('p:rt');
		if (empty($rp_rst['errno']) && $rt) {
			DR('xweibo/xwb.repost', '', $mid, $content);
		}
		
		if (!empty($rp_rst['errno'])) {
			if ($rp_rst['errno'] == '1020504') {
				$this->_showErr('原微博已被作者删除，不可再对其进行评论回复', $this->_getBackURL());
			}
			
			if ($rp_rst['errno'] == '1020503') {
				$this->_showErr('回复评论失败，因为内容长度超出了限制', URL('wbcom.replyComment', array('mid' => $mid, 'cid' => $cid, 'reply_user' => $reply_user)));
			}
			
			$this->_showErr('回复评论失败, 请重试', URL('wbcom.replyComment', array('mid' => $mid, 'cid' => $cid, 'reply_user' => $reply_user)));
		} else {
			$this->_showErr('回复成功', $this->_getBackURL());
		}
	}
	
	/**
	* 查看原图
	* 
	*/
	function viewPhoto()
	{
		$id = V('g:id', 0);
		$v = V('g:v', 1);  //显示原图或缩略图
		
		if (!USER::isUserLogin()) {
			DS('xweibo/xwb.setToken', '', 2);
		}
		
		$mblog_info = DR('xweibo/xwb.getStatuseShow', '', $id);
		
		if ($mblog_info['errno']) {
			$this->_showErr('您要访问的页面不存在', URL('pub'));
		}

		//检查微博或用户是否被屏蔽
		$wb = F('weibo_filter', $mblog_info['rst'], true);
		
		if (empty($wb) || !isset($wb['bmiddle_pic'])) {
			$this->_showErr('您要访问的页面不存在', URL('pub'));
		}
		
		TPL::assign('vp', $v);
		TPL::assign('id', $id);
		TPL::assign('image', $v ? $wb['bmiddle_pic'] : $wb['thumbnail_pic']);
		TPL::assign('backURL', $this->_getBackURL(true));
		$this->_display('view_photo');
	}
	
	/**
	* 保存个人资料
	* 
	*/
	function saveInfo()
	{
		$nick = trim(V('p:nick', ''));
		
		if ($nick === '') {
			$this->_showErr('昵称不能为空', URL('index.setinfo'));
		}
		
		$nickFixLen = $this->_getFixStrlen($nick);
		if ($nickFixLen > 10) {
			$this->_showErr('昵称不能超过20个字母或10个汉字', URL('index.setinfo'));
		}
		
		if ($nickFixLen < 2) {
			$this->_showErr('昵称不能少于4个字母或2个汉字', URL('index.setinfo'));
		}
		
		$gender = V('p:gender');
		$description = trim(V('p:description'));
		
		$updata = array('name' => $nick,
						'gender' => $gender,
						'description' => $description);
		
		$rst = DR('xweibo/xwb.updateProfile', '', $updata);
		
		if (!empty($rst['errno'])) {
			if ($rst['errno'] == '1020104') {
				$this->_showErr('简介不能超过70个字', URL('index.setinfo'));
			}
			
			if ($rst['errno'] == '1021301') {
				$this->_showErr('昵称重复，请使用其它昵称', URL('index.setinfo'));
			}
			
			$this->_showErr('修改失败', URL('index.setinfo'));
		}
		
		DD('xweibo/xwb.getUserShow');
		APP::redirect('index', 2);
	}
	
	/**
	* 保存显示配置项
	* 
	*/
	function saveDisplayset()
	{
		$values = V('-:userConfig');
		$values['wap_font_size'] = (int)V('p:wap_font_size', 1);
		$values['wap_show_pic'] = (int)V('p:wap_show_pic', 1);
		$values['wap_page_wb'] = (int)V('p:wap_page_wb', 10);
		
		DR('common/userConfig.set', '', $values);
		APP::redirect('index', 2);
	}
	
	/**
	* 发送私信页面
	* 
	*/
	function sendMsgFrm()
	{
		$rid = V('g:rid', 0);
		$rname = trim(V('g:rname', ''));
		$st = V('g:st', 1); //来源页 1我的私信 2我的粉丝
		$backLink = ($st == 1 ? '<a href="' . $this->_getBackURL(true) . '">返回我的私信</a>' : '<a href="' . $this->_getBackURL(true) . '">返回我的粉丝</a>');
		
		TPL::assign('rid', $rid);
		TPL::assign('rname', $rname);
		TPL::assign('backLink', $backLink);
		
		$this->_display('send_message');
	}
	
	/**
	* 发送私信
	* 
	*/
	function sendMsg()
	{
		$id = V('p:rid', 0);
		$name = trim(V('p:nick', ''));
		$text = trim(V('p:content', ''));
		
		if ($text === '') {
			$this->_showErr('请输入私信内容', URL('index.message'));
		}
		
		$text = $this->_autoCut($text, 140);
		if (empty($id)) {
			if (empty($name)) {
				$this->_showErr('请输入粉丝姓名', URL('index.message'));
			}
			
			$id = $name;
		}
		
		$rst = DR('xweibo/xwb.sendDirectMessage', '', $id, $text, $name);
		
		if (!empty($rst['errno'])) {
			if ($rst['errno'] == '1020902') {
				$this->_showErr('发送失败, 他还没有关注你，暂时不能发私信给他哦！', URL('index.message'));
			}
			
			$this->_showErr('发送失败', URL('index.message'));
		}
		
		APP::redirect('index.message', 2);
	}
	
	/**
	* 删除私信警告页面
	* 
	*/
	function delMsgAlert()
	{
		$id = V('g:id');
		
		TPL::assign('title', '删除私信');
		TPL::assign('msg', '确定要删除这条私信吗?');
		TPL::assign('confirmURL', WAP_URL('wbcom.delMsg', 'id=' . $id));
		TPL::assign('backURL', $this->_getBackURL(true));
		
		$this->_display('confirm');
	}
	
	/**
	* 删除一条私信
	* 
	*/
	function delMsg()
	{
		$id = V('g:id');
		if (!empty($id)) {
			$rst = DR('xweibo/xwb.deleteDirectMessage', '', $id);
			if (!empty($rst['errno'])) {
				$this->_showErr('删除失败', $this->_getBackURL());
			}
			/// 删除私信缓存
			DD('xweibo/xwb.getDirectMessages');
		}
		
		APP::redirect($this->_getBackURL(), 3);
	}
}
