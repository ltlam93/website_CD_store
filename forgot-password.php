<?php
	require('config-home.php');
	$errors= array();
	$msg = array();
	//code check email va send email cho email tai khoan
	if (isset($_POST["get_submit"])) {
		$email = $_POST["email"]; // lay ra email cua nguoi dung
		$check = $mysqli->query("SELECT * FROM customers WHERE email ='$email'");
		$row = $check->fetch_row();
		if($row > 0){
			$to = "support@cdstore.com"; 
			$subject = "Khôi phục mật khẩu"; 
			$message = "Mật khẩu bạn là :" ; 
			$headers = "From: $email"; 
			$sent = mail($to, $subject, $message, $headers) ; 
			$msg[] = "Thông tin tài khoản đã được gửi vào email của bạn!";
		} else {
			$errors[] = "Email bạn nhập chưa được sử dụng, hãy thử lại";
		
		}
	}
 ?> 

<?php 
	require('header.php');
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
						<a href="#">Quên mật khẩu</a>
					</div>
					<div class="title">
						<h4>Quên mật khẩu</h4>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .single-full-width -->
				<section class="single-full-width clearfix">
					
					<!-- BEGIN .contact-form -->
					<div class="contact-form">
					<?php if (!isset($_POST["get_submit"])) { ?>
						<form method="post">
							<p>
								<label>Email:</label>
								<input name="email" type="email" />
							</p>
							<p class="submit">
								<label></label>
								<button name="get_submit" type="submit">Lấy lại mật khẩu</button>
							</p>
						</form> <?php } ?>
						
						<?php if(count($msg) > 0){
							echo $msg ;
							}?>
						<p class="input-error-wrapper">
						<?php if(count($errors) > 0){
							echo $errors ;
							}?> </p>
						<div class="text">
							<p><b>Lấy lại mật khẩu.</b></p>
							<p>Nếu bạn là khách hàng đã đăng ký trước đây, và không còn nhớ mật khẩu của tìa khoản mình là gì. Chúng tôi sẽ giúp bạn lấy lại mật khẩu cho tài khoản của bạn. Hãy nhập email mà bạn đã đăng ký tài toàn trước đây. Thông tin phục hồi mật khẩu sẽ được gửi về mail cho bạn!.</p>
						</div>
					<!-- END .contact-form -->
					</div>
				
				<!-- END .single-full-width -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
			
<?php 
	require('footer.php');
 ?>