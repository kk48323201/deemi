<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Cart_model');
		$this->load->model('Order_model');
		$this->load->model('Member_model');
		$this->load->model('Address_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
		$this->Member_model->checkLogin();
	}
	public function index()
	{
		$res = array();$do = '';
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$strKey = 'CartTmpData_'.$_SESSION['MemberID'];
		if(isset($this->GET_DATA['do'])&&$this->GET_DATA['do']!=''){
			$do = $this->GET_DATA['do'];
		}
		//--立即下单
		if($do=='Once'){
			$formdata = $this->cache->get($strKey);
			if(!$formdata){
				redirect(base_url());
			}
			$total = 0.00;
			foreach($formdata as $k=>$item){
				$GoodsID = $k;
				$Num = $item;
				$GoodsData = $this->Data_model->getSingle(array('GoodsID'=>$GoodsID),'goods');
				$total = $total + $GoodsData['Price']*$Num;
			}
			$OrderNum = $this->Data_model->getDataNum(array("MemberID"=>$_SESSION["MemberID"],"Status >"=>-1,"IsDel"=>"0"),"order");
			if($OrderNum<1 && intval(beiguo_config('base','open_user_discount'))>0){
				$total = fmoney($total)*beiguo_config('base','user_discount');
			}
			$res["total"] = $total;
			$html = $this->load->view("Cart/ServiceOrderOnce",$res,true);
			exit($html);
		}
		if($do=='SaveOrderData'){
			$GoodsData = $this->cache->get($strKey);
			$CartXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
			foreach($GoodsData as $k=>$item){
				$GoodsID = $k;
				$Num = $item;
				$CartXml .= "<CartList>";
				$CartXml .= "<GoodsID>".$GoodsID."</GoodsID>";
				$CartXml .= "<Num>".$Num."</Num>";
				$CartXml .= "</CartList>";
			}
			$this->POST_DATA["CartXml"]=$CartXml;
			$rs = $this->Order_model->SaveServiceOrderData($this->POST_DATA);
			AjaxReturn($rs);
		}
		if($do=='SaveTmpDataData'){
			$rs = $this->cache->save($strKey,$this->POST_DATA['GoodsNum'],99999999);
			if($rs){
				$result = array('code'=>200);
			}else{
				$result = array('code'=>500);
			}
			AjaxReturn($result);
		}
		$this->load->view("Cart/Home",$res);
	}
}
