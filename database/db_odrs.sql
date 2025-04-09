-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 04:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_odrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `advice`
--

CREATE TABLE `advice` (
  `id` int(11) NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `groom_id` int(11) DEFAULT NULL,
  `bride_id` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `place` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `advice_to` varchar(100) DEFAULT NULL,
  `to_marry` varchar(100) DEFAULT NULL,
  `prepared_by_id` int(11) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `prepared_by_date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `birth`
--

CREATE TABLE `birth` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `request_for` enum('BIRTH CERTIFICATE','AUTHENTICATION','CD/LI') DEFAULT NULL,
  `number_of_copies` int(11) DEFAULT NULL,
  `brn` varchar(255) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob_province` varchar(100) DEFAULT NULL,
  `pob_city` varchar(100) DEFAULT NULL,
  `pob_country` varchar(100) DEFAULT NULL,
  `father_lname` varchar(100) DEFAULT NULL,
  `father_fname` varchar(100) DEFAULT NULL,
  `father_mname` varchar(100) DEFAULT NULL,
  `mother_lname` varchar(100) DEFAULT NULL,
  `mother_fname` varchar(100) DEFAULT NULL,
  `mother_mname` varchar(100) DEFAULT NULL,
  `authorization_letter` text DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cenomar`
--

CREATE TABLE `cenomar` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `number_of_copies` int(11) DEFAULT NULL,
  `brn` varchar(255) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob_province` varchar(100) DEFAULT NULL,
  `pob_city` varchar(100) DEFAULT NULL,
  `pob_country` varchar(100) DEFAULT NULL,
  `father_lname` varchar(100) DEFAULT NULL,
  `father_fname` varchar(100) DEFAULT NULL,
  `father_mname` varchar(100) DEFAULT NULL,
  `mother_lname` varchar(100) DEFAULT NULL,
  `mother_fname` varchar(100) DEFAULT NULL,
  `mother_mname` varchar(100) DEFAULT NULL,
  `authorization_letter` text DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `mobile_number` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `user_type` varchar(255) DEFAULT 'Client',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `mobile_number`, `email`, `address`, `username`, `password`, `user_type`, `status`, `date_created`) VALUES
