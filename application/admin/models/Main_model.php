<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getDashboardData(){
		$input = array();
		$rs = $this->Data_model->execProcSetArr('Manage_Dashboard');
		return array('code'=>200,'rows'=>$rs);
	}
}