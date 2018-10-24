<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Banner_getListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('BannerID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,'banner');
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('BannerID','BannerName','Link','BigThumb','Status','CatID');
		$input = elements($fields,$args);
		$input['CreateTime'] = intval($input['BannerID'])<1?time():"";
		if($input['CreateTime'] == ""){
			unset($input['CreateTime']);
		}
		$BannerID = intval($input['BannerID']);unset($input['BannerID']);
		if($BannerID > 0){
			$this->Data_model->editData(array('BannerID'=>$BannerID),$input,'banner');
		}else{
			$this->Data_model->addData($input,'banner');
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('BannerID');
		$input = elements($fields,$args);
		$this->Data_model->editData($input,array('IsDel'=>1),'banner');
		return array('code'=>200);
	}
	function getCatListData($args){
		$data = $this->Data_model->getData(array(),'',0,0,'banner_cat');
		return array('code'=>200,'rows'=>$data);
	}
}
