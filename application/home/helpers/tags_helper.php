<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function beiguo_config($category,$key){
	$CI =& get_instance();
	$CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	$cachestr = "config_{$category}";
	$config = false;
	if(!$config){
		$config = $CI->Data_model->getData(array('category'=>$category),'id',0,0,'config');
		$CI->cache->save($cachestr,$config,9000);
	}
	
	foreach($config as $item){
		if($key==$item['varname']){
			return $item['value'];
		}
	}
	return "";
}
//--获取客服url
function beiguo_kfurl(){
	$CI =& get_instance();
	return $CI->config->item('kfurl');
}
function tag_getArticle($CatID,$page=1,$pagesize=20){
	$CI =& get_instance();
	$data = $CI->Data_model->getData(array('IsDel'=>'0','CategoryID'=>$CatID),'ListOrder,CreateTime desc',$pagesize,($page-1)*$pagesize,'article');
	return $data;
}
function tag_getPage($PageID){
	$CI =& get_instance();
	$data = $CI->Data_model->getSingle(array('PageID'=>$PageID),'page');
	return $data;
}
function tag_getBanner($page=1,$pagesize=20){
	$CI =& get_instance();
	$data = $CI->Data_model->getData(array('IsDel'=>'0','Status'=>'1'),'CreateTime desc',$pagesize,($page-1)*$pagesize,'banner');
	return $data;
}