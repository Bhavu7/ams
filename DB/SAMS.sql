-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 12:46 PM
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
-- Database: `attendance_management`
--
CREATE DATABASE IF NOT EXISTS `attendance_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `attendance_management`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `email`, `password`) VALUES
(1, 'admin01@gmail.com', 'admin001'),
(2, 'admin02@gmail.com', 'admin02'),
(3, 'admin03@gmail.com', 'admin03'),
(4, 'admin04@gmail.com', 'admin04');

-- --------------------------------------------------------

--
-- Table structure for table `admin_mst`
--

CREATE TABLE `admin_mst` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `role` enum('administrator','manager') NOT NULL,
  `department` varchar(255) NOT NULL,
  `doj` date NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_mst`
--

INSERT INTO `admin_mst` (`admin_id`, `full_name`, `dob`, `email`, `phone`, `address`, `role`, `department`, `doj`, `status`, `profile_image`) VALUES
(1, 'Bhavu', '2025-01-07', 'tanisal336@fundapk.com', '9408479356', 'bgfdf', 'administrator', 'IT', '2025-01-23', 'active', '5469767501907878252_121.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_mst`
--

CREATE TABLE `attendance_mst` (
  `id` int(11) NOT NULL,
  `roll_number` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `division` varchar(10) NOT NULL,
  `semester` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent') NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_mst`
--

INSERT INTO `attendance_mst` (`id`, `roll_number`, `name`, `department`, `division`, `semester`, `attendance_date`, `status`, `photo`) VALUES
(41, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-15', 'present', 'p1.jpg'),
(42, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-15', 'present', 'p1.jpg'),
(43, '22BIT008', 'Bhavesh', 'TY BSc CA & IT', 'Division A', 6, '2025-01-15', 'present', 'picofme (2).png'),
(44, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-15', 'present', 'p1.jpg'),
(45, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-15', 'present', 'p1.jpg'),
(46, '22BIT001', 'ANISHABEN RAMESHBHAI SINDHA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(47, '22BIT002', 'ANSH NAVINBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(48, '22BIT003', 'ANSHUMAN JAYENDRAKUMAR DODIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(49, '22BIT004', 'YASH NILESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(50, '22BIT005', 'JAYMINKUMAR KHUSHALBHAI MAKWANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(51, '22BIT007', 'BHARGAVKUMAR MAHENDRABHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(52, '22BIT008', 'Bhavesh', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', 'picofme (2).png'),
(53, '22BIT009', 'BHAVYA ASHWINKUMAR PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(54, '22BIT012', 'DEVAM GORDHANBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(55, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', 'p1.jpg'),
(56, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', 'p1.jpg'),
(57, '22BIT016', 'DHRUVILKUMAR DILIPBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(58, '22BIT018', 'HARSHIL MAHENDRASINH PADHIYAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(59, '22BIT019', 'HARSHKUMAR ATULBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(60, '22BIT020', 'HARSHKUMAR BAKULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(61, '22BIT021', 'HEMLATTABEN ALPESHBHAI PARMAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(62, '22BIT022', 'HERRY ANILBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(63, '22BIT023', 'HEVIN VIPULBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(64, '22BIT024', 'MEET DHIRUBHAI GOHEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(65, '22BIT025', 'HONEY JIGNESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(66, '22BIT027', 'JAYDIPBHAI CHANDRAKANTBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(67, '22BIT028', 'JAYESHKUMAR RAMESHBHAI BARIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(68, '22BIT031', 'JEETKUMAR MINESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(69, '22BIT032', 'JENILKUMAR ALPESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(70, '22BIT034', 'KARANSINH VIJAYKUMAR ZALA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(71, '22BIT035', 'KAVITABEN DHARMAMSINH CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(72, '22BIT036', 'KEVAL VINODBHAI RANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(73, '22BIT037', 'KHUSHI SHANTILAL PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(74, '22BIT038', 'KINJALBEN MUKESHBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(75, '22BIT039', 'KRISHNABEN HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(76, '22BIT041', 'MALHAR GOPALBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(77, '22BIT042', 'MANAN INDRAVADAN PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(78, '22BIT043', 'MEETKUMAR ANILBHAI KACHOT', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(79, '22BIT044', 'MEETKUMAR JATINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(80, '22BIT045', 'MIHIRKUMAR PRAMODBHAI TALPADA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(81, '22BIT048', 'NEEL JAIMINBHAI SHARMA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(82, '22BIT049', 'NEEL KISHORBHAI AGHERA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(83, '22BIT051', 'NISHA CHANDRAKANTBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(84, '22BIT053', 'OM ASHVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(85, '22BIT054', 'PARTH GHANSHYAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(86, '22BIT055', 'PARTHKUMAR PRAVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(87, '22BIT056', 'PARTHKUMAR VIPULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(88, '22BIT058', 'PAYAL HARESHBHAI BHADANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(89, '22BIT060', 'PRADIPBHAI RAMESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(90, '22BIT061', 'PRIYA JAGDISHBHAI DAVE', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(91, '22BIT062', 'PRIYANKA BHARATBHAI CHAUDHARI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(92, '22BIT064', 'PRIYANKABEN BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(93, '22BIT065', 'RAHUL MANJIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(94, '22BIT066', 'RAVI KIRITBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(95, '22BIT068', 'RIDDHISH KANUBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(96, '22BIT069', 'RINKAL PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(97, '22BIT070', 'RITESHBHAI RAJESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(98, '22BIT071', 'RUSHIK PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(99, '22BIT072', 'SAHIL PRAVINBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(100, '22BIT073', 'SANKET DHIRUBHAI KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(101, '22BIT074', 'SANKET HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(102, '22BIT075', 'SARAL BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(103, '22BIT076', 'SARVESH SHANTIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(104, '22BIT078', 'SHAILESHBHAI PARSHOTAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(105, '22BIT080', 'SHIVAM BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(106, '22BIT081', 'SHRADDHA DIPAKBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(107, '22BIT082', 'SONAL VINODBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(108, '22BIT084', 'TANISH JAYESHRAJ KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(109, '22BIT086', 'TANVIBEN DHIRENBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(110, '22BIT087', 'VATSAL KIRANBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(111, '22BIT088', 'VIDHI JIGNESHBHAI KAPADIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(112, '22BIT001', 'ANISHABEN RAMESHBHAI SINDHA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(113, '22BIT002', 'ANSH NAVINBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(114, '22BIT003', 'ANSHUMAN JAYENDRAKUMAR DODIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(115, '22BIT004', 'YASH NILESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(116, '22BIT005', 'JAYMINKUMAR KHUSHALBHAI MAKWANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(117, '22BIT007', 'BHARGAVKUMAR MAHENDRABHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(118, '22BIT008', 'Bhavesh', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', 'picofme (2).png'),
(119, '22BIT009', 'BHAVYA ASHWINKUMAR PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(120, '22BIT012', 'DEVAM GORDHANBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(121, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', 'p1.jpg'),
(122, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', 'p1.jpg'),
(123, '22BIT016', 'DHRUVILKUMAR DILIPBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(124, '22BIT018', 'HARSHIL MAHENDRASINH PADHIYAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(125, '22BIT019', 'HARSHKUMAR ATULBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(126, '22BIT020', 'HARSHKUMAR BAKULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(127, '22BIT021', 'HEMLATTABEN ALPESHBHAI PARMAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(128, '22BIT022', 'HERRY ANILBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(129, '22BIT023', 'HEVIN VIPULBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(130, '22BIT024', 'MEET DHIRUBHAI GOHEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(131, '22BIT025', 'HONEY JIGNESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(132, '22BIT027', 'JAYDIPBHAI CHANDRAKANTBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(133, '22BIT028', 'JAYESHKUMAR RAMESHBHAI BARIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(134, '22BIT031', 'JEETKUMAR MINESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(135, '22BIT032', 'JENILKUMAR ALPESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(136, '22BIT034', 'KARANSINH VIJAYKUMAR ZALA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(137, '22BIT035', 'KAVITABEN DHARMAMSINH CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(138, '22BIT036', 'KEVAL VINODBHAI RANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(139, '22BIT037', 'KHUSHI SHANTILAL PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(140, '22BIT038', 'KINJALBEN MUKESHBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(141, '22BIT039', 'KRISHNABEN HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(142, '22BIT041', 'MALHAR GOPALBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(143, '22BIT042', 'MANAN INDRAVADAN PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(144, '22BIT043', 'MEETKUMAR ANILBHAI KACHOT', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(145, '22BIT044', 'MEETKUMAR JATINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(146, '22BIT045', 'MIHIRKUMAR PRAMODBHAI TALPADA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(147, '22BIT048', 'NEEL JAIMINBHAI SHARMA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(148, '22BIT049', 'NEEL KISHORBHAI AGHERA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(149, '22BIT051', 'NISHA CHANDRAKANTBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(150, '22BIT053', 'OM ASHVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(151, '22BIT054', 'PARTH GHANSHYAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(152, '22BIT055', 'PARTHKUMAR PRAVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(153, '22BIT056', 'PARTHKUMAR VIPULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(154, '22BIT058', 'PAYAL HARESHBHAI BHADANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(155, '22BIT060', 'PRADIPBHAI RAMESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(156, '22BIT061', 'PRIYA JAGDISHBHAI DAVE', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(157, '22BIT062', 'PRIYANKA BHARATBHAI CHAUDHARI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(158, '22BIT064', 'PRIYANKABEN BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(159, '22BIT065', 'RAHUL MANJIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(160, '22BIT066', 'RAVI KIRITBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(161, '22BIT068', 'RIDDHISH KANUBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(162, '22BIT069', 'RINKAL PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(163, '22BIT070', 'RITESHBHAI RAJESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(164, '22BIT071', 'RUSHIK PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(165, '22BIT072', 'SAHIL PRAVINBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(166, '22BIT073', 'SANKET DHIRUBHAI KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(167, '22BIT074', 'SANKET HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'present', ''),
(168, '22BIT075', 'SARAL BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(169, '22BIT076', 'SARVESH SHANTIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(170, '22BIT078', 'SHAILESHBHAI PARSHOTAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(171, '22BIT080', 'SHIVAM BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(172, '22BIT081', 'SHRADDHA DIPAKBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(173, '22BIT082', 'SONAL VINODBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(174, '22BIT084', 'TANISH JAYESHRAJ KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(175, '22BIT086', 'TANVIBEN DHIRENBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(176, '22BIT087', 'VATSAL KIRANBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(177, '22BIT088', 'VIDHI JIGNESHBHAI KAPADIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-19', 'absent', ''),
(178, '22BIT001', 'ANISHABEN RAMESHBHAI SINDHA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(179, '22BIT002', 'ANSH NAVINBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(180, '22BIT003', 'ANSHUMAN JAYENDRAKUMAR DODIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(181, '22BIT004', 'YASH NILESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(182, '22BIT005', 'JAYMINKUMAR KHUSHALBHAI MAKWANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(183, '22BIT007', 'BHARGAVKUMAR MAHENDRABHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(184, '22BIT008', 'Bhavesh', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'picofme (2).png'),
(185, '22BIT009', 'BHAVYA ASHWINKUMAR PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(186, '22BIT012', 'DEVAM GORDHANBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(187, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'p1.jpg'),
(188, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'p1.jpg'),
(189, '22BIT016', 'DHRUVILKUMAR DILIPBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(190, '22BIT018', 'HARSHIL MAHENDRASINH PADHIYAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(191, '22BIT019', 'HARSHKUMAR ATULBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(192, '22BIT020', 'HARSHKUMAR BAKULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(193, '22BIT021', 'HEMLATTABEN ALPESHBHAI PARMAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(194, '22BIT022', 'HERRY ANILBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(195, '22BIT023', 'HEVIN VIPULBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(196, '22BIT024', 'MEET DHIRUBHAI GOHEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(197, '22BIT025', 'HONEY JIGNESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(198, '22BIT027', 'JAYDIPBHAI CHANDRAKANTBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(199, '22BIT028', 'JAYESHKUMAR RAMESHBHAI BARIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(200, '22BIT031', 'JEETKUMAR MINESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(201, '22BIT032', 'JENILKUMAR ALPESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(202, '22BIT034', 'KARANSINH VIJAYKUMAR ZALA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(203, '22BIT035', 'KAVITABEN DHARMAMSINH CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(204, '22BIT036', 'KEVAL VINODBHAI RANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(205, '22BIT037', 'KHUSHI SHANTILAL PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(206, '22BIT038', 'KINJALBEN MUKESHBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(207, '22BIT039', 'KRISHNABEN HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(208, '22BIT041', 'MALHAR GOPALBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(209, '22BIT042', 'MANAN INDRAVADAN PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(210, '22BIT043', 'MEETKUMAR ANILBHAI KACHOT', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(211, '22BIT044', 'MEETKUMAR JATINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(212, '22BIT045', 'MIHIRKUMAR PRAMODBHAI TALPADA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(213, '22BIT048', 'NEEL JAIMINBHAI SHARMA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(214, '22BIT049', 'NEEL KISHORBHAI AGHERA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(215, '22BIT051', 'NISHA CHANDRAKANTBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(216, '22BIT053', 'OM ASHVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(217, '22BIT054', 'PARTH GHANSHYAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(218, '22BIT055', 'PARTHKUMAR PRAVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(219, '22BIT056', 'PARTHKUMAR VIPULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(220, '22BIT058', 'PAYAL HARESHBHAI BHADANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(221, '22BIT060', 'PRADIPBHAI RAMESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(222, '22BIT061', 'PRIYA JAGDISHBHAI DAVE', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(223, '22BIT062', 'PRIYANKA BHARATBHAI CHAUDHARI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(224, '22BIT064', 'PRIYANKABEN BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(225, '22BIT065', 'RAHUL MANJIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(226, '22BIT066', 'RAVI KIRITBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(227, '22BIT068', 'RIDDHISH KANUBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(228, '22BIT069', 'RINKAL PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(229, '22BIT070', 'RITESHBHAI RAJESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(230, '22BIT071', 'RUSHIK PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(231, '22BIT072', 'SAHIL PRAVINBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(232, '22BIT073', 'SANKET DHIRUBHAI KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(233, '22BIT074', 'SANKET HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(234, '22BIT075', 'SARAL BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(235, '22BIT076', 'SARVESH SHANTIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(236, '22BIT078', 'SHAILESHBHAI PARSHOTAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(237, '22BIT080', 'SHIVAM BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(238, '22BIT081', 'SHRADDHA DIPAKBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(239, '22BIT082', 'SONAL VINODBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(240, '22BIT084', 'TANISH JAYESHRAJ KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(241, '22BIT086', 'TANVIBEN DHIRENBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(242, '22BIT087', 'VATSAL KIRANBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(243, '22BIT088', 'VIDHI JIGNESHBHAI KAPADIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(244, '22BIT001', 'ANISHABEN RAMESHBHAI SINDHA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(245, '22BIT002', 'ANSH NAVINBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(246, '22BIT003', 'ANSHUMAN JAYENDRAKUMAR DODIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(247, '22BIT004', 'YASH NILESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(248, '22BIT005', 'JAYMINKUMAR KHUSHALBHAI MAKWANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(249, '22BIT007', 'BHARGAVKUMAR MAHENDRABHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(250, '22BIT008', 'Bhavesh', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'picofme (2).png'),
(251, '22BIT009', 'BHAVYA ASHWINKUMAR PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(252, '22BIT012', 'DEVAM GORDHANBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(253, '22BIT013', 'Devashish', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'p1.jpg'),
(254, '22BIT015', 'Dhruval', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', 'p1.jpg'),
(255, '22BIT016', 'DHRUVILKUMAR DILIPBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(256, '22BIT018', 'HARSHIL MAHENDRASINH PADHIYAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(257, '22BIT019', 'HARSHKUMAR ATULBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(258, '22BIT020', 'HARSHKUMAR BAKULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(259, '22BIT021', 'HEMLATTABEN ALPESHBHAI PARMAR', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(260, '22BIT022', 'HERRY ANILBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(261, '22BIT023', 'HEVIN VIPULBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(262, '22BIT024', 'MEET DHIRUBHAI GOHEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(263, '22BIT025', 'HONEY JIGNESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(264, '22BIT027', 'JAYDIPBHAI CHANDRAKANTBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(265, '22BIT028', 'JAYESHKUMAR RAMESHBHAI BARIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(266, '22BIT031', 'JEETKUMAR MINESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(267, '22BIT032', 'JENILKUMAR ALPESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(268, '22BIT034', 'KARANSINH VIJAYKUMAR ZALA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(269, '22BIT035', 'KAVITABEN DHARMAMSINH CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(270, '22BIT036', 'KEVAL VINODBHAI RANA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(271, '22BIT037', 'KHUSHI SHANTILAL PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(272, '22BIT038', 'KINJALBEN MUKESHBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(273, '22BIT039', 'KRISHNABEN HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(274, '22BIT041', 'MALHAR GOPALBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(275, '22BIT042', 'MANAN INDRAVADAN PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(276, '22BIT043', 'MEETKUMAR ANILBHAI KACHOT', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(277, '22BIT044', 'MEETKUMAR JATINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(278, '22BIT045', 'MIHIRKUMAR PRAMODBHAI TALPADA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(279, '22BIT048', 'NEEL JAIMINBHAI SHARMA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(280, '22BIT049', 'NEEL KISHORBHAI AGHERA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(281, '22BIT051', 'NISHA CHANDRAKANTBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(282, '22BIT053', 'OM ASHVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(283, '22BIT054', 'PARTH GHANSHYAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(284, '22BIT055', 'PARTHKUMAR PRAVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(285, '22BIT056', 'PARTHKUMAR VIPULBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(286, '22BIT058', 'PAYAL HARESHBHAI BHADANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(287, '22BIT060', 'PRADIPBHAI RAMESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(288, '22BIT061', 'PRIYA JAGDISHBHAI DAVE', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(289, '22BIT062', 'PRIYANKA BHARATBHAI CHAUDHARI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(290, '22BIT064', 'PRIYANKABEN BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(291, '22BIT065', 'RAHUL MANJIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(292, '22BIT066', 'RAVI KIRITBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(293, '22BIT068', 'RIDDHISH KANUBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(294, '22BIT069', 'RINKAL PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(295, '22BIT070', 'RITESHBHAI RAJESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'present', ''),
(296, '22BIT071', 'RUSHIK PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(297, '22BIT072', 'SAHIL PRAVINBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(298, '22BIT073', 'SANKET DHIRUBHAI KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(299, '22BIT074', 'SANKET HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(300, '22BIT075', 'SARAL BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(301, '22BIT076', 'SARVESH SHANTIBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(302, '22BIT078', 'SHAILESHBHAI PARSHOTAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(303, '22BIT080', 'SHIVAM BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(304, '22BIT081', 'SHRADDHA DIPAKBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(305, '22BIT082', 'SONAL VINODBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(306, '22BIT084', 'TANISH JAYESHRAJ KATHROTIYA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(307, '22BIT086', 'TANVIBEN DHIRENBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(308, '22BIT087', 'VATSAL KIRANBHAI PATEL', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', ''),
(309, '22BIT088', 'VIDHI JIGNESHBHAI KAPADIA', 'TY BSc CA & IT', 'Division A', 6, '2025-01-24', 'absent', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_mst`
--

CREATE TABLE `student_mst` (
  `roll_number` varchar(20) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(20) NOT NULL,
  `division` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_mst`
--

INSERT INTO `student_mst` (`roll_number`, `student_id`, `name`, `department`, `division`, `semester`, `email`, `phone`, `photo`) VALUES
('22BCA005', 1, 'harsh', 'FY BCA', 'Division C', '3', 'yaheno6113@nausard.com', '8765456783', 0x53637265656e73686f7420323032342d31322d3130203231343235352e706e67),
('22BCA008', 8, 'Hank Miller', 'TY BSc CA & IT', 'Division D', '8', 'tanisal336@fundapk.com', '9408479356', 0x53637265656e73686f7420323032352d30312d3033203232313133382e706e67),
('22BCA015', 15, 'Dhruval', 'TY BCA', 'Division B', '6', 'student15@gmail.com', '8765456783', 0x757365722e706e67),
('22BCA021', 21, 'Vera Scott', 'TY BCA', 'Division A', '5', 'vera.scott21@example.com', '9876543121', 0x766572612e6a7067),
('22BCA025', 25, 'Zane Fox', 'FY BCA', 'Division A', '1', 'zane.fox25@example.com', '9876543125', 0x7a616e652e6a7067),
('22BCA026', 26, 'Ava Turner', 'SY BCA', 'Division B', '2', 'ava.turner26@example.com', '9876543126', 0x6176612e6a7067),
('22BCA027', 27, 'Ben Hall', 'TY BCA', 'Division C', '3', 'ben.hall27@example.com', '9876543127', 0x62656e2e6a7067),
('22BCA031', 31, 'Finn Hope', 'FY BCA', 'Division C', '7', 'finn.hope31@example.com', '9876543131', 0x66696e6e2e6a7067),
('22BCA032', 32, 'Gina Quinn', 'SY BCA', 'Division D', '8', 'gina.quinn32@example.com', '9876543132', 0x67696e612e6a7067),
('22BCA037', 37, 'Lara White', 'FY BCA', 'Division A', '5', 'lara.white37@example.com', '9876543137', 0x6c6172612e6a7067),
('22BCA039', 39, 'Nina Cross', 'TY BCA', 'Division C', '7', 'nina.cross39@example.com', '9876543139', 0x6e696e612e6a7067),
('22BCA099', 99, 'Nisha Prajapati', 'BCA', 'Division A', '6', 'nishap51@gmail.com', '9876543267', NULL),
('22BIT001', 1, 'ANISHABEN RAMESHBHAI SINDHA', 'TY BSc CA & IT', 'Division A', '6', 'anisha1@example.com', '9106099048', NULL),
('22BIT002', 2, 'ANSH NAVINBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', '6', 'ansh2@example.com', '8849856562', NULL),
('22BIT003', 3, 'ANSHUMAN JAYENDRAKUMAR DODIYA', 'TY BSc CA & IT', 'Division A', '6', 'anshuman3@example.com', '973785289', NULL),
('22BIT004', 4, 'YASH NILESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'yash4@example.com', '7016870470', NULL),
('22BIT005', 5, 'JAYMINKUMAR KHUSHALBHAI MAKWANA', 'TY BSc CA & IT', 'Division A', '6', 'jaymin5@example.com', '', NULL),
('22BIT007', 6, 'BHARGAVKUMAR MAHENDRABHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'bhargav6@example.com', '7984434289', NULL),
('22BIT008', 41, 'Bhavesh', 'TY BSc CA & IT', 'Division A', '6', 'bhavubhoi806@gmail.com', '7096672257', 0x7069636f666d65202832292e706e67),
('22BIT009', 8, 'BHAVYA ASHWINKUMAR PATEL', 'TY BSc CA & IT', 'Division A', '6', 'bhavya8@example.com', '9106738132', NULL),
('22BIT012', 9, 'DEVAM GORDHANBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', '6', 'devam9@example.com', '9104087396', NULL),
('22BIT013', 42, 'Devashish', 'TY BSc CA & IT', 'Division A', '6', 'dmac13@gmail.com', '2738945867', 0x70312e6a7067),
('22BIT015', 43, 'Dhruval', 'TY BSc CA & IT', 'Division A', '6', 'dd15@gmail.com', '9876543218', 0x70312e6a7067),
('22BIT016', 12, 'DHRUVILKUMAR DILIPBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', '6', 'dhruvil12@example.com', '9316597747', NULL),
('22BIT018', 13, 'HARSHIL MAHENDRASINH PADHIYAR', 'TY BSc CA & IT', 'Division A', '6', 'harshil13@example.com', '8849765809', NULL),
('22BIT019', 14, 'HARSHKUMAR ATULBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', '6', 'harsh14@example.com', '9723947850', NULL),
('22BIT020', 15, 'HARSHKUMAR BAKULBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'harsh15@example.com', '9313298182', NULL),
('22BIT021', 16, 'HEMLATTABEN ALPESHBHAI PARMAR', 'TY BSc CA & IT', 'Division A', '6', 'hemlatta16@example.com', '8200404181', NULL),
('22BIT022', 16, 'HERRY ANILBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'herry17@example.com', '9313662557', NULL),
('22BIT023', 17, 'HEVIN VIPULBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', '6', 'hevin18@example.com', '6359437197', NULL),
('22BIT024', 18, 'MEET DHIRUBHAI GOHEL', 'TY BSc CA & IT', 'Division A', '6', 'meet19@example.com', '9316962724', NULL),
('22BIT025', 19, 'HONEY JIGNESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'honey20@example.com', '9724062640', NULL),
('22BIT027', 24, 'JAYDIPBHAI CHANDRAKANTBHAI SOLANKI', 'TY BSc CA & IT', 'Division A', '6', 'jaydip.solanki@example.com', '9737616956', NULL),
('22BIT028', 25, 'JAYESHKUMAR RAMESHBHAI BARIA', 'TY BSc CA & IT', 'Division A', '6', 'jayesh.baria@example.com', '9313106580', NULL),
('22BIT031', 26, 'JEETKUMAR MINESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'jeet.patel@example.com', '7567660128', NULL),
('22BIT032', 27, 'JENILKUMAR ALPESHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'jenil.patel@example.com', '9510989384', NULL),
('22BIT034', 28, 'KARANSINH VIJAYKUMAR ZALA', 'TY BSc CA & IT', 'Division A', '6', 'karan.zala@example.com', '9898342647', NULL),
('22BIT035', 29, 'KAVITABEN DHARMAMSINH CHAUHAN', 'TY BSc CA & IT', 'Division A', '6', 'kavita.chauhan@example.com', '9023643478', NULL),
('22BIT036', 30, 'KEVAL VINODBHAI RANA', 'TY BSc CA & IT', 'Division A', '6', 'keval.rana@example.com', '6356106406', NULL),
('22BIT037', 31, 'KHUSHI SHANTILAL PATEL', 'TY BSc CA & IT', 'Division A', '6', 'khushi.patel@example.com', '8200912869', NULL),
('22BIT038', 32, 'KINJALBEN MUKESHBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', '6', 'kinjal.chauhan@example.com', '9081686829', NULL),
('22BIT039', 33, 'KRISHNABEN HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'krishna.patel@example.com', '9824284480', NULL),
('22BIT041', 34, 'MALHAR GOPALBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'malhar.patel@example.com', '6353897581', NULL),
('22BIT042', 35, 'MANAN INDRAVADAN PATEL', 'TY BSc CA & IT', 'Division A', '6', 'manan.patel@example.com', '7573004686', NULL),
('22BIT043', 36, 'MEETKUMAR ANILBHAI KACHOT', 'TY BSc CA & IT', 'Division A', '6', 'meet.kachot@example.com', '9104079646', NULL),
('22BIT044', 37, 'MEETKUMAR JATINBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'meet.jatin@example.com', '7041922255', NULL),
('22BIT045', 38, 'MIHIRKUMAR PRAMODBHAI TALPADA', 'TY BSc CA & IT', 'Division A', '6', 'mihir.talpada@example.com', '9428647502', NULL),
('22BIT048', 39, 'NEEL JAIMINBHAI SHARMA', 'TY BSc CA & IT', 'Division A', '6', 'neel.sharma@example.com', '9726136851', NULL),
('22BIT049', 40, 'NEEL KISHORBHAI AGHERA', 'TY BSc CA & IT', 'Division A', '6', 'neel.aghera@example.com', '9023319582', NULL),
('22BIT051', 41, 'NISHA CHANDRAKANTBHAI PRAJAPATI', 'TY BSc CA & IT', 'Division A', '6', 'nisha.prajapati@example.com', '9664864937', NULL),
('22BIT053', 42, 'OM ASHVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'om.patel@example.com', '9879320371', NULL),
('22BIT054', 43, 'PARTH GHANSHYAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'parth.patel@example.com', '9825857004', NULL),
('22BIT055', 44, 'PARTHKUMAR PRAVINBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'parthkumar.patel@example.com', '9328506824', NULL),
('22BIT056', 45, 'PARTHKUMAR VIPULBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'parth.vipul@example.com', '6353560513', NULL),
('22BIT058', 46, 'PAYAL HARESHBHAI BHADANI', 'TY BSc CA & IT', 'Division A', '6', 'payal.bhadani@example.com', '9909287829', NULL),
('22BIT060', 47, 'PRADIPBHAI RAMESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', '6', 'pradip.vaghani@example.com', '8866151968', NULL),
('22BIT061', 48, 'PRIYA JAGDISHBHAI DAVE', 'TY BSc CA & IT', 'Division A', '6', 'priya.dave@example.com', '995461832', NULL),
('22BIT062', 49, 'PRIYANKA BHARATBHAI CHAUDHARI', 'TY BSc CA & IT', 'Division A', '6', 'priyanka.chaudhari@example.com', '8320214070', NULL),
('22BIT064', 50, 'PRIYANKABEN BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'priyankaben.patel@example.com', '9316426479', NULL),
('22BIT065', 51, 'RAHUL MANJIBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'rahul.patel@example.com', '6354263331', NULL),
('22BIT066', 52, 'RAVI KIRITBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'ravi.patel@example.com', '7016179541', NULL),
('22BIT068', 53, 'RIDDHISH KANUBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'riddhish.patel@example.com', '7359307321', NULL),
('22BIT069', 54, 'RINKAL PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'rinkal.patel@example.com', '8758417060', NULL),
('22BIT070', 55, 'RITESHBHAI RAJESHBHAI VAGHANI', 'TY BSc CA & IT', 'Division A', '6', 'ritesh.vaghani@example.com', '9313787527', NULL),
('22BIT071', 56, 'RUSHIK PANKAJBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'rushik.patel@example.com', '9408201580', NULL),
('22BIT072', 57, 'SAHIL PRAVINBHAI KACHHADIYA', 'TY BSc CA & IT', 'Division A', '6', 'sahil.kachhadiya@example.com', '9313398722', NULL),
('22BIT073', 58, 'SANKET DHIRUBHAI KATHROTIYA', 'TY BSc CA & IT', 'Division A', '6', 'sanket.kathrotiya@example.com', '', NULL),
('22BIT074', 59, 'SANKET HASMUKHBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'sanket.patel@example.com', '', NULL),
('22BIT075', 60, 'SARAL BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'saral.patel@example.com', '9712788187', NULL),
('22BIT076', 61, 'SARVESH SHANTIBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'sarvesh.patel@example.com', '8238333015', NULL),
('22BIT078', 62, 'SHAILESHBHAI PARSHOTAMBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'shailesh.patel@example.com', '8160207636', NULL),
('22BIT080', 63, 'SHIVAM BHARATBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'shivam.patel@example.com', '7990987002', NULL),
('22BIT081', 64, 'SHRADDHA DIPAKBHAI CHAUHAN', 'TY BSc CA & IT', 'Division A', '6', 'shraddha.chauhan@example.com', '9429035606', NULL),
('22BIT082', 65, 'SONAL VINODBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'sonal.patel@example.com', '8780011909', NULL),
('22BIT084', 66, 'TANISH JAYESHRAJ KATHROTIYA', 'TY BSc CA & IT', 'Division A', '6', 'tanish.kathrotiya@example.com', '9099565495', NULL),
('22BIT086', 67, 'TANVIBEN DHIRENBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'tanvi.patel@example.com', '', NULL),
('22BIT087', 68, 'VATSAL KIRANBHAI PATEL', 'TY BSc CA & IT', 'Division A', '6', 'vatsal.patel@example.com', '', NULL),
('22BIT088', 69, 'VIDHI JIGNESHBHAI KAPADIA', 'TY BSc CA & IT', 'Division A', '6', 'vidhi.kapadia@example.com', '', NULL),
('23BCA050', 50, 'Priya', 'FY BCA', 'Division A', '1', 'priya50@gmail.com', '9876543267', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_login`
--

CREATE TABLE `teacher_login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_login`
--

INSERT INTO `teacher_login` (`id`, `email`, `password`) VALUES
(1, 'teacher01@gmail.com', 'teacher01'),
(2, 'teacher02@gmail.com', 'teacher02'),
(3, 'teacher03@gmail.com', 'teacher03'),
(4, 'teacher04@gmail.com', 'teacher04');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_mst`
--

CREATE TABLE `teacher_mst` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_mst`
--

INSERT INTO `teacher_mst` (`teacher_id`, `name`, `dob`, `doj`, `email`, `phone`, `address`, `department`, `qualification`, `experience`, `specialization`, `profile_photo`, `password`) VALUES
(23, 'Alexa', '2024-10-27', '2024-11-26', 'alexa@gmail.com', '9876543218', 'Croatia', 'CS', 'CS IT', '5 years', 'IT', 'p6.jpg', 'Alexa06'),
(25, 'Teacher2', '2024-10-29', '2024-11-21', 'teacher02@gmail.com', '2738945867', 'dsvdfbdds', 'IT', 'CS IT', '5 years', 'CS', 'uploads/25_miles-morales-5120x2880-18800.png', 'teacher002'),
(31, 'meet', '2024-11-08', '2024-11-28', 'meet@example.com', '7689456784', 'borsad', 'IT', 'MIT', '7 years', 'Developer', 'p2.jpg', 'meet'),
(35, 'Bhavesh Bhoi', '2004-05-07', '2024-12-01', 'bhavubhoi806@gmail.com', '7096672257', 'Anand', 'BSc CA & IT', '12th', '1 Year', 'Full Stack Web Developer', 'user.png', 'Bhavu_07'),
(36, 'Teacher05', '2024-12-19', '2024-12-19', 'teacher05@gmail.com', '8765456783', 'Anand', 'BCA', 'MSc IT', '2.5 Years', 'Teacher', 'user.png', 'Teacher005'),
(37, 'Bhavesh Bhoi', '2004-05-07', '2025-01-14', 'bhavubhoi806@gmail.com', '9408479356', 'Anand', 'BSc CA & IT', 'Information Techno', '2 Years', 'Software Developer', '', 'Bhavu_07'),
(50, 'codeTech', '2025-01-13', '2025-01-22', 'teacher05@gmail.com', '9408479356', 'anand', 'BSc CA & IT', 'Information Techno', '2.5 Years', 'Teacher', '', 'teacher05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_mst`
--
ALTER TABLE `admin_mst`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance_mst`
--
ALTER TABLE `attendance_mst`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roll_number` (`roll_number`);

--
-- Indexes for table `student_mst`
--
ALTER TABLE `student_mst`
  ADD PRIMARY KEY (`roll_number`);

--
-- Indexes for table `teacher_login`
--
ALTER TABLE `teacher_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teacher_mst`
--
ALTER TABLE `teacher_mst`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance_mst`
--
ALTER TABLE `attendance_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `teacher_login`
--
ALTER TABLE `teacher_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teacher_mst`
--
ALTER TABLE `teacher_mst`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_mst`
--
ALTER TABLE `admin_mst`
  ADD CONSTRAINT `admin_mst_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_login` (`id`);

--
-- Constraints for table `attendance_mst`
--
ALTER TABLE `attendance_mst`
  ADD CONSTRAINT `attendance_mst_ibfk_1` FOREIGN KEY (`roll_number`) REFERENCES `student_mst` (`roll_number`);
--
-- Database: `bluebirdhotel`
--
CREATE DATABASE IF NOT EXISTS `bluebirdhotel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bluebirdhotel`;

-- --------------------------------------------------------

--
-- Table structure for table `emp_login`
--

CREATE TABLE `emp_login` (
  `empid` int(100) NOT NULL,
  `Emp_Email` varchar(50) NOT NULL,
  `Emp_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_login`
--

INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(1, 'Admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `NoofRoom` int(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `noofdays` int(30) NOT NULL,
  `roomtotal` double(8,2) NOT NULL,
  `bedtotal` double(8,2) NOT NULL,
  `meal` varchar(30) NOT NULL,
  `mealtotal` double(8,2) NOT NULL,
  `finaltotal` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `Name`, `Email`, `RoomType`, `Bed`, `NoofRoom`, `cin`, `cout`, `noofdays`, `roomtotal`, `bedtotal`, `meal`, `mealtotal`, `finaltotal`) VALUES
(41, 'Tushar pankhaniya', 'pankhaniyatushar9@gmail.com', 'Single Room', 'Single', 1, '2022-11-09', '2022-11-10', 1, 1000.00, 10.00, 'Room only', 0.00, 1010.00);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `type`, `bedding`) VALUES
(4, 'Superior Room', 'Single'),
(6, 'Superior Room', 'Triple'),
(7, 'Superior Room', 'Quad'),
(8, 'Deluxe Room', 'Single'),
(9, 'Deluxe Room', 'Double'),
(10, 'Deluxe Room', 'Triple'),
(11, 'Guest House', 'Single'),
(12, 'Guest House', 'Double'),
(13, 'Guest House', 'Triple'),
(14, 'Guest House', 'Quad'),
(16, 'Superior Room', 'Double'),
(20, 'Single Room', 'Single'),
(22, 'Superior Room', 'Single'),
(23, 'Deluxe Room', 'Single'),
(24, 'Deluxe Room', 'Triple'),
(27, 'Guest House', 'Double'),
(30, 'Deluxe Room', 'Single');

-- --------------------------------------------------------

--
-- Table structure for table `roombook`
--

CREATE TABLE `roombook` (
  `id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `Meal` varchar(30) NOT NULL,
  `NoofRoom` varchar(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `nodays` int(50) NOT NULL,
  `stat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roombook`
--

INSERT INTO `roombook` (`id`, `Name`, `Email`, `Country`, `Phone`, `RoomType`, `Bed`, `Meal`, `NoofRoom`, `cin`, `cout`, `nodays`, `stat`) VALUES
(41, 'Tushar pankhaniya', 'pankhaniyatushar9@gmail.com', 'India', '9313346569', 'Single Room', 'Single', 'Room only', '1', '2022-11-09', '2022-11-10', 1, 'Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`UserID`, `Username`, `Email`, `Password`) VALUES
(1, 'Tushar Pankhaniya', 'tusharpankhaniya2202@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `work` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `work`) VALUES
(1, 'Tushar pankhaniya', 'Manager'),
(3, 'rohit patel', 'Cook'),
(4, 'Dipak', 'Cook'),
(5, 'tirth', 'Helper'),
(6, 'mohan', 'Helper'),
(7, 'shyam', 'cleaner'),
(8, 'rohan', 'weighter'),
(9, 'hiren', 'weighter'),
(10, 'nikunj', 'weighter'),
(11, 'rekha', 'Cook');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_login`
--
ALTER TABLE `emp_login`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_login`
--
ALTER TABLE `emp_login`
  MODIFY `empid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Database: `component_marketplace`
--
CREATE DATABASE IF NOT EXISTS `component_marketplace` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `component_marketplace`;

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `source_code` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `payment_intent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Database: `employee_db`
--
CREATE DATABASE IF NOT EXISTS `employee_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `employee_db`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(50) DEFAULT NULL,
  `institute_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `leaving_date` date DEFAULT NULL,
  `emp_category` varchar(50) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `mother_name` varchar(150) DEFAULT NULL,
  `spouse_name` varchar(150) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `alt_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `ifsc_code` varchar(15) DEFAULT NULL,
  `pan_number` varchar(15) DEFAULT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL,
  `salary_category` varchar(50) DEFAULT NULL,
  `other_salary_category` varchar(100) DEFAULT NULL,
  `duty_hours` decimal(5,2) DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `hours_per_day` decimal(5,2) DEFAULT NULL,
  `salary_pay_band` varchar(50) DEFAULT NULL,
  `basic_salary` decimal(10,2) DEFAULT NULL,
  `pf_number` varchar(50) DEFAULT NULL,
  `pf_join_date` date DEFAULT NULL,
  `ca` decimal(10,2) DEFAULT NULL,
  `da` decimal(10,2) DEFAULT NULL,
  `hra` decimal(10,2) DEFAULT NULL,
  `ta` decimal(10,2) DEFAULT NULL,
  `ma` decimal(10,2) DEFAULT NULL,
  `other_allowance` decimal(10,2) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `aadhar_copy` varchar(255) DEFAULT NULL,
  `pan_copy` varchar(255) DEFAULT NULL,
  `bank_copy` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `approve` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_code`, `institute_name`, `department`, `designation`, `location`, `joining_date`, `leaving_date`, `emp_category`, `full_name`, `gender`, `blood_group`, `nationality`, `dob`, `father_name`, `mother_name`, `spouse_name`, `mobile_number`, `alt_number`, `email`, `address`, `bank_name`, `branch_name`, `account_number`, `ifsc_code`, `pan_number`, `aadhar_number`, `salary_category`, `other_salary_category`, `duty_hours`, `total_hours`, `hours_per_day`, `salary_pay_band`, `basic_salary`, `pf_number`, `pf_join_date`, `ca`, `da`, `hra`, `ta`, `ma`, `other_allowance`, `profile_photo`, `aadhar_copy`, `pan_copy`, `bank_copy`, `created_at`, `updated_at`, `approve`) VALUES
(1, 'EMP001', 'Institute A', 'IT', 'Developer', 'dn', '2023-01-01', '2024-12-19', 'adhoc', 'John Doe', 'Male', 'O+', 'indian', '1990-05-15', 'Father A', 'Mother A', 'Spouse A', '9876543210', '9123456780', 'john.doe@example.com', 'Address 1', 'pnb', 'Branch A', '1234567890', 'IFSC001', 'BAJPC4350M', '518053869918', 'adhoc_with_pf', NULL, 8.00, 160.00, 8.00, 'PB-1', 50000.00, 'PF001', '2023-01-15', 2000.00, 3000.00, 1500.00, 1000.00, 700.00, 2000.00, '\"C:\\Users\\user\\Pictures\\Wallpapers\\range_rover_sport_park_city_edition_2024_5k-3840x2160.jpg\"', 'aadhar1.pdf', 'pan1.pdf', 'bank1.pdf', '2023-01-01 04:30:00', '2025-01-01 16:01:50', 0),
(2, 'EMP002', 'Institute B', 'HR', 'Manager', 'City B', '2022-06-15', NULL, 'Contract', 'Jane Smith', 'Female', 'A+', 'Indian', '1985-07-20', 'Father B', 'Mother B', NULL, '8765432109', '9213456789', 'jane.smith@example.com', 'Address 2', 'Bank B', 'Branch B', '0987654321', 'IFSC002', 'PAN002', 'AADHAR002', 'B', NULL, 7.50, 150.00, 7.50, 'PB-2', 60000.00, 'PF002', '2022-07-01', 2500.00, 3500.00, 1800.00, 1200.00, 600.00, 2500.00, 'photo2.jpg', 'aadhar2.pdf', 'pan2.pdf', 'bank2.pdf', '2022-06-15 03:30:00', '2022-06-15 03:30:00', 0),
(3, 'EMP003', 'Institute C', 'Finance', 'Analyst', 'City C', '2021-03-10', NULL, 'Permanent', 'Mike Johnson', 'Male', 'B+', 'Indian', '1992-11-12', 'Father C', 'Mother C', 'Spouse C', '7654321098', '9321456789', 'mike.johnson@example.com', 'Address 3', 'Bank C', 'Branch C', '1122334455', 'IFSC003', 'PAN003', 'AADHAR003', 'A', 'Special', 8.50, 170.00, 8.50, 'PB-1', 55000.00, 'PF003', '2021-03-20', 2200.00, 3200.00, 1600.00, 1100.00, 550.00, 2200.00, 'photo3.jpg', 'aadhar3.pdf', 'pan3.pdf', 'bank3.pdf', '2021-03-10 03:00:00', '2021-03-10 03:00:00', 0),
(4, 'EMP004', 'Institute D', 'Engineering', 'Technician', 'City D', '2020-08-05', NULL, 'Permanent', 'Alice Brown', 'Female', 'AB-', 'Indian', '1988-09-18', 'Father D', 'Mother D', NULL, '6543210987', '9432156789', 'alice.brown@example.com', 'Address 4', 'Bank D', 'Branch D', '5566778899', 'IFSC004', 'PAN004', 'AADHAR004', 'B', NULL, 9.00, 180.00, 9.00, 'PB-2', 58000.00, 'PF004', '2020-08-15', 2300.00, 3400.00, 1700.00, 1150.00, 575.00, 2300.00, 'photo4.jpg', 'aadhar4.pdf', 'pan4.pdf', 'bank4.pdf', '2020-08-05 02:30:00', '2020-08-05 02:30:00', 0),
(5, 'EMP005', 'Institute E', 'Marketing', 'Executive', 'City E', '2019-12-01', NULL, 'Contract', 'Tom Wilson', 'Male', 'O-', 'Indian', '1991-03-25', 'Father E', 'Mother E', 'Spouse E', '5432109876', '9543215678', 'tom.wilson@example.com', 'Address 5', 'Bank E', 'Branch E', '9988776655', 'IFSC005', 'PAN005', 'AADHAR005', 'A', NULL, 8.00, 160.00, 8.00, 'PB-3', 52000.00, 'PF005', '2019-12-15', 2100.00, 3100.00, 1550.00, 1050.00, 525.00, 2100.00, 'photo5.jpg', 'aadhar5.pdf', 'pan5.pdf', 'bank5.pdf', '2019-12-01 02:00:00', '2019-12-01 02:00:00', 0),
(6, 'EMP006', 'Institute F', 'Sales', 'Coordinator', 'City F', '2023-02-15', NULL, 'Permanent', 'Emma Davis', 'Female', 'A-', 'Indian', '1990-12-22', 'Father F', 'Mother F', NULL, '4321098765', '9654321567', 'emma.davis@example.com', 'Address 6', 'Bank F', 'Branch F', '6677889900', 'IFSC006', 'PAN006', 'AADHAR006', 'B', NULL, 8.25, 165.00, 8.25, 'PB-2', 56000.00, 'PF006', '2023-02-25', 2400.00, 3300.00, 1650.00, 1125.00, 562.50, 2400.00, 'photo6.jpg', 'aadhar6.pdf', 'pan6.pdf', 'bank6.pdf', '2023-02-15 05:00:00', '2023-02-15 05:00:00', 0),
(7, 'EMP007', 'Institute G', 'IT', 'Support', 'City G', '2022-04-20', NULL, 'Permanent', 'Robert Moore', 'Male', 'B-', 'Indian', '1993-07-08', 'Father G', 'Mother G', 'Spouse G', '3210987654', '9765432156', 'robert.moore@example.com', 'Address 7', 'Bank G', 'Branch G', '7788990011', 'IFSC007', 'PAN007', 'AADHAR007', 'A', 'Custom', 9.50, 190.00, 9.50, 'PB-3', 60000.00, 'PF007', '2022-05-01', 2600.00, 3700.00, 1850.00, 1225.00, 612.50, 2600.00, 'photo7.jpg', 'aadhar7.pdf', 'pan7.pdf', 'bank7.pdf', '2022-04-20 05:30:00', '2022-04-20 05:30:00', 0),
(8, 'EMP008', 'Institute H', 'Operations', 'Supervisor', 'City H', '2021-11-05', NULL, 'Contract', 'Laura White', 'Female', 'AB+', 'Indian', '1987-06-14', 'Father H', 'Mother H', NULL, '2109876543', '9876543212', 'laura.white@example.com', 'Address 8', 'Bank H', 'Branch H', '8899001122', 'IFSC008', 'PAN008', 'AADHAR008', 'B', NULL, 7.75, 155.00, 7.75, 'PB-1', 53000.00, 'PF008', '2021-11-15', 2150.00, 3150.00, 1575.00, 1075.00, 537.50, 2150.00, 'photo8.jpg', 'aadhar8.pdf', 'pan8.pdf', 'bank8.pdf', '2021-11-05 06:30:00', '2021-11-05 06:30:00', 0),
(9, 'EMP009', 'Institute I', 'HR', 'Recruiter', 'City I', '2020-10-12', NULL, 'Permanent', 'Oliver Martin', 'Male', 'O+', 'Indian', '1994-02-10', 'Father I', 'Mother I', NULL, '1098765432', '9987654321', 'oliver.martin@example.com', 'Address 9', 'Bank I', 'Branch I', '1234432112', 'IFSC009', 'PAN009', 'AADHAR009', 'A', NULL, 8.50, 170.00, 8.50, 'PB-2', 54000.00, 'PF009', '2020-10-22', 2200.00, 3200.00, 1600.00, 1100.00, 550.00, 2200.00, 'photo9.jpg', 'aadhar9.pdf', 'pan9.pdf', 'bank9.pdf', '2020-10-12 03:15:00', '2020-10-12 03:15:00', 0),
(11, 'EMP011', 'Institute A', 'IT', 'Developer', 'City A', '2023-01-01', NULL, 'Permanent', 'John Doe', 'Male', 'O+', 'Indian', '1990-05-15', 'Father A', 'Mother A', 'Spouse A', '9876543210', '9123456780', 'john.doe@example.com', 'Address 1', 'Bank A', 'Branch A', '1234567890', 'IFSC001', 'PAN001', 'AADHAR001', 'A', NULL, 8.00, 160.00, 8.00, 'PB-1', 50000.00, 'PF001', '2023-01-15', 2000.00, 3000.00, 1500.00, 1000.00, 500.00, 2000.00, NULL, NULL, NULL, NULL, '2024-12-31 04:59:47', '2024-12-31 04:59:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrator','college','school') NOT NULL,
  `admin_code` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `institution_id` varchar(10) DEFAULT NULL,
  `institution_name` varchar(100) DEFAULT NULL,
  `institution_type` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `admin_code`, `department`, `institution_id`, `institution_name`, `institution_type`, `address`, `reset_token`, `reset_token_expiry`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John', 'Doe', 'john.doe1@example.com', 'hashedpassword1', 'administrator', 'ADMIN123', 'IT', 'INST001', 'Tech University', 'University', '123 Tech Lane, Cityville', NULL, NULL, NULL, '2025-01-19 06:30:05', '2025-01-19 06:30:05'),
(2, 'John', 'Doe', 'john.doe2@example.com', 'hashedpassword1', 'administrator', 'ADMIN123', 'IT', 'INST001', 'Tech University', 'University', '123 Tech Lane, Cityville', NULL, NULL, NULL, '2025-01-19 06:30:05', '2025-01-19 06:30:05'),
(3, 'John', 'Doe', 'john.doe3@example.com', 'hashedpassword1', 'administrator', 'ADMIN123', 'IT', 'INST001', 'Tech University', 'University', '123 Tech Lane, Cityville', NULL, NULL, NULL, '2025-01-19 06:30:05', '2025-01-19 06:30:05'),
(4, 'John', 'Doe', 'john.doe4@example.com', 'hashedpassword1', 'administrator', 'ADMIN123', 'IT', 'INST001', 'Tech University', 'University', '123 Tech Lane, Cityville', NULL, NULL, NULL, '2025-01-19 06:30:05', '2025-01-19 06:30:05'),
(5, 'John', 'Doe', 'john.doe5@example.com', 'hashedpassword1', 'administrator', 'ADMIN123', 'IT', 'INST001', 'Tech University', 'University', '123 Tech Lane, Cityville', NULL, NULL, NULL, '2025-01-19 06:30:05', '2025-01-19 06:30:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Database: `employee_management`
--
CREATE DATABASE IF NOT EXISTS `employee_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `employee_management`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `institute_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `location` varchar(50) NOT NULL,
  `joining_date` date NOT NULL,
  `leaving_date` date DEFAULT NULL,
  `emp_category` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `alt_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `ifsc_code` varchar(20) NOT NULL,
  `pan_number` varchar(10) NOT NULL,
  `aadhar_number` varchar(12) NOT NULL,
  `salary_category` varchar(50) NOT NULL,
  `other_salary_category` varchar(100) DEFAULT NULL,
  `duty_hours` int(11) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `hours_per_day` int(11) NOT NULL,
  `salary_pay_band` varchar(50) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `pf_number` varchar(50) DEFAULT NULL,
  `pf_join_date` date DEFAULT NULL,
  `ca` decimal(10,2) DEFAULT NULL,
  `da` decimal(10,2) DEFAULT NULL,
  `pa` decimal(10,2) DEFAULT NULL,
  `hra` decimal(10,2) DEFAULT NULL,
  `ta` decimal(10,2) DEFAULT NULL,
  `ma` decimal(10,2) DEFAULT NULL,
  `oa` decimal(10,2) DEFAULT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `aadhar_copy` varchar(255) NOT NULL,
  `pan_copy` varchar(255) NOT NULL,
  `bank_copy` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_code`, `institute_name`, `department`, `designation`, `location`, `joining_date`, `leaving_date`, `emp_category`, `full_name`, `gender`, `blood_group`, `nationality`, `dob`, `father_name`, `mother_name`, `spouse_name`, `mobile_number`, `alt_number`, `email`, `address`, `bank_name`, `branch_name`, `account_number`, `ifsc_code`, `pan_number`, `aadhar_number`, `salary_category`, `other_salary_category`, `duty_hours`, `total_hours`, `hours_per_day`, `salary_pay_band`, `basic_salary`, `pf_number`, `pf_join_date`, `ca`, `da`, `pa`, `hra`, `ta`, `ma`, `oa`, `profile_photo`, `aadhar_copy`, `pan_copy`, `bank_copy`, `created_at`) VALUES
(1, 'EMP001', 'Institute A', 'IT', 'Developer', 'City A', '2023-01-01', NULL, 'Permanent', 'John Doe', 'Male', 'O+', 'Indian', '1990-01-01', 'Father A', 'Mother A', 'Spouse A', '1234567890', '9876543210', 'john.doe@example.com', '123 Street A', 'Bank A', 'Branch A', '111122223333', 'IFSC001', 'PAN001', 'AADHAR001', 'Category A', NULL, 8, 40, 8, 'Band A', 50000.00, NULL, NULL, 1000.00, 2000.00, 1500.00, 3000.00, 800.00, 1200.00, 500.00, 'photo1.jpg', 'aadhar1.jpg', 'pan1.jpg', 'bank1.jpg', '2024-12-29 16:37:19'),
(2, 'EMP002', 'Institute B', 'HR', 'Manager', 'City B', '2022-02-01', NULL, 'Permanent', 'Jane Doe', 'Female', 'A+', 'Indian', '1985-05-15', 'Father B', 'Mother B', 'Spouse B', '1234567891', '9876543211', 'jane.doe@example.com', '456 Street B', 'Bank B', 'Branch B', '444455556666', 'IFSC002', 'PAN002', 'AADHAR002', 'Category B', NULL, 8, 40, 8, 'Band B', 60000.00, NULL, NULL, 1100.00, 2200.00, 1600.00, 3100.00, 900.00, 1300.00, 600.00, 'photo2.jpg', 'aadhar2.jpg', 'pan2.jpg', 'bank2.jpg', '2024-12-29 16:37:19'),
(3, 'EMP003', 'Institute C', 'Finance', 'Analyst', 'City C', '2021-03-01', NULL, 'Temporary', 'Alice Smith', 'Female', 'B+', 'Indian', '1992-07-20', 'Father C', 'Mother C', NULL, '1234567892', '9876543212', 'alice.smith@example.com', '789 Street C', 'Bank C', 'Branch C', '777788889999', 'IFSC003', 'PAN003', 'AADHAR003', 'Category C', 'Subcategory C1', 6, 30, 6, 'Band C', 40000.00, 'PF001', '2021-03-15', 1200.00, 2300.00, 1700.00, 3200.00, 1000.00, 1400.00, 700.00, 'photo3.jpg', 'aadhar3.jpg', 'pan3.jpg', 'bank3.jpg', '2024-12-29 16:37:19'),
(4, 'EMP004', 'Institute D', 'Marketing', 'Executive', 'City D', '2020-04-01', NULL, 'Contract', 'Bob Johnson', 'Male', 'AB+', 'Indian', '1988-10-10', 'Father D', 'Mother D', NULL, '1234567893', '9876543213', 'bob.johnson@example.com', '101 Street D', 'Bank D', 'Branch D', '222233334444', 'IFSC004', 'PAN004', 'AADHAR004', 'Category D', 'Subcategory D1', 8, 40, 8, 'Band D', 70000.00, NULL, NULL, 1300.00, 2400.00, 1800.00, 3300.00, 1100.00, 1500.00, 800.00, 'photo4.jpg', 'aadhar4.jpg', 'pan4.jpg', 'bank4.jpg', '2024-12-29 16:37:19'),
(5, 'EMP005', 'Institute E', 'Engineering', 'Technician', 'City E', '2019-05-01', NULL, 'Permanent', 'Charlie Brown', 'Male', 'O-', 'Indian', '1995-12-25', 'Father E', 'Mother E', NULL, '1234567894', '9876543214', 'charlie.brown@example.com', '121 Street E', 'Bank E', 'Branch E', '333344445555', 'IFSC005', 'PAN005', 'AADHAR005', 'Category E', NULL, 9, 45, 9, 'Band E', 55000.00, 'PF002', '2019-05-20', 1400.00, 2500.00, 1900.00, 3400.00, 1200.00, 1600.00, 900.00, 'photo5.jpg', 'aadhar5.jpg', 'pan5.jpg', 'bank5.jpg', '2024-12-29 16:37:19'),
(6, 'EMP006', 'Institute F', 'Support', 'Assistant', 'City F', '2018-06-01', '2021-12-31', 'Temporary', 'Diana Prince', 'Female', 'A-', 'Indian', '1993-11-11', 'Father F', 'Mother F', 'Spouse F', '1234567895', '9876543215', 'diana.prince@example.com', '131 Street F', 'Bank F', 'Branch F', '555566667777', 'IFSC006', 'PAN006', 'AADHAR006', 'Category F', NULL, 7, 35, 7, 'Band F', 45000.00, NULL, NULL, 1500.00, 2600.00, 2000.00, 3500.00, 1300.00, 1700.00, 1000.00, 'photo6.jpg', 'aadhar6.jpg', 'pan6.jpg', 'bank6.jpg', '2024-12-29 16:37:19'),
(7, 'EMP007', 'Institute G', 'Admin', 'Clerk', 'City G', '2023-07-01', NULL, 'Permanent', 'Edward King', 'Male', 'B-', 'Indian', '1987-03-03', 'Father G', 'Mother G', 'Spouse G', '1234567896', '9876543216', 'edward.king@example.com', '141 Street G', 'Bank G', 'Branch G', '666677778888', 'IFSC007', 'PAN007', 'AADHAR007', 'Category G', 'Subcategory G1', 8, 40, 8, 'Band G', 65000.00, 'PF003', '2023-07-15', 1600.00, 2700.00, 2100.00, 3600.00, 1400.00, 1800.00, 1100.00, 'photo7.jpg', 'aadhar7.jpg', 'pan7.jpg', 'bank7.jpg', '2024-12-29 16:37:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"attendance_management\",\"table\":\"attendance_mst\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-01-12 16:22:10', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
