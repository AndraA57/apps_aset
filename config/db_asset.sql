/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - db_asset
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_asset` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_asset`;

/*Table structure for table `aset` */

DROP TABLE IF EXISTS `aset`;

CREATE TABLE `aset` (
  `IdAset` int(11) NOT NULL AUTO_INCREMENT,
  `KodeAset` varchar(50) DEFAULT NULL,
  `IdKategoriAset` int(11) DEFAULT NULL,
  `IdLokasiAset` int(11) DEFAULT NULL,
  `NamaAset` varchar(100) DEFAULT NULL,
  `StatusAset` enum('Tersedia','Dipinjam','Rusak','Dihapuskan') DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdAset`),
  UNIQUE KEY `KodeAset` (`KodeAset`),
  KEY `IdKategoriAset` (`IdKategoriAset`),
  KEY `IdLokasiAset` (`IdLokasiAset`),
  CONSTRAINT `aset_ibfk_1` FOREIGN KEY (`IdKategoriAset`) REFERENCES `kategori_aset` (`IdKategoriAset`),
  CONSTRAINT `aset_ibfk_2` FOREIGN KEY (`IdLokasiAset`) REFERENCES `lokasi_aset` (`IdLokasiAset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `aset` */

/*Table structure for table `kategori_aset` */

DROP TABLE IF EXISTS `kategori_aset`;

CREATE TABLE `kategori_aset` (
  `IdKategoriAset` int(11) NOT NULL AUTO_INCREMENT,
  `KodeKategori` varchar(20) DEFAULT NULL,
  `NamaKategori` varchar(100) DEFAULT NULL,
  `DeskripsiKategori` text DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdKategoriAset`),
  UNIQUE KEY `KodeKategori` (`KodeKategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kategori_aset` */

/*Table structure for table `lokasi_aset` */

DROP TABLE IF EXISTS `lokasi_aset`;

CREATE TABLE `lokasi_aset` (
  `IdLokasiAset` int(11) NOT NULL AUTO_INCREMENT,
  `KodeLokasiAset` varchar(20) DEFAULT NULL,
  `NamaLokasiAset` varchar(100) DEFAULT NULL,
  `DeskripsiLokasiAset` text DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdLokasiAset`),
  UNIQUE KEY `KodeLokasiAset` (`KodeLokasiAset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `lokasi_aset` */

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `IdPegawai` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(100) NOT NULL,
  `Sandi` varchar(255) NOT NULL,
  `role` enum('admin','adm_aset','staf','teknisi') NOT NULL,
  `Gender` enum('L','P') DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdPegawai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pegawai` */

insert  into `pegawai`(`IdPegawai`,`Nama`,`Sandi`,`role`,`Gender`,`Create_at`,`Update_at`) values 
(1,'Muhammad Syaban','0192023a7bbd73250516f069df18b500','adm_aset','L','2026-02-03 08:18:46','2026-02-03 12:46:55'),
(2,'Komarudin','0192023a7bbd73250516f069df18b50','staf','L','2026-02-03 12:45:17','2026-02-03 12:45:17');

/*Table structure for table `pengelola_aset` */

DROP TABLE IF EXISTS `pengelola_aset`;

CREATE TABLE `pengelola_aset` (
  `IdPengelola` int(11) NOT NULL AUTO_INCREMENT,
  `IdPegawai` int(11) DEFAULT NULL,
  `Level` enum('Admin Instansi','Admin Aset','Staf','Teknisi') DEFAULT NULL,
  `Gender` enum('L','P') DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdPengelola`),
  KEY `IdPegawai` (`IdPegawai`),
  CONSTRAINT `pengelola_aset_ibfk_1` FOREIGN KEY (`IdPegawai`) REFERENCES `pegawai` (`IdPegawai`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pengelola_aset` */

insert  into `pengelola_aset`(`IdPengelola`,`IdPegawai`,`Level`,`Gender`,`Create_at`,`Update_at`) values 
(1,1,'Admin Instansi','L','2026-02-03 08:18:59','2026-02-03 08:18:59');

/*Table structure for table `pijam_aset` */

DROP TABLE IF EXISTS `pijam_aset`;

CREATE TABLE `pijam_aset` (
  `IdSTA` int(11) NOT NULL AUTO_INCREMENT,
  `IdPegawaiTerima` int(11) DEFAULT NULL,
  `IdPegawaiSerah` int(11) DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdSTA`),
  KEY `IdPegawaiTerima` (`IdPegawaiTerima`),
  KEY `IdPegawaiSerah` (`IdPegawaiSerah`),
  CONSTRAINT `pijam_aset_ibfk_1` FOREIGN KEY (`IdPegawaiTerima`) REFERENCES `pegawai` (`IdPegawai`),
  CONSTRAINT `pijam_aset_ibfk_2` FOREIGN KEY (`IdPegawaiSerah`) REFERENCES `pegawai` (`IdPegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pijam_aset` */

/*Table structure for table `pinjam_aset_detail` */

DROP TABLE IF EXISTS `pinjam_aset_detail`;

CREATE TABLE `pinjam_aset_detail` (
  `IdSTADetail` int(11) NOT NULL AUTO_INCREMENT,
  `IdSTA` int(11) DEFAULT NULL,
  `IdAset` int(11) DEFAULT NULL,
  `StatusKembali` enum('Belum','Sudah') DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdSTADetail`),
  KEY `IdSTA` (`IdSTA`),
  KEY `IdAset` (`IdAset`),
  CONSTRAINT `pinjam_aset_detail_ibfk_1` FOREIGN KEY (`IdSTA`) REFERENCES `pijam_aset` (`IdSTA`),
  CONSTRAINT `pinjam_aset_detail_ibfk_2` FOREIGN KEY (`IdAset`) REFERENCES `aset` (`IdAset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pinjam_aset_detail` */

/*Table structure for table `serah_terima_aset` */

DROP TABLE IF EXISTS `serah_terima_aset`;

CREATE TABLE `serah_terima_aset` (
  `IdSTA` int(11) NOT NULL AUTO_INCREMENT,
  `IdPegawaiTerima` int(11) DEFAULT NULL,
  `IdPegawaiSerah` int(11) DEFAULT NULL,
  `StatusSerah` varchar(50) DEFAULT NULL,
  `StatusTerima` varchar(50) DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdSTA`),
  KEY `IdPegawaiTerima` (`IdPegawaiTerima`),
  KEY `IdPegawaiSerah` (`IdPegawaiSerah`),
  CONSTRAINT `serah_terima_aset_ibfk_1` FOREIGN KEY (`IdPegawaiTerima`) REFERENCES `pegawai` (`IdPegawai`),
  CONSTRAINT `serah_terima_aset_ibfk_2` FOREIGN KEY (`IdPegawaiSerah`) REFERENCES `pegawai` (`IdPegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `serah_terima_aset` */

/*Table structure for table `serah_terima_aset_detail` */

DROP TABLE IF EXISTS `serah_terima_aset_detail`;

CREATE TABLE `serah_terima_aset_detail` (
  `IdSTADetail` int(11) NOT NULL AUTO_INCREMENT,
  `IdSTA` int(11) DEFAULT NULL,
  `IdAset` int(11) DEFAULT NULL,
  `StatusSerah` varchar(50) DEFAULT NULL,
  `StatusTerima` varchar(50) DEFAULT NULL,
  `Create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`IdSTADetail`),
  KEY `IdSTA` (`IdSTA`),
  KEY `IdAset` (`IdAset`),
  CONSTRAINT `serah_terima_aset_detail_ibfk_1` FOREIGN KEY (`IdSTA`) REFERENCES `serah_terima_aset` (`IdSTA`),
  CONSTRAINT `serah_terima_aset_detail_ibfk_2` FOREIGN KEY (`IdAset`) REFERENCES `aset` (`IdAset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `serah_terima_aset_detail` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('Admin Instansi','Pengelola Aset (Admin)','Pengelola Aset (Staf)','Pengelola Aset (Teknisi)') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
