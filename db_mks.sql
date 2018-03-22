-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2018 at 10:03 AM
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
-- Table structure for table `t02_rkas01`
--

CREATE TABLE IF NOT EXISTS `t02_rkas01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t02_rkas01`
--

INSERT INTO `t02_rkas01` (`id`, `keterangan`, `jumlah`) VALUES
(1, 'Sumber Dana', 0.00),
(2, 'Penggunaan', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `t03_rkas02`
--

CREATE TABLE IF NOT EXISTS `t03_rkas02` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `lv1_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `t03_rkas02`
--

INSERT INTO `t03_rkas02` (`id`, `keterangan`, `jumlah`, `lv1_id`) VALUES
(1, 'Dana Rutin', 0.00, 1),
(2, 'Dana Bantuan', 0.00, 1),
(3, 'Dana Komite', 0.00, 1),
(4, 'Dana Hibah', 0.00, 1),
(5, 'Dana DAK', 0.00, 1),
(6, 'Dana Rutin', 0.00, 2),
(7, 'Dana Bantuan', 0.00, 2),
(8, 'Dana Komite', 0.00, 2),
(9, 'Dana Hibah', 0.00, 2),
(10, 'Dana DAK', 0.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t04_rkas03`
--

CREATE TABLE IF NOT EXISTS `t04_rkas03` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) NOT NULL,
  `jumlah` float(15,2) NOT NULL DEFAULT '0.00',
  `lv2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t04_rkas03`
--

INSERT INTO `t04_rkas03` (`id`, `keterangan`, `jumlah`, `lv2_id`) VALUES
(1, 'Gaji', 0.00, 1),
(2, 'Tunjangan Profesi', 0.00, 1),
(3, 'Kesra', 0.00, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

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
(62, '2018-03-22 12:21:59', '/mks/t03_rkas02add.php', '1', 'A', 't03_rkas02', 'id', '10', '', '10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
