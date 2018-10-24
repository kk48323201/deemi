<?php
class mysql{ 
        private $link; 
            //在构造函数里连接数据库，不知道合理不，在config文件里实例化 
                //参数说明：地址，mysql用户名，密码，编码，数据库名，端口 
        function __construct($db_host,$db_username,$db_psd,$db_name,$db_charset,$port="3306") { 
                try{ 
                         if(!$this->link=@mysql_connect($db_host,$db_username,$db_psd,$port)) { 
                             $error="<font color='red'>Error:数据库连接错误</font>"; 
                                 throw new Exception($error); 
                 } 
                         if(!mysql_select_db($db_name,$this->link)) { 
                                 $error="<font color='red'>Error:选择数据库名错误</font>"; 
                                 throw new Exception($error); 
                         } 
                     if($this->getversion()>'4.1') {  //mysql版本大于4.1就设置编码,不是很清楚为什么要大于4.1版本的时候，参考别人的 
                          if($db_charset) { 
                                   mysql_query("SET NAMES '{$db_charset}'"); 
                          } 
                          if($this->getversion()>'5.0.1') {    //mysql版本大于2.0.1就设置sqlmode为空，这个也是模仿别人的 
                                   mysql_query("SET sql_mode=''"); 
                          } 
                     } 
                } catch (Exception $error) { 
                        die($error->getMessage().":".mysql_error()); 
                } 

        } 
    //插入函数 $value是数组 例：array("name=>3,pwd=>2") 
        function insert($table,$value=array()) { 
                foreach($value as $feild => $val){ 
                        $feilds[]="`{$feild}`"; 
                        $vals[]="'{$val}'"; 
                } 
            $sql="Insert INTO {$table} (".implode(",",$feilds).") value(".implode(",",$vals).")"; 
                $this->query($sql); 
        } 
        //修改函数 
        function update($table,$value=array(),$where) { 
                foreach($value as $feild=>$val){ 
                        $set[]="{$feild}='{$val}'"; 
                } 
            $sql="Update {$table} SET ".implode(",",$set)." Where ".$where; 
                $this->query($sql); 
        } 
        //删除函数 
        function del($table,$where) { 
            $sql="Delete FROM {$table} Where ".$where; 
                $this->query($sql); 
        } 
        //取记录数 
        function countnum($sql) { 
                return mysql_num_rows($this->query($sql)); 
        } 
        //取mysql版本 
        function getversion() { 
                if($this->link) { 
                        return mysql_get_server_info($this->link); 
                } 
        } 

        //初始化query 
        function query($sql) { 
                $query=mysql_query($sql,$this->link) or die($this->showerror()); 
                return $query; 
        } 
        //初始化fetch... 
        function fetch_array($result) { 
            return mysql_fetch_array($result); 
        } 
        //mysql报错 
        function showerror() { 
                echo"<font color='red'>数据库操作出错</font>:#".mysql_errno().":".mysql_error(); 
        } 
        //关闭数据库 
        function close(){ 
                mysql_close($this->link); 
        } 

} 
?>