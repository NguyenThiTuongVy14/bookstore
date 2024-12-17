-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 10:07 AM
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

--
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`product_id`, `user_id`, `quantity`) VALUES
(2, 5, 1);

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
(8, 5, 1, 11),
(9, 17, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_description` mediumtext NOT NULL,
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

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `danhmuc_id`, `nxb_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`, `product_stock`) VALUES
(1, 'Kế Toán Vỉa Hè - Thực Hành Báo Cáo Tài Chính Căn Bản Từ Quầy Bán Nước Chanh', 'Cuốn sách này cung cấp kiến thức cơ bản về kế toán doanh nghiệp, nhưng không đi theo những lý thuyết khô khan mà thay vào đó là những tình huống thực tế và dễ hiểu. Qua hình ảnh của một quầy bán nước chanh, tác giả giải thích cách thức vận hành hệ thống kế toán và tài chính từ những yếu tố đơn giản nhất. Đây là cuốn sách thích hợp cho những ai muốn bắt đầu học kế toán một cách dễ dàng và gần gũi.', 5, 9, 'ketoanviahe.png', 'ketoanviahe2.png', 'ketoanviahe3.png', 55000, '2024-12-16 14:26:56', '1', 30),
(2, 'Thỏ Bảy Màu Và Những Người Nghĩ Nó Là Bạn (Tái Bản 2023)', 'Đây là cuốn sách kể về những mẩu chuyện nhỏ xung quanh cuộc sống của Thỏ Bảy Màu, một nhân vật dễ thương và ngây thơ. Mỗi câu chuyện đều chứa đựng những bài học về tình bạn, sự sẻ chia và những giá trị đơn giản trong cuộc sống. Các hình vẽ sinh động và ngộ nghĩnh giúp trẻ em dễ dàng tiếp cận, đồng thời mỗi câu chuyện đều mang đến những thông điệp sâu sắc về lòng nhân ái và sự tôn trọng lẫn nhau.', 4, 10, 'tho7mau1.png', 'tho7mau2.png', 'tho7mau3.png', 65000, '2024-12-16 14:27:11', '1', 20),
(3, 'Tổng Ôn Ngữ Pháp Tiếng Anh (Tái Bản 2023)', 'Cuốn sách này là một tài liệu hữu ích cho những ai đang ôn luyện ngữ pháp tiếng Anh, đặc biệt là các thí sinh chuẩn bị cho các kỳ thi. Các bài học được sắp xếp theo hệ thống, bao gồm tất cả các cấu trúc ngữ pháp cần thiết và thường xuyên xuất hiện trong các đề thi. Cuốn sách này không chỉ giúp người học nắm vững kiến thức ngữ pháp mà còn cung cấp các bài tập luyện tập để chắc chắn rằng bạn sẽ không bị bất ngờ với bất kỳ câu hỏi nào trong kỳ thi.', 10, 12, 'npta1.png', 'npta2.png', 'npta3.png', 180000, '2024-12-16 14:27:20', '1', 20),
(4, '500 Bài Tập Vật Lí Trung Học Cơ Sở', 'Cuốn sách này là tài liệu tham khảo tuyệt vời dành cho học sinh yêu thích môn Vật lý, đặc biệt là các bạn học sinh Trung học cơ sở. Với 500 bài tập phong phú và đa dạng, cuốn sách giúp học sinh nắm vững kiến thức lý thuyết cũng như thực hành các kỹ năng giải quyết vấn đề trong Vật lý. Các bài tập được phân loại rõ ràng theo từng chủ đề và mức độ khó dễ, từ đó giúp người học nâng cao khả năng tư duy khoa học.', 10, 8, 'btvl1.png', 'btvl2.png', 'btvl3.png', 119000, '2024-12-16 14:27:32', '1', 10),
(5, 'Cambridge IELTS 18 Academic - With Answer + Audio', 'Đây là một trong những bộ sách tham khảo hàng đầu dành cho những ai chuẩn bị thi IELTS, đặc biệt là đối với phần thi Academic. Cuốn sách này không chỉ cung cấp các đề thi mô phỏng giống như thật mà còn có phần đáp án chi tiết, giúp người học hiểu rõ vì sao lựa chọn đó là đúng. Hơn nữa, sách còn đi kèm với audio giúp người học luyện nghe hiệu quả, nâng cao kỹ năng nghe và nói trong kỳ thi IELTS.', 11, 13, 'camb1.png', 'camb1.png', 'camb1.png', 209000, '2024-12-16 14:27:41', '1', 20),
(6, 'Cây Cam Ngọt Của Tôi', 'Đây là cuốn tiểu thuyết nổi tiếng của tác giả Đoàn Lê Minh, kể về câu chuyện đầy cảm động và chân thành của một gia đình nghèo khó nhưng luôn đậm tình yêu thương. Qua mỗi trang sách, người đọc sẽ thấy được sự lớn lên của các nhân vật, sự thay đổi trong cách họ nhìn nhận cuộc sống và những khó khăn mà họ phải đối mặt. Đặc biệt, hình ảnh cây cam ngọt là một biểu tượng của hy vọng, tình yêu và sự đoàn kết trong gia đình.', 1, 16, 'caycam.png', 'caycam2.png', 'caycam3.png', 71000, '2024-12-16 14:27:52', '1', 25),
(7, 'Tôi Là Bêtô (Tái Bản 2023)', 'Đây là một sáng tác mới nhất của nhà văn Nguyễn Nhật Ánh, kể về câu chuyện của một chú bêto (bé hạt giống) tìm kiếm con đường của riêng mình. Cuốn sách này không chỉ mang đến những tình huống hài hước, dễ thương mà còn khắc họa sâu sắc những tình cảm phức tạp trong tình bạn, tình yêu và gia đình. Tái bản năm 2023, cuốn sách vẫn giữ nguyên sức hút đối với những độc giả yêu thích phong cách viết trẻ trung và lạc quan của Nguyễn Nhật Ánh.', 1, 2, 'nxbtre_full_24352023_043531.png', 'beto2.png', 'beto3.png', 75000, '2024-12-16 14:28:01', '1', 15),
(8, 'Nhà Giả Kim (Tái Bản 2020)', 'Đây là một trong những tác phẩm nổi tiếng của tác giả Paulo Coelho. Cuốn sách kể về hành trình của một chàng trai trẻ tên Santiago, người đi tìm kho báu, nhưng trên thực tế, hành trình ấy lại là sự khám phá chính bản thân và những giá trị trong cuộc sống. Với lối viết đơn giản, nhẹ nhàng nhưng sâu sắc, tác phẩm này đã trở thành một cẩm nang về triết lý sống, khuyến khích người đọc tìm kiếm và theo đuổi ước mơ của chính mình.', 1, 16, 'nhagiakim1.png', 'nhagiakim2.png', 'nhagiakim3.jpg', 69000, '2024-12-16 14:28:09', '1', 30),
(9, 'Slam Dunk - Deluxe Edition - Tập 1', 'Đây là một bộ manga nổi tiếng về môn thể thao bóng rổ, được yêu thích bởi hàng triệu người trên khắp thế giới. Slam Dunk kể về hành trình của Hanamichi Sakuragi, một học sinh trung học vụng về nhưng đam mê bóng rổ. Cuốn sách không chỉ thu hút bởi các pha hành động gay cấn mà còn bởi những câu chuyện về tình bạn, nỗ lực và lòng kiên trì. Phiên bản Deluxe này được tái bản với chất lượng hình ảnh cao và các chi tiết bổ sung hấp dẫn, dành cho những ai yêu thích bộ manga này.', 4, 21, 'slam-dunk---deluxe-edition-tap-1.png', 'slam-dunk---deluxe-edition-tap-1.png', 'slam-dunk---deluxe-edition-tap-1.png', 55000, '2024-12-16 14:28:16', '1', 30),
(10, 'Không Diệt Không Sinh Đừng Sợ Hãi (Tái Bản 2022)', 'Không diệt Không sinh Đừng sợ hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình', 12, 8, 'khongdietkhongsinh.png', '2023_02_04_09_14_54_7-390x510.png', '2023_02_04_09_14_54_8-390x510.png', 55000, '2023-12-26 01:40:15', '1', 20),
(11, 'Cho Tôi Xin Một Vé Đi Tuổi Thơ (Tái Bản 2023)', 'Cuốn sách này tiếp tục mang đậm phong cách viết của Nguyễn Nhật Ánh, khi tái hiện những kỷ niệm đẹp của tuổi thơ qua các câu chuyện của những người bạn thân thiết, những buổi đi chơi và những niềm vui giản dị. Cuốn sách chứa đựng sự tươi mới, nhẹ nhàng nhưng cũng đầy cảm xúc, gợi lại những ký ức ngọt ngào của một thời tuổi thơ, khi mà những điều đơn giản nhất lại có thể mang lại hạnh phúc.', 1, 2, 'tuoitho1.png', 'tuoitho2.png', 'tuoitho3.png', 69000, '2024-12-16 14:28:35', '1', 20),
(12, 'Đề Ôn Luyện Và Tự Kiểm Tra Tiếng Việt Lớp 1 - Tập 2', ' Giúp học sinh có thể tự ôn luyện sau mỗi giai đoạn học tập', 10, 8, 'tv1.png', 'tv2.png', 'tv3.png', 39000, '2023-12-26 01:45:54', '1', 30),
(13, 'Kiếm Tiền Từ Tiktok Bẳng Cách Nào', 'Đây là một cuốn sách dành cho những ai muốn tận dụng sức mạnh của nền tảng Tiktok để kiếm tiền. Sách chia sẻ những phương pháp, chiến lược để tạo ra các video hấp dẫn, tăng lượt theo dõi và thu nhập từ Tiktok. Cuốn sách này rất phù hợp với những người muốn tham gia vào thị trường Tiktok nhưng chưa biết bắt đầu từ đâu.\n\n', 2, 8, '9786043935370.png', '9786043935370.png', '9786043935370.png', 100000, '2024-12-16 14:28:56', '1', 20),
(14, 'Tết Ở Làng Địa Ngục', 'Cuốn sách này mang đến một câu chuyện đầy bi kịch về một ngôi làng xa xôi trên một ngọn núi, nơi người dân sống trong sự sợ hãi và đau khổ. Những cuộc sống bị đe dọa bởi những sự kiện kỳ lạ, và mọi thứ đều được tô đậm bằng sự kỳ bí và sự bất an. Đây là một câu chuyện về sự kiên cường và nỗi đau mà mỗi con người phải đối mặt khi cuộc sống không còn là những điều bình yên.', 1, 15, 'tetolangdn1.png', 'tetolangdn2.png', '', 100000, '2024-12-16 14:29:10', '1', 20),
(17, 'Tàu ngầm sắt màu đen - Conan movie 26', 'Câu chuyện bắt đầu khi Shinichi Kudo (thám tử Conan) và nhóm bạn của mình, bao gồm Ran, Kogoro Mouri, và một số người khác, vô tình vướng phải một vụ án liên quan đến một tàu ngầm bí ẩn mang tên \"Tàu ngầm sắt màu đen\". Tàu ngầm này là một phần của một dự án quân sự khổng lồ, có liên quan đến một tổ chức tội phạm quốc tế đang cố gắng chiếm đoạt công nghệ hạt nhân để phục vụ cho mục đích riêng.  Trong quá trình điều tra, Conan phát hiện ra rằng tàu ngầm này không chỉ là phương tiện quân sự, mà còn là nơi chứa đựng những bí mật đen tối và những kẻ phản bội có khả năng gây ra những thảm họa khủng khiếp. Đội thám tử của Conan phải đối mặt với những tình huống nguy hiểm khi họ rượt đuổi những kẻ tội phạm và cố gắng ngăn chặn một cuộc khủng hoảng hạt nhân có thể xảy ra.', 4, 21, 'conan1.png', 'conan2.png', 'conan3.png', 50000, '2024-12-16 15:26:28', '1', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(100) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `total_price`, `invoice_number`, `order_date`, `order_status`) VALUES
(7, 5, 245000, 926532, '2024-12-15 12:10:54', 'pending'),
(8, 5, 209000, 516064, '2024-12-15 12:11:11', 'cancelled'),
(9, 5, 180000, 894287, '2024-12-15 16:20:28', 'confirmed'),
(10, 5, 126000, 393185, '2024-12-16 07:55:11', 'confirmed'),
(11, 5, 264000, 746723, '2024-12-16 07:55:57', 'confirmed'),
(12, 5, 50000, 760852, '2024-12-16 15:28:54', 'pending');

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
(6, 'Nguyễn Tường Vy', 'nvy140703@gmail.com', '$2y$10$9KVUHRTMxL65FzGFwAYy5O7NOjILwjsztwPBJLNEUEO2swyQ6zJuO', '0703878957', 'Q7'),
(7, 'Nguyễn Thị Hòa', 'nguyenthienhoatpk@gmail.com', '$2y$10$6y8JdjT5xzjmbu0gKddcAO9RD8sOHgP.AWMF43xEDWX4gN.kKISQa', '01234567890', 'Q8');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
