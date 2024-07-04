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
<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="Admin.php">
			<span class="align-middle">Admin</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">
				Thông tin cá nhân
			</li>
			<li class="sidebar-item">
				<a class="sidebar-link" href="ThongTinAdmin.php">
					<span class="align-middle"><?php echo $userName ?></span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="ThongTinAdmin.php">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="Logout.php">
					<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Log out</span>
				</a>
			</li>

			<li class="sidebar-header">
				QUẢN LÝ CỬA HÀNG
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="QLLoaiSanPham.php">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Quản Lý Loại Sản Phẩm</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="QLSanPham.php">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Quản Lý Sản Phẩm</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="QLDonHang.php">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Quản Lý Đơn Hàng</span>
				</a>
			</li>

			<li class="sidebar-header">
				BÁO CÁO THỐNG KÊ
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="BaoCaoThongKe.php">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Báo Cáo Thống Kê<span>
				</a>
			</li>

			<li class="sidebar-header">
				CHĂM SÓC KHÁCH HÀNG
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="employee_responses.php">
					<i class="align-middle" data-feather="square"></i> <span class="align-middle">Chăm sóc khách hàng</span><span>
				</a>
			</li>
		</ul>
	</div>
</nav>