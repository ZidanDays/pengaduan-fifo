-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2023 at 02:36 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_masyarakat`
--

CREATE TABLE `data_masyarakat` (
  `id_masarakat` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nik` char(16) NOT NULL,
  `alamat` text NOT NULL,
  `rt_rw` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_masyarakat`
--

INSERT INTO `data_masyarakat` (`id_masarakat`, `nama`, `nik`, `alamat`, `rt_rw`) VALUES
(30, 'shelin', '3600987654321', 'tataaran', '01/02'),
(31, 'IRAWAN', '360123456789', 'mariri', '01/02'),
(32, 'HAZWAN', '1029384756', 'tateli', '01/02');
-- --------------------------------------------------------

--
-- Table structure for table `masyarakat`
--

CREATE TABLE `masyarakat` (
  `nik` char(16) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `rt_rw` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tlp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masyarakat`
--

INSERT INTO `masyarakat` (`nik`, `nama`, `alamat`, `rt_rw`, `username`, `password`, `tlp`) VALUES
('3511181104940001', 'ADHITA', 'JEMBER', '21/02', 'ADHITA77', '123456789', '0897897897897'),
('3601081111111111', 'IRAWAN', 'KP. KOLECER', '01/02', 'ira', '123', '085780353253'),
('3601081111990002', 'IRAWAN DIANA', 'KP. UMBULAN', '01/02', 'irawan', '1234', '0857532532632');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `tgl_pengaduan` varchar(40) NOT NULL,
  `nama_pengadu` varchar(40) NOT NULL,
  `nik` char(16) NOT NULL,
  `isi_laporan` text NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('Proses','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `tgl_pengaduan`, `nama_pengadu`, `nik`, `isi_laporan`, `tlp`, `foto`, `status`) VALUES
(36, '2023-01-26 (10:43:52)', 'IRAWAN DIANA', '3601081111990002', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', '0857532532632', 'images (8).jpeg', 'Selesai'),
(38, '2023-01-27 (09:28:33)', 'IRAWAN', '3601081111111111', 'TELAH TERJADI KEBAKARAN DI RUMAH UDIN RT 01/02 KP. KOLECER MOHON SEGERA DITINDAK LANJUTI', '085780353253', 'images (18).jpeg', 'Selesai'),
(39, '2023-01-27 (14:23:52)', 'satiah', '3601082222222222', 'TELAH TERJADI BANJIR DI KP. KOLECER 1 ORANG HANYUT BELUM DITEMUKAN MOHON SEGERA DITINDAK LANJUTI...', '0857532532646', 'images (11).jpeg', 'Selesai'),
(41, '2023-01-28 (08:33:19)', 'HAZWAN', '3601085555555555', 'TELAH TERJADI KEBAKARAN DI DESA UMBULAN RT 01/02 RUMAH PAK RT MOHON SEGERA DI TINDAK LANJUTI.', '0857242552255', 'images (16).jpeg', 'Selesai'),
(42, '2023-01-28 (08:42:45)', 'HAZWAN', '3601085555555555', 'JALAN DESA KAMPUNG KOLECER RUSAK MOHON SEGERA DIPERBAIKI', '0857242552255', 'images (35).jpeg', 'Proses'),
(43, '2023-02-14 (18:22:05)', 'ADHITA', '3511181104940001', 'JALAN DEPAN RUMAH SAYA RUSAK PARAH PAK KADES', '0897897897897', '05284430419f939320e-f23c-4cfb-a359-04f26112a57a.jpg', 'Proses');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `tlp`, `level`) VALUES
(1, 'administrator', 'admin', 'admin', '081617898716', 'admin'),
(2, 'Diana', 'petugas', 'petugas', '081617898717', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_pengaduan` int(11) NOT NULL,
  `tgl_tanggapan` varchar(40) NOT NULL,
  `isi_laporan` text NOT NULL,
  `tanggapan` text NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_pengaduan`, `tgl_tanggapan`, `isi_laporan`, `tanggapan`, `id_petugas`) VALUES
(9, 2, '2020-03-05 (21:49:23)', 'jalan ancurrrrr', 'jalan ancurrrr', 1),
(10, 3, '2020-03-05 (21:49:43)', 'longsor pak lurah', 'lonsor pak lurah', 1),
(11, 5, '2020-03-06 (01:06:33)', 'kebakaran rumah mewah', 'kebakaran rumah mewah', 1),
(12, 6, '2020-03-06 (01:22:16)', 'terjadi longsor di Kp. gadel', 'terjadi longsor di Kp. gadel kami siap membantu', 1),
(13, 7, '2020-03-06 (01:22:59)', 'Sawah kebanjiran di RT 008', 'Sawah kebanjiran di RT 008 kami siap membantu', 1),
(14, 8, '2020-03-06 (01:35:34)', 'tauran antar pelajar', 'tauran antar pelajar kami siap membantu', 1),
(15, 15, '2020-03-07 (11:01:43)', 'h', 'helem putih', 1),
(16, 0, '2020-03-07 (11:14:01)', 'a', 'aipp', 1),
(17, 13, '2020-03-07 (11:43:40)', 'e', 'sarip', 1),
(18, 23, '2020-03-07 (12:08:25)', 'm', 'm', 1),
(19, 21, '2020-03-07 (12:42:12)', 'h', 'h', 1),
(20, 25, '2020-03-07 (15:48:11)', 'Jembatan Roboh di Kp Barengkok', 'Sebelumya kami minta maaf, kami dari prangkat desa akan segera melakukan perbaikan jembatan tersebut sekian dan terimakasih', 1),
(21, 36, '2023-01-26 (14:42:03)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'Terimakasih atas informasinya akan segera kami tindak lanjuti...', 1),
(22, 36, '2023-01-26 (14:47:20)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'SIAP SEGERA DITANGANI', 1),
(23, 36, '2023-01-26 (15:48:23)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'ok siap', 1),
(24, 36, '2023-01-26 (15:48:51)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'ok siap', 1),
(25, 36, '2023-01-26 (15:52:16)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'siap', 1),
(26, 36, '2023-01-26 (16:04:09)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'siap', 1),
(27, 36, '2023-01-26 (16:10:19)', 'Terjadi Longgsor di kp. umbulan rt 01/01 dekat POM bensi segera di tindak lanjuti', 'vdsbdbdsb', 1),
(28, 37, '2023-01-27 (09:39:38)', 'TERJADI LONGSOR DI DEKAT RUMAH PAK RT KP KOLECER 1 LUKA BERAT 1 LUKA RINGAN 1 MENINGGAL', 'SIAP SEGERA KAMI AKAN TANGANI KE LOKASI KEJADIAN ', 1),
(29, 39, '2023-01-27 (14:40:23)', 'TELAH TERJADI BANJIR DI KP. KOLECER 1 ORANG HANYUT BELUM DITEMUKAN MOHON SEGERA DITINDAK LANJUTI...', 'TERIMAKASIH ATAS INFORMASINYA AKAN SEGERA KAMI TINDAK LANJUTI', 1),
(30, 41, '2023-01-28 (08:40:16)', 'TELAH TERJADI KEBAKARAN DI DESA UMBULAN RT 01/02 RUMAH PAK RT MOHON SEGERA DI TINDAK LANJUTI.', 'TERIMAKASIH ATAS INFORMASINYA AKAN SEGERA KAMAI TINDAK LANJUTI', 1),
(31, 43, '2023-02-14 (18:23:17)', 'JALAN DEPAN RUMAH SAYA RUSAK PARAH PAK KADES', 'terima kasih atas pengaduannya,insyaallah bulan 12 proyek perbaikan jalan dimulai', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_masyarakat`
--
ALTER TABLE `data_masyarakat`
  ADD PRIMARY KEY (`id_masarakat`);

--
-- Indexes for table `masyarakat`
--
ALTER TABLE `masyarakat`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_masyarakat`
--
ALTER TABLE `data_masyarakat`
  MODIFY `id_masarakat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `masyarakat` (`nik`);

--
-- Constraints for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD CONSTRAINT `tanggapan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
