-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2018 at 10:52 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_mks`
--

-- --------------------------------------------------------

--
-- Table structure for table `t01_master_sekolah`
--

CREATE TABLE IF NOT EXISTS `t01_master_sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_stat` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `alamat1` varchar(50) NOT NULL,
  `alamat2` varchar(50) NOT NULL,
  `desa` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t01_master_sekolah`
--

INSERT INTO `t01_master_sekolah` (`id`, `no_stat`, `nama`, `status`, `alamat1`, `alamat2`, `desa`, `kecamatan`, `kabupaten`, `provinsi`) VALUES
(1, '123456789012', '[Nama Sekolah]', '[Status Sekolah]', '[Alamat_1]', '[Alamat 2]', '[Desa]', '[Kecamatan]', '[Kabupaten]', '[Provinsi]');

-- --------------------------------------------------------

--
-- Table structure for table `t02_rkas`
--

CREATE TABLE IF NOT EXISTS `t02_rkas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lvl` tinyint(4) NOT NULL,
  `urutan` smallint(6) NOT NULL,
  `nour1` varchar(10) DEFAULT NULL,
  `ket1` varchar(50) DEFAULT NULL,
  `jml1` float(15,2) DEFAULT '0.00',
  `nour2` varchar(10) DEFAULT NULL,
  `ket2` varchar(50) DEFAULT NULL,
  `jml2` float(15,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t02_rkas`
--

INSERT INTO `t02_rkas` (`id`, `lvl`, `urutan`, `nour1`, `ket1`, `jml1`, `nour2`, `ket2`, `jml2`) VALUES
(1, 1, 1, '1.', 'Sumber Dana', 0.00, '1.', 'Penggunaan', 0.00),
(2, 2, 2, '1.1.', 'Dana Rutin', 0.00, '2.1.', 'Dana Rutin', 0.00),
(3, 3, 3, '1.1.1.', 'Gaji', 0.00, NULL, NULL, 0.00),
(4, 3, 4, '1.1.2.', 'Tunjangan Profesi', 0.00, NULL, NULL, 0.00),
(5, 3, 5, '1.1.3.', 'Kesra', 0.00, NULL, NULL, 0.00),
(6, 2, 6, '1.2.', 'Dana Bantuan', 0.00, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `t02_rkas01`
--

CREATE TABLE IF NOT EXISTS `t02_rkas01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` tinyint(4) NOT NULL DEFAULT '0',
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t02_rkas01`
--

INSERT INTO `t02_rkas01` (`id`, `no_urut`, `keterangan`, `jumlah`) VALUES
(1, 1, 'Sumber Dana', 0.00),
(2, 2, 'Penggunaan', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `t03_rkas02`
--

CREATE TABLE IF NOT EXISTS `t03_rkas02` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` tinyint(4) NOT NULL DEFAULT '0',
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `lv1_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `t03_rkas02`
--

INSERT INTO `t03_rkas02` (`id`, `no_urut`, `keterangan`, `jumlah`, `lv1_id`) VALUES
(1, 1, 'Dana Rutin', 0.00, 1),
(2, 2, 'Dana Bantuan', 0.00, 1),
(3, 3, 'Dana Komite', 0.00, 1),
(4, 4, 'Dana Hibah', 0.00, 1),
(5, 5, 'Dana DAK', 0.00, 1),
(6, 1, 'Dana Rutin', 0.00, 2),
(7, 2, 'Dana Bantuan', 0.00, 2),
(8, 3, 'Dana Komite', 0.00, 2),
(9, 4, 'Dana Hibah', 0.00, 2),
(10, 5, 'Dana DAK', 0.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t04_rkas03`
--

CREATE TABLE IF NOT EXISTS `t04_rkas03` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` tinyint(4) NOT NULL DEFAULT '0',
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `lv2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `t04_rkas03`
--

INSERT INTO `t04_rkas03` (`id`, `no_urut`, `keterangan`, `jumlah`, `lv2_id`) VALUES
(1, 1, 'Gaji', 0.00, 1),
(2, 2, 'Tunjangan Profesi', 0.00, 1),
(3, 3, 'Kesra', 0.00, 1),
(4, 1, 'Dana BOS', 0.00, 2),
(5, 2, 'Dana DOS', 0.00, 2),
(6, 1, 'Gaji Guru / Pegawai', 0.00, 6),
(7, 2, 'Tunjangan Profesional Guru', 0.00, 6),
(8, 3, 'Kesra Guru / Pegawai', 0.00, 6),
(9, 1, 'Dana BOS', 0.00, 7),
(10, 2, 'Dana DOS', 0.00, 7),
(11, 1, 'Pembiayaan Perawatan', 0.00, 8),
(12, 2, 'Honorarium GTT', 0.00, 8),
(13, 3, 'Penembokan Batas Halaman Sekolah', 0.00, 8),
(14, 4, 'Pembangunan Mushalla Sekolah', 0.00, 8),
(15, 5, 'Lain-lain', 0.00, 8),
(16, 1, 'Pembelian Bahan Bangunan', 0.00, 10),
(17, 2, 'Ongkos Tukang', 0.00, 10),
(18, 3, 'Pembiayaan Laporan', 0.00, 10),
(19, 4, 'Pajak', 0.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `t05_rkas04`
--

CREATE TABLE IF NOT EXISTS `t05_rkas04` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` tinyint(4) NOT NULL DEFAULT '0',
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `lv3_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `t05_rkas04`
--

INSERT INTO `t05_rkas04` (`id`, `no_urut`, `keterangan`, `jumlah`, `lv3_id`) VALUES
(1, 1, 'Pembiayaan Penerimaan Siswa Baru', 0.00, 9),
(2, 2, 'Pembelian Buku Perpustakaan', 0.00, 9),
(3, 3, 'Pembelian Buku Pelajaran', 0.00, 9),
(4, 4, 'Pembiayaan Remidial (Ekstrakurikuler)', 0.00, 9),
(5, 5, 'Pembiayaan Ulangan Semester dan UAS/UASBN', 0.00, 9),
(6, 6, 'Pembiayaan Bahan Habis Pakai (ATK)', 0.00, 9),
(7, 7, 'Pembiayaan Langganan Daya & Jasa', 0.00, 9),
(8, 8, 'Pembiayaan Perawatan', 0.00, 9),
(9, 9, 'Pembiayaan Honorarium GTT', 0.00, 9),
(10, 10, 'Pengembangan Profesi Guru', 0.00, 9),
(11, 11, 'Bantuan Transportasi Siswa Miskin', 0.00, 9),
(12, 12, 'Pembiayaan Pengolahan & BOS', 0.00, 9),
(13, 13, 'Pembelian Komputer', 0.00, 9),
(14, 14, 'Pembelian ABP & Lain-lain', 0.00, 9),
(15, 15, 'Pengeluaran Pajak', 0.00, 9),
(16, 1, 'Pelaksanaan Pelajaran', 0.00, 10),
(17, 2, 'TU Sekolah', 0.00, 10),
(18, 3, 'Belajar Barang', 0.00, 10),
(19, 4, 'Pendataan / Pelaporan Sekolah', 0.00, 10),
(20, 5, 'Honor Guru / Pegawai', 0.00, 10),
(21, 6, 'Transport', 0.00, 10),
(22, 7, 'Lain-lain', 0.00, 10),
(23, 8, 'Pajak', 0.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `t94_rkas1`
--

CREATE TABLE IF NOT EXISTS `t94_rkas1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` varchar(12) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `no_keyfield` varchar(8) NOT NULL,
  `no_level` tinyint(4) NOT NULL,
  `nama_tabel` varchar(10) NOT NULL,
  `id_data` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `t94_rkas1`
--

INSERT INTO `t94_rkas1` (`id`, `no_urut`, `keterangan`, `jumlah`, `no_keyfield`, `no_level`, `nama_tabel`, `id_data`) VALUES
(1, '1.', 'Sumber Dana', 0.00, '01000000', 1, 't02_rkas01', 1),
(2, '1.1.', 'Dana Rutin', 0.00, '01010000', 2, 't03_rkas02', 1),
(3, '1.1.1.', 'Gaji', 0.00, '01010100', 3, 't04_rkas03', 1),
(4, '1.1.2.', 'Tunjangan Profesi', 0.00, '01010200', 3, 't04_rkas03', 2),
(5, '1.1.3.', 'Kesra', 0.00, '01010300', 3, 't04_rkas03', 3),
(6, '1.2.', 'Dana Bantuan', 0.00, '01020000', 2, 't03_rkas02', 2),
(7, '1.2.1.', 'Dana BOS', 0.00, '01020100', 3, 't04_rkas03', 4),
(8, '1.2.2.', 'Dana DOS', 0.00, '01020200', 3, 't04_rkas03', 5),
(9, '1.3.', 'Dana Komite', 0.00, '01030000', 2, 't03_rkas02', 3),
(10, '1.4.', 'Dana Hibah', 0.00, '01040000', 2, 't03_rkas02', 4),
(11, '1.5.', 'Dana DAK', 0.00, '01050000', 2, 't03_rkas02', 5);

-- --------------------------------------------------------

--
-- Table structure for table `t95_rkas2`
--

CREATE TABLE IF NOT EXISTS `t95_rkas2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_urut` varchar(12) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `no_keyfield` varchar(8) NOT NULL,
  `no_level` tinyint(4) NOT NULL,
  `nama_tabel` varchar(10) NOT NULL,
  `id_data` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `t95_rkas2`
--

INSERT INTO `t95_rkas2` (`id`, `no_urut`, `keterangan`, `jumlah`, `no_keyfield`, `no_level`, `nama_tabel`, `id_data`) VALUES
(1, '2.', 'Penggunaan', 0.00, '01000000', 1, 't02_rkas01', 2),
(2, '2.1.', 'Dana Rutin', 0.00, '01010000', 2, 't03_rkas02', 6),
(3, '2.1.1.', 'Gaji Guru / Pegawai', 0.00, '01010100', 3, 't04_rkas03', 6),
(4, '2.1.2.', 'Tunjangan Profesional Guru', 0.00, '01010200', 3, 't04_rkas03', 7),
(5, '2.1.3.', 'Kesra Guru / Pegawai', 0.00, '01010300', 3, 't04_rkas03', 8),
(6, '2.2.', 'Dana Bantuan', 0.00, '01020000', 2, 't03_rkas02', 7),
(7, '2.2.1.', 'Dana BOS', 0.00, '01020100', 3, 't04_rkas03', 9),
(8, '2.2.1.1.', 'Pembiayaan Penerimaan Siswa Baru', 0.00, '01020101', 4, 't05_rkas04', 1),
(9, '2.2.1.2.', 'Pembelian Buku Perpustakaan', 0.00, '01020102', 4, 't05_rkas04', 2),
(10, '2.2.1.3.', 'Pembelian Buku Pelajaran', 0.00, '01020103', 4, 't05_rkas04', 3),
(11, '2.2.1.4.', 'Pembiayaan Remidial (Ekstrakurikuler)', 0.00, '01020104', 4, 't05_rkas04', 4),
(12, '2.2.1.5.', 'Pembiayaan Ulangan Semester dan UAS/UASBN', 0.00, '01020105', 4, 't05_rkas04', 5),
(13, '2.2.1.6.', 'Pembiayaan Bahan Habis Pakai (ATK)', 0.00, '01020106', 4, 't05_rkas04', 6),
(14, '2.2.1.7.', 'Pembiayaan Langganan Daya & Jasa', 0.00, '01020107', 4, 't05_rkas04', 7),
(15, '2.2.1.8.', 'Pembiayaan Perawatan', 0.00, '01020108', 4, 't05_rkas04', 8),
(16, '2.2.1.9.', 'Pembiayaan Honorarium GTT', 0.00, '01020109', 4, 't05_rkas04', 9),
(17, '2.2.1.10.', 'Pengembangan Profesi Guru', 0.00, '01020110', 4, 't05_rkas04', 10),
(18, '2.2.1.11.', 'Bantuan Transportasi Siswa Miskin', 0.00, '01020111', 4, 't05_rkas04', 11),
(19, '2.2.1.12.', 'Pembiayaan Pengolahan & BOS', 0.00, '01020112', 4, 't05_rkas04', 12),
(20, '2.2.1.13.', 'Pembelian Komputer', 0.00, '01020113', 4, 't05_rkas04', 13),
(21, '2.2.1.14.', 'Pembelian ABP & Lain-lain', 0.00, '01020114', 4, 't05_rkas04', 14),
(22, '2.2.1.15.', 'Pengeluaran Pajak', 0.00, '01020115', 4, 't05_rkas04', 15),
(23, '2.2.2.', 'Dana DOS', 0.00, '01020200', 3, 't04_rkas03', 10),
(24, '2.2.2.1.', 'Pelaksanaan Pelajaran', 0.00, '01020201', 4, 't05_rkas04', 16),
(25, '2.2.2.2.', 'TU Sekolah', 0.00, '01020202', 4, 't05_rkas04', 17),
(26, '2.2.2.3.', 'Belajar Barang', 0.00, '01020203', 4, 't05_rkas04', 18),
(27, '2.2.2.4.', 'Pendataan / Pelaporan Sekolah', 0.00, '01020204', 4, 't05_rkas04', 19),
(28, '2.2.2.5.', 'Honor Guru / Pegawai', 0.00, '01020205', 4, 't05_rkas04', 20),
(29, '2.2.2.6.', 'Transport', 0.00, '01020206', 4, 't05_rkas04', 21),
(30, '2.2.2.7.', 'Lain-lain', 0.00, '01020207', 4, 't05_rkas04', 22),
(31, '2.2.2.8.', 'Pajak', 0.00, '01020208', 4, 't05_rkas04', 23),
(32, '2.3.', 'Dana Komite', 0.00, '01030000', 2, 't03_rkas02', 8),
(33, '2.3.1.', 'Pembiayaan Perawatan', 0.00, '01030100', 3, 't04_rkas03', 11),
(34, '2.3.2.', 'Honorarium GTT', 0.00, '01030200', 3, 't04_rkas03', 12),
(35, '2.3.3.', 'Penembokan Batas Halaman Sekolah', 0.00, '01030300', 3, 't04_rkas03', 13),
(36, '2.3.4.', 'Pembangunan Mushalla Sekolah', 0.00, '01030400', 3, 't04_rkas03', 14),
(37, '2.3.5.', 'Lain-lain', 0.00, '01030500', 3, 't04_rkas03', 15),
(38, '2.4.', 'Dana Hibah', 0.00, '01040000', 2, 't03_rkas02', 9),
(39, '2.5.', 'Dana DAK', 0.00, '01050000', 2, 't03_rkas02', 10),
(40, '2.5.1.', 'Pembelian Bahan Bangunan', 0.00, '01050100', 3, 't04_rkas03', 16),
(41, '2.5.2.', 'Ongkos Tukang', 0.00, '01050200', 3, 't04_rkas03', 17),
(42, '2.5.3.', 'Pembiayaan Laporan', 0.00, '01050300', 3, 't04_rkas03', 18),
(43, '2.5.4.', 'Pajak', 0.00, '01050400', 3, 't04_rkas03', 19);

-- --------------------------------------------------------

--
-- Table structure for table `t96_employees`
--

CREATE TABLE IF NOT EXISTS `t96_employees` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `LastName` varchar(20) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `TitleOfCourtesy` varchar(25) DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `City` varchar(15) DEFAULT NULL,
  `Region` varchar(15) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(24) DEFAULT NULL,
  `Extension` varchar(4) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Notes` longtext,
  `ReportsTo` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL DEFAULT '',
  `UserLevel` int(11) DEFAULT NULL,
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `Profile` longtext,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t96_employees`
--

INSERT INTO `t96_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t97_userlevels`
--

CREATE TABLE IF NOT EXISTS `t97_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t97_userlevels`
--

INSERT INTO `t97_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `t98_userlevelpermissions`
--

CREATE TABLE IF NOT EXISTS `t98_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t98_userlevelpermissions`
--

INSERT INTO `t98_userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}cf01_home.php', 111),
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t01_master_sekolah', 0),
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t96_employees', 0),
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t97_userlevels', 0),
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t98_userlevelpermissions', 0),
(-2, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t99_audit_trail', 0),
(0, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t01_master_sekolah', 0),
(0, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t96_employees', 0),
(0, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t97_userlevels', 0),
(0, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t98_userlevelpermissions', 0),
(0, '{EC8C353E-21D9-43CE-9845-66794CB3C5CD}t99_audit_trail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t99_audit_trail`
--

CREATE TABLE IF NOT EXISTS `t99_audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=437 ;

--
-- Dumping data for table `t99_audit_trail`
--

INSERT INTO `t99_audit_trail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2018-03-19 22:42:00', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '2018-03-19 22:49:24', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(3, '2018-03-19 22:49:45', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(4, '2018-03-19 22:50:15', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(5, '2018-03-19 22:51:27', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(6, '2018-03-19 22:55:44', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(7, '2018-03-19 22:56:33', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(8, '2018-03-19 23:05:18', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(9, '2018-03-19 23:05:33', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(10, '2018-03-19 23:25:03', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(11, '2018-03-20 08:54:04', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(12, '2018-03-22 09:42:39', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(13, '2018-03-22 12:10:17', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(14, '2018-03-22 12:10:30', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(15, '2018-03-22 12:10:48', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'keterangan', '1', '', 'Sumber Dana'),
(16, '2018-03-22 12:10:48', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'jumlah', '1', '', '0'),
(17, '2018-03-22 12:10:48', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'id', '1', '', '1'),
(18, '2018-03-22 12:10:59', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'keterangan', '2', '', 'Penggunaan'),
(19, '2018-03-22 12:10:59', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'jumlah', '2', '', '0'),
(20, '2018-03-22 12:10:59', '/mks/t02_rkas01add.php', '1', 'A', 't02_rkas01', 'id', '2', '', '2'),
(21, '2018-03-22 12:17:52', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(22, '2018-03-22 12:17:59', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(23, '2018-03-22 12:19:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '1', '', '1'),
(24, '2018-03-22 12:19:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '1', '', 'Dana Rutin'),
(25, '2018-03-22 12:19:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '1', '', '0'),
(26, '2018-03-22 12:19:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '1', '', '1'),
(27, '2018-03-22 12:20:00', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '2', '', '1'),
(28, '2018-03-22 12:20:00', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '2', '', 'Dana Bantuan'),
(29, '2018-03-22 12:20:00', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '2', '', '0'),
(30, '2018-03-22 12:20:00', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '2', '', '2'),
(31, '2018-03-22 12:20:18', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '3', '', '1'),
(32, '2018-03-22 12:20:18', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '3', '', 'Dana Komite'),
(33, '2018-03-22 12:20:18', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '3', '', '0'),
(34, '2018-03-22 12:20:18', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '3', '', '3'),
(35, '2018-03-22 12:20:30', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '4', '', '1'),
(36, '2018-03-22 12:20:30', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '4', '', 'Dana Hibah'),
(37, '2018-03-22 12:20:30', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '4', '', '0'),
(38, '2018-03-22 12:20:30', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '4', '', '4'),
(39, '2018-03-22 12:20:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '5', '', '1'),
(40, '2018-03-22 12:20:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '5', '', 'Dana DAK'),
(41, '2018-03-22 12:20:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '5', '', '0'),
(42, '2018-03-22 12:20:42', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '5', '', '5'),
(43, '2018-03-22 12:20:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '6', '', '2'),
(44, '2018-03-22 12:20:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '6', '', 'Dana Rutin'),
(45, '2018-03-22 12:20:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '6', '', '0'),
(46, '2018-03-22 12:20:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '6', '', '6'),
(47, '2018-03-22 12:21:15', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '7', '', '2'),
(48, '2018-03-22 12:21:15', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '7', '', 'Dana Bantuan'),
(49, '2018-03-22 12:21:15', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '7', '', '0'),
(50, '2018-03-22 12:21:15', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '7', '', '7'),
(51, '2018-03-22 12:21:34', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '8', '', '2'),
(52, '2018-03-22 12:21:34', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '8', '', 'Dana Komite'),
(53, '2018-03-22 12:21:34', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '8', '', '0'),
(54, '2018-03-22 12:21:34', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '8', '', '8'),
(55, '2018-03-22 12:21:45', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '9', '', '2'),
(56, '2018-03-22 12:21:45', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '9', '', 'Dana Hibah'),
(57, '2018-03-22 12:21:45', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '9', '', '0'),
(58, '2018-03-22 12:21:45', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '9', '', '9'),
(59, '2018-03-22 12:21:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'lv1_id', '10', '', '2'),
(60, '2018-03-22 12:21:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'keterangan', '10', '', 'Dana DAK'),
(61, '2018-03-22 12:21:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'jumlah', '10', '', '0'),
(62, '2018-03-22 12:21:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '10', '', '10'),
(63, '2018-03-22 16:50:11', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(64, '2018-03-22 17:05:42', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(65, '2018-03-22 17:05:45', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(66, '2018-03-22 17:50:58', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(67, '2018-03-22 17:51:02', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(68, '2018-03-22 18:30:41', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '1', '0', '1'),
(69, '2018-03-22 18:30:58', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '2', '0', '2'),
(70, '2018-03-22 18:47:54', '/mks/t02_rkas01edit.php', '1', 'U', 't02_rkas01', 'no_urut', '1', '0', '1'),
(71, '2018-03-22 18:48:04', '/mks/t02_rkas01edit.php', '1', 'U', 't02_rkas01', 'no_urut', '2', '0', '2'),
(72, '2018-03-22 18:48:40', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '3', '0', '3'),
(73, '2018-03-22 18:48:58', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '4', '0', '4'),
(74, '2018-03-22 18:49:15', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '5', '0', '5'),
(75, '2018-03-22 18:50:40', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '6', '0', '1'),
(76, '2018-03-22 18:52:21', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '7', '0', '2'),
(77, '2018-03-22 18:53:11', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '8', '0', '3'),
(78, '2018-03-22 18:54:27', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '9', '0', '4'),
(79, '2018-03-22 18:54:57', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'no_urut', '10', '0', '5'),
(80, '2018-03-22 19:35:38', '/mks/t04_rkas03edit.php', '1', 'U', 't04_rkas03', 'no_urut', '1', '0', '1'),
(81, '2018-03-22 19:35:54', '/mks/t04_rkas03edit.php', '1', 'U', 't04_rkas03', 'no_urut', '2', '0', '2'),
(82, '2018-03-22 19:36:10', '/mks/t04_rkas03edit.php', '1', 'U', 't04_rkas03', 'no_urut', '3', '0', '3'),
(83, '2018-03-22 19:36:49', '/mks/t04_rkas03edit.php', '1', 'U', 't04_rkas03', 'no_urut', '4', '0', '1'),
(84, '2018-03-22 19:41:46', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '5', '', '1'),
(85, '2018-03-22 19:41:46', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '5', '', '2'),
(86, '2018-03-22 19:41:46', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '5', '', '2'),
(87, '2018-03-22 19:41:46', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '5', '', 'Dana DOS'),
(88, '2018-03-22 19:41:46', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '5', '', '5'),
(89, '2018-03-22 19:42:43', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '6', '', '2'),
(90, '2018-03-22 19:42:43', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '6', '', '6'),
(91, '2018-03-22 19:42:43', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '6', '', '1'),
(92, '2018-03-22 19:42:43', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '6', '', 'Gaji Guru / Pegawai'),
(93, '2018-03-22 19:42:43', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '6', '', '6'),
(94, '2018-03-22 19:43:38', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '7', '', '2'),
(95, '2018-03-22 19:43:38', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '7', '', '6'),
(96, '2018-03-22 19:43:38', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '7', '', '2'),
(97, '2018-03-22 19:43:38', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '7', '', 'Tunjangan Profesional Guru'),
(98, '2018-03-22 19:43:38', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '7', '', '7'),
(99, '2018-03-22 19:44:19', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '8', '', '2'),
(100, '2018-03-22 19:44:19', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '8', '', '6'),
(101, '2018-03-22 19:44:19', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '8', '', '3'),
(102, '2018-03-22 19:44:19', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '8', '', 'Kesra Guru / Pegawai'),
(103, '2018-03-22 19:44:19', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '8', '', '8'),
(104, '2018-03-22 19:45:08', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '9', '', '2'),
(105, '2018-03-22 19:45:08', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '9', '', '7'),
(106, '2018-03-22 19:45:08', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '9', '', '1'),
(107, '2018-03-22 19:45:08', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '9', '', 'Dana BOS'),
(108, '2018-03-22 19:45:08', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '9', '', '9'),
(109, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', '*** Batch update begin ***', 't05_rkas04', '', '', '', ''),
(110, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'no_urut', '1', '', '1'),
(111, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'keterangan', '1', '', 'Pembiayaan Penerimaan Siswa Baru'),
(112, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'jumlah', '1', '', '0'),
(113, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'lv3_id', '1', '', '9'),
(114, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'id', '1', '', '1'),
(115, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'no_urut', '2', '', '2'),
(116, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'keterangan', '2', '', 'Pembelian Buku Perpustakaan'),
(117, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'jumlah', '2', '', '0'),
(118, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'lv3_id', '2', '', '9'),
(119, '2018-03-22 20:00:22', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'id', '2', '', '2'),
(120, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'no_urut', '3', '', '3'),
(121, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'keterangan', '3', '', 'Pembelian Buku Pelajaran'),
(122, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'jumlah', '3', '', '0'),
(123, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'lv3_id', '3', '', '9'),
(124, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'id', '3', '', '3'),
(125, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'no_urut', '4', '', '4'),
(126, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'keterangan', '4', '', 'Pembiayaan Remidial (Ekstrakurikuler)'),
(127, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'jumlah', '4', '', '0'),
(128, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'lv3_id', '4', '', '9'),
(129, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', 'A', 't05_rkas04', 'id', '4', '', '4'),
(130, '2018-03-22 20:00:23', '/mks/t04_rkas03edit.php', '1', '*** Batch update successful ***', 't05_rkas04', '', '', '', ''),
(131, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '1', '', '2'),
(132, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '1', '', '7'),
(133, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '1', '', '9'),
(134, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '1', '', '1'),
(135, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '1', '', 'Pembiayaan Penerimaan Siswa Baru'),
(136, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '1', '', '0'),
(137, '2018-03-22 20:32:59', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '1', '', '1'),
(138, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '2', '', '2'),
(139, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '2', '', '7'),
(140, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '2', '', '9'),
(141, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '2', '', '2'),
(142, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '2', '', 'Pembelian Buku Perpustakaan'),
(143, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '2', '', '0'),
(144, '2018-03-22 20:53:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '2', '', '2'),
(145, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '3', '', '2'),
(146, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '3', '', '7'),
(147, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '3', '', '9'),
(148, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '3', '', '3'),
(149, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '3', '', 'Pembelian Buku Pelajaran'),
(150, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '3', '', '0'),
(151, '2018-03-22 20:54:07', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '3', '', '3'),
(152, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '4', '', '2'),
(153, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '4', '', '7'),
(154, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '4', '', '9'),
(155, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '4', '', '4'),
(156, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '4', '', 'Pembiayaan Remidial (Ekstrakurikuler)'),
(157, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '4', '', '0'),
(158, '2018-03-22 20:54:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '4', '', '4'),
(159, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '5', '', '2'),
(160, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '5', '', '7'),
(161, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '5', '', '9'),
(162, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '5', '', '5'),
(163, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '5', '', 'Pembiayaan Ulangan Semester dan UAS/UASBN'),
(164, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '5', '', '0'),
(165, '2018-03-22 20:55:54', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '5', '', '5'),
(166, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '6', '', '2'),
(167, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '6', '', '7'),
(168, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '6', '', '9'),
(169, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '6', '', '6'),
(170, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '6', '', 'Pembiayaan Bahan Habis Pakai (ATK)'),
(171, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '6', '', '0.00'),
(172, '2018-03-22 20:56:30', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '6', '', '6'),
(173, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '7', '', '2'),
(174, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '7', '', '7'),
(175, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '7', '', '9'),
(176, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '7', '', '7'),
(177, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '7', '', 'Pembiayaan Langganan Daya & Jasa'),
(178, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '7', '', '0.00'),
(179, '2018-03-22 20:59:53', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '7', '', '7'),
(180, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '8', '', '2'),
(181, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '8', '', '7'),
(182, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '8', '', '9'),
(183, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '8', '', '8'),
(184, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '8', '', 'Pembiayaan Perawatan'),
(185, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '8', '', '0.00'),
(186, '2018-03-22 21:00:21', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '8', '', '8'),
(187, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '9', '', '2'),
(188, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '9', '', '7'),
(189, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '9', '', '9'),
(190, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '9', '', '9'),
(191, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '9', '', 'Pembiayaan Honorarium GTT'),
(192, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '9', '', '0.00'),
(193, '2018-03-22 21:00:47', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '9', '', '9'),
(194, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '10', '', '2'),
(195, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '10', '', '7'),
(196, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '10', '', '9'),
(197, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '10', '', '10'),
(198, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '10', '', 'Pengembangan Profesi Guru'),
(199, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '10', '', '0.00'),
(200, '2018-03-22 21:01:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '10', '', '10'),
(201, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '11', '', '2'),
(202, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '11', '', '7'),
(203, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '11', '', '9'),
(204, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '11', '', '11'),
(205, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '11', '', 'Bantuan Transportasi Siswa Miskin'),
(206, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '11', '', '0.00'),
(207, '2018-03-22 21:01:55', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '11', '', '11'),
(208, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '12', '', '2'),
(209, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '12', '', '7'),
(210, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '12', '', '9'),
(211, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '12', '', '12'),
(212, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '12', '', 'Pembiayaan Pengolahan & BOS'),
(213, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '12', '', '0.00'),
(214, '2018-03-22 21:02:25', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '12', '', '12'),
(215, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '13', '', '2'),
(216, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '13', '', '7'),
(217, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '13', '', '9'),
(218, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '13', '', '13'),
(219, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '13', '', 'Pembelian Komputer'),
(220, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '13', '', '0.00'),
(221, '2018-03-22 21:02:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '13', '', '13'),
(222, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '14', '', '2'),
(223, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '14', '', '7'),
(224, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '14', '', '9'),
(225, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '14', '', '14'),
(226, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '14', '', 'Pembelian ABP & Lain-lain'),
(227, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '14', '', '0.00'),
(228, '2018-03-22 21:03:32', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '14', '', '14'),
(229, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '15', '', '2'),
(230, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '15', '', '7'),
(231, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '15', '', '9'),
(232, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '15', '', '15'),
(233, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '15', '', 'Pengeluaran Pajak'),
(234, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '15', '', '0.00'),
(235, '2018-03-22 21:03:58', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '15', '', '15'),
(236, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '10', '', '2'),
(237, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '10', '', '7'),
(238, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '10', '', '2'),
(239, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '10', '', 'Dana DOS'),
(240, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '10', '', '0.00'),
(241, '2018-03-22 21:04:45', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '10', '', '10'),
(242, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '16', '', '2'),
(243, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '16', '', '7'),
(244, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '16', '', '10'),
(245, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '16', '', '1'),
(246, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '16', '', 'Pelaksanaan Pelajaran'),
(247, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '16', '', '0.00'),
(248, '2018-03-22 21:05:20', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '16', '', '16'),
(249, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '17', '', '2'),
(250, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '17', '', '7'),
(251, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '17', '', '10'),
(252, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '17', '', '2'),
(253, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '17', '', 'TU Sekolah'),
(254, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '17', '', '0.00'),
(255, '2018-03-22 21:06:49', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '17', '', '17'),
(256, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '18', '', '2'),
(257, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '18', '', '7'),
(258, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '18', '', '10'),
(259, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '18', '', '3'),
(260, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '18', '', 'Belajar Barang'),
(261, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '18', '', '0.00'),
(262, '2018-03-22 21:07:18', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '18', '', '18'),
(263, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '19', '', '2'),
(264, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '19', '', '7'),
(265, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '19', '', '10'),
(266, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '19', '', '4'),
(267, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '19', '', 'Pendataan / Pelaporan Sekolah'),
(268, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '19', '', '0.00'),
(269, '2018-03-22 21:07:43', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '19', '', '19'),
(270, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '20', '', '2'),
(271, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '20', '', '7'),
(272, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '20', '', '10'),
(273, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '20', '', '5'),
(274, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '20', '', 'Honor Guru / Pegawai'),
(275, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '20', '', '0.00'),
(276, '2018-03-22 21:08:15', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '20', '', '20'),
(277, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '21', '', '2'),
(278, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '21', '', '7'),
(279, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '21', '', '10'),
(280, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '21', '', '6'),
(281, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '21', '', 'Transport'),
(282, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '21', '', '0.00'),
(283, '2018-03-22 21:08:35', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '21', '', '21'),
(284, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '22', '', '2'),
(285, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '22', '', '7'),
(286, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '22', '', '10'),
(287, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '22', '', '7'),
(288, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '22', '', 'Lain-lain'),
(289, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '22', '', '0.00'),
(290, '2018-03-22 21:09:04', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '22', '', '22'),
(291, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv1_id', '23', '', '2'),
(292, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv2_id', '23', '', '7'),
(293, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'lv3_id', '23', '', '10'),
(294, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'no_urut', '23', '', '8'),
(295, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'keterangan', '23', '', 'Pajak'),
(296, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'jumlah', '23', '', '0.00'),
(297, '2018-03-22 21:09:24', '/mks/t05_rkas04add.php', '1', 'A', 't05_rkas04', 'id', '23', '', '23'),
(298, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '11', '', '2'),
(299, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '11', '', '8'),
(300, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '11', '', '1'),
(301, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '11', '', 'Pembiayaan Perawatan'),
(302, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '11', '', '0.00'),
(303, '2018-03-22 21:11:47', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '11', '', '11'),
(304, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '12', '', '2'),
(305, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '12', '', '8'),
(306, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '12', '', '2'),
(307, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '12', '', 'Honorarium GTT'),
(308, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '12', '', '0.00'),
(309, '2018-03-22 21:12:21', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '12', '', '12'),
(310, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '13', '', '2'),
(311, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '13', '', '8'),
(312, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '13', '', '3'),
(313, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '13', '', 'Penembokan Batas Halaman Sekolah'),
(314, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '13', '', '0.00'),
(315, '2018-03-22 21:12:53', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '13', '', '13'),
(316, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '14', '', '2'),
(317, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '14', '', '8'),
(318, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '14', '', '4'),
(319, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '14', '', 'Pembangunan Mushalla Sekolah'),
(320, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '14', '', '0.00'),
(321, '2018-03-22 21:13:25', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '14', '', '14'),
(322, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '15', '', '2'),
(323, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '15', '', '8'),
(324, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '15', '', '5'),
(325, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '15', '', 'Lain-lain'),
(326, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '15', '', '0.00'),
(327, '2018-03-22 21:13:50', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '15', '', '15'),
(328, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '16', '', '2'),
(329, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '16', '', '10'),
(330, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '16', '', '1'),
(331, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '16', '', 'Pembelian Bahan Bangunan'),
(332, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '16', '', '0.00'),
(333, '2018-03-22 21:15:09', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '16', '', '16'),
(334, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '17', '', '2'),
(335, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '17', '', '10'),
(336, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '17', '', '2'),
(337, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '17', '', 'Ongkos Tukang'),
(338, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '17', '', '0.00'),
(339, '2018-03-22 21:15:31', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '17', '', '17'),
(340, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '18', '', '2'),
(341, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '18', '', '10'),
(342, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '18', '', '3'),
(343, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '18', '', 'Pembiayaan Laporan'),
(344, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '18', '', '0.00'),
(345, '2018-03-22 21:15:57', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '18', '', '18'),
(346, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv1_id', '19', '', '2'),
(347, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'lv2_id', '19', '', '10'),
(348, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'no_urut', '19', '', '4'),
(349, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'keterangan', '19', '', 'Pajak'),
(350, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'jumlah', '19', '', '0.00'),
(351, '2018-03-22 21:16:14', '/mks/t04_rkas03add.php', '1', 'A', 't04_rkas03', 'id', '19', '', '19'),
(352, '2018-03-27 11:05:43', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(353, '2018-03-27 13:26:03', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(354, '2018-03-28 11:48:26', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(355, '2018-03-28 11:50:01', '/mks/t03_rkas02edit.php', '1', 'U', 't03_rkas02', 'jumlah', '1', '1.00', '0'),
(356, '2018-03-28 12:43:29', '/mks/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(357, '2018-03-28 12:54:51', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(358, '2018-03-28 14:38:27', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(359, '2018-03-29 08:30:57', '/mks/login.php', 'admin', 'login', '::1', '', '', '', ''),
(360, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', '*** Batch insert begin ***', 't02_rkas', '', '', '', ''),
(361, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '1', '', '1'),
(362, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '1', '', NULL),
(363, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '1', '', NULL),
(364, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '1', '', '4000000'),
(365, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '1', '', NULL),
(366, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '1', '', NULL),
(367, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '1', '', NULL),
(368, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '1', '', '1'),
(369, '2018-03-29 09:09:47', '/mks/t02_rkaslist.php', '1', '*** Batch insert successful ***', 't02_rkas', '', '', '', ''),
(370, '2018-03-29 09:13:48', '/mks/t02_rkaslist.php', '1', '*** Batch update begin ***', 't02_rkas', '', '', '', ''),
(371, '2018-03-29 09:13:48', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour1', '1', NULL, '1.'),
(372, '2018-03-29 09:13:48', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'ket1', '1', NULL, 'Sumber Dana'),
(373, '2018-03-29 09:13:48', '/mks/t02_rkaslist.php', '1', '*** Batch update successful ***', 't02_rkas', '', '', '', ''),
(374, '2018-03-29 09:18:47', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'urutan', '1', '0', '1'),
(375, '2018-03-29 09:19:24', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'jml1', '1', '4000000.00', '0'),
(376, '2018-03-29 09:19:24', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour2', '1', NULL, '1.'),
(377, '2018-03-29 09:19:24', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'ket2', '1', NULL, 'Penggunaan'),
(378, '2018-03-29 09:19:24', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'jml2', '1', NULL, '0'),
(379, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', '*** Batch insert begin ***', 't02_rkas', '', '', '', ''),
(380, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '2', '', '2'),
(381, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'urutan', '2', '', '2'),
(382, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '2', '', '1.1'),
(383, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '2', '', 'Dana Rutin'),
(384, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '2', '', '0'),
(385, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '2', '', NULL),
(386, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '2', '', NULL),
(387, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '2', '', '0'),
(388, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '2', '', '2'),
(389, '2018-03-29 09:23:32', '/mks/t02_rkaslist.php', '1', '*** Batch insert successful ***', 't02_rkas', '', '', '', ''),
(390, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '3', '', '3'),
(391, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'urutan', '3', '', '3'),
(392, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '3', '', '1.1.1'),
(393, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '3', '', 'Gaji'),
(394, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '3', '', '0.00'),
(395, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '3', '', NULL),
(396, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '3', '', NULL),
(397, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '3', '', '0.00'),
(398, '2018-03-29 09:28:09', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '3', '', '3'),
(399, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '4', '', '3'),
(400, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'urutan', '4', '', '3'),
(401, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '4', '', '1.1.2'),
(402, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '4', '', 'Tunjangan Profesi'),
(403, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '4', '', '0.00'),
(404, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '4', '', NULL),
(405, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '4', '', NULL),
(406, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '4', '', '0.00'),
(407, '2018-03-29 09:28:59', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '4', '', '4'),
(408, '2018-03-29 09:29:11', '/mks/t02_rkasedit.php', '1', 'U', 't02_rkas', 'urutan', '4', '3', '2'),
(409, '2018-03-29 09:29:25', '/mks/t02_rkasedit.php', '1', 'U', 't02_rkas', 'urutan', '4', '2', '3'),
(410, '2018-03-29 09:29:32', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'urutan', '4', '3', '4'),
(411, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '5', '', '3'),
(412, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'urutan', '5', '', '5'),
(413, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '5', '', '1.1.3'),
(414, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '5', '', 'Kesra'),
(415, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '5', '', '0.00'),
(416, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '5', '', NULL),
(417, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '5', '', NULL),
(418, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '5', '', '0.00'),
(419, '2018-03-29 09:34:28', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '5', '', '5'),
(420, '2018-03-29 09:34:50', '/mks/t02_rkaslist.php', '1', '*** Batch update begin ***', 't02_rkas', '', '', '', ''),
(421, '2018-03-29 09:34:50', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour1', '2', '1.1', '1.1.'),
(422, '2018-03-29 09:34:51', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour1', '3', '1.1.1', '1.1.1.'),
(423, '2018-03-29 09:34:51', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour1', '4', '1.1.2', '1.1.2.'),
(424, '2018-03-29 09:34:51', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour1', '5', '1.1.3', '1.1.3.'),
(425, '2018-03-29 09:34:51', '/mks/t02_rkaslist.php', '1', '*** Batch update successful ***', 't02_rkas', '', '', '', ''),
(426, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'lvl', '6', '', '2'),
(427, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'urutan', '6', '', '6'),
(428, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour1', '6', '', '1.2.'),
(429, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket1', '6', '', 'Dana Bantuan'),
(430, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml1', '6', '', '0'),
(431, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'nour2', '6', '', NULL),
(432, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'ket2', '6', '', NULL),
(433, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'jml2', '6', '', '0'),
(434, '2018-03-29 09:38:41', '/mks/t02_rkaslist.php', '1', 'A', 't02_rkas', 'id', '6', '', '6'),
(435, '2018-03-29 09:39:41', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'nour2', '2', NULL, '2.1.'),
(436, '2018-03-29 09:39:41', '/mks/t02_rkaslist.php', '1', 'U', 't02_rkas', 'ket2', '2', NULL, 'Dana Rutin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
