<!DOCTYPE html>
<html lang="en">

<head>
  <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php
  include('LinkCss.php');
  ?>

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
session_start();
include('Connect.php');

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);

$cartItemCount = count($_SESSION['cart']);

// Tạo kết nối
try {
  $pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
  $pdo->query("set names utf8");
} catch (PDOException $ex) {
  echo "Lỗi kết nối" . $ex->getMessage();
  die();
}

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);

if (isset($_SESSION['user_id'])) {
  // Lấy thông tin khách hàng từ session
  $userId = $_SESSION['user_id'];
  $userName = $_SESSION['user_name'];
  $userEmail = $_SESSION['user_email'];
  $userPhone = $_SESSION['user_phone'];
  $userAddress = $_SESSION['user_address'];

  // // Hiển thị thông tin khách hàng
  // echo "Mã khách hàng: " . $userId . "<br>";
  // echo "Tên khách hàng: " . $userName . "<br>";
  // echo "Email: " . $userEmail . "<br>";
  // echo "Số điện thoại: " . $userPhone . "<br>";
  // echo "Địa chỉ: " . $userAddress . "<br>";

  $CustomerID = $userId;
  $fullName  = $userName;
  $email     = $userEmail;
  $address   = $userAddress;
  $phone  = $userPhone;
  $image  = ""; //$_FILES["image"]["error"]==0 ? $_FILES["image"]["name"] : "";
  $note =  "";
} else {
  // Nếu khách hàng chưa đăng nhập, chuyển hướng về trang đăng nhập
  header("Location: Login.php");
  exit;
}

