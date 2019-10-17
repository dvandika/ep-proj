-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2019 at 04:35 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ep_aski`
--

-- --------------------------------------------------------

--
-- Table structure for table `ep_admin`
--

CREATE TABLE `ep_admin` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Role` varchar(50) NOT NULL,
  `Company` varchar(50) DEFAULT 'PT ASTRA KOMPONEN INDONESIA',
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ep_admin`
--

INSERT INTO `ep_admin` (`ID`, `FirstName`, `LastName`, `Username`, `Password`, `Email`, `Role`, `Company`, `DateCreated`, `DateModified`) VALUES
(1, 'Administrator', 'ASKI', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@aski.id', 'admin', 'PT ASTRA KOMPONEN INDONESIA', '2019-08-28 08:52:05', '2019-09-01 16:37:50'),
(2, 'Operator', 'ASKI', 'operator', '4b583376b2767b923c3e1da60d10de59', 'operator@aski.id', 'operator', 'PT ASTRA KOMPONEN INDONESIA', '2019-08-28 08:52:05', '2019-08-28 08:52:52'),
(3, 'Diva', 'Andika', 'developer', '5e8edd851d2fdfbd7415232c67367cc3', 'developer@aski.id', 'developer', 'PT ASTRA KOMPONEN INDONESIA', '2019-08-28 08:52:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ep_informasi`
--

