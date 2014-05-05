<?php
	$errors = array();
	$msg = array();
	require('config-home.php');
	if(isset($_POST['reg_submit'])){
		$reg_username   = $_POST['reg_username'];
        $reg_email     = mysql_real_escape_string($_POST['reg_email']);
        $reg_password  = md5($_POST['reg_password']);
		$reg_fullname = $_POST['reg_fullname'];
		$reg_address   = mysql_real_escape_string($_POST['reg_address']);
		$reg_phone     = mysql_real_escape_string($_POST['reg_phone']);
		//checking dữ liệu nhập vào ở form
		switch(isset($_POST['reg_submit'])){
		case 1:
			if(empty($_POST['reg_username']))
				$errors[] = 'Hãy nhập tên tài khoản !';
			break;
		case 2: 
			if(empty($_POST['reg_repassword']))
				$errors[] = 'Hãy nhập mật khẩu !';
			break;
		case 3: 
			if(empty($_POST['reg_fullname']))
				$errors[] = 'Hãy nhập họ tên của bạn!';
			break;
		case 4: 
			if(empty($_POST['reg_address']))
				$errors[] = 'Hãy nhập địa chỉ của bạn!';
			break;
		case 5: 
			if(empty($_POST['reg_phone']))
				$errors[] = 'Hãy nhập số điện thoại của bạn !';
			break;
		case 6:
			if(!empty($_POST['reg_username']) && (strlen($_POST['reg_username']) > 20 || strlen($_POST['reg_username']) < 5))
				$errors[] = 'Tài khoản giới hạn 4~12 ký tự.';
			break;
		case 7:
			if(!empty($_POST['reg_username']) && !preg_match('#^[a-z0-9]+$#i', $_POST['reg_username']))
				$errors[] = 'Tài khoản chỉ chứa ký tự: aA-zZ, 0-9';
			break;
		case 8:
			if((!empty($_POST['reg_password']) && !empty($_POST['reg_repassword'])) && (strlen($_POST['reg_password']) > 14 || strlen($_POST['reg_password']) < 4))
				$errors[] = 'Mật khẩu cho phép 4~12 ký tự.';
			break;
		case 9:
			if((!empty($_POST['reg_password']) && !preg_match('#^[a-z0-9]+$#i', $_POST['reg_password'])) || (!empty($_POST['reg_repassword']) && !preg_match('#^[a-z0-9]+$#i', $_POST['reg_repassword'])))
				$errors[] = 'Mật khẩu chỉ chứa ký tự: aA-zZ, 0-9';
			break;
		case 10:
			if((!empty($_POST['reg_password']) && !empty($_POST['reg_repassword'])) && $_POST['reg_password'] != $_POST['reg_repassword'])
				$errors[] = 'Mật khẩu không khớp!';
			break;
		}
        if(count($errors) == 0){
			if (!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) // Kiểm tra định dạng Email
			{
				$errors[] =  "Email không dúng định dạng";
			}
		}
		// kiem tra username và email da sử dụng chưa
		if(count($errors) == 0){
			$check_user= $mysqli_query("select username from customers where username = '$reg_username'");
			$check_user=$check_user->fetch_rows();
			$check_email= $mysqli_query("select email from customers where email = '$reg_email'");
			$check_email=$check_email->fetch_rows();
			//kiem tra username
			if($check_user != 0){
				$errors[] = " Tài khoản " .$reg_username." đã được sử dụng";
			}
			//kiểm tra email
			if($check_email != 0){
				$errors[] = " Email " .$reg_email." đã được sử dụng";
			}
			//ghi dữ liệu vào bảng customers
			if ( $check_user==0 && $check_email == 0){
				mysql_query("insert into customers(username,password,fullname,address,phone,email) values ('$reg_username','$reg_password','$reg_fullname','$reg_address','$reg_phone','$reg_email')");
				$msg[] = "Chúc mừng ! Bạn đã đăng ký thành công";
				header('Refresh:6; url=index.php');

			}
		}
		
	}
	
?>


<?php 
	include('header.php');
 ?>
	<!-- BEGIN body -->
<body class="top">
		
		<div class="main-body-color-mask"></div>
		<div class="lightbox"></div>

		<!-- BEGIN .quick-shop -->
		
		</div>
		
		<!-- BEGIN .main-body-wrapper -->
		<div class="main-body-wrapper">
			
			<!-- BEGIN .main-header -->
			<?php include('menu.php');?>
			<!-- BEGIN .main-navigation -->
			<section class="main-navigation clearfix">
				<nav>
					<div class="navigation">
						<a href="#">Home</a>
					</div>
					<div class="title">
						<h4>Đăng nhập</h4>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .single-full-width -->
				<section class="single-full-width clearfix">
					
					<!-- BEGIN .main-login -->
					<div class="main-login">
						<form  class="login" method="post">
							<p>
								<label>Tài khoản:</label>
								<input name="reg_username" type="text" />
							</p>
							<p>
								<label>Mật khẩu:</label>
								<input name="reg_password" type="password" />
							</p>
							<p>
								<label>Nhập lại mật khẩu:</label>
								<input name="reg_repassword" type="password" />
							</p>
							<p>
								<label>Họ và tên:</label>
								<input name="reg_fullname" type="text" />
							</p>
							<p>
								<label>Email:</label>
								<input name="reg_email" type="email" />
							</p>
							<p>
								<label>Số điện thoại:</label>
								<input name="reg_phone" type="number" />
							</p>
							<p>
								<label>Địa chỉ:</label>
								<input name="reg_address" type="text" />
							</p>

							<p class="sign-in">
								<label></label>
								<button name="reg_submit" type="submit">Đăng ký</button>
								<b>or <a href="index.php">Quay lại cửa hàng</a></b>
							</p>
						</form>
						<p class="input-error-wrapper"><span>
						<?php	if(count($errors) > 0){
										foreach($errors as $error){
											echo '<span style="text-align: left" class="btn1 btn-notifi"> <i class="fa fa-exclamation-triangle"></i></span>  '.$error.'</span><br />';
										}
										unset($errors);
								} ?> 
						</span></p>
						<?php		if(count($msg) > 0){
										foreach($msg as $msg){
											echo '<span style="text-align: left" class="btn1 btn-success"> <i class="fa fa-check-square-o"></i></span>  '.$msg.'</span><br />';
										}
										unset($msg);
								}
						?>
					<!-- END .main-login -->
					</div>
					
					<!-- BEGIN .guest-login -->
					<div class="guest-login">
						<h3>Đã là thành viên</h3>
						<a href="login.php"><button>Đăng nhập thành viên</button></a>
						
					<!-- END .guest-login -->
					</div>
				
				<!-- END .single-full-width -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
<?php 
	include('footer.php');
 ?>