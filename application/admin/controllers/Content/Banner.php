<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Banner_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Banner_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/BannerForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Banner_model->getSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('Content/BannerForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Banner_model->delData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$input = $this->POST_DATA;
			$input['BigThumb']=SaveImg($this->POST_DATA['BigThumb'],'banner');
			$rs = $this->Banner_model->SaveData($input);
			exit(json_encode($rs));
		}
		if($do=="getCatListData"){
			$return=$this->Banner_model->getCatListData($this->GET_DATA);
			exit(json_encode($return["rows"]));
		}
		$this->load->view('Content/Banner',$res);
	}
}
