<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>

    <?php include("LinkCss.php"); ?>
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

        body {
            background-color: #f8f9fa;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 100px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
        }

        .card-body {
            padding: 40px;
        }

        .success-icon {
            font-size: 72px;
            color: #28a745;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #6c757d;
        }
    </style>

</head>
<?php
session_start();
include('Connect.php');

require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/class.phpmailer.php';
require 'PHPMailer/class.smtp.php';

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);

$cartItemCount = count($_SESSION['cart']);

if (isset($_POST['submit'])) {
    if (isset($_POST['full_name'], $_POST['email'], $_POST['address']) && !empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['address'])) {
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

        $sql = 'Select count(*) As count from User where Email=' . "'" . $email . "'";

        $statement = $pdo->prepare($sql);
        $statement->execute();
        $kq = $statement->fetch(PDO::FETCH_ASSOC);

        $count = $kq['count'];
        echo "Count: " . $count;

        if ($count == 0) {
            $sql1 = 'INSERT INTO User (MaUser, HoTen, DienThoai, TaiKhoan, MatKhau, Email, DiaChi, Avatar, MaQuyen)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $param = array($CustomerID, $fullName, $phone, $taikhoan, $matkhau, $email, $address, $image, 0);
            $statement = $pdo->prepare($sql1);
            $statement->execute($param);

            $getCustomerId = $pdo->lastInsertId();
            // echo "MAKH: " . $getCustomerId;
        } else {
            $sql2 = 'SELECT * FROM User WHERE Email = :Email';
            $statement = $pdo->prepare($sql2);
            $statement->bindParam(':Email', $email);
            $statement->execute();
            $kq = $statement->fetch(PDO::FETCH_ASSOC);
            $getCustomerId = $kq['MaUser'];
            // echo "MaUser: " . $getCustomerId;
        }
        // Chèn dl  vào hóa đơn
        $MaHD = NULL;
        $MaKH = $getCustomerId;
        $NgayDat = date('Y-m-d');
        $TongTien = $_SESSION['total'];
        unset($_SESSION['total']);
        $TienCoc = 0;
        $ConLai = $TongTien - $TienCoc;
        if (isset($_POST['optradio'])) {
            $HTTH = $_POST['optradio'];
            $_SESSION['HTTH'] = $HTTH;
            $HTTT = $_SESSION['HTTH']; // Gán giá trị HTTH từ session vào HTTT
        }
        $GhiChu = "";
        $TrangThai = "1";

        $sql3 = 'INSERT INTO DonHang (MaDonHang, MaUser, NgayDat, TongTien, TienDatCoc, TienConLai, HinhThucThanhToan, GhiChu, MaTrangThai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $param3 = array($MaHD, $MaKH, $NgayDat, $TongTien, $TienCoc, $ConLai, $HTTT, $GhiChu, $TrangThai);
        $statement = $pdo->prepare($sql3);
        $statement->execute($param3);

        // Chèn dl vào Chi tiết HD
        $getOrderId = $pdo->lastInsertId();
        foreach ($_SESSION['cart'] as $key => $item) {
            $MaSP = $item['maSP'];
            $sl = $item['sl'];
            $donGia = $item['giaSP'];

            $sql4 = 'INSERT INTO ChiTietDonHang VALUES(?,?,?,?)';
            $param4 = array($getOrderId, $MaSP, $sl, $donGia);
            $statement = $pdo->prepare($sql4);
            $statement->execute($param4);
        }


        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tgq.2053@gmail.com';  // Thay đổi với email của bạn
        $mail->Password = 'xzhc ityr ehom clra';     // Thay đổi với mật khẩu ứng dụng của bạn
        $mail->SMTPSecure = 'tls'; // Hoặc 'ssl' nếu bạn sử dụng cổng 465
        $mail->Port = 587; // Cổng 587 cho TLS hoặc 465 cho SSL

        $mail->setFrom('tgq.2053@gmail.com', 'Tran Gia Quynh');
        $mail->addAddress($email, $fullName);

        $mail->isHTML(true);
        $mail->Subject = 'Xác nhận đơn hàng của bạn';
        $mail->Body    = "
    <html>
    <head>
    <title>Xác nhận đơn hàng của bạn</title>
    </head>
    <body>
    <h2>Xin chào $fullName,</h2>
    <p>Cảm ơn bạn đã đặt hàng. Dưới đây là chi tiết đơn hàng của bạn:</p>
    <p><strong>Địa chỉ:</strong> $address</p>
    <p><strong>Số điện thoại:</strong> $phone</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Sản phẩm:</strong></p>
    <ul>";

        $cartItems = $_SESSION['cart'];
        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item['sl'] * $item['giaSP'];
            $total += $subtotal;
        }
        foreach ($cartItems as $cartItem) {
            $mail->Body .= "<li>{$cartItem['tenSP']} - Số lượng: {$cartItem['sl']} - Giá: " . number_format($cartItem['giaSP'], 0, ',', '.') . " VND</li>";
        }

        $mail->Body .= "</ul>
    <p><strong>Tổng cộng:</strong> " . number_format($total, 0, ',', '.') . " VND</p>
    </body>
    </html>";

        if (!$mail->send()) {
            echo 'Không thể gửi email xác nhận. Lỗi: ' . $mail->ErrorInfo;
        } else {
            echo 'Email xác nhận đã được gửi thành công.';
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

    <div class="card">
        <div class="card-header">
            Đặt hàng thành công
        </div>
        <div class="card-body text-center">
            <i class="fas fa-check-circle success-icon"></i>
            <h2>Cảm ơn bạn!</h2>
            <p>Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>

    <?php
    include('footerSection.php');
    include('footer.php');
    include('Loader.php');
    ?>
</body>

</html>