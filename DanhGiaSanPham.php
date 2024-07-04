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
} else {
    header("Location: Login.php");
    exit;
}
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

// Lấy danh sách đánh giá sản phẩm
$sql = "SELECT d.TieuDe, d.NoiDung, u.HoTen 
        FROM danhgiasanpham d
        JOIN user u ON d.MaUser = u.MaUser
        WHERE d.MaSP = ?
        ORDER BY d.MaDG DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $maSP);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hiển thị danh sách đánh giá
echo "<h2>Đánh giá sản phẩm</h2>";
if (!empty($result)) {
    foreach ($result as $row) {
        echo "<div class='review'>";
        echo "<h3>" . $row["TieuDe"] . "</h3>";
        echo "<p>" . $row["NoiDung"] . "</p>";
        echo "<p>- " . $row["TenUser"] . "</p>";
        echo "</div>";
    }
} else {
    echo "Chưa có đánh giá nào cho sản phẩm này.";
}

$stmt->closeCursor();
$pdo = null;
?>

<!-- Mẫu form đánh giá sản phẩm -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="maSP" value="<?php echo $maSP; ?>">
    <input type="hidden" name="maUser" value="<?php echo $userId; ?>">
    <label for="tieuDe">Tiêu đề:</label>
    <input type="text" id="tieuDe" name="tieuDe" required>
    <label for="noiDung">Nội dung:</label>
    <textarea id="noiDung" name="noiDung" required></textarea>
    <input type="submit" name="submit" value="Gửi đánh giá">
</form>