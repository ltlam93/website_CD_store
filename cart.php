<?php 
	require('header.php');
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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
			<!-- BEGIN .main-navigation -->
			<section class="main-navigation clearfix">
				<nav>
					<div class="navigation">
						<a href="#">Home</a>
					</div>
					<div class="title">
						<h4>Shopping cart</h4>
					</div>
				</nav>
			<!-- END .main-navigation -->
			</section>
			
			<!-- BEGIN .main-content-wrapper -->
			<section class="main-content-wrapper main-item-wrapper clearfix">
			
				<!-- BEGIN .main-cart -->
				<div class="main-cart">
				
					<div class="titles clearfix">
						<p class="product">Tên Sản phẩm</p>
						<p class="quantity">Số lượng</p>
						<p class="price">Giá</p>
					</div>
					
					<?php if(isset($_SESSION["products"])) // hien thi thong tin item da dua vao gio hang va tinh tong tien
					{
						$total = 0;
						foreach ($_SESSION["products"] as $cart_item){ 
					echo '<form method="post">';
					
						echo'<div class="row clearfix">';
							echo'<div class="item-block-1">';
								if($cart_item["sale"] > 0) {
								echo'<span class="tag-sale"></span>';
								}
								echo'<div class="image-wrapper">';
									echo'<div class="image">';
										echo'<div class="overlay">';
											echo'<div class="position">';
												echo'<div>';
													echo'<a href="item.php?id='.$cart_item["id"].'" class="view">Xem chi tiết</a>';
												echo'</div>';
											echo'</div>';
										echo'</div>';
										echo'<a href="item.php?id='.$cart_item["id"].'"><img src="images/photos/image-'.$cart_item["id"].'.jpg" style="margin: -10px 0 0 0;" alt="" /></a>';
									echo'</div>';
								echo'</div>';
							echo'</div>';
							echo'<div class="product">';
								echo'<h4><a href="item.php?id='.$cart_item["id"].'">'.$cart_item["name"].'</a></h4>';
							echo'</div>';
							echo'<div class="quantity">';
								echo'<input type="text" value="'.$cart_item["quantity"].'" />';
								echo'<button class="more"></button>';
								echo'<button class="less"></button>';
							echo'</div>';
							echo'<div class="price">';
								echo''.$cart_item["price"].' VNĐ';
							echo'</div>';
							echo'<div class="delete">';
								echo'<a href="cart_update.php?removep='.$cart_item["id"].'&return_url='.$current_url.'">&times;</a>';
							echo'</div>';
						echo'</div>';
						
						$subtotal = ($cart_item["price"]*$cart_item["quantity"]); // tinh tong tien cua tung san pham
						$total = ($total + $subtotal); // tinh tong gia tien cua tat ca san pham
						}
						
						echo '<div class="row clearfix">';
							echo '<div class="note">';
								echo '<label>Ghi chú (tùy chọn):</label>';
								echo '<textarea></textarea>';
							echo '</div>';
							echo '<div class="total">';
								echo '<label>Tổng tiền thanh toán:</label>';
								echo '<p>' .$total.'VNĐ</p>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row clearfix">';
							echo '<div class="buttons">';
								echo '<button class="checkout"><a href="payment.php">Tiến hành thanh toán</a></button>';
								echo '<button class="update"><a href="">Cập nhật</a></button>';
								echo '<button class="delete" ><a class="buttons" href="cart_update.php?emptycart=1&return_url='.$current_url.'">Xóa giỏ hàng</a></button>';
								echo '<a href="#"><img src="images/button-paypal-1.png" alt="" class="paypal" /></a>';
							echo '</div>';
						echo '</div>';
						
					echo '</form>';
					}else{
						echo '<h3><center>Giỏ hàng trống</center><h3>';
						}
					?>
					
				<!-- END .main-cart -->
				</div>

			<!-- END .main-content-wrapper -->
			</section>
<?php 
	require('footer.php');
 ?>