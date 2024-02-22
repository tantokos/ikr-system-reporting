-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2023 at 04:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ikr`
--
CREATE DATABASE IF NOT EXISTS `db_ikr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_ikr`;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `nama_branch`, `kode_branch`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta Selatan', 'JKT', 'Jl. Tandean Jakarta Selatan', '2023-10-26 06:58:24', '2023-11-13 23:21:03'),
(2, 'Jakarta Timur', 'JKT', 'Jl. TB Simatupang', '2023-10-26 20:46:18', '2023-11-07 03:48:27'),
(3, 'Bekasi', 'BKS', 'Bekasi', '2023-10-26 21:30:48', '2023-11-07 03:48:45'),
(4, 'Bogor', 'BGR', 'Bogor', '2023-10-26 21:31:52', '2023-11-07 03:49:08'),
(5, 'Tangerang', 'TGR', 'Tangerang', '2023-11-07 03:50:34', '2023-11-07 03:50:34'),
(6, 'Medan', 'MDN', 'Medan', '2023-11-07 03:52:51', '2023-11-07 03:57:22'),
(7, 'Pangkal Pinang', 'PGP', 'Pangkal Pinang', '2023-11-07 05:26:33', '2023-11-07 05:26:33'),
(8, 'Pontianak', 'PTK', 'Pontianak', '2023-11-22 07:27:59', '2023-11-22 07:27:59'),
(9, 'Jambi', 'JMB', 'Jambi', '2023-11-22 07:28:26', '2023-11-22 07:28:26'),
(10, 'Bali', 'DPR', 'Bali', '2023-11-22 07:28:59', '2023-11-22 07:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `callsign_leads`
--

CREATE TABLE `callsign_leads` (
  `id` bigint UNSIGNED NOT NULL,
  `lead_callsign` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leader_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `callsign_leads`
--

INSERT INTO `callsign_leads` (`id`, `lead_callsign`, `leader_id`, `created_at`, `updated_at`) VALUES
(1, 'LEADJKTMST001', '2', '2023-11-11 08:49:05', '2023-11-11 08:49:05'),
(2, 'LEADJKTMST002', '1', '2023-11-11 08:52:16', '2023-11-11 08:52:16'),
(3, 'LEADJKTMST003', '6', '2023-11-11 16:46:37', '2023-11-14 04:31:16'),
(4, 'LEADJKTMST004', '7', '2023-11-11 17:18:08', '2023-11-14 04:31:29'),
(5, 'LEADJKTMST005', '3', '2023-11-14 03:28:49', '2023-11-14 04:31:45'),
(6, 'LEADJKTMST006', '4', '2023-11-14 03:29:40', '2023-11-14 04:32:02'),
(7, 'LEADJKTMST007', '9', '2023-11-14 04:32:25', '2023-11-14 04:32:25'),
(8, 'LEADJKTMST008', '8', '2023-11-14 04:32:43', '2023-11-14 04:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `callsign_tims`
--

CREATE TABLE `callsign_tims` (
  `id` bigint UNSIGNED NOT NULL,
  `callsign_tim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_tim1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_tim2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_tim3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_tim4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_callsign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `callsign_tims`
--

