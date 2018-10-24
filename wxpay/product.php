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

	public function NotifyProcess($data, &$msg)	{
		$notfiyOutput = array();
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		if($data['result_code'] == 'SUCCESS'){
			$this->chuli($data);
		}
		return true;

	}

	public function chuli($data){
		$db=new mysql('localhost','hearti2016','db88709394','hearti2016',"utf8");
		$out_trade_no = $data['out_trade_no'];
		$member_id = $data['attach'];
		$nowtime = time();

		/* 在线商城处理 */
		$sql = "SELECT * FROM `lee_wechat_payment` where out_trade_no = '".$out_trade_no."' order by createtime desc";	
		$result = $db->query($sql);
		$payment = $db->fetch_array($result);
		$order_ids =  explode(",",$payment['order_id']);
		/*结束微信支付订单*/
		$sql = "update `lee_wechat_payment` set `is_close`='1' where out_trade_no= '".$out_trade_no."' and member_id = '{$member_id}'";
		$db->query($sql);
		foreach($order_ids as $order_id){
			$sql = "SELECT * FROM `lee_order` where order_id = '".$order_id."'";
			$result = $db->query($sql); 
			$order = $db->fetch_array($result);
			if($order['is_pay'] < 1){
				$callback = $data;
				$callback['cash_fee'] = (int)$order['amount']*100;
				if($payment['balance']>0.00){
					$sql = "update `lee_order` set is_pay='1',paytime='".date("Y-m-d H:i:s")."',callback='".json_encode($callback)."',payment='balance',updatetime='".$nowtime."' where order_id='".$order['order_id']."'";	
				}else{
					$sql = "update `lee_order` set is_pay='1',paytime='".date("Y-m-d H:i:s")."',callback='".json_encode($callback)."',updatetime='".$nowtime."' where order_id='".$order['order_id']."'";
				}
				Log::DEBUG("query:" . $sql);
				$db->query($sql);
				
				$member_id = $order['member_id'];
				/*商家名字*/
				$merchant_id = $order['shop_id'];
				$sql = "select * from lee_shop where member_id = '{$merchant_id}'";
				$result = $db->query($sql);
				$merchant = $db->fetch_array($result);
				/*获取会员信息*/
				$sql = "SELECT extension FROM `lee_member` where member_id = '{$member_id}'";
				$result = $db->query($sql);
				$member = $db->fetch_array($result);
				/*插入钱包消费记录*/
				$amount = 0-$order['amount'];
				$remaining = $member['extension'];
				$fname = $merchant['shop_name'];
				$sql = "INSERT INTO `lee_finance` (amount,fname,createtime,member_id,tid,balance,remaining) VALUES('{$amount}','{$fname}','{$nowtime}','{$member_id}','2','income',{$remaining})";
				//Log::DEBUG("query:" . $sql);
				$db->query($sql);
				$this->https_request('http://www.hearti.net/index.php/api/notice/shop_buy/'.$order['order_id']);
			}
		}
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



Log::DEBUG("begin notify");

$notify = new PayNotifyCallBack();

$notify->Handle(false);

