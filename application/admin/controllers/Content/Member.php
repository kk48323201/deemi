<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Admin_model->checkLogin();
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Member_model->ListData($this->GET_DATA);
			for($i=0;$i<count($return['total']);$i++){
				//$return['rows'][$i]['WechatNickname'] = $return['rows'][$i]['WechatNickname']!=""?base64_decode($return['rows'][$i]['WechatNickname']):"";
			}
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/MemberForm',$res,true));
		}
		if($do=='edit'){
			$MemberID = $this->GET_DATA['MemberID'];
			$res['data'] = $this->Member_model->GetSingleData($MemberID);
			exit($this->load->view('Content/MemberForm',$res,true));
		}
		if($do=='save'){
			$rs = $this->Member_model->SaveData($this->POST_DATA);
			exit(json_encode($rs));
		}
		if($do=='WeiXinQrcode'){
			$MemberID = intval($this->GET_DATA['MemberID']);
			$img = "upload/wxqrcode/{$MemberID}.jpg";
			if(is_file($img) == false){
				$this->Wechat_model->getQrcode($MemberID,1);
			}
			$res['img'] = base_url($img);
			$tpl = 'Content/MemberWeiXinQrcode';
			exit($this->load->view($tpl,$res,true));
		}
		$this->load->view('Content/Member',$res);
	}
	//--粉丝收益报表
	function AgentReport(){
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=="getData"){
			$rs = $this->Member_model->getAgentListData($this->POST_DATA);
			exit(json_encode($rs));
		}
		$res['MemberID'] = $this->GET_DATA['MemberID'];
		$this->load->view('Content/MemberAgentReport',$res);
	}
	//--订单收益报表
	function OrderReport(){
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=="getData"){
			$rs = $this->Member_model->getAgentOrderListData($this->POST_DATA);
			exit(json_encode($rs));
		}
		$res['MemberID'] = $this->GET_DATA['MemberID'];
		$this->load->view('Content/MemberOrderReport',$res);
	}
}
