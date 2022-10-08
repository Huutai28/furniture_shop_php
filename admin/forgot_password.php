<?php
include "./includes/connect.php";
if (isset($_GET['code'])) {
  if (mysqli_num_rows(mysqli_query($conn, "SELECT `id` FROM `users` WHERE `verification` = '{$_GET['code']}'")) > 0) {
    if (isset($_POST['submit'])) {
      $password = mysqli_real_escape_string($conn, md5($_POST['password']));
      $query = mysqli_query($conn, "UPDATE `users` SET `password`='{$password}',`verification`='' WHERE verification = '{$_GET['code']}'");
      header("Location:login.php");
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Quên mật khẩu</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Quản Trị</h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="POST" action="">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Quên Mật Khẩu</h3>
          <div class="form-group">
            <label class="control-label">Mật Khẩu Mới</label>
            <input class="form-control" type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Tối thiểu tám ký tự, ít nhất một chữ hoa, một chữ thường và một số" required>
          </div>
          <div class="form-group">
            <label class="control-label">Nhập Lại Mật khẩu</label>
            <input class="form-control" type="password" name="re-enterPassword" oninput="check(this)" required>
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
          <div class="form-group">
            <div class="utility">
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Lưu Thay Đổi</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>