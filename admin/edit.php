<?php
	
	require('../config.php');
	$errors_product = array();
	$fedit_product=array();
	$row =array();
	$msg_product = array();
	// lay Id cua san pham muon sua thong tin -> dua du lieu vao from
	if(isset($_GET['product'])){
		$id_product = $_GET['product'];
		$query_product = "select * from cdinfo where id_cd = '$id_product'";
		$result_product = mysql_query($query_product);
		$rows_product = mysql_fetch_array($result_product);
		$fedit_product['id_kind']        = $rows_product['id_kind'];
		$fedit_product['cd_code']       = $rows_product['cd_code'];
		$fedit_product['cd_name']    = $rows_product['name_cd'];
		$fedit_product['singer']    = $rows_product['singer'];
		$fedit_product['desc']     = $rows_product['description'];
		$fedit_product['price']       = $rows_product['price'];
		$fedit_product['quant'] = $rows_product['quantityinstock'];
	}
		//lay thong tin san pham moi tu from
		if(isset($_POST['edit_product_submit'])){
			$edit_cd_code   = $_POST['edit_cd_code'];
			$edit_cd_name   = mysql_real_escape_string($_POST['edit_cd_name']);
			$edit_singer    = mysql_real_escape_string($_POST['edit_singer']);
			$edit_id_kind   = mysql_real_escape_string($_POST['edit_id_kind']);
			$edit_desc      = mysql_real_escape_string($_POST['edit_desc']);
			$edit_price     = mysql_real_escape_string($_POST['edit_price']);
			$edit_quant     = mysql_real_escape_string($_POST['edit_quant']);
		}
		if(isset($_POST['edit_product_submit'])){
	//kiểm tra dữ liệu nhập vào ở form

			if(empty($_POST['edit_cd_code']))
				$errors_product[] = 'Hãy nhập mã của sản phẩm !';

			if(empty($_POST['edit_cd_name']))
				$errors_product[] = 'Hãy nhập tên của sản phẩm !';
				
			if(!empty($_POST['edit_cd_name']) && (strlen($_POST['edit_cd_name']) < 5))
				$errors_product[] = 'Tên sản phẩm tối thiểu 5 ký tự.';

			if(empty($_POST['edit_singer']))
				$errors_product[] = 'Hãy nhập tê ca sỹ thể hiện !';

			if(empty($_POST['edit_id_kind']))
				$errors_product[] = 'Hãy nhập loại sản phẩm !';

			if(empty($_POST['edit_price']))
				$errors_product[] = 'Hãy nhập giá bán của sản phẩm !';

			if(empty($_POST['edit_quant']))
				$errors_product[] = 'Hãy nhập số lượng trong kho của sản phẩm !';

			if(!empty($_POST['edit_id_kind']) && !preg_match('#^[0-9]+$#i', $_POST['edit_id_kind']))
				$errors_product[] = 'Loại sản phẩm là số nguyên';
		
			if(count($errors_product) == 0){
				$check_kind1= mysql_query("select * from cdkind where id_kind = '$edit_id_kind'");
				$check_id_kind=mysql_fetch_array($check_kind1);
				$check_kind=mysql_num_rows($check_kind1);
				$check_code1= mysql_query("select * from cdinfo where cd_code = '$edit_cd_code'");
				$check_cd_code=mysql_fetch_array($check_code1);
				$check_code=mysql_num_rows($check_code1);
				
				//kiem tra loai san pham da co chua, chua co thi exit, co roi thi tiep tuc
				if($check_kind == 0){
					$errors_product[] = "Loại sản phẩm này không có trong hệ thống";
				} else{	
					if($check_code == 0 ){					//kiem tra ma san pham duoc dung chua, =0 la chua duoc su dung, updtae ngay, > 0 la da duoc su dung -> check id tiep
						//update san pham
						mysql_query("UPDATE cdinfo SET id_kind = '$edit_id_kind',cd_code ='$edit_cd_code',name_cd='$edit_cd_name',description='$edit_desc',price='$edit_price', quantityinstock='$edit_quant' WHERE id_cd ='$id_product'");
						//dua ra thong bao
						$msg_product[] = "Đã cập nhật thành công khách hàng!";
					}
					else { //code da co trong he thong, check id neu van la san pham cu thi cho sua, neu la id cua san pham khac thi dua ra loi
						if ($id_product == $check_cd_code['id_cd']){  //kiem tra  id san pham, neu van la san pham cu thi cho sua, khac thi exit
							//update san pham
							mysql_query("UPDATE cdinfo SET id_kind = '$edit_id_kind',cd_code ='$edit_cd_code',name_cd='$edit_cd_name',description='$edit_desc',price='$edit_price', quantityinstock='$edit_quant' WHERE id_cd ='$id_product'");
							//dua ra /hong bao
							$msg_product[] = "Đã cập nhật thành công Sản phẩm!";
						} else{
							$errors_product[] = " Mã sản phẩm " .$edit_cd_name." đã được sử dụng";
						}
						
					}
				}
			}
		}
	//
	//
	//
	//Chinh sua thong tin nguoi dung
	//
	//
	//
	
	$errors_user = array();
	$fesit_user=array();
	$row_user =array();
	$msg_user = array();
	if(isset($_GET['user'])){
		$id_user = $_GET['user'];
		$query_user = "select * from customers where id_customer = '$id_user'";
		$result_user = mysql_query($query_user);
		$rows_user = mysql_fetch_array($result_user);
		$fesit_user['username']        = $rows_user['username'];
			$fesit_user['email']       = $rows_user['email'];
			$fesit_user['fullname']    = $rows_user['fullname'];
			$fesit_user['address']     = $rows_user['address'];
			$fesit_user['phone']       = $rows_user['phone'];
			$fedit_user['id_customer'] = $rows_user['id_customer'];
			$fedit_user['status']      = $rows_user['status'];
	}
		//kiem tra thêm người dùng mới
		if(isset($_POST['edit_user_submit'])){
			$edit_username   = $_POST['edit_username'];
			$edit_email     = mysql_real_escape_string($_POST['edit_email']);
			$edit_fullname = $_POST['edit_fullname'];
			$edit_address   = mysql_real_escape_string($_POST['edit_address']);
			$edit_phone     = mysql_real_escape_string($_POST['edit_phone']);
			$edit_status     = mysql_real_escape_string($_POST['edit_status']);
			//kiểm tra dữ liệu nhập vào ở form
		if(isset($_POST['edit_user_submit'])){

				if(empty($_POST['edit_username']))
					$errors_user[] = 'Hãy nhập tên tài khoản !';
					
				if(!empty($_POST['edit_username']) && (strlen($_POST['edit_username']) > 20 || strlen($_POST['edit_username']) < 5))
					$errors_user[] = 'Tài khoản giới hạn 5~20 ký tự.';
	
				if(!empty($_POST['edit_username']) && !preg_match('#^[a-z0-9]+$#i', $_POST['edit_username']))
					$errors_user[] = 'Tài khoản chỉ chứa ký tự: aA-zZ, 0-9';

				if(empty($_POST['edit_email']))
					$errors_user[] = 'Hãy nhập email của bạn !';

				if(empty($_POST['edit_phone']))
					$errors_user[] = 'Hãy nhập số điện thoại của bạn !';

			}
			if(count($errors_user) == 0){
				if (!filter_var($edit_email, FILTER_VALIDATE_EMAIL)) // Kiểm tra định dạng Email
				{
					$errors_user[] =  "Email không dúng định dạng";
				}
			}
			if(count($errors_user) == 0){
				$check_user= mysql_query("select * from customers where username = '$edit_username'");
				$check_id_user=mysql_fetch_array($check_user);
				$check_user=mysql_num_rows($check_user);
				$check_email= mysql_query("select * from customers where email = '$edit_email'");
				$check_id_email=mysql_fetch_array($check_email);
				$check_email=mysql_num_rows($check_email);
				//kiem tra id_customer
				if ($id_user != $check_id_user['id_customer'] && $id_user != $check_id_email['id_customer']){
					//kiem tra username
					if($check_user != 0){
						$errors_user[] = " Tài khoản " .$edit_username." đã được sử dụng";
					}
					//kiểm tra email
					if($check_email != 0){
						$errors_user[] = " Email " .$edit_email." đã được sử dụng";
					}
					//ghi dữ liệu vào bảng customers
					if ( $check_user==0 && $check_email == 0){
						mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone', status='$edit_status' WHERE id_customer =$id_user");
						//$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
						$msg_user[] = "Đã cập nhật thành công khách hàng!";
					}
				} else
				{
					mysql_query("UPDATE customers SET username = '$edit_username',email='$edit_email',fullname='$edit_fullname',address='$edit_address',phone='$edit_phone', status='$edit_status' WHERE id_customer =$id_user");
					//$msg[] = "Đã cập nhật thông tin ! <br>Tài khoản: <b>" .$edit_username."</b><br> Email là : <b>" .$edit_email."</b><br> Địa chỉ : <b>" .$edit_address."</b><br> Số điện thoại : <b>" .$edit_phone."</b><br>";
					$msg_user[] = "Đã cập nhật thành công khách hàng!";
				}
			}
		}
		
		//
		//
		//
		// Chinh sua thong tin loai san pham
		//
		//
		//
		
	$errors_cat = array();
	$fesit_cat=array();
	$row_cat =array();
	$msg_cat = array();
	if(isset($_GET['cat'])){
		$id_cat = $_GET['cat'];
		$query_cat = "select * from cdkind where id_kind = '$id_cat'";
		$result_cat = mysql_query($query_cat);
		$rows_cat = mysql_fetch_array($result_cat);
		$fesit_cat['id_kind']        = $rows_cat['id_kind'];
		$fesit_cat['name_kind']       = $rows_cat['name_kind'];

	}
		//kiem tra thêm người dùng mới
		if(isset($_POST['edit_cat_submit'])){
			$edit_cat_id      = $_POST['edit_cat_id'];
			$edit_cat_name    = $_POST['edit_cat_name'];
		if(isset($_POST['edit_cat_submit'])){

				if(empty($_POST['edit_cat_id']))
					$errors_cat[] = 'Hãy nhập mã loại sản phẩm !';

				if(empty($_POST['edit_cat_name']))
					$errors_cat[] = 'Hãy nhập tên loại sản phẩm !';

			}
		if(count($errors_cat) == 0){
			$check_cat_id= mysql_query("select * from cdkind where id_kind = '$edit_cat_id'");
			$check_cat_id_new = mysql_fetch_array($check_cat_id);
			$check_cat_id=mysql_num_rows($check_cat_id);
			//kiem tra ma loai san pham da co chua ?
			If($edit_cat_id  == $id_cat){
				mysql_query("UPDATE cdkind SET id_kind = '$edit_cat_id',name_kind='$edit_cat_name' WHERE id_kind =$id_cat");
				$msg_cat[] = "Đã cập nhật thành công loại sản phẩm!";
			}
			else{
				if ( $check_cat_id==0 ){
					mysql_query("UPDATE cdkind SET id_kind = '$edit_cat_id',name_kind='$edit_cat_name' WHERE id_kind =$id_cat");
					$msg_cat[] = "Đã cập nhật thành công loại sản phẩm!";
				}
				else {
					$errors_cat[] = " Mã loại sản phẩm <strong>" .$edit_cat_id. "</strong> đã dược sử dụng";
				}
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
		
		<!--
		---
		--- Hien thi form chinh sua thong tin san pham --- 
		---
		--->
		<?php if(isset($_GET['product'])){ ?>
		<div class="row">
			<div class="col-lg-12">
              	<div class="col-lg-8 add-customers-form">
                    <div class="panel panel-primary">
						<div class="panel-heading">
						<h2 class="panel-title"><center>Chỉnh sửa thông tin sản phẩm</center></h2>
						</div>
					<div class="panel-body">
                    <form id="add_customer" action="" method="post">
						<div class="row">
						<div class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon">Mã SP</span>
								<input name="edit_cd_code" type="text" class="form-control input-lg" value="<?php echo $fedit_product['cd_code']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Tên SP</i></span>
								<input name="edit_cd_name" type="text" class="form-control input-lg" value="<?php echo $fedit_product['cd_name']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Ca sỹ</span>
								<input name="edit_singer" type="text" class="form-control input-lg" value="<?php echo $fedit_product['singer']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Loại SP</span>
								<input name="edit_id_kind" type="number" class="form-control input-lg" value="<?php echo $fedit_product['id_kind']; ?>">
							</div>
							<br>
							 
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
                                <span class="input-group-addon">Mô tả </i></span>
								<textarea name="edit_desc" type="text" class="form-control input-lg" rows_product="4" > <?php echo $fedit_product['desc']; ?> </textarea>
                             </div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Giá bán   </span>
								<input name="edit_price" type="text" class="form-control input-lg" value="<?php echo $fedit_product['price']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">SL kho</span>
								<input name="edit_quant" type="text" class="form-control input-lg" value="<?php echo $fedit_product['quant']; ?>">
							</div>
						</div>
						</div>
						<br>
						<div class="row">
                            <center>
							<button name="edit_product_submit" type="submit" class="btn btn-primary btn-lg">Cập nhật thông tin</button>
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
						<?php	// Đưa ra thông báo khi không sua dc thong tin san pham
							if(count($errors_product) > 0){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo "Không thể thêm! Dữ liệu đã nhập" ?></strong></center>
										</div>	
							<?php
							}
							?>
						<?php	//Đưa ra thông báo khi sua thong tin san pham thành công
							if(count($msg_product) > 0){
								foreach($msg_product as $msg_product){ ?>
									<div class="alert alert-success fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $msg_product ?></strong></center>
									</div>	
							<?php	}
								unset($msg_product);
							}
							?>
					<div class="table-responsive"> <!-- Xuất dữ liệu san phẩm đã chinh sua -->
						<table class="table table-bordered table-hover table-striped tablesorter">
						<tbody>
							<tr>
								<td><b>Mã SP:</td><td><?php if(isset($_POST['edit_product_submit'])) echo $edit_cd_code;?></td>
							</tr>
							<tr>
								<td><b>Tên SP</td><td><?php if(isset($_POST['edit_product_submit']))echo $edit_cd_name;?></td>
							</tr>
							<tr>
								<td><b>Loại SP</td><td><?php if(isset($_POST['edit_product_submit'])) echo $edit_id_kind;?></td>
							</tr>
							<tr>
								<td><b>Ca sỹ</td><td><?php if(isset($_POST['edit_product_submit']))echo $edit_singer; ?></td>
							</tr>
							<tr>
								<td><b>Mô tả</td><td><?php if(isset($_POST['edit_product_submit'])) echo $edit_desc;?></td>
							</tr>
							<tr>
								<td><b>Giá tiền</td><td><?php if(isset($_POST['edit_product_submit'])) echo $edit_price;?></td>
							</tr>
							<tr>
								<td><b>SL kho</td><td><?php if(isset($_POST['edit_product_submit'])) echo $edit_quant;?></td>
							</tr>
						</tbody>
						</table>
					</div>
					<br>
					<div>
					<!-- Đưa ra thông báo -->
							<?php	//Đưa thông báo gặp lỗi nào
							if(count($errors_product) > 0){
								foreach($errors_product as $errors_product){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $errors_product ?></strong></center>
										</div>	
							<?php	}
								unset($errors_product);
							}
							?>
							
							
					</div>
				</div>	<!-- div panel panel-primary -->
				</div> <!-- div col-lg-4 -->
						
					
						
         </div> <!-- div col-lg-12 -->
		</div><!-- div row --->
		</div>  <?php }?>
		<!--
		---
		--- ket thuc chinh sua thong tin san pham --- 
		---
		--->
		
		
		<!--
		---
		--- Hien thi form chinh sua thong tin nguoi dung --- 
		---
		--->
		
		<?php if(isset($_GET['user'])){ ?>
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
								<input name="edit_username" type="text" class="form-control input-lg" value="<?php echo $fesit_user['username']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">UserEmail</i></span>
								<input name="edit_email" type="text" class="form-control input-lg" value="<?php echo $fesit_user['email']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Họ và tên   </span>
								<input name="edit_fullname" type="text" class="form-control input-lg" value="<?php echo $fesit_user['fullname']; ?>">
							</div>
							<br>
							 
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
                                <span class="input-group-addon">Nhóm </i></span>
								<input name="edit_status" type="text" class="form-control input-lg" value="<?php echo $fedit_user['status']; ?>">
                             </div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Địa chỉ   </span>
								<input name="edit_address" type="text" class="form-control input-lg" value="<?php echo $fesit_user['address']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Phone</span>
								<input name="edit_phone" type="number" class="form-control input-lg" value="<?php echo $fesit_user['phone']; ?>">
							</div>
						</div>
						</div>
						<br>
						<div class="row">
                            <center>
							<button name="edit_user_submit" type="submit" class="btn btn-primary btn-lg">Cập nhật thông tin</button>
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
						<?php	// Đưa ra thông báo khi không chinh sua duoc nguoi dung
							if(count($errors_user) > 0){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo "Không thể thêm! Dữ liệu đã nhập" ?></strong></center>
										</div>	
							<?php
							}
							?>
						<?php	//Đưa ra thông báo khi chinh sua thong tin người dùng thành công
							if(count($msg_user) > 0){
								foreach($msg_user as $msg_user){ ?>
									<div class="alert alert-success fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $msg_user ?></strong></center>
									</div>	
							<?php	}
								unset($msg_user);
							}
							?>
					<div class="table-responsive"> <!-- Xuất dữ liệu người dùng da chinh sua -->
						<table class="table table-bordered table-hover table-striped tablesorter">
						<tbody>
							<tr>
								<td><b>Tài khoản:</td><td><?php if(isset($_POST['edit_user_submit'])) echo $edit_username;?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ Email</td><td><?php if(isset($_POST['edit_user_submit']))echo $edit_email;?></td>
							</tr>
							<tr>
								<td><b>Loại tài khoản:</td><td><?php if(isset($_POST['edit_user_submit'])) echo $_POST['edit_status'];?></td>
							</tr>
							<tr>
								<td><b>Họ tên</td><td><?php if(isset($_POST['edit_user_submit']))echo $edit_fullname; ?></td>
							</tr>
							<tr>
								<td><b>Địa chỉ</td><td><?php if(isset($_POST['edit_user_submit'])) echo $edit_address;?></td>
							</tr>
							<tr>
								<td><b>Số điện thoại</td><td><?php if(isset($_POST['edit_user_submit'])) echo $edit_phone;?></td>
							</tr>
						</tbody>
						</table>
					</div>
					<br>
					<div>
					<!-- Đưa ra thông báo -->
							<?php	//Đưa thông báo gặp lỗi nào
							if(count($errors_user) > 0){
								foreach($errors_user as $errors_user){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $errors_user ?></strong></center>
										</div>	
							<?php	}
								unset($errors_user);
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
		<?php }?> 
		
		<!--
		---
		--- Ket thuc form chinh sua thong tin nguoi dung --- 
		---
		--->
		
		<!--
		---
		--- Hien thi form chinh sua loai san pham --- 
		---
		--->
		<?php if(isset($_GET['cat'])){ ?>
        <div class="row">
			 <div class="col-lg-12">
			    <div class="col-lg-8 add-customers-form">
                    <div class="panel panel-primary">
						<div class="panel-heading">
						<h2 class="panel-title"><center>Chỉnh sửa thông tin loại sản phẩm</center></h2>
						</div>
					<div class="panel-body">
                    <form id="add_customer" action="" method="post">
						<div class="row">
						<div class="col-lg-6">
							<div class="input-group">
								<span class="input-group-addon">Mã Categories</span>
								<input name="edit_cat_id" type="number" class="form-control input-lg" value="<?php echo $fesit_cat['id_kind']; ?>">
							</div>
							<br>
							
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
                                <span class="input-group-addon">Loại Categories </i></span>
								<input name="edit_cat_name" type="text" class="form-control input-lg" value="<?php echo $fesit_cat['name_kind']; ?>">
                             </div>
							<br>
							
						</div>
						</div>
						<br>
						<div class="row">
                            <center>
							<button name="edit_cat_submit" type="submit" class="btn btn-primary btn-lg">Cập nhật thông tin</button>
							</center>
						</div>
					</form>
					</div>
				</div>
			</div>
			<!--- hien thi thong tin da chinh sua --->
				<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center>Thông tin loại sản phẩm chỉnh sửa</center></h2>
						</div>
					<div class="panel-body">
						<?php	// Đưa ra thông báo khi không chinh sua duoc loai san pham
							if(count($errors_cat) > 0){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo "Không thể thêm! Dữ liệu đã nhập" ?></strong></center>
										</div>	
							<?php
							}
							?>
						<?php	//Đưa ra thông báo khi chinh sua thong tin loai san pham thành công
							if(count($msg_cat) > 0){
								foreach($msg_cat as $msg_cat){ ?>
									<div class="alert alert-success fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $msg_cat ?></strong></center>
									</div>	
							<?php	}
								unset($msg);
							}
							?>
					<div class="table-responsive"> <!-- Xuất dữ liệu loai san pham da sua -->
						<table class="table table-bordered table-hover table-striped tablesorter">
						<tbody>
							<tr>
								<td><b>Mã Cat</td><td><?php if(isset($_POST['edit_cat_submit'])) echo $edit_cat_id;?></td>
							</tr>
							<tr>
								<td><b>Loại Cat</td><td><?php if(isset($_POST['edit_cat_submit']))echo $edit_cat_name;?></td>
							</tr>
							
						</tbody>
						</table>
					</div>
					<br>
					<div>
					<!-- Đưa ra thông báo -->
							<?php	//Đưa thông báo gặp lỗi nào
							if(count($errors_cat) > 0){
								foreach($errors_cat as $errors_cat){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo $errors_cat ?></strong></center>
										</div>	
							<?php	}
								unset($errors_cat);
							}
							?>
							
							
					</div>
				</div>	<!-- div panel panel-primary -->
				</div> <!-- div col-lg-4 -->
						
					
						
         </div>
			
			
		</div>
        </div>  
		<?php } ?>
		<!--
		---
		--- ket thuc form chinh sua thong tin loai san pham --- 
		---
		--->
		
     </div><!-- /#page-wrapper -->

</html>



<?php 
	require ('layout/footer.php'); 
?>