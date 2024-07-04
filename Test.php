<?php
// Kết nối đến cơ sở dữ liệu
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
    $pdo->query("set names utf8");
} catch (PDOException $ex) {
    echo "Loi ket noi!" . $ex->getMessage();
    die();
}

$filterByStatus = isset($_GET['filterByStatus']) ? $_GET['filterByStatus'] : '';

$sql = "SELECT * FROM DonHang INNER JOIN TrangThaiDonHang ON TrangThaiDonHang.MaTrangThai = DonHang.MaTrangThai";
if ($filterByStatus == 'processing') {
    $sql .= " WHERE TrangThaiDonHang.TenTrangThai = 'Đang xử lý'";
}
if ($filterByStatus == 'shipped') {
    $sql .= " WHERE TrangThaiDonHang.TenTrangThai = 'Đang giao hàng'";
}
if ($filterByStatus == 'delivered') {
    $sql .= " WHERE TrangThaiDonHang.TenTrangThai = 'Đã giao hàng'";
}
if ($filterByStatus == 'success') {
    $sql .= " WHERE TrangThaiDonHang.TenTrangThai = 'Thành Công'";
}
if ($filterByStatus == 'fail') {
    $sql .= " WHERE TrangThaiDonHang.TenTrangThai = 'Thất Bại'";
}


$result = $pdo->query($sql);

// Hiển thị kết quả
if ($result->rowCount() > 0) {
    $donhang3 = $result->fetchAll(PDO::FETCH_OBJ);
    foreach ($donhang3 as $order) {
        echo "<tr>";
        echo "<td>" . $order->MaDonHang . "</td>";
        echo "<td>" . $order->MaUser . "</td>";
        echo "<td>" . $order->NgayDat . "</td>";
        echo "<td>" . $order->HinhThucThanhToan . "</td>";
        echo "<td>" . $order->TongTien . "</td>";
        echo "<td>" . $order->TienDatCoc . "</td>";
        echo "<td>" . $order->TienConLai . "</td>";
        echo "<td>" . $order->GhiChu . "</td>";
        echo "<td>" . $order->TenTrangThai . "</td>";
    }
} else {
    echo "No results found.";
}

$pdo = null;
?>

<form method="GET">
    <label for="filterByStatus">Filter by status:</label>
    <select name="filterByStatus" id="filterByStatus">
        <option value="">All</option>
        <option value="processing">processing</option>
        <option value="shipped">Shipped</option>
        <option value="delivered">Delivered</option>
        <option value="success">success</option>
        <option value="fail">fail</option>
    </select>
    <button type="submit">Filter</button>
</form>