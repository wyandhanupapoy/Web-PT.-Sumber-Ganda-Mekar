-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 06:46 PM
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
-- Database: `sumber_ganda_mekar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$e0MYz1Q1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `spreadsheet_link_1` varchar(255) DEFAULT NULL,
  `spreadsheet_link_2` varchar(255) DEFAULT NULL,
  `spreadsheet_link_3` varchar(255) DEFAULT NULL,
  `spreadsheet_link_4` varchar(255) DEFAULT NULL,
  `spreadsheet_link_5` varchar(255) DEFAULT NULL,
  `spreadsheet_link_name_1` varchar(255) DEFAULT NULL,
  `spreadsheet_link_name_2` varchar(255) DEFAULT NULL,
  `spreadsheet_link_name_3` varchar(255) DEFAULT NULL,
  `spreadsheet_link_name_4` varchar(255) DEFAULT NULL,
  `spreadsheet_link_name_5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `posisi`, `email`, `password`, `spreadsheet_link_1`, `spreadsheet_link_2`, `spreadsheet_link_3`, `spreadsheet_link_4`, `spreadsheet_link_5`, `spreadsheet_link_name_1`, `spreadsheet_link_name_2`, `spreadsheet_link_name_3`, `spreadsheet_link_name_4`, `spreadsheet_link_name_5`) VALUES
(1, 'John Doe', '', 'pegawai@sumbergandamekar.com', '$2y$10$e0MYz1Q1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'nunu', '', 'nunu@sumbergandamekar.com', 'papoyhola', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'dhanu', '', '123@sumbergandamekar.com', '$2y$10$e0MYz1Q1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'poy', '', 'poy@gmail.com', '$2y$10$4ITWTW7wE3/HKPTwx5AXau.VG8.8x9VKyF7A3z266h9/V3nsLcQ8i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Achmad Mulyandi', 'Pegawai Pajak', 'achmad.pibdg@gmail.com', '$2y$10$aYnVPjnZfqUvDMCKx8bMgumhkFTNmM5heRcWRyNx7MxJrFCgHz1Jm', 'https://docs.google.com/spreadsheets/d/1ElnMaMFUICOMBDAzcZ7iffpyQE1RGW4g6CFbreamBcI/edit?usp=sharing', 'https://docs.google.com/spreadsheets/d/1IWa41pz4RZTppWWpnWnHfkon6v-Ut84Ui9-xhyBrnJg/edit?usp=sharing', 'https://docs.google.com/spreadsheets/d/1UySPo8wAtDynLe94GQiA3b5lwPzdHdlY/edit?usp=sharing&ouid=108339230003326742629&rtpof=true&sd=true', 'https://docs.google.com/spreadsheets/d/1LqBv3QDc-3c55l4vdsaiqntisgpyYocE/edit?usp=sharing&ouid=108339230003326742629&rtpof=true&sd=true', 'https://docs.google.com/spreadsheets/d/1yyT8M0pcfT6pINA7_EGqdLtWNZzVh_61s3P2PNFv1lQ/edit?usp=sharing', 'PTIK', 'Hasil Dataset Kelompok 3A', 'DATABASE PESERTA PELATIHAN KEDISIPLINAN DAN BELA NEGARA POLBAN 2024', 'Jadwal WWC 8 Besar Presidium', 'HASIL TO SNBT 2024 BKB NURUL FIKRI SENASIONAL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
