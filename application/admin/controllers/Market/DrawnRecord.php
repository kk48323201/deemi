<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DrawnRecord extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('DrawnRecord_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->DrawnRecord_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='update'){
			$rs = $this->DrawnRecord_model->updateStatus($this->GET_DATA);
			exit(json_encode($return));
		}
		$this->load->view('Market/DrawnRecord',$res);
	}
}
