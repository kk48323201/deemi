<?php

ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'lib/WxPay.Mysql.php';
require_once 'log.php';
//require("../config.php");


//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{

		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{

			return true;

		}

		return false;

	}
	//重写回调处理函数

	public function NotifyProcess($data, &$msg)

	{

		Log::DEBUG("call back:" . json_encode($data));

		$notfiyOutput = array();

		

		if(!array_key_exists("transaction_id", $data)){

			$msg = "输入参数不正确";

			return false;

		}

		if($data['result_code'] == 'SUCCESS'){

			$this->chuli($data);

		}

		

		//查询订单，判断订单真实性

		if(!$this->Queryorder($data["transaction_id"])){

			$msg = "订单查询失败";

			return false;

		}

		

		return true;

	}

	public function chuli($data){
		$db=new mysql('localhost','hearti2016','db88709394','hearti2016',"utf8");
		$out_trade_no = $data['out_trade_no'];
		$member_id = isset($data['attach'])?$data['attach']:"0";
		$callback = json_encode($data);
		$nowtime = time();
		$sql = "SELECT * FROM `lee_recharge` where sn = '{$out_trade_no}' and member_id = '{$member_id}'";
		$result = $db->query($sql);
		$order = $db->fetch_array($result);
		$amount = $order['amount'];
		/*1.订单更改为已处理*/
		$sql = "update `lee_recharge` set status = '1',callback='{$callback}' where sn = '{$out_trade_no}' and member_id = '{$member_id}'";
		$db->query($sql);
		/*2.充值会员账号*/
		$sql = "update `lee_member` set extension = extension+{$amount} where member_id = '{$member_id}'";
		$db->query($sql);
		/*3.获取会员更改后的信息*/
		$sql = "SELECT extension FROM `lee_member` where member_id = '{$member_id}'";
		$result = $db->query($sql);
		$member = $db->fetch_array($result);
		/*4.更新钱包记录*/
		if($order['payment'] == "wechat"){$fname = "微信充值";}
		if($order['payment'] == "alipay"){$fname = "支付宝充值";}
		$remaining = $member['extension'];
		$sql = "INSERT INTO `lee_finance` (amount,fname,createtime,member_id,tid,balance,remaining) VALUES('{$amount}','{$fname}','{$nowtime}','{$member_id}','3','income',{$remaining})";
		$db->query($sql);
		
	}
	function https_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

}
$notify = new PayNotifyCallBack();
$notify->Handle(false);