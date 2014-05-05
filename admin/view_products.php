<?php
	require('../config.php');


	$tbl_name="cd_show       ";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	$stt=1;

	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "view_products.php"; 	//your file name  (the name of this file)
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
			$pagination.= "<a href=\"$targetpage?page=$next\">Trang sau &raquo;</a>";
		else
			$pagination.= "<span class=\"disabled\">Trang sau &raquo;</span>";
		$pagination.= "</ul>\n";		
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
					<center><?=$pagination?> </center>
				</div>
				</div>
			</div>
	
			</div>
	</div>
	</div>
</html>
		 <!-- hiển thị phân trang --->
<?php
	require ('layout/footer.php');	
?>



	