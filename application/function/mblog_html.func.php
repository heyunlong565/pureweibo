<?php
/**************************************************
*  Created:  2010-06-08
*
*  微博内容的html结构
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/

/**
 * mblog html
 *
 * @param string $time 发微博的时间
 * @return string
 */
function mblog_html($result, $counts = null, $type = 'repost', $add = false)
{
	$comments = false;
	if ($type == 'repost') {
		//转发数
		$rts = $counts[0]['rt'] + 1;
		if ($add) {
			//评论数
			$comments = $counts[0]['comments'] + 1;
		}
	} elseif ($type == 'comment') {
		//评论数
		$comments = $counts[0]['comments'] + 1;
		if ($add) {
			//转发数
			$rts = $counts[0]['rt'] + 1;
		}
	}

	$html = '';
		$html .= '<li rel="w:'.$result['id'].'">';
		$html .= '<div class="user-pic">';
		$html .= '<a href="'.URL('ta',array('id' => $result['user']['id'])).'"><img src="'.APP::F('profile_image_url', $result['user']['profile_image_url']).'" alt="'.htmlspecialchars($result['user']['screen_name']).'" title="'. htmlspecialchars($result['user']['screen_name']).'" /></a>';
	    $html .= '</div>';
	    $html .= '<div class="feed-content">';
		$html .= '<p class="feed-main">';
		if (APP::F('filter', $result['user']['screen_name'], 'verify') == true) {
			$v_style = 'class="v-icon icon-bg"';
		} else {
			$v_style = '';
		}
		$html .= '<a '.$v_style.' href="'.URL('ta',array('id' => $result['user']['id'])).'" title="'.htmlspecialchars($result['user']['screen_name']).'">';
		$html .= '我</a>：'.APP::F('format_text', $result['text']).'</p>';
		if (isset($result['thumbnail_pic'])) {
			$html .= '<div class="preview-img">';
			$html .= '<div class="feed-img"><img class="zoom-move" src="'.$result['thumbnail_pic'].'" rel=4 alt="" /></div>';
			$html .= '</div>';
		}

		//转发部分html结构
		if (isset($result['retweeted_status'])) {
			$html .= '<div class="box-style">';
			$html .= '<div class="box-t skin-bg"><span class="skin-bg"></span></div>';
			$html .= '<div class="forward box-content showbox-f">';
			if (APP::F('filter', $result['retweeted_status']['user']['screen_name'], 'verify') == true) {
				$rt_v_style = 'class="v-icon icon-bg"';
			} else {
				$rt_v_style = '';
			}
			$html .= '<p><a '.$rt_v_style.' href="'.URL('ta',array('id' => $result['retweeted_status']['user']['id'])).'">@'.htmlspecialchars($result['retweeted_status']['user']['screen_name']).'</a>：'.APP::F('format_text', $result['retweeted_status']['text']).'<span><a href="'.URL('show',array('id' => $result['retweeted_status']['id'])).'">原文转发';
			if ($rts > 0) {
				$html .= '('.$rts.')';
			}
			$html .= '</a>|';
			$html .= '<a href="'.URL('show',array('id' => $result['retweeted_status']['id'])).'">原文评论';
			if ($comments > 0) {
				$html .= '('.$comments.')';
			}
			$html .= '</a></span></p>';
			if (isset($result['retweeted_status']['thumbnail_pic'])) {
				$html .= '<div class="preview-img">';
				$html .= '<div class="feed-img"><img src="'.$result['retweeted_status']['thumbnail_pic'].'" rel=12 alt="" /></div>';
				$html .= '</div>';
			}
			$html .= '</div>';
			$html .= '<div class="box-b skin-bg"><span class="skin-bg"></span></div>';
			$html .= '<span class="box-arrow skin-bg"></span>';
			$html .= '</div>';
		}
		//end 转发部分html结构

		$html .= '<div class="feed-info"><p>';
		$html .= '<a href="#" rel="e:dl">删除</a>';
		$html .= '<a href="#" rel="e:fw">转发</a>|';
		$html .= '<a href="#" rel="e:fr">收藏</a>|';
		$html .= '<a href="#" rel="e:cm">评论</a></p>';
		$html .= '<span><a href="'.URL('show',array('id' => $result['id'])).'">'.APP::F('format_time', $result['created_at']).'</a> 来自 '.$result['source'].'</span>';
		$html .='</div></div></li>';
		return $html;
}
