<?php
// Kết nối cơ sở dữ liệu
include ('Connect.php');
// Lấy thông tin từ request AJAX
$maDonHang = $_POST['maDonHang'];
$maTrangThai = $_POST['maTrangThai'];

// Cập nhật trạng thái đơn hàng trong cơ sở dữ liệu
$sql = "UPDATE DonHang SET MaTrangThai = :maTrangThai WHERE maDonHang = :maDonHang";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':maTrangThai', $maTrangThai);
$stmt->bindParam(':maDonHang', $maDonHang);
$stmt->execute();

// Trả về kết quả thành công
echo "Cập nhật trạng thái đơn hàng thành công.";
?>