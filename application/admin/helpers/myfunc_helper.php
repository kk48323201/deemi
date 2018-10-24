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
function SaveImg($img,$dir=''){
	$CI =& get_instance();
	if($img == ''){
		return $img;
	}
	
	if(strpos($img,'upload') !== false){  
		return $img;
	}
	//echo $img;exit;
	//$jpg = str_replace('[removed]','',$img);
	$jpg = str_replace('data:image/jpg;base64,', '', $img);
	$jpg = str_replace('data:image/jpeg;base64,','',$jpg);
	$jpg = str_replace('data:image/png;base64,','',$jpg);
	$jpg = str_replace('data:image/gif;base64,','',$jpg);
	
	$save_path = 'upload/'.date("Ymd").'/';
	if($dir!=''){
		$save_path = 'upload/'.$dir.'/'.date("Ymd").'/';
	}
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	$imgname = md5(uniqid(rand())).".png";
	
	file_put_contents($save_path.$imgname, base64_decode($jpg));
	//echo 23;exit;
	//开始图片压缩处理
	$imgconfig['image_library'] = 'gd2';
	$imgconfig['source_image'] = $save_path.$imgname;
	$imgconfig['new_image'] = $save_path.$imgname;
	$imgconfig['create_thumb'] = TRUE;
	$imgconfig['maintain_ratio'] = TRUE;
	$imgconfig['width'] = 500;
	$imgconfig['height'] = 500;
	if($dir=='posters'){
		$imgconfig['width'] = 1000;
		$imgconfig['height'] = 1300;
	}
	$imgconfig['thumb_marker'] = '';
	$CI->load->library('image_lib', $imgconfig); 
	$CI->image_lib->resize();
	$result = $save_path.$imgname;
	return $result;		
}
?>