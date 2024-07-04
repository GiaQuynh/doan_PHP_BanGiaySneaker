<?php
session_start();

require_once 'Connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Validate the input data
    $errors = [];
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors['username'] = '<span style="color:red;">Username must contain only letters and numbers.</span>';
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
        $errors['password'] = '<span style="color:red;">Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.</span>';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '<span style="color:red;">Invalid email address.</span>';
    }

    // Check if the username or email already exists in the database
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE TaiKhoan = :username OR email = :email');
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors['duplicate'] = '<span style="color:red;">Username or email already exists.</span>';
    }

    if (empty($errors)) {
        // Prepare the SQL query
        $stmt = $pdo->prepare('INSERT INTO user (HoTen, TaiKhoan, MatKhau, email, MaQuyen) VALUES (:username, :username, :password, :email, 0)');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Registration successful
            // Add any additional logic, such as sending a welcome email
            echo 'Registration successful!';
        } else {
            // Registration failed
            echo 'Registration failed.';
        }
    } else {
        // Display the validation errors
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

    <title>Sign Up</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>


<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Get started</h1>
                            <p class="lead">
                                Start creating the best possible user experience for you customers.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" id="username" name="username" placeholder="Enter your username" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Enter your email" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="Enter password" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="password2" class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="Enter password" />
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <input type="submit" value="Register">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            Already have account? <a href="Login.php">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/app.js"></script>

</body>

</html>