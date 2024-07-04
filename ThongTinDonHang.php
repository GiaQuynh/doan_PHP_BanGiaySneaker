<!DOCTYPE html>
<html lang="en">

<head>
    <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('LinkCss.php'); ?>
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
ob_start();
session_start();
include('Connect.php');

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);
// Kiểm tra xem khách hàng đã đăng nhập chưa
if (isset($_SESSION['user_id'])) {
    // Lấy thông tin khách hàng từ session
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $userPhone = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];
} else {
    // Nếu khách hàng chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: Login.php");
    exit;
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
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Thông Tin Cá Nhân</span></p>
                    <h1 class="mb-0 bread">Thông Tin Cá Nhân</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="customer-id" class="col-sm-4 col-form-label">Customer ID:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="customer-id"><?php echo $userId; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer-name" class="col-sm-4 col-form-label">Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="customer-name"><?php echo $userName; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer-email" class="col-sm-4 col-form-label">Email:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="customer-email"><?php echo $userEmail; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer-phone" class="col-sm-4 col-form-label">Phone:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="customer-phone"><?php echo $userPhone; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customer-address" class="col-sm-4 col-form-label">Address:</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="customer-address"><?php echo $userAddress; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footerSection.php');
    include('footer.php');
    include('Loader.php');
    ?>
</body>

</html>