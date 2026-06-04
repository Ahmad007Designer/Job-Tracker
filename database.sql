-- ============================================================
-- JobTracker - Database Setup
-- Run this file in phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS `jobtracker`
  CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE `jobtracker`;

-- ------------------------------------------------------------
-- Table: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `email`      VARCHAR(150) NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- Table: job_applications
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `job_applications` (
  `id`             INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`        INT(11)      NOT NULL,
  `company_name`   VARCHAR(150) NOT NULL,
  `job_title`      VARCHAR(150) NOT NULL,
  `location`       VARCHAR(150) DEFAULT NULL,
  `job_type`       ENUM('Full-time','Part-time','Internship','Remote','Contract') NOT NULL DEFAULT 'Full-time',
  `salary_range`   VARCHAR(50)  DEFAULT NULL,
  `status`         ENUM('Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn') NOT NULL DEFAULT 'Applied',
  `applied_date`   DATE         NOT NULL,
  `follow_up_date` DATE         DEFAULT NULL,
  `job_url`        TEXT         DEFAULT NULL,
  `notes`          TEXT         DEFAULT NULL,
  `resume_version` VARCHAR(50)  DEFAULT NULL,
  `created_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ------------------------------------------------------------
-- Sample demo user  (password: demo123)
-- ------------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `password`) VALUES
('Ahmad Husain', 'demo@jobtracker.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ------------------------------------------------------------
-- Sample job applications for demo user
-- ------------------------------------------------------------
INSERT INTO `job_applications`
  (`user_id`,`company_name`,`job_title`,`location`,`job_type`,`salary_range`,`status`,`applied_date`,`follow_up_date`,`job_url`,`notes`,`resume_version`)
VALUES
(1,'TCS','Junior PHP Developer','Noida, UP','Full-time','3-4 LPA','Shortlisted','2025-05-20','2025-05-30','https://careers.tcs.com','Applied via NextStep portal. HR called for screening round.','v2'),
(1,'Infosys','Associate Engineer','Bangalore','Full-time','3.6 LPA','Interview','2025-05-18','2025-05-28','https://infosys.com/careers','InfyTQ certification submitted. Interview scheduled for 5th June.','v2'),
(1,'Nagarro','Software Engineer Trainee','Gurugram','Full-time','4-5 LPA','Applied','2025-05-25',NULL,'https://nagarro.com/careers','Applied via LinkedIn Easy Apply.','v2'),
(1,'BrowserStack','Frontend Intern','Remote','Internship','25k/month','Rejected','2025-05-10',NULL,'https://browserstack.com/careers','Rejected after online coding test. Need more DSA practice.','v1'),
(1,'Mphasis','Web Developer','Pune','Full-time','3.5 LPA','Applied','2025-05-28',NULL,'https://mphasis.com/careers',NULL,'v2');