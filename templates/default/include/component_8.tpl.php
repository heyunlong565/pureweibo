<?php
		
	$clientIp = F('get_client_ip');
//	$clientIp = '121.14.1.158';

	$province_id = V('g:province', '');
	$city_id = V('g:city', '');

	
	$province = $city = '';
	$citys = '';

	$ret = DR('xweibo/xwb.getProvinces', '86400');
	if ($ret['errno']) {
		return;
	}

	$result = &$ret['rst'];
	
	if ($result && isset($result['provinces']) && !empty($result['provinces'])) {
		$provinces = &$result['provinces'];

		if (!($province_id || $city_id)) {		
			$cityInfo = F('http_get_contents',"http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip=$clientIp&charset=utf-8&format=json");
			$info = @json_decode($cityInfo, true);
			
			if (empty($info['province']) || empty($info['city'])) {
			//default
				$info['province'] = '北京';
				$info['city'] = '东城区';
			}
			
//			if ($info && ($info['ret'] != -1)) {
				foreach ($provinces as $p) {
					if ($p['name'] == $info['province']) {
						$province_id = $p['id'];
						$province = $p['name'];

						$citys = &$p['citys'];

						foreach ($citys as $ct) {
							if (current($ct) == $info['city']) {
								$city  = $info['city'];
								$city_id = key($ct);
								break;
							}
						}

						break;
					}
				}
//			}

		} else {
			foreach ($provinces as $p) {
				if ($p['id'] == $province_id) {
					$citys = &$p['citys'];
					$province = $p['name'];

					foreach ($citys as $ct) {
						if ($city_id == key($ct)) {
							$city = current($ct);	
						}
					}

					break;
				}
			}
		}
	}
?>
<div class="pub-feed-list" id="cityWb">
    <div class="column-title">
        <div class="change-city">
        	<p class="city"><?php if ($province && $city):?><span><?php echo F('escape', $province.','.$city);?></span><?php if (!empty($citys)):?>[<a href="#" name="city" id="cityBtn">切换城市</a>]<?php endif;?><?php endif;?></p>
		<?php if (!empty($citys)):?>
			<div class="win-pop win-city hidden" id="win_city">
                <div class="win-t"><div></div></div>
                <div class="win-con">
                    <div class="win-con-in">
						<div class="select-area">
							<label for="sel-city">请选择地区：</label>
							<select name="" id="sel-area">
							<?php
foreach($provinces as $p) {
	echo '<option value="'.$p['id'].'"'.($province_id==$p['id']?' selected':'').'>'.$p['name'].'</option>';
}
							?>
							</select>
						</div>
                        <div class="win-box" id="citys">
						<?php foreach($citys as $ct):?>
                            <a href="<?php echo URL('pub', array('province' => $province_id, 'city' => key($ct)));?>#city"><?php echo F('escape', current($ct));?></a>
						<?php endforeach;?>
                        </div>
                    </div>
                    <div class="win-con-bg"></div>
                </div>
                <div class="win-b"><div></div></div>
                <div class="arrow all-bg"></div>
                <a href="#" class="icon-close-btn icon-bg" id="xwb_cls"></a>
            </div>
		<?php endif;?>
        </div>
        <h3><?php echo F('escape', $mod['title']);?></h3>
    </div>
	<div class="feed-list">
		<?php	
            //同城微博
            $ret = DR('components/cityWB.get', 'g/60', $province_id, $city_id);

			if ($ret['errno'] == 0) {		
				TPL::plugin('include/feedlist', array('list' => $ret['rst']));
			}
        ?>
    </div>
</div>