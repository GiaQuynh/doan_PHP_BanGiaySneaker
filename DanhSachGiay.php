<!DOCTYPE html>
<html lang="en">

<head>
	<title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
	</style>

</head>

<?php
session_start();
include('Connect.php');

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);

$pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo->query("set names utf8");

$sql = "Select * From Brand";
$brand = $pdo->query($sql);

$pdo = NULL;

$pdo0 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo0->query("set names utf8");

$sql0 = "Select * From Brand";
$brand0 = $pdo0->query($sql0);

$pdo0 = NULL;

$pdo1 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo1->query("set names utf8");

include("Pager.php");
$sql = "SELECT 
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
$sta = $pdo1->prepare($sql);
$sta->execute();

if ($sta->rowCount() > 0) {
	$giay = $sta->fetchAll(PDO::FETCH_OBJ);
}

$p = new Pager();
$limit = 6;
$count = count($giay);
$vt = $p->findStart($limit);
$pages = $p->findPages($count, $limit);

$cur = $_GET["page"];
$phantrang = $p->pageList($cur, $pages);

$sql = "SELECT 
    sanpham.TenSP, 
    loaisanpham.GiaLoaiSP, 
    sanpham.HinhAnhSP, 
    loaisanpham.MoTa,
    sanpham.MaMau,
    sanpham.MaSize,
    grouped_sanpham.MaSP AS grouped_MaSP,
    loaisanpham.MaLoaiSP
FROM loaisanpham
JOIN (
    SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
    FROM sanpham
    GROUP BY MaLoaiSP, MaMau
) AS grouped_sanpham
ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
JOIN sanpham 
ON grouped_sanpham.MaSP = sanpham.MaSP
LIMIT $vt, $limit";

$sta = $pdo1->prepare($sql);
$sta->execute();
$sanpham = $sta->fetchAll(PDO::FETCH_ASSOC);
$pdo1 = NULL;



$pdo2 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo2->query("set names utf8");

if (isset($_GET['ml'])) {
	if ($_GET["ml"] == NULL) {
		$ml = 0;
	} else {
		$ml = $_GET["ml"];
	}

	$sql2 = "SELECT 
    sanpham.TenSP, 
    loaisanpham.GiaLoaiSP, 
    sanpham.HinhAnhSP, 
    loaisanpham.MoTa,
    sanpham.MaMau,
    sanpham.MaSize,
    grouped_sanpham.MaSP AS grouped_MaSP,
    loaisanpham.MaLoaiSP
FROM loaisanpham
JOIN (
    SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
    FROM sanpham
    GROUP BY MaLoaiSP, MaMau
) AS grouped_sanpham
ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
JOIN sanpham 
ON grouped_sanpham.MaSP = sanpham.MaSP
    WHERE loaisanpham.MaBrand = :brand_id
    LIMIT :vt, :limit";

	$sta = $pdo2->prepare($sql2);
	$sta->bindParam(':brand_id', $ml, PDO::PARAM_INT);

	$p = new Pager();
	$limit = 2;
	$count = $sta->rowCount();
	$vt = $p->findStart($limit);
	$pages = $p->findPages($count, $limit);
	$cur = $_GET["page"] ?? 1;
	$phantrang = $p->pageList($cur, $pages);

	$sta->bindParam(':vt', $vt, PDO::PARAM_INT);
	$sta->bindParam(':limit', $limit, PDO::PARAM_INT);
	$sta->execute();
	$giay2 = $sta->fetchAll(PDO::FETCH_ASSOC);
}

$pdo2 = null;


$pdo5 = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo5->query("set names utf8");

$sql6 = "Select * From MauSac";
$mau = $pdo5->query($sql6);

