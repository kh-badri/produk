-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2025 at 03:47 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `produk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dataset_produk`
--

CREATE TABLE `dataset_produk` (
  `id` int NOT NULL,
  `waktu_penjualan` date NOT NULL COMMENT 'Format YYYY-MM-DD',
  `nama_produk` varchar(150) NOT NULL,
  `kategori_produk` varchar(100) NOT NULL,
  `harga_produk_rp` int NOT NULL,
  `jumlah_terjual_unit` int NOT NULL,
  `status_promosi` varchar(10) NOT NULL COMMENT 'Ya atau Tidak',
  `terjadi_penurunan` varchar(10) NOT NULL COMMENT 'Ya atau Tidak (Kolom Y/Target)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_analisis`
--

CREATE TABLE `history_analisis` (
  `id` int NOT NULL,
  `tanggal_analisis` datetime NOT NULL,
  `accuracy` decimal(5,2) NOT NULL,
  `total_data` int NOT NULL,
  `hasil_analisis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hasil_evaluasi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `nama_lengkap`, `email`, `foto`) VALUES
(5, 'badri', '$2y$10$ufHMCOpxBb4qWPM/DNxFp.iWNGrDq6ACJ.X3zJ1VB32M5vj8cZY1O', 'cek cekkk', 'khbadri22@gmail.com', '1753267234_9fe1376f34640f12d145.png'),
(8, 'alwi', '$2y$10$.5reV2X6wsjO9qBJQZp0bOP9YgZ7ieSvPltgMONhZK8TVL//v3Kci', 'alwi', 'alwi@gmail.com', '1758871250_c08f82ff61370606e844.png'),
(9, 'admin', '$2y$10$XsbW/03O5RH2ku1KU2Pscu377BMAVlBdt.Slcm6zSxXloRahTTqjS', 'sayadmin', 'admin225@gmail.com', '1761645445_818f865943734f813699.png'),
(10, 'tes', '$2y$10$DWgHE/LslsBlD820AODB9.lOynWBv/OmMZHgftwMNPaHsEb.LRmWi', NULL, NULL, 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dataset_produk`
--
ALTER TABLE `dataset_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_analisis`
--
ALTER TABLE `history_analisis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dataset_produk`
--
ALTER TABLE `dataset_produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_analisis`
--
ALTER TABLE `history_analisis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

