<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_GET['id'])) {
  $query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '{$_GET['id']}'");
  $row_product = mysqli_fetch_array($query);

  $gallery = mysqli_query($conn, "SELECT * FROM `image_library` WHERE `product` = " . $_GET['id']);
  if (!empty($gallery) && !empty($gallery->num_rows)) {
      while ($row = mysqli_fetch_array($gallery)) {
          $product['gallery'][] = array(
              'id' => $row['id'],
              'path' => $row['path']
          );
      }
  }
  include "./includes/uploadFiles.php";
  if (isset($_POST['submit'])) {
    $name =  mysqli_escape_string($conn, $_POST["name"]);
    $price =  mysqli_escape_string($conn, $_POST["price"]);
    $information =  mysqli_escape_string($conn, $_POST["information"]);
    $category =  mysqli_escape_string($conn, $_POST["category"]);
    $edit_by = $_SESSION['USER_NAME'];
    $last_update = date('d/m/Y H:i:s');


    if (isset($_FILES['img']) && !empty($_FILES['img']['name'][0])) {
      $uploadedFiles = $_FILES['img'];
      $result = uploadFiles($uploadedFiles);
      if (!empty($result['errors'])) {
          $error = $result['errors'];
      } else {
          $img = $result['path'];
      }
    }
    if (!isset($img) && !empty($_POST['img'])) {
      $img = $_POST['img'];
    }
    if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
      $uploadedFiles = $_FILES['gallery'];
      $result = uploadFiles($uploadedFiles);
      if (!empty($result['errors'])) {
          $error = $result['errors'];
      } else {
          $galleryImages = $result['uploaded_files'];
      }
    }
    if (!empty($_POST['gallery_image'])) {
        $galleryImages = array_merge($galleryImages, $_POST['gallery_image']);
    }
    if (isset($img)) {
      $result = mysqli_query($conn, "UPDATE `products` SET `name`='{$name}',`price`='{$price}',`img`='{$img}',`information`='{$information}',`category`='{$category}',`edited_by`='{$edit_by}',`last_update`='{$last_update}' WHERE `id`='{$_GET['id']}'");
    }else{
      $result = mysqli_query($conn, "UPDATE `products` SET `name`='{$name}',`price`='{$price}',`information`='{$information}',`category`='{$category}',`edited_by`='{$edit_by}',`last_update`='{$last_update}' WHERE `id`='{$_GET['id']}'");
    }
    if ($result) {
      $product_id = $_GET['id'];
      $insertValues = "";
      foreach ($galleryImages as $path) {
        if (empty($insertValues)) {
            $insertValues = "('{$product_id}','{$path}','{$edit_by}','{$last_update}')";
        } else {
            $insertValues .= ",('{$product_id}','{$path}','{$edit_by}','{$last_update}')";
        }
      }
      mysqli_query($conn,"INSERT INTO `image_library`( `product`, `path`, `edited_by`, `last_update`) VALUES " . $insertValues . ";");
      header("Location: index.php?page=product");
    }
  } 
}
?>
<script>
  function chooseFile(fileInput) {
    if(fileInput.files && fileInput.files[0]){
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#img').attr('src', e.target.result);
      }
      reader.readAsDataURL(fileInput.files[0]);
    }
  }
</script>
<?php include "includes/header.php" ?>
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fa fa-pencil-square-o"></i>Sửa Sản Phẩm</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">sửa sản phẩm</a></li>
    </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
              <div class="col-lg-12">
                <form method="POST" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input class="form-control" id="name" name="name" type="text" value="<?php echo $row_product['name'];?>" required>
                  </div>
                  <div class="form-group">
                    <label for="price">Giá</label>
                    <input class="form-control" id="price" name="price" type="number" min="100000" value="<?php echo $row_product['price'];?>"  required>
                  </div>
                  <div class="form-group">
                    <label for="information">Mô tả sản phẩm</label>
                     <textarea class="form-control" id="information" name="information" rows="6"><?php echo $row_product['information']?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="img">Ảnh đại điện</label>
                    <input class="form-control" id="imgFile" value="<?php echo $row['img']?>" onchange="chooseFile(this)" name="img" type="file" accept="image/jpg, image/png, image/jpeg">
                    <div class="card-body">  
                    <img src="../<?php echo $row_product['img']?>" id="img"  width="220"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="imgs">Ảnh chi tiết</label>
                    <input class="form-control" id="gallery" name="gallery[]" type="file" accept="image/jpg, image/png, image/jpeg"  multiple="">
                    <small class="form-text text-muted" id="imgs">Giữa Shift để chọn nhiều ảnh</small>
                    <div class="field">
                    <ul> <?php foreach ($product['gallery'] as $image) { ?>
                        <li>
                        <img src="../<?php echo $image['path']?>" />
                        <a href="delete_gallery.php?id=<?php echo $image['id'] ?>">Xóa</a>
                        </li>
                        <?php } ?>
                    </ul>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="category">Danh mục sản phẩm</label>
                    <select class="form-control" id="category" name="category" required>
                      <option>--Chọn Danh Mục--</option>
                      <?php
                      $query_category = mysqli_query($conn, "SELECT `id`, `name`FROM `categories`");
                      if (mysqli_num_rows($query) > 0) {
                        while ($category = mysqli_fetch_array($query_category)) {   
                      ?>
                      <option value="<?php echo $category['id'];?>" <?php if ($row_product['category'] == $category['id']) {
                        echo 'selected';
                      } ?> ><?php echo $category['name'];?></option>
                      <?php } } ?>
                    </select>
                  </div>
              </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sửa</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="index.php?page=product"><i class="fa fa-arrow-circle-left"></i>Xem Danh Sách</a>
            </div>
            </form>
          </div>
        </div>
      </div>
</main>
<script src="./js/plugins/review-img.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
  .create( document.querySelector( '#information' ) )
  .then( editor => {
          console.log( editor );
  } )
  .catch( error => {
          console.error( error );
} );
</script>
<?php include "includes/footer.php" ?>