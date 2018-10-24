<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_model extends CI_Model{
	function __construct(){
  		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->library('encrypt');
	}
	//--获取师傅订单
	function getOrderListData($args){
		$fields = array("MasterID","Status","page","rows");
		$input = elements($fields,$args);
		$input["MasterID"] = $_SESSION["MemberID"];
		$input["Status"] = 	isset($input['Status'])?$input['Status']:-1;
		$input["page"] = empty($input['page'])?1:$input['page'];
		$input["rows"] = empty($input['rows'])?15:$input['rows'];
		$rs=$this->Data_model->execProcSetArr('Font_Master_getOrderListData',$input);
		$result = array(
			'code'=>200,
			'total'=>$rs[1][0]['total'],
			'rows'=>$rs[0],
		);
		return $result;	
	}
	function getSingleData($args){
		$fields = array('MasterID','Sn');
		$input = elements($fields,$args);
		$input['MasterID'] = $_SESSION['MemberID'];
		$rs = $this->Data_model->execProcSetArr('Font_Master_Order_getSingleData',$input);
		return array('code'=>200,'rows'=>$rs[0][0],'ServiceList'=>$rs[1]);
	}
	function beginService($args){
		$fields = array('MasterID','Sn');
		$input = elements($fields,$args);
		$input["MasterID"] = $_SESSION["MemberID"];
		$data = $this->Data_model->getSingle($input,'order');
		if(isset($data['OrderID']) && $data['Status'] == 1){
			$this->Data_model->editData($input,array('Status'=>'2','ServiceTime'=>date('Y-m-d H:i:s')),'order');
			return array('code'=>200);
		}else{
			return array('code'=>500);
		}
	}
	function editOrderAmount($args){
		$fields = array('MasterID','Sn','OrderAmount');
		$input = elements($fields,$args);
		$input["MasterID"] = $_SESSION["MemberID"];
		$w = array('MasterID'=>$_SESSION["MemberID"],'Sn'=>$input['Sn']);
		$data = $this->Data_model->getSingle($w,'order');
		if(isset($data['OrderID']) && $data['Status'] == 2){
			$this->Data_model->editData($w,array('OrderAmount'=>$input['OrderAmount'],'Status'=>'3'),'order');
			return array('code'=>200,'OrderAmount'=>$input['OrderAmount']);
		}else{
			return array('code'=>500);
		}
	}
	function cencelOrder($args){
		$fields = array('MasterID','Sn');
		$input = elements($fields,$args);
		$input["MasterID"] = $_SESSION["MemberID"];
		$data = $this->Data_model->getSingle($input,'order');
		if(isset($data['OrderID']) && $data['Status'] == 1){
			$this->Data_mdoel->editData($input,array('Status'=>'5','ServiceTime'=>date('Y-m-d H:i:s')),'order');
			return array('code'=>200);
		}else{
			return array('code'=>500);
		}
	}
}