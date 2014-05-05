<?php
	require('config-home.php');
	$sql_all = $mysqli->query("SELECT * FROM cd_show where sale >0"); //mac dinh hien thi tat ca item
	$sql_cat_filter =  $mysqli->query("select * from cdkind"); //hien thi list cac loai dia CD trong filter
	if(isset($_POST['filter'])){
		$name_cat = $_POST['filter'];
		if($name_cat =="Tất Cả"){ //kiem tra neu filter la "Tất cả" thì hiện thi tất cả tiem
			$sql_cat = $mysqli->query("select * from cd_show where sale > 0");
		}
		else{ // nguoc lai thi hien thi theo category
		$sql_cat = $mysqli->query("select * from cd_show WHERE category ='$name_cat' and sale >0");
		}
	}
?>

<?php 
	require('header.php');
 ?>
<body class="top">
		
		<div class="main-body-color-mask"></div>
		<div class="lightbox"></div>
		
		</div>
		
		<!-- BEGIN .main-body-wrapper -->
		<div class="main-body-wrapper">
			
			<!-- BEGIN .main-header -->
			<?php include('menu.php');?>
			
			<!-- BEGIN .main-navigation -->
			<section class="main-navigation clearfix">
				<nav>
					<div class="navigation">
						<a href="#">Home</a>
						<a href="#">Vies</a>
					</div>
					<div class="title">
						<h4>Sản phẩm giảm giá</h4>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .catalog -->
				<section class="catalog">
				
					<div class="sorting clearfix">
						<form name="myform" method="post" onChange="javascript:document.myform.submit();">
							<label>Chọn theo:</label>
							<select name="filter">
								<option>Filter</option>
								<option>Tất Cả</option>
								<?php  // hien thi ten cac loai CD
								while($obj_cat= $sql_cat_filter->fetch_object()){ ?>
									<option><?php echo $obj_cat->name_kind?></option>
								<?php }?>
							</select>
						</form>
						<div class="tags">
							<label>Tags:</label>
							<a href="#" class="active">all</a>
							<a href="#">elasticated</a>
							<a href="#">hem</a>
							<a href="#">summer</a>
						</div>
					</div>
					
					<!-- hien thi item -->
					<div class="items clearfix">
					<?php if(isset($_POST['filter'])){ //chekc dieu kien neu chon filter -> hien ra ca cd theo category ca chon filter
						 while($obj_cat= $sql_cat->fetch_object()){ ?>
						<div class="item-block-1">
						<span class="tag-sale"></span>
							<div class="image-wrapper">
								<div class="image">
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $obj_cat->description ?></p>
												<a href="item.php?id=<?php echo $obj_cat->id?>" class="quickshop1 ">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="item.php?id=<?php echo $obj_cat->id?>"><img src="images/photos/image-<?php echo $obj_cat->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $obj_cat->id?>"><?php echo $obj_cat->name?></a></h2>
							<p class="price"><?php echo $obj_cat->price?> VNĐ</p>
						</div>
						
						<?php }
						} else { // Mac dinh views.php hien thi tat ca cac item dang co
						while($obj_all= $sql_all->fetch_object()){ ?>
						<div class="item-block-1">
						<?php 
						if($obj_all->sale >0){
						echo' <span class="tag-sale"></span>';
						}?>
							<div class="image-wrapper">
								<div class="image">
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $obj_all->description ?></p>
												<a href="item.php?id=<?php echo $obj_all->id?>" class="quickshop1 ">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="item.php?id=<?php echo $obj_all->id?>"><img src="images/photos/image-<?php echo $obj_all->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $obj_all->id?>"><?php echo $obj_all->name?></a></h2>
							<?php 
							if($obj_all->sale >0){
								echo '<p class="price">'.(($obj_all->price * (100- $obj_all->sale))/100).' VNĐ <s>'.$obj_all->price.' VNĐ</s></p>';
							} else {
							 echo '<p class="price">'.$obj_all->price.' VNĐ</p>';
							} ?>
						</div>
						
						<?php }
						}?>
						
						
						
					</div>

				<!-- END .catalog -->
				</section>

			<!-- END .main-content-wrapper -->
			</section>
			


<?php 
	require('footer.php');
 ?>