<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(ROOTPATH.'/wxpay/lib/WxPay.Api.php');
require_once(ROOTPATH.'/wxpay/lib/WxPay.Notify.php');
class Notify extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('tags');
		$this->load->model('Order_model');
		$this->load->model('Wechat_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,TRUE);
	}
	function wechat(){
		$notify = new PayNotifyCallBack();
		$notify->Handle(false);
		$rs = $notify->getWeChatResult();
		if(isset($rs['return_code'])&&$rs['return_code']=='SUCCESS'){
			$OutTradeNo = $rs['out_trade_no'];
			$args = array(
				'OutTradeNo'=>$OutTradeNo,
				'PaymentID'=>'1',
				'MetaValue'=>json_encode($rs,JSON_UNESCAPED_UNICODE),
				'PayAmount'=>$rs['cash_fee']/100
			);
			//--记录正常付款
			if($rs['attach'] == 'ServiceOrder'){
				$this->Order_model->updateOrderPayStatus($args);
			}else{
				//--记录面对面收款
				$this->Order_model->addFacePayOrder($args);
			}
		}
		exit($notify->ToXml());
	}
}

class PayNotifyCallBack extends WxPayNotify
{
	public $WeChatResult = array();
	//查询订单
	public function Queryorder($transaction_id){
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS"){
			return true;
		}
		return false;
	}

	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg){
		$notfiyOutput = array();
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}

		if($data['result_code'] == 'SUCCESS'){
			$this->WeChatResult = $data;
		}


		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}

	public function getWeChatResult(){
		return $this->WeChatResult;
	}
}

