-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 07, 2024 lúc 10:54 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_bangiay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `MaBrand` int(11) NOT NULL,
  `TenBrand` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`MaBrand`, `TenBrand`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Vans'),
(4, 'Adidas'),
(5, 'Puma'),
(6, 'NB'),
(7, 'Converse'),
(8, 'MLB'),
(9, 'Fila');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDonHang` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDonHang`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(19, 182, 3, 3100000),
(20, 182, 5, 3100000),
(21, 182, 5, 3100000),
(21, 186, 1, 5500000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MaGio` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiettintuc`
--

CREATE TABLE `chitiettintuc` (
  `MaCTTT` int(11) NOT NULL,
  `MaTin` int(11) NOT NULL,
  `NoiDungCTTT` varchar(200) NOT NULL,
  `AnhCTTT` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiettintuc`
--

INSERT INTO `chitiettintuc` (`MaCTTT`, `MaTin`, `NoiDungCTTT`, `AnhCTTT`) VALUES
(1, 1, 'Mong muốn mang lại những trải nghiệm mua sắm tiện lợi cho khách hàng, Sneaker Buzz xin gửi thông báo về thời gian mở cửa của các cửa hàng và lịch giao hàng cho các kênh online trong hệ thống trong dịp', 'CTTT1.webp'),
(2, 2, '“E” hóa lĩnh vực sneaker game để đa dạng hóa khả năng tiếp cận với cộng đồng thời trang 4.0, đào sâu trải nghiệm như 1 giao lộ văn hóa và câu chuyện của nhiều thương hiệu quốc tế, Sneaker Buzz tiếp tụ', 'CTTT2.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chudetintuc`
--

CREATE TABLE `chudetintuc` (
  `MaCD` int(11) NOT NULL,
  `TenCD` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chudetintuc`
--

INSERT INTO `chudetintuc` (`MaCD`, `TenCD`) VALUES
(1, 'Cửa Hàng'),
(2, 'Thời Trang');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgiasanpham`
--

CREATE TABLE `danhgiasanpham` (
  `MaDG` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `MaUser` varchar(200) NOT NULL,
  `TieuDe` varchar(200) NOT NULL,
  `NoiDung` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDonHang` int(11) NOT NULL,
  `MaUser` int(11) NOT NULL,
  `NgayDat` datetime NOT NULL,
  `HinhThucThanhToan` varchar(200) NOT NULL,
  `TongTien` double NOT NULL,
  `TienDatCoc` double NOT NULL,
  `TienConLai` double NOT NULL,
  `GhiChu` varchar(500) NOT NULL,
  `MaTrangThai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaUser`, `NgayDat`, `HinhThucThanhToan`, `TongTien`, `TienDatCoc`, `TienConLai`, `GhiChu`, `MaTrangThai`) VALUES
(17, 42, '2024-06-06 00:00:00', 'TienMat', 5500000, 0, 5500000, '', 3),
(18, 42, '2024-06-06 00:00:00', 'TienMat', 19600000, 0, 19600000, '', 5),
(19, 2, '2024-06-06 00:00:00', 'TienMat', 9300000, 0, 9300000, '', 2),
(20, 2, '2024-06-06 00:00:00', 'ChuyenKhoan', 15500000, 0, 15500000, '', 1),
(21, 2, '2024-06-06 00:00:00', 'TienMat', 21000000, 0, 21000000, '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee_responses`
--

CREATE TABLE `employee_responses` (
  `id` int(11) NOT NULL,
  `MaMess` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `employee_responses`
--

INSERT INTO `employee_responses` (`id`, `MaMess`, `employee_id`, `response`, `created_at`) VALUES
(1, 6, 1, 'hi ', '2024-06-07 07:53:26'),
(2, 6, 1, 'hi', '2024-06-07 07:53:32'),
(3, 16, 1, 'oke', '2024-06-07 08:30:07'),
(4, 16, 1, 'oke', '2024-06-07 08:30:16'),
(5, 18, 1, 'oke', '2024-06-07 08:47:09'),
(6, 18, 1, 'oke', '2024-06-07 08:47:13'),
(7, 18, 1, 'oke', '2024-06-07 08:48:48'),
(8, 14, 1, 'ttt', '2024-06-07 08:49:22'),
(9, 14, 1, 'ttt', '2024-06-07 08:49:25'),
(10, 14, 1, 'ttt', '2024-06-07 08:50:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGio` int(11) NOT NULL,
  `MaUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGio`, `MaUser`) VALUES
(1, 2),
(2, 42);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhthucthanhtoan`
--

CREATE TABLE `hinhthucthanhtoan` (
  `MaHT` int(11) NOT NULL,
  `TenHT` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhthucthanhtoan`
--

INSERT INTO `hinhthucthanhtoan` (`MaHT`, `TenHT`) VALUES
(1, 'Chuyển Khoản Ngân Hàng'),
(2, 'Giao Hàng Tại Nhà');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` varchar(100) NOT NULL,
  `TenKM` varchar(100) NOT NULL,
  `SoLuongKM` int(11) NOT NULL,
  `GiamGia` double NOT NULL,
  `ThoiHan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `MaLoaiSP` int(11) NOT NULL,
  `MaBrand` int(11) NOT NULL,
  `TenLoaiSP` varchar(200) NOT NULL,
  `GiaLoaiSP` double NOT NULL,
  `MoTa` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`MaLoaiSP`, `MaBrand`, `TenLoaiSP`, `GiaLoaiSP`, `MoTa`) VALUES
(1, 2, 'Nike Air Force 107 LV8 ‘Split – Black Phantom’ FD2592-002', 1000000, 'aaaa'),
(2, 1, 'Nike Air Max 90 Triple White', 3100000, 'Nike Air Max 90 là một trong những sản phẩm kinh điển của hãng thể thao Nike, trải qua gần 30 năm lịch sử Nike Air Max 90 đã làm say đắm hàng triệu người yêu giày trên thế giới. Với thiết kế đẹp mắt, form dáng chắc chắn, cảm giác di chuyển vô cùng thoải mái cùng với công nghệ ngày càng hoàn hảo của Nike, Air Max 90 là một sự lựa chọn tuyệt vời cho tất cả mọi người đặc biệt là bạn trẻ năng động.'),
(3, 8, 'MLB Chunky Liner Mid Denim ‘Navy’ 3ASXCDN3N-50NYD', 5500000, 'Mua Giày MLB Chunky Liner Mid Denim ‘Navy’ 3ASXCDN3N-50NYD chính hãng 100% có sẵn tại Authentic Shoes. Giao hàng miễn phí trong 1 ngày.Cam kết đền tiền X5 nếu phát hiện Fake. Đổi trả miễn phí size. FREE vệ sinh giày trọn đời.'),
(4, 7, 'All Star All Terrain', 3154444, 'Feel cozy exploring your environment in style with the Chuck Taylor All Star All Terrain. Find a burst of on-the-go cozy with a quilted tongue that gives you visible comfort and warmth. Weather-resistant materials and hiker-inspired details, like round laces, a heel pull, and a traction outsole are ready for wherever your adventures take you this fall.'),
(5, 1, 'Nike Air Force 1 Mid By You', 4110000, 'Let your design shine in satin, keep it classic in canvas or get luxe with leather. No matter what you choose, these AF-1s are all about you. 12 colour choices and an additional Gum option for the sole mean your design is destined to be one of a kind, just like you.'),
(6, 7, 'Chuck Taylor All Star City Trek Waterproof Boot', 2911794, 'When it comes to fall weather, expect the unexpected. Converse knows this, and thats why we designed the Chuck Taylor All Star City Trek WP. Its a timeless look, now in a boot, with four innovations to get you through fall: waterproofing, comfort, traction, and warmth. Non-wicking canvas helps to keep you dry, while gussets lock the tongue—and warmth—in place. A Converse Traction Utility tread pattern helps keep you steady on rainy commutes. Plus, it comes in easy-to-wear colors to help you grou');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mausac`
--

CREATE TABLE `mausac` (
  `MaMau` int(11) NOT NULL,
  `TenMau` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mausac`
--

INSERT INTO `mausac` (`MaMau`, `TenMau`) VALUES
(1, 'Trắng'),
(2, 'Đỏ'),
(3, 'Đen'),
(4, 'Xanh'),
(5, 'Multi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `MaMess` int(11) NOT NULL,
  `MaUser` int(11) NOT NULL,
  `Message` text NOT NULL,
  `NgayMess` timestamp NOT NULL DEFAULT current_timestamp(),
  `TrangThaiTN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`MaMess`, `MaUser`, `Message`, `NgayMess`, `TrangThaiTN`) VALUES
(1, 1, 'hello', '2024-06-07 07:19:13', ''),
(2, 1, 'toi', '2024-06-07 07:21:29', 'Chưa xử lý'),
(3, 1, 'hello', '2024-06-07 07:25:10', ''),
(4, 1, 'hello', '2024-06-07 07:28:18', ''),
(5, 1, 'hello', '2024-06-07 07:39:58', ''),
(6, 1, 'ádafadf', '2024-06-07 07:40:37', 'responded'),
(7, 1, 'hello', '2024-06-07 08:04:57', ''),
(8, 1, 'hello', '2024-06-07 08:12:37', 'Chưa xử lý'),
(9, 1, 'hello', '2024-06-07 08:15:28', 'Chưa xử lý'),
(10, 1, 'time', '2024-06-07 08:16:14', ''),
(11, 2, 'jjjj', '2024-06-07 08:20:37', ''),
(12, 2, 'gggg', '2024-06-07 08:22:32', ''),
(13, 2, 'rrrr', '2024-06-07 08:25:09', 'Chưa xử lý'),
(14, 2, 'hello', '2024-06-07 08:25:21', 'Đã xử lý'),
(15, 2, 'hello', '2024-06-07 08:28:23', 'Đã xử lý'),
(16, 2, 'jjjj', '2024-06-07 08:28:39', 'Đã xử lý'),
(17, 2, 'hello', '2024-06-07 08:36:30', 'Đã xử lý'),
(18, 2, 'ggg', '2024-06-07 08:36:42', 'Đã xử lý');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanquyen`
--

CREATE TABLE `phanquyen` (
  `MaQuyen` int(11) NOT NULL,
  `TenQuyen` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phanquyen`
--

INSERT INTO `phanquyen` (`MaQuyen`, `TenQuyen`) VALUES
(0, 'Khách Hàng'),
(1, 'Admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(200) NOT NULL,
  `MaLoaiSP` int(11) NOT NULL,
  `MaMau` int(11) NOT NULL,
  `MaSize` int(11) NOT NULL,
  `SoLuongTon` int(11) NOT NULL,
  `HinhAnhSP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MaLoaiSP`, `MaMau`, `MaSize`, `SoLuongTon`, `HinhAnhSP`) VALUES
(179, 'Nike Air Force 107 LV8', 1, 1, 1, 50, 'NK01_2.jpeg'),
(180, 'Nike Air Force 107 LV8', 1, 1, 2, 70, 'NK01.png'),
(181, 'Nike Air Force 107 LV8', 1, 1, 3, 60, 'NK01.png'),
(182, 'Nike Air Max 90', 2, 1, 3, 70, 'NK02.png'),
(184, 'MLB Chunky Liner Mid Denim ‘Navy’', 3, 4, 5, 40, 'MLB01.png'),
(185, 'MLB Chunky Liner Mid Denim ‘Navy’', 3, 4, 6, 50, 'MLB05.JPG'),
(186, 'MLB Chunky Liner Mid Denim ‘Navy’', 3, 4, 7, 70, 'MLB01.png'),
(187, 'MLB Chunky Liner Mid Denim ‘Black’', 3, 3, 4, 50, 'MLB04.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `MaSize` int(11) NOT NULL,
  `SoSize` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`MaSize`, `SoSize`) VALUES
(1, 35),
(2, 36),
(3, 37),
(4, 38),
(5, 39),
(6, 40),
(7, 41),
(8, 42);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tintuc`
--

CREATE TABLE `tintuc` (
  `MaTin` int(11) NOT NULL,
  `TieuDeTin` varchar(200) NOT NULL,
  `NoiDungTin` varchar(200) NOT NULL,
  `NgayDangTin` datetime NOT NULL,
  `AnhTin` varchar(100) NOT NULL,
  `MaCD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tintuc`
--

INSERT INTO `tintuc` (`MaTin`, `TieuDeTin`, `NoiDungTin`, `NgayDangTin`, `AnhTin`, `MaCD`) VALUES
(1, 'LỊCH HOẠT ĐỘNG CỬA HÀNG VÀ GIAO HÀNG ONLINE - TẾT 2024', 'Mong muốn mang lại những trải nghiệm mua sắm tiện lợi cho khách hàng, Sneaker Buzz xin gửi thông báo về thời gian mở cửa của các cửa hàng và lịch giao hàng cho các kênh online trong hệ thống trong dịp', '2024-06-05 06:40:38', 'TinTuc1.webp', 1),
(2, 'E-FASHION DẦN LỘ DIỆN RÕ GIỮA GIAO LỘ VĂN HÓA ĐƯỜNG PHỐ', '“E” hóa lĩnh vực sneaker game để đa dạng hóa khả năng tiếp cận với cộng đồng thời trang 4.0, đào sâu trải nghiệm như 1 giao lộ văn hóa và câu chuyện của nhiều thương hiệu quốc tế, Sneaker Buzz tiếp tụ', '2024-06-05 06:40:39', 'TinTuc2.webp', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaidonhang`
--

CREATE TABLE `trangthaidonhang` (
  `MaTrangThai` int(11) NOT NULL,
  `TenTrangThai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaidonhang`
--

INSERT INTO `trangthaidonhang` (`MaTrangThai`, `TenTrangThai`) VALUES
(1, 'Đang xử lý'),
(2, 'Đang giao hàng'),
(3, 'Đã giao hàng'),
(4, 'Thành Công'),
(5, 'Thất Bại');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `MaUser` int(11) NOT NULL,
  `HoTen` varchar(200) NOT NULL,
  `DienThoai` varchar(11) NOT NULL,
  `TaiKhoan` varchar(20) NOT NULL,
  `MatKhau` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `DiaChi` varchar(200) NOT NULL,
  `Avatar` varchar(200) NOT NULL,
  `MaQuyen` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`MaUser`, `HoTen`, `DienThoai`, `TaiKhoan`, `MatKhau`, `Email`, `DiaChi`, `Avatar`, `MaQuyen`) VALUES
(1, 'Trần Văn A', '09123456789', 'Admin', '123', 'Admin@gmail.com', '123 ABC', '', 1),
(2, 'Lê Thị E', '09123456788', 'user', '456', 'user@gmail.com', '456 GHJ', 'AD01.png', 0),
(3, 'Quin Quin', '0123456789', '', '', 'a@gmail.com', '000', '', 0),
(4, 'Quin Quin', '0123456789', '', '', '0915159910@a', '000', '', 0),
(6, 'ddd', '4356', '', '', 'afff@gmail.com', 'rrrr', '', 0),
(7, 'ggg', '09123', '', '', '56@f', 'ggg', '', 0),
(39, 'aaaa', 'aaaaa', '', '', 'aaaaa@ghj', 'aaaa', '', 0),
(40, '', '', 'rty', 'Qq123456', 'rty@gmail.com', '', '', 0),
(41, 'eeee', '', 'eeee', 'Ss123456', 'eee@gmail.com', '', '', 0),
(42, 'ssssss', '', 'ssssss', 'Ss123456', 'sss@gmail.com', '', '', 0),
(43, 'eeee', '', 'eeee', 'Ss123456', 'eee@gmail.com', '', '', 0),
(44, 'sssss', '', 'sssss', '1234567Aa', 'chjawy.7@gmail.com', '', '', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`MaBrand`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDonHang`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaSP_2` (`MaSP`),
  ADD KEY `MaSP_3` (`MaSP`),
  ADD KEY `MaDonHang` (`MaDonHang`);

--
-- Chỉ mục cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MaGio`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaGio` (`MaGio`,`MaSP`);

--
-- Chỉ mục cho bảng `chitiettintuc`
--
ALTER TABLE `chitiettintuc`
  ADD PRIMARY KEY (`MaCTTT`),
  ADD KEY `MaTin` (`MaTin`);

--
-- Chỉ mục cho bảng `chudetintuc`
--
ALTER TABLE `chudetintuc`
  ADD PRIMARY KEY (`MaCD`);

--
-- Chỉ mục cho bảng `danhgiasanpham`
--
ALTER TABLE `danhgiasanpham`
  ADD PRIMARY KEY (`MaDG`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaUser` (`MaUser`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDonHang`),
  ADD KEY `MaKH` (`MaUser`),
  ADD KEY `MaUser` (`MaUser`,`MaTrangThai`),
  ADD KEY `MaTrangThai` (`MaTrangThai`);

--
-- Chỉ mục cho bảng `employee_responses`
--
ALTER TABLE `employee_responses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGio`),
  ADD KEY `MaUser` (`MaUser`);

--
-- Chỉ mục cho bảng `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  ADD PRIMARY KEY (`MaHT`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MaLoaiSP`),
  ADD KEY `MaBrand` (`MaBrand`);

--
-- Chỉ mục cho bảng `mausac`
--
ALTER TABLE `mausac`
  ADD PRIMARY KEY (`MaMau`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MaMess`);

--
-- Chỉ mục cho bảng `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD PRIMARY KEY (`MaQuyen`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD UNIQUE KEY `unique_product` (`MaLoaiSP`,`MaMau`,`MaSize`),
  ADD KEY `sanpham_ibfk_4` (`MaMau`),
  ADD KEY `MaSize` (`MaSize`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`MaSize`);

--
-- Chỉ mục cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`MaTin`),
  ADD KEY `MaCD` (`MaCD`);

--
-- Chỉ mục cho bảng `trangthaidonhang`
--
ALTER TABLE `trangthaidonhang`
  ADD PRIMARY KEY (`MaTrangThai`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`MaUser`),
  ADD KEY `MaQuyen` (`MaQuyen`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `MaBrand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `chitiettintuc`
--
ALTER TABLE `chitiettintuc`
  MODIFY `MaCTTT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `chudetintuc`
--
ALTER TABLE `chudetintuc`
  MODIFY `MaCD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `MaDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `employee_responses`
--
ALTER TABLE `employee_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `MaGio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `MaLoaiSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `mausac`
--
ALTER TABLE `mausac`
  MODIFY `MaMau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `MaMess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `MaSize` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `MaTin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `trangthaidonhang`
--
ALTER TABLE `trangthaidonhang`
  MODIFY `MaTrangThai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `MaUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietgiohang_ibfk_3` FOREIGN KEY (`MaGio`) REFERENCES `giohang` (`MaGio`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitiettintuc`
--
ALTER TABLE `chitiettintuc`
  ADD CONSTRAINT `chitiettintuc_ibfk_1` FOREIGN KEY (`MaTin`) REFERENCES `tintuc` (`MaTin`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaTrangThai`) REFERENCES `trangthaidonhang` (`MaTrangThai`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaUser`) REFERENCES `user` (`MaUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD CONSTRAINT `loaisanpham_ibfk_1` FOREIGN KEY (`MaBrand`) REFERENCES `brand` (`MaBrand`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaLoaiSP`) REFERENCES `loaisanpham` (`MaLoaiSP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`MaMau`) REFERENCES `mausac` (`MaMau`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`MaSize`) REFERENCES `size` (`MaSize`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `tintuc_ibfk_1` FOREIGN KEY (`MaCD`) REFERENCES `chudetintuc` (`MaCD`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`MaQuyen`) REFERENCES `phanquyen` (`MaQuyen`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
