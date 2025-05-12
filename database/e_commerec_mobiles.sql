-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 08:50 PM
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
-- Database: `e_commerec_mobiles`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Hamed Almoree', 'h55180d@gmail.com', 'hamd', '123123', '2025-05-09 21:24:23'),
(2, 'df', 'h55180d@gmail.com', 'dsf', 'sdf', '2025-05-10 13:29:12'),
(3, 'Hamed Almoree', 'h55180d@gmail.com', '123', 'wwwwwwwwwwwwwwwwwwwwwwwww', '2025-05-10 16:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `offer_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `offer_name`, `discount`, `product_image`, `offer_description`, `created_at`) VALUES
(1, 'hadsfcsdf', 10.00, '../uploads/offer_681f27f9ce145.png', '12ewqd213', '2025-05-10 10:18:33'),
(2, 'dd', 999.99, '../uploads/offer_681f293e5f000.png', 'df', '2025-05-10 10:18:52'),
(3, 'hadsfcsdf', 22.00, '../uploads/offer_681f6bc496614.png', 'ewfesd', '2025-05-10 15:07:48'),
(4, 'hadsfcsdf', 11.00, '../uploads/offer_681f7f82e1fa9.jpg', '11111111', '2025-05-10 16:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`) VALUES
(6, 31, 140.00, '2025-05-10 16:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `quantity`) VALUES
(16, 'سامسونج جوال جالكسي S24 FE', 'بالذكاء الاصطناعي، هاتف ذكي بنظام اندرويد غير مقفل 128GB، كاميرا عالية الدقة 50MP، عمر بطارية طويل، شاشة عرض اكثر سطوعا، اصدار...', 500.00, 'PRD_681f768d59a3e3.69794320.jpg', '2025-05-10 15:53:49', 5),
(17, 'سامسونج غطاء حماية مضاد للانعكاس لموبايل جالاكسي S25', 'واقي شاشة الهاتف، رؤية متزايدة، حماية من الغبار وبصمات الأصابع، مضاد للخدش، اصدار امريكي، EF-US931CTEGUS', 100.00, 'PRD_681f77db5945a3.01959727.jpg', '2025-05-10 15:59:23', 20),
(18, 'ساوند كور سماعات راس Q20i', 'هايبرد اكتيف بخاصية الغاء الضوضاء من انكر بلوتوث لاسلكي فوق الاذن، وقت تشغيل طويل 40 ساعة، صوت عالي الدقة، صوت جهير كبير، تخصيص عبر تطبيق، وضع الشفافية', 140.00, 'PRD_681f7849786cc1.44343377.jpg', '2025-05-10 16:01:13', 11),
(19, 'كاسيتي حافظة ايفون 13 مدمجة [4 قدم 2X', 'حماية من السقوط من الدرجة العسكرية/نحيفة/خفيفة الوزن] - سحابة - اسود شفاف', 20.00, 'PRD_681f78bf9a8905.56017266.jpg', '2025-05-10 16:03:11', 32),
(20, 'كابل ‘USB للطابعة من أوغرين؛ كابل USB2.0', 'نوع أيه ذكر إلى نوع بي ذكر لطابعة المسح الضوئي، كابل عالي السرعة لطابعات BRAZARD، HB، كانون، ليكسمارك،...', 21.00, 'PRD_681f79607902f9.46101593.jpg', '2025-05-10 16:05:52', 110),
(21, 'سامسونج جوال جالكسي S24 الترا ذكي 256GB', 'بالذكاء الاصطناعي بنظام اندرويد غير مقفل بدقة 200MP وكاميرا تكبير 100x ومعالج سريع وعمر بطارية طويل وشاشة من الحافة الى الحافة وقلم S اصدار امريكي، 2024، رمادي', 600.00, 'PRD_681f79c90df077.51124094.jpg', '2025-05-10 16:07:37', 4),
(22, 'لابتوب ناكلود ويندوز 11، لابتوب 17.3 انش مع معالج كور i3، 4GB DDR3 128GB SSD', '(قابلة للتوسيع 1TB)، بطارية 60800mWh FHD، شاشة IPS نوع C، HDMI، واي فاي 5G،...', 1500.00, 'PRD_681f7bb1d031b2.33489461.jpg', '2025-05-10 16:15:45', 2),
(23, 'لابتوب كايجر 2025 بمعالج انتل رباعي النواة (حتى 3.6GHz)', '16GB DDR4 512GB SSD ويندوز 11، 15.6 انش IPS 1080P، هيكل معدني، USB3.2', 1400.00, 'PRD_681f7c036d9fa5.07945185.jpg', '2025-05-10 16:17:07', 3),
(24, 'ايسر لابتوب اسباير 3 A315-24P-R7VH رفيع بشاشة 15.6', 'انش FHD IPS ومعالج AMD رايزن 3 7320U رباعي النواة وبطاقة رسومات AMD راديون وLPDDR5 8GB وذاكرة مستديمة SSD 128GB وواي فاي 6 وويندوز 11 هوم في وضع S', 2500.00, 'PRD_681f7d567ba626.05806086.jpg', '2025-05-10 16:22:46', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass`, `profile_pic`, `last_login`, `role`) VALUES
(22, 'Admin', 'admin@example.com', '$2y$10$OmCLWj6TD87jeXkOW5Jl2..vlwg6ThrhJlwzUlbA5Ti1k4snuvfUi', NULL, '2025-05-08 12:04:05', 'admin'),
(26, 'محمد مهدي', 'mhde@gmail.com', '$2y$10$cYi0p8BnZEWLy4mmLk2zoOgWJbGA7Vvl2pgftJeMb7yBNZxLpmoDO', 'IMG_681d00c81d2389.86003477.jpg', '2025-05-10 18:38:18', 'user'),
(31, 'حامد المرعي', 'hamid22@gmail.com', '$2y$10$RZg3cVnF2NyfVhpY0NXnxuuuCGPnwE0cCNfhqzmU9n4eln/mUWZ0q', 'IMG_681f7ed0cf4947.16917167.jpg', '2025-05-10 19:27:03', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
