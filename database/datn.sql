-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 29, 2025 at 12:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datn`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auths`
--

CREATE TABLE `auths` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
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
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `location_id`, `image`, `name`, `status`, `product_link`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'banner1.jpg', 'Sale 50%', 1, '/products/1', '2025-10-03', '2025-10-13', '2025-10-03 23:28:17', NULL),
(2, 1, 'banner2.jpg', 'New Arrival', 1, '/products/2', '2025-10-03', '2025-10-18', '2025-10-03 23:28:17', NULL),
(3, 2, 'banner3.jpg', 'Flash Sale', 1, '/products/3', '2025-10-03', '2025-10-08', '2025-10-03 23:28:17', NULL),
(4, 3, 'banner4.jpg', 'Back to School', 1, '/products/4', '2025-10-03', '2025-10-23', '2025-10-03 23:28:17', NULL),
(5, 2, 'banner5.jpg', 'Hot Deal', 1, '/products/5', '2025-10-03', '2025-10-10', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
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
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `voucher_id`, `quantity`, `price`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 500000.00, 450000.00, '2025-10-03 23:28:17', NULL),
(2, 2, 2, 1, 150000.00, 120000.00, '2025-10-03 23:28:17', NULL),
(3, 3, NULL, 3, 900000.00, 900000.00, '2025-10-03 23:28:17', NULL),
(4, 4, 3, 1, 350000.00, 250000.00, '2025-10-03 23:28:17', NULL),
(5, 5, 4, 5, 2000000.00, 1930000.00, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
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
-- Dumping data for table `cart_details`
--

INSERT INTO `cart_details` (`id`, `cart_id`, `product_variant_id`, `price`, `quantity`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 250000.00, 2, 500000.00, '2025-10-03 23:28:17', NULL),
(2, 2, 3, 150000.00, 1, 150000.00, '2025-10-03 23:28:17', NULL),
(3, 3, 4, 350000.00, 2, 700000.00, '2025-10-03 23:28:17', NULL),
(4, 3, 5, 500000.00, 1, 500000.00, '2025-10-03 23:28:17', NULL),
(5, 4, 2, 260000.00, 1, 260000.00, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Thời trang Nam', 'thoi-trang-nam', 'Quần áo nam', '2025-10-03 23:28:17', '2025-10-26 23:53:49', NULL),
(2, NULL, 'Thời trang Nữ', 'thoi-trang-nu', 'Quần áo nữ', '2025-10-03 23:28:17', NULL, NULL),
(3, NULL, 'Phụ kiện', 'phu-kien', 'Phụ kiện thời trang', '2025-10-03 23:28:17', NULL, NULL),
(4, NULL, 'Giày dép', 'giay-dep', 'Các loại giày dép', '2025-10-03 23:28:17', NULL, NULL),
(5, NULL, 'Túi xách', 'tui-xach', 'Túi xách cao cấp', '2025-10-03 23:28:17', NULL, NULL),
(6, 5, 'aaaa', 'rr', 's', '2025-10-16 14:13:35', '2025-10-16 14:13:35', NULL),
(11, NULL, 'aa', 'aa', NULL, '2025-10-27 13:00:21', '2025-10-27 13:00:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
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
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `admin_id`, `is_message_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(2, 2, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(3, 3, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(4, 4, 5, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL),
(5, 5, NULL, '2025-10-03 23:28:17', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chat_details`
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
-- Dumping data for table `chat_details`
--

INSERT INTO `chat_details` (`id`, `chat_id`, `sender_id`, `receiver_id`, `message`, `is_read`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Shop ơi còn hàng không?', 0, 1, '2025-10-03 23:28:17', NULL),
(2, 1, 5, 1, 'Còn bạn nhé', 1, 1, '2025-10-03 23:28:17', NULL),
(3, 2, 2, 5, 'Ship về Hải Phòng nhanh ko?', 0, 1, '2025-10-03 23:28:17', NULL),
(4, 3, 3, 5, 'Mình muốn đổi size', 0, 1, '2025-10-03 23:28:17', NULL),
(5, 4, 4, 5, 'Sản phẩm có bảo hành ko?', 0, 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
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
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Redc', '#FF0000', NULL, 'inactive', '2025-10-03 23:28:17', '2025-10-26 16:29:11'),
(2, 'Blue', '#0000FF', NULL, 'active', '2025-10-03 23:28:17', NULL),
(3, 'White', '#FFFFFF', NULL, 'active', '2025-10-03 23:28:17', NULL),
(4, 'Black', '#000000', NULL, 'active', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
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
-- Dumping data for table `comments`
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
-- Table structure for table `failed_jobs`
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
-- Table structure for table `invoices`
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
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `invoice_code`, `issue_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV001', '2025-10-03', '2025-10-03 23:28:17', NULL),
(2, 2, 'INV002', '2025-10-03', '2025-10-03 23:28:17', NULL),
(3, 3, 'INV003', '2025-10-03', '2025-10-03 23:28:17', NULL),
(4, 4, 'INV004', '2025-10-03', '2025-10-03 23:28:17', NULL),
(5, 5, 'INV005', '2025-10-03', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'Homepage Banner'),
(3, 'Sidebar Bottom'),
(2, 'Sidebar Top');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
(12, '2025_10_26_162205_add_description_and_status_to_colors_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `news`
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
-- Dumping data for table `news`
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
-- Table structure for table `news_categories`
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
-- Dumping data for table `news_categories`
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
-- Table structure for table `news_tag`
--

CREATE TABLE `news_tag` (
  `news_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_tag`
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
-- Table structure for table `notifications`
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
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `order_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Đơn hàng mới', 'Bạn vừa đặt đơn ORD001', '2025-10-03 23:28:17', NULL),
(2, 2, 2, 'Thanh toán thành công', 'Đơn ORD002 đã thanh toán', '2025-10-03 23:28:17', NULL),
(3, 3, 3, 'Đơn hàng đang xử lý', 'ORD003 đang chuẩn bị hàng', '2025-10-03 23:28:17', NULL),
(4, 4, 4, 'Đơn hàng giảm giá', 'ORD004 đã được giảm giá', '2025-10-03 23:28:17', NULL),
(5, 5, 5, 'Giao hàng', 'ORD005 đang giao', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_status_id`, `order_status_id`, `voucher_id`, `order_code`, `name`, `address`, `phone`, `subtotal`, `discount`, `total_amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 'ORD001', 'Nguyen Van A', 'Ha Noi', '0900000001', 500000.00, 50000.00, 450000.00, 'Giao nhanh', '2025-10-03 23:28:17', NULL),
(2, 2, 2, 2, 2, 'ORD002', 'Tran Thi B', 'Hai Phong', '0900000002', 150000.00, 30000.00, 120000.00, '', '2025-10-03 23:28:17', NULL),
(3, 3, 1, 1, NULL, 'ORD003', 'Le Van C', 'Da Nang', '0900000003', 900000.00, 0.00, 900000.00, 'Ship giờ hành chính', '2025-10-03 23:28:17', NULL),
(4, 4, 1, 1, 3, 'ORD004', 'Pham Thi D', 'Hue', '0900000004', 350000.00, 100000.00, 250000.00, '', '2025-10-03 23:28:17', NULL),
(5, 5, 2, 4, 4, 'ORD005', 'Admin', 'Ha Noi', '0900000005', 2000000.00, 70000.00, 1930000.00, '', '2025-10-03 23:28:17', '2025-10-26 23:58:03'),
(6, 1, 1, 4, NULL, 'ORD21', 'aaaa', 'aaaa', '0900000001', 0.00, 0.00, 0.00, NULL, NULL, '2025-10-27 13:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
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
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_variant_id`, `price`, `quantity`, `status`, `estimated_delivery`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 250000.00, 2, 1, '2025-10-06', '2025-10-03 23:28:17', NULL),
(2, 2, 3, 150000.00, 1, 1, '2025-10-07', '2025-10-03 23:28:17', NULL),
(3, 3, 4, 350000.00, 2, 1, '2025-10-08', '2025-10-03 23:28:17', NULL),
(4, 4, 2, 260000.00, 1, 1, '2025-10-05', '2025-10-03 23:28:17', NULL),
(5, 5, 5, 500000.00, 4, 1, '2025-10-10', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_statuses`
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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
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
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method_id`, `payment_code`, `payment_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'COD001', 450000.00, 0, '2025-10-03 23:28:17', NULL),
(2, 2, 2, 'VNPAY001', 120000.00, 1, '2025-10-03 23:28:17', NULL),
(3, 3, 3, 'MOMO001', 900000.00, 1, '2025-10-03 23:28:17', NULL),
(4, 4, 1, 'COD002', 250000.00, 0, '2025-10-03 23:28:17', NULL),
(5, 5, 2, 'VNPAY002', 1930000.00, 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
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
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `code`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Thanh toán khi nhận hàng', 'COD', 'offline', NULL, NULL),
(2, 'VNPAY', 'VNPAY', 'online', NULL, NULL),
(3, 'MoMo', 'MOMO', 'online', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_statuses`
--

CREATE TABLE `payment_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Chưa thanh toán', NULL, NULL),
(2, 'Đã thanh toán', NULL, NULL),
(3, 'Hoàn tiền', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_code`, `name`, `description`, `view`, `material`, `onpage`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'SP001', 'Áo sơ mi nam', 'Áo sơ mi công sở', 124, 'Cotton', 1, '2025-10-03 23:28:17', '2025-10-19 08:45:29', NULL),
(2, 1, 'SP002', 'Áo thun nam', 'Áo thun basic', 174, 'Polyester', 1, '2025-10-03 23:28:17', NULL, NULL),
(3, 2, 'SP003', 'Váy nữ xòe', 'Váy công sở xòe nhẹ', 491, 'Lụa', 1, '2025-10-03 23:28:17', NULL, NULL),
(4, 4, 'SP004', 'Quần dài túi hộp', 'Giày sneaker trẻ trung', 450, 'Da PU', 1, '2025-10-03 23:28:17', '2025-10-27 11:36:15', NULL),
(5, 1, 'SP005', 'Quần short jean', 'Túi xách nữ thời trang', 275, 'Da bò', 1, '2025-10-03 23:28:17', '2025-10-27 11:41:15', NULL),
(6, 1, 'SP006', 'Áo polo nam cao cấp', 'Áo polo vải thun lạnh, thoáng mát', 17, 'Thun lạnh', 1, '2025-10-08 00:04:37', NULL, NULL),
(7, 1, 'SP007', 'Áo khoác nam chống nắng', 'Áo khoác dù siêu nhẹ, chống tia UV', 230, 'Polyester', 1, '2025-10-08 00:04:37', NULL, NULL),
(8, 2, 'SP008', 'Áo thun sleep', 'Đầm thiết kế thanh lịch cho dân văn phòng', 109, 'Lụa Nhật', 1, '2025-10-08 00:04:37', '2025-10-27 11:39:12', NULL),
(9, 1, 'SP009', 'Quần jean line up', 'Áo nữ thiết kế trẻ trung, phong cách', 338, 'Voan mịn', 1, '2025-10-08 00:04:37', '2025-10-27 11:42:32', NULL),
(10, 3, 'SP010', 'Kính mát thời trang', 'Kính gọng kim loại cao cấp', 370, 'Kim loại', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:36', '2025-10-27 04:44:36'),
(11, 1, 'SP011', 'Áo tanktop', 'Thắt lưng nam khóa hợp kim cao cấp', 335, 'Da bò thật', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:45', '2025-10-27 04:44:45'),
(12, 3, 'SP012', 'Mũ lưỡi trai Unisex', 'Mũ lưỡi trai trơn phong cách Hàn Quốc', 63, 'Cotton', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:51', '2025-10-27 04:44:51'),
(13, 4, 'SP013', 'Giày thể thao nữ', 'Giày sneaker đế êm, nhẹ', 284, 'Da tổng hợp', 0, '2025-10-08 00:04:37', '2025-10-27 11:44:56', '2025-10-27 04:44:56'),
(14, 4, 'SP014', 'Dép lê nam đơn giản', 'Dép lê cao su, thoải mái khi di chuyển', 241, 'Cao su', 0, '2025-10-08 00:04:37', '2025-10-27 11:45:00', '2025-10-27 04:45:00'),
(15, 4, 'SP015', 'Giày da công sở nam', 'Giày tây nam bóng mịn, sang trọng', 341, 'Da bò', 0, '2025-10-08 00:04:37', '2025-10-27 11:45:05', '2025-10-27 04:45:05'),
(16, 5, 'SP016', 'Áo polo overthinking', 'Túi đeo chéo tiện lợi, phong cách trẻ', 484, 'Vải canvas', 1, '2025-10-08 00:04:37', '2025-10-27 11:43:47', NULL),
(17, 5, 'SP017', 'Balo laptop chống nước', 'Balo thời trang, chống thấm nước', 403, 'Nylon', 0, '2025-10-08 00:04:37', '2025-10-27 11:33:10', '2025-10-27 04:33:10'),
(18, 5, 'SP018', 'Ví da nam mini', 'Ví nhỏ gọn, nhiều ngăn, da mềm', 65, 'Da thật', 0, '2025-10-08 00:04:37', '2025-10-27 11:33:16', '2025-10-27 04:33:16'),
(19, 2, 'SP019', 'Áo khoác nữ form rộng', 'Áo khoác nữ phong cách Hàn Quốc', 87, 'Kaki', 1, '2025-10-08 00:04:37', NULL, NULL),
(20, 1, 'SP020', 'Quần jean nam rách gối', 'Quần jean rách phong cách streetwear', 231, 'Jean cotton', 1, '2025-10-08 00:04:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_favorites`
--

CREATE TABLE `product_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_favorites`
--

INSERT INTO `product_favorites` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-10-03 23:28:17', NULL),
(2, 2, 2, '2025-10-03 23:28:17', NULL),
(3, 3, 3, '2025-10-03 23:28:17', NULL),
(4, 4, 4, '2025-10-03 23:28:17', NULL),
(5, 5, 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_photo_albums`
--

CREATE TABLE `product_photo_albums` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_photo_albums`
--

INSERT INTO `product_photo_albums` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(10, 10, 'sunglasses1_detail.jpg', '2025-10-08 00:04:37', NULL),
(11, 11, 'belt1_detail.jpg', '2025-10-08 00:04:37', NULL),
(12, 12, 'cap1_detail.jpg', '2025-10-08 00:04:37', NULL),
(13, 13, 'shoes2_detail.jpg', '2025-10-08 00:04:37', NULL),
(14, 14, 'slipper1_detail.jpg', '2025-10-08 00:04:37', NULL),
(15, 15, 'shoes3_detail.jpg', '2025-10-08 00:04:37', NULL),
(28, 1, 'products/F1Zj7nANKXVBUd9cGyYpoD07Dssff5AntuXs6FiE.jpg', '2025-10-27 11:16:42', '2025-10-27 11:16:42'),
(29, 2, 'products/ekqMIftlkq9YPhhfOTfketVGr9e5lTPk2h0ldiNN.png', '2025-10-27 11:19:44', '2025-10-27 11:19:44'),
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
-- Table structure for table `product_variants`
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
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color_id`, `size_id`, `price`, `sale`, `image`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 250000.00, 200000.00, 'shirt1-red.jpg', 50, 1, '2025-10-03 23:28:17', NULL),
(2, 1, 2, 2, 260000.00, NULL, 'shirt1-blue.jpg', 0, 1, '2025-10-03 23:28:17', NULL),
(3, 2, 1, 2, 150000.00, NULL, 'shirt2-red.jpg', 0, 1, '2025-10-03 23:28:17', NULL),
(4, 3, 3, 3, 350000.00, 300000.00, 'dress1-white.jpg', 0, 1, '2025-10-03 23:28:17', NULL),
(5, 4, 4, 2, 500000.00, 450000.00, 'sneaker1-black.jpg', 0, 1, '2025-10-03 23:28:17', NULL),
(6, 6, 1, 2, 220000.00, 200000.00, 'polo1-red.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(7, 7, 4, 3, 350000.00, 320000.00, 'jacket1-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(8, 8, 3, 3, 400000.00, 370000.00, 'dress2-white.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(9, 9, 2, 2, 280000.00, NULL, 'top1-blue.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(10, 10, 4, NULL, 250000.00, NULL, 'sunglasses1-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(11, 11, 4, NULL, 300000.00, 270000.00, 'belt1-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(12, 12, NULL, NULL, 180000.00, NULL, 'cap1-green.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(13, 13, 3, 3, 480000.00, 450000.00, 'shoes2-white.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(14, 14, 4, NULL, 120000.00, NULL, 'slipper1-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(15, 15, 4, 3, 650000.00, 600000.00, 'shoes3-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(16, 16, NULL, NULL, 230000.00, NULL, 'bag2-green.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(17, 17, 2, NULL, 490000.00, 460000.00, 'bag3-blue.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(18, 18, 4, NULL, 210000.00, 180000.00, 'wallet1-black.jpg', 0, 1, '2025-10-08 00:04:37', NULL),
(19, 19, 2, 4, 400000.00, 350000.00, 'jacket2-blue.jpg', 120, 1, '2025-10-08 00:04:37', '2025-10-26 23:52:48'),
(20, 20, 1, 3, 370000.00, 340000.00, 'jean1-red.jpg', 100, 1, '2025-10-08 00:04:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rankings`
--

CREATE TABLE `rankings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_points` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rankings`
--

INSERT INTO `rankings` (`id`, `name`, `min_points`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 0, NULL, NULL),
(2, 'Silver', 1000, NULL, NULL),
(3, 'Gold', 5000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
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
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `product_id`, `rating`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Áo đẹp, chất liệu tốt', 1, '2025-10-03 23:28:17', NULL),
(2, 2, 2, 4, 'Áo thun ổn', 1, '2025-10-03 23:28:17', NULL),
(3, 3, 3, 5, 'Váy rất xinh', 1, '2025-10-03 23:28:17', NULL),
(4, 4, 4, 3, 'Giày hơi chật', 1, '2025-10-03 23:28:17', NULL),
(5, 5, 5, 5, 'Túi rất sang', 1, '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'member', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aa20rjg1eZQ4Vk0KR7IWFbUghoS38P7lkDhb5NqR', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiQW1SVjlxa0dwaTNWTlhuQTdEeVRrV2ZuUHdCYkVuSnlOT2lhMDM2cyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiY2FydCI7YToyOntpOjIwO2E6OTp7czoxMDoidmFyaWFudF9pZCI7aToyMDtzOjEwOiJwcm9kdWN0X2lkIjtpOjIwO3M6NDoibmFtZSI7czoyNzoiUXXhuqduIGplYW4gbmFtIHLDoWNoIGfhu5FpIjtzOjU6ImNvbG9yIjtzOjQ6IlJlZGMiO3M6NDoic2l6ZSI7czoxOiJMIjtzOjU6InByaWNlIjtkOjM0MDAwMDtzOjg6InF1YW50aXR5IjtpOjE7czo1OiJpbWFnZSI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ltYWdlcy9wbGFjZWhvbGRlci5wbmciO3M6NDoic2x1ZyI7Tjt9aToxOTthOjk6e3M6MTA6InZhcmlhbnRfaWQiO2k6MTk7czoxMDoicHJvZHVjdF9pZCI7aToxOTtzOjQ6Im5hbWUiO3M6Mjc6IsOBbyBraG/DoWMgbuG7ryBmb3JtIHLhu5luZyI7czo1OiJjb2xvciI7czo0OiJCbHVlIjtzOjQ6InNpemUiO3M6MjoiWEwiO3M6NToicHJpY2UiO2Q6MzUwMDAwO3M6ODoicXVhbnRpdHkiO2k6MTtzOjU6ImltYWdlIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaW1hZ2VzL3BsYWNlaG9sZGVyLnBuZyI7czo0OiJzbHVnIjtOO319czoxMzoicGVuZGluZ19vcmRlciI7YTo0OntzOjc6Im9yZGVySWQiO3M6MTg6Ik9SREVSXzE3NjE1MDQwNTVfMSI7czoxMToidG90YWxBbW91bnQiO2Q6NzcwMDAwO3M6OToib3JkZXJJbmZvIjtzOjM4OiJUaGFuaCB0b2FuIGRvbiBoYW5nIE9SREVSXzE3NjE1MDQwNTVfMSI7czoxNDoicGF5bWVudF9tZXRob2QiO3M6MzoiYXRtIjt9fQ==', 1761504124),
('u4BsBicqlGe6K8eFU4542Ijz2Djsa9iA6GpZFbFN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRGlMTU1ZN3VjNlhvanZOOXNqM1BTSGYybTdOdkI4WXRWYzc3Y0JucCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly9kYXRuXzA5LnRlc3QvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761554629);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
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
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `size_code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'S', 'Sc', NULL, 'inactive', '2025-10-03 23:28:17', '2025-10-27 10:43:40'),
(2, 'M', 'M', NULL, 'active', '2025-10-03 23:28:17', NULL),
(3, 'L', 'L', NULL, 'active', '2025-10-03 23:28:17', NULL),
(4, 'XL', 'XL', NULL, 'active', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `ranking_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `ranking_id`, `image`, `name`, `email`, `phone`, `password`, `address`, `is_verified`, `verification_token`, `remember_token`, `created_at`, `updated_at`, `is_locked`, `deleted_at`) VALUES
(1, 2, 1, NULL, 'Nguyen Van A', 'a@example.com', '0900000001', '$2y$12$5oB6fuLsOfDnIV6zW8ez1erEN9XUDJFPc.2zchnwpAOvSFEv8R75K', 'Ha Noi', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-16 15:15:56', 0, NULL),
(2, 2, 1, NULL, 'Tran Thi B', 'b@example.com', '0900000002', '$2y$10$hashB', 'Hai Phong', 1, NULL, NULL, '2025-10-03 23:28:17', NULL, 0, NULL),
(3, 2, 2, NULL, 'Le Van C', 'c@example.com', '0900000003', '$2y$10$hashC', 'Da Nang', 1, NULL, NULL, '2025-10-03 23:28:17', NULL, 0, NULL),
(4, 2, 2, NULL, 'Pham Thi D', 'd@example.com', '0900000004', '$2y$10$hashD', 'Hue', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-19 08:41:22', 0, NULL),
(5, 1, 3, NULL, 'Admin', 'admin@example.com', '0900000005', '$2y$12$3DGrCuGafvhkSVbSbRklkuu.zoAbIB8Fukjig.phphKP8o18YKsfm', 'Ha Noi', 1, NULL, NULL, '2025-10-03 23:28:17', '2025-10-16 15:09:28', 0, NULL),
(6, 1, NULL, NULL, 'ad', 'ad@gmail.com', '0234567899', '123456', 'hn', 0, 'a', 'iLXm2pPH6rWEDIxsC82uQEW3UAUfGu9REg2fK2hzfj1o6UHuzZ205uDM6iKI', NULL, NULL, 0, NULL),
(7, 2, 1, NULL, 'dja', 'h@gmail.com', NULL, '$2y$12$iCGCcqyZpWx2L5L6v/6qgetTNKl3DbAM.58nFZPL8RvQRxT7g3S4.', NULL, 1, NULL, NULL, '2025-10-19 10:28:10', '2025-10-19 10:28:10', 0, NULL),
(8, 2, 1, NULL, 'abcccc', 'a@gmail.com', NULL, '$2y$12$.q3Ycg24XybMIF.5xy9KoelHSZFh6qhLYflCGAPIyu.l414lITBni', NULL, 1, NULL, NULL, '2025-10-22 14:08:57', '2025-10-22 14:08:57', 0, NULL),
(9, 1, 1, NULL, 'test', 'test@gmail.com', NULL, '$2y$12$.DUpHvFrmB3f61zPNJXP6u9mVK.JFe1fbHFo7OcsjAPHMYQXow/r6', NULL, 1, NULL, NULL, '2025-10-22 14:11:34', '2025-10-26 23:52:14', 0, NULL),
(11, 2, 1, NULL, 'Nguyễn Quang Huân', 'huan1@gmail.com', NULL, '$2y$12$XSbW2v/kK99Y2reC4UnVpu50F.M7SoMF6xeuUOeXtylVXh5.vRizS', NULL, 1, NULL, NULL, '2025-10-27 12:26:11', '2025-10-27 12:26:11', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
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
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_code`, `quantity`, `total_used`, `user_limit`, `sale_price`, `min_order_value`, `start_date`, `end_date`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SALE10', 100, 0, 1, 50000.00, 300000.00, '2025-10-03 23:28:17', '2025-11-02 23:28:17', 1, 'Giảm 50k cho đơn từ 300k', '2025-10-03 23:28:17', NULL),
(2, 'FREESHIP', 50, 0, 1, 30000.00, 200000.00, '2025-10-03 23:28:17', '2025-10-18 23:28:17', 1, 'Miễn phí vận chuyển', '2025-10-03 23:28:17', NULL),
(3, 'DISCOUNT20', 30, 0, 1, 100000.00, 500000.00, '2025-10-03 23:28:17', '2025-10-23 23:28:17', 1, 'Giảm 100k cho đơn từ 500k', '2025-10-03 23:28:17', NULL),
(4, 'NEWUSER', 200, 0, 1, 70000.00, 200000.00, '2025-10-03 23:28:17', '2025-12-02 23:28:17', 1, 'Voucher khách hàng mới', '2025-10-03 23:28:17', NULL),
(5, 'VIP50', 10, 0, 1, 200000.00, 1000000.00, '2025-10-03 23:28:17', '2026-01-01 23:28:17', 1, 'Giảm 200k cho khách VIP', '2025-10-03 23:28:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 1, 19, '2025-10-26 16:30:46', '2025-10-26 16:30:46'),
(3, 1, 6, '2025-10-27 02:10:26', '2025-10-27 02:10:26'),
(4, 1, 4, '2025-10-27 02:10:30', '2025-10-27 02:10:30'),
(5, 1, 14, '2025-10-27 02:10:37', '2025-10-27 02:10:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auths`
--
ALTER TABLE `auths`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_banners_location` (`location_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_carts_user` (`user_id`),
  ADD KEY `fk_carts_voucher` (`voucher_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cart_variant` (`cart_id`,`product_variant_id`),
  ADD KEY `idx_cd_cart` (`cart_id`),
  ADD KEY `idx_cd_variant` (`product_variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chats_user` (`user_id`),
  ADD KEY `idx_chats_admin` (`admin_id`);

--
-- Indexes for table `chat_details`
--
ALTER TABLE `chat_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cd_chat` (`chat_id`),
  ADD KEY `idx_cd_sender` (`sender_id`),
  ADD KEY `idx_cd_receiver` (`receiver_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_colors_name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comments_news` (`news_id`),
  ADD KEY `idx_comments_user` (`user_id`),
  ADD KEY `idx_comments_parent` (`parent_id`),
  ADD KEY `idx_comments_status` (`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_code` (`invoice_code`),
  ADD KEY `idx_inv_order` (`order_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
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
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_news_categories_slug` (`slug`),
  ADD KEY `idx_news_categories_parent` (`parent_id`);

--
-- Indexes for table `news_tag`
--
ALTER TABLE `news_tag`
  ADD PRIMARY KEY (`news_id`,`tag_id`),
  ADD KEY `idx_news_tag_tag` (`tag_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`),
  ADD KEY `idx_notif_order` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `idx_orders_user` (`user_id`),
  ADD KEY `idx_orders_status` (`order_status_id`),
  ADD KEY `fk_orders_payment_status` (`payment_status_id`),
  ADD KEY `fk_orders_voucher` (`voucher_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_od_order` (`order_id`),
  ADD KEY `idx_od_variant` (`product_variant_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pay_order` (`order_id`),
  ADD KEY `idx_pay_method` (`payment_method_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Indexes for table `product_favorites`
--
ALTER TABLE `product_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_fav_user_product` (`user_id`,`product_id`),
  ADD KEY `idx_fav_product` (`product_id`);

--
-- Indexes for table `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ppa_product` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pv_product` (`product_id`),
  ADD KEY `idx_pv_color` (`color_id`),
  ADD KEY `idx_pv_size` (`size_id`);

--
-- Indexes for table `rankings`
--
ALTER TABLE `rankings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_order` (`order_id`),
  ADD KEY `idx_reviews_product` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sizes_name` (`name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tags_slug` (`slug`),
  ADD KEY `idx_tags_name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`),
  ADD KEY `fk_users_ranking` (`ranking_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_code` (`voucher_code`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auths`
--
ALTER TABLE `auths`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat_details`
--
ALTER TABLE `chat_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_favorites`
--
ALTER TABLE `product_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rankings`
--
ALTER TABLE `rankings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `fk_banners_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_carts_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `fk_cd_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cd_variant` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_chats_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chats_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_details`
--
ALTER TABLE `chat_details`
  ADD CONSTRAINT `fk_cdetail_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cdetail_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cdetail_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_inv_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_category` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD CONSTRAINT `fk_news_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `news_tag`
--
ALTER TABLE `news_tag`
  ADD CONSTRAINT `fk_news_tag_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_tag_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_order_status` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_payment_status` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_statuses` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_od_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_od_variant` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_pay_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pay_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `product_favorites`
--
ALTER TABLE `product_favorites`
  ADD CONSTRAINT `fk_fav_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fav_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_photo_albums`
--
ALTER TABLE `product_photo_albums`
  ADD CONSTRAINT `fk_ppa_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `fk_pv_color` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pv_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pv_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_ranking` FOREIGN KEY (`ranking_id`) REFERENCES `rankings` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
