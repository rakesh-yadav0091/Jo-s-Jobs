-- Jo's Jobs Database Schema - Complete
CREATE DATABASE IF NOT EXISTS `jobs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `jobs`;

-- Drop existing tables in correct order
DROP TABLE IF EXISTS `email_log`;
DROP TABLE IF EXISTS `application_tracking`;
DROP TABLE IF EXISTS `saved_jobs`;
DROP TABLE IF EXISTS `job_alerts`;
DROP TABLE IF EXISTS `applicants`;
DROP TABLE IF EXISTS `enquiries`;
DROP TABLE IF EXISTS `job`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `users`;

-- ============================================
-- USERS TABLE
-- ============================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('staff','client') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`, `active`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jo Admin', 'admin@josjobs.co.uk', 'staff', 1),
('client', '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 'Sample Client', 'client@example.com', 'client', 1);

-- ============================================
-- CATEGORY TABLE
-- ============================================
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`name`) VALUES 
('Information Technology'), 
('Human Resources'), 
('Sales'), 
('Marketing'),
('Finance'),
('Healthcare');

-- ============================================
-- JOB TABLE
-- ============================================
CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closingDate` date NOT NULL,
  `categoryId` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateReceived` date NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `clientId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  KEY `clientId` (`clientId`),
  CONSTRAINT `job_category_fk` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `job_client_fk` FOREIGN KEY (`clientId`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Original Jobs
INSERT INTO `job` (`title`, `description`, `salary`, `closingDate`, `categoryId`, `location`, `dateReceived`, `archived`, `clientId`) VALUES
('First level tech support', 'Provide high quality equipment installation and technical support to clients.', '15000 - 18000', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('IT Infrastructure Manager', 'Design and deliver robust IT solutions for enterprise clients.', '45000 - 58000', DATE_ADD(CURDATE(), INTERVAL 7 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('Sales Assistant', 'Join an award winning sales team and help grow our business.', '12000 - 15000', DATE_ADD(CURDATE(), INTERVAL 21 DAY), 3, 'Northampton', CURDATE(), 0, NULL),
('HR Manager', 'Deliver comprehensive HR service to our growing organisation.', '35000 - 40000', DATE_ADD(CURDATE(), INTERVAL 10 DAY), 2, 'Northampton', CURDATE(), 0, NULL);

-- IT JOBS
INSERT INTO `job` (`title`, `description`, `salary`, `closingDate`, `categoryId`, `location`, `dateReceived`, `archived`, `clientId`) VALUES
('Junior Web Developer', 'Exciting opportunity for a junior web developer to join a growing IT team. You will be working on modern web applications using PHP, JavaScript, and MySQL.', '22000 - 28000', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('Network Administrator', 'Manage and maintain the network infrastructure for a leading Northampton company. Required skills include Cisco, firewall management, and network security.', '30000 - 38000', DATE_ADD(CURDATE(), INTERVAL 21 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('Senior Software Engineer', 'Lead the development of enterprise software solutions. Must have experience with PHP, Laravel, and cloud technologies.', '45000 - 60000', DATE_ADD(CURDATE(), INTERVAL 7 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('IT Support Analyst', 'Provide first and second line IT support to users. Strong communication skills and problem-solving abilities required.', '18000 - 25000', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1, 'Northampton', CURDATE(), 0, NULL),
('Full Stack Developer', 'Full stack developer needed for exciting web projects. Must have experience with React, Node.js, and MySQL.', '35000 - 45000', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 1, 'Northampton', CURDATE(), 0, NULL);

-- ============================================
-- APPLICANTS TABLE
-- ============================================
CREATE TABLE `applicants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `jobId` int(11) NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jobId` (`jobId`),
  CONSTRAINT `applicants_job_fk` FOREIGN KEY (`jobId`) REFERENCES `job` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- ENQUIRIES TABLE
-- ============================================
CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enquiry` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Open','Complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `createdAt` datetime NOT NULL,
  `completedBy` int(11) DEFAULT NULL,
  `completedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `completedBy` (`completedBy`),
  CONSTRAINT `enquiries_user_fk` FOREIGN KEY (`completedBy`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- JOB ALERTS TABLE
-- ============================================
CREATE TABLE `job_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequency` enum('daily','weekly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'daily',
  `createdAt` datetime NOT NULL,
  `lastSent` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`),
  CONSTRAINT `job_alerts_category_fk` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SAVED JOBS TABLE
-- ============================================
CREATE TABLE `saved_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobId` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `savedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_save` (`jobId`, `email`),
  CONSTRAINT `saved_jobs_job_fk` FOREIGN KEY (`jobId`) REFERENCES `job` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- APPLICATION TRACKING TABLE
-- ============================================
CREATE TABLE `application_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicantId` int(11) NOT NULL,
  `status` enum('received','reviewing','shortlisted','interviewed','offered','accepted','rejected','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `updatedBy` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_applicant` (`applicantId`),
  KEY `updatedBy` (`updatedBy`),
  CONSTRAINT `tracking_applicant_fk` FOREIGN KEY (`applicantId`) REFERENCES `applicants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tracking_user_fk` FOREIGN KEY (`updatedBy`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- EMAIL LOG TABLE
-- ============================================
CREATE TABLE `email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('alert','closing','application','welcome') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sentAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;