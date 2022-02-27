-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2022 at 07:25 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `church_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `activity_name` varchar(45) DEFAULT NULL,
  `activity_color` varchar(8) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `id` int(11) NOT NULL,
  `amount` decimal(19,2) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `feed_type` varchar(10) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `image_type` varchar(45) DEFAULT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mass_booking`
--

CREATE TABLE `mass_booking` (
  `id` int(11) NOT NULL,
  `mass_intention` text DEFAULT NULL,
  `person` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news_letter`
--

CREATE TABLE `news_letter` (
  `id` int(11) NOT NULL,
  `from` varchar(45) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `to` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `directed_to` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `org_name` varchar(70) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `meeting_days` varchar(10) DEFAULT NULL,
  `re_occurance` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `organization_has_profile`
--

CREATE TABLE `organization_has_profile` (
  `organization_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `position` varchar(45) DEFAULT NULL,
  `date_joined` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `payment_type` varchar(45) DEFAULT NULL,
  `amount` decimal(19,2) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `donation_id` int(11) NOT NULL,
  `subscribe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `feeds` int(11) DEFAULT NULL,
  `user_management` int(11) DEFAULT NULL,
  `mass_booking` int(11) DEFAULT NULL,
  `configurations` int(11) DEFAULT NULL,
  `subscriptions` int(11) DEFAULT NULL,
  `others` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `feeds`, `user_management`, `mass_booking`, `configurations`, `subscriptions`, `others`, `users_id`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `maiden_name` varchar(45) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `marital_status` varchar(45) DEFAULT NULL,
  `d_o_wedding` date DEFAULT NULL,
  `d_o_b` date DEFAULT NULL,
  `state_of_origin` varchar(45) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `residentail_address` text DEFAULT NULL,
  `religion` varchar(20) DEFAULT NULL,
  `registration_no` varchar(16) DEFAULT NULL,
  `registration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `first_name`, `middle_name`, `last_name`, `maiden_name`, `sex`, `marital_status`, `d_o_wedding`, `d_o_b`, `state_of_origin`, `phone_no`, `email`, `residentail_address`, `religion`, `registration_no`, `registration_date`) VALUES
(1, 'Samuel', NULL, 'Ejiga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'olochesamuel2@gmail.com', NULL, NULL, 'njR4X9VEjO', '2022-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `id` int(11) NOT NULL,
  `relationship_type` varchar(20) DEFAULT NULL,
  `related_to` int(11) DEFAULT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sacraments`
--

CREATE TABLE `sacraments` (
  `id` int(11) NOT NULL,
  `tittle` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `minimum_age` int(11) NOT NULL,
  `max_receivable` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sacraments_recieved`
--

CREATE TABLE `sacraments_recieved` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `date_received` date NOT NULL,
  `ministered_by` varchar(80) NOT NULL,
  `sacrament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `amount` decimal(19,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `subscription_model_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_model`
--

CREATE TABLE `subscription_model` (
  `id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `reoccurence` varchar(45) DEFAULT NULL,
  `amount` decimal(19,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_permission`
--

CREATE TABLE `sub_permission` (
  `id` int(11) NOT NULL,
  `login` int(11) DEFAULT NULL,
  `access_data` int(11) DEFAULT NULL,
  `edit_data` int(11) DEFAULT NULL,
  `committee` int(11) DEFAULT NULL,
  `subscription_model_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `passkey` text DEFAULT NULL,
  `status` varchar(7) NOT NULL DEFAULT 'ACTIVE',
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passkey`, `status`, `profile_id`) VALUES
(1, 'admin', '$2y$10$szjDuLdZR5H15VIJekVEw.ODICtE.wlxkJEM8RYYrMqukB3zAv7GG', 'ACTIVE', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_images_profile1_idx` (`profile_id`);

--
-- Indexes for table `mass_booking`
--
ALTER TABLE `mass_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mass_booking_profile1_idx` (`profile_id`);

--
-- Indexes for table `news_letter`
--
ALTER TABLE `news_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_has_profile`
--
ALTER TABLE `organization_has_profile`
  ADD PRIMARY KEY (`organization_id`,`profile_id`),
  ADD KEY `fk_organization_has_profile_profile1_idx` (`profile_id`),
  ADD KEY `fk_organization_has_profile_organization1_idx` (`organization_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_donation1_idx` (`donation_id`),
  ADD KEY `fk_payment_subscribe1_idx` (`subscribe_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permissions_users1_idx` (`users_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_relationships_profile1_idx` (`profile_id`);

--
-- Indexes for table `sacraments`
--
ALTER TABLE `sacraments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sacraments_recieved`
--
ALTER TABLE `sacraments_recieved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subscribe_subscription_model1_idx` (`subscription_model_id`),
  ADD KEY `fk_subscribe_profile1_idx` (`profile_id`);

--
-- Indexes for table `subscription_model`
--
ALTER TABLE `subscription_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_permission`
--
ALTER TABLE `sub_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_permission_subscription_model1_idx` (`subscription_model_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_profile_idx` (`profile_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mass_booking`
--
ALTER TABLE `mass_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_letter`
--
ALTER TABLE `news_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sacraments`
--
ALTER TABLE `sacraments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sacraments_recieved`
--
ALTER TABLE `sacraments_recieved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_model`
--
ALTER TABLE `subscription_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_permission`
--
ALTER TABLE `sub_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mass_booking`
--
ALTER TABLE `mass_booking`
  ADD CONSTRAINT `fk_mass_booking_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `organization_has_profile`
--
ALTER TABLE `organization_has_profile`
  ADD CONSTRAINT `fk_organization_has_profile_organization1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_organization_has_profile_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_donation1` FOREIGN KEY (`donation_id`) REFERENCES `donation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_payment_subscribe1` FOREIGN KEY (`subscribe_id`) REFERENCES `subscribe` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `fk_permissions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `relationships`
--
ALTER TABLE `relationships`
  ADD CONSTRAINT `fk_relationships_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD CONSTRAINT `fk_subscribe_profile1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subscribe_subscription_model1` FOREIGN KEY (`subscription_model_id`) REFERENCES `subscription_model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_permission`
--
ALTER TABLE `sub_permission`
  ADD CONSTRAINT `fk_sub_permission_subscription_model1` FOREIGN KEY (`subscription_model_id`) REFERENCES `subscription_model` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_profile` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
