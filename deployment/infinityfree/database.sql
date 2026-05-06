-- Blog Management System (MySQL)
-- Import this in InfinityFree phpMyAdmin.

SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- Admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blogs
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `category` varchar(80) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_category_index` (`category`),
  KEY `blogs_published_at_index` (`published_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed admin (password: password)
INSERT INTO `admins` (`name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES (
  'Admin',
  'admin@blog.test',
  '$2y$12$ixP2f3oVkWnD7o19yIYyzOyc9lGJ8XKk.CKZKqgBoqtx1JmWv6gQG',
  NULL,
  NOW(),
  NOW()
)
ON DUPLICATE KEY UPDATE `updated_at` = VALUES(`updated_at`);

-- Seed blogs
INSERT INTO `blogs` (`title`, `slug`, `excerpt`, `content`, `category`, `image_path`, `published_at`, `created_at`, `updated_at`) VALUES
('UPSC Result 2026: Highlights','upsc-result-2026-highlights','This is a sample blog post to demonstrate listing, detail view, and filtering. Replace this with real content from the admin panel.','<p>This is a sample blog post to demonstrate listing, detail view, and filtering.</p><p>Replace this with real content from the admin panel.</p>','Result',NULL,DATE_SUB(NOW(), INTERVAL 2 DAY),NOW(),NOW()),
('Railway Admit Card Released','railway-admit-card-released','Sample admit card update content. Use the admin panel to manage posts.','<p>Sample admit card update content. Use the admin panel to manage posts.</p>','Admit Card',NULL,DATE_SUB(NOW(), INTERVAL 10 DAY),NOW(),NOW()),
('Exam Schedule Update','exam-schedule-update','Sample notice content with more details.','<p>Sample notice content with more details.</p>','Notice',NULL,DATE_SUB(NOW(), INTERVAL 20 DAY),NOW(),NOW())
ON DUPLICATE KEY UPDATE `updated_at` = VALUES(`updated_at`);

