-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 09:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `username`, `admin_email`, `admin_password`, `name`) VALUES
(1, 'admin1', 'admin@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Nguyễn Thị Tường Vy');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `danhmuc_id` int(11) NOT NULL,
  `danhmuc_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`danhmuc_id`, `danhmuc_title`) VALUES
(1, 'Tiểu thuyết'),
(2, 'Phân tích kinh tế'),
(3, 'Kỹ năng sống'),
(4, 'Manga - Comics'),
(5, 'Marketing - Bán hàng'),
(6, 'Chính trị'),
(8, 'Hài hước - Truyện cười'),
(9, 'Truyện ngắn'),
(10, 'Giáo khoa - Tham khảo'),
(11, 'Sách học ngoại ngữ'),
(12, 'Lịch sử - Địa lý - Tôn giáo');

-- --------------------------------------------------------

--
-- Table structure for table `nhaxuatban`
--

CREATE TABLE `nhaxuatban` (
  `nxb_id` int(11) NOT NULL,
  `nxb_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhaxuatban`
--

INSERT INTO `nhaxuatban` (`nxb_id`, `nxb_title`) VALUES
(2, 'NXB Trẻ'),
(4, 'Đinh Tị'),
(5, 'AZ Việt Nam'),
(6, 'Alpha Books'),
(7, 'FUJIBOOKS'),
(8, 'NXB Khác'),
(9, 'NXB Thế Giới'),
(10, 'NXB Dân Trí'),
(12, 'NXB Hồng Đức'),
(13, 'Cambridge'),
(15, 'NXB Thanh Niên'),
(16, 'NXB Hội Nhà Văn'),
(21, 'NXB Kim Đồng');

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_product` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `product_id`, `total_product`, `order_id`) VALUES
(1, 2, 1, 7),
(2, 3, 10, 7),
(3, 5, 1, 8),
(4, 3, 1, 9),
(5, 1, 1, 10),
(6, 6, 1, 10),
(7, 1, 1, 11),
(8, 5, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keyword` varchar(255) NOT NULL,
  `danhmuc_id` int(11) NOT NULL,
  `nxb_id` int(11) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL,
  `product_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keyword`, `danhmuc_id`, `nxb_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`, `product_stock`) VALUES
(1, 'Kế Toán Vỉa Hè - Thực Hành Báo Cáo Tài Chính Căn Bản Từ Quầy Bán Nước Chanh', 'Cung cấp kiến thức căn bản về kế toán doanh nghiệp', 'ketoanviahe,taichinhkinhdoanh', 5, 9, 'ketoanviahe.png', 'ketoanviahe2.png', 'ketoanviahe3.png', 55000, '2023-12-26 01:24:37', '1', 30),
(2, 'Thỏ Bảy Màu Và Những Người Nghĩ Nó Là Bạn (Tái Bản 2023)', 'Cuốn sách là những mẩu chuyện nhỏ được ghi lại bằng tranh xoay quanh Thỏ Bảy Màu và những người nghĩ nó là bạn.', 'thobaymau,tho7mau', 4, 10, 'tho7mau1.png', 'tho7mau2.png', 'tho7mau3.png', 65000, '2023-12-26 01:26:13', '1', 20),
(3, 'Tổng Ôn Ngữ Pháp Tiếng Anh (Tái Bản 2023)', ' TỔNG ÔN TẬP ngữ pháp tiếng anh- CHẮC CHẮN CÓ trong đề thi.', 'nguphaptienganh', 10, 12, 'npta1.png', 'npta2.png', 'npta3.png', 180000, '2023-12-26 01:27:18', '1', 20),
(4, '500 Bài Tập Vật Lí Trung Học Cơ Sở', 'Quyển sách là một tài liệu bổ ích cho những học sinh yêu thích môn Vật lí có điều kiện học tập tốt nhất.', 'baitapvatly', 10, 8, 'btvl1.png', 'btvl2.png', 'btvl3.png', 119000, '2023-12-26 01:29:24', '1', 10),
(5, 'Cambridge IELTS 18 Academic - With Answer + Audio', 'Cambridge for IELTS', 'sachthamkhao, cambridge', 11, 13, 'camb1.png', 'camb1.png', 'camb1.png', 209000, '2023-12-26 01:30:20', '1', 20),
(6, 'Cây Cam Ngọt Của Tôi', 'Top Tiểu thuyết', 'tieuthuyet,caycam', 1, 16, 'caycam.png', 'caycam2.png', 'caycam3.png', 71000, '2023-12-26 01:33:32', '1', 25),
(7, 'Tôi Là Bêtô (Tái Bản 2023)', 'Sáng tác mới nhất của nhà văn Nguyễn Nhật Ánh', 'tieuthuyet,beto', 1, 2, 'nxbtre_full_24352023_043531.png', 'beto2.png', 'beto3.png', 75000, '2023-12-26 01:34:48', '1', 15),
(8, 'Nhà Giả Kim (Tái Bản 2020)', 'Một câu chuyện cổ tích giản dị', 'tieuthuyet,nhagiakim', 1, 16, 'nhagiakim1.png', 'nhagiakim2.png', 'nhagiakim3.jpg', 69000, '2023-12-26 01:36:49', '1', 30),
(9, 'Slam Dunk - Deluxe Edition - Tập 1', 'Top manga về đề tài thể thao với hơn hàng nghìn khán giả shounen tại Nhật đón nhận', 'slamdunk,manga', 4, 21, 'slam-dunk---deluxe-edition-tap-1.png', 'slam-dunk---deluxe-edition-tap-1.png', 'slam-dunk---deluxe-edition-tap-1.png', 55000, '2023-12-26 01:39:03', '1', 30),
(10, 'Không Diệt Không Sinh Đừng Sợ Hãi (Tái Bản 2022)', 'Không diệt Không sinh Đừng sợ hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình', 'thichnhathanh', 12, 8, 'khongdietkhongsinh.png', '2023_02_04_09_14_54_7-390x510.png', '2023_02_04_09_14_54_8-390x510.png', 55000, '2023-12-26 01:40:15', '1', 20),
(11, 'Cho Tôi Xin Một Vé Đi Tuổi Thơ (Tái Bản 2023)', ' Sáng tác mới nhất của nhà văn Nguyễn Nhật Ánh', 'tieuthuyet', 1, 2, 'tuoitho1.png', 'tuoitho2.png', 'tuoitho3.png', 69000, '2023-12-26 01:41:26', '1', 20),
(12, 'Đề Ôn Luyện Và Tự Kiểm Tra Tiếng Việt Lớp 1 - Tập 2', ' Giúp học sinh có thể tự ôn luyện sau mỗi giai đoạn học tập', 'sachtiengviet, sachthamkhao', 10, 8, 'tv1.png', 'tv2.png', 'tv3.png', 39000, '2023-12-26 01:45:54', '1', 30),
(13, 'Kiếm Tiền Từ Tiktok Bẳng Cách Nào', 'Đón nhận Top đầu, đừng lạc hậu', 'tiktok,kiemtien', 2, 8, '9786043935370.png', '9786043935370.png', '9786043935370.png', 100000, '2023-12-26 01:47:20', '1', 20),
(14, 'Tết Ở Làng Địa Ngục', 'Năm đó, tại một ngôi làng xa xôi trên một ngọn núi hoang vu, người ta đón Tết trong sự kinh hãi tột độ, hoài nghi đau đáu và giận dữ khôn cùng trước sự ập tới của những bi kich tàn khốc', 'tetolangdianguc,ma', 1, 15, 'tetolangdn1.png', 'tetolangdn2.png', '', 100000, '2023-12-26 01:50:08', '1', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `total_price`, `invoice_number`, `order_date`, `order_status`) VALUES
(7, 5, 245000, 926532, '2024-12-15 12:10:54', 'confirmed'),
(8, 5, 209000, 516064, '2024-12-15 12:11:11', 'cancelled'),
(9, 5, 180000, 894287, '2024-12-15 16:20:28', 'confirmed'),
(10, 5, 126000, 393185, '2024-12-16 07:55:11', 'confirmed'),
(11, 5, 264000, 746723, '2024-12-16 07:55:57', 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_fullname`, `user_email`, `user_password`, `user_phone`, `user_address`) VALUES
(5, 'Nguyễn Thị Tường Vy', 'tuongvy140703@gmail.com', '$2y$10$lp6k6ZHn6zjbTNnltG15furzOfazRy0/euxDaR21z/F.33WQbOnDS', '0703878957', 'Q8'),
(6, 'Nguyễn Tường Vy', 'nvy140703@gmail.com', '$2y$10$9KVUHRTMxL65FzGFwAYy5O7NOjILwjsztwPBJLNEUEO2swyQ6zJuO', '0703878957', 'Q7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `fk_user_cart` (`user_id`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`danhmuc_id`);

--
-- Indexes for table `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  ADD PRIMARY KEY (`nxb_id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pro_od` (`product_id`),
  ADD KEY `fk_ud_od` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `danhmuc_id` (`danhmuc_id`),
  ADD KEY `nxb_id` (`nxb_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `danhmuc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  MODIFY `nxb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `fk_pro_cart` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_cart` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD CONSTRAINT `orders_pending_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_pending_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_pro_od` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ud_od` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`danhmuc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`nxb_id`) REFERENCES `nhaxuatban` (`nxb_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `user_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
