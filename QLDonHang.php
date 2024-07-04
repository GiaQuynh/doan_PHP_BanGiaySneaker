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

$sql = "SELECT MaTrangThai, TenTrangThai 
FROM TrangThaiDonHang";
$trangthai = $pdo->query($sql);

$sql1 = "SELECT *
	FROM DonHang
	INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang";
$donhang0 = $pdo->query($sql1);
// <td><span class="badge bg-success">Done</span></td>
// <td><span class="badge bg-warning">In progress</span></td>

// <td><span class="badge bg-warning">In progress</span></td>
$sta = $pdo->prepare($sql1);
$sta->execute();

if ($sta->rowCount() > 0) {
	$donhang = $sta->fetchAll(PDO::FETCH_OBJ);
}
$p = new Pager();
$limit = 5;


if (isset($donhang)) {
	$count = count($donhang);
	$vt = $p->findStart($limit);
	$pages = $p->findPages($count, $limit);

	$cur = $_GET["page"];
	$phantrang = $p->pageList($cur, $pages);

	$sql1 = "SELECT *
FROM DonHang
INNER JOIN TrangThaiDonHang ON DonHang.MaTrangThai = TrangThaiDonHang.MaTrangThai
        WHERE DonHang.maDonHang limit $vt, $limit";
	$sta = $pdo->prepare($sql1);
	$sta->execute();
	$donhang1 = $sta->fetchAll(PDO::FETCH_OBJ);

	$searchQuery = isset($_GET['Search']) ? $_GET['Search'] : '';

	$sql2 = "SELECT *
FROM DonHang
-- INNER JOIN ChiTietDonHang ON DonHang.maDonHang = ChiTietDonHang.maDonHang
        WHERE DonHang.maDonHang LIKE :searchQuery
        LIMIT $vt, $limit";
	$sta2 = $pdo->prepare($sql2);
	$sta2->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
	$sta2->execute();
	$donhang2 = $sta2->fetchAll(PDO::FETCH_OBJ);

	if (isset($_POST['update_status'])) {
		$maDonHang = $_POST['maDonHang'];
		$maTrangThai = $_POST['maTrangThai'];

		$sql = "UPDATE DonHang SET MaTrangThai = :maTrangThai WHERE maDonHang = :maDonHang";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':maTrangThai', $maTrangThai);
		$stmt->bindParam(':maDonHang', $maDonHang);

		if ($stmt->execute()) {
			// Redirect or display a success message
			echo "Order status updated successfully.";
		} else {
			echo "Error updating order status.";
		}
	}

	$sql1 = "SELECT DonHang.maDonHang, DonHang.MaUser, DonHang.NgayDat, DonHang.HinhThucThanhToan, DonHang.TongTien, DonHang.TienDatCoc, DonHang.TienConLai, DonHang.GhiChu, TrangThaiDonHang.TenTrangThai, TrangThaiDonHang.MaTrangThai
FROM DonHang
INNER JOIN TrangThaiDonHang ON DonHang.MaTrangThai = TrangThaiDonHang.MaTrangThai
WHERE DonHang.maDonHang LIMIT $vt, $limit";
	$sta = $pdo->prepare($sql1);
	$sta->execute();
	$donhang1 = $sta->fetchAll(PDO::FETCH_OBJ);

	if (count($donhang1) <= 0) {
		echo "Không có đơn hàng nào";
	}
} else {
	echo "Không có đơn hàng nào";
}


