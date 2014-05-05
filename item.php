<?php
	require('config-home.php');
	
	//Hien thi thong tin nguoi dung tu search username
	if(isset($_GET['id'])){
		$id= $_GET['id'];
		$sql= $mysqli->query("SELECT * FROM cd_show WHERE id=$id"); //lay ra thong tin item
		$cat= $mysqli->query("SELECT * FROM cd_show WHERE id=$id"); //lay ra id cat cua item
		$cat = $cat->fetch_object();
		$cat_id = $cat->category_id;
		$release = $mysqli->query("SELECT * FROM cd_show WHERE category_id=$cat_id AND id <> '$id' ORDER BY RAND() LIMIT 0,4"); //lay ra random nhung item co cung id cat
	}
	// lay URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	
?>

<?php 
	require('header.php');
 ?>
	<!-- BEGIN body -->
<body class="top">
		
		<div class="main-body-color-mask"></div>
		<div class="lightbox"></div>

		<!-- BEGIN .quick-shop -->
		
		</div>
		
		<!-- BEGIN .main-body-wrapper -->
		<div class="main-body-wrapper">
			
			<!-- BEGIN .main-header -->
			<?php include('menu.php');?>
			
			<section class="main-navigation clearfix">
			
			<!-- END .main-navigation -->
			</section>
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper main-item-wrapper clearfix">
			
				<!-- BEGIN .main-item -->
				<?php 
						while($obj= $sql->fetch_object()){ ?> <!-- Hie nthi thong tin CD -->
				<section class="main-item clearfix">
				
					<div class="item-block-1">
						<div class="image-wrapper" id="_single-product-slider">
							<div class="image">
							<?php if($obj->sale > 0){
							echo '<span class="tag-sale"></span>';
							}?>
								<a href="item.php?id=<?php echo $obj->id?>" class="lightbox-launcher"><img src="images/photos/photo-<?php echo $obj->id?>.jpg" alt="" /></a>
							</div>
						</div>
					</div>
					<form method="post" action="cart_update.php">
					<div class="item-info">
						<h2><a href="#"><?php echo $obj->name?></a></h2>  <!--- hien thi ten cd--->
						<p class="item-text">
							<?php echo $obj->description?> <!--- hien thi desciption--->
						</p>
						<div class="details clearfix">
							
								<p class="item">
									<label>Thể loại:</label>
									<?php echo $obj->category?> <!--- hien thi the loai--->
								</p>
								<p class="item">
									<label>Ca sỹ :</label>
									<?php echo $obj->singer?> <!--- hien thi ten ca sy--->
								</p>
								<p class="item quantity">
									<label>Quantity:</label>
									<select name="product_qty">
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
									</select>
									
								</p>
								<p class="item">
									<label>Share this item:</label>
									<span class="social-icons clearfix">
										<span class='st_facebook_custom facebook'></span>
										<span class='st_twitter_custom twitter'></span>
										<span class='st_linkedin_custom linkedin'></span>
										<span class='st_stumbleupon_custom stumbleupon'></span>
										<span class='st_blogger_custom blogspot'></span>
									</span>
									<a href="#" class="more st_sharethis_custom">more</a>
								</p>
							
						</div>
						<div class="price">
						<?php 
							if($obj->sale >0){ ?>
								<?php echo(($obj->price * (100- $obj->sale))/100);
								echo 'VNĐ';
								echo '<s>'.$obj->price.' VNĐ</s> ';
							} else {
								echo ''.$obj->price.' VNĐ' ;
							} ?> 
							
						</div>
						<div class="buy">
							<button name="buy_submit" type="submit">Thêm vào giỏ hàng</button>
							<input type="hidden" name="product_code" value="<?php echo $id;?>" /> <!-- lay ra id cua item de dua voa file cart_update.php -->
							<input type="hidden" name="return_url" value="<?php echo $current_url;?>" />
							<input type="hidden" name="sale" value="<?php echo $obj->sale;?>" />
						</div>
						
					</div>
					</form>
					
				<!-- END .main-item -->
				</section>
				<?php }?>

				<!-- BEGIN .featured-items -->
				<div class="featured-items clearfix">
					
					<div class="main-title clearfix">
						<p>Sản phẩm cùng loại</p>
						<a href="views.php?id=<?php echo $cat_id?>" class="view">Xem tất cả item</a>
					</div>
					
					<div class="items clearfix">
						<?php 
						while($rel= $release->fetch_object()){ ?> <!-- Hie nthi thong tin CD cung category -->
						<div class="item-block-1">
							<div class="image-wrapper">
								<div class="image">
								<?php if($rel->sale > 0){
									echo '<span class="tag-sale"></span>';
									}?>
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $rel->description?></p>
												<a href="item.php?id=<?php echo $rel->id?>" class="quickshop1">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="#"><img src="images/photos/image-<?php echo $rel->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $rel->id?>"><?php echo $rel->name?></a></h2>
							<p class="price"><?php echo $rel->price?> VNĐ</p>
						</div>
						<?php }?>
						
					</div>

				<!-- END .featured-items -->
				</div>
				
				<!-- BEGIN .special-offers -->
				<div class="special-offers clearfix">
					
					<div class="main-title clearfix">
						<p>Ưu đãi đặc biệt</p>
					</div>
					
					<a href="#" class="sale">
						<span class="title">Sale</span>
						<span class="description">Giảm giá tất cả các mặt hàng</span>
						<span class="background"></span>
					</a>
					
					<a href="#" class="percent-off">
						<span class="title">FREE</span>
						<span class="description">Miễn phí vận chuyển</span>
						<span class="background"></span>
					</a>
					
					<a href="#" class="specials">
						<span class="title">Mới</span>
						<span class="description">Luôn cập nhật những CD mới nhất</span>
						<span class="background"></span>
					</a>
				
				<!-- END .special-offers -->
				</div>

			<!-- END .main-content-wrapper -->
			</section>
<?php 
	require('footer.php');
 ?>