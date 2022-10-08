<?php include "includes/checkLogin.php"?>
<?php if ($_SESSION['USER_LEVEL'] == 2) {
  header("Location: index.php");
}?>
<?php
//import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
if (isset($_POST['submit'])) {
    $name = mysqli_escape_string($conn, $_POST['name']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $level = mysqli_escape_string($conn, $_POST['level']);
    $password = md5("123456");
    $edit_by = $_SESSION['USER_NAME'];
    $create_time = date('d/m/Y H:i:s');
    if (mysqli_num_rows(mysqli_query($conn, "SELECT `id` FROM `users` WHERE `email` = '{$email}'")) > 0 ) {
        $message="<div class='alert alert-danger' role='alert'>Tài khoản '{$email}' này đã được sử dụng. Hãy nhập email khắc!</div>";
    }else{
        $result = mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`, `create_time`, `level`, `create_by`) VALUES ('{$name}','{$email}','{$password}','{$create_time}','{$level}','{$edit_by}')");
        if ($result) {
          echo "<div style='dislay: none;'>";
          $mail = new PHPMailer(true);
          try {
              //Server settings
              $mail->SMTPDebug = 0;                                     //Enable verbose debug output
              $mail->isSMTP();                                          //Send using SMTP
              $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
              $mail->Username   = 'shopht260@gmail.com';                //SMTP username
              $mail->Password   = 'xmnbkqmeqwzdorrv';                   //SMTP password
              $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;      //Enable implicit TLS encryption
              $mail->Port       = 587;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
              $mail->CharSet    ='utf-8';
              //Recipients
              $mail->setFrom('shopht260@gmail.com');
              $mail->addAddress($email);     //Add a recipient
              //Content
              $mail->isHTML(true);           //Set email format to HTML
              $mail->Subject = 'Nội Thất Nam Linh';
              $mail->Body    = 'Tài khoản đăng nhập quản trị viên của bạn là:<br>Tên đăng nhập: ' .$name. '<br>Mật Khẩu: 123456<br>Lưu ý: Hãy đổi mật. Nếu không nhớ tên đằng nhập hãy sử email này để thay cho tên đằng nhập';
    
              $mail->send();
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
          echo "</div>";
        }
        header("Location: users.php");
    }
}
?>
<?php include "includes/header.php" ?>
<main class="app-content">
    <div class="app-title">
        <div>
        <h1><i class="fa fa-dashboard"></i> Thêm tài khoản</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Thêm tài khoản</a></li>
        </ul>
    </div>
    <div class="row">
    <div class="col-md-6">
          <div class="tile">
            <div class="tile-body">
              <form  action="" method="POST" class="form-horizontal">
                <div class="form-group row">
                  <label class="control-label col-md-3">Tên đăng nhập</label>
                  <div class="col-md-8">
                    <input class="form-control" name="name" type="text" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Email</label>
                  <div class="col-md-8">
                    <input class="form-control" name="email" type="email" required>
                  </div>
                  <?php echo $message;?>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Mật khẩu</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" value="123456" disabled>
                  </div>
                </div>
                <div class="form-group">
                    <label for="level">Chức vụ</label>
                    <select class="form-control" name="level" id="level">
                      <option selected value="2">Quản lý</option>
                      <option value="3">Admin</option>
                    </select>
                  </div>
            </div>
            <div class="tile-footer">
              <div class="row">
                <div class="col-md-8 col-md-offset-3">
                  <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Tạo</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Thoát</a>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="clearix"></div>
    </div>
</main>
<?php include "includes/footer.php" ?>