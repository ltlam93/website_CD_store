<?php
	require('../config.php');
	$stt=1;
	$errors = array();
	$msg = array();
	$sql = "SELECT * FROM cdkind";
	$result = mysql_query($sql);
	//kiem tra thêm người dùng mới
	if(isset($_POST['add_submit'])){
		$add_cd_name   = $_POST['add_cd_name'];
		$add_cd_code   = $_POST['add_cd_code'];
        $add_id_kind   = $_POST['add_id_kind'];
        $add_desc  	   = $_POST['add_desc'];
		$add_singer    = $_POST['add_singer'];
		$add_price     = $_POST['add_price'];
		$add_quant     = $_POST['add_quant'];
		//checking dữ liệu nhập vào ở form
		if(isset($_POST['add_submit'])){

			if(empty($_POST['add_cd_name']))
				$errors[] = 'Hãy nhập tên đĩa CD !';
				
			if(!empty($_POST['add_cd_name']) && strlen($_POST['add_cd_name']) <6 )
				$errors[] = 'Tên sản phẩm tối thiểu 6 ký tự !';
				
			if(empty($_POST['add_cd_code']))
				$errors[] = 'Hãy nhập mã cho sản phẩm CD !';

			if(!empty($_POST['add_cd_code']) && strlen($_POST['add_cd_code']) <3 )
				$errors[] = 'Mã sản phẩm có tối thiểu 3 ký tự !';	
				
			if(empty($_POST['add_id_kind']))
				$errors[] = 'Hãy chọn loại đĩa CD !';

			if(empty($_POST['add_desc']))
				$errors[] = 'Hãy viết mô tả cho sản phẩm';

			if(empty($_POST['add_singer']))
				$errors[] = 'Hãy nhập tên ca sỹ !';

			if(empty($_POST['add_price']))
				$errors[] = 'Hãy nhập giá bán của sản phẩm !';

			if(empty($_POST['add_quant']))
				$errors[] = 'Hãy nhập số lượng của sản phẩm !';

			if(!empty($_POST['add_price']) && $_POST['add_price'] < 10000)
				$errors[] = 'Giá sản phẩm tối thiểu là 10000 VNĐ .';

			if(!empty($_POST['add_quant']) && $_POST['add_quant'] < 1)
				$errors[] = 'Số lượng tối thiểu là 1.';
		
		// kiem tra sản phẩm đã có chưa
		if(count($errors) == 0){
			$check_cd= mysql_query("select cd_code from cdinfo where cd_code = '$add_cd_code'");
			$check_cd=mysql_num_rows($check_cd);
			echo $check_cd;
			//kiem tra mã sản phẩm
			if($check_cd != 0){
				$errors[] = " Mã Sản phẩm " .$add_cd_code." đã có trong kho";
			} else {
				$result_id_kind = mysql_query("SELECT * FROM cdkind WHERE name_kind='$add_id_kind'");
				 // lay ra ID cua loai san pham
				$row = mysql_fetch_array($result_id_kind);
				
				$row1 = mysql_fetch_row($result_id_kind); 
				if(count($errors) == 0){
					$id_cat =$row['id_kind'];
					$query = mysql_query("INSERT INTO cdinfo (id_kind,cd_code,name_cd,description,singer,price,quantityinstock) VALUES ('$id_cat','$add_cd_code','$add_cd_name','$add_desc','$add_singer','$add_price','$add_quant')");
					//$msg[] = "Đã thêm thành công sản phẩm mới! <br>Sản phẩm: <b>" .$add_cd_name."</b><br>  Mã sản phẩm :<b> " .$_POST['add_cd_code']. "</b> Thuộc loại:<b> " .$_POST['add_id_kind']. "</b> Ca sỹ :<b> " .$_POST['add_singer']. "</b> Giá bán :<b> " .$_POST['add_price']. "</b> Số lượng :<b> " .$_POST['add_quant']. "</b>";
					$msg[]="Đã thêm thành công sản phẩm mới!";
				} else {
					$errors[] = ' Lỗi không thể thêm sản phẩm';
				}

			}
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
                <p>
                    <?=breadcrumbs() ?>
                </p>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <center>Thêm sản phẩm mới</center>
                        </h2>
                    </div>

                    <div class="panel-body">
                        <form id="add_product" action="" method="post">
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>Tên Đĩa CD</label>
                                        <input name="add_cd_name" type="text" class="form-control" placeholder="Tên Đĩa CD">
                                    </div>
                                    <div class="form-group">
                                        <label>Mã Đĩa CD</label>
                                        <input name="add_cd_code" type="text" class="form-control" placeholder="Mã sản phẩm CD">
                                    </div>
                                    <div class="form-group">
                                        <label>Ca sỹ</label>
                                        <input name="add_singer" type="text" class="form-control" placeholder="Tên ca sỹ">
                                    </div>
                                    <div class="form-group">
                                        <label>Phân loại CD</label>
                                        <select name="add_id_kind" class="form-control input-lg">
                                            <?php while($rows=mysql_fetch_array($result)) //xuất dữ liệu ra bảng 
											{ echo "<option>"; echo $rows[ 'name_kind']; echo "</option>"; } 
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mô tả sản phẩm</label>
                                        <textarea name="add_desc" type="text" class="form-control" rows="5" placeholder="Giới thiệu và sản phẩm"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Giá bán</label>
                                        <input name="add_price" type="number" class="form-control" placeholder="Giá bán của sản phẩm (VNĐ)">
                                    </div>
                                    <div class="form-group">
                                        <label>Số lượng trong kho</label>
                                        <input name="add_quant" type="number" class="form-control" placeholder="Số lượng sản phẩm hiện có">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <center>
                                        <button name="add_submit" type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                                        <button type="reset" class="btn btn-danger">Xóa dữ liệu</button>
                                    </center>
                                </div>
                            </div>
						</form>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <center>Thông tin sản phẩm đã thêm vào</center>
                        </h2>
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
                        <div class="table-responsive">
                            <!-- Xuất dữ liệu sản phẩm mới đã thêm vào -->
                            <table class="table table-bordered table-hover table-striped tablesorter">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Sản phẩm:</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_cd_name; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Mã sản phẩm</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_cd_code; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Loại sản phẩm</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_id_kind; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Ca sỹ</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_singer; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Giá bán</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_price; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>SL kho</td>
                                        <td>
                                            <?php if(isset($_POST[ 'add_submit'])) echo $add_quant; ?>
                                        </td>
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
                    </div>
                </div>
                <!-- div panel panel-primary -->
            </div>
            <!-- div col-lg-4 -->
            
        </div>
        <!-- div col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->

</html>


<?php require ('layout/footer.php'); ?>