<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Goods_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$w = array('IsDel'=>'0');
		$data = $this->Data_model->getData($w,"GoodsID desc",$input["rows"],($input["page"]-1)*$input["rows"],"goods");
		$total = $this->Data_model->getDataNum($w,'goods');
		return array("code"=>200,"rows"=>$data,"total"=>$total);
	}
	function getSingleData($args){
		$fields = array('GoodsID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle(array("GoodsID"=>intval($input["GoodsID"])),'goods');
		$other = $this->Data_model->getSingle(array("GoodsID"=>intval($input["GoodsID"])),'goods_detail');
		$data = array_merge($data,$other);
		return array('code'=>200,'rows'=>$data);
	}
	function saveData($args){
		$fields = array('GoodsID','GoodsName','CategoryID','Price','Qty','Description','BigThumb','OnSale','Unit','CategoryID');
		$input = elements($fields,$args);
		$input['CategoryID'] = intval($input['CategoryID']);
		$other = elements(array('Content','OtherDesc'),$args);
		$other['Content'] = htmlspecialchars($other['Content']); 
		$other['OtherDesc'] = htmlspecialchars($other['OtherDesc']); 
		$GoodsID = intval($input["GoodsID"]);unset($input["GoodsID"]);
		$w = array('GoodsID'=>$GoodsID);
		$result = array('code'=>500,'info'=>'操作失败');
		if($GoodsID>0){			 
			$input["EditTime"] = date("Y-m-d H:i:s");
			$this->Data_model->editData($w,$input,"goods");
			$this->Data_model->editData($w,$other,"goods_detail");
			return array('code'=>200,'info'=>'操作成功');
		}else{
			$input["EditTime"] = $input["CreateTime"] = date("Y-m-d H:i:s");
			$id = $this->Data_model->addData($input,'goods');
			if($id){
				$other['GoodsID'] = $id;
				$this->Data_model->addData($other,'goods_detail');
				return array('code'=>200,'info'=>'操作成功');
			}
		}
		return $result;
	}
	function delData($args){
		$fields = array('ArticleID');
		$input = elements($fields,$args);
		$output = array('returnValue'=>'0');
		$rs = $this->Data_model->execProcSet('Manage_Article_delData',$input,$output);
		return array('code'=>$rs['returnValue']);
	}
	function getCatListData($args){
		$rs = $this->Data_model->execProcSet('Manage_Article_getCatListData');
		return array('rows'=>$rs,"code"=>"200","total"=>count($rs));
	}
	function saveCatData($args){
		$fields = array('CategoryID','CatName','ListOrder','Status');
		$input = elements($fields,$args);
		if(intval($input["CategoryID"]) > 0){
			$this->Data_model->editData(array("CategoryID"=>$input["CategoryID"]),$input,"article_cat");
		}else{
			unset($input["CategoryID"]);
			$this->Data_model->addData($input,"article_cat");
		}
		return array('code'=>200);
	}
	function getCatSingleData($args){
		$fields = array('CategoryID');
		$input = elements($fields,$args);
		$data = $this->Data_model->getSingle($input,"article_cat");
		return array('code'=>200,'rows'=>$data);
	}
	function delCatData($args){
		$fields = array('CategoryID');
		$input = elements($fields,$args);
		$this->Data_model->editData($input,array("IsDel"=>1),"article_cat");
		return array('code'=>$rs['returnValue']);
	}
}