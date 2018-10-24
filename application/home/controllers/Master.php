<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Home_model');
		$this->load->model('Address_model');
		$this->load->model('Member_model');
		$this->load->model('Other_model');
		$this->load->model('Master_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function Order()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=='getData'){
			$rs = $this->Master_model->getOrderListData($this->POST_DATA);
			AjaxReturn($rs);
		}
		//--开始服务通知
		if($do=="beginServiceNotice"){
			$OrderData=$this->Data_model->getSingle(array('Sn'=>$this->POST_DATA['Sn'],'MasterID'=>$_SESSION["MemberID"]),'order');
			if(!isset($OrderData["Sn"])){
				AjaxReturn(array('code'=>500));
			}
			$Customer=$this->Data_model->getSingle(array('MemberID'=>$OrderData['MemberID']),'member');
			if(isset($Customer['WechatOpenid']) && $Customer['WechatOpenid'] != ''){
				$template_id = 'rABpGYyF61wQW1-lHs_UMLvaAMzfdisA2HYhpcKw73Q';
				$openid = $Customer['WechatOpenid'];
				$Sn = $OrderData['Sn'];
				$templateData = array(
					'first'=>array('value'=>urlencode('你好，您预订的服务已开始！')),
					'keyword1'=>array('value'=>urlencode($Sn)),
					'keyword2'=>array('value'=>urlencode($OrderData['ServiceTime'])),
					'remark'=>array('value'=>urlencode('感谢您的支持！')),
				);
				$url = site_url("Order/ServiceOrderDetial/{$Sn}");
				$this->Wechat_model->sendTemplateMsg($openid,$template_id,$templateData,$url);
			}
			AjaxReturn(array('code'=>200));
		}
		$tpl = "Master/Order";
		$this->load->view($tpl,$res);
	}
	function ServiceOrderDetial(){
		$res = array();
		$this->GET_DATA["Sn"] = $this->uri->segment(3);
		$rs = $this->Master_model->getSingleData($this->GET_DATA);
		$res["data"] = $rs["rows"];
		$res["ServiceList"] = $rs["ServiceList"];
		$this->load->view("Master/ServiceOrderDetial",$res);
	}
	function beginService(){
		$rs = $this->Master_model->beginService($this->POST_DATA);
		AjaxReturn($rs);
	}
	function cencelOrder(){
		$rs = $this->Master_model->cencelOrder($this->POST_DATA);
		AjaxReturn($rs);
	}
	function editOrderAmount(){
		$rs = $this->Master_model->editOrderAmount($this->POST_DATA);
		AjaxReturn($rs);
	}
}
