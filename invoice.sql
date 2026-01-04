-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 06:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `company_name`, `email`, `phone`, `address`, `city`, `zip`, `country`, `tax_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'Doe Enterprises', 'john@doe.com', '9876543210', '456 Client St, City', NULL, NULL, 'USA', NULL, 1, '2026-01-04 13:12:26', '2026-01-04 13:12:26');

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
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount_paid` decimal(15,2) NOT NULL DEFAULT 0.00,
  `balance_due` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Unpaid','Partially Paid','Paid','Cancelled') NOT NULL DEFAULT 'Unpaid',
  `notes` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `invoice_date`, `due_date`, `customer_id`, `subtotal`, `total_tax`, `total_discount`, `shipping`, `grand_total`, `amount_paid`, `balance_due`, `status`, `notes`, `terms`, `signature`, `created_at`, `updated_at`) VALUES
(1, 'INV-1001', '2002-10-25', '2025-03-29', 1, '467500.00', '313225.00', '92.00', '48.00', '780681.00', '780681.00', '0.00', 'Paid', 'Ut irure eveniet ip', 'Quibusdam proident', NULL, '2026-01-04 13:21:38', '2026-01-04 13:23:10'),
(2, 'INV--1000', '1970-08-25', '1975-02-08', 1, '35860.00', '3227.40', '12.00', '8.00', '39083.40', '0.00', '39083.40', 'Unpaid', 'Ea Nam quidem aut in', 'Cum sit magna sed qu', NULL, '2026-01-04 13:30:09', '2026-01-04 13:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `unit_price`, `quantity`, `tax_percentage`, `discount`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Quo sit quis non ex', '935.00', 500, '67.00', '92.00', '780633.00', '2026-01-04 13:21:38', '2026-01-04 13:21:38'),
(3, 2, 'Aliquam perferendis', '652.00', 55, '9.00', '12.00', '39075.40', '2026-01-04 13:31:45', '2026-01-04 13:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_04_175413_create_customers_table', 1),
(5, '2026_01_04_175414_create_products_table', 1),
(6, '2026_01_04_175415_create_settings_table', 1),
(7, '2026_01_04_175416_create_quotes_table', 1),
(8, '2026_01_04_175418_create_quote_items_table', 1),
(9, '2026_01_04_175419_create_invoices_table', 1),
(10, '2026_01_04_175420_create_invoice_items_table', 1),
(11, '2026_01_04_175422_create_payments_table', 1);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `payment_date`, `amount`, `payment_method`, `transaction_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-04', '780681.00', 'Bank Transfer', NULL, 'sfsd', '2026-01-04 13:23:10', '2026-01-04 13:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) DEFAULT NULL,
  `type` enum('product','service') NOT NULL DEFAULT 'product',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `description`, `price`, `tax_percentage`, `stock`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Web Design Service', 'SRV-001', 'Professional custom web design', '500.00', '10.00', NULL, 'service', '2026-01-04 13:12:26', '2026-01-04 13:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_number` varchar(255) NOT NULL,
  `quote_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('Draft','Sent','Accepted','Rejected','Invoiced') NOT NULL DEFAULT 'Draft',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `quote_number`, `quote_date`, `due_date`, `reference`, `customer_id`, `subtotal`, `total_tax`, `total_discount`, `shipping`, `grand_total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'QT-1001', '2005-04-29', '2018-05-28', 'Debitis qui et saepe', 1, '43740.00', '8310.60', '42.00', '17.00', '52025.60', 'Invoiced', 'Omnis ad rerum provi', '2026-01-04 13:29:59', '2026-01-04 13:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `quote_items`
--

CREATE TABLE `quote_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quote_items`
--

INSERT INTO `quote_items` (`id`, `quote_id`, `description`, `unit_price`, `quantity`, `tax_percentage`, `discount`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Harum autem commodi', '90.00', 486, '19.00', '42.00', '52008.60', '2026-01-04 13:29:59', '2026-01-04 13:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jX3pj8y9NFJVTKwkDN8huFL4LrXfkWK8ulT7xAfO', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYnVsVkZGWld6N2RqUnUwOXI5SnZMVDBoQVlqakoyejhPano3Z3oxayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lcnMvY3JlYXRlIjtzOjU6InJvdXRlIjtzOjE2OiJjdXN0b21lcnMuY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3Njc1NTA1Mzc7fX0=', 1767552463);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_tax_id` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) NOT NULL DEFAULT '$',
  `invoice_prefix` varchar(255) NOT NULL DEFAULT 'INV-',
  `quote_prefix` varchar(255) NOT NULL DEFAULT 'QT-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_address`, `company_phone`, `company_email`, `company_tax_id`, `company_logo`, `currency_symbol`, `invoice_prefix`, `quote_prefix`, `created_at`, `updated_at`) VALUES
(1, 'Global Solutions Inc.', '123 Business Road, Tech City, 54321', '+1 234 567 890', 'contact@globalsolutions.com', 'TAX12345678', NULL, '$', 'INV-', 'QT-', '2026-01-04 13:12:26', '2026-01-04 13:12:26');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@invoice.com', NULL, '$2y$12$aLFj8n.qM7TT7cRuqS4ei.P84f6LXlFPCV0xMAEkLtTTTCS55/ajK', NULL, '2026-01-04 13:12:26', '2026-01-04 13:12:26');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotes_quote_number_unique` (`quote_number`),
  ADD KEY `quotes_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_items_quote_id_foreign` (`quote_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quote_items`
--
ALTER TABLE `quote_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD CONSTRAINT `quote_items_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
