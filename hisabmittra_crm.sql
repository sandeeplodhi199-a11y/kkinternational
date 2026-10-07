
-- Auto-Saved Action [2026-10-07 08:13:48]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `source_id`, `status`, `priority`, `assigned_to`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-1798', 'Auto SQL Test User', 'test@auto-sql.com', '+91 99999 88888', 'Test Company Pvt Ltd', NULL, 'New', 'High', NULL, 50000, NULL, 'Testing auto SQL persistence.', '2026-10-07 08:13:48', '2026-10-07 08:13:48');

-- Auto-Saved Action [2026-10-07 08:48:29]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `city`, `source_id`, `status`, `priority`, `assigned_to`, `agent`, `basic`, `pro`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-2686', 'him', 'a@w.com', '+91 9876543210', 'apex', 'jodhpur', 2, 'In Progress', 'High', 1, 'mohan', 5000, 10000, 8000, '2026-02-09', 'hello', '2026-10-07 08:48:29', '2026-10-07 08:48:29');

-- Auto-Saved Action [2026-10-07 08:51:29]
INSERT INTO `crm_leads` (`lead_code`, `name`, `email`, `phone`, `company`, `city`, `source_id`, `status`, `priority`, `assigned_to`, `agent`, `basic`, `pro`, `expected_value`, `follow_up_date`, `notes`, `created_at`, `updated_at`) VALUES ('LEAD-9347', 'Kishore Kumar', NULL, '+91 98765 43210', 'KK Steel Mills', 'Jaipur, Rajasthan', NULL, 'Contacted', 'High', NULL, 'Telecaller Raj', 5000, 15000, 0, '2026-10-20', 'Requirement for enterprise package', '2026-10-07 08:51:29', '2026-10-07 08:51:29');

-- Auto-Saved Action [2026-10-07 09:43:42]
UPDATE `crm_demos` SET `status` = 'Completed', `updated_at` = '2026-10-07 09:43:42' WHERE `id` = 2;

-- Auto-Saved Action [2026-10-07 09:44:28]
UPDATE `crm_demos` SET `status` = 'Scheduled', `updated_at` = '2026-10-07 09:44:28' WHERE `id` = 2;

-- Auto-Saved Action [2026-10-07 13:16:26]
INSERT INTO `crm_followups` (`lead_id`, `customer_id`, `assigned_to`, `date`, `time`, `type`, `notes`, `status`, `reminder_sent`, `created_at`, `updated_at`) VALUES (39, NULL, 1, '2026-10-07', '16:45:00', 'Call', 'Test follow-up sync to MySQL', 'Pending', 0, '2026-10-07 13:16:26', '2026-10-07 13:16:26');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_followups` (`lead_id`, `customer_id`, `assigned_to`, `date`, `time`, `type`, `notes`, `status`, `reminder_sent`, `created_at`, `updated_at`) VALUES (39, NULL, 1, '2026-10-07', '15:30:00', 'Call', 'Discuss HisabMittra software license terms', 'Pending', 0, '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_customers` (`customer_code`, `name`, `company`, `email`, `phone`, `address`, `assigned_to`, `lead_id`, `status`, `total_spent`, `notes`, `created_at`, `updated_at`) VALUES ('CUST-4902', 'Aman Verma', 'Verma Enterprises', 'aman@verma.com', '9876543210', 'Jaipur, Rajasthan', NULL, NULL, 'Active', 0.00, 'Premium retail client', '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_deals` (`title`, `customer_id`, `lead_id`, `value`, `stage`, `probability`, `expected_closing_date`, `assigned_to`, `priority`, `notes`, `created_at`, `updated_at`) VALUES ('Verma Enterprises Enterprise ERP', NULL, NULL, 45000, 'Proposal', 60, NULL, 1, 'High', 'Proposal submitted for 5 users', '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_tasks` (`title`, `description`, `assigned_to`, `related_lead_id`, `related_customer_id`, `priority`, `due_date`, `status`, `created_at`, `updated_at`) VALUES ('Send updated quotation and product brochure', 'Send PDF via WhatsApp and Email to client', 1, NULL, NULL, 'Urgent', '2026-10-08', 'Pending', '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_payments` (`payment_no`, `quotation_id`, `customer_id`, `amount`, `payment_date`, `payment_method`, `transaction_ref`, `status`, `notes`, `created_at`, `updated_at`) VALUES ('REC-2026-9241', NULL, 9, 15000, '2026-10-07', 'UPI', 'UPI-884920491', 'Paid', 'Advance payment received', '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_products` (`name`, `code`, `category`, `description`, `price`, `tax_rate`, `status`, `created_at`, `updated_at`) VALUES ('HisabMittra Billing POS Add-on', 'PRD-POS-01', 'Software', 'Barcode billing, thermal printing, and GST e-invoicing', 12000, 18, 'Active', '2026-10-07 13:22:09', '2026-10-07 13:22:09');

-- Auto-Saved Action [2026-10-07 13:22:09]
INSERT INTO `crm_reservations` (`reservation_code`, `customer_name`, `service_name`, `date`, `time`, `assigned_to`, `status`, `amount`, `notes`, `created_at`, `updated_at`) VALUES ('RES-5489', 'Suresh Kumar', 'Onsite Setup & Training', '2026-10-09', '14:00:00', NULL, 'Confirmed', 5000, 'Installation scheduled', '2026-10-07 13:22:09', '2026-10-07 13:22:09');
