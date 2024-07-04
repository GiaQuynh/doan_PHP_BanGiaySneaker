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

// Fetch customer messages
$sql = "SELECT MaMess, m.MaUser, m.message, m.NgayMess, u.HoTen AS user_name
        FROM messages m
        JOIN user u ON m.MaUser = u.MaUser
        WHERE m.TrangThaiTN = 'Chưa xử lý'
        ORDER BY m.NgayMess DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle employee responses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageId = $_POST['message_id'];
    $employeeId = $userId;
    $response = $_POST['response'];

    $sql = "INSERT INTO NhanVien_Rep (MaMess, employee_id, response)
            VALUES (:message_id, :employee_id, :response)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
    $stmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
    $stmt->bindParam(':response', $response, PDO::PARAM_STR);
    $stmt->execute();

    // Update the message status to 'responded'
    $sql = "UPDATE messages SET TrangThaiTN = 'Đã xử lý' WHERE MaMess = :message_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Admin</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include('AdminSidebarMenu.php'); ?>

        <div class="main">
            <?php include('AdminNavbarMenu.php'); ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong> Chăm sóc khách hàng</strong></h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Message</th>
                                <th>Mã Khách Hàng</th>
                                <th>Ngày</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                                    <td><?php echo htmlspecialchars($message['MaUser']); ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($message['NgayMess'])); ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="message_id" value="<?php echo $message['MaMess']; ?>">
                                            <textarea name="response"></textarea>
                                            <button type="submit">Respond</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>
    </div>
    </div>
</body>

</html>