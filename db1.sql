-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2024 at 03:49 PM
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
-- Database: `admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Size', '2024-02-16 07:49:17', '2024-02-16 07:49:17'),
(2, 'Color', '2024-02-16 07:49:31', '2024-02-16 07:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `slug`, `image`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `is_enable`, `sort`) VALUES
(1, 'logo-text1', 'logo-text1', 'assets/images/logo/brandlogo1.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(2, 'logo-text2', 'logo-text2', 'assets/images/logo/brandlogo2.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(3, 'logo-text3', 'logo-text3', 'assets/images/logo/brandlogo3.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(4, 'logo-text4', 'logo-text4', 'assets/images/logo/brandlogo4.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(5, 'logo-text5', 'logo-text5', 'assets/images/logo/brandlogo5.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(6, 'logo-text6', 'logo-text6', 'assets/images/logo/brandlogo6.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(7, 'logo-text7', 'logo-text7', 'assets/images/logo/brandlogo3.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(8, 'logo-text8', 'logo-text8', 'assets/images/logo/brandlogo2.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL),
(9, 'logo-text9', 'logo-text9', 'assets/images/logo/brandlogo1.png', NULL, NULL, NULL, '2024-02-15 10:56:59', '2024-02-15 10:56:59', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `is_featured` int(11) DEFAULT 0,
  `sort` int(11) DEFAULT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `details`, `image_id`, `parent_id`, `level`, `is_featured`, `sort`, `is_enable`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(34, 'default', 'default', NULL, '28', NULL, 1, 0, 0, 1, NULL, NULL, NULL, '2024-03-01 03:48:21', '2024-03-03 04:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `is_featured` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `title`, `slug`, `details`, `sort`, `image_id`, `meta_title`, `meta_description`, `meta_keywords`, `is_enable`, `is_featured`, `created_at`, `updated_at`) VALUES
(4, 'Women\'s Clothing', 'women-s-clothing', 'Women\'s Clothing sss', 2, '54', 'Meta Title 1', 'Meta Description 1', 'test1 1', 1, 0, '2024-01-15 12:55:20', '2024-03-03 07:02:40'),
(6, 'Jewellery', 'Jewellery', NULL, 3, '13', 'Meta Title', 'Meta Description', 'keywords', 1, 0, '2024-01-15 12:48:06', '2024-03-03 06:59:44'),
(8, 'Men\'s Clothing', 'Men\'s Clothing', NULL, 2, '51', 'Meta Title', 'Meta Description', 'keyword1,keyword2,keyword3', 1, 0, '2024-01-19 17:20:18', '2024-03-03 07:02:17'),
(9, 'Watches', 'Watches', NULL, 1, '55', 'Meta Title', 'Meta Description', 'keyword1', 1, 0, '2024-01-19 17:17:53', '2024-03-03 07:03:47'),
(10, 'Baby', 'Baby', NULL, 1, '56', 'Meta Title', 'Meta Description', 'keyword1', 1, 0, '2024-01-19 17:17:53', '2024-03-03 07:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filemanager`
--

