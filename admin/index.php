<?php
	require('../config.php');
	$stt=1;
	$total_user = mysql_fetch_array(mysql_query("SELECT * from total_user"));                 //query lay ra tong so khach hang
	$total_cd_sale = mysql_fetch_array(mysql_query("SELECT * from total_cd_sale"));           //query lay ra tong so san pham da ban
	$total_order_daily = mysql_fetch_array(mysql_query("select * from total_order_daily"));   //query lay ra tong so don hang da dat trong ngay
	$total_money = mysql_fetch_array(mysql_query("select * from total_money"));               //query lay ra tong so tien thu duoc
	$payments_last_10 = mysql_query("select * from payments_last_10");						  //query lay ra 10 khach hang thanh toan tien gan nhat
	$money_week_chart = mysql_query("SELECT * FROM view_money_week");
	function export_data($a){
		while($data = mysql_fetch_array($a)) //xuất dữ liệu ra bảng
		{
		echo "{ d: '" .$data[0]. "', Values: " .$data[1]." },<br>" ;
		}
	}
?>

<?php 
	require('layout/header.php');
	require('layout/menu.php'); 
	require('../functions.php');
?>

  <div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			
			<h3>Admin Panel <small>CD Product Store</small></h3>
			<ol class="breadcrumb">
			<p><?= breadcrumbs() ?></p>
			</ol>
		</div>
	</div>
    <div class="row">
        <div class="col-lg-12">
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Chào mừng tói trang quản trị <a class="alert-link" href="http://startbootstrap.com">Cửa hàng bán đĩa CD CLC</a>! Dưới đây là những thông số giúp bạn có cái nhìn tổng quát nhất về tình hình buôn bán của cửa hàng!
            </div>
         </div>
    </div><!-- /.row -->
		
	<div class="row">
		<!-- Hiện thị số khách hàng đã đăng ký -->
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-2">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="col-xs-10 text-right">
                    <p class="announcement-heading"><?php echo $total_user['totaluser'] ;?></p>
                    <p class="announcement-text">Khách hàng</p>
                  </div>
                </div>
              </div>
              <a href="view_customers.php">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Xem danh sách khách hàng
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right fa-3x"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
		  <!-- Hiện thị số sản phẩm đang bán -->
          <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-2">
                    <i class="fa fa-gift fa-5x"></i>
                  </div>
                  <div class="col-xs-10 text-right">
                    <p class="announcement-heading">
						<?php if (isset($total_cd_sale['total_cd_sale'])){
							echo $total_user['totaluser'] ;
							} else echo "0";
						?></p>
                    <p class="announcement-text">Sản phẩm đã bán</p>
                  </div>
                </div>
              </div>
              <a href="view_products.php">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Xem danh sách sản phẩm
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right fa-3x"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
		  <!-- Hiện thị số đơn hàng  -->
          <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-2">
                    <i class="fa fa-usd fa-5x"></i>
                  </div>
                  <div class="col-xs-10 text-right">
                    <p class="announcement-heading"> 
						<?php if (isset($total_order_daily['total_order_daily'])){
							echo $total_order_daily['total_order_daily'] ;
							} else echo "0";
						?></p>
                    <p class="announcement-text">Đơn hàng trong ngày</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Xem tất cả các đơn hàng
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right fa-3x"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
		</div>
		  <!-- Hiện thị tất cả số tiền thu được -->
          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-2">
                    <i class="fa fa-dollar fa-5x"></i>
                  </div>
                  <div class="col-xs-10 text-right">
                    <p class="announcement-heading">
						<?php if (isset($total_money['total_money'])){
							echo $total_money['total_money']/1000000 ;
							} else echo "0";
						?></p>
                    <p class="announcement-text">Triệu VNĐ</p>
                  </div>
                </div>
              </div>
              <a href="payments.php">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Xem đánh giá chi tiết
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right fa-3x"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
        </div>
		</div><!-- /.row -->
		
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
					<h3 class="panel-title"><center><i class="fa fa-bar-chart-o fa-lg"></i> Lượt mua hàng trong trong tuần</center></h3>
					</div>
					<div class="panel-body">
						<br><br>
						<div id="demo-1"></div>
						<br><br>
					</div>
				</div>
			</div>
				<div class="col-lg-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title"><center><i class="fa fa-money fa-lg"></i> Các giao dịch gần đây</center></h2>
						</div>
					<div class="panel-body">
					<div class="table-responsive"> <!-- Xuất dữ liệu người dùng mới đã thêm vào -->
						<table class="table table-bordered table-hover table-striped tablesorter">
						<thead>
							<tr>
								<th><center>STT  <i class="fa fa-sort"></center></th>
								<th><center>Khách hàng  <i class="fa fa-sort"></center></th>
								<th><center>Thời gian  <i class="fa fa-sort"></center></th>
								<th><center>Giá trị (VNĐ) <i class="fa fa-sort"></center></th>
							</tr>
						</thead>
						<tbody>
						<?php
							while($rows = mysql_fetch_array($payments_last_10)) //xuất dữ liệu ra bảng
							{
								echo "<tr>";
								echo "<td><center>" . $stt . "</center></td>";
								echo "<td>" . $rows['customer'] . "</td>";
								echo "<td>" . $rows['time'] . "</td>";
								echo "<td style =\"text-align:right;\">" . $rows['amount'] . "</td>";
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
		</div>  <!-- /#row -->
		<a href="#" data-toggle="tooltip" data-original-title="Default tooltip"> you probably</a>
		<?php export_data($money_week_chart);?>
		
      </div><!-- /#page-wrapper -->

<!-- Javascrip -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!--<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script> --->
<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
<script src="js/helper-plugins.js"></script> <!-- Plugins --> 
<script src="js/bootstrap.js"></script> <!-- UI --> 

<script src="js/init.js"></script> <!-- All Scripts --> 
<script type="text/javascript">
	Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'demo-1',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
	{ d: '2014-04-28', Values: 5526000 },
	{ d: '2014-04-27', Values: 20604000 },
	{ d: '2014-04-26', Values: 11531700 },
	{ d: '2014-04-25', Values: 12966700 },
	
  ],
  // The name of the data record attribute that contains x-visitss.
  xkey: 'd',
  // A list of names of data record attributes that contain y-visitss.
  ykeys: ['Values'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Sức mua'],
  // Disables line smoothing
});  
</script>
<?php require('/layout/footer.php'); ?>
