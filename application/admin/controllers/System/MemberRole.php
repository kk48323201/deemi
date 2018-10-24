<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberRole extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Setting_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Setting_model->getMemberRoleListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='edit'){
			$rs = $this->Setting_model->getMemberRoleSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('System/MemberRoleForm',$res,true));
		}
		if($do=='save'){
			$input = $this->POST_DATA;
			$rs = $this->Setting_model->saveMemberRoleData($input);
			exit(json_encode($rs));
		}
		$this->load->view('System/MemberRole',$res);
	}
}
