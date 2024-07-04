<?php
session_start();
include('Connect.php');

$product_id = $_GET['msp'];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Construct the SQL query to delete the product
    $sql = "DELETE FROM sanpham WHERE MaSP = $product_id";

    // Execute the SQL query
    if ($pdo->query($sql) === TRUE) {
        $message = "Product deleted successfully.";
        $class = "alert-success";
        header("Location: QLSanPham.php");
        exit();
    }

    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Delete Product</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)) { ?>
                            <div class="alert <?php echo $class; ?>" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <form method="post">
                            <p>Are you sure you want to delete this product?</p>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="QLSanPham.php" class="btn btn-primary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>