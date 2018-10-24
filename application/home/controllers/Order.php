<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->load->model('Address_model');
		$this->load->model('Order_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function index()
	{
		$res = array();$do = '';
		if(isset($this->GET_DATA['do'])&&$this->GET_DATA['do']!=''){
			$do = $this->GET_DATA['do'];
		}
		if($do=='ServiceOrder'){
			$this->load->view("Order/ServiceOrder",$res);
		}
		if($do=='SaveOrder'){
			$rs = $this->Order_model->SaveOrder($this->POST_DATA);
			AjaxReturn($rs);
		}
		if($do=='WechatPay'){
			$rs = $this->Order_model->CreatePaymentOrder($this->POST_DATA['Sn']);
			AjaxReturn($rs);
		}
		if($do=='PayResult'){
			$rs = $this->Order_model->getSingleData($this->GET_DATA);
			$res['OrderInfo'] = $rs[0][0];
			$this->load->view("Order/Success",$res);
		}
		if($do=="SaveComments"){
			$rs = $this->Order_model->SaveComments($this->POST_DATA);
			AjaxReturn($rs);
		}
	}
	function ServiceOrderDetial(){
		$res = array();
		$this->GET_DATA["Sn"] = $this->uri->segment(3);
		$rs = $this->Order_model->getSingleData($this->GET_DATA);
		$res["data"] = $rs["rows"];
		$res["ServiceList"] = $rs["ServiceList"];
		$this->load->view("Order/ServiceOrderDetial",$res);
	}
	function Comments(){
		$OrderID = isset($this->GET_DATA["OrderID"])?intval($this->GET_DATA["OrderID"]):0;
		$data = $this->Data_model->getSingle(array('OrderID'=>$OrderID,"MemberID"=>$_SESSION["MemberID"],"Status"=>3),"order");
		if(!isset($data["OrderID"])){
			redirect(site_url("Member"));exit;
		}
		$rs = $this->Order_model->getSingleData(array("Sn"=>$data["Sn"]));
		$res["data"] = $rs["rows"];
		$this->load->view("Order/Comments",$res);
	}
}
