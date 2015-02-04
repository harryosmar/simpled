/*
SQLyog Ultimate - MySQL GUI v8.21 
MySQL - 5.6.17 : Database - simpled
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`simpled` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `simpled`;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_sessions` */

insert  into `ci_sessions`(`session_id`,`ip_address`,`user_agent`,`last_activity`,`user_data`) values ('2d31071bfc68f1ab36706b7d052c737b','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0',1423060520,'a:1:{s:9:\"user_data\";s:0:\"\";}'),('8bf2e2ff72b039ad309ba8f3cd428b5d','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0',1423039443,'a:1:{s:9:\"user_data\";s:0:\"\";}');

/*Table structure for table `coa` */

DROP TABLE IF EXISTS `coa`;

CREATE TABLE `coa` (
  `coa_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coa_number` varchar(25) NOT NULL DEFAULT '',
  `coa_type_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT '1',
  `description` varchar(100) NOT NULL DEFAULT '',
  `crdr` enum('CR','DR') NOT NULL DEFAULT 'CR',
  `coa_status` enum('ACTIVE','NOT ACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`coa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

/*Data for the table `coa` */

insert  into `coa`(`coa_id`,`coa_number`,`coa_type_id`,`currency_id`,`description`,`crdr`,`coa_status`) values (1,'1-110',1,1,'CASH','DR','ACTIVE'),(2,'1-120',1,1,'BANK MANDIRI 664','DR','ACTIVE'),(3,'1-121',1,1,'BANK BII IDR','DR','ACTIVE'),(4,'1-122',1,3,'BANK BII','DR','ACTIVE'),(6,'1-200',1,1,'ACCOUNT RECEIVABLE','DR','ACTIVE'),(7,'1-210',1,1,'EMPLOYEE RECEIVABLE ','DR','ACTIVE'),(8,'1-220',1,1,'PROVISION FOR DOUBTFUL','DR','ACTIVE'),(9,'1-300',1,1,'INVENTORY','DR','ACTIVE'),(10,'1-400',1,1,'PREPAID RENT','DR','ACTIVE'),(12,'1-500',1,1,'Office Equipment','DR','ACTIVE'),(13,'2-100',1,1,'ACCOUNT PAYABLE','CR','ACTIVE'),(14,'2-200',1,1,'SALARY PAYABLE','CR','ACTIVE'),(15,'2-300',2,1,'TAX PAYABLE','CR','ACTIVE'),(16,'2-400',2,1,'Accrual Expenses','CR','ACTIVE'),(17,'2-500',2,1,'OTHERS PAYABLE','CR','ACTIVE'),(18,'2-600',2,1,'THIRD PARTIES PAYABLE','CR','ACTIVE'),(19,'2-700',2,1,'LONG TERM PAYABLE','CR','ACTIVE'),(20,'3-100',3,1,'SHAREHOLDERS','CR','ACTIVE'),(21,'3-200',3,1,'PRIVE','CR','ACTIVE'),(22,'3-800',3,1,'RETAINED EARNING','CR','ACTIVE'),(23,'3-900',3,1,'RETAINED EARNING CURRENT YEAR','CR','ACTIVE'),(24,'4-100',4,1,'REVENUE','CR','ACTIVE'),(25,'4-600',4,1,'INTEREST INCOME','CR','ACTIVE'),(26,'4-700',4,1,'FOREIGN EXCHANGE RATE','CR','ACTIVE'),(27,'4-800',4,1,'OTHER REVENUE','CR','ACTIVE'),(28,'4-900',4,1,'MISCELLANEOUS INCOME','CR','ACTIVE'),(29,'6-000',5,1,'SALARIES','DR','ACTIVE'),(30,'6-100',5,1,'THR & THN','DR','ACTIVE'),(31,'6-110',5,1,'OVERTIME','DR','ACTIVE'),(32,'6-120',5,1,'LABOUR INSURANCE (JAMSOSTEK)','DR','ACTIVE'),(33,'6-130',5,1,'HEALTH INSURANCE (BPJS)','DR','ACTIVE'),(34,'6-140',5,1,'TERMINATION','DR','ACTIVE'),(35,'6-150',5,1,'STAFF WELFARE','DR','ACTIVE'),(36,'6-160',5,1,'MEDICAL CHECK UP','DR','ACTIVE'),(37,'6-170',5,1,'RECRUITMENT EXPENSE','DR','ACTIVE'),(38,'6-180',5,1,'UNIFORM','DR','ACTIVE'),(39,'6-190',5,1,'SAFETY & EQUIPMENT','DR','ACTIVE'),(40,'6-200',5,1,'SALARIES - GM & CORPORATE','DR','ACTIVE'),(41,'6-300',5,1,'LEGAL & NOTARIAL FEE','DR','ACTIVE'),(42,'6-310',5,1,'INSURANCE EXPENSES','DR','ACTIVE'),(43,'6-320',5,1,'PRINTING & STATIONARY','DR','ACTIVE'),(44,'6-321',5,1,'Fotocopy','DR','ACTIVE'),(45,'6-322',5,1,'Office Supplies','DR','ACTIVE'),(46,'6-323',5,1,'Postage mail & courier','DR','ACTIVE'),(47,'6-311',5,1,'Government dues & Fees','DR','ACTIVE'),(48,'6-312',5,1,'Tax Expenses','DR','ACTIVE'),(49,'6-400',5,1,'Transportation & Gasoline','DR','ACTIVE'),(50,'6-500',5,1,'TELEPHOHE & FACSIMILE','DR','ACTIVE'),(51,'6-510',5,1,'SPEEDY','DR','ACTIVE'),(52,'6-600',5,1,'ENTERTAINMENT','DR','ACTIVE'),(53,'6-700',5,1,'OFFICE RENT EXPENSES','DR','ACTIVE'),(54,'6-710',5,1,'GENERAL OFFICE','DR','ACTIVE'),(55,'6-711',5,1,'OFFICE MISC EXPENSES','DR','ACTIVE'),(56,'6-520',5,1,'WATER EXPENSES','DR','ACTIVE'),(57,'6-530',5,1,'ELECTRICITY EXPENSES','DR','ACTIVE'),(58,'6-900',5,1,'BANK CHARGE','DR','ACTIVE'),(59,'6-800',5,1,'DEPRECIATION OFFICE EQUIPMENT','DR','ACTIVE'),(60,'1-123',1,1,'Bank Mandiri IDR Gab','DR','ACTIVE'),(61,'1-401',1,1,'Prepaid Others','DR','ACTIVE'),(62,'6-810',5,1,'Depreciation Workshop Equipment','DR','ACTIVE'),(63,'1-501',1,1,'Accumulated Depreciation Equipment','CR','ACTIVE'),(64,'1-502',1,1,'Workshop Equipment','DR','ACTIVE'),(65,'1-503',1,1,'Accumulated Depreciation Workshop Equipment','CR','ACTIVE'),(66,'1-124',1,1,'Contra Account','DR','ACTIVE'),(67,'5-100',6,1,'Salary Supervisor','DR','ACTIVE'),(68,'5-110',6,1,'Salary Foreman','DR','ACTIVE'),(69,'5-120',6,1,'Salary Welder','DR','ACTIVE'),(70,'5-130',6,1,'Salary Fitter','DR','ACTIVE'),(71,'5-200',6,1,'Meals & transport allowance','DR','ACTIVE'),(72,'5-300',6,1,'Overtime','DR','ACTIVE'),(73,'5-400',6,1,'Jamsostek','DR','ACTIVE'),(74,'5-500',6,1,'BPJS','DR','ACTIVE'),(75,'5-600',6,1,'Tax','DR','ACTIVE'),(76,'5-700',6,1,'Medical Check up','DR','ACTIVE'),(77,'5-710',6,1,'Welder Qualification Test','DR','ACTIVE'),(78,'5-720',6,1,'Personal Protective Equipment','DR','ACTIVE'),(79,'6-701',5,1,'Repair & Maintenance Office Building','DR','ACTIVE'),(80,'6-702',5,1,'Repair & Manitenance Workshop Building','DR','ACTIVE'),(81,'1-504',1,1,'Office Supplies','DR','ACTIVE'),(82,'1-504',1,1,'Office Supplies','DR','ACTIVE');

/*Table structure for table `coa_type` */

DROP TABLE IF EXISTS `coa_type`;

CREATE TABLE `coa_type` (
  `coa_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coa_type_name` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`coa_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `coa_type` */

insert  into `coa_type`(`coa_type_id`,`coa_type_name`) values (1,'ASSET'),(2,'PAYABLE'),(3,'STOCKHOLDER/EQUITY'),(4,'REVENUE'),(5,'EXPENSES'),(6,'Cost Of Sale');

/*Table structure for table `currency` */

DROP TABLE IF EXISTS `currency`;

CREATE TABLE `currency` (
  `currency_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `currency_label` varchar(25) NOT NULL DEFAULT '',
  `currency_rate` double NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `currency` */

insert  into `currency`(`currency_id`,`currency_label`,`currency_rate`) values (1,'IDR',1),(2,'USD',12000),(3,'SGD',9500);

/*Table structure for table `jurnal` */

DROP TABLE IF EXISTS `jurnal`;

CREATE TABLE `jurnal` (
  `transaction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `ref_number` varchar(50) NOT NULL DEFAULT '',
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `transaction_status` enum('VOID','VALID') NOT NULL DEFAULT 'VALID',
  `input_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;

/*Data for the table `jurnal` */

insert  into `jurnal`(`transaction_id`,`transaction_date`,`ref_number`,`remarks`,`created_by`,`transaction_status`,`input_date`) values (1,'2014-10-31','PCV-003','Water September 2014 Ruko Legenda point',3,'VALID','2015-01-27 15:53:20'),(2,'2014-10-31','PCV-004','Electricity Sep 2014 Ruko Legenda Point',3,'VALID','2015-01-27 15:55:26'),(3,'2014-10-31','RV-001','Setoran modal awal',3,'VALID','2015-01-28 09:26:18'),(4,'2014-10-31','PV-0001','Bank admin Oct 2014',3,'VALID','2015-01-28 09:33:00'),(5,'2014-11-10','RV-003','Loan from Ibu Siti',3,'VALID','2015-01-28 10:13:18'),(6,'2014-10-31','RV-002','Bank interest Oct 2014',3,'VALID','2015-01-28 09:48:59'),(7,'2014-11-11','PV-001A','Withdrawal for operational',3,'VALID','2015-01-28 10:19:01'),(8,'2014-11-11','PV-002','Withdrawal for operational',3,'VALID','2015-01-28 10:17:59'),(9,'2014-11-24','PV-003','Withdrawal for operational',3,'VALID','2015-01-28 10:24:55'),(10,'2014-11-25','PV-004','Withdrawal for operational',3,'VALID','2015-01-28 10:26:52'),(11,'2014-11-30','PV-005','Bank admin Nov 2014',3,'VALID','2015-01-28 10:29:57'),(12,'2014-12-01','PV-007','Withdrawal for operational',3,'VALID','2015-01-28 10:31:43'),(13,'2014-12-03','PV-008','Withdrawal for operational',3,'VALID','2015-01-28 10:32:44'),(14,'2014-12-04','RV-005','Loan from PT. Sindo Seiki',3,'VALID','2015-01-28 10:40:06'),(15,'2014-12-09','PV-010','Withdrawal for operational',3,'VALID','2015-01-28 10:42:33'),(16,'2014-12-10','RV-006','Setoran Modal',3,'VALID','2015-01-28 10:44:26'),(17,'2014-11-02','PCV-0008','RM building\nFotocopy',3,'VALID','2015-01-28 11:13:40'),(18,'2014-11-03','PCV-0007','Security Oct Ruko Legenda point, uniform, water & electricity Oct Ruko Legenda Point',3,'VALID','2015-01-28 11:17:14'),(20,'2014-11-04','PCV-0009','Printing, stationary and fotocopy',3,'VALID','2015-01-29 16:28:55'),(21,'2014-11-04','PCV-0010','Medical check up',3,'VALID','2015-01-29 16:31:12'),(22,'2014-11-05','PCV-0011','Security Nov 2014 Ruko Legenda Point & fotocopy',3,'VALID','2015-01-29 16:34:56'),(23,'2014-11-06','PCV-0012','Cable sisir,meteran,trunking PVC\n(RM building) Ruko Legenda Point',3,'VALID','2015-01-30 09:20:17'),(24,'2014-11-06','PCV-0013','Semen (RM building) \n1pax Sanford 600ml (general off)',3,'VALID','2015-01-30 09:18:18'),(25,'2014-11-07','PCV-0014','Fotocopy, printing & stationary',3,'VALID','2015-01-29 16:46:25'),(26,'2014-11-07','PCV-0015','Rental fotocopy machine periode 7/11 - 7/12/2014',3,'VALID','2015-01-29 16:53:16'),(27,'0000-00-00','PCV-0016','AC Mitsubishi 1PK; printing stationary, RM building',3,'VALID','2015-01-30 08:14:26'),(28,'2014-11-08','PCV-0017','Semen,kaca,paku,etc (RM building)',3,'VALID','2015-01-30 09:16:42'),(29,'2014-11-09','PCV-0018','Triplek,paku (RM buiding); sapu,pel lantai (General off);Kertas A4, binder clip',3,'VALID','2015-01-30 09:14:20'),(30,'2014-11-10','PCV-0019','List plag (RM buiding)\nSanford',3,'VALID','2015-01-30 09:23:38'),(31,'2014-11-11','PCV-0020','2pcs meja kantor @700rb; 4 pcs kursi kantor @250rb\nprinting& stationary',3,'VALID','2015-01-30 09:31:38'),(32,'2014-11-11','PCV-0020','2pcs meja kantor @700rb; 4 pcs kursi kantor @250rb\nprinting& stationary',3,'VALID','2015-01-30 09:31:39'),(33,'2014-11-12','PCV-0021','2unit Laptop \"ASUS\" @3.350rb\nkeset,gayung,glade,etc',3,'VALID','2015-01-30 09:37:41'),(34,'2014-11-12','PCV-0022','Speedy periode 13/11/2014 - 12/12/2014',3,'VALID','2015-01-30 09:39:47'),(35,'2014-11-15','PCV-0023','6pcs gelas kaca',3,'VALID','2015-01-30 09:41:12'),(36,'2014-11-18','PCV-0024','Fotocopy\nMeals',3,'VALID','2015-01-30 09:42:54'),(37,'2014-11-18','PCV-0024','Fotocopy\nMeals',3,'VALID','2015-01-30 09:42:55'),(38,'2014-11-19','PCV-0025','1set Telephone+cable\nduplikat kunci',3,'VALID','2015-01-30 09:45:13'),(39,'2014-11-21','PCV-0026','Papan nama perusahaan\nmeals',3,'VALID','2015-01-30 09:47:37'),(40,'2014-11-24','PCV-0027','100pcs wearpack dark blue ( Yupiter Baru Jaya )\nsafety equipment (New Excel Superindo)',3,'VALID','2015-01-30 09:56:23'),(41,'2014-11-24','PCV-0028','Printing stationary\n4pcs galon',3,'VALID','2015-01-30 09:52:10'),(42,'2014-11-26','PCV-0029','102pcs coverall embrodery ( CV. Davisco Batam)',3,'VALID','2015-01-30 09:54:02'),(43,'2014-11-26','PCV-0030','Cable, grendel,etc',3,'VALID','2015-01-30 09:58:05'),(44,'2014-11-28','PCV-005','duplikat kunci',3,'VALID','2015-01-30 09:59:44'),(45,'2014-12-16','PCV-0036','36pcs logo wearpack\ngasoline\n1,5mtr stk meter',3,'VALID','2015-01-30 10:23:56'),(46,'2014-12-15','PCV-0037','3pcs Materai',3,'VALID','2015-01-30 10:24:59'),(47,'2014-12-13','PCV-0039','Stationary\nsapu, soklin, sanford,etc',3,'VALID','2015-01-30 10:27:07'),(48,'2014-12-11','PCV-0040','Medical check up 17/11/2014 - 19/11/2014  (93 org)',3,'VALID','2015-01-30 10:29:10'),(49,'2014-12-10','PCV-0042','Meals\nprinting&stationary;\nuniform (pelunasan wearpack Navy 92pcs/PT Treesbee)',3,'VALID','2015-01-30 10:38:57'),(50,'2014-12-05','PCV-0043','27pcs materai\nHelmet,eyewear,earplug ( New excel Superindo )',3,'VALID','2015-01-30 10:42:59'),(51,'2014-12-06','PCV-0045','1box kertas A4\nMeals',3,'VALID','2015-01-30 10:45:30'),(52,'2014-12-08','PCV-0046','56pcs wearpack ( Vanhotton )\ncetak pas photo',3,'VALID','2015-01-30 10:51:18'),(53,'2014-12-02','PCV-0047','50pcs Helmet,eyewear, eyeplug ( New excel Superindo )\nmarketing exp (Mr Buco)',3,'VALID','2015-01-30 11:02:14'),(54,'2014-12-02','PCV-0047','50pcs Helmet,eyewear, eyeplug ( New excel Superindo )\nmarketing exp (Mr Buco)',3,'VALID','2015-01-30 11:02:14'),(55,'2014-12-06','PCV-0048','duplikat kunci\nMeals',3,'VALID','2015-01-30 13:54:27'),(56,'2014-12-30','PCV-0049','Car rental Dec 2014 ( marketing Exp )',3,'VALID','2015-01-30 14:14:46'),(57,'2014-12-31','PCV-0059','Alum PTN door etc for Workshop & office',3,'VALID','2015-02-03 08:36:55'),(58,'2014-12-31','PCV-0060','Gypsum, seng partisi,etc for Workshop',3,'VALID','2015-02-03 08:38:44'),(59,'2014-12-31','PCV-0061','door closet, kabel,paku, etc for workshop',3,'VALID','2015-02-03 08:42:29'),(60,'2014-12-31','PCV-0062','Meals,gerendel sorento for workshop,gasoline',3,'VALID','2015-02-03 08:45:33'),(61,'2014-12-31','PCV-0063','Silicon,grendel,gerinda,etc for workshop,\ntransportation',3,'VALID','2015-02-03 08:51:32'),(62,'2014-12-31','PCV-0064','Cat Ninja, kunci',3,'VALID','2015-02-03 08:53:06'),(63,'2014-12-31','PCV-0065','ring,full orat,etc for workshop',3,'VALID','2015-02-03 08:54:46'),(64,'2014-12-31','PCV-0066','Kaca ryben,partisi skirting,etc for workshop',3,'VALID','2015-02-03 08:56:29'),(65,'2014-12-31','PCV-0067','Electric material for workshop',3,'VALID','2015-02-03 08:57:51'),(66,'2014-12-31','PCV-0068','semen,paku,etc for workshop',3,'VALID','2015-02-03 09:01:52'),(67,'2014-12-31','PCV-0069','mata bor,selang,etc',3,'VALID','2015-02-03 09:09:35'),(68,'2014-12-31','PCV-0070','Bensin',3,'VALID','2015-02-03 09:10:53'),(69,'0000-00-00','PCV-0071','meals',3,'VALID','2015-02-03 09:12:45'),(70,'2014-12-31','PCV-0072','Meals',3,'VALID','2015-02-03 09:20:16'),(71,'2014-12-31','PCV-0073','melas\ngerendel',3,'VALID','2015-02-03 09:28:36'),(72,'2014-12-31','PCV-0074','Meals',3,'VALID','2015-02-03 09:30:03'),(73,'2014-12-31','PCV-0075','Gypsum,seng partisii,etc',3,'VALID','2015-02-03 09:31:27'),(74,'2014-12-31','PCV-0076','pipa listrik,elbow,etc for workshop',3,'VALID','2015-02-03 09:33:04'),(75,'2014-12-31','PCV-0077','Gasoline',3,'VALID','2015-02-03 09:34:38'),(76,'2014-12-31','PCV-0078','Cat Ninja for wokshop',3,'VALID','2015-02-03 09:36:03'),(77,'2014-12-31','PCV-0079','Alum skirting,etc for workshop',3,'VALID','2015-02-03 09:38:45'),(78,'2014-12-31','PCV-0080','jointape for workshop',3,'VALID','2015-02-03 09:40:42'),(79,'2014-12-31','PCV-0081','10 set sika top seal for workshop',3,'VALID','2015-02-03 09:43:32'),(80,'2014-12-31','PCV-0050','kuas + thinner',3,'VALID','2015-02-03 09:44:51'),(81,'2014-12-31','PCV-0051','Meals',3,'VALID','2015-02-03 09:45:46'),(82,'2014-12-31','PCV-0052','2 set Coverall wearpack ( Yupiter Baru Jaya )\nspidol',3,'VALID','2015-02-03 09:48:45'),(83,'2014-12-31','PCV-0053','printing stationary,\nobat P3K for employee',3,'VALID','2015-02-03 09:53:14'),(84,'2014-12-31','PCV-0054','Transportation',3,'VALID','2015-02-03 09:54:56'),(85,'2014-12-31','PCV-0055','50 pcs emblem PGI\n2 pcs bordir wearpack ( Vanhotton Indonesia )',3,'VALID','2015-02-03 09:59:09'),(86,'2014-12-31','PCV-0056','3 pcs Cartridge HP 678; TP Link, power bank Samsung, modem',3,'VALID','2015-02-04 09:52:43'),(87,'2014-12-31','PCV-0057','Office Rental Ruko Legenda point periode 16 Des 2014 - 15 Mar 2015',3,'VALID','2015-02-04 09:55:53'),(88,'2014-12-31','PCV-0058','air minum galon at Wasco office',3,'VALID','2015-02-04 10:00:16'),(89,'2014-12-31','PCV-0006','Marketing Exp. ( Mr. Buco )',3,'VALID','2015-02-04 10:01:32'),(90,'2014-12-31','PCV-0084','Tagihan Speedy & tlp Nov 2014',3,'VALID','2015-02-04 10:07:08'),(91,'2014-12-31','PCV-0085','Tagihan air Nov 2014',3,'VALID','2015-02-04 10:08:17'),(92,'2014-12-31','PCV-0086','Electricity Ruko Legenda Nov 2014',3,'VALID','2015-02-04 10:09:32'),(93,'2014-12-31','PCV-0044','Meals',3,'VALID','2015-02-04 10:10:31'),(94,'2014-12-31','PCV-0090','Salary 26 Nov - 25 Dec 2014 Nawal Fadly',3,'VALID','2015-02-04 10:15:58'),(95,'2014-12-31','PCV-0092','Salary Oma Jhon Mora 26 Nov - 25 Dec 2014',3,'VALID','2015-02-04 10:21:50'),(96,'2014-12-31','PCV-0093','Salary Bertoni 26 Nov - 25 Des 2014',3,'VALID','2015-02-04 10:29:23'),(97,'2014-12-31','PCV-0094','Lem fox, kuas,fitting,kuas etc',3,'VALID','2015-02-04 10:32:37'),(98,'2014-12-31','PCV-0095','Alm handle,kaca ryben, lampu,triplek,cat, etc',3,'VALID','2015-02-04 10:34:43'),(99,'2014-12-31','PCV-0096','Meals',3,'VALID','2015-02-04 10:35:50'),(100,'2014-12-31','PCV-0097','Gasoline',3,'VALID','2015-02-04 10:42:00'),(101,'2014-12-31','PCV-0098','10 pcs logo wearpack ( Dina Taylor )',3,'VALID','2015-02-04 10:43:07'),(102,'2014-12-31','PCV-0099','Deposit to PT. Trade Electric Asia Electricity material for workshop',3,'VALID','2015-02-04 10:47:07'),(103,'2014-12-31','PCV-0031','Container rent for Wasco office periode 1 Des 2014 - 31 Mar 2015',3,'VALID','2015-02-04 10:51:45'),(104,'2014-12-31','PCV-0038','Sanford etc',3,'VALID','2015-02-04 10:52:52'),(105,'2014-12-31','PCV-0100','kekurangan gaji Sahriadi ( Office ) Nov 2014',3,'VALID','2015-02-04 10:55:40'),(106,'2014-12-31','PCV-0101','Kekurangan gaji Aida Nov 2014',3,'VALID','2015-02-04 10:56:57'),(107,'2014-12-31','PCV-0102','Kekurangan gaji Jonuar Nov 2014',3,'VALID','2015-02-04 10:58:42'),(108,'2014-12-31','PCV-0104','Kekurangan gaji Ahmad Navik Nov 2014',3,'VALID','2015-02-04 11:00:21'),(109,'2014-12-31','PCV-0105','Kekurangan gaji Rahmat Kartolo Nov 2014',3,'VALID','2015-02-04 11:01:58'),(110,'2014-12-31','PCV-0106','Salary workshop employee',3,'VALID','2015-02-04 11:03:09'),(111,'2014-12-31','PCV-0107','Gaji Afrizal Bin Paiman Nov 2014\nGaji Abdul Latif Nov 2014',3,'VALID','2015-02-04 11:13:42'),(112,'2014-12-31','PCV-0109','26 pcs wear pack ( Yupiter Baru Jaya )\n35 set earplug',3,'VALID','2015-02-04 11:15:33'),(113,'2014-12-31','PCV-0110','1set meja makan + 4kursi\n2pcs meja ; 1pcs rak',3,'VALID','2015-02-04 11:19:47'),(114,'2014-12-31','PCV-0111','26 pcs bordir logo PGI ( Vanhotton )5',3,'VALID','2015-02-04 11:22:38'),(115,'2014-12-31','PCV-0112','ABC, Indocafe',3,'VALID','2015-02-04 11:29:49'),(116,'2014-12-31','PCV-0113','Stationary',3,'VALID','2015-02-04 11:32:35'),(117,'2014-12-31','PCV-0114','92 pcs wearpack cotton with logo ( Treesbee ) DP',3,'VALID','2015-02-04 11:40:39'),(118,'2014-12-31','PCV-0115','99 pcs wearpack  ( Vanhotton & Yupiter Baru Jaya',3,'VALID','2015-02-04 11:49:11'),(119,'2014-12-31','PCV-0116','Helmet, earplug, (PT. Trimitra Harapan, International Hardware)',3,'VALID','2015-02-04 12:01:49'),(120,'2014-12-31','PCV-0117','39 pcs wearpack, bordir, 2 pcs safety gogless ( Yupiter Baru Jaya )',3,'VALID','2015-02-04 13:07:43'),(121,'2014-12-31','PCV-0118','Meals',3,'VALID','2015-02-04 13:08:33'),(122,'2014-12-31','PCV-0119','39pcs helmet , kacamata, earplug (PT. Pratama Widya Sejahtera)',3,'VALID','2015-02-04 13:11:44'),(123,'2014-12-31','PCV-0120','36pcs Helmet ( PT.Pratama Widya Sejahtera )',3,'VALID','2015-02-04 13:15:22'),(124,'2014-12-31','PCV-0121','35pcs kacamata ( PT.Pratama Widya Sejahtera )',3,'VALID','2015-02-04 13:24:09'),(125,'2014-12-31','PCV-0122','Toner HP, multi file, etc',3,'VALID','2015-02-04 13:27:53'),(126,'2014-12-31','PCV-0123','Alum PTN skirting, etc',3,'VALID','2015-02-04 13:30:22'),(127,'2014-12-31','PCV-0124','Electricity December 2014 Tunas 2 office',3,'VALID','2015-02-04 13:50:51'),(128,'2014-12-31','PCV-0125','95 prsn Medical check up',3,'VALID','2015-02-04 13:59:34'),(129,'2014-12-31','PCV-0126','Main tee, cross tee, ceiling sakura,etc',3,'VALID','2015-02-04 14:01:12'),(130,'2014-12-31','PCV-0127','Meals',3,'VALID','2015-02-04 14:01:58'),(131,'2014-12-31','PCV-0128','Gasoline',3,'VALID','2015-02-04 14:02:46'),(132,'2014-12-31','PCV-0129','Pengurusan SIUJK / Surat Ijin Usaha Jasa Konstruksi',3,'VALID','2015-02-04 14:04:40'),(133,'2014-12-31','PCV-0130','Engsel, lem, cat lantai, etc',3,'VALID','2015-02-04 14:05:43'),(134,'2014-12-31','PCV-0131','Meals',3,'VALID','2015-02-04 14:06:34'),(135,'2014-12-31','PCV-0132','1set telephone, 5 meja kantor + kursi\ntempat sampah,ember,etc',3,'VALID','2015-02-04 14:09:24'),(136,'2014-12-31','PCV-0133','Stationary\nkeset kaki,etc',3,'VALID','2015-02-04 14:14:09'),(137,'2014-12-31','PCV-0134','Triplek, selang, etc',3,'VALID','2015-02-04 14:17:00'),(138,'2014-12-31','PCV-0135','Gasoline',3,'VALID','2015-02-04 14:18:01'),(139,'2014-12-31','PCV-0136','Kasbon ( Daven, Dana, Sukri )',3,'VALID','2015-02-04 14:22:45'),(140,'2014-12-31','PCV-0137','Elbow, gembok, carbide rotary',3,'VALID','2015-02-04 14:24:37'),(141,'2014-12-31','PCV-0138','2 meja kantor + kursi\n2 meja + 4 kantor',3,'VALID','2015-02-04 14:26:54'),(142,'2014-12-31','PCV-0139','Papan nama',3,'VALID','2015-02-04 14:29:58'),(143,'2014-12-31','PCV-0140','1 set Camera Nikkon S3500\nTP Link',3,'VALID','2015-02-04 14:32:03'),(144,'2014-12-31','PCV-0141','Gasoline',3,'VALID','2015-02-04 14:33:30'),(145,'2014-12-31','PCV-0142','Pemasangan ceiling at Tunas 2 office',3,'VALID','2015-02-04 14:35:05'),(146,'2014-12-31','PCV-0002','DP PT. Intelindo',3,'VALID','2015-02-04 14:38:38'),(147,'2014-12-31','PCV-0082','Pinjaman karyawan',3,'VALID','2015-02-04 14:45:59'),(148,'0000-00-00','PCV-0032','Pembuatan website perusahaan',3,'VALID','2015-02-04 14:47:24'),(149,'2014-12-31','PCV-0033','bordir at vanhotton',3,'VALID','2015-02-04 14:48:56'),(150,'2014-12-31','PCV-0034','Toner for printer at Wasco\nRM workshop building',3,'VALID','2015-02-04 14:52:50'),(151,'2014-12-31','PCV-0035','Pinjaman karyawan',3,'VALID','2015-02-04 14:53:52'),(152,'2014-12-31','PCV-0083','Marketing exp ( Mr. Buco )',3,'VALID','2015-02-04 14:57:35'),(153,'2014-11-30','PCV-0001','Pengerjaan listrik dan pasang kaca office ruko Legenda',3,'VALID','2015-02-04 14:59:02'),(154,'2014-11-30','PCV-0087','Pendaftaran PT ke Jamsostek',3,'VALID','2015-02-04 15:00:40'),(155,'2014-11-30','PCV-0088','Transportation for welding test',3,'VALID','2015-02-04 15:01:57'),(156,'2014-11-30','PCV-0089','Meals for night shift',3,'VALID','2015-02-04 15:03:11'),(157,'2014-11-30','PCV-0091','Entertainment f/ Wasco\'s QC',3,'VALID','2015-02-04 15:04:19'),(158,'2014-11-30','PCV-0108','Arrange electricity at Ruko Legenda point',3,'VALID','2015-02-04 15:05:16'),(159,'2015-01-05','PV-001','Penarikan tunai for operational',3,'VALID','2015-02-04 15:44:03'),(160,'2015-01-20','RV-100','Loan from Pa. Folooziduhu Nehe',3,'VALID','2015-02-04 15:47:15');

/*Table structure for table `jurnal_detail` */

DROP TABLE IF EXISTS `jurnal_detail`;

CREATE TABLE `jurnal_detail` (
  `transaction_detail_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `coa_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `crdr` enum('CR','DR') NOT NULL DEFAULT 'CR',
  `current_currency_rate` double NOT NULL,
  PRIMARY KEY (`transaction_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=393 DEFAULT CHARSET=utf8;

/*Data for the table `jurnal_detail` */

insert  into `jurnal_detail`(`transaction_detail_id`,`transaction_id`,`coa_id`,`amount`,`crdr`,`current_currency_rate`) values (1,1,56,85000,'DR',1),(2,1,1,85000,'CR',1),(3,2,57,118951,'DR',1),(4,2,1,118951,'CR',1),(5,3,2,5000000,'DR',1),(6,3,20,5000000,'CR',1),(7,4,58,10000,'DR',1),(8,4,2,10000,'CR',1),(9,5,2,250000000,'DR',1),(10,5,18,250000000,'CR',1),(13,7,1,20000000,'DR',1),(14,7,2,20000000,'CR',1),(15,8,1,50000000,'DR',1),(16,8,2,50000000,'CR',1),(17,9,1,30000000,'DR',1),(18,9,2,30000000,'CR',1),(19,10,1,25000000,'DR',1),(20,10,2,25000000,'CR',1),(21,11,58,10000,'DR',1),(22,11,2,10000,'CR',1),(23,12,1,50000000,'DR',1),(24,12,2,50000000,'CR',1),(25,13,1,30000000,'DR',1),(26,13,2,30000000,'CR',1),(29,14,2,100000000,'DR',1),(30,14,18,100000000,'CR',1),(31,15,1,40000000,'DR',1),(32,15,2,40000000,'CR',1),(33,16,2,269000000,'DR',1),(34,16,20,269000000,'CR',1),(35,17,44,32400,'DR',1),(36,17,79,111000,'DR',1),(37,17,1,143400,'CR',1),(38,18,38,100000,'DR',1),(39,18,54,80000,'DR',1),(40,18,56,85000,'DR',1),(41,18,57,93951,'DR',1),(42,18,1,358951,'CR',1),(45,6,2,136.71,'DR',1),(46,6,25,136.71,'CR',1),(47,20,43,26000,'DR',1),(48,20,44,31200,'DR',1),(49,20,1,57200,'CR',1),(50,21,76,3600000,'DR',1),(51,21,1,3600000,'CR',1),(52,22,44,46300,'DR',1),(53,22,54,80000,'DR',1),(54,22,1,126300,'CR',1),(55,23,79,635000,'DR',1),(56,23,1,635000,'CR',1),(57,24,54,28000,'DR',1),(58,24,79,20000,'DR',1),(59,24,1,48000,'CR',1),(60,25,43,43000,'DR',1),(61,25,44,20000,'DR',1),(62,25,1,63000,'CR',1),(63,26,44,600000,'DR',1),(64,26,1,600000,'CR',1),(65,27,12,4000000,'DR',1),(66,27,43,9500,'DR',1),(67,27,79,36000,'DR',1),(68,27,1,4045500,'CR',1),(69,28,79,687000,'DR',1),(70,28,1,687000,'CR',1),(71,29,43,104500,'DR',1),(72,29,54,41000,'DR',1),(73,29,79,63000,'DR',1),(74,29,1,208500,'CR',1),(75,30,54,43000,'DR',1),(76,30,79,30000,'DR',1),(77,30,1,73000,'CR',1),(78,31,43,777000,'DR',1),(79,31,82,2400000,'DR',1),(80,31,1,3177000,'CR',1),(81,32,43,777000,'DR',1),(82,32,82,2400000,'DR',1),(83,32,1,3177000,'CR',1),(84,33,12,6700000,'DR',1),(85,33,54,528690,'DR',1),(86,33,1,7228690,'CR',1),(87,34,51,700000,'DR',1),(88,34,1,700000,'CR',1),(89,35,54,40000,'DR',1),(90,35,1,40000,'CR',1),(91,36,44,42000,'DR',1),(92,36,71,434000,'DR',1),(93,36,1,476000,'CR',1),(94,37,44,42000,'DR',1),(95,37,71,434000,'DR',1),(96,37,1,476000,'CR',1),(97,38,54,15000,'DR',1),(98,38,82,575000,'DR',1),(99,38,1,590000,'CR',1),(100,39,55,850000,'DR',1),(101,39,71,684000,'DR',1),(102,39,1,1534000,'CR',1),(103,40,78,28250000,'DR',1),(104,40,1,28250000,'CR',1),(105,41,43,106000,'DR',1),(106,41,54,180000,'DR',1),(107,41,1,286000,'CR',1),(108,42,78,14260000,'DR',1),(109,42,1,14260000,'CR',1),(110,43,79,116000,'DR',1),(111,43,1,116000,'CR',1),(112,44,54,33000,'DR',1),(113,44,1,33000,'CR',1),(114,45,49,100000,'DR',1),(115,45,54,30000,'DR',1),(116,45,78,170000,'DR',1),(117,45,1,300000,'CR',1),(118,46,46,21000,'DR',1),(119,46,1,21000,'CR',1),(120,47,43,165000,'DR',1),(121,47,54,433000,'DR',1),(122,47,1,598000,'CR',1),(123,48,76,11625000,'DR',1),(124,48,1,11625000,'CR',1),(125,49,43,25000,'DR',1),(126,49,71,300000,'DR',1),(127,49,78,6300000,'DR',1),(128,49,1,6625000,'CR',1),(129,50,46,189000,'DR',1),(130,50,78,2690000,'DR',1),(131,50,1,2879000,'CR',1),(132,51,43,175000,'DR',1),(133,51,71,2098000,'DR',1),(134,51,1,2273000,'CR',1),(135,52,55,50000,'DR',1),(136,52,78,1400000,'DR',1),(137,52,1,1450000,'CR',1),(138,53,40,380000,'DR',1),(139,53,78,4250000,'DR',1),(140,53,1,4630000,'CR',1),(141,54,40,380000,'DR',1),(142,54,78,4250000,'DR',1),(143,54,1,4630000,'CR',1),(144,55,55,12000,'DR',1),(145,55,71,236000,'DR',1),(146,55,1,248000,'CR',1),(147,56,40,4700000,'DR',1),(148,56,1,4700000,'CR',1),(149,57,80,1406000,'DR',1),(150,57,1,1406000,'CR',1),(151,58,80,7094000,'DR',1),(152,58,1,7094000,'CR',1),(153,59,52,37000,'DR',1),(154,59,80,1332000,'DR',1),(155,59,1,1369000,'CR',1),(156,60,49,15470,'DR',1),(157,60,71,50000,'DR',1),(158,60,80,68000,'DR',1),(159,60,1,133470,'CR',1),(160,61,50,20000,'DR',1),(161,61,80,275000,'DR',1),(162,61,1,295000,'CR',1),(163,62,80,550000,'DR',1),(164,62,1,550000,'CR',1),(165,63,80,98000,'DR',1),(166,63,1,98000,'CR',1),(167,64,80,1434000,'DR',1),(168,64,1,1434000,'CR',1),(169,65,80,1000000,'DR',1),(170,65,1,1000000,'CR',1),(171,66,80,149000,'DR',1),(172,66,1,149000,'CR',1),(173,67,80,71000,'DR',1),(174,67,1,71000,'CR',1),(175,68,49,37000,'DR',1),(176,68,1,37000,'CR',1),(177,69,71,146000,'DR',1),(178,69,1,146000,'CR',1),(179,70,71,104000,'DR',1),(180,70,1,104000,'CR',1),(181,71,71,79000,'DR',1),(182,71,80,50000,'DR',1),(183,71,1,129000,'CR',1),(184,72,71,173000,'DR',1),(185,72,1,173000,'CR',1),(186,73,80,5794000,'DR',1),(187,73,1,5794000,'CR',1),(188,74,80,399000,'DR',1),(189,74,1,399000,'CR',1),(190,75,49,60000,'DR',1),(191,75,1,60000,'CR',1),(192,76,80,914000,'DR',1),(193,76,1,914000,'CR',1),(194,77,80,914000,'DR',1),(195,77,1,914000,'CR',1),(196,78,80,60000,'DR',1),(197,78,1,60000,'CR',1),(198,79,80,3100000,'DR',1),(199,79,1,3100000,'CR',1),(200,80,80,15000,'DR',1),(201,80,1,15000,'CR',1),(202,81,71,6552000,'DR',1),(203,81,1,6552000,'CR',1),(204,82,43,21000,'DR',1),(205,82,78,514000,'DR',1),(206,82,1,535000,'CR',1),(207,83,35,41482,'DR',1),(208,83,43,507900,'DR',1),(209,83,1,549382,'CR',1),(210,84,49,100000,'DR',1),(211,84,1,100000,'CR',1),(212,85,43,4000,'DR',1),(213,85,78,1300000,'DR',1),(214,85,1,1304000,'CR',1),(215,86,43,255000,'DR',1),(216,86,82,790000,'DR',1),(217,86,1,1045000,'CR',1),(218,87,10,2000000,'DR',1),(219,87,53,1000000,'DR',1),(220,87,1,3000000,'CR',1),(221,88,35,440000,'DR',1),(222,88,1,440000,'CR',1),(223,89,40,1648125,'DR',1),(224,89,1,1648125,'CR',1),(225,90,50,268172,'DR',1),(226,90,51,152500,'DR',1),(227,90,1,420672,'CR',1),(228,91,56,85000,'DR',1),(229,91,1,85000,'CR',1),(230,92,57,434921,'DR',1),(231,92,1,434921,'CR',1),(232,93,71,1872000,'DR',1),(233,93,1,1872000,'CR',1),(234,94,69,3538000,'DR',1),(235,94,71,610000,'DR',1),(236,94,72,3697500,'DR',1),(237,94,1,7720075,'CR',1),(238,94,73,100340,'CR',1),(239,94,74,25085,'CR',1),(240,95,69,3480000,'DR',1),(241,95,71,530000,'DR',1),(242,95,72,3697500,'DR',1),(243,95,1,7582075,'CR',1),(244,95,73,100340,'CR',1),(245,95,74,25085,'CR',1),(246,96,70,2688000,'DR',1),(247,96,72,2520000,'DR',1),(248,96,72,540000,'DR',1),(249,96,1,5664960,'CR',1),(250,96,73,83040,'CR',1),(251,97,80,177000,'DR',1),(252,97,1,177000,'CR',1),(253,98,80,3852100,'DR',1),(254,98,1,3852100,'CR',1),(255,99,71,628000,'DR',1),(256,99,1,628000,'CR',1),(257,100,49,60000,'DR',1),(258,100,1,60000,'CR',1),(259,101,78,50000,'DR',1),(260,101,1,50000,'CR',1),(261,102,80,10000000,'DR',1),(262,102,1,10000000,'CR',1),(263,103,10,11250000,'DR',1),(264,103,53,3750000,'DR',1),(265,103,1,15000000,'CR',1),(266,104,54,407000,'DR',1),(267,104,1,407000,'CR',1),(268,105,31,173000,'DR',1),(269,105,1,173000,'CR',1),(270,106,31,242700,'DR',1),(271,106,1,242700,'CR',1),(272,107,67,660000,'DR',1),(273,107,1,660000,'CR',1),(274,108,69,444000,'DR',1),(275,108,1,444000,'CR',1),(276,109,67,2025418,'DR',1),(277,109,1,2025418,'CR',1),(278,110,29,5000000,'DR',1),(279,110,1,5000000,'CR',1),(280,111,69,696000,'DR',1),(281,111,70,2424000,'DR',1),(282,111,71,800000,'DR',1),(283,111,72,5936500,'DR',1),(284,111,1,9511000,'CR',1),(285,111,15,259992,'CR',1),(286,111,28,2468,'CR',1),(287,111,73,83040,'CR',1),(288,112,78,6545000,'DR',1),(289,112,1,6545000,'CR',1),(292,114,78,910000,'DR',1),(293,114,1,910000,'CR',1),(294,115,54,264700,'DR',1),(295,115,1,264700,'CR',1),(296,116,43,538200,'DR',1),(297,116,1,538200,'CR',1),(298,117,78,10000000,'DR',1),(299,117,1,10000000,'CR',1),(300,118,78,28350000,'DR',1),(301,118,1,28350000,'CR',1),(302,119,78,2850000,'DR',1),(303,119,1,1650000,'CR',1),(304,119,18,1200000,'CR',1),(305,113,82,3300000,'DR',1),(306,113,18,3300000,'CR',1),(307,120,78,11080000,'DR',1),(308,120,18,11080000,'CR',1),(309,121,71,2050000,'DR',1),(310,121,18,2050000,'CR',1),(311,122,78,3432000,'DR',1),(312,122,18,3432000,'CR',1),(313,123,78,2052000,'DR',1),(314,123,18,2052000,'CR',1),(315,124,78,980000,'DR',1),(316,124,18,980000,'CR',1),(317,125,43,993350,'DR',1),(318,125,1,993350,'CR',1),(319,126,80,3997000,'DR',1),(320,126,1,3997000,'CR',1),(321,127,57,396000,'DR',1),(322,127,1,396000,'CR',1),(323,128,76,11875000,'DR',1),(324,128,1,11875000,'CR',1),(325,129,80,10593000,'DR',1),(326,129,1,10593000,'CR',1),(327,130,71,218000,'DR',1),(328,130,1,218000,'CR',1),(329,131,49,40000,'DR',1),(330,131,1,40000,'CR',1),(331,132,41,7000000,'DR',1),(332,132,1,7000000,'CR',1),(333,133,80,2059400,'DR',1),(334,133,1,2059400,'CR',1),(335,134,71,94000,'DR',1),(336,134,1,94000,'CR',1),(337,135,54,161000,'DR',1),(338,135,82,4970000,'DR',1),(339,135,1,5131000,'CR',1),(340,136,43,1027500,'DR',1),(341,136,54,597200,'DR',1),(342,136,1,1624700,'CR',1),(343,137,80,1741000,'DR',1),(344,137,1,1741000,'CR',1),(345,138,49,625000,'DR',1),(346,138,1,625000,'CR',1),(347,139,7,900000,'DR',1),(348,139,1,900000,'CR',1),(349,140,80,553000,'DR',1),(350,140,1,553000,'CR',1),(351,141,82,4450000,'DR',1),(352,141,1,4450000,'CR',1),(353,142,55,2055000,'DR',1),(354,142,1,2055000,'CR',1),(355,143,12,1500000,'DR',1),(356,143,80,324000,'DR',1),(357,143,1,1824000,'CR',1),(358,144,49,200000,'DR',1),(359,144,1,200000,'CR',1),(360,145,80,6000000,'DR',1),(361,145,1,6000000,'CR',1),(362,146,13,8000000,'DR',1),(363,146,1,8000000,'CR',1),(364,147,7,12600000,'DR',1),(365,147,1,12600000,'CR',1),(366,148,55,1000000,'DR',1),(367,148,1,1000000,'CR',1),(368,149,78,195000,'DR',1),(369,149,1,195000,'CR',1),(370,150,43,730000,'DR',1),(371,150,80,158000,'DR',1),(372,150,18,888000,'CR',1),(373,151,7,11600000,'DR',1),(374,151,1,11600000,'CR',1),(375,152,40,90000000,'DR',1),(376,152,1,90000000,'CR',1),(377,153,79,1000000,'DR',1),(378,153,1,1000000,'CR',1),(379,154,47,1000000,'DR',1),(380,154,1,1000000,'CR',1),(381,155,77,600000,'DR',1),(382,155,1,600000,'CR',1),(383,156,71,300000,'DR',1),(384,156,1,300000,'CR',1),(385,157,52,300000,'DR',1),(386,157,1,300000,'CR',1),(387,158,79,500000,'DR',1),(388,158,1,500000,'CR',1),(389,159,1,15000000,'DR',1),(390,159,2,15000000,'CR',1),(391,160,2,1000000000,'DR',1),(392,160,19,1000000000,'CR',1);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) NOT NULL DEFAULT '0',
  `menu_icon` varchar(50) NOT NULL DEFAULT 'icon-th',
  `menu_segment` varchar(250) NOT NULL DEFAULT '',
  `menu_name` varchar(250) NOT NULL DEFAULT '',
  `menu_desc` text,
  `menu_active` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `menu_link` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `menu_action` varchar(500) NOT NULL DEFAULT '''view,edit,add,delete''',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`menu_id`,`menu_parent_id`,`menu_icon`,`menu_segment`,`menu_name`,`menu_desc`,`menu_active`,`menu_link`,`menu_action`) values (1,0,'icon-th','','Chart Of Account','Chart Of Account','YES','NO','view'),(2,1,'icon-th','coa','List COA','List Chart Of Account','YES','YES','view,edit,add,delete'),(3,1,'icon-th','coa_type','COA Type','Chart Of Account Type','YES','YES','edit,add,delete,view'),(4,0,'icon-th','','Access','Customize User Access','YES','NO','view'),(5,4,'icon-th','user','User','List User, Change Password','YES','YES','view,edit,add,delete'),(6,4,'icon-th','user_group','User Group','List User Group','YES','YES','view,edit,add,delete'),(7,4,'icon-th','menu','Menu','List Menu','YES','YES','view,edit,add,delete'),(8,4,'icon-th','privilege','Privilege','Access Privilege','YES','YES','view,edit,add,delete'),(9,1,'icon-th','currency','Currency','Currency','YES','YES','edit,add,delete,view'),(10,0,'icon-th','','Accounting','Accounting','YES','NO','view,edit,add,delete'),(11,10,'icon-th','jurnal_entry','Jurnal Entry','.','YES','YES','view,edit,add,delete');

/*Table structure for table `privilege` */

DROP TABLE IF EXISTS `privilege`;

CREATE TABLE `privilege` (
  `privilege_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `privilege_action` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `privilege` */

insert  into `privilege`(`privilege_id`,`menu_id`,`user_group_id`,`privilege_action`) values (1,1,1,'view'),(2,1,2,'view'),(3,1,3,'view'),(4,2,1,'view,edit,add,delete'),(5,2,2,'view,edit,add,delete'),(6,2,3,'view,edit,add,delete'),(7,3,1,'edit,add,delete,view'),(8,3,2,'edit,add,delete,view'),(9,3,3,'edit,add,delete,view'),(10,4,1,'view'),(11,4,2,'view'),(12,4,3,''),(13,5,1,'view,edit,add,delete'),(14,5,2,'view,edit,add,delete'),(15,5,3,''),(16,6,1,'view,edit,add,delete'),(17,6,2,'view,edit,add,delete'),(18,6,3,''),(19,7,1,'view,edit,add,delete'),(20,7,2,''),(21,7,3,''),(22,8,1,'view,edit,add,delete'),(23,8,2,'view,edit,add,delete'),(24,8,3,''),(25,9,1,'edit,add,delete,view'),(26,9,2,'edit,add,delete,view'),(27,9,3,'edit,add,delete,view'),(28,10,1,'view,edit,add,delete'),(29,10,2,'view,edit,add,delete'),(30,10,3,'view,edit,add,delete'),(31,11,1,'view,edit,add,delete'),(32,11,2,'view,edit,add,delete'),(33,11,3,'view,edit,add,delete');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `user_email` varchar(500) NOT NULL DEFAULT '',
  `user_password` varchar(500) NOT NULL DEFAULT '',
  `user_fullname` varchar(250) NOT NULL DEFAULT '',
  `user_active` enum('YES','NO') NOT NULL DEFAULT 'YES',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`user_id`,`user_group_id`,`user_email`,`user_password`,`user_fullname`,`user_active`) values (1,1,'if07087@gmail.com','b39b2b3dc81ed59a16c531c44b5160da92fccd72','Harry Osmar Sitohang','YES'),(2,2,'angraenz@gmail.com','03b409cb14fb2ed6c68f9723226f5339295c07ff','Anggraeni Wisono','YES'),(3,3,'gina@gmail.com','975c4e8cdcfc373f98827db6e8d04a7c1803828a','gina@gmail.com','YES');

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `user_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_type` varchar(250) NOT NULL DEFAULT '',
  `user_group_desc` text,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `user_group` */

insert  into `user_group`(`user_group_id`,`user_group_type`,`user_group_desc`) values (1,'DEVELOPER','Grant All Access For Developer, Cause Responsible To Create New Feature'),(2,'SUPERADMIN','Grant Almost All Access, Except Create New Menu/Feature'),(3,'ADMIN','Grant Customize Feature');

/* Trigger structure for table `jurnal` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_delete_jurnal` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_delete_jurnal` AFTER DELETE ON `jurnal` FOR EACH ROW BEGIN
	DELETE FROM `jurnal_detail` WHERE `transaction_id` = OLD.transaction_id;
 END */$$


DELIMITER ;

/* Trigger structure for table `menu` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_insert_menu` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_insert_menu` AFTER INSERT ON `menu` FOR EACH ROW BEGIN
	CALL sp_fix_privilege_per_menu(NEW.menu_id, NEW.menu_action);
    END */$$


DELIMITER ;

/* Trigger structure for table `menu` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_update_menu` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_update_menu` AFTER UPDATE ON `menu` FOR EACH ROW BEGIN
	UPDATE `privilege` SET `privilege_action` = NEW.menu_action WHERE (`user_group_id` = 1 AND `menu_id` = NEW.menu_id) OR (`user_group_id` = 2  AND `menu_id` = NEW.menu_id AND NEW.menu_segment <> 'menu');
    END */$$


DELIMITER ;

/* Trigger structure for table `menu` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_delete_menu` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_delete_menu` AFTER DELETE ON `menu` FOR EACH ROW BEGIN
	DELETE FROM `privilege` WHERE `menu_id` = OLD.menu_id; #Fix Privilege
	#UPDATE `menu` set menu_parent_id = OLD.menu_parent_id WHERE menu_parent_id = OLD.menu_id; #Fix Menu must exectude in server side
    END */$$


DELIMITER ;

/* Trigger structure for table `user_group` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_insert_user_group` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_insert_user_group` AFTER INSERT ON `user_group` FOR EACH ROW BEGIN
	CALL sp_fix_privilege_per_user_group(NEW.user_group_id, NEW.user_group_type);
    END */$$


DELIMITER ;

/* Trigger structure for table `user_group` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trigger_by_delete_user_group` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trigger_by_delete_user_group` AFTER DELETE ON `user_group` FOR EACH ROW BEGIN
	DELETE FROM `privilege` WHERE `user_group_id` = OLD.user_group_id;
    END */$$


DELIMITER ;

/* Procedure structure for procedure `sp_fix_privilege` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_fix_privilege` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege`()
BLOCK1: BEGIN
    DECLARE done1 INT DEFAULT FALSE;
    DECLARE _menu_id INT;
    declare    _menu_segment, _menu_action TEXT;
    DECLARE cur1 CURSOR FOR SELECT `menu_id`, `menu_segment`, `menu_action` FROM `menu`;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;
    OPEN cur1;
    read_loop1: LOOP
        FETCH cur1 INTO _menu_id, _menu_segment, _menu_action;
        IF done1 THEN    
            CLOSE cur1;
            LEAVE read_loop1;
        END IF;
        BLOCK2: BEGIN
            DECLARE done2 INT DEFAULT FALSE;
            DECLARE _user_group_id, _count_menu INT;
            DECLARE _user_group_type TEXT;
            DECLARE cur2 CURSOR FOR SELECT `user_group_id`, `user_group_type` FROM `user_group`;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2 = TRUE;
            OPEN cur2;
            read_loop2: LOOP
                FETCH cur2 INTO _user_group_id, _user_group_type;
                IF done2 THEN    
                    CLOSE cur2;
                    LEAVE read_loop2;
                END IF;
                SET _count_menu = (SELECT COUNT(1) AS `count` FROM `privilege` WHERE `menu_id` = _menu_id AND `user_group_id` = _user_group_id);
                IF (_count_menu = 0 AND _user_group_type = 'DEVELOPER') OR (_count_menu = 0 AND _user_group_type = 'SUPERADMIN' AND _menu_segment <> 'menu') THEN
                    INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, _menu_action);
                ELSEIF (_count_menu <> 0 AND _user_group_type = 'DEVELOPER') OR (_count_menu <> 0 AND _user_group_type = 'SUPERADMIN' AND _menu_segment <> 'menu') THEN
                    UPDATE `privilege` SET `menu_id` = _menu_id, `user_group_id` = _user_group_id, `privilege_action` = _menu_action WHERE `menu_id` = _menu_id AND `user_group_id` = _user_group_id;
                ELSEIF (_count_menu <> 0 AND _menu_segment = 'menu') THEN
                	UPDATE `privilege` SET `menu_id` = _menu_id, `user_group_id` = _user_group_id, `privilege_action` = '' WHERE `menu_id` = _menu_id AND `user_group_id` = _user_group_id;
                ELSEIF _count_menu = 0 THEN
                    INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, '');
                END IF;
            END LOOP read_loop2;
        END BLOCK2;
    END LOOP read_loop1;
    END BLOCK1 */$$
DELIMITER ;

/* Procedure structure for procedure `sp_fix_privilege_per_menu` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_fix_privilege_per_menu` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege_per_menu`(_menu_id INT, _menu_action TEXT)
BLOCK1: BEGIN
    DECLARE done1 INT DEFAULT FALSE;
    DECLARE _user_group_id, _count_menu INT;
    declare    _user_group_type TEXT;
    DECLARE cur1 CURSOR FOR SELECT `user_group_id`, `user_group_type` FROM `user_group`;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;
    OPEN cur1;
    read_loop1: LOOP
        FETCH cur1 INTO _user_group_id, _user_group_type;
        IF done1 THEN    
            CLOSE cur1;
            LEAVE read_loop1;
        END IF;
        SET _count_menu = (SELECT COUNT(1) AS `count` FROM `privilege` WHERE `menu_id` = _menu_id AND `user_group_id` = _user_group_id);
        IF _count_menu = 0 AND (_user_group_type = 'DEVELOPER' OR _user_group_type = 'SUPERADMIN') then
            INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, _menu_action);
        elseif _count_menu = 0 THEN
            INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, '');        
        end if;
    END LOOP read_loop1;
    END BLOCK1 */$$
DELIMITER ;

/* Procedure structure for procedure `sp_fix_privilege_per_user_group` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_fix_privilege_per_user_group` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege_per_user_group`(_user_group_id INT, _user_group_type TEXT)
BLOCK1: BEGIN
    DECLARE done1 INT DEFAULT FALSE;
    DECLARE _menu_id, _count_menu INT;
    declare    _menu_segment, _menu_action TEXT;
    DECLARE cur1 CURSOR FOR SELECT `menu_id`, `menu_segment`, `menu_action` FROM `menu`;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;
    OPEN cur1;
    read_loop1: LOOP
        FETCH cur1 INTO _menu_id, _menu_segment, _menu_action;
        IF done1 THEN    
            CLOSE cur1;
            LEAVE read_loop1;
        END IF;
        SET _count_menu = (SELECT COUNT(1) AS `count` FROM `privilege` WHERE `menu_id` = _menu_id AND `user_group_id` = _user_group_id);
        IF _count_menu = 0 AND (_user_group_type = 'DEVELOPER' OR _user_group_type = 'SUPERADMIN') THEN
            INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, _menu_action);
        elseif  _count_menu = 0 then
            INSERT INTO `privilege` (`menu_id`, `user_group_id`, `privilege_action`) VALUES (_menu_id, _user_group_id, '');        
        end if;
    END LOOP read_loop1;
    END BLOCK1 */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
