-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2018 at 06:44 PM
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
  `desa` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t01_master_sekolah`
--

INSERT INTO `t01_master_sekolah` (`id`, `no_stat`, `nama`, `status`, `desa`, `kecamatan`, `kabupaten`, `provinsi`) VALUES
(1, '123456789012', '[Nama Sekolah]', '[Status Sekolah]', '[Desa]', '[Kecamatan]', '[Kabupaten]', '[Provinsi]');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
(10, '2018-03-19 23:25:03', '/mks/login.php', 'admin', 'login', '::1', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
