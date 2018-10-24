<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Member_model->ListData($this->POST_DATA);
			for($i=0;$i<count($return);$i++){
				$return[$i]['WechatNickname'] = base64_decode($return[$i]['WechatNickname']);
			}
			exit(json_encode($return));
		}
		if($do=='Add'){
			exit($this->load->view('Market/MemberForm',$res,true));
		}
		if($do=='Edit'){
			$MemberID = $this->GET_DATA['MemberID'];
			$res['data'] = $this->Member_model->GetSingleData($MemberID);
			exit($this->load->view('Market/MemberForm',$res,true));
		}
		if($do=='Save'){
			$rs = $this->Member_model->SaveData($this->POST_DATA);
			exit(json_encode($rs));
		}
		$this->load->view('Market/Member',$res);
	}
}
