<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller {
	var $GET_DATA,$POST_DATA;
	function __construct(){
		parent::__construct();
		$this->GET_DATA = $this->input->get(NULL,TRUE);
		$this->POST_DATA = $this->input->post(NULL,false);
	}
	public function index()
	{
		echo date_default_timezone_get();
		echo date("Y-m-d H:i:s");exit;		
	}
	
}
