<?php
	$errors = array();
	$msg = array();
	//kiem tra thêm người dùng mới
	if(isset($_POST['add_submit'])){
		require('../config.php');
		$add_username   = $_POST['add_username'];
        $add_email     = mysql_real_escape_string($_POST['add_email']);
        $add_password  = md5($_POST['add_password']);
		$add_fullname = $_POST['add_fullname'];
		$add_address   = mysql_real_escape_string($_POST['add_address']);
		$add_phone     = mysql_real_escape_string($_POST['add_phone']);
		$add_status    = mysql_real_escape_string($_POST['add_status']);
		//checking dữ liệu nhập vào ở form
		if(isset($_POST['add_submit'])){

			if(empty($_POST['add_username']))
				$errors[] = 'Hãy nhập tên tài khoản !';
			
			if(!empty($_POST['add_username']) && (strlen($_POST['add_username']) > 15 || strlen($_POST['add_username']) < 5))
				$errors[] = 'Tài khoản giới hạn 5~15 ký tự.';

			if(!empty($_POST['add_username']) && !preg_match('#^[a-z0-9]+$#i', $_POST['add_username']))
				$errors[] = 'Tài khoản chỉ chứa ký tự: aA-zZ, 0-9';
 
			if(empty($_POST['add_password']))
				$errors[] = 'Hãy nhập mật khẩu !';
				
			if((!empty($_POST['add_password']) && !empty($_POST['add_repassword'])) && (strlen($_POST['add_password']) > 14 || strlen($_POST['add_password']) < 4))
				$errors[] = 'Mật khẩu cho phép 4~12 ký tự.';

			if((!empty($_POST['add_password']) && !preg_match('#^[a-z0-9]+$#i', $_POST['add_password'])) || (!empty($_POST['add_repassword']) && !preg_match('#^[a-z0-9]+$#i', $_POST['add_repassword'])))
				$errors[] = 'Mật khẩu chỉ chứa ký tự: aA-zZ, 0-9';
 
			if(empty($_POST['add_address']))
				$errors[] = 'Hãy nhập tên khách hàng !';

			if(empty($_POST['add_phone']))
				$errors[] = 'Hãy nhập số điện thoại của bạn !';
		}
        if(count($errors) == 0){
			if (!filter_var($add_email, FILTER_VALIDATE_EMAIL)) // Kiểm tra định dạng Email
			{
				$errors[] =  "Email không dúng định dạng";
			}
		}
		// kiem tra username và email da sử dụng chưa
		if(count($errors) == 0){
			$check_user= mysql_query("select username from customers where username = '$add_username'");
			$check_user=mysql_num_rows($check_user);
			$check_email= mysql_query("select email from customers where email = '$add_email'");
			$check_email=mysql_num_rows($check_email);
			//kiem tra username
			if($check_user != 0){
				$errors[] = " Tài khoản " .$add_username." đã được sử dụng";
			}
			//kiểm tra email
			if($check_email != 0){
				$errors[] = " Email " .$add_email." đã được sử dụng";
			}
			//ghi dữ liệu vào bảng customers
			if ( $check_user==0 && $check_email == 0){
				mysql_query("insert into customers(username,password,fullname,address,phone,email,creattime,status) values ('$add_username','$add_password','$add_fullname','$add_address','$add_phone','$add_email',CURRENT_TIMESTAMP,'$add_status')");
				//$msg[] = "Đã thêm thành công khách hàng mới! <br>Tài khoản: <b>" .$add_username."</b><br>  Mật khẩu là :<b> " .$_POST['add_password']. "</b>";
				$msg[] = "Đã thêm thành công khách hàng mới!";
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
              	<div class="col-lg-8 add-customers-form">
                    <div class="panel panel-primary">
						<div class="panel-heading">
						<h2 class="panel-title"><center>Thêm khách hàng mới</center></h2>
						</div>
					<div class="panel-body">
                    <form id="add_customer" action="" method="post">
						<div class="row">
						<div class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input name="add_username" type="text" class="form-control input-lg" placeholder="Tên tài khoản">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input name="add_email" type="text" class="form-control input-lg" placeholder="Địa chỉ Email">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input name="add_password" type="password" class="form-control input-lg" placeholder="Mật khẩu">
							</div>
							<br>
							 <div class="form-group">
                                <select name="add_status" class="form-control input-lg">
									<option> 1 </option>
									<option> 2 </option>
									<option> 3 </option>
									<span class="help-block">1. <b>Normal</b> 2. <b>VIP Customer</b> 3. <b>Administrator</b> Mặc định : <b>1</b></span>
									<span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                                </select>
                             </div>
							<br>
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input name="add_fullname" type="text" class="form-control input-lg" placeholder="Họ và tên">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-home"></i></span>
								<input name="add_address" type="text" class="form-control input-lg" placeholder="Địa chỉ">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
								<input name="add_phone" type="text" class="form-control input-lg" placeholder="Số điện thoại">
							</div>
							<br>
							 <div class="form-group">                        
									<span class="help-block">1. <b>Normal</b> 2. <b>VIP Customer</b> 3. <b>Administrator</b> <br><b>Mặc định : Normal</b></span>
                             </div>
						</div>
						</div>
						<div class="row">
                            <center>
							<button name="add_submit" type="submit" class="btn btn-primary">Thêm mới</button>
							<button type="reset" class="btn btn-danger">Xóa dữ liệu</button> 
							</center>
						</div>
					</form>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center>Thông tin khách đã thêm vào</center></h2>
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
								<td><b>Tài khoản:</td><td><?php if(isset($_POST['add_submit'])) echo $add_username;?></td>
							</tr>
							<tr>
								<td><b>Mật khẩu:</td><td><?php if(isset($_POST['add_submit'])) echo $_POST['add_password'];?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ Email</td><td><?php if(isset($_POST['add_submit']))echo $add_email;?></td>
							</tr>
							<tr>
								<td><b>Loại tài khoản:</td><td><?php if(isset($_POST['add_submit'])) echo $_POST['add_status'];?></td>
							</tr>
							<tr>
								<td><b>Họ tên</td><td><?php if(isset($_POST['add_submit']))echo $add_fullname; ?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ</td><td><?php if(isset($_POST['add_submit'])) echo $add_address;?></td>
							</tr>
							<tr>
								<td><b>Số điện thoại</td><td><?php if(isset($_POST['add_submit'])) echo $add_phone;?></td>
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
		</div><!-- /.row -->

    </div><!-- /#page-wrapper -->

</html>



<?php require ('layout/footer.php'); ?>