if (isset($_GET['mm'])) {
	if ($_GET["mm"] == NULL)
		$mm = 0;
	else
		$mm = $_GET["mm"];

	if ($mm == 0)
		$sql5 = "SELECT
        sanpham.MaSP, 
        sanpham.TenSP,
		sanpham.MaLoaiSP,
		sanpham.MaMau,
		sanpham.MaSize, 
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
		$sql5 = "SELECT
        sanpham.MaSP, 
        sanpham.TenSP,
		sanpham.MaLoaiSP,
		sanpham.MaMau,
		sanpham.MaSize,
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
	JOIN mausac
		ON mausac.MaMau = sanpham.MaMau
    WHERE mausac.MaMau = " . $mm;

	$giay5 = $pdo5->query($sql5);
	$pdo5 = NULL;
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
		sanpham.MaLoaiSP,
		sanpham.MaMau,
		sanpham.MaSize,
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
		sanpham.MaLoaiSP,
		sanpham.MaMau,
		sanpham.MaSize,
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
		sanpham.MaLoaiSP,
		sanpham.MaMau,
		sanpham.MaSize, 
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
					<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Shop</span></p>
					<h1 class="mb-0 bread">Shop</h1>
				</div>
			</div>
		</div>
	</div>
	</div>
	<section class="ftco-section bg-light">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-10 order-md-last">
					<div class="row">
						<?php
						if (isset($_GET['ml']) && isset($_GET['tl'])) {
						?>
							<div class="row">
								<?php
								foreach ($giay2 as $giay) {
								?>
									<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
										<div class="product d-flex flex-column">
											<a href="#" class="img-prod"><img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" alt="Colorlib Template" />
												<div class="overlay"></div>
											</a>
											<div class="text py-3 pb-4 px-3">
												<h3><a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?>">
														<?php echo $giay['TenSP']; ?></a></h3>
												<div class="pricing">
													<p class="price"><span><?php echo $giay['GiaLoaiSP']; ?> VNĐ</span></p>
												</div>
												<p class="bottom-area d-flex px-3">
													<a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?>" class="buy-now text-center py-2">
														Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
												</p>
											</div>
										</div>
									</div>
								<?php
								}

								?>
							</div>

							<div class="row" style="margin:20px; text-align: center;"><?php echo $phantrang; ?></div>
							<?php
						} else if (isset($_GET['mm']) && isset($_GET['tl'])) {
							foreach ($giay5 as $giay) {
							?>
								<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
									<div class="product d-flex flex-column">
										<a href="#" class="img-prod"><img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" alt="Colorlib Template" />
											<div class="overlay"></div>
										</a>
										<div class="text py-3 pb-4 px-3">
											<h3><a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> "><?php echo $giay['TenSP']; ?></a></h3>
											<div class="pricing">
												<p class="price"><span><?php echo $giay['GiaLoaiSP']; ?> VNĐ</span></p>
											</div>
											<p class="bottom-area d-flex px-3">
												<a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> " class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
											</p>
										</div>
									</div>
								</div>
							<?php
							}
						} else if (isset($_GET['gt']) && isset($_GET['gc'])) {
							foreach ($giay3 as $giay) {
							?>
								<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
									<div class="product d-flex flex-column">
										<a href="#" class="img-prod"><img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" alt="Colorlib Template" />
											<div class="overlay"></div>
										</a>
										<div class="text py-3 pb-4 px-3">
											<h3><a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> "><?php echo $giay['TenSP']; ?></a></h3>
											<div class="pricing">
												<p class="price"><span><?php echo $giay['GiaLoaiSP']; ?> VNĐ</span></p>
											</div>
											<p class="bottom-area d-flex px-3">
												<a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> " class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
											</p>
										</div>
									</div>
								</div>
							<?php
							}
						} elseif (isset($_GET['txt_Search'])) {
							foreach ($giay4 as $giay) {
							?>
								<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
									<div class="product d-flex flex-column">
										<a href="#" class="img-prod"><img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" alt="Colorlib Template" />
											<div class="overlay"></div>
										</a>
										<div class="text py-3 pb-4 px-3">
											<h3><a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> "><?php echo $giay['TenSP']; ?></a></h3>
											<div class="pricing">
												<p class="price"><span><?php echo $giay['GiaLoaiSP']; ?> VNĐ</span></p>
											</div>
											<p class="bottom-area d-flex px-3">
												<a href="ChiTietGiay.php?id=<?php echo $giay['MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?> " class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
											</p>
										</div>
									</div>
								</div>
							<?php
							}
						} else {
							?>
							<div class="row">
								<?php
								foreach ($sanpham as $giay) {
								?>
									<div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
										<div class="product d-flex flex-column">
											<a href="#" class="img-prod"><img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" alt="Colorlib Template" />
												<div class="overlay"></div>
											</a>
											<div class="text py-3 pb-4 px-3">
												<h3><a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?>">
														<?php echo $giay['TenSP']; ?></a></h3>
												<div class="pricing">
													<p class="price"><span><?php echo $giay['GiaLoaiSP']; ?> VNĐ</span></p>
												</div>
												<p class="bottom-area d-flex px-3">
													<a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP'] ?>&idL=<?php echo $giay['MaLoaiSP'] ?>&idM=<?php echo $giay['MaMau'] ?>&idS=<?php echo $giay['MaSize'] ?>" class="buy-now text-center py-2">
														Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
												</p>
											</div>
										</div>
									</div>
								<?php
								}

								?>
							</div>

							<div class="row" style="margin:20px; text-align: center;"><?php echo $phantrang; ?></div>
						<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-4 col-lg-2">
					<div class="sidebar">
						<div class="sidebar-box-2">
							<h2 class="heading">Categories</h2>
							<div class="fancy-collapse-panel">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingOne">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Brands
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">
												<ul>
													<?php
													foreach ($brand as $br) {
													?>
														<li class="list-group-item bg-light"><a href="DanhSachGiay.php?ml=<?php echo $br['MaBrand'] ?>&tl=<?php echo $br['TenBrand'] ?>" style="text-transform:uppercase; text-decoration:none;"><?php echo $br['TenBrand'] ?></a></li>
													<?php
													}
													?>
													<li class="list-group-item bg-light"><a href="DanhSachGiay.php" style="text-transform:uppercase; text-decoration:none;">SHOW ALL</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingFour">
											<h4 class="panel-title">
												<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">Colors
												</a>
											</h4>
										</div>
										<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
											<div class="panel-body">
												<ul>
													<?php
													foreach ($mau as $br) {
													?>
														<li class="list-group-item bg-light"><a href="DanhSachGiay.php?mm=<?php echo $br['MaMau'] ?>&tl=<?php echo $br['TenMau'] ?>" style="text-transform:uppercase; text-decoration:none;"><?php echo $br['TenMau'] ?></a></li>
													<?php
													}
													?>
													<li class="list-group-item bg-light"><a href="DanhSachGiay.php?ml=0&tl=TẤT CẢ CÁC THƯƠNG HIỆU" style="text-transform:uppercase; text-decoration:none;">SHOW ALL</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="sidebar-box-2">
							<h2 class="heading">Price Range</h2>
							<form method="post" class="colorlib-form-2">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="price-from">Price from:</label>
											<div class="form-field">
												<i class="icon icon-arrow-down3"></i>
												<select name="price-from" id="price-from" class="form-control">
													<option value="1000000">1,000,000</option>
													<option value="2000000">2,000,000</option>
													<option value="3000000">3,000,000</option>
													<option value="4000000">4,000,000</option>
													<option value="10000000">10,000,000</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="price-to">Price to:</label>
											<div class="form-field">
												<i class="icon icon-arrow-down3"></i>
												<select name="price-to" id="price-to" class="form-control">
													<option value="1000000">1,000,000</option>
													<option value="2000000">2,000,000</option>
													<option value="3000000">3,000,000</option>
													<option value="4000000">4,000,000</option>
													<option value="10000000">10,000,000</option>
												</select>
											</div>
										</div>
									</div>
									<a href="#" onclick="filterByPrice()">Filter</a>

									<script>
										function filterByPrice() {
											const priceFrom = document.getElementById('price-from').value;
											const priceTo = document.getElementById('price-to').value;
											window.location.href = `DanhSachGiay.php?gt=${priceFrom}&gc=${priceTo}`;
										}
									</script>
									<script>
										function updateLink() {
											var select1 = document.getElementById("Pricefrom");
											var select2 = document.getElementById("Priceto");
											var link = document.getElementById("dynamicLink");
											link.href = "DanhSachGiay.php?gt=" + select1.value + "&gc=" + select2.value;
										}
									</script>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	include("FooterSection.php");
	include("Footer.php");

	include("Loader.php");
	?>

</body>

</html>