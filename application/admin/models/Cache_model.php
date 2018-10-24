<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cache_model extends CI_Model{
	var $CI;
	function __construct(){
  		parent::__construct();
  		$this->CI =& get_instance();
  		$this->load->driver('cache', array('adapter' => 'file'));
	}
	function loadConfig($category){
		$cachestr = 'config_'.$category;
		$cache = $this->CI->cache->get($cachestr);
		if(!$cache){
			$data = $this->CI->Data_model->getData(array('category'=>$category),'',0,0,'config');
			foreach($data as $item){
				$cache[$item['varname']] = $item['value'];
			}
			$this->CI->cache->save($cachestr,$cache,2592000);
		}
		return $cache;
	}
	function delete($key){
		$this->CI->cache->delete($key);
	}
	
	function deleteSome($keystr){
		$cacheinfo = $this->CI->cache->cache_info();
		$cacheArr = array();
		$num = strlen($keystr);
		foreach($cacheinfo as $key=>$item){
			if($keystr==substr($key,0,$num)){
				$this->CI->cache->delete($key);
			}
		}
	}
	function clean(){
		$this->CI->cache->clean();
	}
}