<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo->query("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $MaBrand = $_POST["MaBrand"];
    $TenLoaiSP = $_POST["TenLoaiSP"];
    $GiaLoaiSP = $_POST["GiaLoaiSP"];
    $MoTa = $_POST["MoTa"];

    $stmt = $pdo->prepare("INSERT INTO LoaiSanPham (MaBrand, TenLoaiSP, GiaLoaiSP, MoTa)
VALUES (:MaBrand, :TenLoaiSP, :GiaLoaiSP, :MoTa)");
    $stmt->bindParam(':MaBrand', $MaBrand);
    $stmt->bindParam(':TenLoaiSP', $TenLoaiSP);
    $stmt->bindParam(':GiaLoaiSP', $GiaLoaiSP);
    $stmt->bindParam(':MoTa', $MoTa);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Thêm thành công.';
        header('Location: QLLoaiSanPham.php');
        exit;
    } else {
        $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Thêm sản phẩm</h1>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <form name="createCustomerForm" method="post" action="QLSanPham_Them.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="MaBrand">Mã Brand</label>
                <input type="text" class="form-control" id="MaBrand" name="MaBrand">
            </div>
            <div class="form-group">
                <label for="TenLoaiSP">Tên Loại Sản Phẩm</label>
                <input type="number" class="form-control" id="TenLoaiSP" name="TenLoaiSP">
            </div>
            <div class="form-group">
                <label for="GiaLoaiSP">Giá Loại Sản Phẩm</label>
                <input type="number" class="form-control" id="GiaLoaiSP" name="GiaLoaiSP">
            </div>
            <div class="form-group">
                <label for="MoTa">Mô Tả</label>
                <input type="number" class="form-control" id="MoTa" name="MoTa">
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</body>

</html>