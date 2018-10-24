<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data_model extends CI_Model
{
	var $table;
	function __construct(){
  		parent::__construct();
	}
	
	function setTable($table){
		$this->table = $table;
	}
	
	function setWhere($getwhere){
		if(is_array($getwhere)){
			foreach($getwhere as $key=>$where){
				if($key=='findinset'){
					$this->db->where("1","1 AND FIND_IN_SET($where)",FALSE);
					continue;
				}
				if(is_array($where)){
					$this->db->where_in($key, $where);
				}else{
					$this->db->where($key,$where);
				}
			}
		}else{
			$this->db->where($getwhere);
		}
	}

	function addData($data,$table=''){
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function editData($datawhere,$data,$table=''){
		$table = $table==''?$this->table:$table;
		if(!empty($datawhere))
		{
			$this->db->where($datawhere);
		}
		$this->db->update($table,$data);
	}
	
	function delData($ids,$table='',$dif = 'id'){

		$table = $table==''?$this->table:$table;

		if(is_array($ids)){

			$this->db->where_in($dif,$ids);

		}else{

			$this->db->where($dif,$ids);

		}

		$this->db->delete($table);

	}

	function getData($getwhere="",$order='',$pagenum="0",$exnum="0",$table='',$select="",$group_by=""){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($pagenum>0){
			$this->db->limit($pagenum,$exnum);
		}
		if($select){
			$this->db->select($select);
		}
		if($group_by){
			$this->db->group_by($group_by);
		}
		$data = $this->db->get($table)->result_array();
		return $data;
	}
	
	function getSingle($getwhere="",$table='',$order=''){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		if($order){
			$this->db->order_by($order);
		}
		$row = $this->db->get($table)->row_array();
		return $row;
	}

	function getDataNum($getwhere='',$table='',$order=''){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		if($order){
			$this->db->order_by($order);
		}
		return $this->db->count_all_results($table);
	}
	
	function setHits($id,$table=''){
		$table = $table==''?$this->table:$table;
		$this->db->where('id',$id);
		$this->db->set('hits', 'hits+1',FALSE);
		$this->db->set('realhits', 'realhits+1',FALSE);
		$this->db->update($table);
	}
	
	function listOrder($ids,$res,$order='',$table=''){
		$table = $table==''?$this->table:$table;
		$num = count($ids);
		$data = array();
		for($i=0;$i<$num;$i++){
			$data[] = array('id'=>$ids[$i],'listorder'=>$res[$i]);
		}
		$this->db->update_batch($table,$data,'id');
		
		if($num>0){
			$this->db->where_in('id',$ids);
			if($order){
				$this->db->order_by($order);
			}
			$data = $this->db->get($table)->result_array();
			return $data;
		}
		
		return array();
	}
	/*存储过程*/
	function execProcSet($procName, $input=array(), $output=array()){
		$proc =  "CALL ".$procName."(";
		if (!empty($input)) {
			foreach ($input as $key => $value) {
				if ($value==='') {
					$temp = "''";
				}else if (is_string($value)){
					$temp = "'".$value."'";
				}else if(is_null($value)){
					$temp = 'NULL';
				}else{
					$temp = $value;
				}
				$tempInput[] = $temp;
			}
			$proc = $proc . implode(",", $tempInput);
		}
		if(!empty($output)){
			if (!empty($input)) {
				$proc = $proc . ",";
			}
			foreach ($output as $key => $value) {
				
				$tempOutput[] = "@p_".$key;
			}
			$proc = $proc . implode(",", $tempOutput) . ");";
			foreach ($output as $key => $value) {
				$tempOutputSelect[] = " @p_" . $key. " AS " . $key;
			}
			$selectSql = "SELECT ". implode(",", $tempOutputSelect) . ";";
		}else{
			$proc = $proc . ");";
		}
		log_message('error',$proc);
		if(empty($output)){
			$result = $this->db->query($proc);
			return $tmpData = $result->result_array();
			 
		}
		
		$result =$this->db->query($proc);
		$tmpData = $result->row_array();
		return $tmpData;
	}
	function execProcSetArr($procName, $input=array()){
		$db = new mysqli($this->db->hostname,$this->db->username,$this->db->password,$this->db->database,'3306');
		$db->set_charset("utf8");
		if (mysqli_connect_errno()){
			throw_exception(mysqli_connect_error());
		}
		$proc =  "CALL ".$procName."(";
		if (!empty($input)) {
			foreach ($input as $key => $value) {
				if ($value==='') {
					$temp = "''";
				}else if (is_string($value)){
					$temp = "'".$value."'";
				}else if(is_null($value)){
					$temp = 'NULL';
				}else{
					$temp = $value;
				}
				$tempInput[] = $temp;
			}
			$proc = $proc . implode(",", $tempInput);
		}
		$proc = $proc . ");";
		log_message('error',$proc);
		$results = array();
		if ($db->multi_query($proc)) {
		  do {
			$records = array();
			if ($result = $db->use_result()) {
			  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$records[] = $row;
			  }
			  $result->close();
			}
			$results[] = $records;
		  } while ($db->more_results() && $db->next_result());
		}
		$db->close();
		return $results;
	}
}