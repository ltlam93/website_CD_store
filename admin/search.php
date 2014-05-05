<?php

	
	require('../config.php');
	
	//Hien thi thong tin nguoi dung tu search username
	$msg=array();
	$stt=1;
	if(isset($_GET['all'])){
		$user = $_GET['all'];
		$sql_user = "SELECT * FROM customers where username like '%$user%'";
		$result_user = mysql_query($sql_user);
		$product = $_GET['all'];
		$sql_product = "SELECT * FROM cd_show where name like '%$product%'";
		$result_product = mysql_query($sql_product);
	}
	//Hien thi thong tin san pham tu search san pham
	if(isset($_GET['product'])){
		$product = $_GET['product'];
		$sql_product = "SELECT * FROM cd_show where name like '%$product%'";
		$result_product = mysql_query($sql_product);
	}
	
	
	
	//require file can thiet
	require('layout/header.php');
	require('layout/menu.php'); 
	require('../functions.php');
?>
<html>
<head>
<meta charset="UTF-8" />
</head>

	<div id="page-wrapper">
		<div class="row">
		<div class="col-lg-12">
			<ol class="breadcrumb">
			<p><?= breadcrumbs() ?></p>
			</ol>
		</div>
		<!-- bat dau hien thi search user --->
		<?php 
			if(isset($_GET['all'])){
		?>
		<div class="row"> 
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center>Danh sách khách hàng</center></h2>
					</div>
				<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped tablesorter">
						<thead>
						<tr>
							<th><center>STT  <i class="fa fa-sort"></i></center></th>
							<th><center>Tài khoản  <i class="fa fa-sort"></i></center></th>
							<th><center>Họ tên <i class="fa fa-sort"></i></center></th>
							<th><center>Email  <i class="fa fa-sort"></i></center></th>
							<th><center>Địa chỉ  <i class="fa fa-sort"></i></center></th>
							<th><center>Số điện thoại  <i class="fa fa-sort"></i></center></th>
							<th><center>Tùy chọn  <i class="fa fa-sort"></i></center></th>
						</tr>
						</thead>
					<tbody>
					<?php
						while($rows_user = mysql_fetch_array($result_user))
						{
							echo "<tr>";
							echo "<td><center>" . $stt . "</center></td>";
							echo "<td>" . $rows_user['username'] . "</td>";
							echo "<td><center>" . $rows_user['fullname'] . "</center></td>";
							echo "<td>" . $rows_user['email'] . "</td>";
							echo "<td>" . $rows_user['address'] . "</td>";
							echo "<td>" . $rows_user['phone'] . "</td>";
							echo "<td><center><a name=\"edit_info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sửa thông tin người dùng\" type=\"summit\" class=\"btn btn-primary btn-xs\" href=\"/demo/admin/edit.php?user=".$rows_user['id_customer']."\">Sửa</a> 
								<a name=\"del_summit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Xóa người dùng này\" type=\"summit\" class=\"btn btn-danger btn-xs\" href=\"/demo/admin/delete.php?user=".$rows_user['id_customer']."\">Xóa</button>
								</center></td>";
							echo "</tr>";
							$stt=$stt+1;
							if(isset($_POST['edit_info'])){
								echo $rows['id_customer'];
							}
	
						}
					?>
					</tbody>
					</table>
						
	
				</div>
				</div>
			</div>
		</div>
		
		</div> 
		<?php } ?> <!--- ket thuc hien thi search theo user --->
		
		<!-- bat dau hien thi search product --->
		<?php 
			if(isset($_GET['all'])){
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title"><center>Danh sách các mặt hàng CD đang bán</center></h2>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped tablesorter">
						<thead>
							<tr>
							<th><center>STT  <i class="fa fa-sort"></center></th>
							<th><center>Mã CD  <i class="fa fa-sort"><c/enter></th>
							<th><center>Tên CD  <i class="fa fa-sort"></center></th>
							<th><center>Mô tả  <i class="fa fa-sort"></center></th>
							<th><center>Phân loại  <i class="fa fa-sort"></center></th>
							<th><center>Ca sĩ  <i class="fa fa-sort"></center></th>
							<th><center>Số lượng  <i class="fa fa-sort"></center></th>
							<th><center>Giá  <i class="fa fa-sort"></center></th>
							<th><center>Tùy chọn  <i class="fa fa-sort"></center></th>
							</tr>
						</thead>
						<tbody>
						<?php
						while($rows_product = mysql_fetch_array($result_product)) //xuất dữ liệu ra bảng
						{
							echo "<tr>";
							echo "<td><center>" . $stt . "</center></td>";
							echo "<td><center>" . $rows_product['code'] . "</center></td>";
							echo "<td>" . $rows_product['name'] . "</td>";
							echo "<td>" . $rows_product['description'] . "</td>";
							echo "<td>" . $rows_product['category'] . "</td>";
							echo "<td>" . $rows_product['singer'] . "</td>";
							echo "<td>" . $rows_product['quantityinstock'] . "</td>";
							echo "<td>" . $rows_product['price'] . "</td>";
							echo "<td><center><a name=\"edit_info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sửa thông tin sản phẩm\" type=\"summit\" class=\"btn btn-primary btn-xs\" href=\"/demo/admin/edit.php?product=".$rows_product['id']."\">Sửa</a> 
								<a name=\"del_summit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Xóa sản phẩm này\" type=\"summit\" class=\"btn btn-danger btn-xs\" href=\"/demo/admin/delete.php?id_sp=".$rows_product['id']."\">Xóa</button>
								</center></td>";
							echo "</tr>";
							$stt=$stt+1;
						}
						?>		
						</tbody>
					</table>
					</div>
				</div>
				</div>
			</div>
	
		</div>
		<?php } ?> <!--- ket thuc hien thi search theo product --->
		
	</div>
<?php //call footer.php
	require ('layout/footer.php');	
?>



	