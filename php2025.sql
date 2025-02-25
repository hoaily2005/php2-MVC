-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 17, 2025 lúc 05:31 PM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php2025`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `cart_session` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sku` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `cart_session`, `sku`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(15, NULL, '1g6gvroboe69onbptmkai24i3a', 'SKU864430', 1, 1000000.00, '2025-02-10 17:42:14', '2025-02-10 17:42:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(20, 'Áo ', 'rẻ', '2025-01-16 03:45:33'),
(21, 'danh mục 2a', 'ok', '2025-01-18 15:53:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `name`) VALUES
(2, 'Đỏ'),
(3, 'Xanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(20,2) NOT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `payment_method` enum('cod','vnpay','momo') NOT NULL,
  `shipping_address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_status`, `payment_method`, `shipping_address`, `created_at`, `updated_at`) VALUES
(43, 6, 1000000.00, 'pending', 'cod', 'VIE', '2025-02-17 16:55:58', '2025-02-17 16:55:58'),
(45, 6, 100000.00, 'pending', 'cod', 'VIE', '2025-02-17 16:56:34', '2025-02-17 16:56:34'),
(46, 6, 200000.00, 'failed', 'cod', 'VIE', '2025-02-17 16:56:45', '2025-02-17 17:04:34'),
(47, 6, 200000.00, 'failed', 'cod', 'VIE', '2025-02-17 16:56:54', '2025-02-17 17:28:20'),
(48, 22, 200000.00, 'pending', 'cod', 'VIE', '2025-02-17 17:29:23', '2025-02-17 17:29:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_variant_id` int NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` int GENERATED ALWAYS AS ((`quantity` * `price`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_variant_id`, `price`, `quantity`) VALUES
(29, 45, 24, 100000, 1),
(30, 46, 26, 200000, 1),
(31, 47, 28, 200000, 1),
(32, 48, 26, 200000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(25, 'demo1@gmail.com', '596db7fb66740bf2e80974598b897025fe6c2330b987e0af7478cf08547313ee', 1737305844, '2025-01-19 15:57:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int NOT NULL DEFAULT '0',
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `quantity`, `category_id`) VALUES
(38, 'MU Home (2024-2025) Màu đỏ + Cộc tay ', 'Giá Rẻ', 1000000.00, 'uploads/photo-2024-07-03-00-19-17.jpeg', '2025-02-05 15:29:57', 10, 20),
(42, 'MU Away (2024-2025) Màu xanh + Cộc tay', '✪ ĐẶC ĐIỂM SẢN PHẨM ✪ :\r\n\r\n- Logo cao su dán Cực tinh tế và chắc chắn\r\n\r\n- Chất liệu: Vải Thái cao cấp\r\n\r\n- KHÔNG NHĂN – KHÔNG XÙ – KHÔNG PHAI\r\n\r\n- Thấm hút mồ hôi cực tốt', 100000.00, 'uploads/photo-2024-07-25-20-26-21-copy-1.jpg', '2025-02-05 17:44:27', 11, 20),
(43, 'Argentina Home (2024 - 2025) Màu xanh', 'Áo đẹp lắm', 220000.00, 'uploads/photo-2024-07-01-20-38-03.jpeg', '2025-02-05 17:54:13', 22, 21),
(44, 'TBN Home (2024 - 2025) Màu Đỏ + Cộc tay', 'xzx', 1000000.00, 'uploads/photo-2024-07-04-14-22-26.jpg', '2025-02-06 03:25:22', 22, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_variants`
--

CREATE TABLE `products_variants` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `color_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products_variants`
--

INSERT INTO `products_variants` (`id`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `sku`, `image`) VALUES
(24, 38, 7, 2, 100, 100000, 'SKU864430', 'uploads/67ad5ff8e16f2-photo-2024-09-03-20-15-40.jpeg'),
(26, 42, 7, 2, 11, 200000, 'SKU164505', 'uploads/67a4f97fd7f52-photo-2024-09-03-20-15-41.jpeg'),
(28, 43, 7, 3, 11, 200000, 'SKU975012', 'uploads/67a4fb6f7b4ab-photo-2024-06-26-13-25-12.jpeg'),
(30, 38, 12, 3, 11, 12345, 'SKU902982', 'uploads/67ad5fec8c225-photo-2024-07-25-20-26-21-copy-1.jpg'),
(44, 44, 7, 2, 11, 1000000, 'SKU827953', 'uploads/photo-2024-09-03-20-15-40.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_main`) VALUES
(17, 42, 'uploads/photo-2024-07-25-20-26-21-copy-1.jpg', 1),
(18, 43, 'uploads/photo-2024-07-01-20-38-03.jpeg', 1),
(19, 44, 'uploads/photo-2024-07-04-14-22-26.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(7, 'XL'),
(12, 'XLX');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `auth_provider` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'local',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `auth_provider`, `created_at`, `updated_at`) VALUES
(6, 'Hoài Lý', 'hoailxpk03594@gmail.com', '$2y$10$KNuSfH6i1Mkjx560/fUriu4wznx.PunaSxFciu/U8XFYHk2wTmB.u', '123456789', 'admin', 'local', '2025-01-10 01:32:16', '2025-01-16 02:58:25'),
(22, 'Tin Hot', 'hoailx@gmail.com', '$2y$10$Lc1l4i9.ZSF0UB9FH3H/quJbQDS2SuirwskZO2ONvKC4q0QdA2qmi', NULL, 'admin', 'local', '2025-01-12 09:08:59', '2025-01-21 03:49:03'),
(30, 'hoài lý', 'lyxuanhoai18@gmail.com', '$2y$10$08ILKtje.i1hkSOMBUt/X.ANmzVXcoWPSnCnf1lgIl6qyIn.frKwa', '9959835', 'user', 'local', '2025-01-15 15:41:04', '2025-02-05 16:18:30'),
(35, 'Hoài Lý', 'adanuticateton4145@gmail.com', NULL, NULL, 'user', 'google', '2025-02-05 17:29:38', '2025-02-05 17:29:38');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_unique` (`token`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Chỉ mục cho bảng `products_variants`
--
ALTER TABLE `products_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `products_variants`
--
ALTER TABLE `products_variants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_variant_id`) REFERENCES `products_variants` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products_variants`
--
ALTER TABLE `products_variants`
  ADD CONSTRAINT `products_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_variants_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_variants_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
