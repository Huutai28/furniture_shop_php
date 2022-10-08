<?php include "./pages/header_area.php"?>
<?php
if (isset($_GET['id'])) {
$result = mysqli_query($conn,"SELECT `id`, `name`, `price`, `img`, `information`, `category` FROM `products` WHERE `id`='{$_GET['id']}';");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $category = mysqli_query($conn, "SELECT `name`FROM `categories` WHERE `id` = '{$row['category']}';");
    $name_cate = mysqli_fetch_array($category);
}
}
?>
<div class="single-product-area section-padding-100 clearfix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-50">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo $name_cate['name'] ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $row['name'] ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="single_product_thumb">
                    <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(./<?php echo $row['img']?>);">
                            </li>

                            <?php
                            $library = mysqli_query($conn,"SELECT `id`, `path` FROM `image_library` WHERE `product` = '{$row['id']}';");
                            $slide = 0;
                            if (mysqli_num_rows($library) > 0) {
                                while ($library_row = mysqli_fetch_array($library)) {
                                $slide++;
                                    
                            ?>
                            <li data-target="#product_details_slider" data-slide-to="<?php echo $slide; ?>" style="background-image: url(./<?php echo $library_row['path']?>);">
                            </li>
                            <?php } } ?>
                        </ol>
                        <div class="carousel-inner" style="min-height: 680px;">
                            <div class="carousel-item active">
                                <a class="gallery_img" href="./<?php echo $row['img']?>">
                                    <img class="d-block w-100" src="./<?php echo $row['img']?>" alt="First slide">
                                </a>
                            </div>
                            <?php
                            $library2 = mysqli_query($conn,"SELECT `id`, `path` FROM `image_library` WHERE `product` = '{$row['id']}';");
                            if (mysqli_num_rows($library2) > 0) {
                                while ($library2_row = mysqli_fetch_array($library2)) {
                            ?>
                            <div class="carousel-item">
                                <a class="gallery_img" href="./<?php echo $library2_row['path']?>">
                                    <img class="d-block w-100" src="./<?php echo $library2_row['path']?>" alt="Second slide">
                                </a>
                            </div>
                            <?php } }?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="single_product_desc">

                    <div class="product-meta-data">
                        <div class="line"></div>
                        <p class="product-price">Giá <?php echo number_format($row['price'])?>₫</p>
                        <a href="product-details.html">
                            <h6><?php echo $row['name']?></h6>
                        </a>

                        <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                            <div class="ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="short_overview my-5">
                        <p><?php echo $row['information']?></p>
                    </div>
                    <form class="cart clearfix" action="cart.php?action=add" method="post">
                        <div class="cart-btn d-flex mb-50">
                            <p>Số lượng</p>
                            <div class="quantity">
                                <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity[<?php echo $row['id']?>]" value="1">
                                <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn amado-btn">Mua Ngay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "./pages/footer.php";?>
<script>
$( document ).ready(function() {
    $(".search-nav").hide();
});
</script>