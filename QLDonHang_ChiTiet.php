<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>Blank Page | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php
session_start();
include("Pager.php");
include('Connect.php');

$sql = "select * from DonHang";
$donhang = $pdo->query($sql);

$sql1 = "SELECT *
	FROM DonHang
	INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang";
$donhang0 = $pdo->query($sql1);
// <td><span class="badge bg-success">Done</span></td>
// <td><span class="badge bg-warning">In progress</span></td>

// <td><span class="badge bg-warning">In progress</span></td>
$sta = $pdo->prepare($sql1);
$sta->execute();

if ($sta->rowCount() > 0) {
    $donhang = $sta->fetchAll(PDO::FETCH_OBJ);
}
$p = new Pager();
$limit = 5;
$count = count($donhang);
$vt = $p->findStart($limit);
$pages = $p->findPages($count, $limit);

$cur = $_GET["page"];
$phantrang = $p->pageList($cur, $pages);

$sql1 = "SELECT *
FROM DonHang
INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang
        WHERE DonHang.maDonHang limit $vt, $limit";
$sta = $pdo->prepare($sql1);
$sta->execute();
$donhang1 = $sta->fetchAll(PDO::FETCH_OBJ);

$searchQuery = isset($_GET['Search']) ? $_GET['Search'] : '';


$sql2 = "SELECT *
FROM DonHang
INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang
        WHERE DonHang.maDonHang LIKE :searchQuery
        LIMIT $vt, $limit";
$sta2 = $pdo->prepare($sql2);
$sta2->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
$sta2->execute();
$donhang2 = $sta2->fetchAll(PDO::FETCH_OBJ);

$maDonHang = $_GET["msp"];
$sql = "SELECT *
FROM DonHang
INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang
INNER JOIN SanPham ON SanPham.maSP = ChiTietDonHang.maSP
INNER JOIN Size ON SanPham.maSize = Size.maSize
INNER JOIN TrangThaiDonHang ON DonHang.MaTrangThai = TrangThaiDonHang.MaTrangThai
WHERE DonHang.MaDonHang =" . $maDonHang;
$donhang3 = $pdo->query($sql);
?>

<body>
    <div class="wrapper">
        <?php include('AdminSidebarMenu.php'); ?>

        <div class="main">
            <?php include('AdminNavbarMenu.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Quản Lý Sản Phẩm</h1>

                    <div class="row">
                        <div class="col-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">...</h5>
                                </div>
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Mã Sản Phẩm</th>
                                            <th class="d-none d-xl-table-cell">Hình Ảnh</th>
                                            <th class="d-none d-xl-table-cell">Size</th>
                                            <th class="d-none d-xl-table-cell">Số Lượng</th>
                                            <th class="d-none d-xl-table-cell">Đơn Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['Search'])) {
                                            foreach ($donhang2 as $sp) {
                                        ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $sp['MaSP']; ?></td>
                                            <td class="d-none d-xl-table-cell"><img src="AnhSP/<?php echo $sp['HinhAnhSP']; ?>" class="img-fluid" alt="Colorlib Template" height="100px" width="150px"></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['SoSize']; ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['SoLuong']; ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['DonGia']; ?></td>
                                            <td>
                                                <button class="btn btn-success" type="submit"> <a class="text-light" href="QLDonHang_Sua.php?msp=<?php echo $sp['MaSP']; ?>">Update</a></button>
                                                <button class="btn btn-danger" type="submit"><a class="text-light" href="QLDonHang_Xoa.php?msp=<?php echo $sp['MaSP']; ?>">Delete</a></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                            }
                                        } else {
                                            foreach ($donhang3 as $sp) {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $sp['MaSP']; ?></td>
                                            <td class="d-none d-xl-table-cell"><img src="AnhSP/<?php echo $sp['HinhAnhSP']; ?>" class="img-fluid" alt="Colorlib Template" height="100px" width="150px"></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['SoSize']; ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['SoLuong']; ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $sp['DonGia']; ?></td>
                                        </tr>
                                    </tbody>

                            <?php
                                            }
                                        }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Order ID:</strong> <?php echo $sp['MaDonHang']; ?></p>
                                            <p><strong>Customer ID:</strong> <?php echo $sp['MaUser']; ?></p>
                                            <p><strong>Order Date:</strong> <?php echo $sp['NgayDat']; ?></p>
                                            <p><strong>Payment Method:</strong> <?php echo $sp['HinhThucThanhToan']; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Total Amount:</strong> <?php echo $sp['TongTien']; ?></p>
                                            <p><strong>Deposit Amount:</strong> <?php echo $sp['TienDatCoc']; ?></p>
                                            <p><strong>Outstanding Amount:</strong> <?php echo $sp['TienConLai']; ?></p>
                                            <p><strong>Note:</strong> <?php echo $sp['GhiChu']; ?></p>
                                            <p><strong>Order Status:</strong> <?php echo $sp['TenTrangThai']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            </tbody>
                                </table>
                                <div style="margin:20px; text-align: center;"><?php echo $phantrang; ?></div>
                                <a href="QLDonHang.php"><-Quay lại trang trước</a>
                            </div>

                        </div>
                    </div>

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>