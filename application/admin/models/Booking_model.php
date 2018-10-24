<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Booking_getListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('BookingID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,'booking');
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('BookingID','Name','Phone','Project','BookingTime','Shop');
		$input = elements($fields,$args);
		$input['CreateTime'] = intval($input['BookingID'])<1?time():"";
		if($input['CreateTime'] == ""){
			unset($input['CreateTime']);
		}
		$BookingID = intval($input['BookingID']);unset($input['BookingID']);
		if($BannerID > 0){
			$this->Data_model->editData(array('BookingID'=>$BookingID),$input,'booking');
		}else{
			$this->Data_model->addData($input,'booking');
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('BookingID');
		$input = elements($fields,$args);
		$this->Data_model->editData(array('BookingID'=>$BookingID),array('IsDel'=>1),'booking');
		return array('code'=>200);
	}
}
