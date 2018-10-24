<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->model('Main_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,TRUE);
		$this->Admin_model->checkLogin();
	}
	public function index()
	{
		$get = $this->input->get(NULL,TRUE);
		$res = array();
		$menu = $this->Data_model->getData(array("IsDisplay"=>"1"),'CreateTime desc',0,0,"systemmodule");
		foreach($menu as $item){
			if($item["ParentModuleID"]<1){
				$res["menu"][$item["ModuleID"]]['Module'] = $item;	
			}else{
				$res["menu"][$item["ParentModuleID"]]['Child'][$item["ModuleID"]] = $item;
			}
		}
		$this->load->view('Main',$res);
	}
	public function category(){
		$data = $this->Data_model->getData(array('Status'=>1),'ListOrder',0,0,'category');
		$data[0]['selected'] = 'true';
		exit(json_encode($data));
	}
	public function Transport(){
		$data = $this->Data_model->getData(array('IsDel'=>0,"MerchantsID"=>"0"),'CreateTime desc',0,0,'transport_template');
		$data[0]['selected'] = 'true';
		exit(json_encode($data));
	}
	public function Dashboard(){
		$this->load->view('Dashboard');
	}
}