CREATE TABLE `filemanager` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `preview` text DEFAULT NULL,
  `size` double DEFAULT NULL,
  `extension` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filemanager`
--

INSERT INTO `filemanager` (`id`, `title`, `description`, `filename`, `preview`, `size`, `extension`, `type`, `path`, `created_by`, `created_at`, `is_enable`, `updated_at`) VALUES
(12, 'collection7', NULL, '1708785770.jpg', 'http://localhost/admin/public/filemanager/1708785770.jpg', 38497, 'jpg', 'image/jpeg', 'filemanager/1708785770.jpg', NULL, '2024-02-24 09:42:50', 1, '2024-02-24 09:42:50'),
(13, 'collection8', NULL, '1708785796.jpg', 'http://localhost/admin/public/filemanager/1708785796.jpg', 34969, 'jpg', 'image/jpeg', 'filemanager/1708785796.jpg', NULL, '2024-02-24 09:43:16', 1, '2024-02-24 09:43:16'),
(14, 'demo8-img1', NULL, '1708785835.jpg', 'http://localhost/admin/public/filemanager/1708785835.jpg', 16636, 'jpg', 'image/jpeg', 'filemanager/1708785835.jpg', NULL, '2024-02-24 09:43:55', 1, '2024-02-24 09:43:55'),
(15, 'demo8-img2', NULL, '1708785868.jpg', 'http://localhost/admin/public/filemanager/1708785868.jpg', 77939, 'jpg', 'image/jpeg', 'filemanager/1708785868.jpg', NULL, '2024-02-24 09:44:28', 1, '2024-02-24 09:44:28'),
(16, 'home2-collection1', NULL, '1708785892.jpg', 'http://localhost/admin/public/filemanager/1708785892.jpg', 35459, 'jpg', 'image/jpeg', 'filemanager/1708785892.jpg', NULL, '2024-02-24 09:44:52', 1, '2024-02-24 09:44:52'),
(17, 'home4-collection3', NULL, '1708785970.jpg', 'http://localhost/admin/public/filemanager/1708785970.jpg', 32146, 'jpg', 'image/jpeg', 'filemanager/1708785970.jpg', NULL, '2024-02-24 09:46:10', 1, '2024-02-24 09:46:10'),
(18, 'home5-collection1', NULL, '1708786019.jpg', 'http://localhost/admin/public/filemanager/1708786019.jpg', 115393, 'jpg', 'image/jpeg', 'filemanager/1708786019.jpg', NULL, '2024-02-24 09:46:59', 1, '2024-02-24 09:46:59'),
(19, 'home7-collection1', NULL, '1708786043.jpg', 'http://localhost/admin/public/filemanager/1708786043.jpg', 34800, 'jpg', 'image/jpeg', 'filemanager/1708786043.jpg', NULL, '2024-02-24 09:47:23', 1, '2024-02-24 09:47:23'),
(20, 'home8-collection2', NULL, '1708786070.jpg', 'http://localhost/admin/public/filemanager/1708786070.jpg', 56407, 'jpg', 'image/jpeg', 'filemanager/1708786070.jpg', NULL, '2024-02-24 09:47:50', 1, '2024-02-24 09:47:50'),
(21, 'home10-collection3', NULL, '1708786094.jpg', 'http://localhost/admin/public/filemanager/1708786094.jpg', 33588, 'jpg', 'image/jpeg', 'filemanager/1708786094.jpg', NULL, '2024-02-24 09:48:14', 1, '2024-02-24 09:48:14'),
(22, 'home11-collection5', NULL, '1708786130.jpg', 'http://localhost/admin/public/filemanager/1708786130.jpg', 33866, 'jpg', 'image/jpeg', 'filemanager/1708786130.jpg', NULL, '2024-02-24 09:48:50', 1, '2024-02-24 09:48:50'),
(23, '1708786229.jpg', NULL, '1708786229.jpg', 'http://localhost/admin/public/filemanager/1708786229.jpg', 76011, 'jpg', 'image/jpeg', 'filemanager/1708786229.jpg', NULL, '2024-02-24 09:50:29', 1, '2024-02-24 09:50:29'),
(24, '1708786246.jpg', NULL, '1708786246.jpg', 'http://localhost/admin/public/filemanager/1708786246.jpg', 85717, 'jpg', 'image/jpeg', 'filemanager/1708786246.jpg', NULL, '2024-02-24 09:50:46', 1, '2024-02-24 09:50:46'),
(25, '1708786292.jpg', NULL, '1708786292.jpg', 'http://localhost/admin/public/filemanager/1708786292.jpg', 18533, 'jpg', 'image/jpeg', 'filemanager/1708786292.jpg', NULL, '2024-02-24 09:51:32', 1, '2024-02-24 09:51:32'),
(26, '1708786331.jpg', NULL, '1708786331.jpg', 'http://localhost/admin/public/filemanager/1708786331.jpg', 40314, 'jpg', 'image/jpeg', 'filemanager/1708786331.jpg', NULL, '2024-02-24 09:52:11', 1, '2024-02-24 09:52:11'),
(27, '1708953342.jpg', NULL, '1708953342.jpg', 'http://localhost/admin/public/filemanager/1708953342.jpg', 87553, 'jpg', 'image/jpeg', 'filemanager/1708953342.jpg', NULL, '2024-02-26 08:15:42', 1, '2024-02-26 08:15:42'),
(28, '1708953401.jpg', NULL, '1708953401.jpg', 'http://localhost/admin/public/filemanager/1708953401.jpg', 77454, 'jpg', 'image/jpeg', 'filemanager/1708953401.jpg', NULL, '2024-02-26 08:16:41', 1, '2024-02-26 08:16:41'),
(29, '1708953417.jpg', NULL, '1708953417.jpg', 'http://localhost/admin/public/filemanager/1708953417.jpg', 109986, 'jpg', 'image/jpeg', 'filemanager/1708953417.jpg', NULL, '2024-02-26 08:16:57', 1, '2024-02-26 08:16:57'),
(30, '1708953434.jpg', NULL, '1708953434.jpg', 'http://localhost/admin/public/filemanager/1708953434.jpg', 113123, 'jpg', 'image/jpeg', 'filemanager/1708953434.jpg', NULL, '2024-02-26 08:17:14', 1, '2024-02-26 08:17:14'),
(31, '1708953460.jpg', NULL, '1708953460.jpg', 'http://localhost/admin/public/filemanager/1708953460.jpg', 81486, 'jpg', 'image/jpeg', 'filemanager/1708953460.jpg', NULL, '2024-02-26 08:17:40', 1, '2024-02-26 08:17:40'),
(46, '65e450ed1e78d.jpeg', NULL, '65e450ed1e78d.jpeg', 'http://localhost/admin/public/filemanager/65e450ed1e78d.jpeg', 183359, 'jpeg', 'image/jpeg', 'filemanager/65e450ed1e78d.jpeg', NULL, '2024-03-03 05:29:01', 1, '2024-03-03 05:29:01'),
(48, '65e466a71bba6.jpg', NULL, '65e466a71bba6.jpg', 'http://localhost/admin/public/filemanager/65e466a71bba6.jpg', 19105, 'jpg', 'image/jpeg', 'filemanager/65e466a71bba6.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(49, '65e466a720b04.jpg', NULL, '65e466a720b04.jpg', 'http://localhost/admin/public/filemanager/65e466a720b04.jpg', 31058, 'jpg', 'image/jpeg', 'filemanager/65e466a720b04.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(50, '65e466a724887.jpg', NULL, '65e466a724887.jpg', 'http://localhost/admin/public/filemanager/65e466a724887.jpg', 28941, 'jpg', 'image/jpeg', 'filemanager/65e466a724887.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(51, '65e466a72879c.jpg', NULL, '65e466a72879c.jpg', 'http://localhost/admin/public/filemanager/65e466a72879c.jpg', 23787, 'jpg', 'image/jpeg', 'filemanager/65e466a72879c.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(52, '65e466a72ef00.jpg', NULL, '65e466a72ef00.jpg', 'http://localhost/admin/public/filemanager/65e466a72ef00.jpg', 26322, 'jpg', 'image/jpeg', 'filemanager/65e466a72ef00.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(53, '65e466a7354ba.jpg', NULL, '65e466a7354ba.jpg', 'http://localhost/admin/public/filemanager/65e466a7354ba.jpg', 17694, 'jpg', 'image/jpeg', 'filemanager/65e466a7354ba.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(54, '65e466a739365.jpg', NULL, '65e466a739365.jpg', 'http://localhost/admin/public/filemanager/65e466a739365.jpg', 38497, 'jpg', 'image/jpeg', 'filemanager/65e466a739365.jpg', NULL, '2024-03-03 07:01:43', 1, '2024-03-03 07:01:43'),
(55, '65e467187c030.jpg', NULL, '65e467187c030.jpg', 'http://localhost/admin/public/filemanager/65e467187c030.jpg', 26606, 'jpg', 'image/jpeg', 'filemanager/65e467187c030.jpg', NULL, '2024-03-03 07:03:36', 1, '2024-03-03 07:03:36'),
(56, '65e4674500998.jpg', NULL, '65e4674500998.jpg', 'http://localhost/admin/public/filemanager/65e4674500998.jpg', 44929, 'jpg', 'image/jpeg', 'filemanager/65e4674500998.jpg', NULL, '2024-03-03 07:04:21', 1, '2024-03-03 07:04:21'),
(57, '65e48a4f589e6.jpg', NULL, '65e48a4f589e6.jpg', 'http://localhost/admin/public/filemanager/65e48a4f589e6.jpg', 306598, 'jpg', 'image/jpeg', 'filemanager/65e48a4f589e6.jpg', NULL, '2024-03-03 09:33:51', 1, '2024-03-03 09:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `details`, `is_enable`, `created_at`, `updated_at`) VALUES
(1, 'Main Menu', NULL, 1, '2024-03-01 09:42:33', '2024-03-02 09:54:14'),
(3, 'Footer Menu 1', NULL, 1, '2024-03-02 09:54:05', '2024-03-02 09:54:05'),
(4, 'Mobile Menu', NULL, 1, '2024-03-02 09:55:11', '2024-03-02 09:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `menu_id` bigint(20) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `title`, `subtitle`, `target`, `link`, `level`, `parent_id`, `menu_id`, `sort`, `is_enable`, `created_at`, `updated_at`) VALUES
(6, 'Home', '#', NULL, '#', 1, NULL, 1, 1, 1, '2024-03-01 14:39:09', '2024-03-03 09:39:31'),
(29, 'Shop', NULL, NULL, '#', 1, NULL, 1, 2, 1, '2024-03-02 09:47:48', '2024-03-03 06:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `title` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `price` double DEFAULT NULL,
  `selling_price` double DEFAULT NULL,
  `sku` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `subchildcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `hover_image` text DEFAULT NULL,
  `is_featured` int(11) DEFAULT 0,
  `is_popular` int(11) DEFAULT 0,
  `details` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `price`, `selling_price`, `sku`, `category_id`, `subcategory_id`, `subchildcategory_id`, `brand_id`, `tags`, `image`, `images`, `type`, `hover_image`, `is_featured`, `is_popular`, `details`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `is_enable`, `created_at`, `updated_at`) VALUES
