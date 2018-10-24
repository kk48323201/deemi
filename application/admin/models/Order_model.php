<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends CI_Model{
	function __construct(){
  		parent::__construct();
		$this->load->model('Wechat_model');
	}
	function getListData($args){
		$fields = array('page','rows','Status','Customer','Phone');
		$input = elements($fields,$args);
		$input["page"] = empty($args['page'])?1:$args['page'];
		$input["rows"] = empty($args['rows'])?1:$args['rows'];
		$rs=$this->Data_model->execProcSetArr('Manage_Order_getListData',$input);
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	//--保存派遣订单
	function saveDispatchOrderData($args){
		$fields = array('OrderID','MasterID');
		$input = elements($fields,$args);
		$w = array("OrderID"=>$input["OrderID"]);
		$data = $this->Data_model->getSingle($w,"order");
		if(isset($data["Status"])&&$data["Status"]<2&&$input["OrderID"]>0&&$input["MasterID"]>0){
			$MsterData = $this->Data_model->getSingle(array('MemberID'=>$input["MasterID"]),'member');
			$MemberData = $this->Data_model->getSingle(array('MemberID'=>$data["MemberID"]),'member');
			$this->Data_model->editData($w,array("MasterID"=>$input["MasterID"],"Status"=>"1"),"order");
			//--发送通知给客户
			$template_id = 'hLaFcSeFWA-LgdQUchnbcHrRBLP5Jyb8b3eX_4VI6i4';
			$openid = $MemberData['WechatOpenid'];
			$templateData = array(
				'first'=>array('value'=>urlencode('您的服务，已接单成功')),
				'keyword1'=>array('value'=>urlencode($data['Sn'])),
				'keyword2'=>array('value'=>urlencode("预约服务")),
				'keyword3'=>array('value'=>urlencode($MsterData['RealName'])),
				'keyword4'=>array('value'=>urlencode($MsterData['Mobile'])),
				'remark'=>array('value'=>urlencode('预约时间：'.$data['BookingTime'])),
			);
			if($openid != ''){
				$url = site_url('Order/ServiceOrderDetial/'.$data['Sn']);
				$url = str_replace('adminc','index',$url);
				$this->Wechat_model->sendTemplateMsg($openid,$template_id,$templateData,$url);			
			}
			//--派单通知师傅
			$template_id = 'y7qnyFeI7O34Vp524Ry3RPuL8lEoHV4f2CPhBIiJJJM';
			$openid = $MsterData['WechatOpenid'];
			$templateData = array(
				'first'=>array('value'=>urlencode('您好师傅，您有新的派单消息')),
				'keyword1'=>array('value'=>urlencode($data['Sn'])),
				'keyword2'=>array('value'=>urlencode($data['Customer'])),
				'keyword3'=>array('value'=>urlencode("预约服务")),
				'keyword4'=>array('value'=>urlencode($data['BookingTime'])),
				'keyword5'=>array('value'=>urlencode($data['OrderAmount'])),
				'remark'=>array('value'=>urlencode('客户电话：'.$data['Phone'])),
			);
			if($openid != ''){
				$url = site_url('Master/ServiceOrderDetial/'.$data['Sn']);
				$url = str_replace('adminc','index',$url);
				$this->Wechat_model->sendTemplateMsg($openid,$template_id,$templateData,$url);			
			}
			return array("code"=>200);
		}else{
			return array("code"=>500);
		}
	}
	function getSingleData($args){
		$fields = array('OrderID');
		$input = elements($fields,$args);
		$rs=$this->Data_model->execProcSetArr('Manage_Order_getSingleData',$input);
		return array('rows'=>$rs[0][0],'GoodsList'=>$rs[1]);
	}
	function updateStatus($args){
		$fields = array('OrderID','Status');
		$input = elements($fields,$args);
		$output = array('returnValue'=>'0');
		$rs=$this->Data_model->execProcSet('Manage_Order_updateStatusData',$input,$output);
		return array('code'=>$rs['returnValue']);
	}
}