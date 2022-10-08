<?php include "includes/checkLogin.php" ?>
<?php if ($_SESSION['USER_LEVEL'] == 2) {
  header("Location: index.php");
}?>
<?php include "includes/header.php" ?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Danh sách tài khoản</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"> Danh sách tài khoản</a></li>
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
                  <th>Tên tài khoản</th>
                  <th>Email</th>
                  <th>Chức vụ</th>
                  <th>Tạo bởi</th>
                  <th>Ngày tạo</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>admin</td>
                  <td>shopht260@gmail.com</td>
                  <td>Admin cấp cao</td>
                  <td></td>
                  <td>8:59:20 09/23/2022</td>
                  <td></td>
                </tr>
                <?php
                $result = mysqli_query($conn,"SELECT * FROM `users` WHERE `level` != 1");
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                ?>
                  <tr>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php switch ($row['level']) {
                                  case 1:
                                      echo "Admin cấp cao";
                                      break;
                                  case 2:
                                      echo "Quản lý";
                                      break;
                                  case 3:
                                      echo "Admin";
                                      break;
                                };
                          ?>
                      </td>
                    <td><?php echo $row['create_by'];?></td>
                    <td><?php echo $row['create_time'];?></td>
                    <td><a href="order_detail.php?id=<?php echo $order['id'];?>" class="btn btn-outline-danger" onclick="return confirm('Bạn chắc muốn xóa?')" type="button">Xóa</a></td>
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