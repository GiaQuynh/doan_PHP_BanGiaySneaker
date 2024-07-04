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

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Blank Page | AdminKit Demo</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">


</head>

<?php
session_start();
include("Pager.php");
include('Connect.php');

$sql = "select * from SanPham";
$sanpham = $pdo->query($sql);

$sql1 = "SELECT *
	FROM SanPham sp
	INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
	INNER JOIN MauSac m ON m.MaMau = sp.MaMau
	INNER JOIN Size s ON s.MaSize = sp.MaSize";
$sanpham1 = $pdo->query($sql1);


// $sql = "select ma_mon, ten_mon, noi_dung_tom_tat, don_gia, hinh from mon_an";
$sta = $pdo->prepare($sql1);
$sta->execute();

if ($sta->rowCount() > 0) {
	$sanpham1 = $sta->fetchAll(PDO::FETCH_OBJ);
}

$p = new Pager();
$limit = 5;
$count = count($sanpham1);
$vt = $p->findStart($limit);
$pages = $p->findPages($count, $limit);

$cur = $_GET["page"];
$phantrang = $p->pageList($cur, $pages);

$sql1 = "SELECT *
FROM SanPham sp
INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
INNER JOIN MauSac m ON m.MaMau = sp.MaMau
INNER JOIN Size s ON s.MaSize = sp.MaSize limit $vt, $limit";
$sta = $pdo->prepare($sql1);
$sta->execute();
$sanpham1 = $sta->fetchAll(PDO::FETCH_OBJ);

$searchQuery = isset($_GET['Search']) ? $_GET['Search'] : '';

$sql2 = "SELECT *
        FROM SanPham sp
        INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
        INNER JOIN MauSac m ON m.MaMau = sp.MaMau
        INNER JOIN Size s ON s.MaSize = sp.MaSize
        WHERE sp.TenSP LIKE :searchQuery
        LIMIT $vt, $limit";
$sta2 = $pdo->prepare($sql2);
$sta2->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
$sta2->execute();
$sanpham2 = $sta2->fetchAll(PDO::FETCH_OBJ);

// Lọc sản phẩm theo giá
// if (isset($_GET['filterByPrice'])) {
//     $filterByPrice = $_GET['filterByPrice'];
//     if ($filterByPrice == 'low_to_high') {
//         $sql1 = "SELECT *
//         FROM SanPham sp
//         INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
//         INNER JOIN MauSac m ON m.MaMau = sp.MaMau
//         INNER JOIN Size s ON s.MaSize = sp.MaSize
//         ORDER BY sp.DonGia ASC
//         LIMIT $vt, $limit";
//     } elseif ($filterByPrice == 'high_to_low') {
//         $sql1 = "SELECT *
//         FROM SanPham sp
//         INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
//         INNER JOIN MauSac m ON m.MaMau = sp.MaMau
//         INNER JOIN Size s ON s.MaSize = sp.MaSize
//         ORDER BY sp.DonGia DESC
//         LIMIT $vt, $limit";
//     } else {
//         $sql1 = "SELECT *
//         FROM SanPham sp
//         INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
//         INNER JOIN MauSac m ON m.MaMau = sp.MaMau
//         INNER JOIN Size s ON s.MaSize = sp.MaSize
//         LIMIT $vt, $limit";
//     }
// }

// Lọc sản phẩm theo tên
if (isset($_GET['filterByName'])) {
	$filterByName = $_GET['filterByName'];
	if ($filterByName == 'a_to_z') {
		$sql1 = "SELECT *
        FROM SanPham sp
        INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
        INNER JOIN MauSac m ON m.MaMau = sp.MaMau
        INNER JOIN Size s ON s.MaSize = sp.MaSize
        ORDER BY sp.TenSP ASC
        LIMIT $vt, $limit";
	} elseif ($filterByName == 'z_to_a') {
		$sql1 = "SELECT *
        FROM SanPham sp
        INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
        INNER JOIN MauSac m ON m.MaMau = sp.MaMau
        INNER JOIN Size s ON s.MaSize = sp.MaSize
        ORDER BY sp.TenSP DESC
        LIMIT $vt, $limit";
	} else {
		$sql1 = "SELECT *
        FROM SanPham sp
        INNER JOIN LoaiSanPham lsp ON lsp.MaLoaiSP = sp.MaLoaiSP
        INNER JOIN MauSac m ON m.MaMau = sp.MaMau
        INNER JOIN Size s ON s.MaSize = sp.MaSize
        LIMIT $vt, $limit";
	}
}

