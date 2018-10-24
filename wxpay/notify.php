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
	public function Queryorder($transaction_id){
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
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
		$member_id = $data['attach'];
		
		//查询课程订单信息
		$sql = "SELECT * FROM `lee_order` where sn = '".$out_trade_no."'";
		$result = $db->query($sql); 
		$order = array();
		while($row=$db->fetch_array($result)) { 
			$order = $row; 
		}
		$nowtime = time();
		if(count($order) > 0){
		$total_fee = $data['total_fee']/100;
		$total_fee = number_format($total_fee,2,".","");
			if($order['is_pay'] < 1){
				$sql = "update `lee_order` set is_pay='1',paytime='".date("Y-m-d H:i:s")."',callback='".json_encode($data)."',updatetime='".$nowtime."' where order_id='".$order['order_id']."'";
				$db->query($sql);
				//生成qrcode,查詢商家總qrcode數量
				$sql = "select * from `lee_order_goods` where order_id = '".$order['order_id']."'";
				$result = $db->query($sql);
				while($row=$db->fetch_array($result)) { 
					$orderlist = $row;break; 
				}
				
				if(isset($orderlist['model_id']) && $orderlist['model_id'] == '2'){
					$sql = "INSERT INTO `lee_qrcode` (order_goods_id,member_id,status,updatetime,merchants_id,createtime) VALUES('".$orderlist['order_goods_id']."','".$order['member_id']."','waiting','".$nowtime."','".$order['shop_id']."','".$nowtime."')";
					$result = $db->query($sql);
				}
				/*处理邀请码模块*/
				if($orderlist['desc']!=''){
					$desc = unserialize($orderlist['desc']);
					$is_yaoqingma = false;
					if(isset($desc['is_yaoqingma'])&&(string)$desc['is_yaoqingma']=='1'){
						$is_yaoqingma = true;
					}else{
						$sql = "select * from `lee_goods` where goods_id = '".$orderlist['goods_id']."'";
						$result = $db->query($sql);
						$goods = $db->fetch_array($result);
						if(isset($goods['goods_id'])&&(string)$goods['is_yaoqingma']=='1'){
							$is_yaoqingma = true;
						}
					}
					if($is_yaoqingma == true){
						$sql = "update `lee_yaoqingma_log` as log left join lee_yaoqingma as y on log.yaoqingma_id = y.yaoqingma_id
								set y.use_number = use_number - 1 where log.order_id = '".$orderlist['order_id']."'";
						$result = $db->query($sql);
					}
				}
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
				$fname = $merchant['shop_name'];
				$remaining = $member['extension'];
				$sql = "INSERT INTO `lee_finance` (amount,fname,createtime,member_id,tid,balance,remaining) VALUES('{$amount}','{$fname}','{$nowtime}','{$member_id}','2','income',{$remaining})";
				$db->query($sql);
				$this->https_request('http://www.hearti.net/index.php/api/notice/order/paysuccess/'.$order['order_id']);
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


$notify = new PayNotifyCallBack();

$notify->Handle(false);

