<?php
ob_start();
session_start();
include('Connect.php');

$sql0 = "Select * From Brand";
$brand0 = $pdo->query($sql0);

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php include("LinkCss.php"); ?>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

  <link rel="canonical" href="https://demo-basic.adminkit.io/maps-google.html" />

  <title>Google Maps | AdminKit Demo</title>

  <link href="css/app.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <title>Chatbot</title>

  <style>
    .navbar-nav li {
      display: inline-block;
      vertical-align: middle;
    }

    .navbar-nav form {
      display: inline-block;
      vertical-align: middle;
      margin-left: 20px;
    }

    .navbar-nav button {
      vertical-align: middle;
    }

    .navbar-nav form {
      display: flex;
      align-items: center;
    }

    .navbar-nav form .form-control {
      flex: 1;
      margin-right: 10px;
    }

    .navbar-nav form .btn {
      white-space: nowrap;
    }

    .navbar-nav form .form-control {
      flex: 1;
      margin-right: 10px;
      padding: 5px 5px;
      font-size: 0.875rem;
      height: 10px;
      line-height: 1.2;
      border-radius: 10px;
    }

    .container1 {
      height: 100vh;
    }

    .map {
      height: 200px;
      width: 200px;
    }

    #chat-container {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    #chat-window {
      background-color: #f5f5f5;
      border: 1px solid #e5e5e5;
      border-radius: 10px;
      padding: 1rem;
      height: 400px;
      width: 200px;
    }

    .message {
      display: flex;
      margin-bottom: 1rem;
    }

    .message.sent {
      justify-content: flex-end;
    }

    .message-content {
      max-width: 70%;
      padding: 0.75rem 1.25rem;
      border-radius: 1.25rem;
      font-size: 0.9rem;
    }

    .message.received .message-content {
      background-color: #007bff;
      color: #fff;
    }

    .message.sent .message-content {
      background-color: #e6e6e6;
      color: #333;
    }

    #message-input {
      border: 1px solid #e5e5e5;
      border-radius: 1.25rem;
      padding: 0.75rem 1.25rem;
      font-size: 0.9rem;
      width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }

    #message-input:focus {
      outline: none;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body class="goto-here">
  <div class="py-1 bg-black">
    <div class="container">
      <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
        <div class="col-lg-12 d-block">
          <div class="row d-flex">
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
              <span class="text">+ 1235 2355 98</span>
            </div>
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
              <span class="text">youremail@email.com</span>
            </div>
            <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
              <span class="text">3-5 Business days delivery &amp; Free Returns</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="TrangChu.php">Minishop</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="TrangChu.php" class="nav-link">Home</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="DanhSachGiay.php" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalog</a>
            <div class="dropdown-menu" aria-labelledby="dropdown04">
              <?php
              foreach ($brand0 as $br) {
              ?>
                <a class="dropdown-item" href="DanhSachGiay.php?ml=<?php echo $br['MaBrand'] ?>&tl=<?php echo $br['TenBrand'] ?>" style="text-transform:uppercase; text-decoration:none;"><?php echo $br['TenBrand'] ?></a>
              <?php
              }
              ?>
              <a class="dropdown-item" href="DanhSachGiay.php" style="text-transform:uppercase; text-decoration:none;">Show All</a>
            </div>
          </li>
          <li class="nav-item"><a href="About.php" class="nav-link">About</a></li>
          <li class="nav-item"><a href="Blog.php" class="nav-link">Blog</a></li>
          <li class="nav-item"><a href="Contact.php" class="nav-link">Contact</a></li>
          <form method="get" action="DanhSachGiay.php">
            <input class="form-control mr-1 w-50 px-3 py-1 rounded-pill" style="background-color: transparent;" type="text" placeholder="Search" aria-label="Search" name="txt_Search">
            <div class="d-flex align-items-center">
              <button class="btn btn-outline-dark hover:bg-gray-200 hover:text-gray-800 transition-colors duration-300" style="margin-right:10px;">Search</button>
              <a href="GioHang.php">
                <span class="icon-shopping_cart"></span>
                <?php
                echo (isset($_SESSION['cart']) && count($_SESSION['cart'])) > 0 ? count($_SESSION['cart']) : '';
                ?>
              </a>
            </div>
          </form>
          <?php
          if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != "") {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['user_name']; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="ThongTinKhachHang.php">Thông Tin Cá Nhân</a>
                <a class="dropdown-item" href="LichSuDatHang.php">Lịch Sử Đặt Hàng</a>
                <a class="dropdown-item" href="Logout.php">Logout</a>
              </div>
            </li>
          <?php
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="Login.php">Đăng Nhập</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
          <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Contact</span></p>
          <h1 class="mb-0 bread">Contact Us</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section contact-section bg-light">
    <div class="container">
      <div class="row d-flex mb-5 contact-info">
        <div class="w-100"></div>
        <div class="col-md-3 d-flex">
          <div class="info bg-white p-4">
            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
          </div>
        </div>
        <div class="col-md-3 d-flex">
          <div class="info bg-white p-4">
            <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
          </div>
        </div>
        <div class="col-md-3 d-flex">
          <div class="info bg-white p-4">
            <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
          </div>
        </div>
        <div class="col-md-3 d-flex">
          <div class="info bg-white p-4">
            <p><span>Website</span> <a href="#">yoursite.com</a></p>
          </div>
        </div>
      </div>


      <div class="d-flex">
        <main class="content">
          <div class="container-fluid p-0">

            <div class="mb-3">
              <h1 class="h3 d-inline align-middle">Google Maps</h1>
            </div>
            <div class="row">
              <div class="content" id="default_map" style="height: 300px;"></div>

            </div>
        </main>
        <div class="d-flex">
          <div id="chat-container" class="flex-grow-1">
            <br><br><br><br><br>
            <h1 class="h3 d-inline align-middle"></h1>
            <div id="chat-window"></div>
            <div class="input-group">
              <input type="text" id="message-input" class="form-control" placeholder="Type your message...">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <?php include('footerSection.php'); ?>
  <?php include('footer.php'); ?>
  <?php include('loader.php'); ?>
  <script src="js/app.js"></script>


  <script>
    function initMaps() {
      var defaultMap = {
        zoom: 14,
        center: {
          lat: 10.806322506632515,
          lng: 106.62868705135824
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      new google.maps.Map(document.getElementById("default_map"), defaultMap);
      var hybridMap = {
        zoom: 14,
        center: {
          lat: 10.806322506632515,
          lng: 106.62868705135824
        },
        mapTypeId: google.maps.MapTypeId.HYBRID
      };
      new google.maps.Map(document.getElementById("hybrid_map"), hybridMap);
    }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-aWrwgr64q4b3TEZwQ0lkHI4lZK-moM4&callback=initMaps" async defer></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#message-input').on('keydown', function(event) {
        if (event.keyCode == 13) {
          var message = $(this).val();
          sendMessage(message);
          $(this).val('');
        }
      });
    });

    function sendMessage(message) {
      $.ajax({
        type: 'POST',
        url: 'index.php',
        data: {
          message: message
        },
        success: function(response) {
          $('#chat-window').append('<div class="bot-message">' + response + '</div>');
        }
      });
    }
  </script>
</body>

</html>