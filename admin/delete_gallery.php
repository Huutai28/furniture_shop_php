<?php include "includes/checkLogin.php" ?>
<?php
if (isset($_GET["id"])) {
    $result = mysqli_query($conn, "DELETE FROM `image_library` WHERE id = '{$_GET["id"]}'");
    if ($result) {
        echo "<script>window.history.go(-1);</script>";
    }
}
?>