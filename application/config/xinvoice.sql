-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2021 at 05:29 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xinvoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `Clients`
--

CREATE TABLE `Clients` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `username` varchar(100) NOT NULL COMMENT 'USERNAME',
  `name` varchar(255) NOT NULL COMMENT 'CLIENT NAME',
  `address` varchar(255) NOT NULL COMMENT 'ADDRESS',
  `city` varchar(30) NOT NULL COMMENT 'CITY',
  `district` varchar(50) NOT NULL COMMENT 'DISTRICT',
  `area` varchar(255) NOT NULL COMMENT 'AREA',
  `pin_code` int(6) NOT NULL COMMENT 'PIN CODE',
  `gst_no` varchar(50) NOT NULL COMMENT 'GST NUMBER',
  `pan_no` varchar(30) NOT NULL COMMENT 'PAN NUMBER',
  `aadhar_no` varchar(15) NOT NULL COMMENT 'AADHAR NUMBER',
  `mobile_no` varchar(15) NOT NULL COMMENT 'MOBILE NUMBER',
  `fssai_no` varchar(100) NOT NULL COMMENT 'FSSAI NUMBER',
  `client_type` enum('supplier','distributer','vendor','outlet') NOT NULL DEFAULT 'vendor' COMMENT 'CLIENT TYPE',
  `delete_flag` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT 'DELETE FLAG',
  `firm_code` varchar(10) NOT NULL COMMENT 'FIRM CODE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATED DATE',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Firms`
--

CREATE TABLE `Firms` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `code` varchar(10) NOT NULL COMMENT 'FIRM CODE',
  `name` varchar(255) NOT NULL COMMENT 'FIRM NAME',
  `description` varchar(255) NOT NULL COMMENT 'DESCRIPTION',
  `address` varchar(255) NOT NULL COMMENT 'ADDRESS',
  `area` varchar(255) NOT NULL COMMENT 'AREA',
  `district` varchar(50) NOT NULL COMMENT 'DISTRICT',
  `state` varchar(50) NOT NULL COMMENT 'STATE',
  `pin_code` int(6) NOT NULL COMMENT 'PIN CODE',
  `mobile_number` int(12) NOT NULL COMMENT 'MOBILE NUMBER',
  `delete_flag` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT 'DELETE FLAG',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATED DATE',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE `Items` (
  `id` int(20) NOT NULL COMMENT 'ID',
  `item_code` varchar(100) NOT NULL COMMENT 'ITEM CODE',
  `description` varchar(255) NOT NULL COMMENT 'DESCRIPTION',
  `sub_description` varchar(255) NOT NULL COMMENT 'SUB DESCRIPTION',
  `weight_in_ltr` double NOT NULL COMMENT 'WEIGHT IN LITTER',
  `unit_case` int(10) NOT NULL COMMENT 'UNIT/CASE',
  `mrp` float NOT NULL COMMENT 'MRP',
  `cost_price` float NOT NULL COMMENT 'COST PRICE',
  `op_balance_in_qty` int(10) NOT NULL COMMENT 'OP. BALANCE IN QUANTITY',
  `company_code` varchar(10) NOT NULL COMMENT 'COMPANY CODE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATED DATE',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delete_flag` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT 'DELETED FLAG',
  `firm_id` varchar(10) NOT NULL COMMENT 'FIRM ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Ledgers`
--

CREATE TABLE `Ledgers` (
  `id` int(20) NOT NULL COMMENT 'ID',
  `client_id` int(20) NOT NULL COMMENT 'CLIENT ID',
  `client_name` varchar(255) NOT NULL COMMENT 'CLIENT NAME',
  `amount` varchar(50) NOT NULL COMMENT 'AMOUNT',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATE DATE',
  `created_by` varchar(50) NOT NULL COMMENT 'USERNAME'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `fk_username` varchar(30) NOT NULL COMMENT 'USERNAME',
  `fk_firm_code` varchar(30) NOT NULL COMMENT 'FIRM CODE',
  `comment` text NOT NULL COMMENT 'COMMENT',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'LOG DATE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Stocks`
--

CREATE TABLE `Stocks` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `item_id` int(50) NOT NULL COMMENT 'ITEM ID',
  `item_code` varchar(50) NOT NULL COMMENT 'ITEM CODE',
  `item_count` varchar(50) NOT NULL COMMENT 'ITEM COUNT',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATE DATE',
  `created_by` varchar(50) NOT NULL COMMENT 'USERNAME'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `username` varchar(255) NOT NULL COMMENT 'USERNAME',
  `email` varchar(100) NOT NULL COMMENT 'EMAIL',
  `password` varchar(255) NOT NULL COMMENT 'PASSWORD',
  `first_name` varchar(50) NOT NULL COMMENT 'FIRST NAME',
  `last_name` varchar(50) NOT NULL COMMENT 'LAST NAME',
  `mobile_number` varchar(20) NOT NULL COMMENT 'MOBILE NUMBER',
  `delete_flag` enum('YES','NO') NOT NULL DEFAULT 'NO' COMMENT 'DELETE FLAG',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active' COMMENT 'STATE',
  `last_sign_in_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'LAST SIGN IN TIME',
  `firm_code` varchar(10) NOT NULL COMMENT 'FK FIRM CODE',
  `role` enum('superadmin','admin','coordinator','watcher') NOT NULL DEFAULT 'watcher' COMMENT 'ROLE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'CREATED DATE',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'UPDATED DATE',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `mobile_number`, `delete_flag`, `status`, `last_sign_in_time`, `firm_code`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'iamabhyas', 'abhyaskumardeshpremi@gmail.com', '5e15281a3755bc0e41d36d344b943745', 'Abhyas', 'Deshpremi', '9098773922', 'NO', 'active', '2021-04-03 11:31:34', '', 'watcher', '2021-04-03 11:31:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Ledgers`
--
ALTER TABLE `Ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Stocks`
--
ALTER TABLE `Stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Clients`
--
ALTER TABLE `Clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `Ledgers`
--
ALTER TABLE `Ledgers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `Stocks`
--
ALTER TABLE `Stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
