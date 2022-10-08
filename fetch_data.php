<?php
include "admin/includes/connect.php";
if (isset($_POST['action'])) {
    
    $query = "
    SELECT `id`, `name`, `price`, `img`, `category` FROM `products` WHERE 1 = 1
    ";

    if(isset($_POST["category"]))
    {
    $category_filter = implode("','", $_POST["category"]);
    $query .= "
    AND category IN('".$category_filter."')
    ";
    }

    if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
    {
    $query .= "
    AND price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
    ";
    }

    if (isset($_POST['search']) && !empty($_POST['search']))
    {
        $query .= "
        AND `name` LIKE '%" .$_POST['search']."%'
        ";
    }
}
?>
<div class="row">
    <?php
        $item_per_page= 4;
        if(isset($_POST["page"])){  
                $page = $_POST["page"];
        }else{  
                $page = 1;  
            }  
        $offset = ($page - 1) * $item_per_page;
        $total_records = mysqli_num_rows(mysqli_query($conn, $query));
        $total_pages = ceil($total_records / $item_per_page);

        $result = mysqli_query($conn,$query .= "LIMIT {$item_per_page} OFFSET {$offset}");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
    ?>
    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
        <div class="single-product-wrapper">
            <div class="product-img">
                <img src="./<?php echo $row['img']?>" alt="">
            </div>
            <div class="product-description d-flex align-items-center justify-content-between">
                <div class="product-meta-data">
                    <div class="line"></div>
                    <p class="product-price">Giá <?php echo number_format($row['price'])?>₫</p>
                    <a href="product-details.php?id=<?php echo $row['id'];?>">
                        <h6><?php echo $row['name']?></h6>
                    </a>
                </div>
                <div class="ratings-cart text-right">
                    <div class="ratings">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="cart">
                        <form action="cart.php?action=add" method="post">
                        <input type="number" value="1" name="quantity[<?php echo $row['id']?>]" hidden>
                        <a data-toggle="tooltip" data-placement="left" title="Thêm vào giỏ"><button type="submit" style="outline:none; border-style: none; cursor: pointer; background-color: #fff;"><img src="img/core-img/cart.png" alt=""></button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php } }?>
</div>
<div class="row">
<div class="col-12">
    <nav aria-label="navigation">
        <ul class="pagination justify-content-end mt-50">
            <?php for ($i=1; $i <= $total_pages; $i++) { ?>
                    <?php if ($i != $page) { ?>
                       <li class="page-item"><a class="page-link" id="<?php echo $i?>"><?php echo $i?>.</a></li>
                    <?php }else{ ?>
                        <li class="page-item active"><a class="page-link" id="<?php echo $i?>"><?php echo $i?>.</a></li>
                    <?php }?>  
            <?php } ?>
        </ul>
    </nav>
</div>
</div>