if (isset($_POST['full_name'], $_POST['email'], $_POST['address']) && !empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['address'])) {
  if (isset($_POST['submit'])) {
    if (isset($_SESSION['user_id'])) {
      // Lấy thông tin khách hàng từ session
      $userId = $_SESSION['user_id'];
      $userName = $_SESSION['user_id'];
      $userEmail = $_SESSION['user_email'];
      $userPhone = $_SESSION['user_phone'];
      $userAddress = $_SESSION['user_address'];

      $CustomerID = $_SESSION['user_id'];
      $fullName  = $_SESSION['user_id'];
      $email     = $_SESSION['user_email'];
      $address   = $_SESSION['user_address'];
      $phone  = $_SESSION['user_phone'];
    } else {
      $CustomerID = "NULL";
      $fullName  = $_POST['full_name'];
      $email     = $_POST['email'];
      $address   = $_POST['address'];
      $phone  = $_POST['phone'];
    }



    $sql = 'Select count(*) As count from user where email=' . "'" . $email . "'";

    $statement = $pdo->prepare($sql);
    $statement->execute();
    $kq = $statement->fetch(PDO::FETCH_ASSOC);

    $count = $kq['count'];
    // echo "Count: " . $count;

    if ($count == 0) {
      $sql1 = 'INSERT INTO khach_hang VALUES(?, ?, ?, ?, ?, ?, ?)';
      $param = array($CustomerID, $fullName, $email, $address,  $phone, $image, $note);
      $statement = $pdo->prepare($sql1);
      $statement->execute($param);

      $getCustomerId = $pdo->lastInsertId();
      //  echo "MAKH: ".$getCustomerId;
    } else {
      $sql2 = 'SELECT * FROM khach_hang WHERE email = :email'; // chống SQL injection
      $statement = $pdo->prepare($sql2);
      $statement->bindParam(':email', $email); // chống SQL injection
      $statement->execute();
      $kq = $statement->fetch(PDO::FETCH_ASSOC);
      $getCustomerId = $kq['ma_khach_hang'];
      //   echo "MAKH: ".$getCustomerId;
    }
    // Chèn dl  vào hóa đơn
    $MaHD = NULL;
    $MaKH = $getCustomerId;
    $NgayDat = date('Y-m-d');
    $TongTien = $_SESSION['total'];
    unset($_SESSION['total']);
    $TienCoc = 0;
    $ConLai = $TongTien - $TienCoc;
    $HTTT = "Tiền Mặt";
    $GhiChu = "";

    $sql3 = 'INSERT INTO hoa_don VALUES(?,?,?,?,?,?,?,?)';
    $param3 = array($MaHD, $MaKH, $NgayDat, $TongTien, $TienCoc, $ConLai, $HTTT, $GhiChu);
    $statement = $pdo->prepare($sql3);
    $statement->execute($param3);

    // Chèn dl vào Chi tiết HD
    $getOrderId = $pdo->lastInsertId();
    foreach ($_SESSION['cart'] as $key => $item) {
      $MaMon = $item['maMon'];
      $sl = $item['sl'];
      $donGia = $item['donGia'];
      $monThucDon = 1;

      $sql4 = 'INSERT INTO chi_tiet_hoa_don VALUES(?,?,?,?,?)';
      $param4 = array($getOrderId, $MaMon, $sl, $donGia, $monThucDon);
      $statement = $pdo->prepare($sql4);
      $statement->execute($param4);
    }


    // Giải phóng biến giỏ hàng
    unset($_SESSION['cart']);
    $pdo = NULL;
  }
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
          <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Checkout</span></p>
          <h1 class="mb-0 bread">Checkout</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 ftco-animate">
          <form method="POST" action="ThongBaoDatHang.php" class="billing-form">
            <h3 class="mb-4 billing-heading">Billing Details</h3>
            <div class="row align-items-end">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="fullName">Họ Tên</label>
                  <input type="text" class="form-control" id="fullName" name="full_name" value="<?php echo $userName; ?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="address">Địa chỉ</label>
                  <input type="text" class="form-control" id="address" name="address" value="<?php echo $userAddress; ?>">
                </div>
              </div>
              <div class="w-100"></div>
              <!-- <div class="col-md-4">
                <div class="form-group">
                  <label for="country">Tỉnh / Thành</label>
                  <div class="select-wrap">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select name="" id="" class="form-control">
                      <option value="">France</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="country">Quận / Huyện</label>
                  <div class="select-wrap">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select name="" id="" class="form-control">
                      <option value="">France</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="country">Phường / Xã</label>
                  <div class="select-wrap">
                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                    <select name="" id="" class="form-control">
                      <option value="">France</option>
                    </select>
                  </div>
                </div>
              </div> -->
              <div class="w-100"></div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address">Số Điện Thoại</label>
                  <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userPhone; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $userEmail; ?>">
                </div>
              </div>
              <div class="w-100"></div>
              <!-- <div class="col-md-12">
                <div class="form-group mt-4">
                  <div class="radio">
                    <label class="mr-3"><input type="radio" name="optradio"> Create an Account? </label>
                    <label><input type="radio" name="optradio"> Ship to different address</label>
                  </div>
                </div> -->
            </div>
        </div>

        <div class="row mt-5 pt-3 d-flex">
          <div class="col-md-6 d-flex">
            <div class="cart-detail cart-total bg-light p-3 p-md-4">
              <h3 class="billing-heading mb-4 d-flex justify-content-between align-items-center">
                Cart Total
                <span class="badge badge-secondary badge-pill"><?php echo $cartItemCount; ?></span>

              </h3>
              <ul class="list-group mb-3">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $key => $cartItem) {
                  $total += $cartItem['sl'] * $cartItem['giaSP'];
                ?>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      <h6 class="my-0"><?php echo $cartItem['tenSP'] ?></h6>
                      <small class="text-muted">Quantity: <?php echo $cartItem['sl'] ?></small><br>
                      <small class="text-muted">Price: <?php echo $cartItem['giaSP'] ?></small>
                    </div>
                    <span class="text-muted">$<?php echo $cartItem['sl'] * $cartItem['giaSP'] ?></span>
                  </li>
                <?php
                }
                ?>

                <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>$<?php echo number_format($total, 2);
                            $_SESSION['total'] = $total; ?></strong>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="cart-detail bg-light p-3 p-md-4">
              <h3 class="billing-heading mb-4">Payment Method</h3>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optradio" class="mr-2" value="ChuyenKhoan" <?php if (isset($_SESSION['HTTH']) && $_SESSION['HTTH'] == 'ChuyenKhoan') echo 'checked'; ?>> Thanh Toán Online
                      <div id="payment-image" style="display: none;">
                        <img src="AnhSP/QR.jpg" height="220px" width="180px" alt="Payment Image">
                      </div>
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <div class="radio">
                    <label>
                      <input type="radio" name="optradio" class="mr-2" value="TienMat" <?php if (isset($_SESSION['HTTH']) && $_SESSION['HTTH'] == 'TienMat') echo 'checked'; ?>> Thanh Toán Khi Nhận Hàng
                    </label>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group">
                    <div class="col-md-12">
                      <div class="checkbox">
                        <label><input type="checkbox" value="" class="mr-2"> I have read and accept the terms and conditions</label>
                      </div>
                    </div>
                  </div> -->
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="submit">Tiếp tục thanh toán</button>
            </div>
          </div>
        </div>
        </form><!-- END -->
      </div> <!-- .col-md-8 -->
    </div>
    </div>
  </section> <!-- .section -->


  <?php
  include('Footer.php');
  include('Loader.php');
  ?>;

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

    // Lấy các radio button
    var paymentOptions = document.getElementsByName('optradio');

    // Lắng nghe sự kiện 'change' trên các radio button
    for (var i = 0; i < paymentOptions.length; i++) {
      paymentOptions[i].addEventListener('change', function() {
        var paymentImageDiv = document.getElementById('payment-image');

        // Nếu radio "Thanh Toán Online" được check, hiển thị image
        if (this.value === 'ChuyenKhoan') {
          paymentImageDiv.style.display = 'block';
        } else {
          // Nếu không, ẩn image
          paymentImageDiv.style.display = 'none';
        }
      });
    }
  </script>

</body>

</html>