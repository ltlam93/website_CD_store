<?php
	
	require('../config.php');
	$errors = array();
	$fesit=array();
	$row =array();
	$msg = array();
	// lay Id cua san pham muon sua thong tin -> dua du lieu vao from
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "select * from cdinfo where id_cd = '$id'";
		$result = mysql_query($query);
		$rows = mysql_fetch_array($result);
		$fesit['id_kind']        = $rows['id_kind'];
		$fesit['cd_code']       = $rows['cd_code'];
		$fesit['cd_name']    = $rows['name_cd'];
		$fesit['singer']    = $rows['singer'];
		$fesit['desc']     = $rows['description'];
		$fesit['price']       = $rows['price'];
		$fesit['quant'] = $rows['quantityinstock'];
	}
		//lay thong tin san pham moi tu from
		if(isset($_POST['edit_submit'])){
			$edit_cd_code   = $_POST['edit_cd_code'];
			$edit_cd_name   = mysql_real_escape_string($_POST['edit_cd_name']);
			$edit_singer    = mysql_real_escape_string($_POST['edit_singer']);
			$edit_id_kind   = mysql_real_escape_string($_POST['edit_id_kind']);
			$edit_desc      = mysql_real_escape_string($_POST['edit_desc']);
			$edit_price     = mysql_real_escape_string($_POST['edit_price']);
			$edit_quant     = mysql_real_escape_string($_POST['edit_quant']);
		}
		if(isset($_POST['edit_submit'])){
	//kiểm tra dữ liệu nhập vào ở form

			if(empty($_POST['edit_cd_code']))
				$errors[] = 'Hãy nhập mã của sản phẩm !';

			if(empty($_POST['edit_cd_name']))
				$errors[] = 'Hãy nhập tên của sản phẩm !';
				
			if(!empty($_POST['edit_cd_name']) && (strlen($_POST['edit_cd_name']) < 5))
				$errors[] = 'Tên sản phẩm tối thiểu 5 ký tự.';

			if(empty($_POST['edit_singer']))
				$errors[] = 'Hãy nhập tê ca sỹ thể hiện !';

			if(empty($_POST['edit_id_kind']))
				$errors[] = 'Hãy nhập loại sản phẩm !';

			if(empty($_POST['edit_price']))
				$errors[] = 'Hãy nhập giá bán của sản phẩm !';

			if(empty($_POST['edit_quant']))
				$errors[] = 'Hãy nhập số lượng trong kho của sản phẩm !';

			if(!empty($_POST['edit_id_kind']) && !preg_match('#^[0-9]+$#i', $_POST['edit_id_kind']))
				$errors[] = 'Loại sản phẩm là số nguyên';
		
			if(count($errors) == 0){
				$check_kind1= mysql_query("select * from cdkind where id_kind = '$edit_id_kind'");
				$check_id_kind=mysql_fetch_array($check_kind1);
				$check_kind=mysql_num_rows($check_kind1);
				$check_code1= mysql_query("select * from cdinfo where cd_code = '$edit_cd_code'");
				$check_cd_code=mysql_fetch_array($check_code1);
				$check_code=mysql_num_rows($check_code1);
				
				//kiem tra loai san pham da co chua, chua co thi exit, co roi thi tiep tuc
				if($check_kind == 0){
					$errors[] = "Loại sản phẩm này không có trong hệ thống";
				} else{	
					if($check_code == 0 ){					//kiem tra ma san pham duoc dung chua, =0 la chua duoc su dung, updtae ngay, > 0 la da duoc su dung -> check id tiep
						//update san pham
						mysql_query("UPDATE cdinfo SET id_kind = '$edit_id_kind',cd_code ='$edit_cd_code',name_cd='$edit_cd_name',description='$edit_desc',price='$edit_price', quantityinstock='$edit_quant' WHERE id_cd ='$id'");
						//dua ra thong bao
						$msg[] = "Đã cập nhật thành công khách hàng!";
					}
					else { //code da co trong he thong, check id neu van la san pham cu thi cho sua, neu la id cua san pham khac thi dua ra loi
						if ($id == $check_cd_code['id_cd']){  //kiem tra  id san pham, neu van la san pham cu thi cho sua, khac thi exit
							//update san pham
							mysql_query("UPDATE cdinfo SET id_kind = '$edit_id_kind',cd_code ='$edit_cd_code',name_cd='$edit_cd_name',description='$edit_desc',price='$edit_price', quantityinstock='$edit_quant' WHERE id_cd ='$id'");
							//dua ra /hong bao
							$msg[] = "Đã cập nhật thành công Sản phẩm!";
						} else{
							$errors[] = " Mã sản phẩm " .$edit_cd_name." đã được sử dụng";
						}
						
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
								<span class="input-group-addon">Mã SP</span>
								<input name="edit_cd_code" type="text" class="form-control input-lg" value="<?php echo $fesit['cd_code']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Tên SP</i></span>
								<input name="edit_cd_name" type="text" class="form-control input-lg" value="<?php echo $fesit['cd_name']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Ca sỹ</span>
								<input name="edit_singer" type="text" class="form-control input-lg" value="<?php echo $fesit['singer']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Loại SP</span>
								<input name="edit_id_kind" type="number" class="form-control input-lg" value="<?php echo $fesit['id_kind']; ?>">
							</div>
							<br>
							 
						</div>
						<div class="col-lg-6">		
							<div class="input-group">
                                <span class="input-group-addon">Mô tả </i></span>
								<textarea name="edit_desc" type="text" class="form-control input-lg" rows="4" > <?php echo $fesit['desc']; ?> </textarea>
                             </div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">Giá bán   </span>
								<input name="edit_price" type="text" class="form-control input-lg" value="<?php echo $fesit['price']; ?>">
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon">SL kho</span>
								<input name="edit_quant" type="text" class="form-control input-lg" value="<?php echo $fesit['quant']; ?>">
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
								<td><b>Mã SP:</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_cd_code;?></td>
							</tr>
							<tr>
								<td><b>Tên SP</td><td><?php if(isset($_POST['edit_submit']))echo $edit_cd_name;?></td>
							</tr>
							<tr>
								<td><b>Loại SP</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_id_kind;?></td>
							</tr>
							<tr>
								<td><b>Ca sỹ</td><td><?php if(isset($_POST['edit_submit']))echo $edit_singer; ?></td>
							</tr>
							<tr>
								<td><b>Mô tả</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_desc;?></td>
							</tr>
							<tr>
								<td><b>Giá tiền</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_price;?></td>
							</tr>
							<tr>
								<td><b>SL kho</td><td><?php if(isset($_POST['edit_submit'])) echo $edit_quant;?></td>
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
		
		
     </div><!-- /#page-wrapper -->

</html>



<?php 
	require ('layout/footer.php'); 
?>