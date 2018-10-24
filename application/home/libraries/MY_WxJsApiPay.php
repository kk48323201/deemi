<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/Payment/WxpaylibService/WxPay.Api.php';

class MY_WxJsApiPay{
	public $data = null;
	public $WxConfig;
	
	public function setConfig($WxConfig){
		$this->WxConfig = $WxConfig;
	}
	public function GetOpenid(){
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
			$url = $this->_CreateOauthUrlForCode($baseUrl);
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$openid = $this->getOpenidFromMp($code);
			return $openid;
		}
	}
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
		|| !array_key_exists("prepay_id", $UnifiedOrderResult)
		|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}

		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);

		$config = $this->WxConfig;
		$jsapi->SetPaySign($jsapi->MakeSign($config));
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
	public function GetOpenidFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);

		//初始化curl
		$ch = curl_init();
		$curlVersion = curl_version();
		$config = $this->WxConfig;
		$ua = "WXPaySDK/3.0.9 (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version']." "
		.$config->GetMerchantId();

		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$proxyHost = "0.0.0.0";
		$proxyPort = 0;
		$config->GetProxy($proxyHost, $proxyPort);
		if($proxyHost != "0.0.0.0" && $proxyPort != 0){
			curl_setopt($ch,CURLOPT_PROXY, $proxyHost);
			curl_setopt($ch,CURLOPT_PROXYPORT, $proxyPort);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}
	private function ToUrlParams($urlObj){
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	public function GetEditAddressParameters()
	{	
		$config = $this->WxConfig;
		$getData = $this->data;
		$data = array();
		$data["appid"] = $config->GetAppId();
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = WxPayApi::getNonceStr();
		$data["accesstoken"] = $getData["access_token"];
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => $config->GetAppId(),
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	private function _CreateOauthUrlForCode($redirectUrl)
	{
		$config = $this->WxConfig;
		$urlObj["appid"] = $config->GetAppId();
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	
	/**
	 * 
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 * 
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$config = $this->WxConfig;
		$urlObj["appid"] = $config->GetAppId();
		$urlObj["secret"] = $config->GetAppSecret();
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
}