CREATE TABLE `ep_informasi` (
  `ID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_material`
--

CREATE TABLE `ep_material` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `MaterialNumber` varchar(50) NOT NULL,
  `MaterialDescription` varchar(50) NOT NULL,
  `Type` varchar(10) DEFAULT NULL,
  `Category` varchar(10) DEFAULT NULL,
  `Uom` varchar(10) DEFAULT NULL,
  `ActualStock` int(11) DEFAULT NULL,
  `KebPerDay` int(11) DEFAULT NULL,
  `LevelStock` int(11) DEFAULT NULL,
  `LevelStockDay` int(11) NOT NULL,
  `StdLevelStock` int(11) DEFAULT NULL,
  `Status` int(1) NOT NULL DEFAULT '1' COMMENT '0: Lock, 1: Unlocked',
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ep_material`
--

INSERT INTO `ep_material` (`ID`, `VendorCode`, `MaterialNumber`, `MaterialDescription`, `Type`, `Category`, `Uom`, `ActualStock`, `KebPerDay`, `LevelStock`, `LevelStockDay`, `StdLevelStock`, `Status`, `DateCreated`, `DateUpdate`) VALUES
(1, 31011520, 'QB2MRR-KHLDZLBK00', 'HOLDER MIRROR BACK RH KZLG SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:05', NULL),
(2, 31011520, 'QB2MRR-KHLDZLBK01', 'HOLDER MIRROR BACK LH KZLG SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:05', NULL),
(3, 31011520, 'QB2MRR-SHLDWWBK00', 'HOLDER MIRROR BACK LH KWWT', 'K56H', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:05', NULL),
(4, 31011520, 'QB2MRR-SHLDWWBK01', 'HOLDER MIRROR BACK RH KWWT', 'K56H', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(5, 31011520, 'QB4MRR-KBAS12BK04', 'SUB ASSY BASE STAY RHD RH 34832-C0200', 'D12', 'Komponen', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(6, 31011520, 'QB4MRR-KBAS12BK05', 'SUB ASSY BASE STAY RHD LH 34831-C0200', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(7, 31011520, 'QB4MRR-KBRK14BK00', 'BRACKET M/F LH 34231-C3300 SC', 'D14', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(8, 31011520, 'QB4MRR-KBRK14BK01', 'BRACKET M/F RH 34232-C3300 SC', 'D14', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(9, 31011520, 'QB4MRR-KBRK14BK02', 'BRACKET P/F LH 34231-C3200 SC', 'D14', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(10, 31011520, 'QB4MRR-KBRK14BK03', 'BRACKET P/F RH 34232-C3200 SC', 'D14', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(11, 31011520, 'QB4MRR-KGSK01BK00', 'GASKET LH 441-D01N-30-005-111 SC', 'D01N', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(12, 31011520, 'QB4MRR-KGSK01BK01', 'GASKET RH 441-D01N-30-005-110 SC', 'D01N', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(13, 31011520, 'QB4MRR-KGSK12BK00', 'GASKET RH D12 34382-S0600 SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(14, 31011520, 'QB4MRR-KGSK12BK01', 'GASKET LH D12 34381-S0600 SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(15, 31011520, 'QB4MRR-KGSK14BK00', 'GASKET LH 34231-C1200 SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(16, 31011520, 'QB4MRR-KGSK14BK01', 'GASKET RH 34232-C1100 SC', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(17, 31011520, 'QB4MRR-KHOU14BK00', 'HOUSING LH 34231-C0200 SC', 'D14', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(18, 31011520, 'QB4MRR-KHOU14BK01', 'HOUSING RH 34232-C0100 SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(19, 31011520, 'QB4MRR-SBAS01BK00', 'BASE LH 441-D01N-30-004-111', 'D01N', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(20, 31011520, 'QB4MRR-SBAS01BK01', 'BASE RH 441-D01N-30-004-110', 'D01N', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:06', NULL),
(21, 31011520, 'QB4MRR-SBAS12BK00', 'S/A BASE STAY RHD RH 34832-C0200 EMBED', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(22, 31011520, 'QB4MRR-SBAS12BK01', 'S/A BASE STAY RHD LH 34831-C0200 EMBED', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(23, 31011520, 'QB4MRR-SBAS12BK02', 'S/A BASE STAY LHD RH 34832-C0300 EMBED', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(24, 31011520, 'QB4MRR-SBAS12BK03', 'S/A BASE STAY LHD LH 34831-C0300 EMBED', NULL, 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(25, 31011520, 'QB4MRR-SCVR12BK00', 'COVER OUTER MIRROR RH NO.2 34832-C0100SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(26, 31011520, 'QB4MRR-SCVR12BK01', 'COVER OUTER MIRROR LH NO.2 34831-C0100SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(27, 31011520, 'QB4MRR-SCVR12BK02', 'COVER OUTER MIRROR RH NO.3 34832-C0400SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(28, 31011520, 'QB4MRR-SCVR12BK03', 'COVER OUTER MIRROR LH NO.3 34832-C0400SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(29, 31011520, 'QB4MRR-SCVR12BK04', 'COVER OUTER MIRROR RH NO. 2 STSL D12L SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(30, 31011520, 'QB4MRR-SCVR12BK05', 'COVER OUTER MIRROR LH NO. 2 STSL D12L SC', 'D12', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(31, 31011520, 'QB4MRR-SGSK97BK00', 'GASKET LH D97D', 'D80', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL),
(32, 31011520, 'QB4MRR-SGSK97BK01', 'GASKET RH D97D', 'D80', 'SFG', 'PCS', NULL, NULL, NULL, 0, NULL, 1, '2019-08-28 08:49:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ep_ordersheet`
--

CREATE TABLE `ep_ordersheet` (
  `ID` int(11) NOT NULL,
  `OSNumber` int(11) NOT NULL,
  `Vendor` int(11) NOT NULL,
  `PONumber` int(11) NOT NULL,
  `Material` varchar(50) NOT NULL,
  `Qty` int(11) NOT NULL COMMENT 'Sum scheduled qty',
  `BUn` varchar(5) NOT NULL COMMENT 'UoM',
  `PrintStatus` int(11) NOT NULL COMMENT '0 = Unprinted; 1 = Printed',
  `DeliveryDate` date DEFAULT NULL,
  `DeliveryTime` time DEFAULT NULL COMMENT 'Transm',
  `UploadBy` varchar(50) NOT NULL COMMENT 'Session Username',
  `DateCreated` datetime DEFAULT CURRENT_TIMESTAMP,
  `DateModified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_os_data`
--

CREATE TABLE `ep_os_data` (
  `os_id` int(11) NOT NULL,
  `os_no` int(11) NOT NULL COMMENT 'Get from Excel OS Number',
  `os_vendor` int(11) NOT NULL COMMENT 'Vendor/Supplier Code',
  `os_po_number` varchar(45) NOT NULL,
  `os_material` varchar(45) NOT NULL COMMENT 'Material Code',
  `os_material_desc` varchar(45) NOT NULL,
  `os_bun` varchar(5) NOT NULL,
  `os_transm` time NOT NULL,
  `os_delivery_date` date NOT NULL,
  `os_kanban_qty` int(11) NOT NULL,
  `os_schedule_qty` int(11) NOT NULL COMMENT 'Data from OS upload.',
  `os_sum_schedule_qty` int(11) NOT NULL COMMENT 'Data from OS upload.',
  `os_status` varchar(1) NOT NULL COMMENT 'OS Status',
  `os_status_item` varchar(1) NOT NULL COMMENT 'Status Item / OS',
  `os_print_enc` varchar(50) DEFAULT NULL,
  `os_print_status` int(11) DEFAULT '0' COMMENT '0 = Unprinted; 1 = Printed',
  `os_print_count` int(11) NOT NULL DEFAULT '0' COMMENT 'Auto increase (PHP) if click Accept/Print OS.',
  `os_date_printed` datetime DEFAULT NULL,
  `os_date_uploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `os_upload_by` varchar(45) NOT NULL COMMENT 'Refer to SESSION USERNAME.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_stock`
--

CREATE TABLE `ep_stock` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `MaterialNumber` varchar(50) NOT NULL,
  `ActualStock` int(11) DEFAULT NULL,
  `KPD` int(11) DEFAULT NULL COMMENT 'Kebutuhan per Day',
  `LS` int(11) DEFAULT NULL COMMENT 'Level Stock',
  `SLS` int(11) DEFAULT NULL COMMENT 'Standard Level Stock',
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_stock_report`
--

CREATE TABLE `ep_stock_report` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `Notes` varchar(255) DEFAULT NULL,
  `Path` varchar(255) NOT NULL,
  `Filename` varchar(255) NOT NULL,
  `OriginalName` varchar(50) NOT NULL,
  `DateStock` date NOT NULL,
  `DownloadCount` int(11) DEFAULT NULL,
  `UploadBy` varchar(50) DEFAULT NULL,
  `DateUpload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_stock_template`
--

CREATE TABLE `ep_stock_template` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `Notes` varchar(255) DEFAULT NULL,
  `Month` varchar(25) NOT NULL,
  `Path` varchar(255) NOT NULL,
  `Filename` varchar(50) NOT NULL,
  `OriginalName` varchar(50) NOT NULL,
  `Status` enum('aktif','nonaktif') NOT NULL,
  `UploadBy` varchar(50) NOT NULL,
  `DateUpload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ep_vendor`
--

CREATE TABLE `ep_vendor` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `VendorShortname` varchar(50) NOT NULL,
  `VendorName` varchar(50) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `AuthID` int(11) NOT NULL COMMENT '// REFER TO TB_AUTH',
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ep_vendor`
--

INSERT INTO `ep_vendor` (`ID`, `VendorCode`, `VendorShortname`, `VendorName`, `Address`, `Email`, `Phone`, `AuthID`, `DateCreated`, `DateModified`) VALUES
(1, 31011520, 'JAEIL', 'PT. JAEIL INDONESIA', NULL, NULL, NULL, 1, '2019-08-27 13:12:30', '2019-09-17 15:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `ep_vendor_auth`
--

CREATE TABLE `ep_vendor_auth` (
  `ID` int(11) NOT NULL,
  `VendorCode` int(11) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Role` varchar(20) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ep_vendor_auth`
--

INSERT INTO `ep_vendor_auth` (`ID`, `VendorCode`, `Fullname`, `Username`, `Password`, `Email`, `Role`, `DateCreated`, `DateModified`) VALUES
(1, 31011520, 'PT. JAEIL Indonesia', 'jaeil', '28a8c8cca868a1a79636d461fe240c72', NULL, 'vendor', '2019-08-27 13:35:08', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ep_admin`
--
ALTER TABLE `ep_admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_informasi`
--
ALTER TABLE `ep_informasi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_material`
--
ALTER TABLE `ep_material`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_ordersheet`
--
ALTER TABLE `ep_ordersheet`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_os_data`
--
ALTER TABLE `ep_os_data`
  ADD PRIMARY KEY (`os_id`);

--
-- Indexes for table `ep_stock`
--
ALTER TABLE `ep_stock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_stock_report`
--
ALTER TABLE `ep_stock_report`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_stock_template`
--
ALTER TABLE `ep_stock_template`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ep_vendor`
--
ALTER TABLE `ep_vendor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `VendorNumber` (`VendorCode`);

--
-- Indexes for table `ep_vendor_auth`
--
ALTER TABLE `ep_vendor_auth`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ep_admin`
--
ALTER TABLE `ep_admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ep_informasi`
--
ALTER TABLE `ep_informasi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_material`
--
ALTER TABLE `ep_material`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ep_ordersheet`
--
ALTER TABLE `ep_ordersheet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_os_data`
--
ALTER TABLE `ep_os_data`
  MODIFY `os_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_stock`
--
ALTER TABLE `ep_stock`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_stock_report`
--
ALTER TABLE `ep_stock_report`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_stock_template`
--
ALTER TABLE `ep_stock_template`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ep_vendor`
--
ALTER TABLE `ep_vendor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ep_vendor_auth`
--
ALTER TABLE `ep_vendor_auth`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
