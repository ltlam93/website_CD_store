<html>
<head>
<style>
#lala{
position:absolute;
width:100%;
height:20%;
background-color:#ffffff;
}
#lolo{
opacity:0.5;
}
</style>
</head>
<body>


<div id="lala">
<?php
	if(isset($_POST['log_submit']))
	{
		$log_username=$_POST['log_username'];
		$log_password=md5($_POST['log_password']);
		
		if($log_username && $log_password){
			  require('config-home.php');
			  $sql="select * from customers where username='".$log_username."' and password='".$log_password."'";
			  $query = $mysqli->query($sql);
			  $result = $query->num_rows;
			  if($result == 0)
			  {
			   echo "<center><h3>Bạn đã nhập sai Username hoặc password</h3></center>";
			   header('Refresh:2; url=login.php');
			  }
			  else //đăng nhap thanh công
			  {
			  $row=$query->fetch_object();
				session_start();
				$_SESSION['username'] = $row->username;
				$_SESSION['status'] = $row->status;
				if($row->status==3){
					echo "<center><h3>Xin chào Admin. Đang chuyển đến trang quản trị...</h3></center>";
					header('Location:admin/index.php');
				}
				else{
					header('Location:index.php');
				}
				
			  
			  }
		}
		
	}
?>

</div>
</body>
</html>





