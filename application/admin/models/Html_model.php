<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Html_model extends CI_Model{
	function __construct(){
  		parent::__construct();
	}
	function getRoleListHtml($args){
		$defaultVal = isset($args['RoleID'])?intval($args['RoleID']):0;
		$sStr = "<select name='RoleID' id='RoleID' class='easyui-combobox'><option value='0'>普通会员</option>";
        $list = $this->Data_model->getData(array(),'',0,0,'role');
	
		foreach ($list as $item) {
            $selected = ($defaultVal == $item['RoleID']) ? "selected='selected'" : '';
            $sStr .= "<option value='".$item['RoleID']."' {$selected}>".$item['RoleName']."</option>";
        }
        $sStr .= "</select>";
        return $sStr;
	}
}