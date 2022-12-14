<?php include "./pages/header_area.php"?>
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_GET['action'])) {
    function update_cart($add = false){
        foreach($_POST['quantity'] as $id => $quantity){
            if ($add) {
                $_SESSION['cart'][$id] += $quantity;
            }else{
                $_SESSION['cart'][$id] = $quantity;
            } }
        header('Location: cart.php');
    }
    switch($_GET['action']){
        case "add":
            update_cart(true);
        break;
        case "delete":
            if (isset($_GET['id'])) {
                unset($_SESSION['cart'][$_GET['id']]);
            }
            header('Location: cart.php');
        break;
        case "submit":
           if (isset($_POST["update"])) {
            update_cart();
           } elseif(isset($_POST["order"])) {
             if (!empty($_POST['quantity'])) {
                $products = mysqli_query($conn, "SELECT `id`, `price` FROM `products` WHERE `id` IN (" . implode(", ", array_keys($_POST['quantity'])) . ")");
                $total = 0;
                $orderProducts = array();
                while ($row = mysqli_fetch_array($products)) {
                    $orderProducts[] = $row;
                    $total += $row['price'] * $_POST['quantity'][$row['id']];
                }
                $name = mysqli_escape_string($conn, $_POST['name']);
                $phone = mysqli_escape_string($conn, $_POST['phone']);
                $consciou = $_POST['consciou'];
                $district = $_POST['district'];
                $ward = $_POST['ward'];
                $email = mysqli_escape_string($conn, $_POST['email']);
                $address = mysqli_escape_string($conn, $_POST['address']);
                $create_time = date('d/m/Y H:i:s');

                mysqli_query($conn, "INSERT INTO `orders`(`name`, `phone`, `ward`, `district`, `consciou`, `address`, `email`, `total`, `create_time`) VALUES ('{$name}','{$phone}','{$ward}','{$district}','{$consciou}','{$address}','{$email}','{$total}','{$create_time}')");
                $order_id = $conn->insert_id;
                $insertString = "";
                foreach ($orderProducts as $key => $product) {
                    $insertString .= "('{$order_id}', '{$product['id']}', '{$_POST['quantity'][$product['id']]}', '{$product['price']}', '{$create_time}')";
                    if ($key != count($orderProducts) - 1) {
                        $insertString .= ",";
                    }
                }
                $insertOrder = mysqli_query($conn, "INSERT INTO `order_detail` ( `order_id`, `product_id`, `quantity`, `price`, `create_date`) VALUES " . $insertString . ";");
                unset($_SESSION['cart']);
                header('Location: checkout.php?id='. $order_id);
             }
           
           }
        break;
    }
}
?>
 <?php
