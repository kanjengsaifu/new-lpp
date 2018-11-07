-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.30-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table new_lpp.tbl_m_customers
DROP TABLE IF EXISTS `tbl_m_customers`;
CREATE TABLE IF NOT EXISTS `tbl_m_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_m_materials
DROP TABLE IF EXISTS `tbl_m_materials`;
CREATE TABLE IF NOT EXISTS `tbl_m_materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `material_kode` varchar(20) NOT NULL,
  `category_id` int(10) DEFAULT NULL,
  `conversion` float DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_m_parts
DROP TABLE IF EXISTS `tbl_m_parts`;
CREATE TABLE IF NOT EXISTS `tbl_m_parts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `part_name` varchar(100) NOT NULL,
  `part_kode` varchar(20) NOT NULL,
  `conversion` float NOT NULL,
  `spk_kode` int(5) NOT NULL,
  `id_partcategory` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_m_process
DROP TABLE IF EXISTS `tbl_m_process`;
CREATE TABLE IF NOT EXISTS `tbl_m_process` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_proses` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_profile_category
DROP TABLE IF EXISTS `tbl_profile_category`;
CREATE TABLE IF NOT EXISTS `tbl_profile_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_alias` varchar(3) NOT NULL DEFAULT '0',
  `category_name` varchar(50) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_profile_partcategory
DROP TABLE IF EXISTS `tbl_profile_partcategory`;
CREATE TABLE IF NOT EXISTS `tbl_profile_partcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partcategory_alias` varchar(3) NOT NULL DEFAULT '0',
  `partcategory_name` varchar(50) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_profile_uom
DROP TABLE IF EXISTS `tbl_profile_uom`;
CREATE TABLE IF NOT EXISTS `tbl_profile_uom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uom` varchar(10) NOT NULL,
  `uom_description` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table new_lpp.tbl_trx_spk
DROP TABLE IF EXISTS `tbl_trx_spk`;
CREATE TABLE IF NOT EXISTS `tbl_trx_spk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `spk_no` varchar(20) NOT NULL,
  `id_customer` int(10) NOT NULL,
  `id_material` int(10) NOT NULL,
  `id_part` int(10) NOT NULL,
  `spk_status` tinyint(1) NOT NULL DEFAULT '0',
  `qty_m_base` int(10) NOT NULL DEFAULT '0',
  `id_uom_base` int(10) NOT NULL DEFAULT '0',
  `qty_m_convert` float NOT NULL DEFAULT '0',
  `id_uom_convert` int(10) NOT NULL DEFAULT '0',
  `qty_part` int(10) NOT NULL DEFAULT '0',
  `id_uom_part` int(10) NOT NULL DEFAULT '0',
  `spk_rework` varchar(20) DEFAULT NULL,
  `spk_co_number` varchar(50) DEFAULT NULL,
  `spk_notes` text,
  `spk_history` text,
  `spk_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `spk_end` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `spk_closed` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `spk_no` (`spk_no`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for view new_lpp.vw_materialdetail
DROP VIEW IF EXISTS `vw_materialdetail`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_materialdetail` (
	`id` INT(10) UNSIGNED NOT NULL,
	`name` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`material_kode` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`category_id` INT(10) NULL,
	`conversion` FLOAT NULL,
	`status` TINYINT(1) NOT NULL,
	`created_at` TIMESTAMP NOT NULL,
	`modified_at` TIMESTAMP NOT NULL,
	`category_alias` VARCHAR(3) NULL COLLATE 'latin1_swedish_ci',
	`category_name` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view new_lpp.vw_partdetail
DROP VIEW IF EXISTS `vw_partdetail`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_partdetail` (
	`id` INT(10) UNSIGNED NOT NULL,
	`part_name` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`part_kode` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`conversion` FLOAT NOT NULL,
	`spk_kode` INT(5) NOT NULL,
	`id_partcategory` VARCHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`status` TINYINT(1) NOT NULL,
	`created_at` TIMESTAMP NOT NULL,
	`modified_at` TIMESTAMP NOT NULL,
	`partcategory_alias` VARCHAR(3) NULL COLLATE 'latin1_swedish_ci',
	`partcategory_name` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view new_lpp.vw_spkdetail
DROP VIEW IF EXISTS `vw_spkdetail`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vw_spkdetail` (
	`id` INT(10) UNSIGNED NOT NULL,
	`spk_no` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
	`id_customer` INT(10) NOT NULL,
	`id_material` INT(10) NOT NULL,
	`id_part` INT(10) NOT NULL,
	`spk_status` TINYINT(1) NOT NULL,
	`qty_m_base` INT(10) NOT NULL,
	`id_uom_base` INT(10) NOT NULL,
	`qty_m_convert` FLOAT NOT NULL,
	`id_uom_convert` INT(10) NOT NULL,
	`qty_part` INT(10) NOT NULL,
	`id_uom_part` INT(10) NOT NULL,
	`spk_rework` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci',
	`spk_co_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`spk_notes` TEXT NULL COLLATE 'latin1_swedish_ci',
	`spk_history` TEXT NULL COLLATE 'latin1_swedish_ci',
	`spk_start` TIMESTAMP NOT NULL,
	`spk_end` TIMESTAMP NOT NULL,
	`spk_closed` TIMESTAMP NULL,
	`status` TINYINT(1) NOT NULL,
	`created_at` TIMESTAMP NOT NULL,
	`modified_at` TIMESTAMP NOT NULL,
	`customer_name` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`material_name` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci',
	`part_name` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci',
	`part_category` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view new_lpp.vw_materialdetail
DROP VIEW IF EXISTS `vw_materialdetail`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_materialdetail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vw_materialdetail` AS SELECT m.*, pc.category_alias, pc.category_name
		FROM tbl_m_materials m
		LEFT JOIN tbl_profile_category pc ON m.category_id = pc.id ;

-- Dumping structure for view new_lpp.vw_partdetail
DROP VIEW IF EXISTS `vw_partdetail`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_partdetail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vw_partdetail` AS SELECT p.*, ppc.partcategory_alias, ppc.partcategory_name
		FROM tbl_m_parts p
		LEFT JOIN tbl_profile_partcategory ppc ON p.id_partcategory = ppc.id ;

-- Dumping structure for view new_lpp.vw_spkdetail
DROP VIEW IF EXISTS `vw_spkdetail`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vw_spkdetail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` VIEW `vw_spkdetail` AS SELECT spk.*,
		mc.name AS customer_name,
		mm.name AS material_name,
		mp.part_name AS part_name,
		mp.part_kode AS part_category
		FROM tbl_trx_spk spk
			LEFT JOIN tbl_m_customers mc ON spk.id_customer = mc.id
			LEFT JOIN tbl_m_materials mm On spk.id_material = mm.id
			LEFT JOIN tbl_m_parts mp On spk.id_part = mp.id ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