(3, 'Lexie Shirt', 'lexie-shirt', 200, 300, NULL, 34, NULL, NULL, 1, NULL, '27', 'assets/images/product-images/product-image11.jpg,assets/images/product-images/product-image11-1.jpg,28,29,30', 'single', '29', 0, 0, 'Diva is a minimalist modern shopify theme that will give you and your customers a smooth shopping experience which can be used for various kinds of stores such as fashion,...', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><ul><li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li><li>Sed ut perspiciatis unde omnis iste natus error sit</li><li>Neque porro quisquam est qui dolorem ipsum quia dolor</li><li>Lorem Ipsum is not simply random text.</li><li>Morbi malesuada lacus sed metus luctus pulvinar quis at odio.</li></ul>', 'Lexie Shirt', 'Lexie Shirt', NULL, 1, '2024-02-15 11:10:35', '2024-03-03 07:17:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_collections`
--

CREATE TABLE `product_collections` (
  `id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Admin1', 1, '2024-01-27 09:11:35', '2024-01-27 04:45:22', 1, 1),
(2, 'Super Admin', 1, '2024-01-27 09:11:35', '0000-00-00 00:00:00', 1, NULL),
(3, 'Title 1', 1, '2024-01-27 04:27:59', '2024-01-27 04:27:59', 1, NULL),
(4, 'customer1', 0, '2024-01-27 04:28:38', '2024-01-27 04:45:29', 1, 1),
(5, 'New Role', 1, '2024-02-14 04:43:19', '2024-02-14 04:45:07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `field` text NOT NULL,
  `value` text DEFAULT NULL,
  `type` text NOT NULL DEFAULT 'text',
  `sort` int(11) NOT NULL DEFAULT 0,
  `grouping` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `field`, `value`, `type`, `sort`, `grouping`) VALUES
(1, 'site_title', 'Erha Wears', 'text', 1, 'site_settings'),
(2, 'blog_meta_tags', 'Meta Tags 1', 'text', 2, 'seo_settings'),
(3, 'blog_meta_description', 'Meta Description', 'text', 3, 'seo_settings'),
(4, 'blog_keywords', 'keyword1,keyword2,keyword3,keyword4', 'text', 4, 'seo_settings'),
(5, 'footer_credits', 'Copyright: 2024 <a href=\"#.\"><span class=\"color_red\">website name Here</span></a>. All Rights Reserved', 'text', 5, 'site_settings'),
(6, 'phone_number', '03333906535', 'text', 5, 'site_settings'),
(7, 'email_address', 'info@iGetFinalchoice.com', 'text', 4, 'site_settings'),
(8, 'address', 'Address Will come here.', 'text', 4, 'site_settings'),
(9, 'domain', 'www.yourdomain.com', 'text', 4, 'admin_settings'),
(15, 'logo', 'settings_logo_65aadb59abf33.png', 'image', 1, 'site_settings'),
(16, 'fav_icon', 'settings_fav_icon_65aadb3928a64.png', 'image', 1, 'site_settings'),
(18, 'about_us', '<p>11111111</p>', 'textarea', 4, 'site_settings'),
(19, 'privacy_policy', '<p>sdasd</p>', 'textarea', 4, 'site_settings'),
(20, 'terms_&_conditions', '<p>sddssdsd</p>', 'textarea', 4, 'site_settings'),
(22, 'facebook_link', '..', 'text', 1, 'social_media_settings'),
(23, 'youtube_link', '..', 'text', 1, 'social_media_settings'),
(24, 'twitter_link', '..', 'text', 1, 'social_media_settings'),
(25, 'instagram_link', '..', 'text', 1, 'social_media_settings'),
(27, 'admin_logo', 'www.yourdomain.com', 'image', 4, 'admin_settings'),
(28, 'admin_favicon', 'www.yourdomain.com', 'image', 4, 'admin_settings');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `alt` text DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `is_enable` int(11) NOT NULL DEFAULT 1,
  `button` text DEFAULT NULL,
  `alignment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `slug`, `details`, `image_id`, `alt`, `sort`, `link`, `is_enable`, `button`, `alignment`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Diva', NULL, 'We have created a Store  that looks Awesome and performs Brilliantly', 24, NULL, 1, '#', 1, 'Purchase Now', 'center', '2024-02-29 13:41:17', '2024-03-03 06:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `permissions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `created_by`, `permissions`) VALUES
