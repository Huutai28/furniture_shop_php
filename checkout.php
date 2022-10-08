<?php include "./pages/header_area.php"?>
<?php
if (isset($_GET['id'])) {
   $result = mysqli_query($conn, "SELECT * FROM `orders` WHERE `id` ='{$_GET['id']}'");
   if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    $ward = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`FROM `xaphuongthitran` WHERE xaid = '{$row['ward']}'"));
    $district = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`FROM `quanhuyen` WHERE maqh = '{$row['district']}'"));
    $consciou = mysqli_fetch_array(mysqli_query($conn,"SELECT `name` FROM `tinhthanhpho` WHERE matp = '{$row['consciou']}'"));
   }
}
?>
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
            <div class="card border-warning mb-3 ">
                <div class="card-body text-warning">
                    <h5 class="card-title">Đặt hàng thành công</h5>
                    <p class="card-text">Cảm ơn khách hàng đã đặt hàng trên website nội thất Nam Linh. Chúng tôi sẽ sớm gọi cho quý khách để xác nhận đơn hàng và báo giá vận chuyển.</p>
                    <h5 class="card-title">Thông tin đơn hàng</h5>
                    <p class="card-text">Tên khách hàng: <?php echo $row['name'];?><br>Số điện thoại: <?php echo $row['phone'];?><br>Địa chỉ:  <?php echo $row['address'].", ". $ward['name'].", ". $district['name'].", ". $consciou['name'];?><br>Tổng đơn hàng: <?php echo number_format($row['total']);?>₫<br>Ngày đặt: <?php echo $row['create_time'];?></p>
                </div>
                </div>
            </div>
            <div class="col-12 col-lg-12">
            <div class="cart-table clearfix">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tên</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $carts = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `order_id` = '{$_GET['id']}';");
                        if (mysqli_num_rows($carts) > 0) {
                            while ($cart = mysqli_fetch_array($carts)) {
                                $product = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`, `img` FROM `products` WHERE id = '{$cart['product_id']}'"));
                        ?>
                        <tr>
                            <td class="cart_product_img">
                                <img src="./<?php echo $product['img'];?>" alt="Product">
                            </td>
                            <td class="cart_product_desc">
                                <h5><?php echo $product['name'];?></h5>
                            </td>
                            <td class="price">
                                <span><?php echo number_format($cart['price']);?>₫</span>
                            </td>
                            <td class="qty">
                            <span><?php echo $cart['quantity'];?></span>
                            </td>
                            <td class="price">
                                <span><?php echo number_format($cart['price'] * $cart['quantity'])?>₫</span>
                            </td>
                        </tr>
                        <?php } }?>
                    </tbody>
                </table>
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