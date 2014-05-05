<?php
	require('config-home.php');
	if(isset($_GET['item'])){
		$item = $_GET['item'];
		$sql = $mysqli->query("select * from cd_show WHERE name like '%$item%'");
	}
	if(isset($_POST['search'])){
		$item = $_POST['search'];
		header('Location:search.php?item='.$item);
	}
?>

<?php 
	require('header.php');
 ?>
<body class="top">
		
		<div class="main-body-color-mask"></div>
		<div class="lightbox"></div>

		<!-- BEGIN .quick-shop -->
		
		</div>
		
		<!-- BEGIN .main-body-wrapper -->
		<div class="main-body-wrapper">
			
			<!-- BEGIN .main-header -->
			<?php include('menu.php');?>
			
			<!-- BEGIN .main-navigation -->
			<section class="main-navigation clearfix">
				<nav>
					<div class="navigation">
						<a href="index.php">Trang chủ</a>
						<a href="search.php">Tìm kiếm</a>
					</div>
					<div class="title">
					<?php if(isset($_GET['item'])){
						echo '<h4>Kết quả tìm kiếm cho từ khóa "'.$item.'"</h4>';
					}?>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .catalog -->
				<section class="catalog">
				
					
					<div class="items clearfix">
					<?php if(isset($_GET['item'])){
						 $count=0;
						 while($obj= $sql->fetch_object()){ ?>
						<div class="item-block-1">
							<div class="image-wrapper">
								<div class="image">
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $obj->description ?></p>
												<a href="item.php?id=<?php echo $obj->id?>" class="quickshop1 ">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="item.php?id=<?php echo $obj->id?>"><img src="images/photos/image-<?php echo $obj->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $obj->id?>"><?php echo $obj->name?></a></h2>
							<p class="price"><?php echo $obj->price?> VNĐ</p>
						</div>
						
						<?php $count = $count +1;
						} ?>

						<?php 
							if($count ==0){ //Neu khong co item nao duoc tim thay thi hien thi loi canh bao vao form search
								echo '<section class=" clearfix">';
								echo '<div><center>';
									echo'<form method="post">';
										echo'<h5>Xin lỗi, từ khóa bạn tìm không có kết quả, hãy thử tìm với từ khóa khác</h5><br>';
										echo '<button>Tìm kiếm</button>';
										echo '<input  name="search" type="text" placeholder="Nhập từ khóa cần tìm"  />';
								echo '</form></center>';
								echo '</div>';
						echo '</section>';
							}
						} else {?>
						<section class=" clearfix"> <!-- form tim kiem --->
								<div><center>
									<form method="post">
										<h3>Tìm kiếm</h3>
										<button>Tìm kiếm</button>
										<input  name="search" type="text" placeholder="Nhập từ khóa cần tìm"  />
								</form></center>
								</div>
						</section>
					<?php }?>	
						
						
					</div>

				<!-- END .catalog -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
			


<?php 
	require('footer.php');
 ?>