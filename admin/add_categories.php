<?php
	$errors = array();
	$msg = array();
	//kiem tra thêm người dùng mới
	if(isset($_POST['add_submit'])){
		require('../config.php');
		$add_categories   = mysql_real_escape_string($_POST['add_categories']);
		//checking dữ liệu nhập vào ở form
		if(empty($_POST['add_categories'])){
			$errors[] = 'Hãy nhập tên loại sản phẩm !';
		}
		if(!empty($_POST['add_categories']) && strlen($_POST['add_categories']) <6 )
				$errors[] = 'Mã sản phẩm có tối thiểu 6 ký tự !';	

		// Không có lỗi nhập form tiến hành thực thi SQL
		if(count($errors) == 0){
			$check_cat= mysql_query("SELECT name_kind FROM cdkind WHERE name_kind='$add_categories'");
			$check_cat=mysql_num_rows($check_cat);
			//kiem tra categories tồn tại chưa
			if($check_cat != 0){
				$errors[] = " Loại sản phẩm " .$add_categories." đã được sử dụng";
			}else
			{	//chen dữ liệu nhập từ form vào database
				mysql_query("INSERT INTO cdkind (name_kind) VALUES('$add_categories')");
				$msg[] = "Đã thêm loại sản phẩm mới thành công! <br>Loại sản phẩm: <b>" .$add_categories."</b>";
			}
		}
		}
	
	
?>

<?php //import file header , function va menu
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
				<div class="col-lg-4"></div>
				
              	<div class="col-lg-4 add-form">
					<div class="panel panel-primary">
					<div class="panel-heading">
					<h2 class="panel-title"><center>Thêm mới categories</center></h2>
					</div>
					<div class="panel-body">
                    <form id="add_categories" action="" method="post">
                        <div class="form-group">
  							<input name="add_categories" type="text" class="form-control input-lg" placeholder="Tên chủng loại CD">
						</div>
                        <br><center>
                            <button name="add_submit" type="submit" class="btn btn-primary">Thêm mới</button>
							<button type="reset" class="btn btn-danger">Xóa dữ liệu</button> 
							</center>
					</form>
					<br>
							<!-- Đưa ra thông báo -->
							<?php	
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
							<?php	
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
                     </div>
					</div>
            	</div>
				
				<div class="col-lg-4">
				
				</div>
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

</html>



<?php 
	require ('layout/footer.php'); 
?>