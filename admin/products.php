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
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Danh mục</th>
                  <th>Giá</th>
                  <th>Mô tả</th>
                  <th>Sửa bởi</th>
                  <th>Ngày sửa</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 $query = mysqli_query($conn, "SELECT * FROM `products`");
                 if (mysqli_num_rows($query) > 0) {
                   while ($row = mysqli_fetch_array($query)) { 
                    $query_category= mysqli_query($conn, "SELECT `name` FROM `categories` WHERE `id` = '{$row['category']}'");
                    $category = mysqli_fetch_array($query_category);
                ?>
                <tr>
                  <td><img width="160" src="../<?php echo $row['img'];?>"></td>
                  <td><?php echo $row['name']?></td>
                  <td><?php echo $category['name']?></td>
                  <td><?php echo number_format($row['price'])?>₫</td>
                  <td><?php echo $row['information']?></td>
                  <td><?php echo $row['edited_by']?></td>
                  <td><?php echo $row['last_update']?></td>
                  <td><a class="btn btn-outline-warning" href="edit_product.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o"></i>Sửa</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-outline-danger" href="delete_product.php?id=<?php echo $row['id'];?>" onclick="return confirm('Bạn chắc muốn xóa?')"><i class="fa fa-trash"></i>Xóa</a></td>
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