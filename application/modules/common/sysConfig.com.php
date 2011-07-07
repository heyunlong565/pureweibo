<?php
/**************************************************
*  Created:  2010-10-28
*
*  网站自定义配置项管理类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
***************************************************/
class sysConfig {

	///初始值 
	var $options = array(   
							'rewrite_enable' => '',		//Rewrite设置 0.不开启 1.开启
							'logo' => '',				//logo图标
							'address_icon' => '',		//网站地址图标			
							'login_way' => '',			//登录方式 1.仅使用新浪帐号直接登录 2.仅使用原有站点帐号登录 3. 使用新浪帐号与原有站点帐号并存方式登录
							'third_code' => '',			//网站第三方统计代码
							'site_record' => '',		//网站备案信息代码
							'site_name' => '',			//网站名称
							'head_link' => '',			//页首链接
							'foot_link' => '',			//页尾链接
							'default_skin'=>'',			//默认皮肤
							'authen_enable'=>'',		//用户认证方式 1.使用站点特定的认证 0.使用新浪名人认证
							'authen_big_icon'=>'',		//站点认证大图标
							'authen_small_icon'=>'',	//站点认证小图标
							'authen_small_icon_title' => '', //站点认证小图标提示文字
							'skin_default'=>'',			//默认皮肤设置
							'ad_header' => '', //header广告代码
							'ad_footer' => '', //footer广告代码
							'guide_auto_follow' => '0', //登录引导自动关注开关
							'guide_auto_follow_id' => '', //自动关注的用户列表ID
							'wb_version' => ''	//当前xweibo版本号
						);	


	/**
	 * 保存用户配置信息
	 * @return bool|null
	 */
	function set(){
		
        $args = func_get_args();
		if (!isset($this->options[$args[0]])) {
			return RST(false, '2110001', 'Set the option does not exist');
		}
		
		///删除缓存
		DD('common/sysConfig.get');
		$db = APP::ADP('db');
		$data[] = '("' . $db->escape($args[0]) . '","' . $db->escape($args[1]) .'")';

		$sql = 'REPLACE ' . $db->getTable(T_SYS_CONFIG) . '(`key`,`value`) VALUES' . implode(',', $data);

        return RST($db->execute($sql));

	}

	/**
	 * 获取网站自定义配置信息
	 *
	 * @param string $key 如:rewrite_enable
	 * $key为空时取全部配置信息
	 * @return bool|null
	 */
	function get($key = null)
	{
		$db = APP :: ADP('db');
		$row = $db->query('SELECT * FROM ' . $db->getTable(T_SYS_CONFIG));

        foreach($row as $value) {
             $rs[$value['key']] = $value['value'];
        }
                
		if ($key) {
			$kvalue = isset($rs[$key]) ? $rs[$key] : false;
			return RST($kvalue);	
		}
		return RST($rs);
	}
}
?>