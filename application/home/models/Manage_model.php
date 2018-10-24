<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getMemberListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_Manage_getMemberListData',$input);
		if($rs[0][0]["returnValue"]==200){
			return array('code'=>$rs[0][0]["returnValue"],'rows'=>$rs[1],'total'=>$rs[2][0]['total']);
		}else{
			return array('code'=>$rs[0][0]["returnValue"],'rows'=>array(),'total'=>0);
		}
	}
	function getSingleMember($args){
		$fields = array("MemberID");
		$input = elements($fields,$args);
		$rs=$this->Data_model->execProcSet('Font_Manage_getSingleMemberData',$input);
		return array('rows'=>$rs[0]);
	}
	function saveMemberData($args){
		$fields = array("MemberID","lat","lng","RoleID","WecharAddress","RealName");
		$input = elements($fields,$args);
		$output = array("returnValue"=>0);
		$rs=$this->Data_model->execProcSet('Font_Manage_saveMemberData',$input,$output);
		return array('code'=>$rs["returnValue"]);
	}
}