<?php  
//Tao ket noi toi DTB
//
$host = "localhost"; 
// tai khoan co so du lieu 
$user = "root";  
// mat khau
$pass = "";  
//ten database
$dtb ="cd";
$connection = mysql_connect($host,$user,$pass);
if (!$connection) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dtb);
?>