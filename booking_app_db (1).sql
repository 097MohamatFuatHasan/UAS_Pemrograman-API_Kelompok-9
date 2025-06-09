-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 12:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_name` varchar(255) DEFAULT NULL,
  `nama_pemesan` varchar(255) NOT NULL,
  `check_in` date NOT NULL,
  `check_in_time` time NOT NULL DEFAULT '14:00:00',
  `check_out` date NOT NULL,
  `check_out_time` time NOT NULL DEFAULT '12:00:00',
  `guests` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `facilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`facilities`)),
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `address`, `facilities`, `phone`, `email`, `description`, `created_at`, `updated_at`, `image_path`) VALUES
(1, 'Hotel Bintang Lima', 'Jl. Sudirman No. 12, Jakarta Pusat', '[{\"name\":\"Gym\",\"image\":\"images\\/facilities\\/n4b2Vl50K4zNwHqnsPKHLSrBThunQCoWDpwShbhk.jpg\"},{\"name\":\"Wifi\",\"image\":\"images\\/facilities\\/I0jJOkifuAcSIV6HIrulnJLkHWL2dR0GT8gwvcoB.jpg\"},{\"name\":\"Restaurant\",\"image\":\"images\\/facilities\\/ysmMB61x4W3y6v0Eg8OSvutgVt4tMimwRUSQOQnz.jpg\"},{\"name\":\"Parking Lot\",\"image\":\"images\\/facilities\\/3dOXxcG2oGE2U9BO18A1DFwYCfohtm06FjYmg9Yx.jpg\"}]', '021-12345678', 'info@bintanglima.com', 'Hotel mewah di pusat kota Jakarta dengan pelayanan kelas dunia dan fasilitas lengkap.', '2025-06-07 02:04:38', '2025-06-07 02:04:38', 'images/hotels/lauVCOKljJjITeJy9qdVjAXYPF5v8w2S5gExC963.jpg'),
(2, 'Hotel Pelangi Indah', 'Jl. Imam Bonjol No. 8, Malang', '[{\"name\":\"Gym\",\"image\":\"images\\/facilities\\/5w4O7yOkTS1UyvbXw9bvnqCKKjiwXiwneIcF9kOU.jpg\"},{\"name\":\"Wifi\",\"image\":\"images\\/facilities\\/20oOpHUTEjhGAhgrs50kJ6q2UErdz4RB4Sem6oon.jpg\"},{\"name\":\"Restaurant\",\"image\":\"images\\/facilities\\/NUnYd0icuYMEc5DF7TbCwAxRWNlfDb9Tj7hA2hjL.jpg\"},{\"name\":\"Parking Lot\",\"image\":\"images\\/facilities\\/czFYcXMrv5SngG5keFkurO4qtIzfTtiwUBInEG5w.jpg\"},{\"name\":\"Spa\",\"image\":\"images\\/facilities\\/FrfKzBXG7fQY2HHGAWDAvKVfI7crx6xZTuBOy9QH.jpg\"}]', '0341-987654', 'kontak@pelangiindah.co.id', 'Hotel nyaman di kawasan pegunungan dengan suasana sejuk dan ramah keluarga.', '2025-06-07 02:10:19', '2025-06-07 02:10:19', 'images/hotels/25lXFZbFVjHP6qb2LDRts7iFU6kNGeGwVICGNALK.jpg'),
(3, 'Hotel Sakura', 'Jl. Sakura No. 77, Bandung', '[{\"name\":\"Spa\",\"image\":\"images\\/facilities\\/dQ9yteUxH5ITNcZ1vtDawWzYQzNo1GMMcRNlln2Z.jpg\"},{\"name\":\"Wifi\",\"image\":\"images\\/facilities\\/S5oidIpT1oDCq6qdOjWsDrEkdWdztWhuQ968djIq.jpg\"},{\"name\":\"Restaurant\",\"image\":\"images\\/facilities\\/ePnDqIzGNBJQjiQCPMEU2qkvKG5TeHREXvWvDjIm.jpg\"},{\"name\":\"Parking Lot\",\"image\":\"images\\/facilities\\/dPqiYU4KWSEVhLjcWCnuHeO3plt2f1dATjLl9F5L.jpg\"}]', '022-66554433', 'info@sakurahotel.jp', 'Hotel bernuansa Jepang yang menawarkan pengalaman unik dan ketenangan.', '2025-06-07 02:13:20', '2025-06-07 02:13:20', 'images/hotels/OCDxtTZZ9H57OxSkrJyg0pVqJvVQNPVjaNYpTYyL.jpg'),
(4, 'Hotel Pantai Bahagia', 'Jl. Pantai Selatan No. 10, Bali', '[{\"name\":\"Gym\",\"image\":\"images\\/facilities\\/wB065VCsFS5m5JkYwzO8APSODiaanC0ZwxkkfudL.jpg\"},{\"name\":\"Wifi\",\"image\":\"images\\/facilities\\/wmI0y9p1uM2aQDtj1Lx5pQ5gByN0YTcN1RudlnGp.jpg\"},{\"name\":\"Restaurant\",\"image\":\"images\\/facilities\\/K3Ms35zks5F9TzjUlgMjN0Vwx8nqmwkUe6Wj96cB.jpg\"},{\"name\":\"Parking Lot\",\"image\":\"images\\/facilities\\/I8mDm7HrszfBqR9wM8auaGsdxlUsTI9XjIfZ4chx.jpg\"},{\"name\":\"Spa\",\"image\":\"images\\/facilities\\/9oUAGIn87ECCAgPIbbJxE4EZTwpGUohvdrTfsyqQ.jpg\"}]', '0361-334455', 'booking@pantaibahagia.com', 'Hotel pinggir pantai dengan pemandangan laut langsung dari balkon kamar.', '2025-06-07 02:18:17', '2025-06-07 02:18:17', 'images/hotels/JkhCxu6713sdPoFQg9abuYvvljNfDWT0enryM3yZ.jpg');

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
(100, '2014_10_12_000000_create_users_table', 1),
(101, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(102, '2019_08_19_000000_create_failed_jobs_table', 1),
(103, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(104, '2025_05_08_125946_create_hotels_table', 1),
(105, '2025_05_08_125947_create_rooms_table', 1),
(106, '2025_05_08_151607_create_bookings_table', 1),
(107, '2025_05_15_064209_add_time_to_bookings', 1),
(108, '2025_05_15_064931_create_ratings_table', 1),
(109, '2025_05_20_091202_add_hotel_name_to_bookings_table', 1),
(110, '2025_05_23_152321_add_image_to_hotels_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rateable_type` varchar(255) NOT NULL,
  `rateable_id` bigint(20) UNSIGNED NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `type`, `number`, `price`, `capacity`, `description`, `image`, `available`, `created_at`, `updated_at`) VALUES
(4, 1, 'Standard Room', '1', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-07 02:24:44', '2025-06-07 02:24:44'),
(5, 1, 'Standard Room', '2', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-07 02:24:44', '2025-06-07 02:24:44'),
(6, 1, 'Standard Room', '3', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-07 02:24:44', '2025-06-07 02:24:44'),
(7, 1, 'Standard Room', '4', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-07 02:24:44', '2025-06-07 02:24:44'),
(8, 1, 'Standard Room', '5', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-07 02:24:44', '2025-06-07 02:24:44'),
(9, 1, 'Presidential Suite', '101', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-07 02:25:53', '2025-06-07 02:25:53'),
(11, 1, 'Presidential Suite', '102', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-07 02:25:53', '2025-06-07 02:25:53'),
(12, 1, 'Family Room', '201', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-07 02:26:44', '2025-06-07 02:26:44'),
(13, 1, 'Family Room', '202', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-07 02:26:44', '2025-06-07 02:26:44'),
(14, 1, 'Family Room', '203', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-07 02:26:44', '2025-06-07 02:26:44'),
(15, 1, 'Family Room', '204', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-07 02:26:44', '2025-06-07 02:26:44'),
(16, 1, 'Family Room', '205', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-07 02:26:44', '2025-06-07 02:26:44'),
(20, 2, 'Standard Room', '1', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(21, 2, 'Standard Room', '2', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(22, 2, 'Standard Room', '3', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(23, 2, 'Standard Room', '4', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(24, 2, 'Standard Room', '5', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(25, 2, 'Presidential Suite', '101', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(26, 2, 'Presidential Suite', '102', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(27, 2, 'Family Room', '201', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(28, 2, 'Family Room', '202', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(29, 2, 'Family Room', '203', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(30, 2, 'Family Room', '204', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(31, 2, 'Family Room', '205', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(40, 3, 'Standard Room', '1', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(41, 3, 'Standard Room', '2', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(42, 3, 'Standard Room', '3', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(43, 3, 'Standard Room', '4', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(44, 3, 'Standard Room', '5', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(45, 3, 'Presidential Suite', '101', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(46, 3, 'Presidential Suite', '102', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(47, 3, 'Family Room', '201', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(48, 3, 'Family Room', '202', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(49, 3, 'Family Room', '203', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(50, 3, 'Family Room', '204', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(51, 3, 'Family Room', '205', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(55, 4, 'Standard Room', '1', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(56, 4, 'Standard Room', '2', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(57, 4, 'Standard Room', '3', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(58, 4, 'Standard Room', '4', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(59, 4, 'Standard Room', '5', 340000.00, 2, 'Kamar nyaman dengan fasilitas standar dan sarapan gratis', 'images/rooms/wswbiLVYmnRGNZg7RV6RvLJHQMHjRIWYr4SRvsIo.jpg', 1, '2025-06-06 19:24:44', '2025-06-06 19:24:44'),
(60, 4, 'Presidential Suite', '101', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(61, 4, 'Presidential Suite', '102', 5000000.00, 4, 'Kamar eksklusif dengan ruang tamu pribadi dan jacuzzi', 'images/rooms/ZDMFsvdCrnH8W6ZS4cylwhtVk3xeqwZeVhOBuC1d.jpg', 1, '2025-06-06 19:25:53', '2025-06-06 19:25:53'),
(62, 4, 'Family Room', '201', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(63, 4, 'Family Room', '202', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(64, 4, 'Family Room', '203', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(65, 4, 'Family Room', '204', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44'),
(66, 4, 'Family Room', '205', 1200000.00, 8, 'Cocok untuk keluarga, dengan tempat tidur tambahan', 'images/rooms/pSZ6DeUIDyyp8Qzm0sz8HXQfiXeKLESLPoexyv7V.jpg', 1, '2025-06-06 19:26:44', '2025-06-06 19:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$7xIqBX3/9Ji8dKCOMxqsDOdChDKJ4aix4nkfOaP6TgYBAP7hOik1W', 'admin', NULL, '2025-06-07 01:02:22', '2025-06-07 01:02:22'),
(2, 'Budi Setiawan', 'budis@gmail.com', NULL, '$2y$10$Q4F7mkocvxk6N/.3g0chxuqOCWrzrEC2QEhQV4N4fEX21b9ca5EO.', 'user', NULL, '2025-06-07 01:03:02', '2025-06-07 01:03:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_rateable_type_rateable_id_index` (`rateable_type`,`rateable_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hotel_id_foreign` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
