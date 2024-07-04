<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
$pdo->query("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenSP = $_POST["tenSP"];
    $maLoaiSP = $_POST["maLoaiSP"];
    $maMau = $_POST["maMau"];
    $maSize = $_POST["maSize"];
    $soLuong = $_POST["soLuong"];
    $hinh = $_FILES['hinh']['name'];
    $target_dir = "AnhSP/";
    $target_file = $target_dir . basename($_FILES["hinh"]["name"]);

    $stmt = $pdo->prepare("INSERT INTO SanPham (TenSP, MaLoaiSP, MaMau, MaSize, SoLuongTon, HinhAnhSP)
VALUES (:tenSP, :maLoaiSP, :maMau, :maSize, :soLuong, :hinh)");
    $stmt->bindParam(':tenSP', $tenSP);
    $stmt->bindParam(':maLoaiSP', $maLoaiSP);
    $stmt->bindParam(':maMau', $maMau);
    $stmt->bindParam(':maSize', $maSize);
    $stmt->bindParam(':soLuong', $soLuong);
    $stmt->bindParam(':hinh', $hinh);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Thêm thành công.';
        header('Location: QLSanPham.php');
        exit;
    } else {
        $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }

    if (isset($_FILES['hinh']) && $_FILES['hinh']['name'] !== '') {
        $hinh = $_FILES['hinh']['name'];
        $target_file = $target_dir . basename($hinh);
        if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO SanPham (TenSP, MaLoaiSP, MaMau, MaSize, SoLuongTon, HinhAnhSP)
            VALUES (:tenSP, :maLoaiSP, :maMau, :maSize, :soLuong, :hinh)");
            $stmt->bindParam(':hinh', $hinh);
            $stmt->execute();
        } else {
            $_SESSION['error'] = 'There was an error uploading your file.';
        }
    } else {
        $_SESSION['error'] = 'No file selected.';
    }


    $sql = "INSERT INTO SanPham (TenSP, MaLoaiSP, MaMau, MaSize,SoLuongTon, HinhAnhSP)
    VALUES (:tenSP, :maLoaiSP, :maMau, :maSize, :soLuong, :hinh)";

    $stmt = $pdo->prepare($sql);
    // Bind the parameters
    $stmt->bindParam(":tenSP", $tenSP);
    $stmt->bindParam(":maLoaiSP", $maLoaiSP);
    $stmt->bindParam(":maMau", $maMau);
    $stmt->bindParam(":maSize", $maSize);
    $stmt->bindParam(":soLuong", $soLuong);
    $stmt->bindParam(":hinh", $hinh);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Thêm thành công.';
        header('Location: QLSanPham.php');
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
                <label for="tenSP">Tên Sản Phẩm</label>
                <input type="text" class="form-control" id="tenSP" name="tenSP">
            </div>
            <div class="form-group">
                <label for="maLoaiSP">Mã Loại Sản Phẩm</label>
                <input type="number" class="form-control" id="maLoaiSP" name="maLoaiSP">
            </div>
            <div class="form-group">
                <label for="maMau">Mã Màu</label>
                <input type="number" class="form-control" id="maMau" name="maMau">
            </div>
            <div class="form-group">
                <label for="maSize">Mã Size</label>
                <input type="number" class="form-control" id="maSize" name="maSize">
            </div>
            <div class="form-group">
                <label for="soLuong">Số Lượng</label>
                <input type="number" class="form-control" id="soLuong" name="soLuong">
            </div>
            <div class="form-group">
                <label for="hinh">Hình</label>
                <input type="file" id="hinh" name="hinh" class="form-control-file" onchange="displayFileName()">
                <small class="form-text text-muted" id="fileNameDisplay">Chưa chọn ảnh</small>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </div>

    <script>
        function displayFileName() {
            var fileInput = document.getElementById('hinh');
            var fileNameDisplay = document.getElementById('fileNameDisplay');
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Chưa chọn ảnh';
            }
        }
    </script>
</body>

</html>