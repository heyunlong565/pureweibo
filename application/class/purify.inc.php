<?php
	function purify($r = array()) {
		if (array_key_exists('rst', $r)) {
			if (array_key_exists('results', $r['rst'])) {
				$r['rst']['results'] = array_filter($r['rst']['results'], 'ispure');
			} else {
			//var_dump($r);
				$r['rst'] = array_filter($r['rst'], 'ispure');
			}
		}
		return $r;
	}
	function ispure($item = array()) {
		static $bannedlist = array(
			1066229767 => '欣欣时尚生活馆',
			1078677607 => '老雷_广告导演',
			1097201945 => '治愈系心理学',
			1099713350 => '精选尘缘语录',
			1134796120 => '史上第一最最搞',
			1191965271 => '三联生活周刊',
			1193725273 => '中国企业家杂志',
			1197227673 => '董崇飞',
			1206187722 => '方雨007',
			1225153942 => '热门话题总汇',
			1236380405 => '时尚经典语录',
			1237359237 => 'billkds',
			1237946757 => '纸寿司',
			1239937974 => '时尚街拍杂志',
			1252373132 => '全球热门排行榜',
			1259780144 => '时尚潮流部落',
			1265695842 => '肖明超',
			1270766897 => '韩国娱乐大全',
			1270952305 => '凡人阿政',
			1275075351 => '全球时尚速递',
			1322621724 => '80印象馆',
			1342829361 => '加措活佛-慈爱基金',
			1386242467 => '笑评人生',
			1410717760 => '鼓浪屿游玩-问问知道',
			1420174783 => '文怡',
			1420862042 => '哑巴',
			1431680140 => '麦家',
			1439843461 => '大笑话小笑话',
			1454884585 => '雾满拦江',
			1483330984 => '侯宁',
			1558148043 => '时尚搞笑语录',
			1562681384 => '小小流氓女',
			1567852087 => '全球流行风尚',
			1575527140 => '江苏卫视',
			1580329092 => '全球建筑资讯',
			1591738770 => '梁斯鸿leungshome',
			1615743184 => '全球奇闻趣事',
			1619962527 => '北京兵人',
			1620587953 => '方象易经',
			1627825392 => '互联网的那点事',
			1628951200 => '创意铺子',
			1639650452 => '围脖画报',
			1640494672 => '经典语录',
			1641179817 => '马良',
			1642088277 => '财经网',
			1642351200 => '热门微博',
			1642482194 => '创业家杂志',
			1642588657 => '闲看点',
			1642632024 => '新浪数码',
			1642632622 => '科学探索',
			1642634100 => '新浪科技',
			1642635773 => '我们爱讲冷笑话',
			1644274254 => '趣玩网',
			1644394154 => '测试达人',
			1644395354 => '冷笑话精选',
			1644570320 => '当时我震惊了',
			1644572034 => '精彩语录',
			1644574352 => '时尚女性',
			1644587232 => '早安-晚安-心语',
			1646132320 => '全球时尚街拍',
			1646417027 => '时尚趣味馆',
			1646465281 => '围脖经典语录',
			1649378025 => '百合网',
			1649670037 => '互动百科',
			1651593604 => '我们爱讲俏皮话',
			1651618343 => '地空捣蛋',
			1652194081 => '美容健康',
			1652236241 => '伍冰珊',
			1653202503 => '广告门',
			1653584582 => '支付宝担保买卖',
			1653689003 => '新周刊',
			1653957693 => '微博冷笑话',
			1657421782 => '生活小智慧',
			1657430300 => '创意工坊',
			1657476130 => '奢华派',
			1658364043 => '全球创意搜罗',
			1659240213 => '美容美发美甲坊',
			1660209951 => '全球时尚',
			1660452532 => '猫扑',
			1660612723 => '可爱宠物中心',
			1662109054 => '语录笑话谜语趣图游记',
			1662291704 => 'Silver920',
			1665101605 => '84剩女',
			1667480033 => '智言趣语',
			1668595852 => '广州_李静茹',
			1670667874 => '王人平',
			1671342103 => '张泉灵',
			1671526850 => '星座爱情001',
			1671619793 => '淘宝美食',
			1674242970 => '环球音乐榜',
			1675718025 => '微博经典语录',
			1680599832 => '搞笑大百科',
			1686871920 => '偶得幽兰',
			1689619065 => '微博星座运势',
			1690499784 => '爆笑视频',
			1690511644 => '搞笑图片',
			1690514813 => '热门电影榜',
			1692483772 => '原创动漫',
			1692902542 => '健康饮食',
			1698229264 => '音悦台',
			1699451730 => '有道词典',
			1702833725 => '全球热门',
			1703524110 => '淡蓝同志新闻',
			1708242827 => '浪漫英语屋',
			1708288824 => '时尚芭莎',
			1711394437 => '优米网',
			1713066300 => '笑来了大姨妈',
			1713926427 => '微博搞笑排行榜',
			1715931423 => '全球大杂烩精选',
			1716488301 => '人人网',
			1718455577 => '美丽说',
			1718622107 => '经典心理学',
			1719010744 => '潮流英语',
			1719020647 => '水瓶座蜜语',
			1720084970 => '糗事大百科',
			1722647875 => '微博搞笑榜中榜',
			1723956434 => '青牛网',
			1724367710 => '揭露地球',
			1726286122 => '下午茶9',
			1726907913 => '微博经典趣事',
			1729908110 => '这个绝对有意思',
			1732440374 => 'monkey1986',
			1732701841 => '日本潮流最前线',
			1733770795 => '微博小百科',
			1733779624 => '星座宝典',
			1733787604 => '当时我就泪奔了',
			1735373401 => '女人天生爱美丽',
			1735618041 => '星座秘语',
			1737636294 => '新新快乐',
			1737650455 => '烂片通缉令',
			1737717945 => '盐水冰棍拓',
			1738595307 => '当时我就雷晕了',
			1739665194 => '动画电影枪手买家',
			1740577714 => '全球热门搜罗',
			1740579797 => '星座奇妙物语',
			1740961333 => '黑色幽默精选',
			1740961621 => '新街拍',
			1743374541 => '美图秀秀',
			1744491812 => '生活领悟',
			1744762545 => '全球街拍',
			1746804810 => '英语天天说',
			1748034003 => '微博热点',
			1749001647 => '搜搜pop团购导航总站',
			1749818205 => '时尚之坊',
			1750602644 => 'NoNoPark',
			1750903687 => '最音乐',
			1756667731 => '广告也疯狂',
			1757131563 => '测试心理学',
			1757138607 => '教你做好女人',
			1757174173 => '此刻我惊呆了',
			1757353251 => '电影工厂',
			1758570073 => '极创意',
			1759412397 => '恶趣味爱上重口味',
			1760369714 => '历史震惊你',
			1760945071 => '团800网',
			1761216793 => '最神奇的心理学',
			1762436132 => '热电影',
			1762675215 => '爱物网',
			1762696131 => '怪诞心理行为学',
			1762698011 => '创意集市',
			1762719777 => '早安丶晚安丶心语',
			1764208435 => '时尚全球汇',
			1764222885 => '这个微博很给力',
			1764226841 => '萌宠大本营',
			1764669250 => '欧美街拍时尚',
			1766616701 => '奢侈尚品',
			1769867744 => '这有意思',
			1770232883 => '颜晓滨_老颜管理精选',
			1770818961 => '时尚经典排行榜',
			1774698101 => '修心养生辞典',
			1774813191 => '双子座蜜语',
			1774817377 => '潮音乐',
			1774839495 => '微博心理学',
			1774860981 => '环球时尚旅行',
			1775767857 => '微博星座达人',
			1776266241 => '全球时尚最前线',
			1780417033 => '实用小百科',
			1780550155 => '精彩英文语录',
			1781017640 => '星座小秘书',
			1784827665 => '热门搞笑精选',
			1787525055 => '围脖测试控',
			1788690213 => '星座蜜语',
			1788839005 => '沙发放中间',
			1789431530 => '路过的总结xi',
			1790839994 => '围脖流行风尚',
			1791292051 => '全球时尚热榜',
			1793718135 => '精彩爱情语录',
			1794166463 => '星座大全',
			1799648721 => '80后那事',
			1800697877 => '划算买大牌',
			1802393212 => '收录唯美图片',
			1803754177 => '跟韩剧学穿衣',
			1805508620 => '妮妮創意速遞',
			1806941117 => '大美人小智慧',
			1808842910 => '海边铁匠',
			1821898647 => '微群小助手',
			1822569103 => '长沙团购打折',
			1824081497 => '香港知名记者',
			1824756383 => '杂志书',
			1825050563 => '历史袁老师',
			1828483985 => '全球大百科',
			1829906213 => '淘宝新奇特商品',
			1829942640 => '动漫梦工场',
			1830138345 => 'DIY达人',
			1830325932 => '重口味宅腐女',
			1830442653 => '韩流音悦台',
			1832444080 => '经典-电影-台词',
			1832447572 => '一块去旅行',
			1835812695 => '超级实用小百科',
			1836384951 => 'En给力sh',
			1837642963 => '美丽爱情心语',
			1839953980 => 'hi冷笑话女王',
			1841391791 => '环球街拍',
			1842262067 => '全球潮流街拍',
			1842352884 => '美妆团购',
			1843443790 => '精彩电影',
			1843633441 => '搜狐全娱乐',
			1848090933 => '台词丶音乐丶电影',
			1848155523 => '微杂志',
			1848925910 => 'Special小糖',
			1850240642 => '语录库',
			1851524785 => '笑多了会怀孕',
			1852791491 => '全球流行音乐',
			1853472775 => '传世经典排行榜',
			1854262562 => '全球新鲜资讯',
			1854471750 => '我为奢品狂',
			1854743504 => '电影集结号',
			1854978097 => '宠物SOS',
			1856201337 => '十二星座蜜语',
			1857414070 => '世界美景',
			1857432230 => '潮人美鞋馆',
			1857435872 => '惠大帮帮帮',
			1858319430 => '环球时尚家居',
			1858395502 => '全球时尚焦点',
			1858595532 => '日韩时尚最前沿',
			1859790645 => '搞笑冷笑话精选',
			1860973204 => '狮子座蜜语',
			1863188053 => 'symbol0918',
			1863454415 => 'MSN奢侈品频道',
			1863595250 => '大力做大力愛',
			1864500772 => '时尚瘦身',
			1864502714 => '爱尚婚纱',
			1864528464 => '爱尚奢侈品',
			1867021795 => '不达不狂不厉害不精明',
			1867323824 => '热点时尚',
			1870113224 => '星座查询',
			1870605083 => '上海潮流情报',
			1874209821 => '时尚潮物',
			1878956214 => '口袋小说',
			1879349260 => '全球囧事大本营',
			1879393492 => '环球美食之旅',
			1880314011 => '搭配我最大',
			1880319371 => 'symsym2008',
			1880644580 => '糗事微博',
			1880883170 => '围脖搞笑精华榜',
			1881161372 => '美图丶心语丶旅行',
			1885695252 => '全球电影榜',
			1886419032 => '宅腐集中营',
			1887632421 => '服饰搭配控',
			1887696033 => '跟明星学穿衣Style',
			1887802145 => '百度新闻',
			1890826225 => '每天学点心理学',
			1890901295 => '全球尚品',
			1893801487 => '微天下',
			1894602195 => '时尚-美甲',
			1895126643 => '布丁美食',
			1896395304 => '生活精选',
			1897054331 => '全球热门伤不起',
			1898484642 => '星座小站',
			1900887504 => '口袋英语',
			1901122663 => '天秤座蜜语',
			1904351863 => '我是多多',
			1905375702 => '我们都爱帅哥',
			1905377014 => '潮流美剧',
			1905798965 => '养生健康知识',
			1906114713 => '真心话',
			1907299322 => '吸血鬼日记控',
			1907416044 => '巨蟹座蜜语',
			1909419534 => '56网女性',
			1909422630 => '56网拍客',
			1909601200 => '56网母婴',
			1909694054 => '56网综艺',
			1910100845 => '爱美协会',
			1911406070 => '我们都是腐女',
			1911594332 => '摩羯座蜜语',
			1916506581 => '生活上的那些事兒',
			1920013524 => 'calvin费洛蒙',
			1920061532 => '全球经典音乐',
			1925266324 => '模特美女集中营',
			1927790995 => '广州生活指南',
			1928277197 => '星座魅影',
			1930409882 => '求职小帮手',
			1935001690 => '我美丽我健康',
			1936932187 => '小三私房话',
			1938314652 => '微博公益联盟',
			1938989085 => '高朋团购',
			1939419914 => '环球汽车',
			1940798632 => '总裁语录',
			1945139410 => '上海沃画报',
			1945520877 => '超级搞笑风云榜',
			1945744752 => '全球恐怖热点',
			1945816902 => '神经病爱上精神病',
			1947100120 => '知识就是力量CCW',
			1947267610 => '潮流最前线',
			1951298162 => '粤蒲粤好玩',
			1957134282 => '心理学暗示',
			1959448104 => '美人儿趣事',
			1960084034 => '微博八卦堂',
			1966021100 => '微博小百科V',
			1966380590 => '环球家居',
			1966860421 => '十二星座语',
			1968692705 => '视觉艺术设计',
			1971040242 => '关注我的都是重口味',
			1972102042 => '稀奇搞怪小技巧',
			1972612492 => '该死的心理学',
			1977983524 => '笑料百科',
			1978875447 => '唯美英文',
			1979401964 => '56网搞笑',
			1980430637 => '塑身瑜伽',
			1980820184 => '重口味大杂烩',
			1980929593 => '历史上的今天',
			1983440250 => '闺蜜私房话',
			1983571970 => '潮流音乐狂',
			1984147603 => '八卦三分钟',
			1985551380 => '全球电影收录',
			1985551890 => '全球音乐收录',
			1988518703 => '爱平板',
			1989623247 => '女性博客',
			1992523932 => '美食工场',
			1993350880 => '口袋书屋',
			1994619150 => '世界奇趣搜_集FuN',
			1996986411 => '爱问星座',
			1998590751 => '笑死偶了',
			2006490207 => '星座命理专家',
			2010185247 => '英语精英VIP',
			2011796120 => '笑话有木有',
			2013756714 => '鼓浪屿杭州免费住联盟',
			2017683591 => '百科常识大全',
			2019688651 => '那些灵异事件',
			2019719255 => '日剧全攻略',
			2023712627 => '娱乐界小道先知',
			2023791210 => '看书有道',
			2024532373 => '桔子水晶',
			2026806915 => '养生美食指南',
			2028308787 => '创意吓死人',
			2028896463 => '微博热门转发榜',
			2031855047 => '比价皇',
			2040160344 => '历史这玩意儿',
			2040398155 => '潮流时尚焦点',
			2043445557 => '孙振耀',
			2045843190 => '身旁小笑话',
			2045873540 => '诙谐冷笑话',
			2048661167 => '全球潮流婚纱',
			2050120650 => '创意搞笑视频',
			2051473247 => '控控大本营',
			2055646735 => '美容贴士精选',
			2057651577 => '世界奇趣',
			2059773503 => '建筑师之梦',
			2062331137 => '56网红人',
			2063540952 => '英语警察',
			2066785327 => '刘忻__',
			2067331943 => '一本书一句话一段情',
			2068941174 => '我们都爱读书',
			2075525577 => '欧阳中小学教育',
			2080114694 => '动漫基地',
			2087497631 => '杨洋yy_',
			2089027167 => '超级冷笑话排行榜',
			2089682643 => '鬼故事灵异事件记',
			2089716475 => '邪恶小漫画',
			2089743553 => '处女座蜜语',
			2089978377 => '金牛座蜜语',
			2090476735 => 'IQ伤不起',
			2090988135 => '段林希dlx_',
			2091828527 => '爱自由爱旅游',
			2092032733 => '教子语录',
			2095259551 => '喻佳丽yjl_',
			2096095141 => '时尚新新女性',
			2099555177 => '苏妙玲sml_',
			2101605203 => '孙昕欣sxx_',
			2103213795 => '唯美星座',
			2105343271 => '猫扑城市',
			2105832005 => '猫扑美食',
			2105892495 => '客官不可以嘛',
			2106156585 => '游戏发烧友',
			2107123611 => '李斯丹妮lsdn_',
			2114264892 => '星座蜜语宝典',
			2115174924 => '明星撞衫大PK',
			2121609853 => '射手座蜜语',
			2122230105 => '零食主义控',
			2122234845 => '一本书一段情',
			2122237241 => '双鱼座蜜语',
			2122243241 => '我们都爱古诗词',
			2128322550 => '毛豆妈育儿经',
			2128483985 => '爱康国宾每日健康',
			2130169362 => '全球时尚工坊',
			2131445654 => '咱们一起去旅行',
			2131917384 => '精彩英语语录',
			2136452744 => '最神奇的星座',
			2138582403 => 'Fotos-恋图控',
			2141100877 => '视觉志',
			2141115767 => '神秘未解之谜',
			2149614850 => '全球旅行风',
			2156053770 => '暖心-音乐-歌词',
			2156460415 => '时尚精品控',
			2156460914 => '广告也震惊',
			2158697171 => '最天秤',
			2161753087 => '惊艳吧',
			2167798451 => '处女座性格行为特点',
			2175615234 => '你的青春闻起来好香',
			2177813955 => '时尚最流行',
			2184712582 => '性感男女世界',
			2204122960 => '白羊座蜜语',
			2208548220 => '天蝎座蜜语',
			2209078444 => '全球慢报',
			0 => '',
			1 => '');
		if (array_key_exists($item['user']['id'], $bannedlist)) {
			return 0;
		}
		//var_dump($item);
		if (array_key_exists('retweeted_status', $item)) {
			if (array_key_exists($item['retweeted_status']['user']['id'], $bannedlist)) {
				return 0;
			}
		}
		return 1;
	}