<!DOCTYPE html>
<html lang="en">

<head>
  <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php include('LinkCss.php'); ?>
  <link href='https://unpkg.com/css.gg@2.0.0/icons/css/pen.css' rel='stylesheet'>

  <style>
    .navbar-nav li {
      display: inline-block;
      vertical-align: middle;
    }

    .navbar-nav form {
      display: inline-block;
      vertical-align: middle;
      margin-left: 20px;
    }

    .navbar-nav button {
      vertical-align: middle;
    }

    .navbar-nav form {
      display: flex;
      align-items: center;
    }

    .navbar-nav form .form-control {
      flex: 1;
      margin-right: 10px;
    }

    .navbar-nav form .btn {
      white-space: nowrap;
    }

    .navbar-nav form .form-control {
      flex: 1;
      margin-right: 10px;
      padding: 5px 5px;
      font-size: 0.875rem;
      height: 10px;
      line-height: 1.2;
      border-radius: 10px;
    }
  </style>
</head>

<?php
// GIỎ HÀNG
session_start();

include('Connect.php');

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);


// Nếu chưa tồn tại thì khởi tạo giỏ
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

//Xóa ALL giỏ
if (isset($_GET['emptyCart']) && ($_GET['emptyCart'] == 1)) unset($_SESSION['cart']);

//Xóa item trong Giỏ
if (isset($_GET['delId']) && ($_GET['delId'] >= 0)) {
  // unset($_SESSION['cart'][$_GET['delId']]);
  array_splice($_SESSION['cart'], $_GET['delId'], 1);
}

// Update item trong giỏ
if (isset($_GET['updateId']) && ($_GET['updateId'] >= 0)) {
  $index = $_GET['updateId'];
  if (isset($_SESSION['cart'][$index])) {
    $new_quantity = $_GET['num_sl']; // Số lượng mới
    $_SESSION['cart'][$index]['sl'] = $new_quantity;
  }
}

//Lấy dl từ form Xem Chi Tiết
if (isset($_POST['add_to_cart']) && ($_POST['add_to_cart'])) {
  $maSP = $_POST['maSP'];
  $tenSP = $_POST['tenSP'];
  $hinhSP = $_POST['hinhSP'];
  $giaSP = $_POST['giaSP'];
  $sl = $_POST['sl'];

  $flag = 0;
  $count = count($_SESSION['cart']);
  for ($i = 0; $i < $count; $i++) {
    $item = $_SESSION['cart'][$i];
    if ($item["maSP"] == $maSP) {
      $flag = 1;
      $sl_new = $sl + $item["sl"];
      $item["sl"] = $sl_new; // Cập nhật số lượng trực tiếp trong mảng $_SESSION['cart']
      $_SESSION['cart'][$i] = $item;
      break;
    }
  }

  //Thêm SP vào giỏ nếu kg trùng
  if ($flag == 0) {
    // $sp = [$maMon,$tenMon, $hinh,$donGia,$sl];
    $sp = array(
      'maSP' => $maSP,
      'tenSP' => $tenSP,
      'hinhSP' => $hinhSP,
      'giaSP' => $giaSP,
      'sl' => $sl,
    );
    $_SESSION['cart'][] = $sp;
  }
}

?>

<?php

$pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo->query("set names utf8");

$sql = "Select * From Brand";
$brand = $pdo->query($sql);

$pdo = NULL;

$pdo1 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo1->query("set names utf8");

$sql1 = "SELECT
sanpham.MaSP, 
sanpham.TenSP, 
loaisanpham.GiaLoaiSP, 
sanpham.HinhAnhSP, 
loaisanpham.MoTa
FROM loaisanpham
JOIN (
SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
FROM sanpham
GROUP BY MaLoaiSP, MaMau
) AS grouped_sanpham
ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
JOIN sanpham 
ON grouped_sanpham.MaSP = sanpham.MaSP";
$sanpham = $pdo1->query($sql1);
$pdo1 = NULL;

$pdo2 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo2->query("set names utf8");
if (isset($_GET['ml'])) {
  if ($_GET["ml"] == NULL)
    $ml = 0;
  else
    $ml = $_GET["ml"];

  if ($ml == 0)
    $sql2 = "SELECT
		sanpham.MaSP,  
		sanpham.TenSP, 
		loaisanpham.GiaLoaiSP, 
		sanpham.HinhAnhSP, 
		loaisanpham.MoTa
	FROM loaisanpham
	JOIN (
		SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
		FROM sanpham
		GROUP BY MaLoaiSP, MaMau
	) AS grouped_sanpham
		ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
	JOIN sanpham 
		ON grouped_sanpham.MaSP = sanpham.MaSP";
  else
    $sql2 = "SELECT
		sanpham.MaSP,
		sanpham.TenSP,
		loaisanpham.GiaLoaiSP,
		sanpham.HinhAnhSP,
		loaisanpham.MoTa
	FROM loaisanpham
	JOIN (
		SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
		FROM sanpham
		GROUP BY MaLoaiSP, MaMau
	) AS grouped_sanpham
		ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
	JOIN sanpham
		ON grouped_sanpham.MaSP = sanpham.MaSP
	JOIN brand
		ON brand.MaBrand = loaisanpham.MaBrand
	WHERE brand.MaBrand = " . $ml;

  $giay2 = $pdo2->query($sql2);
  $pdo2 = NULL;
}