// Update order status
if (isset($_POST['update_status'])) {
	$maDonHang = $_POST['maDonHang'];
	$maTrangThai = $_POST['maTrangThai'];

	$sql = "UPDATE DonHang SET MaTrangThai = :maTrangThai WHERE maDonHang = :maDonHang";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':maTrangThai', $maTrangThai);
	$stmt->bindParam(':maDonHang', $maDonHang);

	if ($stmt->execute()) {
		// Redirect or display a success message
		echo "Order status updated successfully.";
	} else {
		echo "Error updating order status.";
	}
}
// Lọc đơn hàng theo trạng thái
if (isset($_GET['filterByStatus'])) {
	$filterByStatus = $_GET['filterByStatus'];

	$sql1 = "SELECT DonHang.maDonHang, DonHang.MaUser, DonHang.NgayDat, DonHang.HinhThucThanhToan, DonHang.TongTien, DonHang.TienDatCoc, DonHang.TienConLai, DonHang.GhiChu, TrangThaiDonHang.TenTrangThai, TrangThaiDonHang.MaTrangThai
		FROM DonHang
		INNER JOIN TrangThaiDonHang ON DonHang.MaTrangThai = TrangThaiDonHang.MaTrangThai";
	if ($filterByStatus == 'processing') {
		$sql1 .= " WHERE TrangThaiDonHang.TenTrangThai = N'Đang xử lý'";
	} elseif ($filterByStatus == 'shipped') {
		$sql1 .= " WHERE TrangThaiDonHang.TenTrangThai = N'Đang giao hàng'";
	} elseif ($filterByStatus == 'delivered') {
		$sql1 .= " WHERE TrangThaiDonHang.TenTrangThai = N'Đã giao hàng'";
	} elseif ($filterByStatus == 'success') {
		$sql1 .= " WHERE TrangThaiDonHang.TenTrangThai = N'Thành Công'";
	} elseif ($filterByStatus == 'fail') {
		$sql1 .= " WHERE TrangThaiDonHang.TenTrangThai = N'Thất Bại'";
	}

	$sta1 = $pdo->prepare($sql1);
	$sta1->execute();
	$donhang3 = $sta1->fetchAll(PDO::FETCH_OBJ);
	// foreach ($donhang3 as $order) {
	// 	echo "<tr>";
	// 	echo "<td>" . $order->maDonHang . "</td>";
	// 	echo "<td>" . $order->MaUser . "</td>";
	// 	echo "<td>" . $order->NgayDat . "</td>";
	// 	echo "<td>" . $order->HinhThucThanhToan . "</td>";
	// 	echo "<td>" . $order->TongTien . "</td>";
	// 	echo "<td>" . $order->TienDatCoc . "</td>";
	// 	echo "<td>" . $order->TienConLai . "</td>";
	// 	echo "<td>" . $order->GhiChu . "</td>";
	// 	echo "<td>" . $order->TenTrangThai . "</td>";
	// }
}

?>

