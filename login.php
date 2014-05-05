
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
						<form action="checklogin.php" class="login" method="post">
							<p>
								<label>Tài khoản:</label>
								<input name="log_username" type="text" />
							</p>
							<p>
								<label>Mật khẩu:</label>
								<input name="log_password" type="password" />
							</p>
							<p>
								<label></label>
								<a href="forgot-password.php">Quên mật khẩu?</a>
							</p>
							<p class="sign-in">
								<label></label>
								<button name="log_submit" type="submit">Đăng nhập</button>
								<b>or <a href="index.php">Quay lại cửa hàng</a></b>
							</p>
						</form>
					<!-- END .main-login -->
					</div>
					
					<!-- BEGIN .guest-login -->
					<div class="guest-login">
						<h3>Khách hàng mới</h3>
						<a href="index.php"><button>Continue as guest</button></a>
					<!-- END .guest-login -->
					</div>
				
				<!-- END .single-full-width -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
<?php 
	include('footer.php');
 ?>