$sta = $pdo->prepare($sql1);
$sta->execute();
$sanpham1 = $sta->fetchAll(PDO::FETCH_OBJ);

?>


<body>
	<div class="wrapper">
		<?php
		include('AdminSideBarMenu.php');
		?>

		<div class="main">
			<?php
			include('AdminNavBarMenu.php');
			?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Quản Lý Sản Phẩm</h1>

					<div class="row">
						<div class="col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<form method="get" action="QLSanPham.php" class="d-flex align-items-center">
										<input class="form-control mr-1 w-50 px-3 py-1 rounded-pill" style="background-color: transparent;" type="text" placeholder="Search" aria-label="Search" name="Search">
										<button class="btn btn-outline-dark hover:bg-gray-200 hover:text-gray-800 transition-colors duration-300" style="margin-right:10px;">Search</button>
									</form>
									<h5 class="card-title mb-0">
										<button class="btn btn-primary" type="submit">
											<a class="text-light" href="QLSanPham_Them.php"> ADD NEW</a>
										</button>
									</h5>
									<!-- <div class="form-group">
										<label for="filterByPrice">Filter By Price:</label>
										<select class="form-control" id="filterByPrice">
											<option value="">All Prices</option>
											<option value="asc">Price: Low to High</option>
											<option value="desc">Price: High to Low</option>
										</select>
									</div>

									<div class="form-group">
										<label for="filterByName">Filter By Name:</label>
										<select class="form-control" id="filterByName">
											<option value="">All Names</option>
											<option value="asc">A to Z</option>
											<option value="desc">Z to A</option>
										</select>
									</div> -->
								</div>
								<!-- <a href="?filterByPrice=low_to_high">Giá: Thấp đến Cao</a>
								<a href="?filterByPrice=high_to_low">Giá: Cao đến Thấp</a> -->
								<a href="?filterByName=a_to_z">Tên: A đến Z</a>
								<a href="?filterByName=z_to_a">Tên: Z đến A</a>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Mã Sản Phẩm</th>
											<th class="d-none d-xl-table-cell">Tên Sản Phẩm</th>
											<th class="d-none d-xl-table-cell">Loại Sản Phẩm</th>
											<th class="d-none d-xl-table-cell">Màu Sắc</th>
											<th class="d-none d-md-table-cell">Size</th>
											<th class="d-none d-md-table-cell">Số Lượng Tồn</th>
											<th class="d-none d-md-table-cell">Hình Ảnh</th>
											<th class="d-none d-md-table-cell"></th>
										</tr>
									</thead>
									<?php
									if (isset($_GET['Search'])) {
										foreach ($sanpham2 as $sp) {
									?>
											<tbody>
												<tr>
													<td><?php echo $sp->MaSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenLoaiSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenMau ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->SoSize ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->SoLuongTon ?></td>
													<td class="d-none d-xl-table-cell"><img src="AnhSP/<?php echo $sp->HinhAnhSP; ?>" class="img-fluid" alt="Colorlib Template" height="100px" width="150px"></td>
													<td>
														<button class="btn btn-success" type="submit"> <a class="text-light" href="QLSanPham_Sua.php?msp=<?php echo $sp->MaSP; ?>">Update</a></button>
														<button class="btn btn-danger" type="submit"><a class="text-light" href="QLSanPham_Xoa.php?msp=<?php echo $sp->MaSP; ?>">Delete</a></button>
													</td>
												</tr>
											</tbody>
										<?php
										}
									} else {
										foreach ($sanpham1 as $sp) {
										?>
											<tbody>
												<tr>
													<td><?php echo $sp->MaSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenLoaiSP ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->TenMau ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->SoSize ?></td>
													<td class="d-none d-xl-table-cell"><?php echo $sp->SoLuongTon ?></td>
													<td class="d-none d-xl-table-cell"><img src="AnhSP/<?php echo $sp->HinhAnhSP; ?>" class="img-fluid" alt="Colorlib Template" height="100px" width="150px"></td>
													<td>
														<button class="btn btn-success" type="submit"> <a class="text-light" href="QLSanPham_Sua.php?msp=<?php echo $sp->MaSP; ?>">Update</a></button>
														<button class="btn btn-danger" type="submit"><a class="text-light" href="QLSanPham_Xoa.php?msp=<?php echo $sp->MaSP; ?>">Delete</a></button>
													</td>
												</tr>
											</tbody>
									<?php
										}
									}
									?>
								</table>
								<div style="margin:20px; text-align: center;"><?php echo $phantrang; ?></div>
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