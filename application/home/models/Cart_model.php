<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cart_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function saveData($args){
		$fields = array('MemberID','GoodsID');
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];
		$w = array('MemberID'=>$input['MemberID'],'GoodsID'=>$input['GoodsID']);
		$data = $this->Data_model->getSingle($w,'cart');
		if(isset($data['CartID'])){
			$Num = (int)$data['Num']+1;
			$this->Data_model->editData($w,array('Num'=>$Num),'cart');
		}else{
			$Num = 1;
			$insert = array(
				'MemberID'=>$input['MemberID'],
				'GoodsID'=>$input['GoodsID'],
				'Num'=>1,
			);
			$this->Data_model->addData($insert,'cart');
		}
		return array('code'=>200);
	}
	function getCartData(){
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_getCartData',$input);
		return array('code'=>200,'rows'=>$rs[0],'info'=>$rs[1][0]); 
	}
	function updateCart($args){
		$fields = array('MemberID','CartXml');
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];

		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Member_UpdateCartData',$input,$output);
		return array('code'=>$rs['returnValue']);
	}
	function delCartData($args){
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['CartID'] = isset($args['CartID'])?$args['CartID']:"";
		$output = array('returnValue'=>0);
		$this->Data_model->execProcSet('Font_Member_DelCartData',$input,$output);
		return array('code'=>200);
	}

}