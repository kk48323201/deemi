<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Page_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Page_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/PageForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Page_model->getSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('Content/PageForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Page_model->delData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$input = $this->POST_DATA;
			$img = SaveImg($this->POST_DATA['BigThumb'],'page');
			$input['BigThumb'] = $img;
			$rs = $this->Page_model->saveData($input);
			exit(json_encode($rs));
		}
		$this->load->view('Content/Page',$res);
	}
}
