<?php
	require('config-home.php');
	$sql = $mysqli->query("SELECT * FROM cd_show  where sale = 0 ORDER BY price DESC LIMIT 8");
	$sql_sale = $mysqli->query("SELECT * FROM cd_show where sale > 0 ORDER BY sale DESC LIMIT 4");
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
			
			<!-- BEGIN .main-slider -->
			<section class="main-slider">
			
				<div class="paging">
					<a href="#" class="previous"></a>
					<a href="#" class="next"></a>
				</div>
				
				<nav>
					<span id="pager">
					<a href="#">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					</span>
				</nav>
				
				<div id="hompage-slider_content">
					
					<!-- BEGIN .item -->
					<div class="item" style="background-image: url(images/slide/slider-1.jpg);">
						<div class="title-wrapper clearfix">
							<div class="title">
								<p class="clearfix"><a href="#" class="headline">Little details make a big difference</a></p>
								<p class="clearfix"><a href="#" class="intro">The important thing is not to stop questioning. Curiosity has its own reason for existing. -Albert Einstein </a></p>
							</div>
						</div>
						<img src="images/blank.png" alt="" />
					<!-- END .item -->
					</div>
					
					<!-- BEGIN .item -->
					<div class="item" style="background-image: url(images/slide/slider-2.jpg);">
						<div class="title-wrapper clearfix">
							<div class="title">
								<p class="clearfix"><a href="#" class="headline">Pandora gives you more</a></p>
								<p class="clearfix"><a href="#" class="intro">All the great things are simple, and many can be expressed in a single word: freedom, justice, honor, duty, mercy, hope. -Winston Churchill </a></p>
							</div>
						</div>
						<img src="images/blank.png" alt="" />
					<!-- END .item -->
					</div>
					
					<!-- BEGIN .item -->
					<div class="item" style="background-image: url(images/slide/slider-3.jpg);">
						<div class="title-wrapper clearfix">
							<div class="title">
								<p class="clearfix"><a href="#" class="headline">Looking cool</a></p>
								<p class="clearfix"><a href="#" class="intro">I now not with what weapons World War III will be fought, but World War IV will be fought with sticks and stones. -Albert Einstein </a></p>
							</div>
						</div>
						<img src="images/blank.png" alt="" />
					<!-- END .item -->
					</div>
					
					<!-- BEGIN .item -->
					<div class="item" style="background-image: url(images/slide/slider-4.jpg);">
						<div class="title-wrapper clearfix">
							<div class="title">
								<p class="clearfix"><a href="#" class="headline">Leave a lasting impression on your customers</a></p>
								<p class="clearfix"><a href="#" class="intro">As far as the laws of mathematics refer to reality, they are not certain, as far as they are certain, they do not refer to reality.  -Albert Einstein </a></p>
							</div>
						</div>
						<img src="images/blank.png" alt="" />
					<!-- END .item -->
					</div>
					
				</div>
				
			<!-- END .main-slider -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper clearfix">
				
				<!-- BEGIN .welcome-message-1 -->
				<div class="welcome-message-1">
					<h2>Chào mừng tới <span>CD STORE</span></h2>
					<p><b>Chất lượng && Dịch vụ chuyên nghiệp</b></p>
					<p><b>CD STORE</b> là hệ thống bán lẻ địa CD Chất lượng cao. Với mong muốn mang đến cho những người thưởn thức âm nhạc những bản nhạc mới nhất và hót nhất, luôn được cập nhật từng ngày từng giờ. Chúng tôi hy vong chất lượng ở <strong>CD STORE</strong> sẽ làm hài lòng quý khách.</p>
				<!-- END .welcome-message-1 -->
				</div>
				
								
				
				<!-- BEGIN .San pham giam gia -->
				<div class="featured-items clearfix">
					
					<div class="main-title clearfix">
						<p>Sản phẩm giảm giá</p>
						<a href="sale.php" class="view">Xem tất cả sản phẩm</a>
					</div>
					
					<div class="items clearfix">
						<?php 
						while($obj_sale= $sql_sale->fetch_object()){ ?>
						<div class="item-block-1">
							<span class="tag-sale"></span>
							<div class="image-wrapper">
								<div class="image">
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $obj_sale->description?></p>
												<a href="item.php?id=<?php echo $obj_sale->id?>" class="quickshop1">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="item.php?id=<?php echo $obj_sale->id?>"><img src="images/photos/image-<?php echo $obj_sale->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $obj_sale->id?>"><?php echo $obj_sale->name?></a></h2>
							<h6><center><?php echo $obj_sale->singer?></center></h6><br>
							<p class="price"><?php echo (($obj_sale->price * (100- $obj_sale->sale))/100)?> VNĐ <s><?php echo $obj_sale->price?> VNĐ</s></p>
						</div>
						<?php }?>
						
						
					</div>

				<!-- END .San pham giam gia -->
				</div>
				
				<!-- BEGIN .featured-items -->
				<div class="featured-items clearfix">
					
					<div class="main-title clearfix">
						<p>Sản phẩm mới</p>
						<a href="views.php" class="view">Xem tất cả sản phẩm</a>
					</div>
					
					<div class="items clearfix">
						<?php 
						while($obj= $sql->fetch_object()){ ?>
						<div class="item-block-1">
							<div class="image-wrapper">
								<div class="image">
									<div class="overlay">
										<div class="position">
											<div>
												<p><?php echo $obj->description?></p>
												<a href="item.php?id=<?php echo $obj->id?>" class="quickshop1">Quick shop</a>
											</div>
										</div>
									</div>
									<a href="item.php?id=<?php echo $obj->id?>"><img src="images/photos/image-<?php echo $obj->id?>.jpg" style="margin: -27.5px 0 0 0;" alt="" /></a>
								</div>
							</div>
							<h2><a href="item.php?id=<?php echo $obj->id?>"><?php echo $obj->name?></a></h2>
							<h6><center><?php echo $obj->singer?></center></h6><br>
							<p class="price"><?php echo $obj->price?> VNĐ</p>
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
				
				<!-- BEGIN .homepage-columns -->
				<div class="homepage-columns clearfix">
					
					<div class="blog">
					
						<div class="main-title clearfix">
							<p>Latest from news blog</p>
						</div>
						
						<div class="items">
						
							<div class="item">
								<h2><a href="#">Praesent feugiat felis congue nulla dapibus</a></h2>
								<div class="title-details">
									<a href="#" class="time">May 23, 2012</a>
									<a href="#" class="comments">6</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vitae nibh risus. Morbi dapibus lectus at erat viverra malesuada. Phasellus congue nulla. <a href="#" class="more-link">Read more <b>+</b></a></p>
							</div>
							
							<div class="item">
								<h2><a href="#">Aliquam feugiat imperdiet orcinon mattis</a></h2>
								<div class="title-details">
									<a href="#" class="time">May 15, 2012</a>
									<a href="#" class="comments">12</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rutrum risus vitae aliquet libero volutpat. Integer viverra tempus dolor condimentum euismod leo feugiat. <a href="#" class="more-link">Read more <b>+</b></a></p>
							</div>
							
							<div class="item">
								<h2><a href="#">Consectetur adipiscing etiamts adipiscing</a></h2>
								<div class="title-details">
									<a href="#" class="time">May 11, 2012</a>
									<a href="#" class="comments">0</a>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vitae nibh risus. Morbi malesuada. Phasellus congue nulla eu turpis. Nam risus ligula. <a href="#" class="more-link">Read more <b>+</b></a></p>
							</div>
							
						</div>
						
					</div>
					
					<!-- BEGIN .best-sellers -->
					<div class="best-sellers">
					
						<div class="main-title clearfix">
							<p>CD Bán chạy</p>
						</div>
						
						<div class="items">
						
							<div class="item-block-1">
								<span class="tag-sale"></span>
								<div class="image-wrapper">
									<div class="image">
										<div class="overlay">
											<div class="position">
												<div>
													<a href="item.php?id=10" class="view">Xem thêm</a>
												</div>
											</div>
										</div>
										<a href="#"><img src="images/photos/photo-10.jpg" style="margin: -10px 0 0 0;" alt="" /></a>
									</div>
								</div>
								<p class="price">90k VNĐ</p>
							</div>
						
							<div class="item-block-1">
								<div class="image-wrapper">
									<div class="image">
										<div class="overlay">
											<div class="position">
												<div>
													<a href="item.php?id=17" class="view">Xem thêm</a>
												</div>
											</div>
										</div>
										<a href="#"><img src="images/photos/photo-17.jpg" style="margin: -30px 0 0 0;" alt="" /></a>
									</div>
								</div>
								<p class="price">50k VNĐ</p>
							</div>
							
							<div class="item-block-1">
								<div class="image-wrapper">
									<div class="image">
										<div class="overlay">
											<div class="position">
												<div>
													<a href="item.php?id=5" class="view">Xem thêm</a>
												</div>
											</div>
										</div>
										<a href="#"><img src="images/photos/photo-5.jpg" style="margin: -30px 0 0 0;" alt="" /></a>
									</div>
								</div>
								<p class="price">100k VNĐ</p>
							</div>
							
							<div class="item-block-1">
								<div class="image-wrapper">
									<div class="image">
										<div class="overlay">
											<div class="position">
												<div>
													<a href="item.php?id=22" class="view">Xem thêm</a>
												</div>
											</div>
										</div>
										<a href="#"><img src="images/photos/photo-22.jpg" style="margin: -10px 0 0 0;" alt="" /></a>
									</div>
								</div>
								<p class="price">80k VNĐ</p>
							</div>
						
						</div>
					
					<!-- END .best-sellers -->	
					</div>
					
					<!-- BEGIN .about-us -->
					<div class="about-us">
					
						<div class="main-title clearfix">
							<p>Thông tin liên hệ</p>
						</div>
						
						<p>Mecenas quis porta in, condimentum  eget arcu. Fringilla aliquam ultricies pellente sque vel turpis nec leo tincidunt sollicitudin ac non risus. Ves tibu lum ultrices feugiat velit, quis tincidunt velit volutpat nec. Vivamus pharetra fringilla augue, elementum ante ultrices tincidunt. Aenean consequat tincidunt.</p>
						<p>Quisque scelerisque augue eu turpis condimentum iaculis. Cras adipiscing lobortis convallis. Nam eu augue lorem.</p>
						<a href="#" class="phone">(84)-963-012-472</a>
						<a href="#" class="email">support@cdstore.com</a>
					
					<!-- END .about-us -->	
					</div>
					
				<!-- END .homepage-columns -->
				</div>
				
			<!-- END .main-content-wrapper -->
			</section>
	
	
<?php 
	require('footer.php');
 ?>