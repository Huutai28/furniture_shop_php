<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_POST["submit"])) {
    $name = mysqli_escape_string($conn, $_POST["name"]);
    $edit_by = $_SESSION['USER_NAME'];
    $last_update = date('d/m/Y H:i:s');

    if (mysqli_num_rows(mysqli_query($conn, "SELECT `id` FROM `categories` WHERE `name` = '{$name}'")) > 0) {
        $message="<div class='alert alert-danger' role='alert'>Danh mục này đã tồn tại! Hãy chọn tên khác.</div>";
    }else{
        mysqli_query($conn,"INSERT INTO `categories`(`name`, `edited_by`, `last_update`) VALUES ('{$name}','{$edit_by}','{$last_update}')");
        header("Location: categories.php");
    }
}
?>
<?php include "includes/header.php" ?>
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fa fa-pencil-square-o"></i> Thêm Danh Mục</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">thêm danh mục</a></li>
    </ul>
    </div>
    <div class="row">
    <div class="col-md-6">
        <div class="tile">
        <div class="tile-body">
            <form method="POST" action="" class="form-horizontal">
            <div class="form-group row">
                <label class="control-label col-md-3">Tên Danh Mục</label>
                <div class="col-md-8">
                <input class="form-control col-md-12" type="text" name="name" placeholder="Vd: Bàn Ăn" required>
                </div>
            </div> 
            <?php echo $message;?>
        </div>
        <div class="tile-footer">
            <div class="row">
            <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Thêm</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="index.php?page=category"><i class="fa fa-arrow-circle-left"></i>Xem Danh Sách</a>
            </div>
            </div>
        </div>
        </form>
        </div>
    </div>
    <div class="clearix"></div>
    </div>
</main>
<?php include "includes/footer.php" ?>