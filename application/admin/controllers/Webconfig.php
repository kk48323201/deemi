<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Webconfig extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('array');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,TRUE);
		$this->Admin_model->checkLogin();
	}
	function index(){
		$res = $res['base'] = $res['attr'] = $res['mail'] = array();
		if(isset($this->GET_DATA['do']) && $this->GET_DATA['do']=='Save'){
			$base = $this->POST_DATA['base'];
			foreach($base as $key=>$item){
				$c = $this->Data_model->getDataNum(array('varname'=>$key,'category'=>'base'),'config');
				if($c>0){
					$this->Data_model->editData(array('varname'=>$key,'category'=>'base'),array('value'=>$item),'config');
				}else{
					$this->Data_model->addData(array('varname'=>$key,'category'=>'base','value'=>$item),'config');
				}
			}
			$wechat = $this->POST_DATA['wechat'];
			foreach($wechat as $key=>$item){
				$c = $this->Data_model->getDataNum(array('varname'=>$key,'category'=>'wechat'),'config');
				if($c>0){
					$this->Data_model->editData(array('varname'=>$key,'category'=>'wechat'),array('value'=>$item),'config');
				}else{
					$this->Data_model->addData(array('varname'=>$key,'category'=>'wechat','value'=>$item),'config');
				}
			}
			$mail = $this->POST_DATA['mail'];
			foreach($mail as $key=>$item){
				$c = $this->Data_model->getDataNum(array('varname'=>$key,'category'=>'mail'),'config');
				if($c>0){
					$this->Data_model->editData(array('varname'=>$key,'category'=>'mail'),array('value'=>$item),'config');
				}else{
					$this->Data_model->addData(array('varname'=>$key,'category'=>'mail','value'=>$item),'config');
				}
			}
			$attr = $this->POST_DATA['attr'];
			foreach($attr as $key=>$item){
				$c = $this->Data_model->getDataNum(array('varname'=>$key,'category'=>'attr'),'config');
				if($c>0){
					$this->Data_model->editData(array('varname'=>$key,'category'=>'attr'),array('value'=>$item),'config');
				}else{
					$this->Data_model->addData(array('varname'=>$key,'category'=>'attr','value'=>$item),'config');
				}
			}
			$result = array('code'=>'200');
			exit(json_encode($result));
		}
		$base = $this->Data_model->getData(array('category'=>'base'),'id',0,0,'config');
		foreach($base as $item){
			$res['base'][$item['varname']] = $item['value'];
		}
		$attr = $this->Data_model->getData(array('category'=>'attr'),'id',0,0,'config');
		foreach($attr as $item){
			$res['attr'][$item['varname']] = $item['value'];
		}
		$mail = $this->Data_model->getData(array('category'=>'mail'),'id',0,0,'config');
		foreach($mail as $item){
			$res['mail'][$item['varname']] = $item['value'];
		}
		$wechat = $this->Data_model->getData(array('category'=>'wechat'),'id',0,0,'config');
		foreach($wechat as $item){
			$res['wechat'][$item['varname']] = $item['value'];
		}
		$tpl = 'System/Webconfig';
		$this->load->view($tpl,$res);
	}
}
