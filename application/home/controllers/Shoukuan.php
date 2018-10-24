<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shoukuan extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->load->model('Order_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function index()
	{
		$res = array();$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=="WechatF2F"){
			$rs = $this->Order_model->CreateFacePaymentOrder($this->POST_DATA);
			AjaxReturn($rs);
		}
		$tpl = "Member/Shoukuan";
		$this->load->view($tpl,$res);
	}
}
