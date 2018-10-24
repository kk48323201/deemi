<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$this->Member_model->checkLogin();
		$tpl = "Service/Home";
		$res['PageID'] = $this->GET_DATA['PageID'];
		$this->load->view($tpl,$res);
	}
}
