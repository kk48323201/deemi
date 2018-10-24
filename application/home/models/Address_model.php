<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Address_model extends CI_Model{
	function __construct(){
  		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
	}
	function getCitysJson(){
		$CityJson = $this->cache->get('CityJson');
		if(!$CityJson){
			$str = '!function(){var citys=';
			$arr = array();
			$Provincial = $this->Data_model->getData(array(),'',0,0,'provincial','ProvincialName,ProvincialID');
			$aa = array();
			for($a=0;$a<count($Provincial);$a++){
				$bb = array();
				$City = $this->Data_model->getData(array('ProvincialID'=>$Provincial[$a]['ProvincialID']),'ID',0,0,'city','CityName,CityID');
				for($b=0;$b<count($City);$b++){
					$cc = array();
					$Areas = $this->Data_model->getData(array('CityID'=>$City[$b]['CityID']),'',0,0,'areas','AreaName');
					foreach($Areas as $itemcc){
						$cc[] = $itemcc['AreaName'];
					}
					$bb[] = array('n'=>$City[$b]['CityName'],'a'=>$cc);
				}
				$aa[] = array('n'=>$Provincial[$a]['ProvincialName'],'c'=>$bb);
			}
			$str .= json_encode($aa,JSON_UNESCAPED_UNICODE);
			$str .= ';if(typeof define==="function"){define(citys)}else{window.YDUI_CITYS=citys}}();';
			$this->cache->save('CityJson',$str);
			return $str;
		}else{
			return $CityJson;
		}
	}
	
	function saveAddress($args){
		$fields = array('AddressID','MemberID','Customer','Phone','WecharAddress','ZdyAddress','lat','lng','TypeID');
		$input = elements($fields,$args,NULL);
		$AddressID = intval($input['AddressID']);unset($input['AddressID']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$input["TypeID"] = intval($input["TypeID"]);
		$input['CreateTime'] = $input['EditTime'] = date("Y-m-d H:i:s");
		if($AddressID < 1){
			$n = $this->Data_model->getDataNum(array('MemberID'=>$_SESSION['MemberID'],'IsDel'=>'0'),'address');
			if($n < 1){
				$input['IsDefault'] = 1;
			}
			$AddressID = $this->Data_model->addData($input,'address');
			if($AddressID){
				return array('code'=>200);
			}else{
				return array('code'=>500);
			}
		}else{
			$this->Data_model->editData(array('AddressID'=>$AddressID,'MemberID'=>$_SESSION['MemberID']),$input,'address');
			return array('code'=>200);
		}
	}
	function AddressListData($args){
		$input = array(
			'MemberID'=>$_SESSION['MemberID'],
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$w = array('MemberID'=>$_SESSION['MemberID'],'IsDel'=>0);
		$data = $this->Data_model->getData($w,'IsDefault desc,CreateTime',$input['rows'],($input['page']-1)*$input['rows'],'address');
		$total = $this->Data_model->getDataNum($w,'address');
		$Member = $this->Data_model->getSingle(array("MemberID"=>$_SESSION["MemberID"],"IsDel"=>"0"),'member');
		$Role = $this->Data_model->getSingle(array("RoleID"=>$Member["RoleID"]),'role');
		$result['rows'] = $data;
		$result['total'] = $total;
		$result['DcAddress'] = $Role["DcAddress"];
		return $result;
	}
	function getAddressData($args){
		if(!isset($args['AddressID'])){
			return array('code'=>500);
		}
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['AddressID'] = intval($args['AddressID']);
		$data = $this->Data_model->getSingle($input,'address');
		if(isset($data['AddressID'])){
			return array('code'=>200,'rows'=>$data);
		}else{
			return array('code'=>500);
		}
	}
	function delAddressData($args){
		if(!isset($args['AddressID'])){
			return array('code'=>500);
		}
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['AddressID'] = intval($args['AddressID']);
		$this->Data_model->editData($input,array('IsDel'=>'1'),'address');
		return array('code'=>200);
	}
	function setAddressDefault($args){
		if(!isset($args['AddressID'])){
			return array('code'=>500);
		}
		$output = array('returnValue'=>0);
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['AddressID'] = intval($args['AddressID']);
		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Member_setAddressDefault',$input,$output);
		return array('code'=>200);
	}
}