<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->load->model('Manage_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function Member()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=='getData'){
			$rs = $this->Manage_model->getMemberListData($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=='getSingle'){
			$rs = $this->Manage_model->getSingleMember($this->GET_DATA);
			AjaxReturn($rs);
		}
		if($do=='save'){
			$rs = $this->Manage_model->saveMemberData($this->POST_DATA);
			AjaxReturn($rs);
		}
		$RoleData = $this->Data_model->getData("","",0,0,'role');
		$tmpData = array();
		foreach($RoleData as $item){
			$tmpData[] = array(
				'title'=>$item['RoleName'],
				'value'=>$item['RoleID'],
			);
		}
		$res['RoleData'] = $tmpData;
		
		$tpl = "Manage/Member";
		$this->load->view($tpl,$res);
	}
}
