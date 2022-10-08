<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Trang Quản Trị - Đồ Gỗ Nam Linh</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css?r='+ Math.floor(Math.random()*100) +'">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="index.html">Quản Trị</a>
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <ul class="app-nav">
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="changePassword.php"><i class="fa fa-lock fa-lg"></i> Đổi Mật Khẩu</a></li>
            <li><a class="dropdown-item" href="./includes/logout.php"><i class="fa fa-sign-out fa-lg"></i> Đăng Xuất</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <div>
          <p class="app-sidebar__user-name"><?php echo $_SESSION['USER_NAME']?></p>
          <p class="app-sidebar__user-designation"><?php switch ($_SESSION['USER_LEVEL']) {
                                  case 1:
                                      echo "Admin cấp cao";
                                      break;
                                  case 2:
                                      echo "Quản lý";
                                      break;
                                  case 3:
                                      echo "Admin";
                                      break;
                                };
                          ?></p>
        </div>
      </div>
      <ul class="app-menu">
      <li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Tông Quan</span></a></li>
      <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th"></i><span class="app-menu__label">Danh Mục</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="add_category.php"><i class="icon fa fa-circle-o"></i> Thêm Mới</a></li>
          <li><a class="treeview-item" href="categories.php"><i class="icon fa fa-circle-o"></i> Danh Sách</a></li>
        </ul>
      </li>
      <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Sản Phẩm</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="add_product.php"><i class="icon fa fa-circle-o"></i> Thêm Mới</a></li>
          <li><a class="treeview-item" href="products.php"><i class="icon fa fa-circle-o"></i> Danh Sách</a></li>
        </ul>
      </li>
      <li><a class="app-menu__item" href="orders.php"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Đơn hàng</span></a></li>
      <?php
      if ($_SESSION['USER_LEVEL'] != 2) {
      ?>
      <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Tài khoản</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="add_user.php"><i class="icon fa fa-circle-o"></i> Thêm Mới</a></li>
          <li><a class="treeview-item" href="users.php"><i class="icon fa fa-circle-o"></i> Danh Sách</a></li>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </aside>