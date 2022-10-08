<?php include "includes/checkLogin.php" ?>
<?php include "includes/header.php" ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-th-list"></i> Đơn hàng chi tiết </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item active"><a href="#"> Đơn hàng chi tiết </a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Số lượng</th>
                  <th>Đơn giá</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_GET['id'])) {
                    $orders = mysqli_query($conn,"SELECT * FROM `order_detail` WHERE `order_id` = '{$_GET['id']}'");
                    if (mysqli_num_rows($orders) > 0) {
                        while ($row = mysqli_fetch_array($orders)) {
                            $product = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`, `img` FROM `products` WHERE id = '{$row['product_id']}'"));
                ?>
                 <tr>
                    <td><img width="160" src="../<?php echo $product['img'];?>"/></td>
                    <td><?php echo $product['name'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td><?php echo number_format($row['price']);?>₫</td>
                </tr>
                <?php } } }else{ ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include "includes/footer.php" ?>
