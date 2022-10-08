<?php include "includes/checkLogin.php" ?>
<?php include "includes/header.php" ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-th-list"></i> Danh Sách Đơn hàng</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item active"><a href="#">Danh Sách Đơn hàng</a></li>
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
                  <th>Tên khách hàng</th>
                  <th>Số điện thoại</th>
                  <th>Giá trị đơn hàng</th>
                  <th>Địa chỉ chi tiết</th>
                  <th>Xã/phường</th>
                  <th>Quận/huyện</th>
                  <th>Tỉnh/thành phố</th>
                  <th>Ngày đặt</th>
                  <th>Xem đơn</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $orders = mysqli_query($conn,"SELECT * FROM `orders`");
                if (mysqli_num_rows($orders) > 0) {
                    while ($order = mysqli_fetch_array($orders)) {
                        $ward = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`FROM `xaphuongthitran` WHERE xaid = '{$order['ward']}'"));
                        $district = mysqli_fetch_array(mysqli_query($conn,"SELECT `name`FROM `quanhuyen` WHERE maqh = '{$order['district']}'"));
                        $consciou = mysqli_fetch_array(mysqli_query($conn,"SELECT `name` FROM `tinhthanhpho` WHERE matp = '{$order['consciou']}'"));
                ?>
                <tr>
                    <td><?php echo $order['name'];?></td>
                    <td><?php echo $order['phone'];?></td>
                    <td><?php echo number_format($order['total']);?>₫</td>
                    <td><?php echo $order['address'];?></td>
                    <td><?php echo $ward['name'];?></td>
                    <td><?php echo $district['name'];?></td>
                    <td><?php echo $consciou['name'];?></td>
                    <td><?php echo $order['create_time'];?></td>
                    <td><a href="order_detail.php?id=<?php echo $order['id'];?>" class="btn btn-outline-success" type="button">Xem chi tiết</a></td>
                </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include "includes/footer.php" ?>