(1, 'Ajelda', 'Tudlasan', '09505394636', 'chenleeebdao45@gmail.com', 'Brgy. 5, Nasipit, ADN', 'ajelda', '$2y$10$DGgQYF7rY0qd0K9j5bGSsuF.bEMZB/7nlTb4WI5ThaEuQAWNfHCJ2', 'Client', 'Active', '2025-03-29 14:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `consents`
--

CREATE TABLE `consents` (
  `id` int(11) NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `groom_id` int(11) DEFAULT NULL,
  `bride_id` int(11) DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_address` text DEFAULT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  `child_name` varchar(100) DEFAULT NULL,
  `child_address` varchar(100) DEFAULT NULL,
  `child_age` varchar(20) DEFAULT NULL,
  `to_marry` varchar(255) DEFAULT NULL,
  `to_marry_address` varchar(255) DEFAULT NULL,
  `prepared_by_id` int(11) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `prepared_by_date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `request_for` enum('DEATH CERTIFICATE','AUTHENTICATION','CD/LI') DEFAULT NULL,
  `number_of_copies` int(11) DEFAULT NULL,
  `brn` varchar(255) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob_province` varchar(100) DEFAULT NULL,
  `pob_city` varchar(100) DEFAULT NULL,
  `pob_country` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `specify` varchar(100) DEFAULT NULL,
  `authorization_letter` text DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `logs_detail` text DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `marriage`
--

CREATE TABLE `marriage` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `request_for` enum('MARRIAGE CERTIFICATE','AUTHENTICATION','CD/LI') DEFAULT NULL,
  `number_of_copies` int(11) DEFAULT NULL,
  `husband_lname` varchar(100) DEFAULT NULL,
  `husband_fname` varchar(100) DEFAULT NULL,
  `husband_mname` varchar(100) DEFAULT NULL,
  `wife_lname` varchar(100) DEFAULT NULL,
  `wife_fname` varchar(100) DEFAULT NULL,
  `wife_mname` varchar(100) DEFAULT NULL,
  `dom` date DEFAULT NULL,
  `pom_province` varchar(100) DEFAULT NULL,
  `pom_city` varchar(100) DEFAULT NULL,
  `pom_country` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `specify` varchar(100) DEFAULT NULL,
  `authorization_letter` text DEFAULT NULL,
  `valid_id` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `marriage_bride`
--

CREATE TABLE `marriage_bride` (
  `id` int(11) NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `to_marry` varchar(255) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `pob_city` varchar(100) DEFAULT NULL,
  `pob_province` varchar(100) DEFAULT NULL,
  `pob_country` varchar(100) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) DEFAULT NULL,
  `residence` varchar(255) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `previously_married` varchar(100) DEFAULT NULL,
  `place_dissolved` varchar(100) DEFAULT NULL,
  `date_dissolved` date DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_citizenship` varchar(255) DEFAULT NULL,
  `father_residence` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_citizenship` varchar(255) DEFAULT NULL,
  `mother_residence` varchar(255) DEFAULT NULL,
  `person_consent` varchar(255) DEFAULT NULL,
  `person_relationship` varchar(255) DEFAULT NULL,
  `person_citizenship` varchar(255) DEFAULT NULL,
  `person_residence` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `registrar_id` int(11) DEFAULT NULL,
  `registrar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `marriage_groom`
--

CREATE TABLE `marriage_groom` (
  `id` int(11) NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `to_marry` varchar(255) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `pob_city` varchar(100) DEFAULT NULL,
  `pob_province` varchar(100) DEFAULT NULL,
  `pob_country` varchar(100) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) DEFAULT NULL,
  `residence` varchar(255) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `previously_married` varchar(100) DEFAULT NULL,
  `place_dissolved` varchar(100) DEFAULT NULL,
  `date_dissolved` date DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_citizenship` varchar(255) DEFAULT NULL,
  `father_residence` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_citizenship` varchar(255) DEFAULT NULL,
  `mother_residence` varchar(255) DEFAULT NULL,
  `person_consent` varchar(255) DEFAULT NULL,
  `person_relationship` varchar(255) DEFAULT NULL,
  `person_citizenship` varchar(255) DEFAULT NULL,
  `person_residence` varchar(255) DEFAULT NULL,
  `registrar_id` int(11) DEFAULT NULL,
  `registrar` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `marriage_license`
--

CREATE TABLE `marriage_license` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `province` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `registry_no` varchar(100) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `date_receipt` date DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `date_issuance` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `picture` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `type`, `account_name`, `account_number`, `picture`, `status`, `date_created`) VALUES
(1, 'Gcash', 'Eden Salas', '09505394585', '/upload/payment_type/file_67e128738e017.png', 'Active', '2025-03-24 09:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `dt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE `request_type` (
  `id` int(11) NOT NULL,
  `document_type` enum('Birth Certificate','Death Certificate','CENOMAR','Marriage Certificate','Marriage License') DEFAULT NULL,
  `date_requested` date DEFAULT NULL,
  `requested_by_id` int(11) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `acted_by_id` int(11) DEFAULT NULL,
  `acted_by` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 150.00,
  `proof_payment` text DEFAULT NULL,
  `official_receipt` text DEFAULT NULL,
  `status` enum('FOR PAYMENT','FOR VERIFICATION','FOR CLAIMING','CLAIMED','FOR PROCESSING') DEFAULT 'FOR PAYMENT',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_type` enum('Administrator','Staff') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `date_created`) VALUES
(1, 'Chenlee', 'Ebdao', 'admin', '$2y$10$HCK3lPU5KOgZ21/n0HeFW.mEmWj345NdQDXEPOcQdqdSst4PuMHFK', 'Administrator', 'Active', '2022-10-23 13:43:17'),
(2, 'sara', 'manongas', 'sara_manongas', '$2y$10$Un17Caqn2A9qU6dV9PC.dO4yWkaCzv2KZEQedt1/wp4sRFk5bNLre', 'Staff', 'Active', '2025-03-21 05:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `witness`
--

CREATE TABLE `witness` (
  `id` int(11) NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `groom_id` int(11) DEFAULT NULL,
  `bride_id` int(11) DEFAULT NULL,
  `witness_names` text DEFAULT NULL,
  `residency` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `to_marry` varchar(255) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `date_issued` date DEFAULT NULL,
  `issued_at` text DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advice`
--
ALTER TABLE `advice`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `birth`
--
ALTER TABLE `birth`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `cenomar`
--
ALTER TABLE `cenomar`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `consents`
--
ALTER TABLE `consents`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `marriage`
--
ALTER TABLE `marriage`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `marriage_bride`
--
ALTER TABLE `marriage_bride`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `marriage_groom`
--
ALTER TABLE `marriage_groom`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `marriage_license`
--
ALTER TABLE `marriage_license`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `witness`
--
ALTER TABLE `witness`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advice`
--
ALTER TABLE `advice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `birth`
--
ALTER TABLE `birth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cenomar`
--
ALTER TABLE `cenomar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `consents`
--
ALTER TABLE `consents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marriage`
--
ALTER TABLE `marriage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marriage_bride`
--
ALTER TABLE `marriage_bride`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marriage_groom`
--
ALTER TABLE `marriage_groom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marriage_license`
--
ALTER TABLE `marriage_license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_type`
--
ALTER TABLE `request_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `witness`
--
ALTER TABLE `witness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
