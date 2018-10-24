<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qcloudsms_model extends CI_Model{
	var $appid,$appkey;
	function __construct(){
  		parent::__construct();
		// 短信应用SDK AppID
		$this->appid = 	'1400143324'; // 1400开头		
		// 短信应用SDK AppKey
		$this->appkey = "4bd97c5e09b2300a410e8ab39ad2f3f3";
	}
	function sendsms($Mobile,$Code){
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsMobileStatusPuller.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsMultiSender.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsSenderUtil.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsSingleSender.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsStatusPuller.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsVoicePromptSender.php");
		require_once(ROOTPATH."application/home/libraries/qcloudsms/SmsVoiceVerifyCodeSender.php");
		
		$ssender = new Qcloud\Sms\SmsSingleSender($this->appid, $this->appkey);
		$templateId = 212532;
		$params = [$Code];
    	$result = $ssender->sendWithParam("86", $Mobile, $templateId,
        $params, "", "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
    	$rsp = json_decode($result,true);
		return $rsp;
	}
}