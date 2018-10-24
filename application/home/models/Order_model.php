<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	//--新增面对面付款记录
	function addFacePayOrder($args){
		$input['OutTradeNo'] = trim($args['OutTradeNo']);
		$input['PaymentID'] = $args['PaymentID'];
		$input['MetaValue'] = $args['MetaValue'];
		$input['PayAmount'] = $args['PayAmount'];
		$output = array('returnValue'=>0);
		$result = $this->Data_model->execProcSet('Font_Order_addFacePayData',$input,$output);
		return true;
	}
	//--创建面对面付款订单
	function CreateFacePaymentOrder($args){
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['Amount'] = $args['Amount'];
		$rs = $this->Data_model->execProcSet('Font_Order_CreateFacePaymentOrder',$input);
		if(isset($rs[0]['code'])&&$rs[0]['code']==200){
			return self::WechatJsapi('FaceOrder',$rs[0]['OutTradeNo'],$rs[0]['OrderAmount']);
		}else{
			return array('code'=>500,'rows'=>'微信无法支付');
		}
	}
	function CreatePaymentOrder($Sn){
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['Sn'] = $Sn;
		$rs = $this->Data_model->execProcSet('Font_Order_CreatePaymentOrder',$input);
		if(isset($rs[0]['code'])&&$rs[0]['code']==200){
			return self::WechatJsapi('ServiceOrder',$rs[0]['OutTradeNo'],$rs[0]['OrderAmount']);
		}else{
			return array('code'=>500,'rows'=>'微信无法支付');
		}
	}
	function WechatJsapi($Attach,$OutTradeNo,$OrderAmount){
		$WechatOpenid = $_SESSION['wechat']['openid'];
		$Notify_url = site_url('Api/Notify/wechat');
		require_once(ROOTPATH."/wxpay/lib/WxPay.Api.php");
		require_once(ROOTPATH."/wxpay/WxPay.JsApiPay.php");
		$tools = new JsApiPay();
		$input = new WxPayUnifiedOrder();
		$input->SetBody('洗哥');
		$input->SetAttach($Attach);
		$input->SetOut_trade_no($OutTradeNo);
		$input->SetTotal_fee($OrderAmount*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url($Notify_url);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($WechatOpenid);
		$WechatOrder = WxPayApi::unifiedOrder($input);
		if(isset($WechatOrder['return_code']['FAIL'])){
			return array('code'=>500,'rows'=>$WechatOrder['return_code']['FAIL']);
		}
		$jsApiParameters = $tools->GetJsApiParameters($WechatOrder);
		return array('code'=>'200','rows'=>json_decode($jsApiParameters,true));
	}
	//--更改订单支付状态,异步通知服务支付成功
	function updateOrderPayStatus($args){
		$input['OutTradeNo'] = trim($args['OutTradeNo']);
		$input['PaymentID'] = $args['PaymentID'];
		$input['MetaValue'] = $args['MetaValue'];
		$input['PayAmount'] = $args['PayAmount'];
		$output = array('returnValue'=>0);
		$result = $this->Data_model->execProcSet('Font_Order_updatePayStatus',$input,$output);
		return true;
	}
	//保存服务订单
	function SaveServiceOrderData($args){
		$fields = array('MemberID','AddressID','Remark','BookingTime',"CartXml");
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];
		$input['BookingTime'] = $input['BookingTime'].':00';
		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Order_SaveServiceData',$input,$output);
		return array('code'=>$rs["returnValue"]);
	}
	function getSingleData($args){
		$fields = array('MemberID','Sn');
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];
		$rs = $this->Data_model->execProcSetArr('Font_Order_getSingleData',$input);
		return array('code'=>200,'rows'=>$rs[0][0],'ServiceList'=>$rs[1]);
	}
	//--保存评论
	function SaveComments($args){
		$fields = array('OrderID','MemberID','Remark','Simple');
		$input = elements($fields,$args);
		$input['MemberID'] = $_SESSION['MemberID'];
		$output = array('returnValue'=>0);
		$rs=$this->Data_model->execProcSet('Font_Order_SaveComments',$input,$output);
		return array('code'=>$rs["returnValue"]);
	}
}