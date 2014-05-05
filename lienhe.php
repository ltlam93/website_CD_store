<?php
	require('config-home.php');
	if(isset($_POST['send_submit'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$type = $_POST['type'];
		$content = $_POST['content'];
		$query = $mysqli->query("INSERT INTO support(fullname,email,type_support,content,time) VALUES ('$name','$email','$type','$content',CURRENT_TIMESTAMP)");
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
						<a href="#">Liên hệ</a>
					</div>
					<div class="title">
						<h4>Liên hệ</h4>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .single-full-width -->
				<section class="single-full-width clearfix">
					<?php if(isset($_POST['send_submit'])){ 
						echo '<center><p>Support của bạn đã được gửi! <a href="index.php"><span style="color:red"> Quay lại trang chủ</span></a></p></center>';
					} else { ?>
					<!-- BEGIN .contact-form -->
					<div class="contact-form">
						<form method="post">
							<p>
								<label>Họ và tên:</label>
								<input name="name" type="text" />
							</p>
							<p>
								<label>Email:</label>
								<input name="email" type="email" />
							</p>
							<p>
								<label>Loại hỗ trợ:</label>
								<select name="type">
									<option>Báo lỗi</option>
									<option>Hỗ trợ thanh toán</option>
									<option>Hỗ trợ kỹ thuật</option>
								</select>
							</p>
							<p>
								<label>Nội dung:</label>
								<textarea name="content" class="textarea-1"></textarea>
							</p>
							<p class="submit">
								<label></label>
								<button name="send_submit" type="submit">Gửi hỗ trợ</button>
							</p>
						</form>
						<div class="text">
							<p><b>Yêu cầu hỗ trợ.</b></p>
							<p>Nếu bạn gặp bất cứ vấn đề gì về mua hàng, giá sản phẩm, kỹ thuật.... hãy gửi support cho chúng tôi.</p>
						</div>
					<!-- END .contact-form -->
					</div>
					<?php } ?>
				<!-- END .single-full-width -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
			
<?php 
	require('footer.php');
 ?>