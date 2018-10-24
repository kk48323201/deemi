<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Admin_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('System/ManageForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Admin_model->getSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('System/ManageForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Admin_model->delData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$rs = $this->Admin_model->saveData($this->POST_DATA);
			exit(json_encode($rs));
		}
		$this->load->view('System/Manage',$res);
	}
}
