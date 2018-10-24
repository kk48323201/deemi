<?php
class MY_Loader extends CI_Loader {
	function __construct()
	{
		parent::__construct();
		self::loadPublicModel();
	}
	/*加载公共模型*/
	function loadPublicModel(){
		$this->model('../../admin/models/Data_model');
		$this->model('../../admin/models/Wechat_model');
	}
}
