<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Goods extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Goods_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=="getCommentsListData"){
			$rs = $this->Goods_model->getCommentsListData($this->GET_DATA);
			AjaxReturn($rs);
		}
		$GoodsList = $this->Data_model->getData(array("IsDel"=>0,"OnSale"=>1),"GoodsID asc",0,0,"goods");
		//--获取用户订单数，用于首单优惠
		$OrderNum = $this->Data_model->getDataNum(array("MemberID"=>$_SESSION["MemberID"],"Status >"=>-1,"IsDel"=>"0"),"order");
		$data = $this->Goods_model->getSingle($this->uri->segment(3));
		$res["OrderNum"] = $OrderNum;
		$res['data'] = $data['rows'];
		$res["GoodsList"] = $GoodsList;
		$tpl = "Goods/detail";
		$this->load->view($tpl,$res);
	}
}
