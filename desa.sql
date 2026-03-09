-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for desa
DROP DATABASE IF EXISTS `desa`;
CREATE DATABASE IF NOT EXISTS `desa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `desa`;

-- Dumping structure for table desa.data_masyarakat
DROP TABLE IF EXISTS `data_masyarakat`;
CREATE TABLE IF NOT EXISTS `data_masyarakat` (
  `id_masarakat` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `nik` char(16) NOT NULL,
  `alamat` text NOT NULL,
  `rt_rw` varchar(50) NOT NULL,
  PRIMARY KEY (`id_masarakat`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table desa.masyarakat
DROP TABLE IF EXISTS `masyarakat`;
CREATE TABLE IF NOT EXISTS `masyarakat` (
  `nik` char(16) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `rt_rw` varchar(20) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table desa.pengaduan
DROP TABLE IF EXISTS `pengaduan`;
CREATE TABLE IF NOT EXISTS `pengaduan` (
  `id_pengaduan` int NOT NULL AUTO_INCREMENT,
  `tgl_pengaduan` varchar(40) NOT NULL,
  `nama_pengadu` varchar(40) NOT NULL,
  `nik` char(16) NOT NULL,
  `isi_laporan` text NOT NULL,
  `prioritas` enum('Tinggi','Sedang','Rendah') DEFAULT 'Rendah',
  `tlp` varchar(13) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  PRIMARY KEY (`id_pengaduan`),
  KEY `nik` (`nik`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table desa.petugas
DROP TABLE IF EXISTS `petugas`;
CREATE TABLE IF NOT EXISTS `petugas` (
  `id_petugas` int NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `level` enum('admin','petugas') NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table desa.tanggapan
DROP TABLE IF EXISTS `tanggapan`;
CREATE TABLE IF NOT EXISTS `tanggapan` (
  `id_tanggapan` int NOT NULL AUTO_INCREMENT,
  `id_pengaduan` int NOT NULL,
  `tgl_tanggapan` varchar(40) NOT NULL,
  `isi_laporan` text NOT NULL,
  `tanggapan` text NOT NULL,
  `id_petugas` int NOT NULL,
  PRIMARY KEY (`id_tanggapan`),
  KEY `id_pengaduan` (`id_pengaduan`),
  KEY `id_petugas` (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
