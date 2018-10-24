<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Address_model');
		$this->load->model('Member_model');
		$this->load->model('Other_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=='savePhoneTask'){
			$rs = $this->Member_model->savePhoneTask($this->POST_DATA);
			AjaxReturn($rs);
		}
		//--获取钱包金额和列表数据
		if($do=="getPurseInfo"){
			$rs = $this->Member_model->getPurseInfo($this->POST_DATA);
			AjaxReturn($rs);
		}
		//--获取申请提现记录
		if($do=="getDrawnList"){
			$rs = $this->Member_model->getDrawnListData($this->GET_DATA);
			AjaxReturn($rs);
		}
		$data = $this->Member_model->getMemberCenterData();
		$res["data"] = $data;
		$tpl = "Member/Home";
		$this->load->view($tpl,$res);
	}
	public function Earnings()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=="getData"){
			if($this->POST_DATA['Status'] == 1){
				$rs = $this->Member_model->getAgentOrderListData($this->POST_DATA);
			}else{
				$rs = $this->Member_model->getAgentListData($this->POST_DATA);
			}
			AjaxReturn($rs);
		}
		$tpl = "Member/Earnings";
		$this->load->view($tpl,$res);
	}
	public function Order()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == "getData"){
			$rs = $this->Member_model->getOrderData($this->POST_DATA);
			AjaxReturn($rs);
		}
		$tpl = "Member/Order";
		$this->load->view($tpl,$res);
	}
	function sendCode(){
		$rs = $this->Other_model->SendCode($this->POST_DATA);
		AjaxReturn($rs);
	}
	public function Address(){
		$res = array();
		$do = '';
		if(isset($this->GET_DATA['do'])&&$this->GET_DATA['do']!=''){
			$do = $this->GET_DATA['do'];
		}
		if($do=='getAddress'){
			$rs = $this->Address_model->getAddressData($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=='setAddress'){
			$rs = $this->Address_model->setAddressDefault($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=='delAddress'){
			$rs = $this->Address_model->delAddressData($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=='citys'){
			$rs = $this->Address_model->getCitysJson();
			exit($rs);
		}
		if($do=='Save'){
			$rs = $this->Address_model->SaveAddress($this->POST_DATA);
			AjaxReturn($rs);
		}
		if($do=='ListData'){
			$rs = $this->Address_model->AddressListData($this->GET_DATA);
			exit(json_encode($rs,JSON_UNESCAPED_UNICODE));
		}
		if($do=='selAddress'){
			$html = $this->load->view("Member/AddressMain",array(),true);	
			exit($html);
		}
		$this->load->view("Member/Address");
	}
	public function Qrcode(){
		$res = array();
		$res['qrimg'] = $this->Wechat_model->getQrcode($_SESSION['MemberID'],1);
		$this->load->view("Member/Qrcode",$res);
	}
	public function Contact(){
		$res = array();
		$this->load->view("Member/Contact",$res);
	}
	public function Purse(){
		$res = array();
		$do = '';
		if(isset($this->GET_DATA['do'])&&$this->GET_DATA['do']!=''){
			$do = $this->GET_DATA['do'];
		}
		//--财务记录
		if($do=="PurseList"){
			$html = $this->load->view("Member/PurseList",$res,true);
			echo $html;exit;
		}
		//--提现记录
		if($do=="DrawnList"){
			$html = $this->load->view("Member/DrawnList",$res,true);
			echo $html;exit;
		}
		$this->load->view("Member/Purse");
	}
}
