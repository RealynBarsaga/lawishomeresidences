-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2024 at 01:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_barangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbrgyofficial`
--

CREATE TABLE `tblbrgyofficial` (
  `id` int(11) NOT NULL,
  `sPosition` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `completeName` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pcontact` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paddress` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `termStart` date NOT NULL,
  `termEnd` date NOT NULL,
  `Status` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `barangay` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `image` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbrgyofficial`
--

INSERT INTO `tblbrgyofficial` (`id`, `sPosition`, `completeName`, `pcontact`, `paddress`, `termStart`, `termEnd`, `Status`, `barangay`, `image`) VALUES
(4, 'Hon', 'Gilbert S. Sevillejo', '09269948693', 'Pili Madridejos Cebu', '2006-05-06', '2017-05-08', 'Ongoing Term', 'Pili', ''),
(8, 'Captain', 'Rexiber V. Villaceran', '09269948693', 'Tabagak Madridejos Cebu', '2016-05-10', '2026-05-14', 'Ongoing Term', 'Tabagak', '1726761691083_man.png'),
(9, 'Captain', 'Bacilio S. Ducay', '09215316216', 'Bunakan Madridejos Cebu', '2020-09-09', '2025-07-24', 'Ongoing Term', 'Bunakan', '1726762089573_man.png'),
(10, 'Captain', 'Carl Justin Caraos', '09123136173', 'Tugas Madridejos Cebu', '2021-05-04', '2026-05-09', 'Ongoing Term', 'Tugas', '1727140625527_man.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblclearance`
--

CREATE TABLE `tblclearance` (
  `id` int(11) NOT NULL,
  `clearanceNo` varchar(255) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `purpose` text NOT NULL,
  `orNo` int(11) NOT NULL,
  `samount` int(11) NOT NULL,
  `dateRecorded` date NOT NULL,
  `recordedBy` varchar(50) NOT NULL,
  `barangay` text NOT NULL,
  `age` int(11) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `purok` varchar(20) NOT NULL,
  `report_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclearance`
--

INSERT INTO `tblclearance` (`id`, `clearanceNo`, `Name`, `purpose`, `orNo`, `samount`, `dateRecorded`, `recordedBy`, `barangay`, `age`, `bdate`, `purok`, `report_type`) VALUES
(58, '0001', 'Gilbert Sevillejo', 'Pangguna', 12, 122, '2024-09-21', 'bunakan', 'Bunakan', 22, '2002-05-05', 'Lamon-lamon', 'Clearance'),
(60, '0001', 'Raden Joshua Hiba', 'Pangguna', 21, 21, '2024-09-21', 'tabagak', 'Tabagak', 13, '2011-01-01', 'Ambut unsa', 'Clearance'),
(61, '0002', 'Realyn E. Barsaga', 'Pangguna', 12, 12, '2024-09-22', 'admin', 'Tabagak', 12, '2012-01-03', 'Lamon-lamon', 'Clearance');

-- --------------------------------------------------------

--
-- Table structure for table `tblhousehold`
--

CREATE TABLE `tblhousehold` (
  `id` int(11) NOT NULL,
  `householdno` int(11) NOT NULL,
  `totalhouseholdmembers` int(2) NOT NULL,
  `headoffamily` varchar(100) NOT NULL,
  `purok` varchar(20) NOT NULL,
  `barangay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblhousehold`
--

INSERT INTO `tblhousehold` (`id`, `householdno`, `totalhouseholdmembers`, `headoffamily`, `purok`, `barangay`) VALUES
(70, 2, 0, '44', '', ''),
(72, 3, 0, '46', '', ''),
(73, 1, 0, '34', '', ''),
(74, 2, 0, '32', '', ''),
(76, 4, 0, '47', '', ''),
(77, 2, 0, '48', '', ''),
(78, 5, 0, '49', '', ''),
(79, 6, 0, '50', '', ''),
(80, 3, 0, '37', '', ''),
(82, 3, 0, '41', '', ''),
(83, 2, 0, '51', '', ''),
(84, 6, 0, '52', '', ''),
(85, 4, 0, '53', '', ''),
(86, 3, 0, '56', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblindigency`
--

CREATE TABLE `tblindigency` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `purok` varchar(50) NOT NULL,
  `barangay` text NOT NULL,
  `dateRecorded` date NOT NULL,
  `report_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblindigency`
--

INSERT INTO `tblindigency` (`id`, `Name`, `purpose`, `purok`, `barangay`, `dateRecorded`, `report_type`) VALUES
(3, 'Shara Villcarlos', 'asyidoldsa', 'Lamon-lamon', 'Tabagak', '2024-10-01', 'Certificate Of Indigency');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogs`
--

CREATE TABLE `tbllogs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `logdate` date NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbllogs`
--

INSERT INTO `tbllogs` (`id`, `user`, `logdate`, `action`) VALUES
(745, 'Brgy.Tabagak', '2024-09-22', 'Update Official named Rexiber V. Villaceran'),
(746, 'Administrator', '2024-09-22', 'Added Official named Vincent Y. Villacrusis'),
(747, 'Administrator', '2024-09-22', 'Added Official named Perla B. Molina'),
(748, 'Administrator', '2024-09-22', 'Added Official named Julius Villaceran'),
(749, 'Administrator', '2024-09-22', 'Added Official named Jhon Robert S. Dela Fuente'),
(750, 'Administrator', '2024-09-22', 'Added Official named Delfin A. Santillan'),
(751, 'Administrator', '2024-09-22', 'Added Official named Owen G. Daruca'),
(752, 'Administrator', '2024-09-22', 'Added Official named Perla A. Bacayo'),
(753, 'Administrator', '2024-09-22', 'Added Official named Vanice Cyrus M. Rebadomia'),
(754, 'Administrator', '2024-09-22', 'Added Official named Frederick F. Salazar'),
(755, 'Brgy.Tabagak', '2024-09-22', 'Added Clearance name of FSGFAGDA'),
(756, 'Brgy.Tabagak', '2024-09-24', 'Update Official named Rexiber V. Villaceran'),
(757, 'Brgy.Tugas', '2024-09-24', 'Added Official named Carl Justin Caraos'),
(758, 'Brgy.Tabagak', '2024-09-27', 'Update Clearance info of Realyn E. Barsaga'),
(759, 'Brgy.Tabagak', '2024-09-27', 'Update Official named Rexiber V. Villaceran'),
(760, 'Administrator', '2024-09-28', 'Added Official named jhsagudkja'),
(761, 'Administrator', '2024-09-28', 'Added Official named sUYKLSYWIU1QKNW'),
(762, 'Administrator', '2024-09-29', 'Added Permit with name of '),
(763, 'Brgy.Tabagak', '2024-09-29', 'Added Resident named of   '),
(764, 'Brgy.Tabagak', '2024-09-29', 'Added Resident named of   '),
(765, 'Brgy.Tabagak', '2024-09-29', 'Added certificate of residency purpose of '),
(766, 'Brgy.Tabagak', '2024-09-30', 'Added Clearance name of Cindy Lucero'),
(767, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of yasdad'),
(768, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of asyidoldsa'),
(769, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of dfdf'),
(770, 'Brgy.Bunakan', '2024-10-01', 'Added certificate of residency purpose of asda'),
(771, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of yasdad'),
(772, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of yasdad'),
(773, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of asyidoldsa'),
(774, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of asyidoldsa'),
(775, 'Brgy.Tabagak', '2024-10-01', 'Added certificate of residency purpose of asyidoldsa');

-- --------------------------------------------------------

--
-- Table structure for table `tblmadofficial`
--

CREATE TABLE `tblmadofficial` (
  `id` int(11) NOT NULL,
  `sPosition` varchar(50) NOT NULL,
  `completeName` text NOT NULL,
  `pcontact` varchar(20) NOT NULL,
  `paddress` text NOT NULL,
  `termStart` date NOT NULL,
  `termEnd` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmadofficial`
--

INSERT INTO `tblmadofficial` (`id`, `sPosition`, `completeName`, `pcontact`, `paddress`, `termStart`, `termEnd`, `status`, `image`) VALUES
(31, 'Mayor', 'Romeo A. Villaceran', '09269948693', 'Pili Madridejos Cebu', '2023-05-11', '2025-05-06', 'Ongoing Term', '1727511425157_man.png'),
(33, 'Vice Mayor', 'Vincent Y. Villacrusis', '09123173992', 'Poblacion Madridejos Cebu', '2015-01-01', '2026-06-11', 'Ongoing Term', '1727511425157_man.png'),
(34, 'Hon', 'Perla B. Molina', '09123173138', 'Wapa hibawe', '2020-05-03', '2026-05-07', 'Ongoing Term', '1727511512343_women.png'),
(35, 'Hon', 'Julius Villaceran', '09127131381', 'Tabagak Madridejos Cebu', '2020-02-07', '2026-06-11', 'Ongoing Term', '1727511425157_man.png'),
(36, 'Hon', 'Jhon Robert S. Dela Fuente', '09213187381', 'Mancilang Madridejos Cebu', '2020-05-07', '2026-05-13', 'Ongoing Term', '1727511425157_man.png'),
(37, 'Hon', 'Delfin A. Santillan', '09217321317', 'Wapa hibawe', '2020-06-03', '2026-05-06', 'Ongoing Term', '1727511425157_man.png'),
(38, 'Hon', 'Owen G. Daruca', '09513464424', 'Maalat Madridejos Cebu', '2020-05-14', '2026-05-14', 'Ongoing Term', '1727511425157_man.png'),
(39, 'Hon', 'Perla A. Bacayo', '09123123182', 'Maalat Madridejos Cebu', '2019-07-09', '2026-02-10', 'Ongoing Term', '1727511512343_women.png'),
(40, 'Hon', 'Vanice Cyrus M. Rebadomia', '09217371237', 'Waako kaybaw', '2018-05-09', '2026-07-11', 'Ongoing Term', '1727511512343_women.png'),
(41, 'Hon', 'Frederick F. Salazar', '09236273263', 'Wapa hibawe', '2022-01-06', '2026-05-06', 'Ongoing Term', '1727511512343_women.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblpermit`
--

CREATE TABLE `tblpermit` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `businessName` text NOT NULL,
  `businessAddress` text NOT NULL,
  `typeOfBusiness` varchar(50) NOT NULL,
  `orNo` int(11) NOT NULL,
  `samount` int(11) NOT NULL,
  `dateRecorded` date NOT NULL,
  `recordedBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpermit`
--

INSERT INTO `tblpermit` (`id`, `Name`, `businessName`, `businessAddress`, `typeOfBusiness`, `orNo`, `samount`, `dateRecorded`, `recordedBy`) VALUES
(78, 'Gilbert Sevillejo', 'basta uy', 'BASTA', 'Merchandising', 12, 12, '2024-08-16', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblrecidency`
--

CREATE TABLE `tblrecidency` (
  `id` int(20) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `purok` varchar(50) NOT NULL,
  `barangay` text NOT NULL,
  `dateRecorded` date NOT NULL,
  `report_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblrecidency`
--

INSERT INTO `tblrecidency` (`id`, `Name`, `purpose`, `purok`, `barangay`, `dateRecorded`, `report_type`) VALUES
(11, 'Neil Albert Quejada', 'asyidoldsa', 'Waako kaybaw', 'Tabagak', '2024-10-01', 'Certificate Of Residency');

-- --------------------------------------------------------

--
-- Table structure for table `tblstaff`
--

CREATE TABLE `tblstaff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `compass` varchar(255) NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstaff`
--

INSERT INTO `tblstaff` (`id`, `name`, `username`, `password`, `compass`, `logo`) VALUES
(44, 'Bunakan', 'bunakan', '$2y$10$dwqTfYi40MX01FW4HwGU6Oe/5ST5faF41C/7ddC2Ibw/B2wtXMYfy', '$2y$10$dwqTfYi40MX01FW4HwGU6Oe/5ST5faF41C/7ddC2Ibw/B2wtXMYfy', '0902201524.png'),
(46, 'Tabagak', 'tabagak', '$2y$10$7Y1QF0qRW9BBe7EPcoGrZOiXizvLjjWl5R755PP3mLJpFNToJQEyW', '$2y$10$7Y1QF0qRW9BBe7EPcoGrZOiXizvLjjWl5R755PP3mLJpFNToJQEyW', '0902195205.png'),
(52, 'Mancilang', 'mancilang', '$2y$10$mkfvFxO3vnfwU.gbUlD9uOnhn.pjBlRAF4bTvU3BtNB9c8ahLBZNe', '$2y$10$mkfvFxO3vnfwU.gbUlD9uOnhn.pjBlRAF4bTvU3BtNB9c8ahLBZNe', '0910133732.png'),
(53, 'Malbago', 'malbago', '$2y$10$p3On.t6i0h3vOhlXjGp3N.KrgpoFdHPGiQ3XPHK1AcxOeFDTn0fUS', '$2y$10$p3On.t6i0h3vOhlXjGp3N.KrgpoFdHPGiQ3XPHK1AcxOeFDTn0fUS', '0910140006.png'),
(54, 'Kodia', 'kodia', '$2y$10$5RFxZW4FK5wF19EAKHdHMeyuvu43PCthxLL.O7qkOtxap7rm4vBYi', '$2y$10$5RFxZW4FK5wF19EAKHdHMeyuvu43PCthxLL.O7qkOtxap7rm4vBYi', '0910140016.png'),
(59, 'Maalat', 'maalat', '$2y$10$8rUrgmcVEdBxGmTSJSKl6./nylgSOaftFt77QZ1Ku9lWjfvrPQzoG', '$2y$10$8rUrgmcVEdBxGmTSJSKl6./nylgSOaftFt77QZ1Ku9lWjfvrPQzoG', '0910133623.png'),
(61, 'Tarong', 'tarong', '$2y$10$fzt4qrGAVInSjzr9qXHW2eIdy5Mam5Kp4NDbc9JopI.7gJCv88ORS', '$2y$10$fzt4qrGAVInSjzr9qXHW2eIdy5Mam5Kp4NDbc9JopI.7gJCv88ORS', '0910145248.png'),
(62, 'Talangnan', 'talangnan', '$2y$10$RBJTUIJF51.kKpVIlCQ9COSjlw2xT.c1ukAEq/ykiTPB5NLC96Qhu', '$2y$10$RBJTUIJF51.kKpVIlCQ9COSjlw2xT.c1ukAEq/ykiTPB5NLC96Qhu', '0910145516.png'),
(63, 'Poblacion', 'poblacion', '$2y$10$KV8szs48n7B6E6JoUQ6Bg.CMpW6SvZoPlhcCTwtllEMc7GMyaxEq2', '$2y$10$KV8szs48n7B6E6JoUQ6Bg.CMpW6SvZoPlhcCTwtllEMc7GMyaxEq2', '0910150159.png'),
(73, 'Tugas', 'tugas', '$2y$10$3WmXCsHyRspM0JIbyeFXmuuSf3qEfBgrCALmhMvi/4qEsOW660XBy', '$2y$10$3WmXCsHyRspM0JIbyeFXmuuSf3qEfBgrCALmhMvi/4qEsOW660XBy', '0910155442.png'),
(74, 'Pili', 'pili', '$2y$10$3Mg8B0Qaqt8uGKzDJr3n9eLg/3.uNodXP0Hoh1PBRzroQgH.kUg2.', '$2y$10$3Mg8B0Qaqt8uGKzDJr3n9eLg/3.uNodXP0Hoh1PBRzroQgH.kUg2.', '0910161628.png'),
(75, 'San Agustin', 'sanagustin', '$2y$10$6PJTjOie7slgZPFagtcHu.FMy0zSsBRvLUF4VXjrqwwdlQAHvrAFi', '$2y$10$6PJTjOie7slgZPFagtcHu.FMy0zSsBRvLUF4VXjrqwwdlQAHvrAFi', '0910163145.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbltabagak`
--

CREATE TABLE `tbltabagak` (
  `id` int(11) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `mname` varchar(20) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `bplace` text NOT NULL,
  `age` int(11) NOT NULL,
  `barangay` varchar(120) NOT NULL,
  `totalhousehold` int(5) NOT NULL,
  `civilstatus` varchar(20) NOT NULL,
  `householdnum` int(11) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `houseOwnershipStatus` varchar(50) NOT NULL,
  `landOwnershipStatus` varchar(20) NOT NULL,
  `lightningFacilities` varchar(20) NOT NULL,
  `formerAddress` text NOT NULL,
  `image` text NOT NULL,
  `purok` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltabagak`
--

INSERT INTO `tbltabagak` (`id`, `lname`, `fname`, `mname`, `bdate`, `bplace`, `age`, `barangay`, `totalhousehold`, `civilstatus`, `householdnum`, `religion`, `nationality`, `gender`, `houseOwnershipStatus`, `landOwnershipStatus`, `lightningFacilities`, `formerAddress`, `image`, `purok`) VALUES
(32, 'Sevillejo', 'Gilbert', 'S', '2002-05-05', 'Tabagak', 22, 'Tabagak', 10, 'Single', 2, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Tabagak', 'man.png', 'Lamon-Lamon'),
(34, 'Quijada', 'NeilAlbert', 'Q', '2003-07-03', 'Tabagak', 21, 'Tabagak', 13, 'Single', 1, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Tabagak', 'man.png', 'Lower-Bangus'),
(37, 'Villacarlos', 'Shara', 'D', '2005-05-08', 'Tabagak', 19, 'Tabagak', 12, 'Single', 3, 'Catholic', 'Filipino', 'Female', 'Own Home', 'Owned', 'Electric', 'Tabagak', 'women.png', 'Lawihan'),
(41, 'Ybanez', 'Jeslyn', 'F', '2005-05-08', 'Bunakan', 19, 'Bunakan', 12, 'Single', 3, 'Catholic', 'Filipino', 'Female', 'Own Home', 'Owned', 'Electric', 'Bunakan', 'women.png', 'Bilabid'),
(44, 'Alegre', 'Kurt Brayan', 'E', '2009-05-03', 'Bunakan', 15, 'Bunakan', 21, 'Single', 2, 'Catholic', 'Filipino', 'Male', 'Rent', 'Owned', 'Electric', 'Bunakan', 'man.png', 'Bilabid'),
(46, 'Smith', 'John', 'D', '2002-11-06', 'Kodia', 21, 'Kodia', 2, 'Single', 3, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Kodia', 'man.png', 'Waako kaybaw'),
(47, 'Gidayawan', 'Andry', 'D', '2003-05-01', 'Malbago', 21, 'Malbago', 5, 'Single', 4, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Malbago', '1725357632447_women.png', 'Waako kaybaw'),
(48, 'Discarten', 'Mary Jean', 'P', '2001-09-04', 'Maalat', 22, 'Maalat', 6, 'Single', 2, 'Catholic', 'Filipino', 'Female', 'Own Home', 'Owned', 'Electric', 'Maalat', '1725357859262_women.png', 'Ambut unsa'),
(49, 'Ducay', 'Merriam', 'T', '2002-05-01', 'mancilang', 22, 'Mancilang', 5, 'Single', 5, 'Catholic', 'Filipino', 'Female', 'Own Home', 'Owned', 'Electric', 'mancilang', '1725459284384_women.png', 'Ambut unsa'),
(50, 'Villcarlos', 'Jimar', 'D', '2000-05-03', 'Pili', 24, 'Pili', 6, 'Single', 6, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Pili', '1725498194029_women.png', 'Bakhaw'),
(51, 'Disabelle ', 'Rommel', 'H', '2001-06-07', 'Talangnan', 23, 'Talangnan', 2, 'Single', 2, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Talangnan', '1726084484014_man.png', 'ambot sila lugar'),
(52, 'Hiba', 'Raden Joshua', 'T', '2000-07-07', 'Talangnan', 24, 'Talangnan', 3, 'Single', 6, 'Catholic', 'Filipino', 'Male', 'Own Home', 'Owned', 'Electric', 'Talangnan', '1726084642130_man.png', 'ambot sila lugar'),
(53, 'Mansueto', 'Jevey', 'V', '2005-08-02', 'Poblacion', 19, 'Poblacion', 6, 'Single', 4, 'Catholic', 'Filipino', 'Male', 'Rent', 'Landless', 'Electric', 'Poblacion', '1726235304532_man.png', 'HAGAS'),
(54, 'hahaha', 'Gilbert', 'sdajdsa', '2020-01-09', 'Bunakan', 4, 'Bunakan', 3, 'Single', 3, 'Catholic', 'Filipino', 'Male', 'Rent', 'Owned', 'Electric', 'Bunakan', '1726495013990_man.png', 'Bilabid'),
(56, 'Oftana', 'Mary Grace', 'P', '2004-06-02', 'Tugas', 20, 'Tugas', 2, 'Single', 3, 'Catholic', 'Filipino', 'Female', 'Own Home', 'Owned', 'Electric', 'Tugas', '1726846349275_women.png', 'Purok');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `username`, `password`, `type`) VALUES
(1, 'admin', '$2y$10$2sC1wT3rLxqOsmMpxR0zUuo/YG.kuNLmBO/vdk7SZFVNQRRGkCCqS', 'administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbrgyofficial`
--
ALTER TABLE `tblbrgyofficial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclearance`
--
ALTER TABLE `tblclearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblhousehold`
--
ALTER TABLE `tblhousehold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblindigency`
--
ALTER TABLE `tblindigency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbllogs`
--
ALTER TABLE `tbllogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmadofficial`
--
ALTER TABLE `tblmadofficial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpermit`
--
ALTER TABLE `tblpermit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrecidency`
--
ALTER TABLE `tblrecidency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstaff`
--
ALTER TABLE `tblstaff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltabagak`
--
ALTER TABLE `tbltabagak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbrgyofficial`
--
ALTER TABLE `tblbrgyofficial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblclearance`
--
ALTER TABLE `tblclearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tblhousehold`
--
ALTER TABLE `tblhousehold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `tblindigency`
--
ALTER TABLE `tblindigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbllogs`
--
ALTER TABLE `tbllogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=776;

--
-- AUTO_INCREMENT for table `tblmadofficial`
--
ALTER TABLE `tblmadofficial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tblpermit`
--
ALTER TABLE `tblpermit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tblrecidency`
--
ALTER TABLE `tblrecidency`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblstaff`
--
ALTER TABLE `tblstaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbltabagak`
--
ALTER TABLE `tbltabagak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
