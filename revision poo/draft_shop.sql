-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2025 at 03:14 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `draft_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Vêtement ', 'rangement habit', '2025-10-29 14:30:31', '2025-10-29 14:30:31'),
(12, 'multimedia', 'Catégorie des appareils multimedia.', '2025-10-23 13:57:53', '2025-10-23 13:57:53'),
(25, 'Meubles', 'Catégorie de meubles divers.', '2025-10-23 13:58:04', '2025-10-23 13:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `id` int NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `material_fee` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`id`, `size`, `color`, `type`, `material_fee`, `product_id`) VALUES
(12, 'S', 'vert', 'coton', 222, 78),
(13, 'S', 'vert', 'coton', 222, 80),
(14, 'XL', 'rouge', 'pantalon', 500, 83),
(15, 'XL', 'rouge', 'pantalon', 500, 84),
(16, 'S', 'vert', 'coton', 222, 86),
(17, 'S', 'vert', 'coton', 222, 87),
(18, 'S', 'vert', 'coton', 222, 89),
(19, 'S', 'vert', 'coton', 222, 91),
(20, 'S', 'vert', 'coton', 222, 93),
(21, 'S', 'vert', 'coton', 222, 95);

-- --------------------------------------------------------

--
-- Table structure for table `electronic`
--

CREATE TABLE `electronic` (
  `id` int NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `warranty_fee` int NOT NULL,
  `product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `electronic`
--

INSERT INTO `electronic` (`id`, `brand`, `warranty_fee`, `product_id`) VALUES
(3, 'nintendo', 22, 79),
(4, 'SEGA', 22, 81),
(15, 'Samsung', 55, 2),
(25, 'Apple', 200, 3),
(26, 'Sony', 22, 92),
(27, 'Sony', 22, 94),
(28, 'Sony', 22, 96);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int DEFAULT NULL,
  `description` text,
  `quantity` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `quantity`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Chaise design', 150, 'Une chaise confortable au design moderne.', 10, '2025-10-23 11:35:48', '2025-10-23 11:35:48', 25),
(2, 'Ecran 4K', 300, 'Un écran haute résolution pour une expérience visuelle immersive.', 5, '2025-10-23 11:35:58', '2025-10-23 11:35:58', 12),
(3, 'Smartphone', 200, 'Telephone', 15, '2025-10-23 16:09:52', '2025-10-23 16:09:52', 12),
(12, 'Table de jardin', 450, 'Belle table de jardin en teck', 10, '2025-10-29 09:18:45', '2025-10-29 09:18:45', 25),
(78, 'pyjama', 220, 'pyjama enfant', 2, '2025-01-01 10:00:00', '2025-01-01 10:00:00', 6),
(79, 'nintendo switch', 1000, 'console', 2, '2025-10-30 10:20:24', '2025-10-30 10:20:24', 12),
(80, 'Pull épais d\'hiver', 99, 'Un pull chaud et confortable pour les journées froides.', 50, '2025-01-01 10:00:00', '2025-01-01 10:00:00', 6),
(81, 'Sega Saturn', 1000, 'console', 2, '2025-10-30 09:03:14', '2025-10-30 09:03:14', 12),
(83, 'jean', 100, 'jean de luxe', 2, '2025-10-31 10:04:33', '2025-10-31 10:04:33', 6),
(84, 'jean', 100, 'jean de luxe', 2, '2025-10-31 10:11:45', '2025-10-31 10:11:45', 6),
(86, 'manteau', 220, 'manteau enfant', 2, '2025-11-03 14:14:35', '2025-11-03 14:14:35', 6),
(87, 'manteau', 220, 'manteau enfant', 2, '2025-11-03 14:15:57', '2025-11-03 14:15:57', 6),
(88, 'PS2', 1000, 'console', 2, '2025-11-03 14:15:57', '2025-11-03 14:15:57', 12),
(89, 'manteau', 220, 'manteau enfant', 2, '2025-11-04 15:58:44', '2025-11-04 15:58:44', 6),
(90, 'PS2', 1000, 'console', 2, '2025-11-04 15:58:45', '2025-11-04 15:58:45', 12),
(91, 'manteau', 220, 'manteau enfant', 2, '2025-11-04 16:10:46', '2025-11-04 16:10:46', 6),
(92, 'PS2', 1000, 'console', 2, '2025-11-04 16:10:46', '2025-11-04 16:10:46', 12),
(93, 'manteau', 220, 'manteau enfant', 2, '2025-11-04 16:10:47', '2025-11-04 16:10:47', 6),
(94, 'PS2', 1000, 'console', 2, '2025-11-04 16:10:47', '2025-11-04 16:10:47', 12),
(95, 'manteau', 220, 'manteau enfant', 2, '2025-11-04 16:12:35', '2025-11-04 16:12:35', 6),
(96, 'PS2', 1000, 'console', 2, '2025-11-04 16:12:35', '2025-11-04 16:12:35', 12);

-- --------------------------------------------------------

--
-- Table structure for table `product_photo`
--

CREATE TABLE `product_photo` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_photo`
--

INSERT INTO `product_photo` (`id`, `product_id`, `photo_url`) VALUES
(13, 78, 'https://picsum.photos/9000/3000'),
(14, 79, 'https://picsum.photos/98/400'),
(15, 80, 'https://picsum.photos/9000/3000'),
(16, 81, 'https://picsum.photos/98/30000'),
(17, 83, 'https://picsum.photos/988/300'),
(18, 84, 'https://picsum.photos/988/300'),
(19, 86, 'https://picsum.photos/9000/3000'),
(20, 87, 'https://picsum.photos/9000/3000'),
(21, 89, 'https://picsum.photos/9000/3000'),
(22, 91, 'https://picsum.photos/9000/3000'),
(23, 92, 'https://picsum.photos/98/300'),
(24, 93, 'https://picsum.photos/9000/3000'),
(25, 94, 'https://picsum.photos/98/300'),
(26, 95, 'https://picsum.photos/9000/3000'),
(27, 96, 'https://picsum.photos/98/300');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `electronic`
--
ALTER TABLE `electronic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `electronic_ibfk_2` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_photo`
--
ALTER TABLE `product_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `electronic`
--
ALTER TABLE `electronic`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `product_photo`
--
ALTER TABLE `product_photo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clothing`
--
ALTER TABLE `clothing`
  ADD CONSTRAINT `clothing_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `electronic`
--
ALTER TABLE `electronic`
  ADD CONSTRAINT `electronic_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_photo`
--
ALTER TABLE `product_photo`
  ADD CONSTRAINT `product_photo_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
