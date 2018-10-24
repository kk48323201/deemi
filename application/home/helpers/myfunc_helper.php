<?php
function isMobile()
{ 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
			'iPhone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 
function is_weixin() { 
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
        return true; 
    } return false; 
}
function AjaxReturn($e){
	exit(json_encode($e,JSON_UNESCAPED_UNICODE));
}
function getCurUrl(){
	return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
}
function dd_password($str){
	return strtoupper(crypt($str,'$1$beiguojiayuan$'));
}
function beiguo_get($key){
	$CI =& get_instance();
	$CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$result = $CI->cache->get($key);
	return $result;
}
function beiguo_save($data,$key){
	$CI =& get_instance();
	$CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$result = $CI->cache->save($key,1800);
	return $result;
}
function ip() {
    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    return $res;
}
/*快速创建缩略图*/
function LeeShowThumb($img,$w,$h){
	if($img==''){
		return base_url('style/images/noimages.jpg');
	}
	$CI =& get_instance();
	$CI->load->library('image_lib');
	$name = md5($img).$w.'x'.$h;
	$showurl = base_url('upload/cache_img/'.$name.'.jpg');
	$filepath = 'upload/cache_img/'.$name.'.jpg';
	if(file_exists($filepath)){
		return $showurl;
	}else{
		
		$config['thumb_marker'] = false;
		$config['source_image'] = ROOTPATH.$img;
		$config['create_thumb'] = false;
		$config['maintain_ratio'] = TRUE;
		$config['new_image'] = $filepath;
		$config['width'] = $w;
		$config['quality'] = '100';
		$config['height'] = $h;
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		return $showurl;
	}
}
//--获取微信分享配置
function getWxSahreConfig(){
	$CI =& get_instance();
	$rs = $CI->Wechat_model->getSignPackage();
	return $rs;
}
function SBC_DBC($str, $args2) {
	$DBC = Array(
	'０' , '１' , '２' , '３' , '４' ,
	'５' , '６' , '７' , '８' , '９' ,
	'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,
	'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' ,
	'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,
	'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' ,
	'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,
	'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' ,
	'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,
	'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' ,
	'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,
	'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' ,
	'ｙ' , 'ｚ' , '－' , '　' , '：' ,
	'．' , '，' , '／' , '％' , '＃' ,
	'！' , '＠' , '＆' , '（' , '）' ,
	'＜' , '＞' , '＂' , '＇' , '？' ,
	'［' , '］' , '｛' , '｝' , '＼' ,
	'｜' , '＋' , '＝' , '＿' , '＾' ,
	'￥' , '￣' , '｀','【','】'
	);
	$SBC = Array( // 半角
	'0', '1', '2', '3', '4',
	'5', '6', '7', '8', '9',
	'A', 'B', 'C', 'D', 'E',
	'F', 'G', 'H', 'I', 'J',
	'K', 'L', 'M', 'N', 'O',
	'P', 'Q', 'R', 'S', 'T',
	'U', 'V', 'W', 'X', 'Y',
	'Z', 'a', 'b', 'c', 'd',
	'e', 'f', 'g', 'h', 'i',
	'j', 'k', 'l', 'm', 'n',
	'o', 'p', 'q', 'r', 's',
	't', 'u', 'v', 'w', 'x',
	'y', 'z', '-', ' ', ':',
	'.', ',', '/', '%', '#',
	'!', '@', '&', '(', ')',
	'<', '>', '"', '\'','?',
	'[', ']', '{', '}', '\\',
	'|', '+', '=', '_', '^',
	'$', '~', '`','[',']'
	);
	if ($args2 == 0) {
		return str_replace($SBC, $DBC, $str); // 半角到全角
	} else if ($args2 == 1) {
		return str_replace($DBC, $SBC, $str); // 全角到半角
	} else {
		return false;
	}
}
function fmoney($num){
	return $format_num = sprintf("%.2f",$num);
}
function getip()
{
    return $_SERVER['REMOTE_ADDR'];
}
?>