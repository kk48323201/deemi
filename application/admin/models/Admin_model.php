<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function login($args){
		$fields = array('AdminUser','AdminPassword');
		$input = elements($fields,$args);
		$input['AdminPassword'] = dd_password($input['AdminPassword']);
		$rs = $this->Data_model->execProcSetArr('Manage_Admin_LoginData',$input);
		if(isset($rs[0][0]["AdminID"])){
			$_SESSION["AdminID"] = $rs[0][0]["AdminID"];
			$_SESSION["AdminUser"] = $rs[0][0]["AdminUser"];
			return array('code'=>200);
		}
		return array('code'=>500);
	}
	function checkLogin(){
		if(!isset($_SESSION["AdminID"])){
			 redirect(site_url("Home/Login"));
		}
	}
	function getSingleData($args){
		$fields = array('AdminID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,"admin");
		unset($data["AdminPassword"]);
		return array('code'=>200,'rows'=>$data);
	}
	function getListData($args){
		$data = $this->Data_model->getData(array(),"AdminID desc","0","0","admin","AdminID,AdminUser");
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('AdminID','AdminUser','AdminPassword');
		$input = elements($fields,$args);
		if(intval($input["AdminID"]) > 0){
			if(empty($input["AdminPassword"])){
				unset($input["AdminPassword"]);
			}else{
				$input["AdminPassword"] = dd_password($input['AdminPassword']);
			}
			$this->Data_model->editData(array("AdminID"=>$input["AdminID"]),$input,"admin");
		}else{
			if(!empty($input["AdminPassword"])){
				unset($input["AdminID"]);
				$input["AdminPassword"] = dd_password($input['AdminPassword']);
				$this->Data_model->addData($input,"admin");
			}
		}
		return array('code'=>200);
	}
	function delData($args){
		$fields = array('AdminID');
		$input = elements($fields,$args);
		if(intval($input["AdminID"]) != 1){
			$AdminID = intval($input["AdminID"]);
			$this->Data_model->delData($AdminID,"admin");
		}
		return array('code'=>200);
	}
}