<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Member_model');
		$this->load->model('Goods_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$this->Member_model->checkLogin();
		$res = array();$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		$ShareID = isset($this->GET_DATA["ShareID"])?$this->GET_DATA["ShareID"]:0;
		if($ShareID > 0){
			$this->Member_model->WxInviteRecord($ShareID,$_SESSION["WechatOpenid"]);
		}
		if($do=='getListData'){
			$rs = $this->Goods_model->getListData($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=="setLocation"){
			$rs = $this->Memebr_model->setLocation($this->POST_DATA);
			AjaxReturn($rs);
		}
		$tpl = "Home/Home";
		$this->load->view($tpl,$res);
	}
	public function Login()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=='login'){
			$rs = $this->Member_model->MobileLogin($this->POST_DATA);
			AjaxReturn($rs);
		}
		$tpl = "Home/Login";
		$this->load->view($tpl,$res);
	}
	//--合作商家
	public function Business(){
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		$MarketData = $this->Member_model->getMapMarketData();
		$res["MarketData"] = json_encode(array("code"=>0,"msg"=>"success","data"=>$MarketData));
		$tpl = "Home/Business";
		$this->load->view($tpl,$res);
	}
}
