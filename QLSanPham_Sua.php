<?php
// Connect to the database using the Connect.php file
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $tenSP = $_POST['tenSP'];
    $loaiSP = $_POST['loaiSP'];
    $mau = $_POST['mau'];
    $size = $_POST['size'];
    $soLuong = $_POST['soLuong'];
    $hinhAnh = $_POST['hinhAnh'];

    // Update the product in the database
    $sql = "UPDATE SanPham
            SET TenSP = :tenSP, MaLoaiSP = :loaiSP, MaMau = :mau, MaSize = :size, SoLuongTon = :soLuong, HinhAnhSP = :hinhAnh
            WHERE MaSP = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tenSP', $tenSP);
    $stmt->bindParam(':loaiSP', $loaiSP);
    $stmt->bindParam(':mau', $mau);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':soLuong', $soLuong);
    $stmt->bindParam(':hinhAnh', $hinhAnh);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect the user to the product management page
    header('Location: QLSanPham.php');
    exit;
} else {
    // Get the product details to be edited
    $id = $_GET['msp'];
    $sql = "SELECT *
            FROM SanPham sp
            INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
            INNER JOIN MauSac m ON m.MaMau = sp.MaMau
            INNER JOIN Size s ON s.MaSize = sp.MaSize
            WHERE sp.MaSP = :id";
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
        <form method="post" action="QLSanPham_Sua.php">
            <input type="hidden" name="id" value="<?php echo $product['MaSP']; ?>">
            <div class="form-group">
                <label for="tenSP">Tên Sản Phẩm</label>
                <input type="text" class="form-control" id="tenSP" name="tenSP" value="<?php echo $product['TenSP']; ?>">
            </div>
            <div class="form-group">
                <label for="loaiSP">Loại Sản Phẩm</label>
                <select class="form-control" id="loaiSP" name="loaiSP">
                    <?php
                    // Fetch the list of product categories from the database
                    $sql = "SELECT * FROM LoaiSanPham";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['MaLoaiSP'] == $product['MaLoaiSP']) ? 'selected' : '';
                        echo "<option value='{$row['MaLoaiSP']}' $selected>{$row['TenLoaiSP']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="mau">Màu Sắc</label>
                <select class="form-control" id="mau" name="mau">
                    <?php
                    // Fetch the list of colors from the database
                    $sql = "SELECT * FROM MauSac";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['MaMau'] == $product['MaMau']) ? 'selected' : '';
                        echo "<option value='{$row['MaMau']}' $selected>{$row['TenMau']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <select class="form-control" id="size" name="size">
                    <?php
                    // Fetch the list of sizes from the database
                    $sql = "SELECT * FROM Size";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['MaSize'] == $product['MaSize']) ? 'selected' : '';
                        echo "<option value='{$row['MaSize']}' $selected>{$row['TenSize']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="soLuong">Số Lượng Tồn</label>
                <input type="number" class="form-control" id="soLuong" name="soLuong" value="<?php echo $product['SoLuongTon']; ?>">
            </div>
            <div class="form-group">
                <label for="hinhAnh">Hình Ảnh</label>
                <input type="text" class="form-control" id="hinhAnh" name="hinhAnh" value="<?php echo $product['HinhAnhSP']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="QLSanPham.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>