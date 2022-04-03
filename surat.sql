-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 12:09 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `etbl_instansi`
--

CREATE TABLE `etbl_instansi` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode_kecamatan` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_instansi` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_instansi`
--

INSERT INTO `etbl_instansi` (`id`, `kode_provinsi`, `kode_kabupaten`, `kode_kecamatan`, `kode`, `nama_instansi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '04', '2435', '0739128', '87569130', 'Instansi I', '2022-03-14 01:45:45', '2022-03-14 01:45:45', NULL),
(2, '04', '2435', '0739128', '94578061', 'Instansi II', '2022-03-14 01:46:14', '2022-03-14 01:46:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_jabatan`
--

CREATE TABLE `etbl_jabatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_jabatan` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_jabatan`
--

INSERT INTO `etbl_jabatan` (`id`, `kode`, `nama_jabatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '75302614', 'Jabatan I', '2022-03-14 13:45:03', '2022-03-14 13:45:03', NULL),
(2, '59428610', 'Jabatan II', '2022-03-14 13:45:27', '2022-03-14 13:45:27', NULL),
(3, '65894317', 'Bendahara I', '2022-03-19 14:24:29', '2022-03-19 14:24:29', NULL),
(4, '59086172', 'Kepala Bidang I', '2022-03-19 14:24:42', '2022-03-19 14:24:42', NULL),
(5, '47018235', 'Bendahara II', '2022-03-19 14:24:54', '2022-03-19 14:25:14', NULL),
(6, '21347856', 'Kepala Bidang II', '2022-03-19 14:25:07', '2022-03-19 14:25:07', NULL),
(7, '63204871', 'Pegawai I', '2022-03-19 17:19:17', '2022-03-19 17:19:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_jenis_wilayah`
--

CREATE TABLE `etbl_jenis_wilayah` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `jenis_wilayah` varchar(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_jenis_wilayah`
--

INSERT INTO `etbl_jenis_wilayah` (`id`, `kode_provinsi`, `kode_kabupaten`, `kode`, `jenis_wilayah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '27', '0891', '48795260', 'Luar Kota', '2022-03-14 01:42:32', '2022-03-14 01:42:32', NULL),
(2, '04', '2435', '93701654', 'Dalam Kota', '2022-03-14 01:43:58', '2022-03-14 01:43:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_kabupaten`
--

CREATE TABLE `etbl_kabupaten` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_kabupaten` varchar(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_kabupaten`
--

INSERT INTO `etbl_kabupaten` (`id`, `kode_provinsi`, `kode`, `nama_kabupaten`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '27', '0891', 'Kab. Cilacap', '2022-03-14 01:42:06', '2022-03-14 01:42:06', NULL),
(2, '04', '2435', 'Kab Cirebon', '2022-03-14 01:43:27', '2022-03-14 01:43:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_kecamatan`
--

CREATE TABLE `etbl_kecamatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_kecamatan` varchar(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_kecamatan`
--

INSERT INTO `etbl_kecamatan` (`id`, `kode_kabupaten`, `kode`, `nama_kecamatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '0891', '7215368', 'Sidareja', '2022-03-14 01:42:20', '2022-03-14 01:42:20', NULL),
(2, '2435', '0739128', 'Kecamatan', '2022-03-14 01:43:41', '2022-03-14 01:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_kuitansi`
--

CREATE TABLE `etbl_kuitansi` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_spd` varchar(3) DEFAULT NULL,
  `pegawai_all` varchar(100) NOT NULL,
  `pegawai_diperintah` varchar(25) NOT NULL,
  `nip_pegawai` varchar(25) NOT NULL,
  `kode_pangol` varchar(20) NOT NULL,
  `kode_jabatan` varchar(20) NOT NULL,
  `untuk` varchar(50) NOT NULL,
  `kode_instansi` varchar(20) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `lama` int(2) NOT NULL,
  `kode_rekening` varchar(20) DEFAULT NULL,
  `pejabat` varchar(25) NOT NULL,
  `jumlah_uang` varchar(10) NOT NULL,
  `yang_menyetujui` varchar(25) DEFAULT NULL,
  `bendahara` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_kuitansi`
--

INSERT INTO `etbl_kuitansi` (`id`, `kode_spd`, `pegawai_all`, `pegawai_diperintah`, `nip_pegawai`, `kode_pangol`, `kode_jabatan`, `untuk`, `kode_instansi`, `awal`, `akhir`, `lama`, `kode_rekening`, `pejabat`, `jumlah_uang`, `yang_menyetujui`, `bendahara`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '345', '[\"123456789\",\"2342423423\"]', '123456789', '123456789', '23598401', '75302614', 'asdasdasdasd', '87569130', '2022-03-22', '2022-03-29', 7, '94718306', '238479238749', '3500000', '79878794565421', '456465465465', '2022-03-22 06:27:41', '2022-03-22 06:27:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_migrations`
--

CREATE TABLE `etbl_migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_migrations`
--

INSERT INTO `etbl_migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-02-20-053714', 'App\\Database\\Migrations\\Pangol', 'default', 'App', 1647240083, 1),
(2, '2022-02-21-203513', 'App\\Database\\Migrations\\Jabatan', 'default', 'App', 1647240083, 1),
(3, '2022-02-22-084649', 'App\\Database\\Migrations\\Provinsi', 'default', 'App', 1647240083, 1),
(4, '2022-02-22-084703', 'App\\Database\\Migrations\\Kabupaten', 'default', 'App', 1647240083, 1),
(5, '2022-02-22-084710', 'App\\Database\\Migrations\\Kecamatan', 'default', 'App', 1647240083, 1),
(6, '2022-02-22-084720', 'App\\Database\\Migrations\\Jeniswilayah', 'default', 'App', 1647240083, 1),
(7, '2022-02-22-084730', 'App\\Database\\Migrations\\Zonasi', 'default', 'App', 1647240084, 1),
(8, '2022-02-22-094747', 'App\\Database\\Migrations\\Wilayah', 'default', 'App', 1647240084, 1),
(9, '2022-02-24-202917', 'App\\Database\\Migrations\\Instansi', 'default', 'App', 1647240084, 1),
(10, '2022-02-26-083130', 'App\\Database\\Migrations\\Sbuh', 'default', 'App', 1647240084, 1),
(11, '2022-02-26-222239', 'App\\Database\\Migrations\\Rekening', 'default', 'App', 1647240084, 1),
(12, '2022-02-27-163742', 'App\\Database\\Migrations\\Pegawai', 'default', 'App', 1647240084, 1),
(25, '2022-03-07-094552', 'App\\Database\\Migrations\\Spt', 'default', 'App', 1647939408, 2),
(26, '2022-03-09-113700', 'App\\Database\\Migrations\\Spd', 'default', 'App', 1647939408, 2),
(27, '2022-03-14-223731', 'App\\Database\\Migrations\\Kuitansi', 'default', 'App', 1647939409, 2),
(30, '2022-03-20-112818', 'App\\Database\\Migrations\\Rincian', 'default', 'App', 1648982244, 3);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_pangol`
--

CREATE TABLE `etbl_pangol` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_pangol` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_pangol`
--

INSERT INTO `etbl_pangol` (`id`, `kode`, `nama_pangol`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '23598401', 'Golongan I', '2022-03-14 01:44:39', '2022-03-19 02:25:45', NULL),
(2, '01386479', 'Golongan II', '2022-03-14 01:44:50', '2022-03-19 02:25:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_pegawai`
--

CREATE TABLE `etbl_pegawai` (
  `id` int(10) UNSIGNED NOT NULL,
  `nip` varchar(25) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `kode_jabatan` varchar(20) NOT NULL,
  `kode_pangol` varchar(20) NOT NULL,
  `pelaksana` enum('Kasi Pelayan','Kasi Pengawasan') NOT NULL DEFAULT 'Kasi Pelayan',
  `foto` varchar(255) NOT NULL DEFAULT 'custom/img/foto/default.png',
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Kepala Bidang','Bendahara','Pegawai') NOT NULL DEFAULT 'Pegawai',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_pegawai`
--

INSERT INTO `etbl_pegawai` (`id`, `nip`, `nama`, `tgl_lahir`, `kode_jabatan`, `kode_pangol`, `pelaksana`, `foto`, `username`, `password`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123456789', 'Pegawai', '2022-03-14', '75302614', '23598401', 'Kasi Pelayan', '1647240493_67f703f24b354784abde.jpg', 'pegawai', '$2y$10$7cO5KabLTCM.UpN.rXftWuKG5.PG3u2T5Qfz5.vxNleTivuE9cMQy', 'Pegawai', '2022-03-14 01:48:13', '2022-03-19 02:39:21', NULL),
(2, '132132133', 'Admin', '2022-03-14', '59428610', '01386479', 'Kasi Pelayan', '1647240525_d5d7ea6abc1241a5cfba.jpg', 'admin', '$2y$10$h2nY3O.Nrih/dpUqrYFhkeX39vWoc052K4jTKAmTwMo58gXp/0TNC', 'Admin', '2022-03-14 01:48:45', '2022-03-19 02:38:57', NULL),
(3, '456465465465', 'Bendahara I', '2022-03-19', '65894317', '23598401', 'Kasi Pelayan', '1647675453_936248f5e19c8b43cf9e.png', 'bendahara', '$2y$10$.SKi3UeW5GuEEAUx0Rh8K.yB1OWX5zj9ORbHFr29CY0Hf.eSL4T9W', 'Bendahara', '2022-03-19 02:37:33', '2022-03-19 02:37:33', NULL),
(4, '79878794565421', 'Kepala Bidang I', '2022-03-19', '59086172', '01386479', 'Kasi Pengawasan', '1647675492_4af04b7867cd5226ce2f.jpg', 'kepala', '$2y$10$ajUSefPnDC0hAJ3FqHYIY.EqTp1F9CqfKPqrS.B.X2zNb.yQ/7j8W', 'Kepala Bidang', '2022-03-19 02:38:12', '2022-03-19 02:38:12', NULL),
(5, '2342423423', 'Antok Surohmat', '2022-03-19', '63204871', '23598401', 'Kasi Pelayan', '1647685214_41c21e6fbd6e0424a7fc.jpg', 'pegawai02', '$2y$10$wGNpUb9hoDvy9YdT6XwGwucSQAPKgkVsNMOgIXtTw0E./r3HzpZ0i', 'Pegawai', '2022-03-19 05:20:15', '2022-03-19 05:20:15', NULL),
(6, '908093824098230', 'Pegawai 03', '2022-03-19', '63204871', '23598401', 'Kasi Pelayan', '1647685246_b45cef7b2ec73e737690.jpg', 'pegawai03', '$2y$10$ee9jUlA3bwjFU9t0JIu.puEKpEkSXSPxyFHJUpIeSm4vd8ME.U5dy', 'Pegawai', '2022-03-19 05:20:46', '2022-03-19 05:20:46', NULL),
(7, '3465873456', 'Pegawai VI', '2022-03-19', '63204871', '23598401', 'Kasi Pelayan', '1647685287_b7e1144d809fcfca42ee.png', 'pegawai04', '$2y$10$oscVTZNc3urK8FOgaA4eT.pOMlBJtIbk8oxx6lqUX103x7tYlGq5m', 'Pegawai', '2022-03-19 05:21:27', '2022-03-19 05:21:27', NULL),
(8, '238479238749', 'Pegawai V', '2022-03-19', '63204871', '23598401', 'Kasi Pelayan', '1647685320_6dfcd74c746a691167dc.jpg', 'pegawai05', '$2y$10$58KAEos7mmD9RU7UNvXCUOl4IIxluUGgdf8rIM/cDCHNWlAX195yO', 'Pegawai', '2022-03-19 05:22:00', '2022-03-19 05:22:00', NULL),
(9, '764568347568347', 'Pegawai VI', '2022-03-19', '63204871', '23598401', 'Kasi Pelayan', '1647685354_a7b42044663a87450dab.jpg', 'pegawai06', '$2y$10$2qmO24D8IRY.8xIgqNha4OACiYaQKSgVIGe9FwZboO8uY58Apbj/K', 'Pegawai', '2022-03-19 05:22:34', '2022-03-19 05:22:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_provinsi`
--

CREATE TABLE `etbl_provinsi` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_provinsi` varchar(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_provinsi`
--

INSERT INTO `etbl_provinsi` (`id`, `kode`, `nama_provinsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '27', 'Jawa Tengah', '2022-03-14 01:41:50', '2022-03-14 01:41:50', NULL),
(2, '04', 'Jawa Barat', '2022-03-14 01:43:16', '2022-03-14 01:43:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_rekening`
--

CREATE TABLE `etbl_rekening` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `kode_jenis_wilayah` varchar(20) NOT NULL,
  `nomer_rekening` varchar(12) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_rekening`
--

INSERT INTO `etbl_rekening` (`id`, `kode`, `kode_jenis_wilayah`, `nomer_rekening`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '94718306', '93701654', '1234567890', '2022-03-14 01:47:10', '2022-03-14 01:47:10', NULL),
(2, '16320978', '48795260', '0987654321', '2022-03-14 01:47:30', '2022-03-14 01:47:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_rincian`
--

CREATE TABLE `etbl_rincian` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_spd` varchar(3) DEFAULT NULL,
  `rincian_sbuh` varchar(25) NOT NULL,
  `rincian_biaya` varchar(255) NOT NULL DEFAULT '["0"]',
  `jumlah_biaya` varchar(255) NOT NULL DEFAULT '["0"]',
  `bukti` longtext DEFAULT NULL,
  `jumlah_uang` varchar(8) NOT NULL,
  `keterangan_sbuh` varchar(50) NOT NULL,
  `jumlah_total` varchar(10) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `yang_menyetujui` varchar(25) DEFAULT NULL,
  `bendahara` varchar(25) NOT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '{}',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_rincian`
--

INSERT INTO `etbl_rincian` (`id`, `kode_spd`, `rincian_sbuh`, `rincian_biaya`, `jumlah_biaya`, `bukti`, `jumlah_uang`, `keterangan_sbuh`, `jumlah_total`, `awal`, `akhir`, `yang_menyetujui`, `bendahara`, `detail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '345', 'asdasdasdasd', '[\"0\"]', '[\"0\"]', NULL, '3500000', '', '3500000', '2022-03-22', '2022-03-29', '79878794565421', '456465465465', '[{\"rincian_biaya\":\"qweqweqw\",\"jumlah_biaya\":\"12312312\",\"bukti_riil\":\"03-04-2022/1648994008_e462a4bcb5ec08797ee7.png\"},{\"rincian_biaya\":\"aaaaa\",\"jumlah_biaya\":\"1111111\",\"bukti_riil\":\"03-04-2022/1648994008_5bc411ae85d84df4f3c1.png\"},{\"rincian_biaya\":\"vvvvvvv\",\"jumlah_biaya\":\"23222222\",\"bukti_riil\":\"03-04-2022/1648994008_43ba0320b02ff0526c4b.png\"},{\"rincian_biaya\":\"\",\"jumlah_biaya\":\"\",\"bukti_riil\":\"\"},{\"rincian_biaya\":\"\",\"jumlah_biaya\":\"\",\"bukti_riil\":\"\"}]', NULL, NULL, NULL),
(4, '345', 'asdasdasdasd', '[\"0\"]', '[\"0\"]', NULL, '3500000', '', '3500000', '2022-03-22', '2022-03-29', '79878794565421', '456465465465', '[{\"rincian_biaya\":\"aaaaa\",\"jumlah_biaya\":\"12345\",\"bukti_riil\":\"03-04-2022/1648994723_d3f60bbc2e85d5b96f62.png\"},{\"rincian_biaya\":\"bbbb\",\"jumlah_biaya\":\"5345\",\"bukti_riil\":\"03-04-2022/1648994723_1b99d1ac2732b2d4f96a.png\"},{\"rincian_biaya\":\"ccccccc\",\"jumlah_biaya\":\"676677\",\"bukti_riil\":\"03-04-2022/1648994723_900013709fd79b7a8084.png\"},{\"rincian_biaya\":\"\",\"jumlah_biaya\":\"\",\"bukti_riil\":\"\"},{\"rincian_biaya\":\"\",\"jumlah_biaya\":\"\",\"bukti_riil\":\"\"}]', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_sbuh`
--

CREATE TABLE `etbl_sbuh` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode_jenis_wilayah` varchar(20) NOT NULL,
  `kode_kecamatan` varchar(20) NOT NULL,
  `kode_zonasi` varchar(20) NOT NULL,
  `kode_pangol` varchar(20) NOT NULL,
  `jumlah_uang` varchar(6) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_sbuh`
--

INSERT INTO `etbl_sbuh` (`id`, `kode`, `kode_provinsi`, `kode_kabupaten`, `kode_jenis_wilayah`, `kode_kecamatan`, `kode_zonasi`, `kode_pangol`, `jumlah_uang`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '63127048', '04', '2435', '93701654', '0739128', '61028593', '23598401', '500000', '2022-03-14 01:46:36', '2022-03-14 01:46:36', NULL),
(2, '59073862', '27', '0891', '48795260', '7215368', '93612485', '01386479', '900000', '2022-03-14 01:46:51', '2022-03-14 01:46:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_spd`
--

CREATE TABLE `etbl_spd` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(3) DEFAULT NULL,
  `kode_spt` varchar(3) NOT NULL,
  `pejabat` varchar(25) NOT NULL,
  `pegawai_all` varchar(100) NOT NULL,
  `pegawai_diperintah` varchar(50) DEFAULT NULL,
  `tingkat_biaya` enum('Tingkat A','Tingkat B','Tinkat C') NOT NULL DEFAULT 'Tingkat A',
  `untuk` varchar(50) NOT NULL,
  `kode_instansi` varchar(20) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `lama` int(2) NOT NULL,
  `kode_rekening` varchar(20) DEFAULT NULL,
  `keterangan` varchar(20) DEFAULT NULL,
  `jenis_kendaraan` enum('Bus','Kapal','Kereta Api','Mobil Dinas','Motor Dinas','Pesawat') NOT NULL DEFAULT 'Bus',
  `status` enum('true','false') NOT NULL DEFAULT 'false',
  `yang_menyetujui` varchar(25) DEFAULT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_spd`
--

INSERT INTO `etbl_spd` (`id`, `kode`, `kode_spt`, `pejabat`, `pegawai_all`, `pegawai_diperintah`, `tingkat_biaya`, `untuk`, `kode_instansi`, `awal`, `akhir`, `lama`, `kode_rekening`, `keterangan`, `jenis_kendaraan`, `status`, `yang_menyetujui`, `detail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, '345', '789', '132132133', '[\"123456789\",\"2342423423\"]', '123456789', 'Tingkat A', 'asdasdasdasd', '87569130', '2022-03-22', '2022-03-29', 7, '94718306', 'sdfsdfsd', 'Kereta Api', 'true', '79878794565421', '{\"first\":{\"tibadi\":\"sdfsd\",\"tanggaltiba\":\"2022-03-23\",\"kepalatiba\":\"sdfsdfsdfsd\",\"berangkatdari\":\"sdfsdfs\",\"tujuan\":\"sdfsdfsd\",\"tanggalberangkat\":\"2022-03-23\",\"kepalaberangkat\":\"sdfsdf\"},\"second\":{\"tibadi\":\"\",\"tanggaltiba\":\"\",\"kepalatiba\":\"\",\"berangkatdari\":\"\",\"tujuan\":\"\",\"tanggalberangkat\":\"\",\"kepalaberangkat\":\"\"},\"third\":{\"tibadi\":\"\",\"tanggaltiba\":\"\",\"kepalatiba\":\"\",\"berangkatdari\":\"\",\"tujuan\":\"\",\"tanggalberangkat\":\"\",\"kepalaberangkat\":\"\"},\"fourth\":{\"tibadi\":\"\",\"tanggaltiba\":\"\",\"kepalatiba\":\"\",\"berangkatdari\":\"\",\"tujuan\":\"\",\"tanggalberangkat\":\"\",\"kepalaberangkat\":\"\"}}', '2022-03-22 04:35:25', '2022-03-22 04:35:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_spt`
--

CREATE TABLE `etbl_spt` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(3) NOT NULL,
  `pegawai_all` varchar(100) NOT NULL,
  `dasar` varchar(50) NOT NULL,
  `untuk` varchar(50) NOT NULL,
  `kode_instansi` varchar(20) NOT NULL,
  `alamat_instansi` varchar(50) NOT NULL,
  `awal` date NOT NULL,
  `akhir` date NOT NULL,
  `lama` int(2) NOT NULL,
  `pejabat` varchar(25) NOT NULL,
  `status` enum('Pending','Revisi','Disetujui') NOT NULL DEFAULT 'Pending',
  `keterangan` varchar(20) DEFAULT NULL,
  `yang_menyetujui` varchar(25) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_spt`
--

INSERT INTO `etbl_spt` (`id`, `kode`, `pegawai_all`, `dasar`, `untuk`, `kode_instansi`, `alamat_instansi`, `awal`, `akhir`, `lama`, `pejabat`, `status`, `keterangan`, `yang_menyetujui`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '789', '[\"123456789\",\"2342423423\"]', 'asdasdas', 'asdasdasdasd', '87569130', 'Kecamatan, Kab Cirebon, Jawa Barat', '2022-03-22', '2022-03-29', 7, '132132133', 'Disetujui', '', '79878794565421', '2022-03-22 04:09:11', '2022-03-22 04:35:25', NULL),
(2, '234', '[\"123456789\",\"238479238749\",\"764568347568347\"]', 'sadasd', 'asdasdasdasdas', '94578061', 'Kecamatan, Kab Cirebon, Jawa Barat', '2022-04-02', '2022-04-09', 7, '456465465465', 'Pending', NULL, NULL, '2022-04-02 06:08:47', '2022-04-02 06:08:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_wilayah`
--

CREATE TABLE `etbl_wilayah` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` bigint(20) NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode_jenis_wilayah` varchar(20) NOT NULL,
  `kode_kecamatan` varchar(20) NOT NULL,
  `kode_zonasi` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_wilayah`
--

INSERT INTO `etbl_wilayah` (`id`, `kode`, `kode_provinsi`, `kode_kabupaten`, `kode_jenis_wilayah`, `kode_kecamatan`, `kode_zonasi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13089754, '27', '0891', '48795260', '7215368', '93612485', '2022-03-14 01:43:06', '2022-03-14 01:43:06', NULL),
(2, 21869405, '04', '2435', '93701654', '0739128', '61028593', '2022-03-14 01:44:17', '2022-03-14 01:44:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etbl_zonasi`
--

CREATE TABLE `etbl_zonasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode_provinsi` varchar(20) NOT NULL,
  `kode_kabupaten` varchar(20) NOT NULL,
  `kode_kecamatan` varchar(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_zonasi` varchar(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etbl_zonasi`
--

INSERT INTO `etbl_zonasi` (`id`, `kode_provinsi`, `kode_kabupaten`, `kode_kecamatan`, `kode`, `nama_zonasi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '27', '0891', '7215368', '93612485', 'Zona I', '2022-03-14 01:42:44', '2022-03-14 01:42:44', NULL),
(2, '04', '2435', '0739128', '61028593', 'Zona II', '2022-03-14 01:44:11', '2022-03-14 01:44:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etbl_instansi`
--
ALTER TABLE `etbl_instansi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_instansi_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `etbl_instansi_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `etbl_instansi_kode_kecamatan_foreign` (`kode_kecamatan`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_jabatan`
--
ALTER TABLE `etbl_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_jenis_wilayah`
--
ALTER TABLE `etbl_jenis_wilayah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_jenis_wilayah_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `etbl_jenis_wilayah_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_kabupaten`
--
ALTER TABLE `etbl_kabupaten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_kabupaten_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_kecamatan`
--
ALTER TABLE `etbl_kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_kecamatan_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_kuitansi`
--
ALTER TABLE `etbl_kuitansi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_kuitansi_kode_spd_foreign` (`kode_spd`),
  ADD KEY `etbl_kuitansi_kode_instansi_foreign` (`kode_instansi`),
  ADD KEY `etbl_kuitansi_pejabat_foreign` (`pejabat`),
  ADD KEY `etbl_kuitansi_kode_rekening_foreign` (`kode_rekening`);

--
-- Indexes for table `etbl_migrations`
--
ALTER TABLE `etbl_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `etbl_pangol`
--
ALTER TABLE `etbl_pangol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_pegawai`
--
ALTER TABLE `etbl_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `etbl_pegawai_kode_jabatan_foreign` (`kode_jabatan`),
  ADD KEY `etbl_pegawai_kode_pangol_foreign` (`kode_pangol`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `etbl_provinsi`
--
ALTER TABLE `etbl_provinsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_rekening`
--
ALTER TABLE `etbl_rekening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_rekening_kode_jenis_wilayah_foreign` (`kode_jenis_wilayah`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_rincian`
--
ALTER TABLE `etbl_rincian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_rincian_kode_spd_foreign` (`kode_spd`);

--
-- Indexes for table `etbl_sbuh`
--
ALTER TABLE `etbl_sbuh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_sbuh_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `etbl_sbuh_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `etbl_sbuh_kode_jenis_wilayah_foreign` (`kode_jenis_wilayah`),
  ADD KEY `etbl_sbuh_kode_kecamatan_foreign` (`kode_kecamatan`),
  ADD KEY `etbl_sbuh_kode_zonasi_foreign` (`kode_zonasi`),
  ADD KEY `etbl_sbuh_kode_pangol_foreign` (`kode_pangol`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_spd`
--
ALTER TABLE `etbl_spd`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `etbl_spd_kode_spt_foreign` (`kode_spt`),
  ADD KEY `etbl_spd_kode_instansi_foreign` (`kode_instansi`),
  ADD KEY `etbl_spd_pejabat_foreign` (`pejabat`),
  ADD KEY `etbl_spd_kode_rekening_foreign` (`kode_rekening`);

--
-- Indexes for table `etbl_spt`
--
ALTER TABLE `etbl_spt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `etbl_spt_kode_instansi_foreign` (`kode_instansi`),
  ADD KEY `etbl_spt_pejabat_foreign` (`pejabat`);

--
-- Indexes for table `etbl_wilayah`
--
ALTER TABLE `etbl_wilayah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_wilayah_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `etbl_wilayah_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `etbl_wilayah_kode_jenis_wilayah_foreign` (`kode_jenis_wilayah`),
  ADD KEY `etbl_wilayah_kode_kecamatan_foreign` (`kode_kecamatan`),
  ADD KEY `etbl_wilayah_kode_zonasi_foreign` (`kode_zonasi`),
  ADD KEY `kode` (`kode`);

--
-- Indexes for table `etbl_zonasi`
--
ALTER TABLE `etbl_zonasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etbl_zonasi_kode_provinsi_foreign` (`kode_provinsi`),
  ADD KEY `etbl_zonasi_kode_kabupaten_foreign` (`kode_kabupaten`),
  ADD KEY `etbl_zonasi_kode_kecamatan_foreign` (`kode_kecamatan`),
  ADD KEY `kode` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etbl_instansi`
--
ALTER TABLE `etbl_instansi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_jabatan`
--
ALTER TABLE `etbl_jabatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `etbl_jenis_wilayah`
--
ALTER TABLE `etbl_jenis_wilayah`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_kabupaten`
--
ALTER TABLE `etbl_kabupaten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_kecamatan`
--
ALTER TABLE `etbl_kecamatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_kuitansi`
--
ALTER TABLE `etbl_kuitansi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `etbl_migrations`
--
ALTER TABLE `etbl_migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `etbl_pangol`
--
ALTER TABLE `etbl_pangol`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_pegawai`
--
ALTER TABLE `etbl_pegawai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `etbl_provinsi`
--
ALTER TABLE `etbl_provinsi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_rekening`
--
ALTER TABLE `etbl_rekening`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_rincian`
--
ALTER TABLE `etbl_rincian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `etbl_sbuh`
--
ALTER TABLE `etbl_sbuh`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_spd`
--
ALTER TABLE `etbl_spd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `etbl_spt`
--
ALTER TABLE `etbl_spt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_wilayah`
--
ALTER TABLE `etbl_wilayah`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `etbl_zonasi`
--
ALTER TABLE `etbl_zonasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `etbl_instansi`
--
ALTER TABLE `etbl_instansi`
  ADD CONSTRAINT `etbl_instansi_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`),
  ADD CONSTRAINT `etbl_instansi_kode_kecamatan_foreign` FOREIGN KEY (`kode_kecamatan`) REFERENCES `etbl_kecamatan` (`kode`),
  ADD CONSTRAINT `etbl_instansi_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`);

--
-- Constraints for table `etbl_jenis_wilayah`
--
ALTER TABLE `etbl_jenis_wilayah`
  ADD CONSTRAINT `etbl_jenis_wilayah_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`),
  ADD CONSTRAINT `etbl_jenis_wilayah_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`);

--
-- Constraints for table `etbl_kabupaten`
--
ALTER TABLE `etbl_kabupaten`
  ADD CONSTRAINT `etbl_kabupaten_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`);

--
-- Constraints for table `etbl_kecamatan`
--
ALTER TABLE `etbl_kecamatan`
  ADD CONSTRAINT `etbl_kecamatan_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`);

--
-- Constraints for table `etbl_kuitansi`
--
ALTER TABLE `etbl_kuitansi`
  ADD CONSTRAINT `etbl_kuitansi_kode_instansi_foreign` FOREIGN KEY (`kode_instansi`) REFERENCES `etbl_instansi` (`kode`),
  ADD CONSTRAINT `etbl_kuitansi_kode_rekening_foreign` FOREIGN KEY (`kode_rekening`) REFERENCES `etbl_rekening` (`kode`),
  ADD CONSTRAINT `etbl_kuitansi_kode_spd_foreign` FOREIGN KEY (`kode_spd`) REFERENCES `etbl_spd` (`kode`),
  ADD CONSTRAINT `etbl_kuitansi_pejabat_foreign` FOREIGN KEY (`pejabat`) REFERENCES `etbl_pegawai` (`nip`);

--
-- Constraints for table `etbl_pegawai`
--
ALTER TABLE `etbl_pegawai`
  ADD CONSTRAINT `etbl_pegawai_kode_jabatan_foreign` FOREIGN KEY (`kode_jabatan`) REFERENCES `etbl_jabatan` (`kode`),
  ADD CONSTRAINT `etbl_pegawai_kode_pangol_foreign` FOREIGN KEY (`kode_pangol`) REFERENCES `etbl_pangol` (`kode`);

--
-- Constraints for table `etbl_rekening`
--
ALTER TABLE `etbl_rekening`
  ADD CONSTRAINT `etbl_rekening_kode_jenis_wilayah_foreign` FOREIGN KEY (`kode_jenis_wilayah`) REFERENCES `etbl_jenis_wilayah` (`kode`);

--
-- Constraints for table `etbl_rincian`
--
ALTER TABLE `etbl_rincian`
  ADD CONSTRAINT `etbl_rincian_kode_spd_foreign` FOREIGN KEY (`kode_spd`) REFERENCES `etbl_spd` (`kode`);

--
-- Constraints for table `etbl_sbuh`
--
ALTER TABLE `etbl_sbuh`
  ADD CONSTRAINT `etbl_sbuh_kode_jenis_wilayah_foreign` FOREIGN KEY (`kode_jenis_wilayah`) REFERENCES `etbl_jenis_wilayah` (`kode`),
  ADD CONSTRAINT `etbl_sbuh_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`),
  ADD CONSTRAINT `etbl_sbuh_kode_kecamatan_foreign` FOREIGN KEY (`kode_kecamatan`) REFERENCES `etbl_kecamatan` (`kode`),
  ADD CONSTRAINT `etbl_sbuh_kode_pangol_foreign` FOREIGN KEY (`kode_pangol`) REFERENCES `etbl_pangol` (`kode`),
  ADD CONSTRAINT `etbl_sbuh_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`),
  ADD CONSTRAINT `etbl_sbuh_kode_zonasi_foreign` FOREIGN KEY (`kode_zonasi`) REFERENCES `etbl_zonasi` (`kode`);

--
-- Constraints for table `etbl_spd`
--
ALTER TABLE `etbl_spd`
  ADD CONSTRAINT `etbl_spd_kode_instansi_foreign` FOREIGN KEY (`kode_instansi`) REFERENCES `etbl_instansi` (`kode`),
  ADD CONSTRAINT `etbl_spd_kode_rekening_foreign` FOREIGN KEY (`kode_rekening`) REFERENCES `etbl_rekening` (`kode`),
  ADD CONSTRAINT `etbl_spd_kode_spt_foreign` FOREIGN KEY (`kode_spt`) REFERENCES `etbl_spt` (`kode`),
  ADD CONSTRAINT `etbl_spd_pejabat_foreign` FOREIGN KEY (`pejabat`) REFERENCES `etbl_pegawai` (`nip`);

--
-- Constraints for table `etbl_spt`
--
ALTER TABLE `etbl_spt`
  ADD CONSTRAINT `etbl_spt_kode_instansi_foreign` FOREIGN KEY (`kode_instansi`) REFERENCES `etbl_instansi` (`kode`),
  ADD CONSTRAINT `etbl_spt_pejabat_foreign` FOREIGN KEY (`pejabat`) REFERENCES `etbl_pegawai` (`nip`);

--
-- Constraints for table `etbl_wilayah`
--
ALTER TABLE `etbl_wilayah`
  ADD CONSTRAINT `etbl_wilayah_kode_jenis_wilayah_foreign` FOREIGN KEY (`kode_jenis_wilayah`) REFERENCES `etbl_jenis_wilayah` (`kode`),
  ADD CONSTRAINT `etbl_wilayah_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`),
  ADD CONSTRAINT `etbl_wilayah_kode_kecamatan_foreign` FOREIGN KEY (`kode_kecamatan`) REFERENCES `etbl_kecamatan` (`kode`),
  ADD CONSTRAINT `etbl_wilayah_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`),
  ADD CONSTRAINT `etbl_wilayah_kode_zonasi_foreign` FOREIGN KEY (`kode_zonasi`) REFERENCES `etbl_zonasi` (`kode`);

--
-- Constraints for table `etbl_zonasi`
--
ALTER TABLE `etbl_zonasi`
  ADD CONSTRAINT `etbl_zonasi_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `etbl_kabupaten` (`kode`),
  ADD CONSTRAINT `etbl_zonasi_kode_kecamatan_foreign` FOREIGN KEY (`kode_kecamatan`) REFERENCES `etbl_kecamatan` (`kode`),
  ADD CONSTRAINT `etbl_zonasi_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `etbl_provinsi` (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
