<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_GET['id'])) {
   mysqli_query($conn, "DELETE FROM `categories` WHERE id ='{$_GET['id']}'");
   header("Location: categories.php");
}
?>