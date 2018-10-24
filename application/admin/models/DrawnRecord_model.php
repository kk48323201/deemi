<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DrawnRecord_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_DrawnRecord_getListData',$input);
		
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function updateStatus($args){
		$fields = array('ID','Status');
		$input = elements($fields,$args);
		$this->Data_model->editData(array('ID'=>$input['ID']),array("Status"=>$input['Status']),"drawn_record");
		return array('code'=>200);
	}
}