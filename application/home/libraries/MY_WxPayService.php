<?php defined('BASEPATH') OR exit('No direct script access allowed');

// 加载微信支付配置抽象类
require_once APPPATH.'libraries/Payment/WxpaylibService/WxPay.Config.Interface.php';

/**
 * MY_WxPay 自定义微信支付类
 * @author Mike Lee
 */
class MY_WxPayService extends WxPayConfigInterface{

    private $_CI,$AppId,$MerchantId,$NotifyUrl,$Key;
    public function  __construct(){
        $this->_CI = & get_instance();
    }
	public function SetConfig($args){
		$this->AppId = $args['AppId'];
		$this->MerchantId = $args['MerchantId'];
		$this->NotifyUrl = $args['NotifyUrl'];
		$this->Key = $args['Key'];
		$this->AppSecret = $args['AppSecret'];
	}
    public function GetAppId(){
		return $this->AppId;
	}
	public function GetMerchantId(){
		return $this->MerchantId;
	}
	public function GetNotifyUrl(){
		return $this->NotifyUrl;
	}
	public function GetSignType(){
		return "HMAC-SHA256";
	}
	public function GetProxy(&$proxyHost, &$proxyPort)
	{
		$proxyHost = "0.0.0.0";
		$proxyPort = 0;
	}
	public function GetReportLevenl()
	{
		return 1;
	}
	public function GetKey()
	{
		return $this->Key;
	}
	public function GetAppSecret()
	{
		return $this->AppSecret;
	}
	public function GetSSLCertPath(&$sslCertPath, &$sslKeyPath)
	{
		$sslCertPath = '../cert/apiclient_cert.pem';
		$sslKeyPath = '../cert/apiclient_key.pem';
	}

}