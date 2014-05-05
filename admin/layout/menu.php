<?php 
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("cd");
	if(isset($_POST['user'])){
		$username = $_POST['user'];
		header('Location:search.php?all='.$username);
	}
	
?>
<head>
	<link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
</head>

<body>
	
    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../index.php">STORE Admin Panel</a>
        </div>
	<!-- Menu -->
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gift"></i> Sản phẩm CD<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add_product.php">Thêm mới CD</a></li>
                <li><a href="view_products.php">Xem tất cả CD</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-briefcase"></i> CD Category<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add_categories.php">Thêm mới</a></li>
                <li><a href="view_categories.php">Xem các loại CD</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Khách hàng<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add_customer.php">Thêm mới người dùng</a></li>
                <li><a href="view_customers.php">Xem tất cả USER</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-eye-slash"></i> Bài viết<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Viết bài mới</a></li>
                <li><a href="#">Tất cả bài đăng</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a href="payments.php" ><i class="fa fa-dollar"></i> Quản lý Giao dịch </a>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
			
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Sản phẩm <b class="caret"></b></a>
			<ul class="dropdown-menu">
                <li><a href="add_product.php">Thêm mới</a></li>
				<li class="divider"></li>
                <li><a href="view_products.php">Xem các loại CD</a></li>
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Khách hàng <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add_customer.php">Thêm mới</a></li>
				<li class="divider"></li>
                <li><a href="view_customers.php">Xem tất cả</a></li>
              </ul>
            </li>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
			  <?php
				if(!empty($_SESSION['username'])){
					echo $_SESSION['username'];
				}?>
				<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="edit_customer.php"><i class="fa fa-user"></i> Sửa hồ sơ</a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="../logout.php"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
              </ul>
            </li>
          </ul>
			<form class="navbar-form navbar-right" method="post" action="">
				<input name="user" type="summit" class="form-control" placeholder="Tìm kiếm product,user">
			</form>
        </div><!-- /.navbar-collapse -->
      </nav>