(1, 'Owais Azam', NULL, 'admin@gmail.com', NULL, '$2y$10$xhPEybNF4n6iu.wTTK/V3OilB31PZwiaM8BjUdWWsHKoo4nrtqtGq', NULL, NULL, NULL, 1, 1, 'dashboard_management,store_category_management,store_management,coupons_management,blogs_category_management,blogs_management,site_management,user_rights_management'),
(2, 'Owais Azam 1', NULL, 'iamowaisazam221@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(3, 'User 1', NULL, 'user1@gmail.com', NULL, '$2y$10$ZlbiEzXleDKGKZkcztA4eeQ5grxA2d0Esd3692x0ZNvP7y5ynzQ.2', NULL, '2024-01-03 10:48:55', '2024-01-03 10:48:55', 1, 1, NULL),
(4, 'Title 1', NULL, 'admin1@gmail.com', NULL, '$2y$10$uQxrxCxNOeWE729Tm85iUO705DAHwdK1zLRTPvVwjhpvvIyJ2NcUa', NULL, '2024-01-03 10:51:41', '2024-01-03 10:51:41', 1, 1, NULL),
(5, 'admin1', NULL, 'superadmin@example.com', NULL, '$2y$10$EfBxTv7n0BLsT4MqTzsJteDRtxz1wjFr92H0HpDEJRS5SJcMQOPu6', NULL, '2024-01-03 10:52:44', '2024-01-03 10:52:44', 1, 1, 'store_management,coupons_management,site_management'),
(7, 'Owais Azam 1', NULL, 'iamowaisazam1@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(8, 'Owais Azam 2', NULL, 'iamowaisazam2@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(9, 'Owais Azam 3', NULL, 'iamowaisazam3@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(10, 'Owais Azam 4', NULL, 'iamowaisazam4@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(11, 'Owais Azam 5', NULL, 'iamowaisazam5@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(12, 'Owais Azam 6', NULL, 'iamowaisazam6@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(13, 'Owais Azam 7', NULL, 'iamowaisazam7@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(14, 'Owais Azam 8', NULL, 'iamowaisazam8@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(15, 'Owais Azam 9', NULL, 'iamowaisazam9@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management'),
(16, 'Owais Azam 10', NULL, 'iamowaisazam10@gmail.com', NULL, '$2y$10$Rx7ppVgpkUz.BEsxqv4P2.o6F4BGJxuQ.Yws1YxdnY.RUzmMvjZIS', NULL, '2024-01-03 12:25:47', '2024-01-03 12:25:47', 1, 2, 'store_management,coupons_management,blogs_management,site_management,user_rights_management');

-- --------------------------------------------------------

--
-- Table structure for table `values`
--

CREATE TABLE `values` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `values`
--

INSERT INTO `values` (`id`, `title`, `attribute_id`, `created_at`, `updated_at`) VALUES
(1, 'xl', 1, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(2, 'l', 1, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(3, 'm', 1, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(4, 's', 1, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(5, 'red', 2, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(6, 'blue', 2, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(7, 'green', 2, '2024-02-16 07:55:17', '2024-02-16 07:55:17'),
(8, 'pink', 2, '2024-02-16 07:55:17', '2024-02-16 07:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `product_id` bigint(11) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `product_id`, `sku`, `quantity`, `price`, `image`, `created_at`, `updated_at`) VALUES
(174, 3, 'xl-red', 10, 400, '57', '2024-02-26 15:25:39', '2024-03-03 09:34:06'),
(175, 3, 'xl-blue', 20, 300, '57', '2024-02-26 15:25:39', '2024-03-03 09:34:06'),
(176, 3, 'l-red', 30, 200, '57', '2024-02-26 15:25:39', '2024-03-03 09:34:06'),
(177, 3, 'l-blue', 40, 50, '57', '2024-02-26 15:25:39', '2024-03-03 09:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `variation_attributes`
--

CREATE TABLE `variation_attributes` (
  `id` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `attribute_id` int(50) DEFAULT NULL,
  `value_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation_attributes`
--

INSERT INTO `variation_attributes` (`id`, `variation_id`, `attribute_id`, `value_id`, `value`, `created_at`, `updated_at`) VALUES
(241, 174, 1, 1, 'xl', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(242, 174, 2, 5, 'red', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(243, 175, 1, 1, 'xl', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(244, 175, 2, 6, 'blue', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(245, 176, 1, 2, 'l', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(246, 176, 2, 5, 'red', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(247, 177, 1, 2, 'l', '2024-02-26 15:25:39', '2024-02-26 15:25:39'),
(248, 177, 2, 6, 'blue', '2024-02-26 15:25:39', '2024-02-26 15:25:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_relation_inside` (`parent_id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `filemanager`
--
ALTER TABLE `filemanager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_relation_parent_id` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `values`
--
ALTER TABLE `values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `variation_attributes`
--
ALTER TABLE `variation_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pva_product_variation_id_to_variation_id` (`variation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filemanager`
--
ALTER TABLE `filemanager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_collections`
--
ALTER TABLE `product_collections`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `values`
--
ALTER TABLE `values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `variation_attributes`
--
ALTER TABLE `variation_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `category_relation_inside` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_relation_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variations`
--
ALTER TABLE `variations`
  ADD CONSTRAINT `product_to_product_variation_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variation_attributes`
--
ALTER TABLE `variation_attributes`
  ADD CONSTRAINT `pva_product_variation_id_to_variation_id` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
