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

if (isset($_SESSION['user_name'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $userPhone = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];
    // Xử lý đánh giá sản phẩm
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $maSP = $_POST["maSP"];
        $userId = $_POST["maUser"];
        $tieuDe = $_POST["tieuDe"];
        $noiDung = $_POST["noiDung"];

        $sql = "INSERT INTO danhgiasanpham (MaSP, MaUser, TieuDe, NoiDung) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $maSP);
        $stmt->bindParam(2, $userId);
        $stmt->bindParam(3, $tieuDe);
        $stmt->bindParam(4, $noiDung);

        if ($stmt->execute()) {
            echo "Đánh giá sản phẩm thành công.";
        } else {
            echo "Đã xảy ra lỗi khi đánh giá sản phẩm: " . $stmt->errorInfo()[2];
        }
        $stmt->closeCursor();
    }
} else {
    echo "Vui lòng đăng nhập để đánh giá sản phẩm!";
}

$maSP = $_GET["id"];
// Lấy danh sách đánh giá sản phẩm
$sql = "SELECT d.TieuDe, d.NoiDung, u.HoTen, d.NgayDanhGia
        FROM danhgiasanpham d
        JOIN user u ON d.MaUser = u.MaUser
        WHERE d.MaSP = ?
        ORDER BY d.MaDG DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $maSP);
$stmt->execute();
$danhgias = $stmt->fetchAll(PDO::FETCH_ASSOC);




$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);


$sql = "select * from LoaiSanPham, SanPham, Size where Size.MaSize = SanPham.MaSize AND LoaiSanPham.MaLoaiSP = SanPham.MaLoaiSP AND MaSP =" . $maSP;
$giay = $pdo->query($sql);

if (isset($_GET['idL']) && isset($_GET['idM'])) {
    $maL = $_GET["idL"];
    $maM = $_GET["idM"];
    $sql1 = "SELECT sp.*, s.*
    FROM sanpham sp
    INNER JOIN size s ON sp.MaSize = s.MaSize
    INNER JOIN loaisanpham lsp ON sp.MaLoaiSP = lsp.MaLoaiSP
    WHERE sp.MaLoaiSP = $maL AND sp.MaMau = $maM AND sp.MaLoaiSP = $maL";

    $giay1 = $pdo->query($sql1);
}


