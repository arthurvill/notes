-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 12:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rap`
--

-- --------------------------------------------------------

--
-- Table structure for table `archived_notes`
--

CREATE TABLE `archived_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `title`, `description`, `created_at`) VALUES
(94, '', '', '2024-04-20 06:24:40'),
(95, '', '', '2024-04-20 06:31:14'),
(96, '', '', '2024-04-20 06:32:02'),
(97, '', '', '2024-04-20 06:32:13'),
(98, '', '', '2024-04-20 06:32:45'),
(99, '', '', '2024-04-20 06:35:43'),
(100, '', '', '2024-04-20 06:36:12'),
(101, '', '', '2024-04-20 06:42:05'),
(102, '', '', '2024-04-20 06:46:05'),
(103, '', '', '2024-04-20 06:47:43'),
(104, '', '', '2024-04-20 06:48:29'),
(105, '', '', '2024-04-20 06:48:44'),
(106, '', '', '2024-04-20 06:49:10'),
(107, '', '', '2024-04-20 06:49:21'),
(108, '', '', '2024-04-20 06:50:09'),
(109, '', '', '2024-04-21 09:27:32'),
(110, '', '', '2024-04-21 09:30:08'),
(111, '', '', '2024-04-21 09:37:01'),
(112, '', '', '2024-04-21 09:52:55'),
(113, '', '', '2024-04-21 09:53:54'),
(114, '', '', '2024-04-21 10:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `notetable`
--

CREATE TABLE `notetable` (
  `id` int(100) NOT NULL,
  `r_id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `r_id` int(100) NOT NULL,
  `r_username` varchar(100) NOT NULL,
  `r_email` varchar(100) NOT NULL,
  `r_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`r_id`, `r_username`, `r_email`, `r_password`) VALUES
(7, 'ArthurVillareal', 'arthurvillareal925@gmail.com', '$2y$10$hrccBKBsvdBFI.QS/CK/Z.rDrsVVbINGthlix5fracG4lzz716Txi'),
(8, 'pa', 'pa@gmail.com', '$2y$10$jfayKHh.wZJqpya75VpRgeO2lZdiIK.6PvZpbrafD3vi6FpivjTUe'),
(9, 'Ben', 'ben@gmail.com', '$2y$10$QaaF5ehp342H7c8NQwokreMhnPBxP9GBL/0jTJ4RiHuN1F2ZGJQ/6'),
(10, 'dasd', 'adsd', '$2y$10$zDFqm6drxj6EXaMKd0A34esOeoPOOQtFZHXqL9CTCJtj4w7bOryMK'),
(11, 'Arthur ', 'arthurvillareal925@gmail.com', '$2y$10$diVQtn49ZSObXWjW6Vc38.3oZStqTNlDPK46bJxVc97pr4CEy0ubS'),
(12, 'zxc', 'atoy@gmail.com', '$2y$10$MYX5Qd.JbteiyOb4GugWSOz/OAuHto6sq6wZdjELsYXLooHe/xLka'),
(13, 'zxc', 'atoy@gmail.com', '$2y$10$szVcJibNpibFDjnHL3Jn2OilSiZlVwA0Op4193gUKG9YUjf5xdkLW'),
(14, 'zxc', 'atoy@gmail.com', '$2y$10$o3QmVmnrbvN0pG3bgWsH1O0Z2ehyW6v5L21ZrhubJjz92LrmbfZSa'),
(15, 'zxc', 'atoy@gmail.com', '$2y$10$fHgwSlbpRH3ufcxDd.wUXuYwIfv14iBaRKiugCmR8cC77N4tRzFC.'),
(16, 'zxc', 'atoy@gmail.com', '$2y$10$xt06Q3Q5QzCoH2uA8aopV.Q4YdsrpZhmzhJXlUHU1JAk7pJkWJYZa'),
(17, 'zxc', 'atoy@gmail.com', '$2y$10$cBiPUYAcSbGOJO/pMmEx/.ddkAo1Q3P4fpO53FvnYLibIScIPfdae'),
(18, 'zxc', 'atoy@gmail.com', '$2y$10$9plqI1FShdga1xPMVUTZU.N6q3UazpsPn5hSxxOdbv6KsnahTbVgq'),
(19, 'zxc', 'atoy@gmail.com', '$2y$10$wIinzhJgrlREffya1DyFz.rlpaEmBuG3157bCUDsF98S55eE3Ku9C'),
(20, 'zxc', 'atoy@gmail.com', '$2y$10$/YZfVov0Ha5TSSPrcVZvX.NfqjAqbfF5D64DDRniNO6VvCFdjP5PC'),
(21, 'zxc', 'atoy@gmail.com', '$2y$10$YalDtMi2wWkH4S95UXoxT.B2jjSL58l2ymCckl1mipcdU6Hs0FrYW'),
(22, 'zxc', 'atoy@gmail.com', '$2y$10$9bfMgmWLIYhb128rtnjJieAKNu/xwnw2Gd.55FSe6X2AAdBLdBtTy'),
(23, 'zxc', 'atoy@gmail.com', '$2y$10$0lk68RH2c30VOAJrpYGzR.52eqvHeLGpQwBvbFYIMP6hEgbaKznLK'),
(24, 'zxc', 'atoy@gmail.com', '$2y$10$pMHUxHdRoACLMVv0CcB8d.WOvKobevg3vDMxA7B69MEbEPWUi9XgS'),
(25, 'zxc', 'atoy@gmail.com', '$2y$10$2AM1dY8CbQad0IlVP9rO/OvTmtB3N/TwqI.xR7Se9pUrs/S71iIIe'),
(26, 'zxc', 'atoy@gmail.com', '$2y$10$4HzkbU99UKsevcS0h5g53ew7FzKZiAuZJmeU0Ik09Sb5PUT4NgIMq'),
(27, 'zxc', 'atoy@gmail.com', '$2y$10$00PdysyL2TSU.PC/EECfwel62xqYNL9uylrW4RQHw7QthLvO5oi7.'),
(28, 'zxc', 'atoy@gmail.com', '$2y$10$7JbNMJLMI.ICYyLiQWPEFe8N8B4AS4kWEl9idNeesFDDn4uph0Bhe'),
(29, 'zxc', 'atoy@gmail.com', '$2y$10$WbFNP.fSR1JGoR4Y4Hf3L.9mWgHxzwu/VzAagphMEBFVAHpYeuR1u'),
(30, 'zxc', 'atoy@gmail.com', '$2y$10$a214ozmj15PS3p04iXyIpeuCZsFiVzyRO0ldHgJIaX44kqeWzOIv6'),
(31, 'zxc', 'atoy@gmail.com', '$2y$10$uwUFOlq07xsO2yDPdYfPJ.C3ULC.g7.SUQW0plrUx35Uwoo11jYAS'),
(32, 'zxc', 'atoy@gmail.com', '$2y$10$B0DxnFRu/r0SYnSGMRyFV.mr3LopTyw8SuEDz3LE860uP05sJYkfK'),
(33, 'asdas', 'adasd', '$2y$10$xYLq7QzGdTeg3lUEqhksbOjW19ZAQDC7V/cXhXrtYMLJl4AJN81te'),
(34, 'DFASDFSDF', 'SDFSDFSD', '$2y$10$TU74I7LLmE7G.ktpQ2h0DeVO/NvUI2mXJdOd0xme1iR1RsIVtRCYC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archived_notes`
--
ALTER TABLE `archived_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notetable`
--
ALTER TABLE `notetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`r_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archived_notes`
--
ALTER TABLE `archived_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `notetable`
--
ALTER TABLE `notetable`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `r_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
