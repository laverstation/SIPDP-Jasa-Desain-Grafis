-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 08:57 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_jabatan`
--

CREATE TABLE `data_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `jabatan` varchar(120) NOT NULL,
  `kontrak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_jabatan`
--

INSERT INTO `data_jabatan` (`id_jabatan`, `jabatan`, `kontrak`) VALUES
(1, 'Animator', 'Freelancer'),
(2, 'Illustrator', 'Freelancer'),
(3, 'Admin', 'Karyawan Tetap');

-- --------------------------------------------------------

--
-- Table structure for table `data_job`
--

CREATE TABLE `data_job` (
  `id_job` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `detail_job` text NOT NULL,
  `harga_job` int(11) NOT NULL,
  `tgl_mulai` date NOT NULL DEFAULT current_timestamp(),
  `tgl_deadline` date NOT NULL,
  `desain` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `revisi` varchar(100) NOT NULL,
  `detail_revisi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nip` varchar(6) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `id_hak` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id_pegawai`, `nip`, `nama_pegawai`, `username`, `password`, `jenis_kelamin`, `id_jabatan`, `tanggal_masuk`, `id_hak`, `photo`) VALUES
(1, '202001', 'Raihan Mubarok', 'raihan', 'raihan', 'Laki Laki', 3, '2020-01-01', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_hak` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `hak_akses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_hak`, `keterangan`, `hak_akses`) VALUES
(1, 'Admin', 1),
(2, 'Pegawai', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_jabatan`
--
ALTER TABLE `data_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `data_job`
--
ALTER TABLE `data_job`
  ADD PRIMARY KEY (`id_job`),
  ADD KEY `id_pegawai` (`id_pegawai`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_hak` (`id_hak`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_hak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_jabatan`
--
ALTER TABLE `data_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_job`
--
ALTER TABLE `data_job`
  MODIFY `id_job` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_hak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_job`
--
ALTER TABLE `data_job`
  ADD CONSTRAINT `data_job_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `data_jabatan` (`id_jabatan`),
  ADD CONSTRAINT `data_job_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `data_pegawai` (`id_pegawai`);

--
-- Constraints for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD CONSTRAINT `data_pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `data_jabatan` (`id_jabatan`),
  ADD CONSTRAINT `data_pegawai_ibfk_2` FOREIGN KEY (`id_hak`) REFERENCES `hak_akses` (`id_hak`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
