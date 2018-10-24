<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member_model extends CI_Model{
	function __construct(){
  		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->library('encrypt');
	}
	
	function RegMember($Mobile){
		$n = $this->Data_model->getDataNum(array('Mobile'=>$Mobile,'IsDel'=>'0'),"member");
		if($n<1){
			$data = array();
			$data['Mobile'] = $Mobile;
			$data['CreateTime'] = $data['EditTime'] = date("Y-m-d H:i:s");
			$data['Password'] = dd_password(rand(123456,999999));
			$this->Data_model->addData($data,'member');
			return true;
		}
		return false;
	}
	public function checkManage(){
		if(!isset($_SESSION['IsManage'])){
			redirect(site_aurl('login'));
		}else{
			if($_SESSION['IsManage']!='1'){
				redirect(site_aurl('login'));
			}	
		}
		
	}
	public function checkLogin($cururl=''){
		if(!isset($_SESSION['wechat']['openid'])){
			$url = getCurUrl();
			if($cururl!=''){
				redirect('Wechat/login?backurl='.$cururl);
			}else{
				redirect('Wechat/login?backurl='.$url);
			}
		}else{
			if(!isset($_SESSION['IsMember'])){
				$w = array('WechatOpenid'=>$_SESSION['wechat']['openid'],'IsDel'=>'0');
				$n = $this->Data_model->getDataNum($w,"member");
				if($n<1){
					$data = array();
					$data['WechatOpenid'] = $_SESSION['wechat']['openid'];
					$data['WechatNickname'] = base64_encode($_SESSION['wechat']['nickname']);
					$data['WechatProvince'] = $_SESSION['wechat']['province'];
					$data['WechatCity'] = $_SESSION['wechat']['city'];
					$data['WechatHeadimgurl'] = $_SESSION['wechat']['headimgurl'];
					$data['WechatSex'] = $_SESSION['wechat']['sex'];
					$data['WechatUnionid'] = isset($_SESSION['wechat']['unionid'])?$_SESSION['wechat']['unionid']:"";
					$data['CreateTime'] = $data['EditTime'] = date("Y-m-d H:i:s");
					$data['Password'] = dd_password(rand(123456,999999));
					$data['Mobile'] = '';
					$data['Email'] = '';
					$this->Data_model->addData($data,'member');
				}else{
					$data = array();
					$data['WechatOpenid'] = $_SESSION['wechat']['openid'];
					$data['WechatNickname'] = base64_encode($_SESSION['wechat']['nickname']);
					$data['WechatProvince'] = $_SESSION['wechat']['province'];
					$data['WechatCity'] = $_SESSION['wechat']['city'];
					$data['WechatHeadimgurl'] = $_SESSION['wechat']['headimgurl'];
					$data['WechatSex'] = $_SESSION['wechat']['sex'];
					$data['WechatUnionid'] = isset($_SESSION['wechat']['unionid'])?$_SESSION['wechat']['unionid']:"";
					
					$this->Data_model->editData($w,$data,'member');
				}
				$Member = self::getMemberByWechatOpenid($_SESSION['wechat']['openid']);
				self::setLogin($Member);
				$_SESSION['IsMember'] = '1';
			}
		}
		return true;
	}
	public function checkLogin2($cururl=''){
		if(!isset($_SESSION['wechat']['openid'])){
			$url = getCurUrl();
			if($cururl!=''){
				redirect('Wechat/login?backurl='.$cururl);
			}else{
				redirect('Wechat/login?backurl='.$url);
			}
		}else{
			
			if(!isset($_SESSION['IsMember'])){
				$w = array('WechatOpenid'=>$_SESSION['wechat']['openid'],'IsDel'=>'0');
				$n = $this->Data_model->getDataNum($w,"member");
				if($n<1){
					$data = array();
					$data['WechatOpenid'] = $_SESSION['wechat']['openid'];
					$data['WechatNickname'] = base64_encode($_SESSION['wechat']['nickname']);
					$data['WechatProvince'] = $_SESSION['wechat']['province'];
					$data['WechatCity'] = $_SESSION['wechat']['city'];
					$data['WechatHeadimgurl'] = $_SESSION['wechat']['headimgurl'];
					$data['WechatSex'] = $_SESSION['wechat']['sex'];
					$data['WechatUnionid'] = isset($_SESSION['wechat']['unionid'])?$_SESSION['wechat']['unionid']:"";
					$data['CreateTime'] = $data['EditTime'] = date("Y-m-d H:i:s");
					$data['Password'] = dd_password(rand(123456,999999));
					$data['Mobile'] = '';
					$data['Email'] = '';
					$this->Data_model->addData($data,'member');
				}else{
					$data = array();
					$data['WechatOpenid'] = $_SESSION['wechat']['openid'];
					$data['WechatNickname'] = base64_encode($_SESSION['wechat']['nickname']);
					$data['WechatProvince'] = $_SESSION['wechat']['province'];
					$data['WechatCity'] = $_SESSION['wechat']['city'];
					$data['WechatHeadimgurl'] = $_SESSION['wechat']['headimgurl'];
					$data['WechatSex'] = $_SESSION['wechat']['sex'];
					$data['WechatUnionid'] = isset($_SESSION['wechat']['unionid'])?$_SESSION['wechat']['unionid']:"";
					$this->Data_model->editData($w,$data,'member');
				}
				$Member = self::getMemberByWechatOpenid($_SESSION['wechat']['openid']);
				self::setLogin($Member);
				$_SESSION['IsMember'] = '1';
			}
		}
		return true;
	}
	function AutoRegByWechat($Openid){
		$n = $this->Data_model->getDataNum(array('WechatOpenid'=>$Openid,'IsDel'=>'0'),"member");
		if($n<1){
			$obj = $this->Wechat_model->getWinXinUser($Openid);
			$wechat = json_decode($obj,true);
			if(isset($wechat['nickname'])){
				$data['WechatOpenid'] = $Openid;
				$data['WechatNickname'] = base64_encode($wechat['nickname']);
				$data['WechatProvince'] = $wechat['province'];
				$data['WechatCity'] = $wechat['city'];
				$data['WechatHeadimgurl'] = $wechat['headimgurl'];
				$data['WechatSex'] = $wechat['sex'];
				$data['WechatUnionid'] = isset($wechat['unionid'])?$wechat['unionid']:"";
				$data['CreateTime'] = $data['EditTime'] = date("Y-m-d H:i:s");
				$data['Password'] = dd_password(rand(123456,999999));
				$data['Mobile'] = '';
				$data['Email'] = '';
				$this->Data_model->addData($data,'member');
			}
		}
	}
	function MobileLogin($args){
		$fields = array('Mobile','vcode');
		$other_fields = array('vcode');
		$input = elements($fields,$args);
		$rs=$this->Data_model->execProcSet('Front_Member_MobileLogin',$input);
		if(isset($rs[0]["MemberID"])){
			if(is_weixin()==false){
				self::setLogin($rs[0]);
			}
			return array("code"=>200);
		}else{
			return array("code"=>500);
		}
	}
	function setLogin($data){
		foreach($data as $k=>$v){$_SESSION[$k]=$v;}
		return true;
	}
	function getMemberByWechatOpenid($WechatOpenid){
		$tmpData = $this->Data_model->getSingle(array("WechatOpenid"=>$WechatOpenid,'IsDel'=>'0'),"member");
		if(!isset($tmpData['MemberID'])){
			return array();
		}
		$fields = array('MemberID','Mobile','RealName','CreateTime','WechatOpenid','WechatNickname','WechatProvince','WechatCity','WechatHeadimgurl','WechatSex','WechatUnionid','RoleID');
		$result = elements($fields,$tmpData,NULL);
		$result['WechatNickname'] = $result['WechatNickname']!=''?base64_decode($result['WechatNickname']):"";
		return $result;
	}
	//--获取会员订单
	function getOrderData($args){
		$fields = array("MemberID","Status","page","rows");
		$input = elements($fields,$args);
		$input["MemberID"] = $_SESSION["MemberID"];
		$input["Status"] = 	isset($input['Status'])?$input['Status']:-1;
		$input["page"] = empty($input['page'])?1:$input['page'];
		$input["rows"] = empty($input['rows'])?15:$input['rows'];
		$rs=$this->Data_model->execProcSetArr('Font_Member_getOrderListData',$input);
		$result = array(
			'code'=>200,
			'total'=>$rs[1][0]['total'],
			'rows'=>$rs[0],
		);
		return $result;	
	}
	//--绑定手机号码
	function savePhoneTask($args){
		$fields = array("Mobile","Code","MemberID");
		$input = elements($fields,$args);
		$w = array('Content'=>$input['Code'],'MemberID'=>$_SESSION['MemberID'],'Mobile'=>$input['Mobile']);
		$c = $this->Data_model->getDataNum($w,'sms');
		if($c < 1){
			return array('code'=>500,'info'=>'验证码错误');
		}else{
			$this->Data_model->editData(array('MemberID'=>$_SESSION['MemberID']),array('Mobile'=>$input['Mobile']),'member');
			$_SESSION['Mobile'] = $input["Mobile"];
			return array('code'=>200,'info'=>'操作成功');
		}
	}
	//--邀请注册,发布邀请会员，受邀会员，同时绑定永久推广关系
	function WxInviteRecord($MemberID,$Openid){
		$this->load->driver('cache', array('adapter' =>'file'));
		//--判断是否已经注册,若没则自动注册
		$this->AutoRegByWechat($Openid);
		$this->db->reconnect();
		//--邀请人
		$MemberData = $this->Data_model->getSingle(array('IsDel'=>0,'MemberID'=>$MemberID),'member');
		//-被邀请人
		if (!$Customer = $this->cache->get($Openid)){
			$Customer = $this->getMemberByWechatOpenid($Openid);	
			$this->cache->save($Openid,$Customer, 21600);
		}
		
		$input=array('MemberID'=>$MemberID,'CustomerID'=>$Customer['MemberID']);
		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Wechat_saveInviteRecord',$input,$output);
		$this->db->close();
$this->db->initialize();
		if($rs['returnValue']==200){
			//--邀请成功，发送模板消息
			//$this->WxTmplmsg_model->memberJoinSuccess($MemberID,$Customer);
		}else{
			$RoleData = $this->Data_model->getSingle(array('RoleID'=>$MemberData['RoleID']),'role');
			//--发送失败通知给客户
			$template_id = 'P2_A42ipcLomjGyB3X-Cku59RimoKxWrUcneP0nOtvM';
			$openid = $MemberData['WechatOpenid'];
			$templateData = array(
				'first'=>array('value'=>urlencode($Customer['WechatNickname'].'扫码失败')),
				'keyword1'=>array('value'=>urlencode('这是别人的粉丝')),
				'keyword2'=>array('value'=>urlencode(date("Y-m-d H:i:s"))),
				'remark'=>array('value'=>urlencode('吸收更多的新粉丝，获取更多的收益机会')),
			);
			if($openid != '' && $RoleData['IsFans'] > 0){
				$this->Wechat_model->sendTemplateMsg($openid,$template_id,$templateData,'');	
			}
		}
		return array('code'=>$rs['returnValue']);
	}
	//--获取会员中心数据
	function getMemberCenterData(){
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSet('Font_Member_getCenterData',$input);
		return $rs[0];
	}
	//--记录会员位置
	function setLocation($args){
		$MemberID = $_SESSION["MemberID"];
		$fields = array("lng","lat");
		$input = elements($fields,$args);
		$this->Data_model->editData(array('MemberID'=>$MemberID),$input,'member');
	}
	//--获取钱包金额
	function getPurseInfo($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_Member_getPurseInfo',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total'],'totalAmount'=>$rs[1][0]['totalAmount']);
	}
	//--获取申请提现记录
	function getDrawnListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_Member_getDrawnListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	//--获取地图标记
	function getMapMarketData(){
		$sql = "SELECT A.MemberID,A.lat,A.lng,A.RealName FROM dm_member as A
		left join dm_role as B on A.RoleID = B.RoleID WHERE A.IsDel='0' and B.ShowMap = 1 and A.lat != '' and A.lng !='' and A.RealName!=''";
  		$query = $this->db->query($sql);
		$rs = array();
		foreach ($query->result_array() as $row){
			$rs[] = $row;
		}
		return $rs;
	}
	//--获取代理粉丝
	function getAgentListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_Member_getAgentListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	//--获取代理粉丝
	function getAgentOrderListData($args){
		$fields = array("MemberID","page","rows");
		$input = elements($fields,$args);
		$input['page'] = intval($input['page']) < 1?1:intval($input['page']);
		$input['rows'] = intval($input['rows']) < 1?20:intval($input['rows']);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs=$this->Data_model->execProcSetArr('Font_Member_getAgenOrdertListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
}