<?php
session_start();
unset($_SESSION['USER_EMAIL']);
unset($_SESSION['USER_NAME']);
unset($_SESSION['USER_LEVEL']);
session_destroy();
header("Location: ../login.php");
?>