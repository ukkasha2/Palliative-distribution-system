-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 05:49 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `palliativecare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `date_created` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_name`, `category_image`, `date_created`) VALUES
(7, 'Student', '../uploads/Student.jpg', '2024-04-05 03:08:57'),
(8, 'New Born Baby', '../uploads/New Born Baby.jpg', '2024-04-05 03:15:17'),
(9, 'Vulnerable', '../uploads/Vulnerable.jpg', '2024-04-05 03:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `users_fingerprints`
--

CREATE TABLE `users_fingerprints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fingerprint_template` text NOT NULL,
  `created_at` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_fingerprints`
--

INSERT INTO `users_fingerprints` (`id`, `user_id`, `fingerprint_template`, `created_at`) VALUES
(1, 1, 'Rk1SACAyMAAAAACiAAABPAFiAMUAxQEAAAAoFkB8APOOAECbAJ57AEDbARVuAEAyAPGdAICdAUsJAICjAGt6AEDMAV/bAEC6ADp3AIDPANx2AIBKAM8LAEDkAMBzAICnAUKRAEBoAID8AEC2AVzgAIBNAGWDAEDCALTzAEBTALCMAIDGATJyAIBjATghAECjAVWdAIBJAVOjAEB5AEl5AAAA', '2024-03-31 20:02:28'),
(2, 2, 'Rk1SACAyMAAAAADMAAABPAFiAMUAxQEAAAAoHYC8AP4LAIDrALr9AECyATMNAEDyAKUAAEDKAU0FAEEcASxnAEEqASm9AEBBANOaAED6AFgJAIB2AFYSAEC5ALmRAIDcASKKAECzAJsPAIB0AMERAIEOAT6/AID7AVB AEDwAVzoAECWAGcRAEA2AJcWAIBxAEgXAID3APn1AIB7AOEQAECGASecAIEFAKOAAEDMAVn AIDcAV2CAIEaAULDAEDPAFwPAIBKAVUcAAAA', '2024-03-31 20:03:49'),
(3, 3, 'Rk1SACAyMAAAAADeAAABPAFiAMUAxQEAAAAoIECJANa9AICaAOuaAIDEAN7AAIDKAMnMAEBiAK6gAIBRAOe2AICJASAYAED/AMrRAED9AQDDAED0AIjUAECaADnzAECTALybAIC4ANu/AIB5AOsvAIBlANq7AIDRAPO AEBZAQEJAEBrAR HAEA/APw3AICEAToSAEDrAG1bAECmACd/AECnAOKzAECgAKp1AIB7APMlAICBAQeIAIDeANzJAECcASSRAIA6AMo7AEA AQQPAECDAGSCAIENAIRUAAAA', '2024-04-05 03:32:16'),
(4, 4, 'Rk1SACAyMAAAAAC6AAABPAFiAMUAxQEAAAAoGoCkAPkDAICFARkIAEBmAIUQAEChATvyAIB4AUoGAIAWAMkRAICRAVLzAIASAS8WAID AUbTAIDEANL4AICZASwDAEBNASAVAIAeANeVAED9AO5tAECjAGOTAIB4AVf7AIDoAFsBAECaAC4TAEBNANASAIA3APqWAECAAHQSAECsAGsLAEDfAH76AIBjAGMaAEDNAU/TAEC1AD4QAAAA', '2024-04-05 03:35:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_fingerprints`
--
ALTER TABLE `users_fingerprints`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_fingerprints`
--
ALTER TABLE `users_fingerprints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
