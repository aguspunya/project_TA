-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2015 at 06:45 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_03`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `Kdbarang` varchar(5) NOT NULL,
  `NmBarang` varchar(25) NOT NULL,
  `Harga` float NOT NULL,
  `Stok` int(10) NOT NULL,
  `StokMinimum` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`Kdbarang`, `NmBarang`, `Harga`, `Stok`, `StokMinimum`) VALUES
('KB001', 'Sepatu', 200000, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE IF NOT EXISTS `beli` (
  `NoBukti` varchar(5) NOT NULL,
  `IdVendor` varchar(5) NOT NULL,
  `TglBeli` date NOT NULL,
  `KdBarang` varchar(5) NOT NULL,
  `Qty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beli`
--

INSERT INTO `beli` (`NoBukti`, `IdVendor`, `TglBeli`, `KdBarang`, `Qty`) VALUES
('B-001', 'V-001', '2014-10-24', 'KB001', 5);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `IdVendor` varchar(5) NOT NULL,
  `Nama` varchar(25) NOT NULL,
  `Alamat` text NOT NULL,
  `Kota` varchar(30) NOT NULL,
  `Telp` varchar(15) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`IdVendor`, `Nama`, `Alamat`, `Kota`, `Telp`, `Email`) VALUES
('V-001', 'B-001', 'Jl. Pintu Air Sidamukti', 'Depok', '085782241894', 'setiawan1864@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
 ADD PRIMARY KEY (`Kdbarang`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
 ADD PRIMARY KEY (`NoBukti`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
 ADD PRIMARY KEY (`IdVendor`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
