<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Order_model');
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Order_model->getListData($this->POST_DATA);
			exit(json_encode($return));
		}
		//--派遣
		if($do=="Dispatch"){
			$res["data"] = $this->GET_DATA;
			$html = $this->load->view('Market/DispatchOrder',$res,true);
			exit($html);	
		}
		//--获取师傅清单
		if($do=='getDispatchMasterList'){
			$rs = $this->Member_model->getDispatchMasterList();
			exit(json_encode($rs["rows"]));
		}
		//--保存派遣订单
		if($do=='saveDispatchOrder'){
			$rs = $this->Order_model->saveDispatchOrderData($this->POST_DATA);
			exit(json_encode($rs));
		}
		//编辑订单
		if($do=="editData"){
			$rs = $this->Order_model->getSingleData($this->GET_DATA);
			$res["data"] = $rs["rows"];
			$res["GoodsList"] = $rs["GoodsList"];
			$html = $this->load->view('Market/OrderForm',$res,true);
			exit($html);
		}
		//--取消订单
		if($do=="cancel"){
			$rs = $this->Order_model->updateStatus($this->POST_DATA);
		}
		$this->load->view('Market/Order',$res);
	}
}
