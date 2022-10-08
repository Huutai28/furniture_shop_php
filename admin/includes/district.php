<?php
include "connect.php";
echo "<option value=''>--Chọn quận/huyện--</option>";
if (isset($_POST['country_id'])) {
   $query = mysqli_query($conn,"SELECT * FROM `quanhuyen` WHERE `matp` = '{$_POST['country_id']}';");
   if (mysqli_num_rows($query)) {
        while ($row = mysqli_fetch_array($query)) {
?>
         <option value='<?php echo $row['maqh'] ?>'><?php echo $row['name']; ?></option>;
<?php } } } ?>
