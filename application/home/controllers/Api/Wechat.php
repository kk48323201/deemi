<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wechat extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('tags');
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->model('Wechat_model');
	}
	function setmenu(){
		$wxconfig = $this->config->item('wxconfig');
		#$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxconfig['appid'].'c&redirect_uri='.base_url().'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
		$oauth_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxconfig['appid'].'&redirect_uri='.urlencode(base_url()).'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
		$menu = array();
		/*$menu['button'][] = array(
			'name'=>"健康商城",
			'sub_button' => array(
				array('type'=>"view",'name'=>'商城入口','url'=>base_url()),
				array('type'=>"view",'name'=>'9.9元特卖','url'=>site_url('Home/Topic?do=Discounts')),
				array('type'=>"view",'name'=>'海鲜干货','url'=>site_url('Home/Topic?do=Seafood')),
				array('type'=>"view",'name'=>'春季祛湿','url'=>site_url('Home/Topic?do=Spring')),
				array('type'=>"view",'name'=>'减肥美容','url'=>site_url('Home/Topic?do=Woman')),
			)
		);*/
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
		

		$jsonmenu = json_encode($menu,JSON_UNESCAPED_UNICODE);
		$this->Wechat_model->setWxMenu($jsonmenu);
	}
}