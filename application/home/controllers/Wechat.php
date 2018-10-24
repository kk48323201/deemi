<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wechat extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('tags');
		$this->load->model('Wechat_model');
		$this->load->model('Member_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
	}
	public function login(){
		if(isset($this->GET_DATA['backurl'])&&$this->GET_DATA['backurl']!=''){
			$_SESSION['backurl'] = isset($this->GET_DATA['backurl'])?$this->GET_DATA['backurl']:site_url('Home');
		}
		$url = site_url('Wechat/login');
		if($this->Wechat_model->is_weixin() && !isset($_SESSION['wechat']['openid'])){
			if(isset($this->GET_DATA['code']) && $this->GET_DATA['code']!=''){
				$rs = $this->Wechat_model->getWechatUser($this->GET_DATA['code']);
			}else{
				$this->Wechat_model->jumpWechatOauth($url);
			}
		}
		if(isset($_SESSION['wechat']['openid'])){
			redirect($_SESSION['backurl']);
		}
		exit;
	}
	public function setmenu(){
		
		$menu = array();
		
		$menu['button'][] = array(
			'name'=>"服务预约",
			'type'=>'view',
			'url'=>base_url(),
		);
		$menu['button'][] = array(
			'name'=>"关于我们",
			'sub_button' => array(
				array('type'=>"view",'name'=>'微商城','url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx052f605b81768d4c&redirect_uri=http%3A%2F%2Fwechat.51hs.cn%2Fv1%2Fwechat.php%3Fmenu=2&response_type=code&scope=snsapi_base&state=0'),
				array('type'=>"view",'name'=>'微店购水','url'=>'http://weidian.com/s/332541600?wfr=c'),
				array('type'=>"view",'name'=>'优惠充值','url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx052f605b81768d4c&redirect_uri=http%3A%2F%2Fwechat.51hs.cn%2Fv1%2Fwechat.php%3Fmenu=1&response_type=code&scope=snsapi_base&state=1&connect_redirect=1#wechat_redirect'),
			)
		);
		
		$jsonmenu = self::encode_json($menu);
		$this->Wechat_model->setWxMenu($jsonmenu);
	}
	private function encode_json($str){  
    	if(version_compare("5.4", PHP_VERSION, ">")){
			$code = json_encode($str);  
			return preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
		}else{
			return json_encode($str, JSON_UNESCAPED_UNICODE);
		}
	}
	function test(){
		$this->Member_model->checkLogin();
		exit;
	}
}