$pdo3 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo3->query("set names utf8");
if (isset($_GET['gt']) && isset($_GET['gc'])) {
  $gt = $_GET['gt'];
  $gc = $_GET['gc'];
  if ($gt == 0 && $gc == 0)
    $sql3 = "SELECT
		sanpham.MaSP,  
		sanpham.TenSP, 
		loaisanpham.GiaLoaiSP, 
		sanpham.HinhAnhSP, 
		loaisanpham.MoTa
	FROM loaisanpham
	JOIN (
		SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
		FROM sanpham
		GROUP BY MaLoaiSP, MaMau
	) AS grouped_sanpham
		ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
	JOIN sanpham 
		ON grouped_sanpham.MaSP = sanpham.MaSP";
  else
    $sql3 = "SELECT
		sanpham.MaSP,  
		sanpham.TenSP, 
		loaisanpham.GiaLoaiSP, 
		sanpham.HinhAnhSP, 
		loaisanpham.MoTa
	FROM loaisanpham
	JOIN (
		SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
		FROM sanpham
		GROUP BY MaLoaiSP, MaMau
	) AS grouped_sanpham
		ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
	JOIN sanpham 
		ON grouped_sanpham.MaSP = sanpham.MaSP
	WHERE GiaLoaiSP >" . $gt . "&& GiaLoaiSP<=" . $gc;

  $giay3 = $pdo3->query($sql3);
  $pdo3 = NULL;
}
// Tìm kiếm theo tên
$pdo4 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo4->query("set names utf8");
if (isset($_GET['txt_Search'])) {
  $Ten = $_GET["txt_Search"];
  $sql4 = "SELECT 
        sanpham.MaSP, 
        sanpham.TenSP, 
        loaisanpham.GiaLoaiSP, 
        sanpham.HinhAnhSP, 
        loaisanpham.MoTa
    FROM loaisanpham
    JOIN (
        SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
        FROM sanpham
        WHERE TenSP LIKE :Ten
        GROUP BY MaLoaiSP, MaMau
    ) AS grouped_sanpham
        ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
    JOIN sanpham 
        ON grouped_sanpham.MaSP = sanpham.MaSP
    WHERE sanpham.TenSP LIKE :Ten";

  $stmt = $pdo4->prepare($sql4);
  $stmt->bindValue(':Ten', '%' . $Ten . '%', PDO::PARAM_STR);
  $stmt->execute();
  $giay4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $pdo4 = NULL;
}
?>