if (!empty($_SESSION['cart'])) {
    $products = mysqli_query($conn,"SELECT `id`, `name`, `price`, `img` FROM `products` WHERE `id` IN (" .implode(", ", array_keys($_SESSION['cart'])). ");");
    $total = 0;
?>
<div class="cart-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="cart-title mt-50">
                    <h2>Gi??? H??ng</h2>
                </div>
                <form action="cart.php?action=submit" method="POST">
                <div class="cart-table clearfix">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>T??n</th>
                                <th>????n gi??</th>
                                <th>S??? l?????ng</th>
                                <th>Th??nh ti???n</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($products) > 0) {
                                $i = 0;
                                while ($row = mysqli_fetch_array($products)) {
                                    $i++;
                                    $total += $row['price'] * $_SESSION['cart'][$row['id']];
                            ?>
                                <tr>
                                <td class="cart_product_img">
                                    <a href="product-details.php?id=<?php echo $row['id']?>"><img src="./<?php echo $row['img']?>" alt="Product"></a>
                                </td>
                                <td class="cart_product_desc">
                                    <h5><?php echo $row['name']?></h5>
                                </td>
                                <td class="price">
                                    <span><?php echo number_format($row['price'])?>???</span>
                                </td>
                                <td class="qty">
                                    <div class="qty-btn d-flex">
                                        <div class="quantity">
                                            <span class="qty-minus" onclick="var effect = document.getElementById('qty<?php echo $i ?>'); var qty<?php echo $i ?> = effect.value; if( !isNaN( qty<?php echo $i ?> ) &amp;&amp; qty<?php echo $i ?> &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                            <input type="number" class="qty-text" id="qty<?php echo $i ?>" step="1" min="1" max="300" name="quantity[<?php echo $row['id']?>]" value="<?php echo $_SESSION['cart'][$row['id']]?>">
                                            <span class="qty-plus" onclick="var effect = document.getElementById('qty<?php echo $i ?>'); var qty<?php echo $i ?> = effect.value; if( !isNaN( qty<?php echo $i ?> )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="price">
                                    <span><?php  echo number_format($row['price'] * $_SESSION['cart'][$row['id']])?>???</span>
                                </td>
                                <td class="cart_product_img">
                                    <a onclick="return confirm('B???n ch???c mu???n x??a?')" href="cart.php?action=delete&id=<?php echo $row['id']?>">X??a</a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                    <button type="submit" name="update" id="update" class="btn amado-btn active" style=" position: absolute; right: 0px; z-index: 2;">C???p nh???t gi??? h??ng</button>
                </div>
            </div>
        </div>
        <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-50 clearfix">
                            <div class="cart-title">
                                <h2>Thanh To??n</h2>
                            </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="H??? t??n" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="S??? ??i???n tho???i" oninput="check(this)" required>
                                    </div>
                                    <script>
                                        //h??m validation tr?????ng nh???p l???i m???t kh???u
                                        function check(input) {
                                            var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
                                            var value = document.getElementById("phone").value;
                                            if (isNaN(value)) {
                                                input.setCustomValidity('S??? ??i???n tho???i ph???i l?? s??.');
                                            }else if (vnf_regex.test(input.value) == false) {
                                                input.setCustomValidity('S??? ??i???n tho???i kh??ng ????ng.');
                                            } else {
                                                //H???t l???i, reset message
                                                input.setCustomValidity('');
                                            }
                                        }
                                    </script>
                                    <div class="col-md-12 mb-3">
                                        <select class="form-control" name="consciou" id="consciou" required>
                                        <option value="">--Ch???n t???nh/th??nh ph???--</option>
                                        <?php
                                        $conscious = mysqli_query($conn,"SELECT * FROM `tinhthanhpho`");
                                        if (mysqli_num_rows($conscious)) {
                                            while ($row_conscious = mysqli_fetch_array($conscious)) {
                                        ?>
                                        <option value="<?php echo $row_conscious['matp'];?>"><?php echo $row_conscious['name'];?></option>
                                        <?php } } ?>
                                    </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select id="district" name="district" class="form-control" required>
                                            <option value="">--Ch???n qu???n/huy???n--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <select class="form-control" name="ward" id="ward" required>
                                        <option value="">--Ch???n ph?????ng/x??--</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                    <textarea name="address" class="form-control" id="address" cols="30" rows="6" placeholder="?????a ch??? chi ti???t:&#13;&#10;  ghi b???ng T???ng, s??? nh??, ng??ch, t??n ???????ng/ Ho???c ng??, x??m, th??n, ???p" required></textarea>
                                    </div>
                                </div>              
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="cart-summary">
                            <h5>T???ng ????n h??ng</h5>
                            <ul class="summary-table">
                                <li><span>????n H??ng:</span> <span><?php echo number_format($total); ?>???</span></li>
                                <li><span>V???n chuy???n:</span> <span>Ch??a t??nh</span></li>
                                <li><span>T???ng C???ng:</span> <span><?php echo number_format($total); ?>???</span></li>
                            </ul>

                            <div class="payment-method">
                                <!-- Cash on delivery -->
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="radio" name="checkout" class="custom-control-input" id="cod" checked>
                                    <label class="custom-control-label" for="cod">Thanh to??n khi nh???n h??ng</label>
                                </div>
                                <!-- Paypal -->
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="radio" name="checkout" class="custom-control-input" id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal <img class="ml-15" src="img/core-img/paypal.png" alt=""></label>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LfCyFEiAAAAACGdOBcUcvdANmdvYd5JUuzbFMSX"></div>
                            <div class="cart-btn mt-100">
                                <button type="submit"name="order" id="submit" class="btn amado-btn w-100">?????t H??ng</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
</div>
<?php }else{?>
    <div class="container-fluid  mt-100 cart-table-area section-padding-100 clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body cart">
                        <div class="col-sm-12 empty-cart-cls text-center">
                            <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3">
                            <h3><strong>Kh??ng c?? s???n ph???m trong gi??? h??ng</strong></h3>
                            <h4>H??y ch???n mua s???n ph???m n??o ???? trong c???a h??ng!</h4>
                            <a href="shop.php" class="btn btn-primary cart-btn-transform m-3" data-abc="true">Ti???p T???c Mua S???m</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php include "./pages/footer.php";?>
<script>
$( document ).ready(function() {
    $(".search-nav").hide();
});
</script>
<script>
$(document).ready(function() {
    $("#consciou").change(function(){
      var country_id = this.value;
      $.ajax({
      url: "./admin/includes/district.php",
      type: "POST",
      data: {
      country_id: country_id
      },
      success:function(result){  
        $("#district").html(result);
      }
      });
    });   

    $("#district").change(function(){
      var district_id = this.value;
      $.ajax({
      url: "./admin/includes/ward.php",
      type: "POST",
      data: {
      district_id: district_id
      },
      success:function(result){  
        $("#ward").html(result);
      }
      });
    });   
});
</script>
<script>
$( document ).ready(function() {
    $(".search-nav").hide();
});
</script>
<script>
$( document ).ready(function() {
    $("#update").click(function() {
    $('input').removeAttr('required');
    $('select').removeAttr('required');
    $('textarea').removeAttr('required');

});
});
</script>
<script>
$( document ).ready(function() {
    $( "#submit" ).click(function() {
        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            alert("H??y x??c minh b???n kh??ng ph???i robot!");
            return false;
        }
    });
});
</script>