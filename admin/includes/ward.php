<?php
include "connect.php";
echo "<option value=''>--Chọn phường/xã--</option>";
if (isset($_POST['district_id'])) {
   $query = mysqli_query($conn,"SELECT * FROM `xaphuongthitran` WHERE maqh = '{$_POST['district_id']}'");
   if (mysqli_num_rows($query)) {
        while ($row = mysqli_fetch_array($query)) {
?>
         <option value='<?php echo $row['xaid'] ?>'><?php echo $row['name']; ?></option>;
<?php } } } ?>