<body>
	<div class="wrapper">
		<?php include('AdminSidebarMenu.php'); ?>

		<div class="main">
			<?php include('AdminNavbarMenu.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Quản Lý Sản Phẩm</h1>
					<form method="GET">
						<label for="filterByStatus">Filter by status:</label>
						<select name="filterByStatus" id="filterByStatus">
							<option value="">All</option>
							<option value="processing">Đang xử lý</option>
							<option value="shipped">Đang giao hàng</option>
							<option value="delivered">Đã giao hàng</option>
							<option value="success">Thành công</option>
							<option value="fail">Thất bại</option>
						</select>
						<button type="submit">Filter</button>
					</form>

					<div class="row">
						<div class="col-12 d-flex">
							<div class="card flex-fill">
								<div class="card-header">
									<h5 class="card-title mb-0">...</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Mã Đơn Hàng</th>
											<th class="d-none d-xl-table-cell">Mã Khách Hàng</th>
											<th class="d-none d-xl-table-cell">Ngày Đặt</th>
											<th class="d-none d-xl-table-cell">Hình Thức Thanh Toán</th>
											<th class="d-none d-xl-table-cell">Tổng Tiền</th>
											<th class="d-none d-md-table-cell">Tiền Đặt Cọc</th>
											<th class="d-none d-xl-table-cell">Tiền Còn Lại</th>
											<th class="d-none d-xl-table-cell">Ghi chú</th>
											<th class="d-none d-xl-table-cell">Mã Trạng Thái</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (isset($donhang3)) {
											foreach ($donhang3 as $order) :
										?>
												<tr>
													<td><?php echo $order->maDonHang; ?></td>
													<td><?php echo $order->MaUser; ?></td>
													<td><?php echo $order->NgayDat; ?></td>
													<td><?php echo $order->HinhThucThanhToan; ?></td>
													<td><?php echo $order->TongTien; ?></td>
													<td><?php echo $order->TienDatCoc; ?></td>
													<td><?php echo $order->TienConLai; ?></td>
													<td><?php echo $order->GhiChu; ?></td>
													<td><?php echo $order->TenTrangThai; ?></td>
													<td>
														<form method="POST" action="">
															<input type="hidden" name="maDonHang" value="<?php echo $order->maDonHang; ?>">
															<select name="maTrangThai">
																<?php
																$statusSql = "SELECT * FROM TrangThaiDonHang";
																$statusStmt = $pdo->query($statusSql);
																$statuses = $statusStmt->fetchAll(PDO::FETCH_OBJ);

																foreach ($statuses as $status) {
																	$selected = ($status->MaTrangThai == $order->MaTrangThai) ? 'selected' : '';
																	echo "<option value='{$status->MaTrangThai}' $selected>{$status->TenTrangThai}</option>";
																}
																?>
															</select>
															<button type="submit" name="update_status">Update</button>
															<!-- <button type="submit" name="update_status">Update</button> -->
															<!-- <button class="btn btn-danger" type="submit"><a class="text-light" href="QLDonHang_Xoa.php?msp=<?php echo $order->maDonHang; ?>">Delete</a></button> -->
															<button type="submit"><a href="QLDonHang_ChiTiet.php?msp=<?php echo $order->maDonHang; ?>">Xem chi tiết</a></button>
														</form>
													</td>
												</tr>
										<?php
											endforeach;
										} 
										elseif (isset($donhang1)) {
											foreach ($donhang1 as $order) :
										?>
												<tr>
													<td><?php echo $order->maDonHang; ?></td>
													<td><?php echo $order->MaUser; ?></td>
													<td><?php echo $order->NgayDat; ?></td>
													<td><?php echo $order->HinhThucThanhToan; ?></td>
													<td><?php echo $order->TongTien; ?></td>
													<td><?php echo $order->TienDatCoc; ?></td>
													<td><?php echo $order->TienConLai; ?></td>
													<td><?php echo $order->GhiChu; ?></td>
													<td><?php echo $order->TenTrangThai; ?></td>
													<td>
														<form method="POST" action="">
															<input type="hidden" name="maDonHang" value="<?php echo $order->maDonHang; ?>">
															<select name="maTrangThai">
																<?php
																$statusSql = "SELECT * FROM TrangThaiDonHang";
																$statusStmt = $pdo->query($statusSql);
																$statuses = $statusStmt->fetchAll(PDO::FETCH_OBJ);

																foreach ($statuses as $status) {
																	$selected = ($status->MaTrangThai == $order->MaTrangThai) ? 'selected' : '';
																	echo "<option value='{$status->MaTrangThai}' $selected>{$status->TenTrangThai}</option>";
																}
																?>
															</select>
															<button type="submit" name="update_status">Update</button>
															<!-- <button type="submit" name="update_status">Update</button> -->
															<!-- <button class="btn btn-danger" type="submit"><a class="text-light" href="QLDonHang_Xoa.php?msp=<?php echo $order->maDonHang; ?>">Delete</a></button> -->
															<button type="submit"><a href="QLDonHang_ChiTiet.php?msp=<?php echo $order->maDonHang; ?>">Xem chi tiết</a></button>
														</form>
													</td>
												</tr>
										<?php
											endforeach;
										} 
										else {
											echo "Không có đơn hàng nào";
										}
										?>
									</tbody>

									</tbody>
								</table>
								<?php
								if (isset($phantrang)) {
								?>
									<div style="margin:20px; text-align: center;"><?php echo $phantrang; ?></div>

								<?php
								}

								?>
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
	<!-- <script>
		$('.btn-update').on('click', function() {
			var maDonHang = $(this).data('maDonHang');
			var maTrangThai = $(this).closest('tr').find('select[name="MaTrangThai"]').val();

			$.ajax({
				url: 'update_order_status.php',
				type: 'POST',
				data: {
					maDonHang: maDonHang,
					maTrangThai: maTrangThai
				},
				success: function(response) {
					console.log(response);
				},
				error: function() {
					alert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.');
				}
			});
		});

		$('.delete-btn').click(function() {
			var orderID = $(this).data('order-id');

			if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) {
				$.ajax({
					url: 'QLDonHang.php',
					type: 'POST',
					data: {
						action: 'delete_order',
						maDonHang: orderID
					},
					success: function(response) {
						if (response === 'success') {
							alert('Đơn hàng đã được xóa thành công.');
							location.reload();
						} else {
							alert('Đã có lỗi xảy ra khi xóa đơn hàng.');
						}
					},
					error: function() {
						alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
					}
				});
			}
		});
	</script> -->

</body>

</html>