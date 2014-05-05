<?php
	
	require('../config.php');
	$errors = array();
	$fesit=array();
	$row =array();
	$msg = array();
	//if(isset($_POST['search_submit'])){
		//echo "<center><h3>Bạn đã nhập sai tên tài khoản</h3></center>";
		//header('Refresh:2; url=view_customers.php');
	//}else
	//{ 
	//if(isset($_POST['search_user'])){
		//$name = $_POST['search_user'];
		//$query = "select * from customers where username = '$name'";
		//$result = mysql_query($query);
		//$rows = mysql_fetch_array($result);
		
	
	// lay data từ sql đưa vào form :D
		
			//$fesit['username']   = $rows['username'];
			//$fesit['email']     = $rows['email'];
			//$fesit['fullname'] = $rows['fullname'];
			//$fesit['address']   = $rows['address'];
			//$fesit['phone']    = $rows['phone'];
			//$fedit['id_customer']  = $rows['id_customer'];
	//}
	//}
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "select * from customers where id_customer = '$id'";
		$result = mysql_query($query);
		$rows = mysql_fetch_array($result);
		$fesit['username']   = $rows['username'];
			$fesit['email']     = $rows['email'];
			$fesit['fullname'] = $rows['fullname'];
			$fesit['address']   = $rows['address'];
			$fesit['phone']    = $rows['phone'];
			$fedit['id_customer']  = $rows['id_customer'];
		}
		//kiem tra thêm người dùng mới
		if(isset($_POST['edit_submit'])){
			$edit_username   = $_POST['edit_username'];
			$edit_email     = mysql_real_escape_string($_POST['edit_email']);
			$edit_fullname = $_POST['edit_fullname'];
			$edit_address   = mysql_real_escape_string($_POST['edit_address']);
			$edit_phone     = mysql_real_escape_string($_POST['edit_phone']);
	//kiểm tra dữ liệu nhập vào ở form
		switch(isset($_POST['edit_submit'])){
			case 1:
				if(empty($_POST['edit_username']))
					$errors[] = 'Hãy nhập tên tài khoản !';
				break;
			case 2: 
				if(empty($_POST['edit_email']))
					$errors[] = 'Hãy nhập email của bạn !';
				break;
			case 3: 
				if(empty($_POST['edit_phone']))
					$errors[] = 'Hãy nhập số điện thoại của bạn !';
				break;
			case 4:
				if(!empty($_POST['edit_username']) && (strlen($_POST['edit_username']) > 20 || strlen($_POST['edit_username']) < 5))
					$errors[] = 'Tài khoản giới hạn 4~12 ký tự.';
				break;
			case 5:
				if(!empty($_POST['edit_username']) && !preg_match('#^[a-z0-9]+$#i', $_POST['edit_username']))
					$errors[] = 'Tài khoản chỉ chứa ký tự: aA-zZ, 0-9';
				break;
			}
			if(count($errors) == 0){
				if (!filter_var($edit_email, FILTER_VALIDATE_EMAIL)) // Kiểm tra định dạng Email
				{
					$errors[] =  "Email không dúng định dạng";
				}
			}
			if(count($errors) == 0){
				$check_user= mysql_query("select * from customers where username = '$edit_username'");
				$check_id_user=mysql_fetch_array($check_user);
				$check_user=mysql_num_rows($check_user);
				$check_email= mysql_query("select * from customers where email = '$edit_email'");
				$check_id_email=mysql_fetch_array($check_email);
				$check_email=mysql_num_rows($check_email);
				//kiem tra id_customer
				if ($id!= $check_id_user['id_customer'] && $id != $check_id_email['id_customer']){
					//kiem tra username
					if($check_user != 0){
						$errors[] = " Tài khoản " .$edit_username." đã được sử dụng";
					}
					//kiểm tra email
					if($check_email != 0){
						$errors[] = " Email " .$edit_email." đã được sử dụng";
					}
					//ghi dữ liệu vào bảng customers
					if ( $check_user==0 && $check_email == 0){
						mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone' WHERE id_customer =$id");
						$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
					}
				} else
				{
					mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone' WHERE id_customer =$id");
					$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
				}
			}
		}
	
?>
<?php 
	require('layout/header.php');
	require('layout/menu.php'); 
	require('../functions.php');
?>
<html>
	
	<div id="page-wrapper">
		<div class="row">
		<div class="col-lg-12">
			<ol class="breadcrumb">
			<p><?= breadcrumbs() ?></p>
			</ol>
		</div>
        <div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4"></div>
              	<div class="col-lg-4 edit_customer-form">
					<div class="panel panel-primary">
					<div class="panel-heading">
					<h2 class="panel-title"><center>Chỉnh sửa thông tin</center></h2>
					</div>
					</div>
                    <form id="edit_customer" action="" method="post">
						<input type="hidden" name="edit_id" value="<?php echo $fedit['id_customer']; ?>">
                        <div class="form-group">
							 <label >Tên tài khoản</label>
							<input name="edit_username" type="text" class="form-control" value="<?php echo $fesit['username']; ?>">
						</div>
                        <div class="form-group">
							 <label >Địa chỉ Email</label>
  							<input name="edit_email" type="text" class="form-control" value="<?php echo $fesit['email']; ?>">
						</div>
						<div class="form-group">
							 <label >Họ và tên</label>
							<input name="edit_fullname" type="text" class="form-control" value="<?php echo $fesit['fullname']; ?>">
						</div>
                        <div class="form-group">
							 <label >Địa chỉ</label>
  							<input name="edit_address" type="text" class="form-control" value="<?php echo $fesit['address']; ?>">
						</div>
                        <div class="form-group">
							 <label >Số điện thoại</label>
  							<input name="edit_phone" type="text" class="form-control" value="<?php echo $fesit['phone']; ?>">
						</div>
                        <br>
                            <center><button name="edit_submit" type="submit" class="btn btn-primary">Cập nhật thông tin</button></center>
					</form>
							<!-- Đưa ra thông báo -->
							<?php	
							if(count($errors) > 0){
								foreach($errors as $error){
									echo '<span style="text-align: left" class="btn1 btn-notifi"> <i class="fa fa-exclamation-triangle"></i></span>  '.$error.'</span><br />';
								}
								unset($errors);
							}
							if(count($msg) > 0){
								foreach($msg as $msg){
									echo '<span style="text-align: left" class="btn1 btn-success"> <i class="fa fa-check-square-o"></i></span>  '.$msg.'</span><br />';
								}
								unset($msg);
							}
							?>
            	</div>
				
				<div class="col-lg-4">
				
				</div>
          </div>
        </div><!-- /.row -->
		
			
		
		
		
     </div><!-- /#page-wrapper -->

</html>



<?php 
	require ('layout/footer.php'); 
?>