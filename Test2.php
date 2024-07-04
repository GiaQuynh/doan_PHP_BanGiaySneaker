<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
    $pdo->query("set names utf8");
} catch (PDOException $ex) {
    echo "Loi ket noi!" . $ex->getMessage();
    die();
}
if (isset($_GET['filterByStatus'])) {
    $filterByStatus = $_GET['filterByStatus'];

    $sql1 = "SELECT DonHang.maDonHang, DonHang.MaUser, DonHang.NgayDat, DonHang.HinhThucThanhToan, DonHang.TongTien, DonHang.TienDatCoc, DonHang.TienConLai, DonHang.GhiChu, TrangThaiDonHang.TenTrangThai, TrangThaiDonHang.MaTrangThai
		FROM DonHang
		INNER JOIN TrangThaiDonHang ON DonHang.MaTrangThai = TrangThaiDonHang.MaTrangThai
		WHERE TrangThaiDonHang.TenTrangThai = 'Đang xử lý'";

    $sta1 = $pdo->prepare($sql1);
    $sta1->execute();
    $donhang3 = $sta1->fetchAll(PDO::FETCH_OBJ);
    foreach ($donhang3 as $order) {
        echo "<tr>";
        echo "<td>" . $order->maDonHang . "</td>";
        echo "<td>" . $order->MaUser . "</td>";
        echo "<td>" . $order->NgayDat . "</td>";
        echo "<td>" . $order->HinhThucThanhToan . "</td>";
        echo "<td>" . $order->TongTien . "</td>";
        echo "<td>" . $order->TienDatCoc . "</td>";
        echo "<td>" . $order->TienConLai . "</td>";
        echo "<td>" . $order->GhiChu . "</td>";
        echo "<td>" . $order->TenTrangThai . "</td>";
    }
}
