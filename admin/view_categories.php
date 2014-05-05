<?php
	require('../config.php');
	
	/*
		Place code to connect to your DB here.
	*/
	// include your code to connect to DB.

	$tbl_name="cdkind";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	$stt=1;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "view_categories.php"; 	//your file name  (the name of this file)
	$limit = 7;	//how many items to show per page
	$page = !empty($_GET['page']) ? $_GET['page'] : 1;
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination pagination-lg\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">&laquo; Trang trước</a>";
		else
			$pagination.= "<span class=\"disabled\">&laquo; Trang trước</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">Trang Sau &raquo;</a>";
		else
			$pagination.= "<span class=\"disabled\">Trang Sau &raquo;</span>";
		$pagination.= "</ul>\n";		
	}
	
	// add categories
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
				$msg[] = "Đã thêm loại sản phẩm mới thành công! <br>Loại sản phẩm: <strong>" .$add_categories."</strong>";
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
			<div class="col-lg-8">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center>Các loại CD đang bán</center></h2>
					</div>
				<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped tablesorter">
					<thead>
						<tr>
							<th><center>STT  <i class="fa fa-sort"></i><center></th>
							<th><center>ID Category  <i class="fa fa-sort"></i></center></th>
							<th><center>Chủng loại  <i class="fa fa-sort"></i></center></th>
							<th><center>Tùy chọn  <i class="fa fa-sort"></center></th>
						</tr>
					</thead>
					<tbody>
					<?php
						while($rows = mysql_fetch_array($result)) //xuất dữ liệu ra bảng
						{
							echo "<tr>";
							echo "<td><center>" . $stt. "</center></td>";
							echo "<td><center>" . $rows['id_kind'] . "</center></td>";
							echo "<td>" . $rows['name_kind'] . "</td>";
							echo "<td><center><a name=\"edit_info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sửa thông tin  loại sản phẩm\" type=\"summit\" class=\"btn btn-primary btn-xs\" href=\"/demo/admin/edit.php?cat=".$rows['id_kind']."\">Sửa</a> 
									<a name=\"del_summit\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Xóa  loại sản phẩm này\" type=\"summit\" class=\"btn btn-danger btn-xs\" href=\"/demo/admin/delete.php?cat=".$rows['id_kind']."\">Xóa</button>
									</center></td>";
							echo "</tr>";
							$stt=$stt+1;
	
						}
						?>
					</tbody>
					</table>
				</div>
				<center><?=$pagination?> </center>
				</div>
			</div>
			</div>
			
			<!-- add categories -->
			
			<div class="col-lg-4 add-form">
					<div class="panel panel-primary">
					<div class="panel-heading">
					<h2 class="panel-title"><center>Thêm mới categories</center></h2>
					</div>
					<div class="panel-body">
						<div class="alert alert-success fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<center>Hãy nhập <strong>loại sản phẩm</strong> muốn thêm </center>
						</div>
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
										<center><?php echo $errors ?></center>
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
										<center><?php echo $msg ?></center>
										</div>	
							<?php	}
								unset($msg);
							}
							?>
                     </div>
					</div>
            	</div>
			
		</div>
		 <!-- hiển thị phân trang --->
		</div>
	</div>
</html>
<?php
	require ('layout/footer.php');	
?>

