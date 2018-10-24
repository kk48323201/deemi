<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Training_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Training_getListData',$input);
		
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('TrainingID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,'training');
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('TrainingID','TrainingName');
		$input = elements($fields,$args);
		$TrainingID = intval($input['TrainingID']);
		unset($input['TrainingID']);
		if($TrainingID > 0){
			$this->Data_model->editData(array('TrainingID'=>$TrainingID),$input,'training');
		}else{
			$this->Data_model->addData($input,'training');
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('TrainingID');
		$input = elements($fields,$args);
		$this->Data_model->editData($input,array('IsDel'=>'1'),'training');
		return array('code'=>200);
	}
}