<?php
	
	require('../config.php');
	$errors = array();
	$fesit=array();
	$row =array();
	$msg = array();
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "select * from customers where id_customer = '$id'";
		$result = mysql_query($query);
		$rows = mysql_fetch_array($result);
		$fesit['username']        = $rows['username'];
			$fesit['email']       = $rows['email'];
			$fesit['fullname']    = $rows['fullname'];
			$fesit['address']     = $rows['address'];
			$fesit['phone']       = $rows['phone'];
			$fedit['id_customer'] = $rows['id_customer'];
			$fedit['status']      = $rows['status'];
	}
		//kiem tra thêm người dùng mới
		if(isset($_POST['edit_submit'])){
			$edit_username   = $_POST['edit_username'];
			$edit_email     = mysql_real_escape_string($_POST['edit_email']);
			$edit_fullname = $_POST['edit_fullname'];
			$edit_address   = mysql_real_escape_string($_POST['edit_address']);
			$edit_phone     = mysql_real_escape_string($_POST['edit_phone']);
			$edit_status     = mysql_real_escape_string($_POST['edit_status']);
			
	//kiểm tra dữ liệu nhập vào ở form
		if(isset($_POST['edit_submit'])){

				if(empty($_POST['edit_username']))
					$errors[] = 'Hãy nhập tên tài khoản !';
					
				if(!empty($_POST['edit_username']) && (strlen($_POST['edit_username']) > 20 || strlen($_POST['edit_username']) < 5))
					$errors[] = 'Tài khoản giới hạn 5~20 ký tự.';
	
				if(!empty($_POST['edit_username']) && !preg_match('#^[a-z0-9]+$#i', $_POST['edit_username']))
					$errors[] = 'Tài khoản chỉ chứa ký tự: aA-zZ, 0-9';

				if(empty($_POST['edit_email']))
					$errors[] = 'Hãy nhập email của bạn !';

				if(empty($_POST['edit_phone']))
					$errors[] = 'Hãy nhập số điện thoại của bạn !';

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
				if ($id != $check_id_user['id_customer'] && $id != $check_id_email['id_customer']){
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
						mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone', status='$edit_status' WHERE id_customer =$id");
						//$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
						$msg[] = "Đã cập nhật thành công khách hàng!";
					}
				} else
				{
					mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone', status='$edit_status' WHERE id_customer =$id");
					//$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
					$msg[] = "Đã cập nhật thành công khách hàng!";
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
		
		 <!--- kiem tra neu co id user th moi hien thi form chinh sua thong tin --->
		<?php if(isset($_GET['id'])){ ?>
		<div class="row">
			<div class="col-lg-12">
              	<div class="col-lg-8 add-customers-form">
                    <div class="panel panel-primary">
						<div class="panel-heading">
						<h2 class="panel-title"><center>Chỉnh sửa thông tin người dùng</center></h2>
						</div>
					<div class="panel-body">
                    <form id="add_customer" action="" method="post">
						<div class="row">
						<div class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon">Tài khoản</span>
								<input name="edit_username" type="text" class="form-control input-lg" value="<?php echo $fesit['username']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">UserEmail</i></span>
								<input name="edit_email" type="text" class="form-control input-lg" value="<?php echo $fesit['email']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Họ và tên   </span>
								<input name="edit_fullname" type="text" class="form-control input-lg" value="<?php echo $fesit['fullname']; ?>">
							</div>
							<br>
							 
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
                                <span class="input-group-addon">Nhóm </i></span>
								<input name="edit_status" type="text" class="form-control input-lg" value="<?php echo $fedit['status']; ?>">
                             </div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Địa chỉ   </span>
								<input name="edit_address" type="text" class="form-control input-lg" value="<?php echo $fesit['address']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Phone</span>
								<input name="edit_phone" type="number" class="form-control input-lg" value="<?php echo $fesit['phone']; ?>">
							</div>
						</div>
						</div>
						<br>
						<div class="row">
                            <center>
							<button name="edit_submit" type="submit" class="btn btn-primary btn-lg">Cập nhật thông tin</button>
							</center>
						</div>
					</form>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center>Thông tin khách đã chỉnh sửa</center></h2>
						</div>
					<div class="panel-body">
						<?php	// Đưa ra thông báo khi không thêm được người dùng mới
							if(count($errors) > 0){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo "Không thể thêm! Dữ liệu đã nhập" ?></strong></center>
										</div>	
							<?php
							}
							?>
						<?php	//Đưa ra thông báo khi thêm người dùng mới thành công
							if(count($msg) > 0){
								foreach($msg as $msg){ ?>
									<div class="alert alert-success fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $msg ?></strong></center>
									</div>	
							<?php	}
								unset($msg);
							}
							?>
					<div class="table-responsive"> <!-- Xuất dữ liệu người dùng mới đã thêm vào -->
						<table class="table table-bordered table-hover table-striped tablesorter">
						<tbody>
							<tr>
								<td><b>Tài khoản:</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_username;?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ Email</td><td><?php if(isset($_POST['edit_submit']))echo $edit_email;?></td>
							</tr>
							<tr>
								<td><b>Loại tài khoản:</td><td><?php if(isset($_POST['edit_submit'])) echo $_POST['edit_status'];?></td>
							</tr>
							<tr>
								<td><b>Họ tên</td><td><?php if(isset($_POST['edit_submit']))echo $edit_fullname; ?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_address;?></td>
							</tr>
							<tr>
								<td><b>Số điện thoại</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_phone;?></td>
							</tr>
						</tbody>
						</table>
					</div>
					<br>
					<div>
					<!-- Đưa ra thông báo -->
							<?php	//Đưa thông báo gặp lỗi nào
							if(count($errors) > 0){
								foreach($errors as $errors){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $errors ?></strong></center>
										</div>	
							<?php	}
								unset($errors);
							}
							?>
							
							
					</div>
				</div>	<!-- div panel panel-primary -->
				</div> <!-- div col-lg-4 -->
						
					
						
         </div> <!-- div col-lg-12 -->
		</div><!-- div row --->
		
		<div class="row">
		
		</div>
		
		</div>
		<?php }?>  <!--- Ket thuc hien thi thong tin --->
     </div><!-- /#page-wrapper -->

</html>



<?php 
	require ('layout/footer.php'); 
?>