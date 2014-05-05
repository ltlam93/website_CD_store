<?php
	class database{
		protected $connect;
		protected $results;
		public function connect(){
			@$this->connect = mysql_connect(config::HOST_NAME,config::HOST_USER,config::HOST_PASS) or die("can't connect sever");
			mysql_select_db(config::DB_NAME,$this->connect) or die("not select database");
			mysql_query("SET NAMES utf8");
		}
		public function query($sql){
			if($this->connect){
				$this->results = mysql_query($sql);
			}
		}
		public function num_rows(){
			if($this->results){
				$row = mysql_num_rows($this->results);
			}else{
				$row = 0;
			}
			return $row;
		}
		public function fetch(){
			if($this->results){
				$row = mysql_fetch_assoc($this->results);
			}else{
				$row = 0;
			}
			return $row;
		}
		public function fetchAll(){
			$data = array();
			if($this->results){
				while($row = $this->fetch()){
					$data[] = $row;
				}
				return $data;
			}
		}
	}
	//Function cho User (customers)
	class libraries_user extends database{
		protected $_table = "customers";
		//kiem tra tai khoan khi dang nhap
		public function check_login($user,$pass){
			$sql = "select * from $this->_table where username = '$user' and password = '$pass'";
			$this->query($sql);
			if($this->num_rows() == 0){
				return FALSE;
			}else{
				return $this->fetch();
			}
		}
		//them  moi khach hang
		public function add_user($data){
			$table = $this->_table;
			$col = implode(",",array_keys($data));
			$arr = array_values($data);
			foreach($arr as $arr2){
				$arr3[] = "'$arr2'";
			}
			$val = implode(",",$arr3);
			$sql = "insert into $table($col) values($val)";
			$this->query($sql);
		}
		
		// tong khach hang
		public function total_user(){
			$sql = "select * from $this->_table";
			$this->query($sql);
			return $this->num_rows();
		}
		
		//kiem tra Tai khoan da su dung chua
		// su dung roi, tra ve TRUE. chua cha ve FALSE
		public function check_username($name){
			$sql = "select username from $this->_table where username = '$name'";
			$this->query($sql);
			if($this->num_rows() == 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//kiem tha Email da su dung chua
		// su dung roi, tra ve TRUE. chua cha ve FALSE
		public function check_email($email){
			$sql = "select email from $this->_table where email = '$email'";
			$this->query($sql);
			if($this->num_rows() == 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//Xoa user
		public function del_user($table,$id){
			$sql = "delete from $this->_table where user_id = $id and user_id != 1 ";
			$this->query($sql);
		}
		
		//Cap nhat user
		public function update_user($data,$id){
			foreach($data as $k => $v){
				$arr[] = "$k = '$v'";
			}
			$col = implode(",",$arr);
			$sql = "update $this->_table set $col where user_id = '$id'";
			$this->query($sql);
		}
	}
	
	class libraries_products extends database{
		protected $_table = "tbl_cdInfo";
		
		//them san pham CD
		public function add_cd($data){
			$table = $this->_table;
			$col = implode(",",array_keys($data));
			$arr = array_values($data);
			foreach($arr as $arr2){
				$arr3[] = "'$arr2'";
			}
			$val = implode(",",$arr3);
			$sql = "insert into $table($col) values($val)";
			$this->query($sql);
		}
		
		//Dua ra tong so mat hang CD
		public function total_cd(){
			$sql = "select * from $this->_table";
			$this->query($sql);
			return $this->num_rows();
		}
		
		// Show CD voi so luon gioi han
		public function list_cd($start,$limit){
			$sql = "select * from $this->_table order by cd_id DESC limit $start,$limit";
			$this->query($sql);
			return $this->fetchAll();
		}
		//Show cac loai CD
		public function list_cdkind(){
			$sql = "select * from tbl_cdKind";
			$this->query($sql);
			return $this->fetchAll();
		}
		
		//Xoa san pham CD
		public function del_pro($table,$id){
			$sql = "delete from $this->_table where cd_id = '$id'";
			$this->query($sql);
		}
		
		//Cap nhat san pham CD
		public function update_cd($data,$id){
			foreach($data as $k => $v){
				$arr[] = "$k = '$v'";
			}
			$col = implode(",",$arr);
			$sql = "update $this->_table set $col where cd_id = '$id'";
			$this->query($sql);
		}
		public function getdata($id){
			$sql = "select * from $this->_table where cd_id = '$id'";
			$this->query($sql);
			return $this->fetch();
		}
	}

	// tạo Breadcrumb
function breadcrumbs($text = 'Bạn đang ở: ', $sep = ' / ', $home = 'Home') {
	//Use RDFa breadcrumb, can also be used for microformats etc.
	$bc     =   '<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crums">'.$text;
	//Get the website:
	$site   =   'http://'.$_SERVER['HTTP_HOST'];
	//Get all vars en skip the empty ones
	$crumbs =   array_filter( explode("/",$_SERVER["REQUEST_URI"]) );
	//Create the home breadcrumb
	$bc    .=   '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$home.'</a>'.$sep.'</span>'; 
	//Count all not empty breadcrumbs
	$nm     =   count($crumbs);
	$i      =   1;
	//Loop the crumbs
foreach($crumbs as $crumb){
    //Make the link look nice
    $link    =  ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$crumb) );
    //Loose the last seperator
    $sep     =  $i==$nm?'':$sep;
    //Add crumbs to the root
    $site   .=  '/'.$crumb;
    //Make the next crumb
    $bc     .=  '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$link.'</a>'.$sep.'</span>';
    $i++;
}
$bc .=  '</div>';
//Return the result
return $bc;
}
?>
