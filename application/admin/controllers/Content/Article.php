<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->load->model('Article_model');
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Article_model->getListData($this->GET_DATA);
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/ArticleForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Article_model->getSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('Content/ArticleForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Article_model->delData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$input = $this->POST_DATA;
			$img = SaveImg($this->POST_DATA['BigThumb'],'article');
			$input['BigThumb'] = $img;
			$rs = $this->Article_model->saveData($input);
			exit(json_encode($rs));
		}
		if($do=='catListData'){
			$rs = $this->Article_model->getCatListData($this->POST_DATA);
			$CategoryID = isset($this->POST_DATA["CategoryID"])?intval($this->POST_DATA["CategoryID"]):0;
			if($CategoryID>0){
				for($i=0;$i<count($rs["rows"]);$i++){
					if($rs["rows"][$i]["CategoryID"] == $CategoryID){
						$rs["rows"][$i]["selected"] = true;
					}
				}
			}else{
				if($CategoryID > -1){
					$rs["rows"][0]["selected"] = true;
				}else{
					$rs["rows"][] = array(
						"CategoryID"=>0,
						"CatName"=>"全部分类",
						"ListOrder"=>99,
						"Status"=>1,
						"selected"=>true);
				}
			}
			AjaxReturn($rs["rows"]);
		}
		$this->load->view('Content/Article',$res);
	}
	function Cat(){
		$res = array();
		$do = isset($this->GET_DATA['do'])?$this->GET_DATA['do']:"";
		if($do == 'ListData'){
			$return=$this->Article_model->getCatListData(array());
			exit(json_encode($return));
		}
		if($do=='add'){
			exit($this->load->view('Content/ArticleCatForm',$res,true));
		}
		if($do=='edit'){
			$rs = $this->Article_model->getCatSingleData($this->GET_DATA);
			$res['data'] = $rs['rows'];
			exit($this->load->view('Content/ArticleCatForm',$res,true));
		}
		if($do=='del'){
			$rs = $this->Article_model->delCatData($this->GET_DATA);
			exit(json_encode($rs));
		}
		if($do=='save'){
			$rs = $this->Article_model->saveCatData($this->POST_DATA);
			exit(json_encode($rs));
		}
		$this->load->view('Content/ArticleCat',$res);
	}
	public function UploadImages(){
		$save_path = 'upload/article';
		$ext_arr = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
		);
		$uploadconfig = $this->Cache_model->loadConfig('attr');
	
		$dir_name = '';
		$save_path .= $dir_name.'/';
		if (!file_exists($save_path)) {
				mkdir($save_path);
		}
		$save_path .= date('Ymd').'/';
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	
		$uploadconfig['upload_path'] = $save_path;
		$uploadconfig['allowed_types'] = implode('|',$ext_arr['image']);
		$uploadconfig['max_size'] = $uploadconfig['attr_maxsize']?$uploadconfig['attr_maxsize']:0;
		$uploadconfig['encrypt_name']  = TRUE;
		$uploadconfig['remove_spaces']  = TRUE;
		$this->load->library('upload', $uploadconfig);
		if(!$this->upload->do_upload('imgFile')){
			$result = array('error'=>1,'message'=>$this->upload->display_errors('',''));
		}else{
			$data = $this->upload->data();
			$image_width = $data['image_width'];
			$image_height = $data['image_height'];
			if($image_width > 560){
				$img_config['image_library'] = 'gd2';
				$img_config['source_image'] = $save_path.$data['file_name'];
				$img_config['create_thumb'] = false;
				$img_config['maintain_ratio'] = true;
				$img_config['width'] = 800;
				//$img_config['height'] = intval(750*$image_height/$image_width);
				$img_config['height'] = 800;
				$this->load->library('image_lib',$img_config);
				$this->image_lib->resize();
			}
			/*
			if($this->input->post('iswater')==1&&$dir_name=='image'&&$attrconfig['water_type']>0){
				$this->load->library('image_lib',array("width"=>"750"));
				$waterconfig['source_image'] = $save_path.$data['file_name'];
				$waterconfig['quality'] = $attrconfig['water_quality'];
				$waterconfig['wm_padding'] = $attrconfig['water_padding'];
				$this->image_lib->initialize($waterconfig);
				$this->image_lib->watermark();
			}
			*/
			$img = array(
				'CreateTIme'=>date("Y-m-d H:i:s"),
				'Imgsrc' => $save_path.$data['file_name'],
				'StoreID'=>'0',
			);
			//$this->Data_model->addData($img,'images');
			$result = array('error'=>0,'url'=>base_url($save_path.$data['file_name']));
		}

		echo json_encode($result);exit;
	}
}
