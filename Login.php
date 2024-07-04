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

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Sign In | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php
ob_start();
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ql_bangiay", "root", "");
    $pdo->query("set names utf8");
} catch (PDOException $ex) {
    echo "Loi ket noi!" . $ex->getMessage();
    die();
}
?>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back!</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form action="" name="mf" id="formLG" method="post" onsubmit="return checkLogin()">
                                        <div class="mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input class="form-control form-control-lg" type="text" id="valuserName" name="userName" placeholder="Enter your email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="">Password</i></label>
                                            <input class="form-control form-control-lg" type="passWord" id="valpassWord" name="passWord" placeholder="Nhập Mật Khẩu" required>
                                        </div>
                                        <div>
                                            <div class="form-check align-items-center">
                                                <input class="form-check-input" type="checkbox" name="rememberMe" id="remember-me">
                                                <label class="form-check-label text-small" for="remember-me">Nhớ Mật Khẩu</label>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <input type="submit" name="bnt-submit" value="Đăng Nhập">
                                        </div>
                                        <span id="disError">
                                            <?php
                                            if (isset($_POST['bnt-submit']) and $_POST['bnt-submit'] == 'Đăng Nhập') {
                                                $user = $_POST['userName'];
                                                $passWord = $_POST['passWord'];
                                                $stmt = $pdo->prepare("SELECT MaUser, HoTen, Email, DienThoai, DiaChi, MaQuyen FROM user WHERE TaiKhoan = ? AND MatKhau = ?");
                                                $stmt->execute([$user, $passWord]);
                                                if ($stmt->rowCount() > 0) {
                                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    $_SESSION['user_id'] = $row['MaUser'];
                                                    $_SESSION['user_name'] = $row['HoTen'];
                                                    $_SESSION['user_email'] = $row['Email'];
                                                    $_SESSION['user_phone'] = $row['DienThoai'];
                                                    $_SESSION['user_address'] = $row['DiaChi'];
                                                    $_SESSION['user_role'] = $row['MaQuyen'];
                                                    if ($row['MaQuyen'] == 1) {
                                                        header("location: Admin.php");
                                                    } else {
                                                        header("location: TrangChu.php");
                                                    }
                                                } else {
                                                    echo "<script>alert('Tài Khoản Hoặc Mật Khẩu Không Đúng !');</script>";
                                                }
                                            }
                                            ?>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <span>Bạn Chưa Có Tài Khoản ?</span>
                            <span><a href="Signin.php" class="btn btn-lg btn-primary">Tạo Tài Khoản</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>

    <script type="text/javascript">
        function checkLogin() {
            var valUser = document.querySelector('#valuserName');
            var valPassword = document.querySelector('#valpassWord');
            var disError = document.querySelector('#disError');

            // Validate username
            // var usernameRegex = /^[a-zA-Z0-9]+$/;
            // if (!usernameRegex.test(valUser.value)) {
            //     disError.style.display = "block";
            //     disError.innerHTML = "Tên đăng nhập chỉ được chứa chữ và số.";
            //     document.querySelector('#formLG').style.border = "1px solid red";
            //     document.querySelector('form').style.animationName = "error";
            //     document.querySelector('form').style.animationDuration = "0.3s";
            //     return false;
            // }

            // // Validate password
            // var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            // if (!passwordRegex.test(valPassword.value)) {
            //     disError.style.display = "block";
            //     disError.innerHTML = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.";
            //     document.querySelector('#formLG').style.border = "1px solid red";
            //     document.querySelector('form').style.animationName = "error";
            //     document.querySelector('form').style.animationDuration = "0.3s";
            //     return false;
            // }

            // // Validate username
            // if (valUser.value.trim() === '') {
            //     disError.style.display = "block";
            //     disError.innerHTML = "Vui lòng nhập tên đăng nhập.";
            //     document.querySelector('#formLG').style.border = "1px solid red";
            //     document.querySelector('form').style.animationName = "error";
            //     document.querySelector('form').style.animationDuration = "0.3s";
            //     return false;
            // }

            // // Validate password
            // if (valPassword.value.trim() === '') {
            //     disError.style.display = "block";
            //     disError.innerHTML = "Vui lòng nhập mật khẩu.";
            //     document.querySelector('#formLG').style.border = "1px solid red";
            //     document.querySelector('form').style.animationName = "error";
            //     document.querySelector('form').style.animationDuration = "0.3s";
            //     return false;
            // }

            return true;
        }
    </script>
    <script src="./jsLogin.js"></script>
</body>

</html>