<?php
/**************************************************
*  Created:  2010-06-08
*
*  格式化微博显示的内容
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author xionghui <xionghui1@staff.sina.com.cn>
*
***************************************************/
function format_text($text, $type = 'feed'){
	if (empty($text)){return $text;}
	if ($type == 'feed') {
		$newText = '';
		$c = preg_quote("\"~!@#$%^&*()+`{}[]:'<>?,/|\`·#￥%…—*（）——+－＝：“；‘《》？，。、｜\\");//[^@\.\s\;".$c."]
		$mc = preg_split(";(#[^#]+#|[a-z0-9\-_]*[a-z0-9]@(?:[a-z0-9-]+)(?:\.[a-z0-9-]+)+|@[\x{4e00}-\x{9fa5}0-9A-Za-z_\-]+|http://(?:sinaurl|t)\.cn/[a-z0-9]+|<a\s+href=[\"'][^\"']+[\"'][^>]*>.+?</a>);sium",$text,-1,PREG_SPLIT_DELIM_CAPTURE );
		//print_r($mc);
		foreach ($mc as $i=>$v){
			if ($i%2==1){
				if (substr($v, 0, 1).substr($v, -1, 1)=='##'){
					$newText.=' <a href="'.URL('search.weibo', array('k' => substr($v,1,-1))).'">'.htmlspecialchars($v).'</a> ';
				}elseif(substr($v, 0, 1)=='@'){
					$newText.=' <a href="'.URL('ta', array('name' => substr($v,1))).'">'.htmlspecialchars($v).'</a> ';
				}elseif(preg_match("#^http://(?:sinaurl|t)\.cn/[a-z0-9]+\$#sim",$v)){
					$newText.=' <a title="'.$v.'" href="'.$v.'" target="_blank">'.$v.'</a> ';
				}elseif(preg_match("#<a\s+href=[\"']([^\"']+)[\"'][^>]*>(.+?)</a>#sim",$v,$ma)){
					if (preg_match("#http://t.sina.com.cn/k/([^/]+)\$#sim",$ma[1],$mlink)){
						$newText.=' <a href="'.URL('search', array('k' => $mlink[1])).'">'.htmlspecialchars($ma[2]).'</a> ';
					}else{
						$newText.=$v;
					}
				}else{
					$newText.= htmlspecialchars($v);
				}
			}else{
				$newText.=htmlspecialchars($v);
			}
		}
		$text = $newText;
	}else{
	 	$text = htmlspecialchars($text);	
	}
	//替换表情
	$emoticons = DS('xweibo/xwb.getRepFaces', 86400);
	$search_em = &$emoticons['search'];
	$replace_em = &$emoticons['replace'];

	if (!empty($search_em)) {
		$text = str_replace($search_em, $replace_em, $text);
	}
	return $text;
}