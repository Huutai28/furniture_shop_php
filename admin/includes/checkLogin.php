<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$message='';
if (!isset($_SESSION['USER_EMAIL']) || !isset($_SESSION['USER_NAME']) || !isset($_SESSION['USER_LEVEL'])) {
  header("Location: login.php");
}
include "connect.php";
?>