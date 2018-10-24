<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Course_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Course_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/CourseForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Course_model->getSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('Content/CourseForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Course_model->delData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$input = $this->POST_DATA;
			$img = SaveImg($this->POST_DATA['BigThumb'],'article');
			$input['BigThumb'] = $img;
			$rs = $this->Course_model->saveData($input);
			exit(json_encode($rs));
		}
		$this->load->view('Content/Course',$res);
	}
}
