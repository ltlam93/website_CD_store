<?php 
	session_start();
	require('config-home.php');
	if(isset($_POST['buy_submit'])){
		$user = $_SESSION["username"];
		$id_user = $mysqli->query("SELECT id_customer FROM customers WHERE username ='$user'"); // lay ra ID cua tai khoan dang dnag nhap
		$requiredate = $_POST['requiredate'];
		$query = "INSERT INTO order(id_customer, orderDate, requiredDate) VALUES ('$id_user', CURRENT_DATE , '$requiredate')";
		$mysqli->query($query);
		$id_order = $mysqli->query("SELECT id_order FROM `order` WHERE id_customer ='$id_user' AND shippedDate='$requiredate'");
		foreach ($_SESSION["products"] as $item){
			$id = $item["id"];
			$quantity = $item["quantity"];
			$price = $item["price"];
			$result2=	$mysqli->query("INSERT INTO orderdetail(id_order,cd_code,quantityOrdered,priceEach) VALUES ('$id_order','$id','$quantity','$price')");
		}
		
	}
?>

<!DOCTYPE html>

<!-- BEGIN html -->
<html>
	
	<!-- BEGIN head -->
	<head>
		
		<!-- Title -->
		<title>CD STORE - Chất Lượng và dịch vụ chuyên nghiệp</title>
		
		<!-- Meta tags -->
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=100%; initial-scale=1; minimum-scale=1;" />
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="css/checkout.css" type="text/css" />
		<!--[if lt IE 9]><link rel="stylesheet" href="css/ie678-fix.css" type="text/css" type="text/css" /><![endif]-->
		
		<!-- JavaScripts -->
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery.placeholder.min.js" type="text/javascript"></script>
		<script src="js/jquery.uniform.js" type="text/javascript"></script>
		<script src="js/jquery.cycle.all.js" type="text/javascript"></script>
		<script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
		<script src="js/jquery.touchwipe.js" type="text/javascript"></script>
		<script src="js/html5shiv.js" type="text/javascript"></script>
		<script src="js/theme.js" type="text/javascript"></script>
		
	<!-- END head -->
	</head>
	
	<!-- BEGIN body -->
	<body class="top">
		
		<div class="main-body-color-mask"></div>

		<!-- BEGIN .main-body-wrapper -->
		<div class="main-body-wrapper">
						
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
					
				<!-- BEGIN .main-header -->
				<div class="main-header">
					<div class="logo">
						<a href="index.php" class="logo-blank custom-font-1"><span> CD STORE</span></a>
						<span class="custom-font-1">Chất Lượng và dịch vụ chuyên nghiệp</span>
					</div>
				<!-- END .main-header -->
				</div>
	
				<!-- BEGIN .main-content -->
				<div class="main-content item-block-3">
					<div class="content">
	
						<!-- BEGIN .header -->
						<div class="header">
	
							<div class="left">
	
								<h6>Bạn đã chọn mua những mặt hàng sau:</h6>
								<?php if(isset($_SESSION["products"])) // hien thi thong tin item da dua vao gio hang va tinh tong tien
								{
									$total = 0;
								foreach ($_SESSION["products"] as $cart_item){ //hien thi nhung item da chon mua
								echo '<div class="item">';
									echo '<div class="image-wrapper-1">';
										echo '<div class="image">';
											echo '<a href="#"><img src="images-checkout/photo-'.$cart_item["id"].'.jpg" alt="" width="50" height="50" /></a>';
										echo '</div>';
									echo '</div>';
									echo '<div class="text">';
										echo '<h3 class="custom-font-1">'.$cart_item["name"].'</h3>';
										echo '<p>'.$cart_item["quantity"].' x '.$cart_item["price"].' VNĐ</p>';
									echo '</div>';
								echo '</div>';
								
								$subtotal = ($cart_item["price"]*$cart_item["quantity"]); // tinh tong tien cua tung san pham
								$total = ($total + $subtotal); // tinh tong gia tien cua tat ca san pham
								}
	
							echo '</div>';
	
							echo '<div class="right custom-font-1">';
								echo '<h2>'.$total.' VNĐ</h2>';
								echo '<h3>(Miễn phí gói vận chuyển (300k)</h3>';
								echo '<h4>Step 1 of 2</h4>';
							echo '</div>';
							} ?>
							
							<div class="clear"></div>
	
						<!-- END .header -->
						</div>
						<!-- hien thi phan thong tin khach hang -->
						<div class="form-wrapper">
							<form method="post">
		
								<div class="checkout-item contact-email">
									<div class="main-title">		
									</div>
								</div>
								<?php if(isset($_SESSION["username"])){ //hien thi thong tin user
										$username = $_SESSION["username"];
										$sql = $mysqli->query("SELECT * FROM customers WHERE username ='$username'");
										$obj = $sql->fetch_object(); ?>
								<div class="checkout-item billing-address">
									<div class="main-title">
										<p class="custom-font-1">Thông tin mua và nhận hàng</p>
									</div>
									<div class="items">
										<p><label>Họ và tên:</label><strong><?php echo $obj->username ?></strong></p>
										<p><label>Email:</label><strong><?php echo $obj->email ?></strong></p>
										<p><label>Địa chỉ:</label><strong><?php echo $obj->address ?></strong></p>
										<p><label>Số điện thoại:</label><strong><?php echo $obj->phone ?></strong></p>
										<p><label>Ngày nhận hàng:</label><input name="requiredate" type="date" class="input-text-1" /></p>
										<p><label>Ghi chú:</label><input type="text" class="input-text-1" /></p>
									</div>
								</div>
		
								<div class="checkout-item shipping-address">
									<div class="main-title">
										<p class="custom-font-1">Địa chỉ nhận hàng</p>
									</div>
									<div class="items">
										<center><p><strong><?php echo $obj->address ?></strong></p></center>
										<p class="message"><span>Hàng sẽ được gửi đến theo địa chỉ mà quý khách đã đăng ký.</span></p>
									</div>
								</div>
								
								<div class="clear"></div>
		
								<div class="next-step">
									<table>
										<tr>
											<td>
												<button name="buy_submit" type="submit" class="button-1 custom-font-1">Mua hàng</button><b>hoặc <a href="index.php">Quay lại cửa hàng</a></b>
											</td>
										</tr>
									</table>
								</div>
								<?php } else{ // hien thi thong bao neu nguoi dung chua dang nhap
								echo '<div class="checkout-item contact-email">';
									echo '<div class="main-title">';
										echo '<center><p class="custom-font-1">Rất tiếc bạn chưa đăng nhập tài khoản</p></center>';
									echo '</div>';
									echo '<center><p><a href="login.php"><b>Đăng nhập ngay!</b></a>Bạn chưa có tài khoản?  <a href="register.php">Đăng ký tại đây</a></p></center>';
								echo '<br><br><br></div>';
								}
								?>
							</form>
						</div>
						<div class="clear"></div>
	
					</div>
				<!-- END .main-content -->
				</div>

			<!-- END .main-content-wrapper -->
			</section>
			
		<!-- END .main-body-wrapper -->
		</div>

	<!-- END body -->
	</body>
	
<!-- END html -->
</html>