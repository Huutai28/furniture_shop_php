<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_GET['id'])) {
    mysqli_query($conn, "DELETE FROM `products` WHERE id ='{$_GET['id']}'");
   header("Location: ../index.php?page=product");
}
?>