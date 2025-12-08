-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 18, 2025 lúc 02:43 PM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `datn`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `auths`
--

CREATE TABLE `auths` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `product_link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `location_id`, `image`, `name`, `status`, `product_link`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'banner1.jpg', 'Sale 50%', 1, '/products/1', '2025-10-03', '2025-10-13', '2025-10-03 23:28:17', NULL),
(2, 1, 'banner2.jpg', 'New Arrival', 1, '/products/2', '2025-10-03', '2025-10-18', '2025-10-03 23:28:17', NULL),
(3, 2, 'banner3.jpg', 'Flash Sale', 1, '/products/3', '2025-10-03', '2025-10-08', '2025-10-03 23:28:17', NULL),
(4, 3, 'banner4.jpg', 'Back to School', 1, '/products/4', '2025-10-03', '2025-10-23', '2025-10-03 23:28:17', NULL),
(5, 2, 'banner5.jpg', 'Hot Deal', 1, '/products/5', '2025-10-03', '2025-10-10', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `voucher_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `voucher_id`, `quantity`, `price`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 500000.00, 450000.00, '2025-10-03 23:28:17', NULL),
(2, 2, 2, 1, 150000.00, 120000.00, '2025-10-03 23:28:17', NULL),
(3, 3, NULL, 3, 900000.00, 900000.00, '2025-10-03 23:28:17', NULL),
(4, 4, 3, 1, 350000.00, 250000.00, '2025-10-03 23:28:17', NULL),
(5, 5, 4, 5, 2000000.00, 1930000.00, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_details`
--

CREATE TABLE `cart_details` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_variant_id` bigint UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_details`
--

INSERT INTO `cart_details` (`id`, `cart_id`, `product_variant_id`, `price`, `quantity`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 250000.00, 2, 500000.00, '2025-10-03 23:28:17', NULL),
(2, 2, 3, 150000.00, 1, 150000.00, '2025-10-03 23:28:17', NULL),
(3, 3, 4, 350000.00, 2, 700000.00, '2025-10-03 23:28:17', NULL),
(4, 3, 5, 500000.00, 1, 500000.00, '2025-10-03 23:28:17', NULL),
(5, 4, 2, 260000.00, 1, 260000.00, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Thời trang Nam', 'thoi-trang-nam', 'Quần áo nam', '2025-10-03 23:28:17', '2025-10-26 23:53:49', NULL),
(2, NULL, 'Thời trang Nữ', 'thoi-trang-nu', 'Quần áo nữ', '2025-10-03 23:28:17', NULL, NULL),
(3, NULL, 'Phụ kiện', 'phu-kien', 'Phụ kiện thời trang', '2025-10-03 23:28:17', NULL, NULL),
(4, NULL, 'Giày dép', 'giay-dep', 'Các loại giày dép', '2025-10-03 23:28:17', NULL, NULL),
(5, NULL, 'Túi xách', 'tui-xach', 'Túi xách cao cấp', '2025-10-03 23:28:17', NULL, NULL),
(6, 1, 'T Shirt', 't-shirt', 's', '2025-10-16 14:13:35', '2025-11-17 01:39:05', '2025-11-16 18:39:05'),
(11, 1, 'Sweater', 'sweater', NULL, '2025-10-27 13:00:21', '2025-11-06 12:56:54', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `is_message_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `admin_id`, `is_message_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(2, 2, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(3, 3, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(4, 4, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(5, 5, NULL, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_details`
--

CREATE TABLE `chat_details` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_details`
--

INSERT INTO `chat_details` (`id`, `chat_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Shop ơi còn hàng không?', 0, 1, '2025-10-03 23:28:17', NULL),
(2, 1, 5, 1, 'Còn bạn nhé', 1, 1, '2025-10-03 23:28:17', NULL),
(3, 2, 2, 5, 'Ship về Hải Phòng nhanh ko?', 0, 1, '2025-10-03 23:28:17', NULL),
(4, 3, 3, 5, 'Mình muốn đổi size', 0, 1, '2025-10-03 23:28:17', NULL),
(5, 4, 4, 5, 'Sản phẩm có bảo hành ko?', 0, 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `color_code` varchar(20) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Redc', '#FF0000', NULL, 'inactive', '2025-10-03 23:28:17', '2025-10-26 16:29:11'),
(2, 'Blue', '#0000FF', NULL, 'active', '2025-10-03 23:28:17', NULL),
(3, 'White', '#FFFFFF', NULL, 'active', '2025-10-03 23:28:17', NULL),
(4, 'Black', '#000000', NULL, 'active', '2025-10-03 23:28:17', NULL),
(6, 'Đen', '#000000', NULL, 'active', '2025-11-14 01:27:58', NULL),
(7, 'Trắng', '#FFFFFF', NULL, 'active', '2025-11-14 01:27:58', NULL),
(8, 'Be', '#F5F5DC', NULL, 'active', '2025-11-14 01:27:58', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `news_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','spam','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `parent_id`, `content`, `status`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(201, 101, 2, NULL, 'Bảng màu earth–tone phối rất dễ, đặc biệt là cùng da lộn!', 'approved', '203.0.113.10', 'Chrome/141 Windows 10', '2025-10-01 20:37:33', '2025-10-01 20:37:33'),
(202, 101, NULL, 201, 'Có gợi ý giày loafer tông nâu không ạ?', 'approved', '198.51.100.23', 'Firefox/132 Ubuntu', '2025-10-02 20:37:33', '2025-10-02 20:37:33'),
(203, 103, 1, NULL, 'Form hơi ôm ngang bàn chân, ai chân bè nên cộng nửa size.', 'approved', '198.51.100.77', 'Chrome/141 macOS', '2025-10-09 20:37:33', '2025-10-09 20:37:33'),
(204, 104, 3, NULL, 'Lookbook denim rất đẹp, phần wash sun–fade nhìn đã mắt.', 'approved', '203.0.113.12', 'Chrome/141 Windows 11', '2025-10-11 20:37:33', '2025-10-11 20:37:33'),
(205, 106, NULL, NULL, 'Bài bền vững hữu ích, mình bắt đầu đọc care label từ hôm nay.', 'pending', '203.0.113.22', 'Safari/18 iOS', '2025-10-12 20:37:33', '2025-10-12 20:37:33'),
(206, 108, 1, NULL, 'Combo olive–denim là chân ái, hợp thời tiết Hà Nội.', 'approved', '198.51.100.90', 'Edge/141 Windows', '2025-10-14 00:37:33', '2025-10-14 00:37:33'),
(207, 108, 2, 206, 'Chuẩn, thêm mũ cap màu be là ổn áp.', 'approved', '198.51.100.91', 'Edge/141 Windows', '2025-10-14 02:37:33', '2025-10-14 02:37:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `invoice_code` varchar(120) NOT NULL,
  `issue_date` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `invoice_code`, `issue_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV001', '2025-10-03', '2025-10-03 23:28:17', NULL),
(2, 2, 'INV002', '2025-10-03', '2025-10-03 23:28:17', NULL),
(3, 3, 'INV003', '2025-10-03', '2025-10-03 23:28:17', NULL),
(4, 4, 'INV004', '2025-10-03', '2025-10-03 23:28:17', NULL),
(5, 5, 'INV005', '2025-10-03', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'Homepage Banner'),
(3, 'Sidebar Bottom'),
(2, 'Sidebar Top');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(4, '0001_01_01_000001_create_cache_table', 2),
(5, '0001_01_01_000002_create_jobs_table', 2),
(6, '2025_10_04_162806_create_products_table', 2),
(7, '2025_10_04_162908_create_categories_table', 2),
(8, '2025_10_05_024516_create_auths_table', 2),
(9, '2025_10_05_050828_create_accounts_table', 2),
(10, '2025_10_22_065108_create_wishlists_table', 3),
(11, '2025_10_26_162159_add_description_and_status_to_sizes_table', 4),
(12, '2025_10_26_162205_add_description_and_status_to_colors_table', 5),
(15, '2025_11_01_000000_sync_payment_status_and_triggers_on_orders', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','pending','published','archived') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `reading_time` tinyint UNSIGNED DEFAULT NULL,
  `seo_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `thumbnail`, `status`, `published_at`, `views`, `reading_time`, `seo_title`, `seo_description`, `seo_keywords`, `created_at`, `updated_at`) VALUES
(101, 11, 1, 'Xu hướng Thu/Đông: bảng màu earth–tone trở lại', 'xu-huong-fw-earth-tone', 'Earth–tone (nâu, be, olive) quay lại cùng chất liệu len & da lộn.', '<p>Tổng hợp bảng màu Thu/Đông 2025 với cách phối layer, cách chọn áo khoác dáng rộng và phụ kiện tông trầm.</p>', NULL, 'published', '2025-10-01 03:37:33', 680, 5, 'Xu hướng earth–tone', 'Cách phối earth–tone cho Thu/Đông 2025', 'xu-huong,earth-tone,fall-winter', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(102, 12, 2, '5 công thức phối đồ đi làm: gọn gàng mà không nhạt', '5-cong-thuc-phoi-do-di-lam', 'Gợi ý capsule wardrobe: sơ mi, quần âu, loafers, blazer.', '<p>Áp dụng quy tắc 3 mảnh (top–bottom–outer) cùng phụ kiện tối giản để tăng chiều sâu outfit.</p>', NULL, 'published', '2025-10-06 03:37:33', 412, 6, 'Công thức phối đồ công sở', 'Capsule wardrobe cho dân văn phòng', 'minimal,workwear,capsule', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(103, 13, 3, 'Review Nike Air Zoom Lite: nhẹ, êm, phù hợp daily?', 'review-nike-air-zoom-lite', 'Đánh giá nhanh độ êm, form và độ bền sau 30 ngày sử dụng.', '<p>Bài viết chấm điểm upper, midsole, độ bám đế và gợi ý size cho người chân bè.</p>', NULL, 'published', '2025-10-09 03:37:33', 533, 4, 'Review sneaker daily', 'Đánh giá Nike Air Zoom Lite thực tế', 'sneaker,review,comfort', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(104, 15, 1, 'BST Denim Recrafted: kỹ thuật wash vintage 90s', 'bst-denim-recrafted-wash-90s', 'Lookbook tập trung vào phom thẳng, cạp cao và wash “sun–fade”.', '<p>Giải thích quy trình wash & distress, vì sao raw denim vẫn được ưa chuộng trong tủ đồ tối giản.</p>', NULL, 'published', '2025-10-11 03:37:33', 276, 5, 'BST Denim Recrafted', 'Kỹ thuật wash denim phong cách 90s', 'denim,lookbook,vintage', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(105, 14, 2, 'Local brand Việt collab nghệ sĩ minh họa: câu chuyện phía sau', 'local-brand-collab-illustrator', 'Một cú bắt tay thú vị giữa thời trang và minh họa đương đại.', '<p>Phỏng vấn nhanh team thiết kế về moodboard, bảng màu và thông điệp chiến dịch.</p>', NULL, 'pending', NULL, 97, 3, 'Local brand collab', 'Hậu trường collab thời trang Việt', 'local-brand,collab,story', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(106, 16, 1, 'Thời trang bền vững: 7 thói quen mua sắm có ý thức', 'thoi-trang-ben-vung-7-thoi-quen', 'Mặc ít hơn, chọn kỹ hơn, ưu tiên vật liệu tái chế.', '<p>Danh sách thói quen thực tế: đọc care label, bảo quản đúng cách, ưu tiên sửa chữa thay vì bỏ đi.</p>', NULL, 'published', '2025-10-12 03:37:33', 348, 6, 'Mua sắm bền vững', '7 thói quen thời trang bền vững', 'sustainable,eco,habits', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(107, 12, 3, 'Phối layer ngày mưa: không phồng, không bí', 'phoi-layer-ngay-mua', 'Chọn chất liệu chống nước nhẹ, giữ form gọn.', '<p>Gợi ý outer shell mỏng, áo thun thoáng và quần quick–dry; bonus danh sách phụ kiện chống ướt.</p>', NULL, 'draft', NULL, 0, 4, 'Layer ngày mưa', 'Công thức layer gọn nhẹ khi trời mưa', 'layer,techwear,rain', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(108, 11, 2, 'Màu Olive đang “lên hương”: mix thế nào để không già?', 'mau-olive-mix-sao-cho-dep', 'Từ quân đội tới streetwear: olive phối be/trắng/denim là “auto hợp”.', '<p>3 combo dễ áp dụng: olive–be, olive–trắng, olive–denim, kèm mẹo cân bằng sáng tối.</p>', NULL, 'published', '2025-10-14 03:37:33', 221, 4, 'Mix màu Olive', 'Cách phối màu Olive chuẩn mới', 'olive,trend,streetwear', '2025-10-14 20:37:33', '2025-10-14 20:37:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news_categories`
--

INSERT INTO `news_categories` (`id`, `parent_id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(10, NULL, 'Thời trang', 'thoi-trang', 'Tin tức & xu hướng thời trang', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(11, 10, 'Xu hướng', 'xu-huong', 'Trend theo mùa, chất liệu, bảng màu', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(12, 10, 'Mẹo phối đồ', 'meo-phoi-do', 'Styling tips cho nhiều hoàn cảnh', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(13, 10, 'Review sản phẩm', 'review-san-pham', 'Đánh giá giày, quần áo, phụ kiện', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(14, 10, 'Thương hiệu', 'thuong-hieu', 'Câu chuyện các brand, collab', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(15, 10, 'Bộ sưu tập mới', 'bo-suu-tap-moi', 'Ra mắt lookbook, runway, campaign', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(16, NULL, 'Bền vững', 'ben-vung', 'Thời trang bền vững & tái chế', '2025-10-14 20:37:33', '2025-10-14 20:37:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_tag`
--

CREATE TABLE `news_tag` (
  `news_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news_tag`
--

INSERT INTO `news_tag` (`news_id`, `tag_id`, `created_at`) VALUES
(101, 22, '2025-10-14 20:37:33'),
(101, 27, '2025-10-14 20:37:33'),
(101, 28, '2025-10-14 20:37:33'),
(102, 22, '2025-10-14 20:37:33'),
(102, 30, '2025-10-14 20:37:33'),
(102, 31, '2025-10-14 20:37:33'),
(103, 24, '2025-10-14 20:37:33'),
(103, 30, '2025-10-14 20:37:33'),
(104, 21, '2025-10-14 20:37:33'),
(104, 25, '2025-10-14 20:37:33'),
(104, 27, '2025-10-14 20:37:33'),
(105, 27, '2025-10-14 20:37:33'),
(105, 29, '2025-10-14 20:37:33'),
(106, 22, '2025-10-14 20:37:33'),
(106, 26, '2025-10-14 20:37:33'),
(107, 20, '2025-10-14 20:37:33'),
(107, 31, '2025-10-14 20:37:33'),
(108, 20, '2025-10-14 20:37:33'),
(108, 22, '2025-10-14 20:37:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `order_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Đơn hàng mới', 'Bạn vừa đặt đơn ORD001', '2025-10-03 23:28:17', NULL),
(2, 2, 2, 'Thanh toán thành công', 'Đơn ORD002 đã thanh toán', '2025-10-03 23:28:17', NULL),
(3, 3, 3, 'Đơn hàng đang xử lý', 'ORD003 đang chuẩn bị hàng', '2025-10-03 23:28:17', NULL),
(4, 4, 4, 'Đơn hàng giảm giá', 'ORD004 đã được giảm giá', '2025-10-03 23:28:17', NULL),
(5, 5, 5, 'Giao hàng', 'ORD005 đang giao', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `payment_status_id` bigint UNSIGNED NOT NULL,
  `order_status_id` bigint UNSIGNED NOT NULL,
  `voucher_id` bigint UNSIGNED DEFAULT NULL,
  `order_code` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `note` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_status_id`, `order_status_id`, `voucher_id`, `order_code`, `name`, `address`, `phone`, `subtotal`, `discount`, `total_amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 'ORD001', 'Nguyen Van A', 'Ha Noi', '0900000001', 500000.00, 50000.00, 450000.00, 'Giao nhanh', '2025-10-03 23:28:17', NULL),
(2, 2, 1, 2, 2, 'ORD002', 'Tran Thi B', 'Hai Phong', '0900000002', 150000.00, 30000.00, 120000.00, '', '2025-10-03 23:28:17', NULL),
(3, 3, 1, 2, NULL, 'ORD003', 'Le Van C', 'Da Nang', '0900000003', 900000.00, 0.00, 900000.00, 'Ship giờ hành chính', '2025-10-03 23:28:17', '2025-11-01 14:30:37'),
(4, 4, 1, 3, 3, 'ORD004', 'Pham Thi D', 'Hue', '0900000004', 350000.00, 100000.00, 250000.00, '', '2025-10-03 23:28:17', '2025-11-01 10:58:13'),
(5, 5, 2, 4, 4, 'ORD005', 'Admin', 'Ha Noi', '0900000005', 2000000.00, 70000.00, 1930000.00, '', '2025-10-03 23:28:17', '2025-10-26 23:58:03'),
(6, 1, 2, 4, NULL, 'ORD21', 'aaaa', 'aaaa', '0900000001', 0.00, 0.00, 0.00, NULL, '2025-11-04 03:17:38', '2025-11-11 03:17:38'),
(7, 12, 5, 7, NULL, 'ORD20251101A', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 850000.00, 50000.00, 800000.00, 'Giao trong giờ hành chính', '2025-11-01 18:48:14', '2025-11-01 14:39:09'),
(8, 12, 5, 6, NULL, 'ORD20251101B', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 1200000.00, 100000.00, 1100000.00, 'Yêu cầu gói quà', '2025-11-01 18:48:14', '2025-11-01 21:47:15'),
(9, 12, 2, 4, NULL, 'ORD20251101C', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 690000.00, 0.00, 690000.00, 'Thanh toán khi nhận hàng', '2025-11-01 18:48:14', '2025-11-01 18:48:14'),
(10, 12, 1, 2, NULL, 'ORD20251101D', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 1570000.00, 70000.00, 1500000.00, 'Giao nhanh', '2025-11-01 18:48:14', '2025-11-01 18:48:14'),
(11, 12, 1, 1, NULL, 'ORD20251101E', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 1050000.00, 100000.00, 950000.00, 'Khách hủy vì sai kích thước', '2025-11-01 18:48:14', '2025-11-04 15:15:02'),
(12, 12, 1, 2, NULL, 'ORD20251102A', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 960000.00, 60000.00, 900000.00, 'Thanh toán online thành công', '2025-11-04 16:44:05', '2025-11-04 16:44:05'),
(13, 12, 1, 3, NULL, 'ORD20251102B', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 1150000.00, 50000.00, 1100000.00, 'COD - thanh toán khi nhận hàng', '2025-11-04 16:44:05', '2025-11-04 16:44:05'),
(14, 12, 3, 5, NULL, 'ORD20251102C', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 740000.00, 40000.00, 700000.00, 'Đơn hàng đang chờ hoàn tiền', '2025-11-04 16:44:05', '2025-11-10 21:25:49'),
(15, 12, 3, 5, NULL, 'ORD20251102D', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 1280000.00, 80000.00, 1200000.00, 'Khách thanh toán qua ví điện tử', '2025-11-04 16:44:05', '2025-11-05 14:04:12'),
(16, 12, 3, 5, NULL, 'ORD20251102E', 'Nguyễn Văn Hùng', '123 Lĩnh Nam, Hoàng Mai, Hà Nội', '0912345678', 880000.00, 30000.00, 850000.00, 'Giao dịch bị từ chối bởi ngân hàng', '2025-11-04 16:44:05', '2025-11-04 16:44:05');

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `trg_orders_sync_payment_status_bi` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
                SET NEW.payment_status_id = CASE NEW.order_status_id
                    WHEN 1 THEN 1   -- Chờ xác nhận      -> Chưa thanh toán
                    WHEN 2 THEN 1   -- Xác nhận    -> Chưa thanh toán
                    WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                    WHEN 4 THEN 2   -- Đã giao hàng -> Đang xử lý
                    WHEN 5 THEN 3   -- Hoàn thành  -> Đã thanh toán
                    WHEN 6 THEN 5   -- Hủy  -> Hoàn tiền
                    WHEN 7 THEN 5   -- Hoàn hàng  -> Hoàn tiền
                    ELSE NEW.payment_status_id
                END;
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_orders_sync_payment_status_bu` BEFORE UPDATE ON `orders` FOR EACH ROW BEGIN
                -- Đồng bộ theo order_status_id mới
                SET NEW.payment_status_id = CASE NEW.order_status_id
                    WHEN 1 THEN 1   -- Chờ xác nhận      -> Chưa thanh toán
                    WHEN 2 THEN 1   -- Xác nhận    -> Chưa thanh toán
                    WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                    WHEN 4 THEN 2   -- Đã giao hàng -> Đang xử lý
                    WHEN 5 THEN 3   -- Hoàn thành  -> Đã thanh toán
                    WHEN 6 THEN 5   -- Hủy  -> Hoàn tiền
                    WHEN 7 THEN 5   -- Hoàn hàng  -> Hoàn tiền
                    ELSE NEW.payment_status_id
                END;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_variant_id` bigint UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `estimated_delivery` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_variant_id`, `price`, `quantity`, `status`, `estimated_delivery`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 250000.00, 2, 1, '2025-10-06', '2025-10-03 23:28:17', NULL),
(2, 2, 3, 150000.00, 1, 1, '2025-10-07', '2025-10-03 23:28:17', NULL),
(3, 3, 4, 350000.00, 2, 2, '2025-10-08', '2025-10-03 23:28:17', '2025-11-01 14:30:37'),
(4, 4, 2, 260000.00, 1, 2, '2025-10-05', '2025-10-03 23:28:17', '2025-11-01 06:12:36'),
(5, 5, 5, 500000.00, 4, 1, '2025-10-10', '2025-10-03 23:28:17', NULL),
(6, 1, 1, 250000.00, 1, 3, '2025-11-05', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(7, 1, 3, 300000.00, 2, 3, '2025-11-05', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(8, 1, 5, 150000.00, 1, 3, '2025-11-05', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(9, 2, 2, 400000.00, 1, 1, '2025-11-06', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(10, 2, 4, 350000.00, 1, 1, '2025-11-06', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(11, 2, 6, 450000.00, 2, 1, '2025-11-06', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(12, 3, 1, 230000.00, 1, 4, '2025-11-04', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(13, 3, 7, 210000.00, 1, 4, '2025-11-04', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(14, 3, 8, 250000.00, 2, 4, '2025-11-04', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(15, 4, 3, 500000.00, 1, 2, '2025-11-07', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(16, 4, 6, 520000.00, 1, 2, '2025-11-07', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(17, 4, 9, 550000.00, 1, 2, '2025-11-07', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(18, 4, 10, 450000.00, 1, 2, '2025-11-07', '2025-11-01 19:25:29', '2025-11-01 19:25:29'),
(22, 7, 20, 250000.00, 1, 3, '2025-11-05', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(23, 7, 3, 300000.00, 2, 3, '2025-11-05', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(24, 7, 5, 150000.00, 1, 3, '2025-11-05', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(25, 8, 2, 400000.00, 1, 2, '2025-11-06', '2025-11-01 19:30:49', '2025-11-01 14:40:36'),
(26, 8, 4, 350000.00, 1, 2, '2025-11-06', '2025-11-01 19:30:49', '2025-11-01 14:40:36'),
(27, 8, 6, 450000.00, 2, 2, '2025-11-06', '2025-11-01 19:30:49', '2025-11-01 14:40:36'),
(28, 9, 1, 230000.00, 1, 4, '2025-11-04', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(29, 9, 7, 210000.00, 1, 4, '2025-11-04', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(30, 9, 8, 250000.00, 2, 4, '2025-11-04', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(31, 10, 3, 500000.00, 1, 2, '2025-11-07', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(32, 10, 6, 520000.00, 1, 2, '2025-11-07', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(33, 10, 9, 550000.00, 1, 2, '2025-11-07', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(34, 10, 10, 450000.00, 1, 2, '2025-11-07', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(35, 11, 20, 300000.00, 1, 5, '2025-11-03', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(36, 11, 5, 350000.00, 1, 5, '2025-11-03', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(37, 11, 8, 400000.00, 1, 5, '2025-11-03', '2025-11-01 19:30:49', '2025-11-01 19:30:49'),
(38, 12, 2, 320000.00, 1, 3, '2025-11-08', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(39, 12, 5, 280000.00, 2, 3, '2025-11-08', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(40, 12, 7, 360000.00, 1, 3, '2025-11-08', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(41, 13, 1, 450000.00, 1, 1, '2025-11-09', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(42, 13, 3, 380000.00, 1, 1, '2025-11-09', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(43, 13, 6, 370000.00, 2, 1, '2025-11-09', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(44, 14, 4, 250000.00, 1, 5, '2025-11-07', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(45, 14, 8, 310000.00, 2, 5, '2025-11-07', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(46, 14, 9, 180000.00, 1, 5, '2025-11-07', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(47, 15, 2, 400000.00, 1, 4, '2025-11-10', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(48, 15, 6, 420000.00, 1, 4, '2025-11-10', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(49, 15, 11, 460000.00, 2, 4, '2025-11-10', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(50, 16, 5, 300000.00, 1, 5, '2025-11-06', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(51, 16, 7, 320000.00, 1, 5, '2025-11-06', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(52, 16, 12, 230000.00, 2, 5, '2025-11-06', '2025-11-04 17:04:56', '2025-11-04 17:04:56'),
(100, 1, 19, 350000.00, 1, 1, '2025-01-06', '2025-01-03 10:15:00', '2025-01-03 10:15:00'),
(101, 2, 19, 400000.00, 2, 1, '2025-01-08', '2025-01-05 09:02:00', '2025-01-05 09:02:00'),
(102, 3, 19, 600000.00, 2, 1, '2025-01-10', '2025-01-07 14:20:00', '2025-01-07 14:20:00'),
(103, 4, 19, 450000.00, 1, 1, '2025-01-12', '2025-01-09 11:45:00', '2025-01-09 11:45:00'),
(104, 5, 19, 490000.00, 2, 1, '2025-01-15', '2025-01-12 16:10:00', '2025-01-12 16:10:00'),
(105, 6, 19, 365000.00, 2, 1, '2025-01-17', '2025-01-14 08:30:00', '2025-01-14 08:30:00'),
(106, 7, 19, 530000.00, 1, 1, '2025-01-20', '2025-01-18 13:55:00', '2025-01-18 13:55:00'),
(107, 8, 19, 780000.00, 2, 1, '2025-01-21', '2025-01-19 17:40:00', '2025-01-19 17:40:00'),
(108, 9, 19, 420000.00, 1, 1, '2025-01-23', '2025-01-20 12:12:00', '2025-01-20 12:12:00'),
(109, 10, 19, 435000.00, 2, 1, '2025-01-25', '2025-01-22 19:28:00', '2025-01-22 19:28:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Chờ xác nhận', NULL, NULL),
(2, 'Xác nhận', NULL, NULL),
(3, 'Đang giao hàng', NULL, NULL),
(4, 'Đã giao hàng', NULL, NULL),
(5, 'Hoàn thành', NULL, NULL),
(6, 'Hủy', NULL, NULL),
(7, 'Hoàn hàng', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_method_id` bigint UNSIGNED NOT NULL,
  `payment_code` varchar(150) DEFAULT NULL,
  `payment_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method_id`, `payment_code`, `payment_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'COD001', 450000.00, 0, '2025-10-03 23:28:17', NULL),
(2, 2, 2, 'VNPAY001', 120000.00, 1, '2025-10-03 23:28:17', NULL),
(3, 3, 3, 'MOMO001', 900000.00, 1, '2025-10-03 23:28:17', NULL),
(4, 4, 1, 'COD002', 250000.00, 0, '2025-10-03 23:28:17', NULL),
(5, 5, 2, 'VNPAY002', 1930000.00, 1, '2025-10-03 23:28:17', NULL),
(6, 7, 1, 'PAY20251107001', 325000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(7, 8, 2, 'PAY20251107002', 450000.00, 0, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(8, 9, 3, 'PAY20251107003', 278000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(9, 10, 1, 'PAY20251107004', 589000.00, 2, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(10, 11, 2, 'PAY20251107005', 190000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(11, 12, 3, 'PAY20251107006', 420000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(12, 13, 1, 'PAY20251107007', 870000.00, 0, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(13, 14, 2, 'PAY20251107008', 315000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(14, 15, 3, 'PAY20251107009', 255000.00, 2, '2025-11-05 01:17:27', '2025-11-05 01:17:27'),
(15, 16, 1, 'PAY20251107010', 499000.00, 1, '2025-11-05 01:17:27', '2025-11-05 01:17:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `code`, `type`, `created_at`, `updated_at`) VALUES
(1, 'COD', 'COD', 'offline', NULL, NULL),
(2, 'VNPAY', 'VNPAY', 'online', NULL, NULL),
(3, '', 'MOMO', 'online', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_statuses`
--

CREATE TABLE `payment_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Chưa thanh toán', NULL, '2025-11-01 14:33:28'),
(2, 'Đang xử lý', NULL, '2025-11-01 14:33:28'),
(3, 'Đã thanh toán', NULL, '2025-11-01 14:33:28'),
(4, 'Thanh toán thất bại', '2025-11-01 19:44:40', '2025-11-01 19:44:40'),
(5, 'Hoàn tiền', '2025-11-01 20:21:47', '2025-11-01 14:33:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `view` int NOT NULL,
  `material` varchar(150) DEFAULT NULL,
  `onpage` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_code`, `name`, `description`, `view`, `material`, `onpage`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'SP001', 'Áo sơ mi nam', 'Áo sơ mi công sở', 124, 'Cotton', 1, '2025-10-03 23:28:17', '2025-10-19 08:45:29', NULL),
(2, 1, 'SP002', 'Áo thun nam', 'Áo thun basic', 174, 'Polyester', 1, '2025-10-03 23:28:17', NULL, NULL),
(3, 2, 'SP003', 'Váy nữ xòe', 'Váy công sở xòe nhẹ', 491, 'Lụa', 1, '2025-10-03 23:28:17', NULL, NULL),
(4, 4, 'SP004', 'Quần dài túi hộp', 'Giày sneaker trẻ trung', 450, 'Da PU', 1, '2025-10-03 23:28:17', '2025-10-27 11:36:15', NULL),
(5, 1, 'SP005', 'Quần short jean', 'Túi xách nữ thời trang', 275, 'Da bò', 1, '2025-10-03 23:28:17', '2025-10-27 11:41:15', NULL),
(6, 1, 'SP006', 'Áo polo nam cao cấp', 'Áo polo vải thun lạnh, thoáng mát', 17, 'Thun lạnh', 1, '2025-10-08 00:04:37', NULL, NULL),
(7, 1, 'SP007', 'Áo khoác nam chống nắng', 'Áo khoác dù siêu nhẹ, chống tia UV', 230, 'Polyester', 1, '2025-10-08 00:04:37', NULL, NULL),
(8, 11, 'SP008', 'Áo thun sleep', 'Đầm thiết kế thanh lịch cho dân văn phòng', 109, 'Lụa Nhật', 1, '2025-10-08 00:04:37', '2025-10-29 17:25:23', NULL),
(9, 1, 'SP009', 'Quần jean line up', 'Áo nữ thiết kế trẻ trung, phong cách', 338, 'Voan mịn', 1, '2025-10-08 00:04:37', '2025-10-27 11:42:32', NULL),
(10, 3, 'SP010', 'Kính mát thời trang', 'Kính gọng kim loại cao cấp', 370, 'Kim loại', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:36', '2025-10-27 04:44:36'),
(11, 1, 'SP011', 'Áo tanktop', 'Thắt lưng nam khóa hợp kim cao cấp', 335, 'Da bò thật', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:45', '2025-10-27 04:44:45'),
(12, 3, 'SP012', 'Mũ lưỡi trai Unisex', 'Mũ lưỡi trai trơn phong cách Hàn Quốc', 63, 'Cotton', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:51', '2025-10-27 04:44:51'),
(13, 11, 'SP013', 'Giày thể thao nữ', 'Giày sneaker đế êm, nhẹ', 284, 'Da tổng hợp', 1, '2025-10-08 00:04:37', '2025-10-29 17:26:41', NULL),
(14, 4, 'SP014', 'Dép lê nam đơn giản', 'Dép lê cao su, thoải mái khi di chuyển', 241, 'Cao su', 1, '2025-10-08 00:04:37', '2025-10-29 17:24:30', NULL),
(15, 4, 'SP015', 'Giày da công sở nam', 'Giày tây nam bóng mịn, sang trọng', 341, 'Da bò', 0, '2025-10-08 00:04:37', '2025-11-17 01:41:20', '2025-11-16 18:41:20'),
(16, 11, 'SP016', 'Áo polo overthinking', 'Túi đeo chéo tiện lợi, phong cách trẻ', 484, 'Vải canvas', 1, '2025-10-08 00:04:37', '2025-11-17 01:40:27', NULL),
(17, 5, 'SP017', 'Balo laptop chống nước', 'Balo thời trang, chống thấm nước', 403, 'Nylon', 1, '2025-10-08 00:04:37', '2025-11-17 01:44:12', NULL),
(18, 5, 'SP018', 'Ví da nam mini', 'Ví nhỏ gọn, nhiều ngăn, da mềm', 65, 'Da thật', 1, '2025-10-08 00:04:37', '2025-11-17 01:44:10', NULL),
(19, 11, 'SP019', 'Áo khoác nữ form rộng', 'Áo khoác nữ phong cách Hàn Quốc', 87, 'Kaki', 1, '2025-10-08 00:04:37', '2025-11-17 01:44:07', NULL),
(20, 1, 'SP020', 'Quần jean nam rách gối', 'Quần jean rách phong cách streetwear', 231, 'Jean cotton', 1, '2025-10-08 00:04:37', '2025-11-17 01:45:59', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_favorites`
--

CREATE TABLE `product_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `product_favorites`
--

INSERT INTO `product_favorites` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-10-03 23:28:17', NULL),
(2, 2, 2, '2025-10-03 23:28:17', NULL),
(3, 3, 3, '2025-10-03 23:28:17', NULL),
(4, 4, 4, '2025-10-03 23:28:17', NULL),
(5, 5, 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_photo_albums`
--

CREATE TABLE `product_photo_albums` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `product_photo_albums`
--

INSERT INTO `product_photo_albums` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(10, 10, NULL, '2025-10-08 00:04:37', NULL),
(11, 11, NULL, '2025-10-08 00:04:37', NULL),
(12, 12, NULL, '2025-10-08 00:04:37', NULL),
(13, 13, NULL, '2025-10-08 00:04:37', NULL),
(14, 14, NULL, '2025-10-08 00:04:37', NULL),
(15, 15, NULL, '2025-10-08 00:04:37', NULL),
(28, 1, 'products/F1Zj7nANKXVBUd9cGyYpoD07Dssff5AntuXs6FiE.jpg', '2025-10-27 11:16:42', '2025-10-27 11:16:42'),
(29, 19, 'products/ekqMIftlkq9YPhhfOTfketVGr9e5lTPk2h0ldiNN.png', '2025-10-27 11:19:44', '2025-10-27 11:19:44'),
(30, 20, 'products/8YcE5GttjJyXZHuxbVKCMCWVu8ZV7ddfezTIKTsS.jpg', '2025-10-27 11:23:48', '2025-10-27 11:23:48'),
(31, 19, 'products/vsybQC2j9rInqirFrFRnMnj2TObMeOWkKwhVbNws.jpg', '2025-10-27 11:26:36', '2025-10-27 11:26:36'),
(32, 18, 'products/9VvHbkTN2bAsAKco7W5kCq5guBj3chqr8ghUSZZ3.webp', '2025-10-27 11:29:33', '2025-10-27 11:29:33'),
(34, 17, 'products/nFF21nWIXRuwHGF8d4t6lfBV9cSgzSjrQHew6rvh.jpg', '2025-10-27 11:32:22', '2025-10-27 11:32:22'),
(35, 3, 'products/uHhG7KKbdOTSSSDH7cHBLnVDkNDMQVEDrMCJhxaP.jpg', '2025-10-27 11:34:19', '2025-10-27 11:34:19'),
(36, 4, 'products/jlpPqOWyWC0Jvkc2ct6pHoyjT1ljOq3KN5Lo8Rbl.jpg', '2025-10-27 11:36:15', '2025-10-27 11:36:15'),
(37, 6, 'products/kejqFmT4tDPnQOUYl1J86VV9seTYvbghPwB42Ak4.jpg', '2025-10-27 11:37:21', '2025-10-27 11:37:21'),
(38, 7, 'products/7P2w2aGECKbUF0TX8V2hogDFtxpEShYAhYn5nsJV.jpg', '2025-10-27 11:38:06', '2025-10-27 11:38:06'),
(39, 8, 'products/QHAdt4vCKOnFBjlxwUAXOLr7I99MuptWKHX6KHAs.jpg', '2025-10-27 11:39:12', '2025-10-27 11:39:12'),
(40, 5, 'products/bLmL1OesbwM82Os7jAB9JST0rQggPbXQ76Nd1O7T.jpg', '2025-10-27 11:41:15', '2025-10-27 11:41:15'),
(41, 9, 'products/vLgpEXecj1XQ6JxDtfDJrjXnrdGu3izIW69ylj7a.jpg', '2025-10-27 11:42:44', '2025-10-27 11:42:44'),
(42, 16, 'products/GiiQ8WU5MOuDysGNM6QJbXbmUrMc2MxzMxiEQh81.jpg', '2025-10-27 11:43:48', '2025-10-27 11:43:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `size_id` bigint UNSIGNED DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sale` decimal(12,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` bigint NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color_id`, `size_id`, `price`, `sale`, `image`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 250000.00, 200000.00, NULL, 437, 1, '2025-10-03 23:28:17', NULL),
(2, 1, 2, 2, 260000.00, NULL, NULL, 102, 1, '2025-10-03 23:28:17', '2025-11-01 14:40:36'),
(3, 2, 1, 2, 150000.00, NULL, NULL, 152, 1, '2025-10-03 23:28:17', NULL),
(4, 3, 3, 3, 350000.00, 300000.00, NULL, 398, 1, '2025-10-03 23:28:17', '2025-11-01 14:40:36'),
(5, 4, 4, 2, 500000.00, 450000.00, NULL, 502, 1, '2025-10-03 23:28:17', NULL),
(6, 6, 1, 2, 220000.00, 200000.00, NULL, 259, 1, '2025-10-08 00:04:37', '2025-11-01 14:40:36'),
(7, 7, 4, 3, 350000.00, 320000.00, NULL, 747, 1, '2025-10-08 00:04:37', NULL),
(8, 8, 3, 3, 400000.00, 370000.00, NULL, 908, 1, '2025-10-08 00:04:37', NULL),
(9, 9, 2, 2, 280000.00, NULL, NULL, 259, 1, '2025-10-08 00:04:37', NULL),
(10, 10, 4, NULL, 250000.00, NULL, NULL, 513, 1, '2025-10-08 00:04:37', NULL),
(11, 11, 4, NULL, 300000.00, 270000.00, NULL, 743, 1, '2025-10-08 00:04:37', NULL),
(12, 12, NULL, NULL, 180000.00, NULL, NULL, 136, 1, '2025-10-08 00:04:37', NULL),
(13, 13, 3, 3, 480000.00, 450000.00, NULL, 391, 1, '2025-10-08 00:04:37', NULL),
(14, 14, 4, NULL, 120000.00, NULL, NULL, 501, 1, '2025-10-08 00:04:37', NULL),
(15, 15, 4, 3, 650000.00, 600000.00, NULL, 287, 1, '2025-10-08 00:04:37', NULL),
(16, 16, NULL, NULL, 230000.00, NULL, NULL, 880, 1, '2025-10-08 00:04:37', NULL),
(17, 17, 2, NULL, 490000.00, 460000.00, NULL, 499, 1, '2025-10-08 00:04:37', NULL),
(18, 18, 4, NULL, 210000.00, 180000.00, NULL, 801, 1, '2025-10-08 00:04:37', NULL),
(19, 19, 2, 4, 400000.00, 350000.00, NULL, 469, 1, '2025-10-08 00:04:37', '2025-10-26 23:52:48'),
(20, 20, 1, 3, 370000.00, 340000.00, NULL, 2, 1, '2025-10-08 00:04:37', NULL),
(30, 19, 4, 1, 350000.00, 320000.00, 'products/variant_black_m.jpg', 12, 1, '2025-11-14 01:39:22', NULL),
(31, 19, 4, 2, 350000.00, 320000.00, 'images/variant_black_l.jpg', 11, 1, '2025-11-14 01:39:22', NULL),
(32, 19, 4, 3, 350000.00, 320000.00, 'images/variant_black_xl.jpg', 18, 1, '2025-11-14 01:39:22', NULL),
(33, 19, 3, 1, 350000.00, 330000.00, 'images/variant_white_m.jpg', 32, 1, '2025-11-14 01:39:22', NULL),
(34, 19, 3, 2, 350000.00, 330000.00, 'images/variant_white_l.jpg', 64, 1, '2025-11-14 01:39:22', NULL),
(35, 19, 3, 3, 350000.00, 330000.00, 'images/variant_white_xl.jpg', 33, 1, '2025-11-14 01:39:22', NULL),
(36, 19, 8, 1, 360000.00, 340000.00, 'images/variant_be_m.jpg', 75, 1, '2025-11-14 01:39:22', NULL),
(37, 19, 8, 2, 360000.00, 340000.00, 'images/variant_be_l.jpg', 11, 1, '2025-11-14 01:39:22', NULL),
(38, 19, 8, 3, 360000.00, 340000.00, 'images/variant_be_xl.jpg', 35, 1, '2025-11-14 01:39:22', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rankings`
--

CREATE TABLE `rankings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_points` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `rankings`
--

INSERT INTO `rankings` (`id`, `name`, `min_points`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 0, NULL, NULL),
(2, 'Silver', 1000, NULL, NULL),
(3, 'Gold', 5000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `content` text,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `product_id`, `rating`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 5, 'Áo đẹp, chất liệu tốt', 1, '2025-10-03 23:28:17', NULL),
(2, 1, 2, 4, 'Áo thun ổn', 1, '2025-10-03 23:28:17', NULL),
(3, 11, 3, 5, 'Váy rất xinh', 1, '2025-10-03 23:28:17', NULL),
(4, 7, 4, 3, 'Giày hơi chật', 1, '2025-10-03 23:28:17', NULL),
(5, 1, 5, 5, 'Túi rất sang', 1, '2025-10-03 23:28:17', NULL),
(6, 14, 3, 5, 'Sản phẩm đúng mô tả, rất hài lòng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(7, 9, 5, 4, 'Chất lượng tốt, giao hàng nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(8, 15, 8, 3, 'Ổn trong tầm giá, không quá xuất sắc.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(9, 1, 12, 2, 'Màu hơi khác ảnh, chất liệu tạm.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(10, 6, 1, 5, 'Shop đóng gói kỹ, hàng đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(11, 13, 10, 4, 'Giá hợp lý, form ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(12, 1, 6, 5, 'Rất thích, sẽ mua lại.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(13, 9, 14, 3, 'Phần bo áo hơi cứng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(14, 11, 17, 5, 'Tư vấn nhiệt tình, hàng chất lượng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(15, 12, 9, 4, 'Giao hàng nhanh, bao bì đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(16, 13, 2, 5, 'Vải mịn, mặc thoải mái.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(17, 12, 7, 3, 'Giao hàng hơi chậm.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(18, 6, 11, 4, 'Màu lên chuẩn, đúng size.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(19, 9, 16, 5, 'Chất lượng cao, đáng tiền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(20, 10, 18, 2, 'Đường may chưa đều.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(21, 8, 20, 4, 'Shop phản hồi nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(22, 11, 5, 3, 'Form hơi rộng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(23, 13, 13, 5, 'Mẫu mới đẹp, ấn tượng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(24, 4, 4, 4, 'Giao hàng sớm hơn dự kiến.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(25, 8, 9, 5, 'Đóng gói rất kỹ, đánh giá cao.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(26, 13, 1, 5, 'Mặc vừa, chất vải dày dặn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(27, 13, 6, 4, 'Hàng giống hình, giao nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(28, 7, 8, 3, 'Không quá nổi bật nhưng ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(29, 12, 12, 2, 'Có vài sợi chỉ thừa.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(30, 8, 3, 4, 'Shop hỗ trợ nhiệt tình.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(31, 6, 19, 5, 'Sản phẩm vượt mong đợi.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(32, 4, 10, 3, 'Cần cải thiện phần bao bì.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(33, 15, 15, 5, 'Hài lòng tuyệt đối.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(34, 3, 7, 4, 'Đáng tiền, sẽ ủng hộ tiếp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(35, 1, 14, 5, 'Tốt hơn mong đợi.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(36, 11, 2, 4, 'Chất lượng tốt, đường may đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(37, 7, 11, 3, 'Mặc hơi rộng vai.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(38, 2, 17, 5, 'Đóng gói cẩn thận.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(39, 2, 5, 2, 'Form không như ảnh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(40, 2, 9, 4, 'Vải co giãn nhẹ, ưng ý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(41, 6, 13, 5, 'Shop uy tín, hàng chính hãng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(42, 7, 8, 3, 'Giao hàng nhanh, chất tạm ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(43, 1, 19, 5, 'Hàng đẹp xuất sắc.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(44, 12, 16, 4, 'Vừa vặn, không bị phai màu.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(45, 15, 1, 5, 'Cực kỳ hài lòng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(46, 6, 7, 5, 'Mẫu này rất đẹp, đáng tiền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(47, 15, 3, 4, 'Màu sắc tinh tế.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(48, 12, 12, 3, 'Đóng gói hơi ẩu.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(49, 13, 5, 5, 'Sản phẩm tuyệt vời.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(50, 1, 14, 2, 'Chưa như mong đợi.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(51, 11, 10, 5, 'Hàng chuẩn, nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(52, 4, 6, 4, 'Giá hợp lý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(53, 3, 8, 3, 'Vải hơi cứng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(54, 3, 19, 5, 'Rất đẹp, đúng mô tả.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(55, 4, 2, 4, 'Sẽ quay lại mua.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(56, 12, 9, 5, 'Chất liệu mịn, co giãn tốt.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(57, 2, 11, 4, 'Màu đúng ảnh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(58, 5, 4, 3, 'Vải hơi mỏng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(59, 1, 13, 2, 'Không giống hình.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(60, 6, 18, 4, 'Phù hợp giá tiền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(61, 12, 1, 5, 'Giao cực nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(62, 10, 15, 3, 'Tạm ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(63, 13, 7, 4, 'Nhân viên hỗ trợ tốt.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(64, 3, 6, 5, 'Mua lần thứ 2 vẫn hài lòng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(65, 9, 10, 5, 'Cực kỳ ưng ý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(66, 4, 3, 4, 'Chất vải dày, form chuẩn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(67, 7, 8, 5, 'Hàng đẹp, đáng giá.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(68, 7, 14, 2, 'Cần cải thiện đóng gói.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(69, 14, 19, 4, 'Hài lòng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(70, 4, 9, 3, 'Không quá nổi bật.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(71, 7, 12, 5, 'Giao hàng nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(72, 9, 10, 4, 'Phù hợp mô tả.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(73, 9, 7, 3, 'Chất lượng trung bình.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(74, 15, 1, 5, 'Xuất sắc.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(75, 3, 16, 4, 'Đáng tiền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(76, 13, 11, 5, 'Rất ưng mẫu này.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(77, 11, 2, 4, 'Giá hợp lý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(78, 15, 5, 3, 'Hơi nhăn khi giặt.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(79, 12, 6, 2, 'Màu khác ảnh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(80, 1, 9, 5, 'Tốt hơn mong đợi.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(81, 12, 8, 4, 'Đường may đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(82, 13, 10, 3, 'Phần cổ hơi cứng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(83, 14, 12, 4, 'Giao hàng nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(84, 15, 4, 5, 'Mua lại chắc chắn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(85, 3, 17, 5, 'Chất lượng tuyệt vời.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(86, 13, 13, 5, 'Rất đáng tiền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(87, 9, 3, 4, 'Form chuẩn, đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(88, 9, 19, 2, 'Cần cải thiện vải.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(89, 14, 15, 3, 'Tạm ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(90, 14, 9, 5, 'Shop hỗ trợ nhanh.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(91, 14, 6, 4, 'Mặc thoải mái.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(92, 10, 8, 5, 'Sản phẩm chất lượng.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(93, 10, 2, 3, 'Không có gì nổi bật.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(94, 4, 11, 5, 'Đẹp và bền.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(95, 2, 18, 4, 'Rất hợp lý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(96, 15, 10, 5, 'Giao nhanh, đóng gói đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(97, 9, 12, 4, 'Đúng như mô tả.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(98, 12, 5, 3, 'Không ấn tượng lắm.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(99, 2, 7, 2, 'Chất lượng trung bình.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(100, 6, 9, 5, 'Hài lòng tuyệt đối.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(101, 7, 14, 4, 'Form đẹp.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(102, 2, 1, 3, 'Tạm ổn.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(103, 3, 8, 5, 'Hàng đẹp, đáng giá.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(104, 8, 19, 4, 'Phù hợp mô tả.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07'),
(105, 14, 17, 5, 'Cực kỳ ưng ý.', 1, '2025-11-06 01:56:07', '2025-11-06 01:56:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'member', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Sc35MZv7zA8yeA9JpGOE02VN5SHjlRYQ91nuA0Mx', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ3RqQ3Q3VXBoSEt1RVY2U01CNUR5UVdnbUFoM09lTFRETEgwSDZyYiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly9kYXRuXzA5LnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEzOiJwZW5kaW5nX29yZGVyIjthOjQ6e3M6Nzoib3JkZXJJZCI7czoxOToiT1JERVJfMTc2MzQ3NjY5Nl8xMiI7czoxMToidG90YWxBbW91bnQiO2Q6MzUwMDAwO3M6OToib3JkZXJJbmZvIjtzOjM5OiJUaGFuaCB0b2FuIGRvbiBoYW5nIE9SREVSXzE3NjM0NzY2OTZfMTIiO3M6MTQ6InBheW1lbnRfbWV0aG9kIjtzOjM6ImF0bSI7fX0=', 1763476753);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `size_code` varchar(50) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `size_code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Small', 'S', 'Nhỏ, dành cho người có vóc dáng nhỏ nhắn.', 'inactive', '2025-10-03 23:28:17', '2025-11-06 14:44:08'),
(2, 'Medium', 'M', 'Trung bình, dành cho người có vóc dáng vừa phải.', 'active', '2025-10-03 23:28:17', '2025-11-06 14:44:36'),
(3, 'Large', 'L', 'Lớn, dành cho người có vóc dáng cao lớn.', 'active', '2025-10-03 23:28:17', '2025-11-06 14:45:07'),
(4, 'Extra Large', 'XL', 'Rất lớn, dành cho người có vóc dáng to lớn.', 'active', '2025-10-03 23:28:17', '2025-11-06 14:45:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(20, 'Streetwear', 'streetwear', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(21, 'Vintage', 'vintage', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(22, 'Minimal', 'minimal', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(23, 'High Fashion', 'high-fashion', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(24, 'Sneaker', 'sneaker', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(25, 'Denim', 'denim', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(26, 'Sustainable', 'sustainable', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(27, 'Lookbook', 'lookbook', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(28, 'Runway', 'runway', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(29, 'Local Brand', 'local-brand', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(30, 'Accessories', 'accessories', '2025-10-14 20:37:33', '2025-10-14 20:37:33'),
(31, 'Workwear', 'workwear', '2025-10-14 20:37:33', '2025-10-14 20:37:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `ranking_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role_id`, `ranking_id`, `image`, `username`, `name`, `email`, `phone`, `password`, `address`, `is_verified`, `verification_token`, `remember_token`, `created_at`, `updated_at`, `is_locked`, `deleted_at`) VALUES
(1, 2, 1, NULL, NULL, 'Nguyen Van A', 'a@example.com', '0900000001', '$2y$12$5oB6fuLsOfDnIV6zW8ez1erEN9XUDJFPc.2zchnwpAOvSFEv8R75K', 'Ha Noi', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-16 15:15:56', 0, NULL),
(2, 2, 1, NULL, NULL, 'Tran Thi B', 'b@example.com', '0900000002', '$2y$10$hashB', 'Hai Phong', 1, NULL, NULL, '2025-10-03 23:28:17', NULL, 0, NULL),
(3, 2, 2, NULL, NULL, 'Le Van C', 'c@example.com', '0900000003', '$2y$10$hashC', 'Da Nang', 1, NULL, NULL, '2025-10-03 23:28:17', NULL, 0, NULL),
(4, 2, 2, NULL, NULL, 'Pham Thi D', 'd@example.com', '0900000004', '$2y$10$hashD', 'Hue', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-19 08:41:22', 0, NULL),
(5, 1, 3, NULL, NULL, 'Admin', 'admin@example.com', '0900000005', '$2y$12$3DGrCuGafvhkSVbSbRklkuu.zoAbIB8Fukjig.phphKP8o18YKsfm', 'Ha Noi', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-16 15:09:28', 0, NULL),
(7, 2, 1, NULL, NULL, 'dja', 'h@gmail.com', NULL, '$2y$12$iCGCcqyZpWx2L5L6v/6qgetTNKl3DbAM.58nFZPL8RvQRxT7g3S4.', NULL, 1, NULL, NULL, '2025-10-19 10:28:10', '2025-10-19 10:28:10', 0, NULL),
(8, 2, 1, NULL, NULL, 'abcccc', 'a@gmail.com', NULL, '$2y$12$.q3Ycg24XybMIF.5xy9KoelHSZFh6qhLYflCGAPIyu.l414lITBni', NULL, 1, NULL, NULL, '2025-10-22 14:08:57', '2025-11-11 00:49:09', 0, NULL),
(9, 1, 1, NULL, NULL, 'test', 'test@gmail.com', NULL, '$2y$12$.DUpHvFrmB3f61zPNJXP6u9mVK.JFe1fbHFo7OcsjAPHMYQXow/r6', NULL, 1, NULL, NULL, '2025-10-22 14:11:34', '2025-11-11 01:28:19', 0, NULL),
(11, 2, NULL, NULL, NULL, 'Nguyễn Quang Huân', 'huan1@gmail.com', NULL, '$2y$12$XSbW2v/kK99Y2reC4UnVpu50F.M7SoMF6xeuUOeXtylVXh5.vRizS', NULL, 1, NULL, NULL, '2025-10-27 12:26:11', '2025-11-11 01:28:49', 0, NULL),
(12, 1, 1, 'avatars/a2OCQN2ReiB68jdFxXJJMAM8m3U9etdAsNjd2RSZ.gif', 'HoangHung04', 'Hoàng Văn Hùng', 'hungdz8975@gmail.com', '0369573472', '$2y$12$DRBPxZ4RWmXhSM96HQ230u04IJ9vzHEtunnSgrT3pwHJs1MeqfAbO', '66 Ng. 132 Đ. Cầu Diễn, Nguyên Xá, Bắc Từ Liêm, Hà Nội, Việt Nam', 1, NULL, 'z5gUubRK0KB4ifowDnIJm67PluKSThQliEi57MHdhUMEYYQP7mq1PBZgsfjG', '2025-11-01 11:06:44', '2025-11-03 00:42:17', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint UNSIGNED NOT NULL,
  `voucher_code` varchar(100) NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `total_used` int UNSIGNED NOT NULL DEFAULT '0',
  `user_limit` int UNSIGNED NOT NULL DEFAULT '1',
  `sale_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `min_order_value` decimal(12,2) NOT NULL DEFAULT '0.00',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_code`, `quantity`, `total_used`, `user_limit`, `sale_price`, `min_order_value`, `start_date`, `end_date`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SALE10', 100, 0, 1, 50000.00, 300000.00, '2025-10-03 23:28:17', '2025-11-02 23:28:17', 1, 'Giảm 50k cho đơn từ 300k', '2025-10-03 23:28:17', NULL),
(2, 'FREESHIP', 50, 0, 1, 30000.00, 200000.00, '2025-10-03 23:28:17', '2025-10-18 23:28:17', 1, 'Miễn phí vận chuyển', '2025-10-03 23:28:17', NULL),
(3, 'DISCOUNT20', 30, 0, 1, 100000.00, 500000.00, '2025-10-03 23:28:17', '2025-10-23 23:28:17', 1, 'Giảm 100k cho đơn từ 500k', '2025-10-03 23:28:17', NULL),
(4, 'NEWUSER', 200, 0, 1, 70000.00, 200000.00, '2025-10-03 23:28:17', '2025-12-02 23:28:17', 1, 'Voucher khách hàng mới', '2025-10-03 23:28:17', NULL),
(5, 'VIP50', 10, 0, 1, 200000.00, 1000000.00, '2025-10-03 23:28:17', '2026-01-01 23:28:17', 1, 'Giảm 200k cho khách VIP', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 1, 19, '2025-10-26 16:30:46', '2025-10-26 16:30:46'),
(3, 1, 6, '2025-10-27 02:10:26', '2025-10-27 02:10:26'),
(4, 1, 4, '2025-10-27 02:10:30', '2025-10-27 02:10:30'),
(5, 1, 14, '2025-10-27 02:10:37', '2025-10-27 02:10:37'),
(12, 12, 1, '2025-11-18 12:01:41', '2025-11-18 12:01:41');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `auths`
--
ALTER TABLE `auths`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_banners_location` (`location_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_carts_user` (`user_id`),
  ADD KEY `fk_carts_voucher` (`voucher_id`);

--
-- Chỉ mục cho bảng `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cart_variant` (`cart_id`,`product_variant_id`),
  ADD KEY `idx_cd_cart` (`cart_id`),
  ADD KEY `idx_cd_variant` (`product_variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Chỉ mục cho bảng `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chats_user` (`user_id`),
  ADD KEY `idx_chats_admin` (`admin_id`);

--
-- Chỉ mục cho bảng `chat_details`
--
ALTER TABLE `chat_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cd_chat` (`chat_id`),
  ADD KEY `idx_cd_sender` (`sender_id`),
  ADD KEY `idx_cd_receiver` (`receiver_id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_colors_name` (`name`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comments_news` (`news_id`),
  ADD KEY `idx_comments_user` (`user_id`),
  ADD KEY `idx_comments_parent` (`parent_id`),
  ADD KEY `idx_comments_status` (`status`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_code` (`invoice_code`),
  ADD KEY `idx_inv_order` (`order_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_news_slug` (`slug`),
  ADD KEY `idx_news_category` (`category_id`),
  ADD KEY `idx_news_author` (`author_id`),
  ADD KEY `idx_news_status_published_at` (`status`,`published_at`),
  ADD KEY `idx_news_views` (`views`);
ALTER TABLE `news` ADD FULLTEXT KEY `ft_news_text` (`title`,`excerpt`,`content`);

--
-- Chỉ mục cho bảng `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_news_categories_slug` (`slug`),
  ADD KEY `idx_news_categories_parent` (`parent_id`);

--
-- Chỉ mục cho bảng `news_tag`
--
ALTER TABLE `news_tag`
  ADD PRIMARY KEY (`news_id`,`tag_id`),
  ADD KEY `idx_news_tag_tag` (`tag_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`),
  ADD KEY `idx_notif_order` (`order_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `idx_orders_user` (`user_id`),
  ADD KEY `idx_orders_status` (`order_status_id`),
  ADD KEY `fk_orders_payment_status` (`payment_status_id`),
  ADD KEY `fk_orders_voucher` (`voucher_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_od_order` (`order_id`),
  ADD KEY `idx_od_variant` (`product_variant_id`);

--
-- Chỉ mục cho bảng `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pay_order` (`order_id`),
  ADD KEY `idx_pay_method` (`payment_method_id`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `payment_statuses`
--
ALTER TABLE `payment_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Chỉ mục cho bảng `product_favorites`
--
ALTER TABLE `product_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fav_user_product` (`user_id`,`product_id`),
  ADD KEY `idx_fav_product` (`product_id`);

--
-- Chỉ mục cho bảng `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ppa_product` (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pv_product` (`product_id`),
  ADD KEY `idx_pv_color` (`color_id`),
  ADD KEY `idx_pv_size` (`size_id`);

--
-- Chỉ mục cho bảng `rankings`
--
ALTER TABLE `rankings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_order` (`order_id`),
  ADD KEY `idx_reviews_product` (`product_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sizes_name` (`name`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tags_slug` (`slug`),
  ADD KEY `idx_tags_name` (`name`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`),
  ADD KEY `fk_users_ranking` (`ranking_id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_code` (`voucher_code`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `auths`
--
ALTER TABLE `auths`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `chat_details`
--
ALTER TABLE `chat_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT cho bảng `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT cho bảng `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `payment_statuses`
--
ALTER TABLE `payment_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `product_favorites`
--
ALTER TABLE `product_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `rankings`
--
ALTER TABLE `rankings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `fk_banners_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_carts_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `fk_cd_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cd_variant` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_chats_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chats_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `chat_details`
--
ALTER TABLE `chat_details`
  ADD CONSTRAINT `fk_cdetail_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cdetail_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cdetail_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_inv_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_category` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `news_categories`
--
ALTER TABLE `news_categories`
  ADD CONSTRAINT `fk_news_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `news_tag`
--
ALTER TABLE `news_tag`
  ADD CONSTRAINT `fk_news_tag_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_order_status` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_payment_status` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_od_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_od_variant` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pay_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pay_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `product_favorites`
--
ALTER TABLE `product_favorites`
  ADD CONSTRAINT `fk_fav_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fav_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  ADD CONSTRAINT `fk_ppa_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `fk_pv_color` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pv_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pv_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_ranking` FOREIGN KEY (`ranking_id`) REFERENCES `rankings` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
