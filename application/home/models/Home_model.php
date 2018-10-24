<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	//--获取首页商品，新品
	function getListData($args){
		$fields = array('page','rows');
		$input = elements($fields,$args);
		$input['page'] = intval($args['page'])<1?1:intval($args['page']);
		$input['rows'] = intval($args['rows'])<1?10:intval($args['rows']);
		$rs = $this->Data_model->execProcSetArr('Font_Goods_NewListData',$input);
		return array('code'=>200,'rows'=>$rs[0],'other'=>$rs[1][0]);
	}

}