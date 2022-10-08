<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="nội thất, bàn ăn, đồ gỗ, nam linh">
    <meta name="description" content="Đồ Gỗ Nam Linh tự hào là cơ sở uy tín số 1 chuyên sản xuất, bán buôn, lẻ các sản phẩm đồ gỗ:... Liên Hà, Đông Anh, Hanoi, Vietnam 100000.">
    <title>Đồ Gỗ Nam Linh</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/core-style.css">
</head>
<body>
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form id="search_form">
                            <input type="search" name="search" id="search" value="" placeholder="Nhập từ khóa tìm kiếm...">
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content-wrapper d-flex clearfix">
        <div class="mobile-nav">
            <div class="amado-navbar-brand">
                <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>
        <header class="header-area clearfix">
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <div class="logo">
                <a href="index.php"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <nav class="amado-nav">
                <ul>
                    <li class="active"><a href="index.php">Trang Chủ</a></li>
                    <li><a href="cart.php">Giỏ Hàng</a></li>
                    <li><a href="#">Liên Hệ</a></li>
                </ul>
            </nav>
            <div class="amado-btn-group mt-30 mb-100">
                <a href="#" class="btn amado-btn mb-15">Khuyến mại</a>
                <a href="#" class="btn amado-btn active">Tin Tức</a>
            </div>
            <div class="cart-fav-search mb-100">
                <a href="cart.php" class="cart-nav"><img src="img/core-img/cart.png" alt=""> Giỏ hàng <span><?php if (isset($_SESSION['cart'])) {
                    echo "(" .count($_SESSION['cart']) . ")";
                }else{
                    echo "(0)";
                } ?></span></a>
                <a href="#" class="search-nav"><img src="img/core-img/search.png" alt=""> Tìm kiếm</a>
            </div>
            <div class="social-info d-flex justify-content-between">
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            </div>
        </header>
<?php include "./admin/includes/connect.php";?>