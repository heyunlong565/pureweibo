<?php
/**************************************************
*  Created:  2010-11-18
*
*  用户、微博、回复过滤
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author zhenquan <zhenquan@staff.sina.com.cn>
*
***************************************************/

require_once  APP::functionFile('get_filter_cache');
class filter{
	var $cfg = array(
				'sub_filter' => true,//是否过滤最后回复、发表、转发
				'only_chk_verify' => false // 是否只检查是否通过认证
				);

	/**
	 * 得到过滤器要使用的数据
	 * @param $index 要得到的数据类型
	 * @return array
	 */
	function getFilterData($index = null) {
		static $data = null;
		if ($data === null) {
			$data = array(
						'user_verify' => get_filter_cache('user_verify'),
						'weibo' => get_filter_cache('weibo'),
						'comment' => get_filter_cache('comment'),
						'content' => get_filter_cache('content'),
						'nick' => get_filter_cache('nick')
						);
		}
		if ($index !== null && isset($data[$index])) {
			return $data[$index];
		}
		return $data;
	}

	/**
	 * 设置配置项
	 * @param $index 配置项下标
	 * @param $value 配置项的值
	 */
	function setConfig($index, $value = null) {
		if (is_array($index)) {
			$this->cfg = array_merge($this->cfg, $index);
		} else {
			$this->cfg[$index] = $value;
		}
	}
	/**
	 * 过滤单条用户数据
	 * @param $data array 单条用户数据
	 * @return array
	 */
	function user($data) {
		if (!is_array($data)) {
			return false;
		}
		if (!(isset($data['id']) && isset($data['screen_name']) && isset($data['description']))) {
			$data['filter_state'] = 1; //要过滤的数据不完整
			return $data;
		}

		$f_verify = $this->getFilterData('user_verify');
		if (isset($f_verify[(string)$data['id']])) {
			$data['site_v'] = 1;
		} else {
			$data['site_v'] = 0;
		}

		$f_nick = $this->getFilterData('nick');
		if (isset($f_nick[(string)$data['id']])) {
			$data['filter_state'] = 2; // 用户已被屏蔽
			return $data;
		}
		// 过滤最后发布的微博
		if ($this->cfg['sub_filter'] && isset($data['status'])) {
			if (!(isset($data['status']['id']) && isset($data['status']['text']))) {
				$data['filter_state'] = 11;// 要过滤的数据不完整
				return $data;
			}
			$f_weibo = $this->getFilterData('weibo');
			$f_content = $this->getFilterData('content');
			if (isset($data['status']['retweeted_status'])) {
				$d = $data['status']['retweeted_status'];
				if (!(isset($d['id']) && isset($d['text']) && isset($d['user']) && isset($d['user']['id']))) {
					$data['filter_state'] = 111;
				}
				if (isset($f_weibo[(string)$d['id']])) {
					$data['filter_state'] = 113;
					return $data;
				}
				if (isset($f_nick[(string)$d['user']['id']])) {
					$data['filter_state'] = 112;
					return $data;
				}
				do {
					$f = key($f_content);
					if (strpos($d['text'], $f) > -1) {
						$data['filter_state'] = 114;// 最后发表的微博包含有关键字
						return $data;
					}
				} while(next($f_content));

			}
			if (isset($f_weibo[$data['status']['id']])) {
				$data['filter_state'] = 13; // 最后发表的微博被屏蔽
				return $data;
			}

			reset($f_content);
			do {
				$k = key($f_content);
				if (strpos($data['status']['text'], $k) > -1) {
					$data['filter_state'] = 14;
					//$this->setError( array('error' => '最后发表的微博包含有关键字:'. $k, $data));
					return $data;
				}
			} while(next($f_content));
		}
		return $data;
	}

	/**
	 * 批量过滤用户
	 * @param $data array 要过滤的数据
	 * @return array
	 */
	function users($data) {
		$after = array();
		$count = count($data);
		for ($i=0; $i<$count; $i++) {
			$after[] = $this->user($data[$i]);
		}
		$this->logNew = true;
		return $after;
	}

	/**
	 * 过滤微博或回复
	 * @param $data array 要过滤的数据
	 * @return array
	 */
	function weibo($data) {
		if (!is_array($data)) {
			return false;
		}
		if (!(isset($data['id']) && isset($data['text']) && isset($data['user']) && isset($data['user']['id']))) {
			//$this->addError(array('error'=>'要过滤的数据不完整', 'data'=>$data));
			$data['filter_state'] = 1;
			return array();
		}
		if ($this->cfg['sub_filter']) {
			if (isset($data['retweeted_status'])) {
				$d = $data['retweeted_status'];
			}
			if (isset($data['status'])) {
				$d = $data['status'];
			}
			if (isset($d) && !(isset($d['id']) && isset($d['text']) && isset($d['user']) && isset($d['user']['id']))) {
				$data['filter_state'] = 11;
				return $data;
			}
		}

		$f_weibo = $this->getFilterData('weibo');
		$f_nick = $this->getFilterData('nick');
		$f_verify = $this->getFilterData('user_verify');
		if (isset($f_verify[$data['user']['id']])) {
			$data['user']['site_v'] = 1;
		} else {
			$data['user']['site_v'] = 0;
		}

		if (!$this->cfg['only_chk_verify']) {
			if (!isset($data['status'])) {
				if (isset($f_weibo[(string)$data['id']])) {
					$data['filter_state'] = 3;// 该微博被屏蔽
					return $data;
				}
			} else {
				$f_comment = $this->getFilterData('comment');
				if (isset($f_comment[(string)$data['id']])) {
					$data['filter_state'] = 3;// 该回复被屏蔽
					return $data;
				}
			}

			if (isset($f_nick[(string)$data['user']['id']])) {
				$data['filter_state'] = 2; // 用户被屏蔽
				return $data;
			}

			$f_content = $this->getFilterData('content');
			reset($f_content);
			do {
				$f = key($f_content);
				if (strpos($data['text'], $f) > -1) {
					//$this->addError(array('error'=>'内容包含有关键字:' . $k, 'data'=>$data));
					$data['filter_state'] = 4;
					return $data;
				}
			} while(next($f_content));
		} // end if

		// 处理子内容
		if ($this->cfg['sub_filter']) {
			if (isset($data['retweeted_status'])) {
				$d = &$data['retweeted_status'];
			}
			if (isset($data['status'])) {
				$d = &$data['status'];
			}
			if (isset($d)) {
				if (isset($f_verify[(string)$d['user']['id']])) {
					$d['user']['site_v'] = 1;
				} else {
					$d['user']['site_v'] = 0;
				}
				if ($this->cfg['only_chk_verify']) {
					return $data;
				}
				if (isset($f_weibo[(string)$d['id']])) {
					$data['filter_state'] = 13;
					return $data;
				}

				if (isset($f_nick[(string)$d['user']['id']])) {
					$data['filter_state'] = 12;
					return $data;
				}

				reset($f_content);
				do {
					$f = key($f_content);
					if (strpos($d['text'], $f) > -1) {
						$data['filter_state'] = 14;// 内容包含有关键字
						return $data;
					}
				} while(next($f_content));

			}
		}
		return $data;
	}

	/**
	 * 批量过滤微博
	 * @param $data array
	 * @return array
	 */
	function weibos($data) {
		$count = count($data);
		$after = array();
		for ($i=0; $i< $count; $i++) {
			$after[] = $this->weibo($data[$i]);
		}
		return $after;
	}
}
