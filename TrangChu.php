<!DOCTYPE html>
<html lang="en">

<head>
    <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('LinkCss.php'); ?>

</head>

<?php
include('Connect.php');

$sql0 = "Select * From Brand";
$brand = $pdo->query($sql0);

$sql = "SELECT 
    sanpham.TenSP, 
    loaisanpham.GiaLoaiSP, 
    sanpham.HinhAnhSP, 
    loaisanpham.MoTa,
    sanpham.MaMau,
    sanpham.MaSize,
    grouped_sanpham.MaSP AS grouped_MaSP,
    loaisanpham.MaLoaiSP
FROM loaisanpham
JOIN (
    SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
    FROM sanpham
    GROUP BY MaLoaiSP, MaMau
    ORDER BY MaSP DESC
    LIMIT 8
) AS grouped_sanpham
ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
JOIN sanpham 
ON grouped_sanpham.MaSP = sanpham.MaSP
ORDER BY sanpham.MaSP DESC
LIMIT 8";
$sanpham = $pdo->query($sql);

$sql1 = "SELECT 
    sanpham.TenSP, 
    loaisanpham.GiaLoaiSP, 
    sanpham.HinhAnhSP, 
    loaisanpham.MoTa,
    sanpham.MaMau,
    sanpham.MaSize,
    grouped_sanpham.MaSP AS grouped_MaSP,
    loaisanpham.MaLoaiSP
FROM loaisanpham
JOIN (
    SELECT DISTINCT MaLoaiSP, MaMau, MIN(MaSP) AS MaSP
    FROM sanpham
    GROUP BY MaLoaiSP, MaMau
    ORDER BY MaSP DESC
    LIMIT 8
) AS grouped_sanpham
ON loaisanpham.MaLoaiSP = grouped_sanpham.MaLoaiSP
JOIN sanpham 
ON grouped_sanpham.MaSP = sanpham.MaSP
ORDER BY sanpham.MaSP DESC
LIMIT 8";
$sanpham1 = $pdo->query($sql1);
$pdo = NULL;

?>

