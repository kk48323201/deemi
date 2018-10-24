<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Course_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Course_getListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('CourseID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,'course');
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('CourseID','CourseName','Price','Content','Status','BigThumb','ExperienceTime','Welfare','Tips','Description','Shop','Tel');
		$input = elements($fields,$args);
		$input['CreateTime'] = intval($input['CourseID'])<1?date("Y-m-d H:i:s"):"";
		if($input['CreateTime'] == ""){
			unset($input['CreateTime']);
		}
		$CourseID = intval($input['CourseID']);unset($input['CourseID']);
		if($CourseID > 0){
			$this->Data_model->editData(array('CourseID'=>$CourseID),$input,'course');
		}else{
			$this->Data_model->addData($input,'course');
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('CourseID');
		$input = elements($fields,$args);
		$this->Data_model->editData($input,array('IsDel'=>1),'course');
		return array('code'=>200);
	}
}