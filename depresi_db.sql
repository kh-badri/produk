-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2025 at 04:18 PM
-- Server version: 5.7.44
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `depresi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id` int(11) UNSIGNED NOT NULL,
  `durasi_layar` float(5,1) NOT NULL,
  `durasi_sosmed` float(5,1) NOT NULL,
  `durasi_tidur` float(5,1) NOT NULL,
  `resiko_depresi` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataset`
--

INSERT INTO `dataset` (`id`, `durasi_layar`, `durasi_sosmed`, `durasi_tidur`, `resiko_depresi`, `created_at`, `updated_at`) VALUES
(1, 6.0, 7.0, 6.0, 'Tinggi', '2025-10-21 16:17:19', '2025-10-21 16:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) UNSIGNED NOT NULL,
  `durasi_layar` float(5,1) NOT NULL,
  `durasi_sosmed` float(5,1) NOT NULL,
  `durasi_tidur` float(5,1) NOT NULL,
  `k` int(5) NOT NULL,
  `hasil_klasifikasi` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `durasi_layar`, `durasi_sosmed`, `durasi_tidur`, `k`, `hasil_klasifikasi`, `created_at`, `updated_at`) VALUES
(3, 7.0, 5.0, 6.0, 3, 'Tinggi', '2025-10-21 16:06:32', '2025-10-21 16:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(12) NOT NULL,
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
(9, 'admin', '$2y$10$XsbW/03O5RH2ku1KU2Pscu377BMAVlBdt.Slcm6zSxXloRahTTqjS', 'sayadmin', 'admin225@gmail.com', '1761063392_2a0ed935235082d568a1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
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
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