INSERT INTO `callsign_tims` (`id`, `callsign_tim`, `nik_tim1`, `nik_tim2`, `nik_tim3`, `nik_tim4`, `lead_callsign`, `created_at`, `updated_at`) VALUES
(2, 'JKTMST001', '14', '15', '16', NULL, '1', '2023-11-20 03:46:57', '2023-11-20 03:46:57'),
(3, 'JKTMST002', '17', '18', '19', NULL, '1', '2023-11-20 04:49:03', '2023-11-20 04:49:03'),
(4, 'JKTMST003', '20', '21', '22', NULL, '1', '2023-11-20 07:34:01', '2023-11-20 07:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `nik_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_karyawan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `nik_karyawan`, `nama_karyawan`, `no_telp`, `branch_id`, `divisi`, `departement`, `posisi`, `email`, `status_active`, `foto_karyawan`, `created_at`, `updated_at`) VALUES
(1, '2017040052', 'Maman Suparman', '083819161848', '2', 'IKR', 'FTTH', 'Leader Installer', 'maman.suparman@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 151554.png.png', '2023-11-07 05:58:48', '2023-11-16 01:47:20'),
(2, '2018110127', 'Muhammad Solkan', '081388246415', '2', 'IKR', 'FTTH', 'Leader Installer', 'muhammad.solkan@misitel.co.id', 'aktif', 'Screenshot 2023-11-08 141843.png.png', '2023-11-08 02:01:03', '2023-11-16 01:47:33'),
(3, '2021010294', 'Mario Immanuel', '085892888607', '2', 'IKR', 'FTTH', 'Leader Maintenance', 'mario.imnauel@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 151752.png.png', '2023-11-08 02:06:38', '2023-11-16 01:48:02'),
(4, '2021090313', 'Jacky Johanes Bernard', '089612312572', '2', 'IKR', 'FTTH', 'Leader Maintenance', 'jacky.johanes@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 151945.png.png', '2023-11-09 02:01:09', '2023-11-16 01:48:16'),
(6, '2017020034', 'Muhammad Sobar', '081315386039', '1', 'IKR', 'FTTH', 'Leader Installer', 'muhammad.sobar@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 171716.png.png', '2023-11-09 03:10:08', '2023-11-16 01:48:43'),
(7, '2018050079', 'Fuzi Ardiansyah', '082124118564', '1', 'IKR', 'FTTH', 'Leader Installer', 'fuzi.ardiansyah@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 172000.png', '2023-11-09 03:20:21', '2023-11-16 01:48:59'),
(8, '2022020338', 'Eko Setiawan', '08888022183', '1', 'IKR', 'FTTH', 'Leader Maintenance', 'eko.setiawan@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 172247.png', '2023-11-09 03:23:01', '2023-11-16 01:49:15'),
(9, '2022040390', 'Rinaldy Ahmad Naufal', '085774596112', '1', 'IKR', 'FTTH', 'Leader Maintenance', 'rinaldy.ahmad@misitel.co.id', 'aktif', 'Screenshot 2023-11-09 174343.png', '2023-11-09 03:43:56', '2023-11-16 01:49:31'),
(10, '2019020144', 'Agung Mulyana', '085745375625', '1', 'IKR', 'FTTH', 'Leader Dismantle', 'agung.mulyana@misitel.co.id', 'aktif', 'Screenshot 2023-11-14 185927.png', '2023-11-14 04:59:45', '2023-11-16 01:49:44'),
(11, '2019050158', 'Aji Muhamad Ridho', '081294740079', '1', 'IKR', 'FTTX/FTTB', 'Leader FTTX/FTTB', 'aji.muhamad@misitel.co.id', 'aktif', 'Screenshot 2023-11-14 190502.png', '2023-11-14 05:05:15', '2023-11-16 01:50:21'),
(12, '2017050054', 'Mochamad Arif Rahman', '085771506090', '1', 'IKR', 'FTTX/FTTB', 'Leader FTTX/FTTB', 'mochamad.arif@misitel.co.id', 'aktif', 'Screenshot 2023-11-14 190632.png', '2023-11-14 05:06:45', '2023-11-16 01:50:41'),
(13, '2022080451', 'Muhammad Soleh', '0895630153127', '1', 'IKR', 'FTTH', 'Installer', 'muhammad.soleh@misitel.co.id', 'aktif', 'Screenshot 2023-11-16 093134.png', '2023-11-15 19:30:58', '2023-11-15 21:26:02'),
(14, '2020020175', 'Jajang Nurzaman (KKM)', '', '2', 'IKR', 'FTTH', 'Installer', 'jajang.nurzaman@misitel.co.id', 'aktif', 'foto-blank.jpg', '2023-11-16 07:30:35', '2023-11-16 07:30:35'),
(15, '2022120514', 'Muhammad Ibnu Alfarizi', '', '2', 'IKR', 'FTTH', 'Installer', 'ibnu.alfarizi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(16, '2020090237', 'Hendi', '', '2', 'IKR', 'FTTH', 'Installer', 'hendi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(17, '2015060021', 'Saputra Arbidah', '', '2', 'IKR', 'FTTH', 'Installer', 'saputra.arbidah@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(18, '2022080428', 'Juprianto Manalu', '', '2', 'IKR', 'FTTH', 'Installer', 'juprianto.manalu@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(19, '2022120501', 'Fadilla Muhammad Ramadhan', '', '2', 'IKR', 'FTTH', 'Installer', 'fadilla.muhammad@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(20, '2018090100', 'Wahyudi Harianto', '', '2', 'IKR', 'FTTH', 'Installer', 'wahyudi.harianto@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(21, '2020050001', 'Zaenal Abidin', '', '2', 'IKR', 'FTTH', 'Installer', 'zaenal.abidin@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(22, '2022040367', 'Dandy Rizky Nanda', '', '2', 'IKR', 'FTTH', 'Installer', 'dandy.rizky@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(23, '2022120519', 'Christian Safei', '', '2', 'IKR', 'FTTH', 'Installer', 'christian.safei@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(24, '2017030044', 'Sarwani', '', '2', 'IKR', 'FTTH', 'Installer', 'sarwani@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(25, '2022080431', 'Ahmad Sarifudin', '', '2', 'IKR', 'FTTH', 'Installer', 'ahmad.sarifudin@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(26, '2022040383', 'Rachmad Sariyanto', '', '2', 'IKR', 'FTTH', 'Installer', 'rachmad.sariyanto@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(27, '2022040384', 'Ahmad Faisal', '', '2', 'IKR', 'FTTH', 'Installer', 'ahmad.faisal@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(28, '2018100111', 'Iya Irawan', '', '2', 'IKR', 'FTTH', 'Installer', 'iya.irawan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(29, '2017020039', 'Abdai Rathomi', '', '2', 'IKR', 'FTTH', 'Installer', 'abdai.rathomi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(30, '2022120515', 'Ungkas Aditya', '', '2', 'IKR', 'FTTH', 'Installer', 'ungkas.aditya@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(31, '2017020035', 'Muhammad Wiro Andriyansyah', '', '2', 'IKR', 'FTTH', 'Installer', 'muhammad.wiro@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(32, '2022040371', 'Indra Rahmat Putra', '', '2', 'IKR', 'FTTH', 'Installer', 'indra.rahmat@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(33, '2023020552', 'Ibrahim Madani', '', '2', 'IKR', 'FTTH', 'Installer', 'ibrahim.madani@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(34, '2022120521', 'Muhammad Abdul Gani', '', '2', 'IKR', 'FTTH', 'Installer', 'muhammad.abdul@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(35, '2015060025', 'Arif Suherman', '', '2', 'IKR', 'FTTH', 'Installer', 'arif.suherman@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(36, '2022080447', 'Muhammad Aldi Sulistyo', '', '2', 'IKR', 'FTTH', 'Installer', 'muhammad.aldi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(37, '2023050664', 'Ihsan Mahin', '', '2', 'IKR', 'FTTH', 'Installer', 'ihsan.mahin@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(38, '2020120266', 'Seto Tirto Wibowo', '', '2', 'IKR', 'FTTH', 'Installer', 'seto.tirto@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(39, '2019010136', 'Budi Santoso (IKR 2)', '', '2', 'IKR', 'FTTH', 'Installer', 'budi.santoso@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(40, '2022120522', 'Taufik Hidayat R', '', '2', 'IKR', 'FTTH', 'Installer', 'hidayat.taufik@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(41, '2017020033', 'Irdianto', '', '2', 'IKR', 'FTTH', 'Installer', 'irdianto@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(42, '2023030589', 'Cahyo Kuncoro', '', '2', 'IKR', 'FTTH', 'Installer', 'cahyo.kuncoro@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(43, '2019010137', 'Rubiyanto', '', '2', 'IKR', 'FTTH', 'Installer', 'rubiyanto@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(44, '2021010301', 'Rizki Arizal', '', '2', 'IKR', 'FTTH', 'Maintenance', 'rizki.arizal@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(45, '2022030357', 'Satria Adhin J. Lubis', '', '2', 'IKR', 'FTTH', 'Maintenance', 'satria.adhin@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(46, '2022100466', 'Fajar Cahyono', '', '2', 'IKR', 'FTTH', 'Maintenance', 'fajar.cahyono@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(47, '2022070422', 'Daniel Christopher', '', '2', 'IKR', 'FTTH', 'Maintenance', 'daniel.christopher@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(48, '2022110475', 'Sulistyo Wibowo', '', '2', 'IKR', 'FTTH', 'Maintenance', 'sulistyo.wibowo@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(49, '2023050660', 'Audi Fratezha', '', '2', 'IKR', 'FTTH', 'Maintenance', 'audi.fratezha@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(50, '2023050647', 'Ikdam Razak', '', '2', 'IKR', 'FTTH', 'Maintenance', 'ikdam.razak@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(51, '2022120494', 'Kosim', '', '2', 'IKR', 'FTTH', 'Maintenance', 'kosim@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(52, '2023010529', 'Sebastyan Jordy', '', '2', 'IKR', 'FTTH', 'Maintenance', 'sebastyan.jordy@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(53, '2023050649', 'Dimas Fadilah', '', '2', 'IKR', 'FTTH', 'Maintenance', 'dimas.fadilah@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(54, '2022080449', 'Muhammad Surya Ismail', '', '2', 'IKR', 'FTTH', 'Maintenance', 'muhammad.surya@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(55, '2022100468', 'Muhammad Iqbal (MST)', '', '2', 'IKR', 'FTTH', 'Maintenance', 'iqbal.muhammad@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(56, '2021010299', 'Wahyu Sahputra', '', '2', 'IKR', 'FTTH', 'Maintenance', 'wahyu.sahputra@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(57, '2022120520', 'Danoyo', '', '2', 'IKR', 'FTTH', 'Maintenance', 'danoyo@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(58, '2022070410', 'Ardhito Rayhan Yutyasnanda', '', '2', 'IKR', 'FTTH', 'Maintenance', 'ardhito.rayhan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(59, '2023050651', 'Angga Setiyandi', '', '2', 'IKR', 'FTTH', 'Maintenance', 'angga.setiyandi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(60, '2022110470', 'Henri Untung', '', '2', 'IKR', 'FTTH', 'Maintenance', 'henri.untung@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(61, '2022120495', 'Doni Ramdhani', '', '2', 'IKR', 'FTTH', 'Maintenance', 'doni.ramdhani@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(62, '2023050657', 'Rizki', '', '2', 'IKR', 'FTTH', 'Maintenance', 'rizki.rizki@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(63, '2022070407', 'Zulfin Ramadhan Simanjuntak', '', '2', 'IKR', 'FTTH', 'Maintenance', 'zulfin.ramadhan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(64, '2022070415', 'Achmad Fadilla Syah', '', '2', 'IKR', 'FTTH', 'Maintenance', 'achmad.fadilla@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(65, '2023050656', 'Denis Setiawan', '', '2', 'IKR', 'FTTH', 'Maintenance', 'denis.setiawan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(66, '2022120502', 'Adhi Kurniawan', '', '2', 'IKR', 'FTTH', 'Maintenance', 'adhi.kurniawan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(67, '2022120511', 'Zaki Maulana', '', '2', 'IKR', 'FTTH', 'Maintenance', 'zaki.maulana@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(68, '2021100322', 'Benni', '', '2', 'IKR', 'FTTH', 'Maintenance', 'benni@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(69, '2022050402', 'Kurnia Ramadhan Sitepu', '', '2', 'IKR', 'FTTH', 'Maintenance', 'kurnia.ramadhan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(70, '2023010525', 'Muhammad Rizky (MST)', '', '2', 'IKR', 'FTTH', 'Maintenance', 'rizky.muhammad@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(71, '2022080435', 'Dandy Riski Kurniawan', '', '2', 'IKR', 'FTTH', 'Maintenance', 'dandy.riski@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(72, '2022080443', 'Akbar Riza Sarjani', '', '2', 'IKR', 'FTTH', 'Maintenance', 'akbar.riza@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(73, '2022110481', 'Indra S.', '', '2', 'IKR', 'FTTH', 'Maintenance', 'indra.s@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(74, '2022100467', 'Muamar Khadafi', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'muamar.khadafi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(75, '2022120499', 'Rohmat', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'rohmat@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(76, '2022040379', 'Hilmi Haidar', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'hilmi.haidar@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(77, '2020120252', 'Nurdiansyah (IKR)', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'nurdiansyah@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(78, '2023010524', 'Ahmad Wildan', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'ahmad.wildan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(79, '2023020548', 'Tetra Sayekti Wibowo', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'tetra.sayekti@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(80, '2022040377', 'Edgar Danuvan Sihotang', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'edgar.danuvan@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(81, '2023050653', 'Prayoga Aditya', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'prayoga.aditya@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(82, '2023080722', 'Dendi Kusnadi', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'dendi.kusnadi@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(83, '2022040369', 'Nathanael Devon Agly Putra', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'nathanael.devon@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(84, '2023100737', 'Ady Kase', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'ady.kase@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL),
(85, '2023050652', 'Wahyu Aji Saputra', '', '2', 'IKR', 'Dismantle FTTH', 'Dismantle', 'wahyu.aji@misitel.co.id', 'aktif', 'foto-blank.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fats`
--

CREATE TABLE `fats` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_cluster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cluster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_fat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suspend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ms_regular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fats`
--

INSERT INTO `fats` (`id`, `kode_area`, `area`, `kode_cluster`, `cluster`, `hp`, `jml_fat`, `active`, `suspend`, `ms_regular`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'JKT', 'Jakarta Timur', 'CRS', 'Ciracas', '3072', '378', '1006', '100', 'Manage Service', '2', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(2, 'JKT', 'Jakarta Selatan', 'BNC', 'Buncit', '2320', '266', '634', '75', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(3, 'JKT', 'Jakarta Selatan', 'CLD', 'Cilandak', '4757', '552', '890', '86', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(4, 'JKT', 'Jakarta Selatan', 'JGK', 'Jagakarsa', '2005', '132', '882', '144', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(5, 'JKT', 'Jakarta Selatan', 'KBG', 'Kebagusan', '592', '47', '224', '29', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(6, 'JKT', 'Jakarta Selatan', 'KBY', 'Kebayoran', '607', '55', '23', '5', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(7, 'JKT', 'Jakarta Selatan', 'KBL', 'Kebayoran lama', '4872', '530', '1746', '181', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(8, 'JKT', 'Jakarta Selatan', 'KMG', 'Kemang', '4264', '477', '1126', '95', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(9, 'JKT', 'Jakarta Utara', 'PJN', 'Penjaringan', '392', '48', '61', '9', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(10, 'JKT', 'Jakarta Utara', 'TJP', 'Tanjung Priuk', '2504', '307', '331', '25', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(11, 'JKT', 'Jakarta Utara', 'PLT', 'Pluit', '4032', '503', '227', '13', 'Manage Service', '1', '2023-11-22 09:44:20', '2023-11-22 09:44:20'),
(12, 'JKT', 'Jakarta Pusat', 'KMY', 'Kemayoran', '0', '0', '0', '0', 'Manage Service', '1', '2023-11-22 18:12:49', '2023-11-22 18:12:49'),
(13, 'JKT', 'Jakarta Pusat', 'MNT', 'Menteng', '0', '0', '0', '0', 'Manage Service', '1', '2023-11-22 18:24:10', '2023-11-22 18:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_01_054756_create_employees_table', 1),
(6, '2023_10_26_062431_create_branches_table', 1),
(7, '2023_11_09_125927_create_callsign_leads_table', 2),
(8, '2023_11_09_125939_create_callsign_tims_table', 2),
(9, '2023_11_22_015928_create_fats_table', 3),
(10, '2023_11_22_140642_add_kode_branch_to_branches', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_nama_branch_unique` (`nama_branch`);

--
-- Indexes for table `callsign_leads`
--
ALTER TABLE `callsign_leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `callsign_leads_lead_callsign_unique` (`lead_callsign`);

--
-- Indexes for table `callsign_tims`
--
ALTER TABLE `callsign_tims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `callsign_tims_nik_tim2_unique` (`nik_tim2`),
  ADD UNIQUE KEY `callsign_tims_nik_tim3_unique` (`nik_tim3`),
  ADD UNIQUE KEY `callsign_tims_nik_tim4_unique` (`nik_tim4`),
  ADD UNIQUE KEY `callsign_tims_nik_tim1_unique` (`nik_tim1`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_nik_karyawan_unique` (`nik_karyawan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fats`
--
ALTER TABLE `fats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `callsign_leads`
--
ALTER TABLE `callsign_leads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `callsign_tims`
--
ALTER TABLE `callsign_tims`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fats`
--
ALTER TABLE `fats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
