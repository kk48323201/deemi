<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Article_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getListData($args){
		$input = array(
			'page' => empty($args['page'])?1:$args['page'],
			'rows' => empty($args['rows'])?20:$args['rows'],
		);
		$rs=$this->Data_model->execProcSetArr('Manage_Article_getListData',$input);
		
		return array('rows'=>$rs[0],'total'=>$rs[1][0]['total']);
	}
	function getSingleData($args){
		$fields = array('ArticleID');
		$input = elements($fields,$args);
		$rs = $this->Data_model->execProcSet('Manage_Article_getSingleData',$input);
		return array('code'=>200,'rows'=>$rs[0]);
	}
	function saveData($args){
		$fields = array('ArticleID','Description','Title','MemberID','Status','BigThumb','CategoryID','IsNew','Content','ListOrder','VideoLink','Tel');
		$input = elements($fields,$args);
		$input["IsNew"] = empty($input['IsNew'])?"0":$input['IsNew'];
		$input['MemberID'] = empty($input['MemberID'])?"0":$input['MemberID'];
		$input['Content'] = htmlspecialchars($args['Content']);
		$output = array('returnValue'=>'0');
		$rs = $this->Data_model->execProcSet('Manage_Article_saveData',$input,$output);
		return array('code'=>$rs['returnValue']);
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