// Ensure database connection is established
if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") {
    $MaUser = $_SESSION['user_id'];

    // Check if cart exists for the user
    $sql = "SELECT COUNT(*) AS count FROM GioHang WHERE MaUser = :MaUser";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':MaUser', $MaUser);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    // Create a new cart if it doesn't exist
    if ($count == 0) {
        $sql3 = "INSERT INTO GioHang (MaGio, MaUser) VALUES (NULL, :MaUser)";
        $statement = $pdo->prepare($sql3);
        $statement->bindParam(':MaUser', $MaUser);
        if ($statement->execute()) {
            $getGioId = $pdo->lastInsertId();
        } else {
            // Handle error when creating a new cart
            echo "Error creating a new cart.";
        }
    } else {
        $sql2 = "SELECT MaGio FROM GioHang WHERE MaUser = :MaUser";
        $statement = $pdo->prepare($sql2);
        $statement->bindParam(':MaUser', $MaUser);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $getGioId = $result['MaGio'];
    }

    // Insert cart items
    if (isset($_POST['add_to_cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $MaSP = $item['maSP'];
            $sl = $item['sl'];
            $donGia = $item['giaSP'];

            $sql4 = "INSERT INTO ChiTietGioHang (MaGio, MaSP, SoLuong, DonGia) VALUES (:MaGio, :MaSP, :sl, :donGia)";
            $statement = $pdo->prepare($sql4);
            $statement->bindParam(':MaGio', $getGioId);
            $statement->bindParam(':MaSP', $MaSP);
            $statement->bindParam(':sl', $sl);
            $statement->bindParam(':donGia', $donGia);
            if (!$statement->execute()) {
                // Handle error when inserting cart items
                echo "Error adding item to the cart.";
            }
        }
    }
} else {

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
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Shop</span></p>
                    <h1 class="mb-0 bread">Shop</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <?php foreach ($giay as $giayy) {
                ?>
                    <div class="col-lg-6 mb-5 ftco-animate">
                        <a href="AnhSP/<?php echo $giayy['HinhAnhSP']; ?>" class="image-popup prod-img-bg"><img src="AnhSP/<?php echo $giayy['HinhAnhSP']; ?>" class="img-fluid" alt="Colorlib Template"></a>
                    </div>
                    <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                        <h3><?php echo $giayy['TenSP']; ?></h3>
                        <div class="rating d-flex">
                            <p class="text-left mr-4">
                                <a href="#" class="mr-2">5.0</a>
                                <a href="#"><span class="ion-ios-star-outline"></span></a>
                                <a href="#"><span class="ion-ios-star-outline"></span></a>
                                <a href="#"><span class="ion-ios-star-outline"></span></a>
                                <a href="#"><span class="ion-ios-star-outline"></span></a>
                                <a href="#"><span class="ion-ios-star-outline"></span></a>
                            </p>
                            <p class="text-left mr-4">
                                <a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>
                            </p>
                            <p class="text-left">
                                <a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>
                            </p>
                        </div>
                        <p class="price"><span><?php echo $giayy['GiaLoaiSP'] ?></span></p>
                        <p><?php echo $giayy['MoTa'] ?></p>
                        </p>
                        <p>Size: <?php echo $giayy['SoSize'] ?></p>
                        <div class="row mt-4">Các size khác:
                            <?php
                            foreach ($giay1 as $giayy1) {
                            ?>
                                <center><a class="btn btn-primary mb-2" href="ChiTietGiay.php?id=<?php echo $giayy1['MaSP'] ?>&idL=<?php echo $giayy1['MaLoaiSP'] ?>&idM=<?php echo $giayy1['MaMau'] ?>&idS=<?php echo $giayy1['SoSize'] ?> "> <?php echo $giayy1['SoSize'] ?></a></center>
                            <?php
                            }
                            ?>

                        <?php } ?>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <p style="color: #000;">Số lượng còn: <?php echo $giayy['SoLuongTon'] ?></p>
                        </div>
                        </div>
                        <form class="form-inline" method="POST" action="GioHang.php">
                            <div class="form-group mb-2" style="margin-right:10px;">
                                <input type="hidden" name="maSP" value="<?php echo $giayy['MaSP'] ?>">
                                <input type="hidden" name="hinhSP" value="<?php echo $giayy['HinhAnhSP'] ?>">
                                <input type="hidden" name="tenSP" value="<?php echo $giayy['TenSP'] ?>">
                                <input type="hidden" name="giaSP" value="<?php echo $giayy['GiaLoaiSP'] ?>">
                                <div class="input-group col-md-6 d-flex mb-3">
                                    <span class="input-group-btn mr-2">
                                        <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                            <i class="ion-ios-remove"></i>
                                        </button>
                                    </span>
                                    <input type="text" id="quantity" name="sl" class="quantity form-control input-number" value="1" min="1" max="100">
                                    <span class="input-group-btn ml-2">
                                        <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                            <i class="ion-ios-add"></i>
                                        </button>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary" name="add_to_cart" value="add_to_cart">CHO VÀO GIỎ</button>
                            </div>
                        </form>
                    </div>
            </div>




            <div class="row mt-5">
                <div class="col-md-12 nav-link-wrap">
                    <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Description</a>

                        <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Manufacturer</a>

                        <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reviews</a>

                    </div>
                </div>
                <div class="col-md-12 tab-wrap">

                    <div class="tab-content bg-light" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
                            <div class="p-4">
                                <h3 class="mb-4"><?php echo $giayy['TenSP'] ?></h3>
                                <p><?php echo $giayy['MoTa'] ?></p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
                            <div class="p-4">
                                <h3 class="mb-4">Manufactured By Nike</h3>
                                <p><?php echo $giayy['MoTa'] ?></p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
                            <div class="row p-4">
                                <div class="col-md-7">
                                    <h3 class="mb-4">Reviews</h3>
                                    <div class="review-form">
                                        <form method="post" action="ChiTietGiay.php?id=<?php echo $giayy['MaSP'] ?>&idL=<?php echo $giayy['MaLoaiSP'] ?>&idM=<?php echo $giayy['MaMau'] ?>&idS=<?php echo $giayy['MaSize'] ?> ">
                                            <input type="hidden" name="maSP" value="<?php echo $_GET['id']; ?>">
                                            <input type="hidden" name="maUser" value="<?php echo $userId; ?>">
                                            <div class="form-group">
                                                <label for="tieuDe">Tiêu đề:</label>
                                                <input type="text" class="form-control" id="tieuDe" name="tieuDe" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="noiDung">Nội dung:</label>
                                                <textarea class="form-control" id="noiDung" name="noiDung" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="submit">Gửi đánh giá</button>
                                        </form>
                                    </div>
                                    <div class="review-list">
                                        <?php
                                        foreach ($danhgias as $danhgia) {
                                        ?>
                                            <div class="review card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="font-weight-light mb-1">
                                                            <?php echo $danhgia['HoTen'] ?>
                                                        </p>
                                                        <small class="text-muted"><?php echo $danhgia['NgayDanhGia'] ?></small>
                                                    </div>
                                                    <h3 class="card-title"><?php echo $danhgia['TieuDe'] ?></h3>
                                                    <p class="card-text font-weight-light">
                                                        <?php echo $danhgia['NoiDung'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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



    <?php include('Loader.php'); ?>

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