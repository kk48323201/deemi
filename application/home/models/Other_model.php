<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Other_model extends CI_Model{
	function __construct(){
  		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->library('encrypt');
		$this->load->model('Qcloudsms_model');
	}

	function SendCode($args){
		$fields = array('Mobile','Code','MemberID');
		$input = elements($fields,$args,NULL);
		$input["Code"]=rand(100000,999999);
		$input['MemberID'] = $_SESSION['MemberID'];
		if(empty($input["Mobile"])){
			return array("code"=>500,'info'=>'请输入手机号码');
		}
		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Other_sendSmsCode',$input,$output);
		if($rs['returnValue'] == 200){
			$result = $this->Qcloudsms_model->sendsms($input['Mobile'],$input['Code']);
			if(isset($result['errmsg'])){
				if($result['errmsg']!='OK'){
					return array('code'=>501,'info'=>'发送失败');
				}
			}else{
				return array('code'=>502,'info'=>'发送失败');
			}
		}
		if($rs['returnValue'] == 200){
			return array('code'=>$rs['returnValue'],'info'=>'发送成功');
		}elseif($rs['returnValue'] == 500){
			return array('code'=>$rs['returnValue'],'info'=>'请一分钟后才尝试');
		}elseif($rs['returnValue'] == 501){
			return array('code'=>$rs['returnValue'],'info'=>'今次发送次数超过限制');
		}else{
			return array('code'=>$rs['returnValue'],'info'=>'操作失败');
		}
	}

}