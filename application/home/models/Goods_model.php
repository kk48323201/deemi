<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Goods_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$fields = array('page','rows');
		$input = elements($fields,$args);
		$input['page'] = intval($args['page'])<1?1:intval($args['page']);
		$input['rows'] = intval($args['rows'])<1?10:intval($args['rows']);
		$w = array('IsDel'=>'0','Status'=>'1','OnSale'=>"1");
		$data = $this->Data_model->getData($w,'CreateTime desc',$input['rows'],($input['page']-1)*$input['rows'],'goods');
		$total = $this->Data_model->getDataNum($w,'goods');
		return array('code'=>200,'rows'=>$data,'total'=>$total);
	}
	function getSingle($GoodsID){
		$baseData = $this->Data_model->getSingle(array('GoodsID'=>$GoodsID),'goods');
		$otherData = $this->Data_model->getSingle(array('GoodsID'=>$GoodsID),'goods_detail');
		$data = array_merge($baseData,$otherData);
		return array('code'=>200,'rows'=>$data);
	}
	function getCommentsListData($args){
		$fields = array('GoodsID','MemberID','page','rows');
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs = $this->Data_model->execProcSetArr('Font_Goods_getServiceCommentsListData',$input);
		return array('code'=>200,'rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}

}