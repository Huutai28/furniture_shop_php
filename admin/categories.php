<?php include "includes/checkLogin.php" ?>
<?php include "includes/header.php" ?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-th-list"></i> Danh Sách Danh Mục</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item active"><a href="#">Danh Sách Danh Mục</a></li>
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
                  <th>Tên danh mục</th>
                  <th>Số mặt hàng</th>
                  <th>Sửa bởi</th>
                  <th>Ngày sửa</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM `categories`");
                if (mysqli_num_rows($query) > 0) {
                  while ($row = mysqli_fetch_array($query)) {
                    $count = mysqli_num_rows(mysqli_query($conn, "SELECT `name` FROM `products` WHERE `category` = '{$row["id"]}'"));
                ?>
                <tr>
                  <td><?php echo $row['name']?></td>
                  <td><?php echo $count;?></td>
                  <td><?php echo $row['edited_by']?></td>
                  <td><?php echo $row['last_update']?></td>
                  <td><a class="btn btn-outline-warning" href="edit_category.php?id=<?php echo $row['id']?>"><i class="fa fa-pencil-square-o"></i>Sửa</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-outline-danger" <?php if ($count) { ?>
                    onclick="return confirm('Không thể xóa! Vẫn còn sản phẩm trong danh mục này.')" href="javascript:void(0);"
                  <?php }else { ?>
                    href="delete_category.php?id=<?php echo $row['id']?>" onclick="return confirm('Bạn chắc muốn xóa?')"
                 <?php }?> ><i class="fa fa-trash"></i>Xóa</a></td>
                </tr>
                <?php } }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include "includes/footer.php" ?>
