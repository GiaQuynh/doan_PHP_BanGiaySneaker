<?php
// Establish database connection
$pdo = new PDO("mysql:host=localhost;dbname=your_database_name", "your_username", "your_password");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_GET['id'];

    // Prepare and execute the delete query
    $stmt = $pdo->prepare("DELETE FROM SanPham WHERE MaSP = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Return a success response
        echo json_encode(['success' => true]);
    } else {
        // Return an error response
        echo json_encode(['success' => false, 'error' => 'Failed to delete product.']);
    }
}
?>