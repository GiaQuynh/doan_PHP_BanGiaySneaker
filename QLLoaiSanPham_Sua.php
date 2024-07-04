<?php
// Connect to the database using the Connect.php file
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $MaBrand = $_POST['MaBrand'];
    $TenLoaiSP = $_POST['TenLoaiSP'];
    $GiaLoaiSP = $_POST['GiaLoaiSP'];
    $MoTa = $_POST['MoTa'];

    // Update the product in the database
    $sql = "UPDATE LoaiSanPham
            SET MaBrand = :MaBrand, TenLoaiSP = :TenLoaiSP, GiaLoaiSP = :GiaLoaiSP, MoTa = :MoTa
            WHERE MaLoaiSP = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':MaBrand', $MaBrand);
    $stmt->bindParam(':TenLoaiSP', $TenLoaiSP);
    $stmt->bindParam(':GiaLoaiSP', $GiaLoaiSP);
    $stmt->bindParam(':MoTa', $MoTa);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect the user to the product management page
    header('Location: QLLoaiSanPham.php');
    exit;
} else {
    // Get the product details to be edited
    $id = $_GET['msp'];
    $sql = "SELECT *
            FROM LoaiSanPham
            INNER JOIN Brand ON Brand.MaBrand = Brand.MaBrand
            WHERE LoaiSanPham.MaLoaiSP = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý Sản Phẩm - Sửa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Sửa Sản Phẩm</h1>
        <form method="post" action="QLLoaiSanPham_Sua.php">
            <input type="hidden" name="id" value="<?php echo $product['MaLoaiSP']; ?>">
            <div class="form-group">
                <label for="MaBrand">Mã Brand</label>
                <select class="form-control" id="MaBrand" name="MaBrand">
                    <?php
                    // Fetch the list of product categories from the database
                    $sql = "SELECT * FROM Brand";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['MaBrand'] == $product['MaBrand']) ? 'selected' : '';
                        echo "<option value='{$row['MaBrand']}' $selected>{$row['TenBrand']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="TenLoaiSP">Tên Loại Sản Phẩm</label>
                <input type="text" class="form-control" id="TenLoaiSP" name="TenLoaiSP" value="<?php echo $product['TenLoaiSP']; ?>">
            </div>
            <div class="form-group">
                <label for="GiaLoaiSP">Giá Loại Sản Phẩm</label>
                <input type="text" class="form-control" id="GiaLoaiSP" name="GiaLoaiSP" value="<?php echo $product['GiaLoaiSP']; ?>">
            </div>
            <div class="form-group">
                <label for="MoTa">Mô Tả</label>
                <input type="text" class="form-control" id="MoTa" name="MoTa" value="<?php echo $product['MoTa']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="QLLoaiSanPham.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>