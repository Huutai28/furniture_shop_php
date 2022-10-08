<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_POST['submit'])) {
    $password = mysqli_escape_string($conn, md5($_POST['password']));
    $query = mysqli_query($conn, "UPDATE `users` SET `password`='{$password}' WHERE `name` = '{$_SESSION['USER_NAME']}'");
    header("Location: index.php");
}
?>
<?php include "includes/header.php" ?>
<main class="app-content">
    <div class="app-title">
    <div>
        <h1><i class="fa fa-pencil-square-o"></i> Đổi mật khẩu</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Đổi mật khẩu</a></li>
    </ul>
    </div>
    <div class="row">
    <div class="col-md-6">
        <div class="tile">
        <div class="tile-body">
            <form method="POST" action="" class="form-horizontal">
            <div class="form-group row">
                <label class="control-label col-md-3">Mật khẩu mới</label>
                <div class="col-md-8">
                <input class="form-control col-md-12" type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Tối thiểu tám ký tự, ít nhất một chữ hoa, một chữ thường và một số" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-3">Nhập lại mật khẩu</label>
                <div class="col-md-8">
                <input class="form-control col-md-12" type="password" name="re-enterPassword" oninput="check(this)" required>
                </div>
            </div>
            <script>
            //hàm validation trường nhập lại mặt khẩu
            function check(input) {
                if (input.value != document.getElementById('password').value) {
                    input.setCustomValidity('Nhập lại mặt khẩu không khớp.');
                } else {
                    //Hết lỗi, reset message
                    input.setCustomValidity('');
                }
            }
            </script>
        </div>
        <div class="tile-footer">
            <div class="row">
            <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Lưu Thay Đổi</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="index.php"><i class="fa fa-arrow-circle-left"></i>Thoát</a>
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