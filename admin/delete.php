<?php
	require('../config.php');
	$msg_user = array();
	$msg_sp   = array();
	$msg_cat  = array();
	$msg_payments  = array();
	//xoa khach hang
	if(isset($_GET['user'])){
		$id_user = $_GET['user'];
		$query_user = mysql_query("select * from customers where id_customer ='$id_user'");
		$query_user = mysql_fetch_array($query_user);
		$del_user = mysql_query("delete from customers where id_customer = '$id_user'");
		$msg_user = "<center><h4>Đã xóa tài khoản <b>".$query_user['username']."</b>. <br>Đang trở về trang trước ... </h4></center>";
		header('Refresh:3; url=view_customers.php');
	}
	//Xoa San pham
	if(isset($_GET['product'])){
		$id_sp = $_GET['product'];
		$query_sp = mysql_query("select * from cdinfo where id_cd ='$id_sp'");
		$query_sp = mysql_fetch_array($query_sp);
		$del_sp = mysql_query("delete from cdinfo where id_cd = '$id_sp'");
		$msg_sp = "<center><h4>Đã xóa Sản phẩm <b>".$query_sp['name_cd']."</b>. <br>Đang trở về trang trước ... </h4></center>";
		header('Refresh:3; url=view_products.php');
	}
	//Xoa loai san pham 
	if(isset($_GET['cat'])){
		$id_cat = $_GET['cat'];
		$query_cat = mysql_query("select * from cdkind where id_kind ='$id_cat'");
		$query_cat = mysql_fetch_array($query_cat);
		$del_cat = mysql_query("delete from cdkind where id_kind = '$id_cat'");
		$msg_user = "<center><h4>Đã xóa loại Sản phẩm <b>".$query_cat['name_kind']."</b>. <br>Đang trở về trang trước ... </h4></center>";
		header('Refresh:3; url=view_categories.php');
	}
	//xoa thong tin thanh toan hoa don
	if(isset($_GET['payments'])){
		$id_payments = $_GET['payments'];
		$query_payments1 = mysql_query("select * from payments_all where checkNumber ='$id_payments'");
		$query_payments1 = mysql_fetch_array($query_payments1);
		$query_payments = mysql_query("select * from payments where checkNumber ='$id_payments'");
		$query_payments = mysql_fetch_array($query_payments);
		$del_payments = mysql_query("delete from payments where checkNumber = '$id_payments'");
		$msg_payments = "<center><h4>Đã xóa hóa đơn thanh toán của :<br> Khách hàng <strong>".$query_payments1['customer']."</strong>.<br> Mã thanh toán :<strong>" .$query_payments['checkNumber']."</strong>. <br>Đang trở về trang trước ... </h4></center>";
		header('Refresh:3; url=payments.php');
	}
?>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<style>
body{
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}
</style>

<link href="css/bootstrap.css" rel="stylesheet">
<body>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
			 <?php	// Đưa ra thông báo xoa nguoi dung
				if(count($msg_user) > 0){ ?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<center><strong><?php echo $msg_user ?></strong></center>
							</div>	
			<?php
				}
			?>
			
			<?php	// Đưa ra thông báo xoa san pham
				if(count($msg_sp) > 0){ ?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<center><strong><?php echo $msg_sp ?></strong></center>
							</div>	
			<?php
				}
			?>
			
			<?php	// Đưa ra thông báo xoa san pham
				if(count($msg_sp) > 0){ ?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<center><strong><?php echo $msg_sp ?></strong></center>
							</div>	
			<?php
				}
			?>
			
			<?php	// Đưa ra thông báo xoa thong tin thanh toan cua nguoi dung
				if(count($msg_payments) > 0){ ?>
					<div class="alert alert-danger fade in">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<center><strong><?php echo $msg_payments ?></strong></center>
							</div>	
			<?php
				}
			?>
			</div>
			<div class="col-lg-4"></div>
			</div>
		</div>
	</div>	
</body>
</head>
</html>