<body class="goto-here">
  <div class="py-1 bg-black">
    <div class="container">
      <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
        <div class="col-lg-12 d-block">
          <div class="row d-flex">
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
              <span class="text">+ 1235 2355 98</span>
            </div>
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
              <span class="text">youremail@email.com</span>
            </div>
            <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
              <span class="text">3-5 Business days delivery &amp; Free Returns</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="TrangChu.php">Minishop</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="TrangChu.php" class="nav-link">Home</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="DanhSachGiay.php" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalog</a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
              <?php
              foreach ($brand0 as $br) {
              ?>
                <a class="dropdown-item" href="DanhSachGiay.php?ml=<?php echo $br['MaBrand'] ?>&tl=<?php echo $br['TenBrand'] ?>" style="text-transform:uppercase; text-decoration:none;"><?php echo $br['TenBrand'] ?></a>
              <?php
              }
              ?>
              <a class="dropdown-item" href="DanhSachGiay.php" style="text-transform:uppercase; text-decoration:none;">Show All</a>
            </div>
          </li>
          <li class="nav-item"><a href="About.php" class="nav-link">About</a></li>
          <li class="nav-item"><a href="Blog.php" class="nav-link">Blog</a></li>
          <li class="nav-item"><a href="Contact.php" class="nav-link">Contact</a></li>
          <form method="get" action="DanhSachGiay.php">
            <input class="form-control mr-1 w-50 px-3 py-1 rounded-pill" style="background-color: transparent;" type="text" placeholder="Search" aria-label="Search" name="txt_Search">
            <div class="d-flex align-items-center">
              <button class="btn btn-outline-dark hover:bg-gray-200 hover:text-gray-800 transition-colors duration-300" style="margin-right:10px;">Search</button>
              <a href="GioHang.php">
                <span class="icon-shopping_cart"></span>
                <?php
                echo (isset($_SESSION['cart']) && count($_SESSION['cart'])) > 0 ? count($_SESSION['cart']) : '';
                ?>
              </a>
            </div>
          </form>
          <?php
          if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['user_name']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="ThongTinKhachHang.php">Thông Tin Cá Nhân</a>
                <a class="dropdown-item" href="LichSuDatHang.php">Lịch Sử Đặt Hàng</a>
                <a class="dropdown-item" href="Logout.php">Logout</a>
              </div>
            </li>
          <?php
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="Login.php">Đăng Nhập</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
          <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
          <h1 class="mb-0 bread">My Wishlist</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-cart">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ftco-animate">
          <div class="cart-list">
            <?php if (empty($_SESSION['cart'])) { ?>
              <table class="table">
                <tr>
                  <td>
                    <p>Your cart is emty</p>
                  </td>
                </tr>
              </table>
            <?php
            } ?>
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
              <table class="table">
                <thead class="thead-primary">
                  <tr class="text-center">
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $totalCounter = 0;
                  $itemCounter = 0;
                  $count = count($_SESSION['cart']);
                  for ($i = 0; $i < $count; $i++) {
                    $item = $_SESSION['cart'][$i];
                    $imgUrl = "AnhSP" . "/" . $item["hinhSP"];
                    $total = (float)$item["giaSP"] * (int)$item["sl"];
                    $totalCounter += $total;
                    $itemCounter += $item["sl"];
                  ?>
                    <tr class="text-center">
                      <td class="product-remove"><a href="GioHang.php?delId=<?php echo $i ?>" class="text-danger"><span class="ion-ios-close"></span></a></td>

                      <td class="image-prod">
                        <img src="<?php echo $imgUrl; ?>" class="img">
                      </td>
                      <td class="product-name">
                        <h3><?php echo $item['tenSP']; ?></h3>
                      </td>
                      <td class="price">$<?php echo $item['giaSP']; ?></td>

                      <td>
                        <form action="GioHang.php" method="get">
                          <input type="hidden" name="updateId" value="<?php echo $i ?>">
                          <input type="number" name="num_sl" class="cart-qty-single" data-item="<?php echo $key ?>" value="<?php echo $item['sl']; ?>" min="1" max="1000">
                          <button type="submit" style=" background-color: transparent; border: none; color: inherit; cursor: pointer; padding: 0;"><i class="gg-pen"></i></button>
                        </form>
                      </td>
                      <td>
                        <?php echo $total; ?>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr class="border-top border-bottom">
                    <td><a class="btn btn-danger btn-sm" href="GioHang.php?emptyCart=1">Clear Cart</a></td>
                    <td></td>
                    <td>
                      <strong>
                        <?php
                        echo ($itemCounter == 1) ? $itemCounter . ' item' : $itemCounter . ' items'; ?>
                      </strong>
                    </td>
                    <td><strong>$<?php echo $totalCounter; ?></strong></td>
                  </tr>
                  </tr>
                </tbody>
              </table>
            <?php } ?>
          </div>
          <br>
          <div class="row">
            <div class="col-md-11">
              <a href="Checkout.php">
                <button class="btn btn-primary btn-lg float-right py-3 px-4">Checkout</button>
              </a>
            </div>
          </div>
  </section>


  <footer class="ftco-footer ftco-section">
    <div class="container">
      <div class="row">
        <div class="mouse">
          <a href="#" class="mouse-icon">
            <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
          </a>
        </div>
      </div>
      <div class="row mb-5">
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Minishop</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4 ml-md-5">
            <h2 class="ftco-heading-2">Menu</h2>
            <ul class="list-unstyled">
              <li><a href="#" class="py-2 d-block">Shop</a></li>
              <li><a href="#" class="py-2 d-block">About</a></li>
              <li><a href="#" class="py-2 d-block">Journal</a></li>
              <li><a href="#" class="py-2 d-block">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Help</h2>
            <div class="d-flex">
              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
              </ul>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">FAQs</a></li>
                <li><a href="#" class="py-2 d-block">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">

          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

  <script>
    $(document).ready(function() {

      var quantitiy = 0;
      $('.quantity-right-plus').click(function(e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        $('#quantity').val(quantity + 1);


        // Increment

      });

      $('.quantity-left-minus').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

        // Increment
        if (quantity > 0) {
          $('#quantity').val(quantity - 1);
        }
      });

    });
  </script>

</body>

</html>