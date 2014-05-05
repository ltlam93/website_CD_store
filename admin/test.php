<?php
	require('../config.php');
	$sql = "SELECT * FROM cd_show ";
	$result = mysql_query($sql);
	$stt=1;
?>

<?php //import file header , function va menu
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
		<div class="row">
			<div class="col-lg-12">
				
					<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped tablesorter" id="dynamic-table">
						<thead>
							<tr>
							<th><center>STT  <i class="fa fa-sort"></center></th>
							<th><center>Mã CD  <i class="fa fa-sort"><c/enter></th>
							<th><center>Tên CD  <i class="fa fa-sort"></center></th>
							<th><center>Mô tả  <i class="fa fa-sort"></center></th>
							<th><center>Phân loại  <i class="fa fa-sort"></center></th>
							<th><center>Ca sĩ  <i class="fa fa-sort"></center></th>
							<th><center>SL  <i class="fa fa-sort"></center></th>
							<th><center>Giá  <i class="fa fa-sort"></center></th>
							<th><center>Tùy chọn  <i class="fa fa-sort"></center></th>
							</tr>
						</thead>
						<tbody>
						<?php
						while($rows = mysql_fetch_array($result)) //xuất dữ liệu ra bảng
						{
							echo "<tr>";
							echo "<td><center>" . $stt . "</center></td>";
							echo "<td><center>" . $rows['code'] . "</center></td>";
							echo "<td>" . $rows['name'] . "</td>";
							echo "<td>" . $rows['description'] . "</td>";
							echo "<td>" . $rows['category'] . "</td>";
							echo "<td>" . $rows['singer'] . "</td>";
							echo "<td>" . $rows['quantityinstock'] . "</td>";
							echo "<td>" . ($rows['price']/1000) . "k</td>";
							echo "<td><center><a name=\"edit_info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sửa thông tin sản phẩm\" type=\"summit\" class=\"btn btn-primary btn-xs\" href=\"/demo/admin/edit.php?product=".$rows['id']."\">Sửa</a> 
								<a name=\"del_summit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Xóa sản phẩm này\" type=\"summit\" class=\"btn btn-danger btn-xs\" href=\"/demo/admin/delete.php?product=".$rows['id']."\">Xóa</button>
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
</html>
<script src="plugins/data-tables/jquery.dataTables.js"></script> 
<script src="plugins/data-tables/dynamic_table_init.js"></script>		
<?php
	require ('layout/footer.php');	
?>



	