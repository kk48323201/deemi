<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Wxserver extends CI_Controller {
	/*微信服务端*/
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('tags');
		$this->load->model('Wechat_model');
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,TRUE);
	}
	function index(){
    	$this->Wechat_model->valid();
		$wechat = $this->Wechat_model->getRev();
		$Event = $this->Wechat_model->getRevEvent();
		$text = $wechat->getRevContent();
		$RevType = $wechat->getRevType();
		
		//--扫码邀请注册
		if(isset($Event['event'])&&$Event['event']=='SCAN'){
			$rs = $this->Member_model->WxInviteRecord($Event['key'],$this->Wechat_model->getRevFrom());
		}
		
	}
}

