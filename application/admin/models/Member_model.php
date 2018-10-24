<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	/*
	创建视图
	CREATE OR REPLACE view dm_member_view as 
	select m.Mobile,m.MemberID,m.Email
	m.WechatOpenid,m.WechatNickname,m.WechatProvince,m.WechatCity,m.WechatHeadimgurl,m.WechatSex,m.WechatUnionid,
	m.RealName,m.IsManage,m.ReferrerID,m.SalesmanID,m.CreateTime,m.Status
	from dm_member as m where IsDel='0'
	*/
	function ListData($args){
		
		$fields = array("rows","page");
		$input = elements($fields,$args);
		$input["rows"] = empty($args['rows'])?20:$args['rows'];
		$input["page"] = empty($args['page'])?1:$args['page'];
		$w = array('IsDel'=>'0');
		$data = $this->Data_model->getData($w,"MemberID desc",$input["rows"],($input["page"]-1)*$input["rows"],"member");
		$RoleData = $this->Data_model->getData("","",0,0,"role");
		for($i=0;$i<count($data);$i++){
			foreach($RoleData as $item){
				if($item['RoleID'] == $data[$i]['RoleID']){
					$data[$i]['RoleName'] = $item['RoleName'];
				}
			}
		}
		$total = $this->Data_model->getDataNum($w,'member');
		for($i=0;$i<count($data);$i++){
			unset($data[$i]['Password']);
		}
		return array("code"=>200,"rows"=>$data,"total"=>$total);
	}
	function getSingleData($MemberID){
		$data = $this->Data_model->getSingle(array('MemberID'=>intval($MemberID)),'member');
		return $data;
	}
	function SaveData($args){
		$fields = array('MemberID','Mobile','Email','Password','Status','RealName','RoleID');
		$input = elements($fields,$args);
		$MemberID = intval($input["MemberID"]);unset($input["MemberID"]);
		if($MemberID < 1){
			$input["Password"] = $input["Password"]!=""?dd_password($input["Password"]):dd_password(time());
		}else{
			if($input["Password"]!=""){
				$input["Password"] = dd_password($input["Password"]);
			}else{
				unset($input["Passsword"]);
			}
		}
		$c = $this->Data_model->getDataNum(array("Mobile"=>$input['Mobile'],"MemberID !="=>$MemberID),"member");
		if($c > 0){
			return array('code'=>500,'info'=>'手机号码已存在');
		}
		if($MemberID>0){			
			$input["EditTime"] = date("Y-m-d H:i:s");
			$this->Data_model->editData(array('MemberID'=>$MemberID),$input,"member");
			return array('code'=>200,'info'=>'操作成功');
		}else{
			$input["EditTime"] = $input["CreateTime"] = date("Y-m-d H:i:s");
			$id = $this->Data_model->addData($input,'member');
			if($id>0){
				return array('code'=>200,'info'=>'操作成功');
			}else{
				return array('code'=>500,'info'=>'操作失败');
			}
		}
	}
	function getDispatchMasterList(){
		$rs = $this->Data_model->getData(array('IsDel'=>0,'RoleID'=>1,'Status'=>'1'),'',0,0,'member');
		return array('code'=>200,'rows'=>$rs);
	}
	//--获取代理粉丝
	function getAgentListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$rs=$this->Data_model->execProcSetArr('Font_Member_getAgentListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	//--获取代理粉丝
	function getAgentOrderListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$rs=$this->Data_model->execProcSetArr('Font_Member_getAgenOrdertListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
}