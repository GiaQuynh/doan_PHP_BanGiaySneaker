<?php

ob_start();
session_start();
include('Connect.php');

if (isset($_SESSION['user_name'])) {
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

// Định nghĩa các câu trả lời
$responses = array(
    'hello' => 'Xin chào! Bạn cần tôi giúp đỡ việc gì?',
    'time' => 'Thời gian hiện tại là ' . date('H:i'),
    'default' => 'Xin đợi một chút! Chúng tôi sẽ trả lời tin nhắn của bạn sau'
  );

// Lấy tin nhắn từ người dùng
$message = $_POST['message'] ?? '';

// Xử lý tin nhắn
$response = isset($responses[$message]) ? $responses[$message] : $responses['default'];

// Trả về câu trả lời
echo $response;

$sql = "SELECT er.response
        FROM NhanVien_Rep er
        JOIN messages m ON er.MaMess = m.MaMess
        WHERE m.MaMess = :message_id
        ORDER BY er.created_at DESC
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':message_id', $message_id, PDO::PARAM_INT);
$stmt->execute();
$employeeResponse = $stmt->fetch(PDO::FETCH_COLUMN);

// Display the response
if ($employeeResponse) {
    echo '<div class="employee-response">' . htmlspecialchars($employeeResponse) . '</div>';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (MaUser, message, TrangThaiTN) VALUES (:userId, :message, :status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $status = isset($responses[$message]) ? 'Đã xử lý' : 'Chưa xử lý';
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();
}
?>