-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hisabmittra_crm
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Auto-Saved Action [2026-10-07 08:13:48]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `source_id`, `status`, `priority`, `assigned_to`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-1798', 'Auto SQL Test User', 'test@auto-sql.com', '+91 99999 88888', 'Test Company Pvt Ltd', NULL, 'New', 'High', NULL, 50000, NULL, 'Testing auto SQL persistence.', '2026-10-07 08:13:48', '2026-10-07 08:13:48');

-- Auto-Saved Action [2026-10-07 08:48:29]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `city`, `source_id`, `status`, `priority`, `assigned_to`, `agent`, `basic`, `pro`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-2686', 'him', 'a@w.com', '+91 9876543210', 'apex', 'jodhpur', 2, 'In Progress', 'High', 1, 'mohan', 5000, 10000, 8000, '2026-02-09', 'hello', '2026-10-07 08:48:29', '2026-10-07 08:48:29');

-- Auto-Saved Action [2026-10-07 08:51:29]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `city`, `source_id`, `status`, `priority`, `assigned_to`, `agent`, `basic`, `pro`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-9347', 'Kishore Kumar', NULL, '+91 98765 43210', 'KK Steel Mills', 'Jaipur, Rajasthan', NULL, 'Contacted', 'High', NULL, 'Telecaller Raj', 5000, 15000, 0, '2026-10-20', 'Requirement for enterprise package', '2026-10-07 08:51:29', '2026-10-07 08:51:29');
