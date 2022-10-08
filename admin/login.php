<?php
session_start();
$message='';
//import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
include "./includes/connect.php";
if (isset($_POST["login"])) {
  $name = mysqli_escape_string($conn, $_POST["name"]);
  $password = mysqli_escape_string($conn, md5($_POST["password"]));
  $login_query = mysqli_query($conn,"SELECT * FROM `users` WHERE (`name` = '{$name}' OR `email` = '{$name}') AND `password` = '{$password}'");
  if (mysqli_num_rows($login_query) === 1) {
    $row_user = mysqli_fetch_array($login_query);
    $_SESSION['USER_EMAIL'] = $row_user['email'];
    $_SESSION['USER_NAME'] = $row_user['name'];
    $_SESSION['USER_LEVEL'] = $row_user['level'];
    header("Location: index.php");
  }else{
    $message ="<div class='alert alert-danger' role='alert'>Tên tài khoản hoặc mật khẩu không đúng!</div>";
  }

  if(!empty($_POST["rememberMe"])) {
    setcookie ("name",$_POST["name"],time()+ 2592000);
    setcookie ("password",$_POST["password"],time()+ 2592000);
  } else {
    setcookie("name","");
    setcookie("password","");
  }
} elseif(isset($_POST["forget"])){
    $email = mysqli_escape_string($conn, $_POST['email']);
    $verification = mysqli_real_escape_string($conn, md5(rand()));
    if (mysqli_num_rows(mysqli_query($conn, "SELECT `id`FROM `users` WHERE `email` = '{$email}'")) > 0 ) {
      $forget_query = mysqli_query($conn, "UPDATE `users` SET `verification`='{$verification}' WHERE `email` = '{$email}'");
      if ($forget_query) {
        echo "<div style='display: none;'>";
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                  //Enable verbose debug output
            $mail->isSMTP();                                       //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                  //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                              //Enable SMTP authentication
            $mail->Username   = 'shopht260@gmail.com';             //SMTP username
            $mail->Password   = 'xjlxqzpgqhyarlpe';                //SMTP password
            $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;   //Enable implicit TLS encryption
            $mail->Port       = 587;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet    ='utf-8';
            //Recipients
            $mail->setFrom('shopht260@gmail.com');
            $mail->addAddress($email);     //Add a recipient
            //Content
            $mail->isHTML(true);           //Set email format to HTML
            $mail->Subject = 'Nội Thất Nam Linh';
            $mail->Body    = 'Link đổi mật khẩu của bạn: <b><a href="http://localhost/dogonamlinh/admin/forgot_password.php?code='.$verification.'">http://localhost/dogonamlinh/admin/forgot_password.php?code='.$verification.'</a></b>';
  
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "</div>";
        $message = "<div class='alert alert-info'>Hãy kiểm tra email. Link đổi mật khẩu được gửi từ shopht206@gmail.com</div>";
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
    <title>Đăng Nhập Trang Quản Trị</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Quản Trị</h1>
      </div>
      <?php echo $message; ?>
      <div class="login-box">
        <form class="login-form" method="POST" action="">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Đăng Nhập</h3>
          <div class="form-group">
            <label class="control-label">Tên tài khoản hoặc Email</label>
            <input class="form-control" type="text" name="name" value="<?php if(isset($_COOKIE["name"])) { echo $_COOKIE["name"]; } ?>" required autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Mật khẩu</label>
            <input class="form-control" type="password" minlength="4" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required>
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" name="rememberMe"><span class="label-text">Tự động điền</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Quên Mật Khẩu?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="login"><i class="fa fa-sign-in fa-lg fa-fw"></i>Đăng Nhập</button>
          </div>
        </form>
        <form class="forget-form" method="POST">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>QUÊN MẬT KHẨU ?</h3>
          <div class="form-group">
            <label class="control-label">Email</label>
            <input class="form-control" type="email" name="email" required>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit" name="forget"><i class="fa fa-unlock fa-lg fa-fw"></i>Đổi Mật Khẩu</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Quay lại trang đăng nhập</a></p>
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