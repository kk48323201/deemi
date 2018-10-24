<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->helper("captcha");
		$this->load->model('Public_model');
		$this->load->model('Admin_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,TRUE);
	}
	public function Login(){
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do=='login'){
			if($this->POST_DATA["Captcha"]!=$_SESSION["Captcha"]){
				AjaxReturn(array("code"=>501));
			}
			$rs=$this->Admin_model->login($this->POST_DATA);
			AjaxReturn($rs);
		}
		$res['captcha'] = $this->Public_model->cap();
		$this->load->view('Login',$res);
	}
	public function Captcha(){
		echo $this->Public_model->cap();
	}
	public function Logout(){
		session_destroy();
		redirect(site_url("Home/Login"));
	}
	public function test(){
		echo dd_password("bgadmin88");
	}
}
