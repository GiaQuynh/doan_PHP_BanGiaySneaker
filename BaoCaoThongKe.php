<?php
// Kết nối đến cơ sở dữ liệu
ob_start();
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $userPhone = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];
}
include('Connect.php');

$sql = "SELECT chitietdonhang.MaSP, TenSP, SUM(SoLuong) AS TongSoLuong, SUM(DonGia*SoLuong) AS TongDoanhThu
            FROM chitietdonhang
            INNER JOIN sanpham on chitietdonhang.masp = sanpham.masp
            GROUP BY chitietdonhang.MaSP";
$result = $pdo->query($sql);

// echo "<h1>Thống kê sản phẩm bán ra</h1>";
// echo "<table>";
// echo "<tr><th>Mã sản phẩm</th><th>Tổng số lượng</th><th>Tổng doanh thu</th></tr>";

// if ($result->rowCount() > 0) {
//     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//         echo "<tr>";
//         echo "<td>" . $row["MaSP"] . "</td>";
//         echo "<td>" . $row["TongSoLuong"] . "</td>";
//         echo "<td>" . $row["TongDoanhThu"] . "</td>";
//         echo "</tr>";
//     }
// } else {
//     echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
// }

// echo "</table>";
?>
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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include('AdminSidebarMenu.php'); ?>

        <div class="main">
            <?php include('AdminNavbarMenu.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"></h1>

                    <h1>Thống kê sản phẩm bán ra</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Tổng số lượng</th>
                                <th>Tổng doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $row["MaSP"] . "</td>";
                                    echo "<td>" . $row["TenSP"] . "</td>";
                                    echo "<td>" . $row["TongSoLuong"] . "</td>";
                                    echo "<td>" . $row["TongDoanhThu"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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