<body class="goto-here">

    <?php include('NavMenu.php'); ?>

    <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
            <div class="slider-item js-fullheight">
                <div class="overlay"></div>
                <div class="container-fluid p-0">
                    <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                        <img class="one-third order-md-last img-fluid" src="images/bg_1.png" alt="">
                        <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                            <div class="text">
                                <span class="subheading">#New Arrival</span>
                                <div class="horizontal">
                                    <h1 class="mb-4 mt-3">Shoes Collection 2019</h1>
                                    <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country.</p>

                                    <p><a href="#" class="btn-custom">Discover Now</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-item js-fullheight">
                <div class="overlay"></div>
                <div class="container-fluid p-0">
                    <div class="row d-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                        <img class="one-third order-md-last img-fluid" src="images/bg_2.png" alt="">
                        <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                            <div class="text">
                                <span class="subheading">#New Arrival</span>
                                <div class="horizontal">
                                    <h1 class="mb-4 mt-3">New Shoes Winter Collection</h1>
                                    <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country.</p>

                                    <p><a href="#" class="btn-custom">Discover Now</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters ftco-services">
                <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services p-4 py-md-5">
                        <div class="icon d-flex justify-content-center align-items-center mb-4">
                            <span class="flaticon-bag"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Free Shipping</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services p-4 py-md-5">
                        <div class="icon d-flex justify-content-center align-items-center mb-4">
                            <span class="flaticon-customer-service"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Support Customer</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services p-4 py-md-5">
                        <div class="icon d-flex justify-content-center align-items-center mb-4">
                            <span class="flaticon-payment-security"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Secure Payments</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">New Shoes Arrival</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <div class="row">
                <?php
                foreach ($sanpham as $giay) {
                ?>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="product d-flex flex-column h-100">
                            <a href="#" class="img-prod mb-3">
                                <img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" style="height: 200px; width:200px" alt="<?php echo $giay['TenSP']; ?>">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 px-3 flex-grow-1">
                                <h3 class="mb-2"><a href="#"><?php echo $giay['TenSP']; ?></a></h3>
                                <div class="pricing mb-3">
                                    <p class="price"><span><?php echo $giay['GiaLoaiSP']; ?></span></p>
                                </div>
                                <p class="bottom-area d-flex justify-content-between align-items-center">
                                    <a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP']; ?>&idL=<?php echo $giay['MaLoaiSP']; ?>&idM=<?php echo $giay['MaMau']; ?>&idS=<?php echo $giay['MaSize']; ?>" class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-deal bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="images/prod-1.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-6">
                    <div class="heading-section heading-section-white">
                        <span class="subheading">Deal of the month</span>
                        <h2 class="mb-3">Deal of the month</h2>
                    </div>
                    <div id="timer" class="d-flex mb-4">
                        <div class="time" id="days"></div>
                        <div class="time pl-4" id="hours"></div>
                        <div class="time pl-4" id="minutes"></div>
                        <div class="time pl-4" id="seconds"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Hot Sales</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <div class="row">
                <?php
                foreach ($sanpham1 as $giay) {
                ?>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="product d-flex flex-column h-100">
                            <a href="#" class="img-prod mb-3">
                                <img class="img-fluid" src="AnhSP/<?php echo $giay['HinhAnhSP']; ?>" style="height: 200px; width:200px" alt="<?php echo $giay['TenSP']; ?>">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 px-3 flex-grow-1">
                                <h3 class="mb-2"><a href="#"><?php echo $giay['TenSP']; ?></a></h3>
                                <div class="pricing mb-3">
                                    <p class="price"><span><?php echo $giay['GiaLoaiSP']; ?></span></p>
                                </div>
                                <p class="bottom-area d-flex justify-content-between align-items-center">
                                    <a href="ChiTietGiay.php?id=<?php echo $giay['grouped_MaSP']; ?>&idL=<?php echo $giay['MaLoaiSP']; ?>&idM=<?php echo $giay['MaMau']; ?>&idS=<?php echo $giay['MaSize']; ?>" class="buy-now text-center py-2">Buy now<span><i class="ion-ios-cart ml-1"></i></span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>



    <section class="ftco-section testimony-section">
        <div class="container">
            <div class="row">
                <div class="services-flow d-flex">
                    <div class="services-2 p-4 d-flex ftco-animate">
                        <div class="icon">
                            <span class="flaticon-bag"></span>
                        </div>
                        <div class="text">
                            <h3>Free Shipping</h3>
                            <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                        </div>
                    </div>
                    <div class="services-2 p-4 d-flex ftco-animate">
                        <div class="icon">
                            <span class="flaticon-heart-box"></span>
                        </div>
                        <div class="text">
                            <h3>Valuable Gifts</h3>
                            <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                        </div>
                    </div>
                    <div class="services-2 p-4 d-flex ftco-animate">
                        <div class="icon">
                            <span class="flaticon-payment-security"></span>
                        </div>
                        <div class="text">
                            <h3>All Day Support</h3>
                            <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                        </div>
                    </div>
                    <div class="services-2 p-4 d-flex ftco-animate">
                        <div class="icon">
                            <span class="flaticon-customer-service"></span>
                        </div>
                        <div class="text">
                            <h3>All Day Support</h3>
                            <p class="mb-0">Separated they live in. A small river named Duden flows</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-gallery">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center mb-4 ftco-animate">
                    <h2 class="mb-4">Follow Us On Instagram</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
                </div>
            </div>
        </div>
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-1.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-1.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-2.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-2.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-3.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-4.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-4.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-5.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-5.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-lg-2 ftco-animate">
                    <a href="images/gallery-6.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-6.jpg);">
                        <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-section">
        <div class="container">
            <div class="row">
                <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Minishop</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Menu</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Shop</a></li>
                            <li><a href="#" class="py-2 d-block">About</a></li>
                            <li><a href="#" class="py-2 d-block">Journal</a></li>
                            <li><a href="#" class="py-2 d-block">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Help</h2>
                        <div class="d-flex">
                            <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
                                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
                                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
                                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><a href="#" class="py-2 d-block">FAQs</a></li>
                                <li><a href="#" class="py-2 d-block">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <?php include('Loader.php'); ?>

</body>

</html>