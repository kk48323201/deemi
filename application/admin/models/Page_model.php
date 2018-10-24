<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Page_getListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('PageID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,'page');
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('PageID','PageName','Content','BigThumb');
		$input = elements($fields,$args);
		$input['CreateTime'] = intval($input['PageID'])<1?time():"";
		if($input['CreateTime'] == ""){
			unset($input['CreateTime']);
		}
		$PageID = intval($input['PageID']);unset($input['PageID']);
		if($PageID > 0){
			$this->Data_model->editData(array('PageID'=>$PageID),$input,'page');
		}else{
			$this->Data_model->addData($input,'page');
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('PageID');
		$input = elements($fields,$args);
		$this->Data_model->editData($input,array('IsDel'=>1),'page');
		return array('code'=>200);
	}
	function getCatListData($args){
		$data = $this->Data_model->getData(array(),'',0,0,'page');
		return array('code'=>200,'rows'=>$data);
	}
}
