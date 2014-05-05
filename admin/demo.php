<?php
	require('../config.php');
	// php code 
	$errors_cat = array();
	$fesit_cat=array();
	$row_cat =array();
	$msg_cat = array();
	if(isset($_GET['id_cat'])){
		$id_cat = $_GET['id_cat'];
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


    <div class="container">
		<div class="row">
		<div class="col-lg-12">
			<ol class="breadcrumb">
			<p><?= breadcrumbs() ?></p>
			</ol>
		</div>
		<?php if(isset($_GET['id_cat'])){ ?>
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
						<?php	// Đưa ra thông báo khi không thêm được người dùng mới
							if(count($errors_cat) > 0){ ?>
									<div class="alert alert-danger fade in">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<center><strong><?php echo "Không thể thêm! Dữ liệu đã nhập" ?></strong></center>
										</div>	
							<?php
							}
							?>
						<?php	//Đưa ra thông báo khi thêm người dùng mới thành công
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
					<div class="table-responsive"> <!-- Xuất dữ liệu người dùng mới đã thêm vào -->
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
		
		
		
    </div>
	</div>

</html>

<?php require('layout/footer.php'); ?>