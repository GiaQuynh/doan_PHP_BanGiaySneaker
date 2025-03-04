<?php
ob_start();
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $userPhone = $_SESSION['user_phone'];
    $userAddress = $_SESSION['user_address'];

    // echo "Mã khách hàng: " . $userId . "";
    // echo "Tên khách hàng: " . $userName . "";
    // echo "Email: " . $userEmail . "";
    // echo "Số điện thoại: " . $userPhone . "";
    // echo "Địa chỉ: " . $userAddress . "";
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

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-profile.html" />

    <title>Profile | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<?php

if (isset($_SESSION['user_id'])) {
	$userId = $_SESSION['user_id'];
	$userName = $_SESSION['user_name'];
	$userEmail = $_SESSION['user_email'];
	$userPhone = $_SESSION['user_phone'];
	$userAddress = $_SESSION['user_address'];

	// echo "Mã khách hàng: " . $userId . "";
	// echo "Tên khách hàng: " . $userName . "";
	// echo "Email: " . $userEmail . "";
	// echo "Số điện thoại: " . $userPhone . "";
	// echo "Địa chỉ: " . $userAddress . "";
}
?>
<body>
    <div class="wrapper">
        <?php
        include('AdminSidebarMenu.php');
        ?>

        <div class="main">
            <?php
            include('AdminNavbarMenu.php');
            ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Profile</h1>
                        <a class="badge bg-dark text-white ms-2" href="upgrade-to-pro.html">
                            Get more page examples
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Profile Details</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="img/avatars/avatar-4.jpg" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                                    <h5 class="card-title mb-0"><?php echo $userName ?></h5>
                                    <div class="text-muted mb-2">Lead Developer</div>

                                    <div>
                                        <a class="btn btn-primary btn-sm" href="#">Follow</a>
                                        <a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span> Message</a>
                                    </div>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body">
                                    <h5 class="h6 card-title">Skills</h5>
                                    <a href="#" class="badge bg-primary me-1 my-1">HTML</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">JavaScript</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">Sass</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">Angular</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">Vue</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">React</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">Redux</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">UI</a>
                                    <a href="#" class="badge bg-primary me-1 my-1">UX</a>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body">
                                    <h5 class="h6 card-title">About</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><span data-feather="home" class="feather-sm me-1"></span> Lives in <a href="#">San Francisco, SA</a></li>

                                        <li class="mb-1"><span data-feather="briefcase" class="feather-sm me-1"></span> Works at <a href="#">GitHub</a></li>
                                        <li class="mb-1"><span data-feather="map-pin" class="feather-sm me-1"></span> From <a href="#">Boston</a></li>
                                    </ul>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body">
                                    <h5 class="h6 card-title">Elsewhere</h5>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1"><a href="#">staciehall.co</a></li>
                                        <li class="mb-1"><a href="#">Twitter</a></li>
                                        <li class="mb-1"><a href="#">Facebook</a></li>
                                        <li class="mb-1"><a href="#">Instagram</a></li>
                                        <li class="mb-1"><a href="#">LinkedIn</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 col-xl-9">
                            <div class="card">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Activities</h5>
                                </div>
                                <div class="card-body h-100">

                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle me-2" alt="Vanessa Tucker">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">5m ago</small>
                                            <strong>Vanessa Tucker</strong> started following <strong>Christina Mason</strong><br />
                                            <small class="text-muted">Today 7:51 pm</small><br />

                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar.jpg" width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">30m ago</small>
                                            <strong>Charles Hall</strong> posted something on <strong>Christina Mason</strong>'s timeline<br />
                                            <small class="text-muted">Today 7:21 pm</small>

                                            <div class="border text-sm text-muted p-2 mt-1">
                                                Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus
                                                pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante.
                                            </div>

                                            <a href="#" class="btn btn-sm btn-danger mt-1"><i class="feather-sm" data-feather="heart"></i> Like</a>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar-4.jpg" width="36" height="36" class="rounded-circle me-2" alt="Christina Mason">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">1h ago</small>
                                            <strong>Christina Mason</strong> posted a new blog<br />

                                            <small class="text-muted">Today 6:35 pm</small>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar-2.jpg" width="36" height="36" class="rounded-circle me-2" alt="William Harris">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">3h ago</small>
                                            <strong>William Harris</strong> posted two photos on <strong>Christina Mason</strong>'s timeline<br />
                                            <small class="text-muted">Today 5:12 pm</small>

                                            <div class="row g-0 mt-1">
                                                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                                    <img src="img/photos/unsplash-1.jpg" class="img-fluid pe-2" alt="Unsplash">
                                                </div>
                                                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                                    <img src="img/photos/unsplash-2.jpg" class="img-fluid pe-2" alt="Unsplash">
                                                </div>
                                            </div>

                                            <a href="#" class="btn btn-sm btn-danger mt-1"><i class="feather-sm" data-feather="heart"></i> Like</a>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar-2.jpg" width="36" height="36" class="rounded-circle me-2" alt="William Harris">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">1d ago</small>
                                            <strong>William Harris</strong> started following <strong>Christina Mason</strong><br />
                                            <small class="text-muted">Yesterday 3:12 pm</small>

                                            <div class="d-flex align-items-start mt-1">
                                                <a class="pe-3" href="#">
                                                    <img src="img/avatars/avatar-4.jpg" width="36" height="36" class="rounded-circle me-2" alt="Christina Mason">
                                                </a>
                                                <div class="flex-grow-1">
                                                    <div class="border text-sm text-muted p-2 mt-1">
                                                        Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar-4.jpg" width="36" height="36" class="rounded-circle me-2" alt="Christina Mason">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">1d ago</small>
                                            <strong>Christina Mason</strong> posted a new blog<br />
                                            <small class="text-muted">Yesterday 2:43 pm</small>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-flex align-items-start">
                                        <img src="img/avatars/avatar.jpg" width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
                                        <div class="flex-grow-1">
                                            <small class="float-end text-navy">1d ago</small>
                                            <strong>Charles Hall</strong> started following <strong>Christina Mason</strong><br />
                                            <small class="text-muted">Yesterdag 1:51 pm</small>
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="d-grid">
                                        <a href="#" class="btn btn-primary">Load more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

</body>

</html>