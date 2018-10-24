<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getMemberRoleListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$w = array();
		$data = $this->Data_model->getData($w,"RoleID desc",$input["rows"],($input["page"]-1)*$input["rows"],"role");
		$total = $this->Data_model->getDataNum($w,'role');
		return array("code"=>200,"rows"=>$data,"total"=>$total);
	}
	function getMemberRoleSingleData($args){
		$fields = array('RoleID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle(array("RoleID"=>intval($input["RoleID"])),'role');
		return array('code'=>200,'rows'=>$data);
	}
	function saveMemberRoleData($args){
		$fields = array('RoleID','RoleName','DirectRate','DndirectRate','IsFans','DcAddress','Manage','ShowMap');
		$input = elements($fields,$args); 
		$RoleID = intval($input["RoleID"]);unset($input["RoleID"]);
		$w = array('RoleID'=>$RoleID);
		$result = array('code'=>500,'info'=>'操作失败');
		if($RoleID>0){			 
			$this->Data_model->editData($w,$input,"role");
			return array('code'=>200,'info'=>'操作成功');
		}else{
			$id = $this->Data_model->addData($input,'role');
			if($id>0){
				return array('code'=>200,'info'=>'操作成功');
			}
		}
		return $result;
	}
}