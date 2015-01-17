-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: simpled
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('58f2a3149f542c0e571b157645d7a58c','192.168.33.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36',1421371912,'a:3:{s:9:\"user_data\";s:0:\"\";s:4:\"user\";O:8:\"stdClass\":8:{s:7:\"user_id\";s:1:\"1\";s:13:\"user_group_id\";s:1:\"1\";s:10:\"user_email\";s:17:\"if07087@gmail.com\";s:13:\"user_password\";s:40:\"b39b2b3dc81ed59a16c531c44b5160da92fccd72\";s:13:\"user_fullname\";s:20:\"Harry Osmar Sitohang\";s:11:\"user_active\";s:3:\"YES\";s:15:\"user_group_type\";s:9:\"DEVELOPER\";s:15:\"user_group_desc\";s:71:\"Grant All Access For Developer, Cause Responsible To Create New Feature\";}s:9:\"subnavbar\";s:1455:\"<li class=\"dropdown parentmenu\"><a data-menu-segment=\"\" href=\"javascript:;\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-th\"></i><span>Chart Of Account</span><b class=\"caret\"></b></a><ul class=\"dropdown-menu\"><li><a data-menu-segment=\"coa\" href=\"http://simpled.me/baseadmin/coa\">List COA</a></li><li><a data-menu-segment=\"coa_type\" href=\"http://simpled.me/baseadmin/coa_type\">COA Type</a></li><li><a data-menu-segment=\"currency\" href=\"http://simpled.me/baseadmin/currency\">Currency</a></li></ul></li><li class=\"dropdown parentmenu\"><a data-menu-segment=\"\" href=\"javascript:;\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-th\"></i><span>Access</span><b class=\"caret\"></b></a><ul class=\"dropdown-menu\"><li><a data-menu-segment=\"user\" href=\"http://simpled.me/baseadmin/user\">User</a></li><li><a data-menu-segment=\"user_group\" href=\"http://simpled.me/baseadmin/user_group\">User Group</a></li><li><a data-menu-segment=\"menu\" href=\"http://simpled.me/baseadmin/menu\">Menu</a></li><li><a data-menu-segment=\"privilege\" href=\"http://simpled.me/baseadmin/privilege\">Privilege</a></li></ul></li><li class=\"dropdown parentmenu\"><a data-menu-segment=\"\" href=\"javascript:;\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-th\"></i><span>Accounting</span><b class=\"caret\"></b></a><ul class=\"dropdown-menu\"><li><a data-menu-segment=\"jurnal_entry\" href=\"http://simpled.me/baseadmin/jurnal_entry\">Jurnal Entry</a></li></ul></li>\";}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coa`
--

DROP TABLE IF EXISTS `coa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coa` (
  `coa_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coa_number` varchar(25) NOT NULL DEFAULT '',
  `coa_type_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL DEFAULT '1',
  `description` varchar(100) NOT NULL DEFAULT '',
  `crdr` enum('CR','DR') NOT NULL DEFAULT 'CR',
  `coa_status` enum('ACTIVE','NOT ACTIVE') NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`coa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coa`
--

LOCK TABLES `coa` WRITE;
/*!40000 ALTER TABLE `coa` DISABLE KEYS */;
INSERT INTO `coa` VALUES (1,'1-110',1,1,'CASH','DR','ACTIVE'),(2,'1-120',1,1,'BANK MANDIRI','DR','ACTIVE'),(3,'1-121',1,1,'BANK BII IDR','DR','ACTIVE'),(4,'1-122',1,3,'BANK BII','DR','ACTIVE'),(6,'1-200',1,1,'ACCOUNT RECEIVABLE','DR','ACTIVE'),(7,'1-210',1,1,'EMPLOYEE RECEIVABLE ','DR','ACTIVE'),(8,'1-220',1,1,'PROVISION FOR DOUBTFUL','DR','ACTIVE'),(9,'1-300',1,1,'INVENTORY','DR','ACTIVE'),(10,'1-400',1,1,'PREPAID RENT','DR','ACTIVE'),(12,'1-500',1,1,'EQUIPMENT','DR','ACTIVE'),(13,'2-100',1,1,'ACCOUNT PAYABLE','CR','ACTIVE'),(14,'2-200',1,1,'SALARY PAYABLE','CR','ACTIVE'),(15,'2-300',2,1,'TAX PAYABLE','CR','ACTIVE'),(16,'2-400',2,1,'EXPENSES PAYABLE','CR','ACTIVE'),(17,'2-500',2,1,'OTHERS PAYABLE','CR','ACTIVE'),(18,'2-600',2,1,'THIRD PARTIES PAYABLE','CR','ACTIVE'),(19,'2-700',2,1,'LONG TERM PAYABLE','CR','ACTIVE'),(20,'3-100',3,1,'SHAREHOLDERS','CR','ACTIVE'),(21,'3-200',3,1,'PRIVE','CR','ACTIVE'),(22,'3-800',3,1,'RETAINED EARNING','CR','ACTIVE'),(23,'3-900',3,1,'RETAINED EARNING CURRENT YEAR','CR','ACTIVE'),(24,'4-100',4,1,'REVENUE','CR','ACTIVE'),(25,'4-600',4,1,'INTEREST INCOME','CR','ACTIVE'),(26,'4-700',4,1,'FOREIGN EXCHANGE RATE','CR','ACTIVE'),(27,'4-800',4,1,'OTHER REVENUE','CR','ACTIVE'),(28,'4-900',4,1,'MISCELLANEOUS INCOME','CR','ACTIVE'),(29,'5-000',5,1,'SALARIES','DR','ACTIVE'),(30,'5-001',5,1,'THR & THN','DR','ACTIVE'),(31,'5-002',5,1,'OVERTIME','DR','ACTIVE'),(32,'5-003',5,1,'LABOUR INSURANCE (JAMSOSTEK)','DR','ACTIVE'),(33,'5-004',5,1,'HEALTH INSURANCE (BPJS)','DR','ACTIVE'),(34,'5-005',5,1,'TERMINATION','DR','ACTIVE'),(35,'5-006',5,1,'STAFF WELFARE','DR','ACTIVE'),(36,'5-007',5,1,'MEDICAL CHECK UP','DR','ACTIVE'),(37,'5-008',5,1,'RECRUITMENT EXPENSE','DR','ACTIVE'),(38,'5-009',5,1,'UNIFORM','DR','ACTIVE'),(39,'5-010',5,1,'SAFETY & EQUIPMENT','DR','ACTIVE'),(40,'5-011',5,1,'SALARIES - GM & CORPORATE','DR','ACTIVE'),(41,'5-100',5,1,'LEGAL & NOTARIAL FEE','DR','ACTIVE'),(42,'5-200',5,1,'INSURANCE EXPENSES','DR','ACTIVE'),(43,'5-300',5,1,'PRINTING & STATIONARY','DR','ACTIVE'),(44,'5-301',5,1,'FOTOCOPY','DR','ACTIVE'),(45,'5-302',5,1,'OFFICE SUPPLIES','DR','ACTIVE'),(46,'5-303',5,1,'POSTAGE MAIL & COURIER','DR','ACTIVE'),(47,'5-400',5,1,'GOVERNMENT DUES & FEES','DR','ACTIVE'),(48,'5-401',5,1,'TAX EXPENSE','DR','ACTIVE'),(49,'5-500',5,1,'TRANSPORTATION & GASOLINE','DR','ACTIVE'),(50,'5-600',5,1,'TELEPHOHE & FACSIMILE','DR','ACTIVE'),(51,'5-601',5,1,'SPEEDY','DR','ACTIVE'),(52,'5-700',5,1,'ENTERTAINMENT','DR','ACTIVE'),(53,'5-800',5,1,'OFFICE RENT EXPENSES','DR','ACTIVE'),(54,'5-801',5,1,'GENERAL OFFICE','DR','ACTIVE'),(55,'5-802',5,1,'OFFICE MISC EXPENSES','DR','ACTIVE'),(56,'5-803',5,1,'WATER EXPENSES','DR','ACTIVE'),(57,'5-804',5,1,'ELECTRICITY EXPENSES','DR','ACTIVE'),(58,'5-900',5,1,'BANK CHARGE','DR','ACTIVE'),(59,'6-000',5,1,'DEPRECIATION OFFICE EQUIPMENT','DR','ACTIVE');
/*!40000 ALTER TABLE `coa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coa_type`
--

DROP TABLE IF EXISTS `coa_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coa_type` (
  `coa_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coa_type_name` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`coa_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coa_type`
--

LOCK TABLES `coa_type` WRITE;
/*!40000 ALTER TABLE `coa_type` DISABLE KEYS */;
INSERT INTO `coa_type` VALUES (1,'ASSET'),(2,'PAYABLE'),(3,'STOCKHOLDER/EQUITY'),(4,'REVENUE'),(5,'EXPENSES');
/*!40000 ALTER TABLE `coa_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `currency_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `currency_label` varchar(25) NOT NULL DEFAULT '',
  `currency_rate` double NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'IDR',1),(2,'USD',12000),(3,'SGD',9500);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurnal`
--

DROP TABLE IF EXISTS `jurnal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jurnal` (
  `transaction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `ref_number` varchar(50) NOT NULL DEFAULT '',
  `remarks` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `transaction_status` enum('VOID','VALID') NOT NULL DEFAULT 'VALID',
  `input_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurnal`
--

LOCK TABLES `jurnal` WRITE;
/*!40000 ALTER TABLE `jurnal` DISABLE KEYS */;
INSERT INTO `jurnal` VALUES (6,'2015-01-15','PEV-001','baiya',1,'VALID','2015-01-15 16:15:09'),(7,'2015-01-15','test','test',1,'VALID','2015-01-15 16:17:43');
/*!40000 ALTER TABLE `jurnal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurnal_detail`
--

DROP TABLE IF EXISTS `jurnal_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jurnal_detail` (
  `transaction_detail_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `coa_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `crdr` enum('CR','DR') NOT NULL DEFAULT 'CR',
  `current_currency_rate` double NOT NULL,
  PRIMARY KEY (`transaction_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurnal_detail`
--

LOCK TABLES `jurnal_detail` WRITE;
/*!40000 ALTER TABLE `jurnal_detail` DISABLE KEYS */;
INSERT INTO `jurnal_detail` VALUES (29,6,1,10000,'DR',1),(30,6,1,10000,'DR',1),(31,6,1,10000,'CR',1),(32,6,2,10000,'CR',1),(33,7,1,500000,'DR',1),(34,7,4,100,'DR',9500),(35,7,1,250000,'CR',1),(36,7,4,100,'CR',9500),(37,7,7,250000,'CR',1);
/*!40000 ALTER TABLE `jurnal_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) NOT NULL DEFAULT '0',
  `menu_segment` varchar(250) NOT NULL DEFAULT '',
  `menu_name` varchar(250) NOT NULL DEFAULT '',
  `menu_desc` text,
  `menu_active` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `menu_link` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `menu_action` varchar(500) NOT NULL DEFAULT '''view,edit,add,delete''',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,0,'','Chart Of Account','Chart Of Account','YES','NO','view'),(2,1,'coa','List COA','List Chart Of Account','YES','YES','view,edit,add,delete'),(3,1,'coa_type','COA Type','Chart Of Account Type','YES','YES','edit,add,delete,view'),(4,0,'','Access','Customize User Access','YES','NO','view'),(5,4,'user','User','List User, Change Password','YES','YES','view,edit,add,delete'),(6,4,'user_group','User Group','List User Group','YES','YES','view,edit,add,delete'),(7,4,'menu','Menu','List Menu','YES','YES','view,edit,add,delete'),(8,4,'privilege','Privilege','Access Privilege','YES','YES','view,edit,add,delete'),(9,1,'currency','Currency','Currency','YES','YES','view,edit,add,delete'),(10,0,'','Accounting','Accounting','YES','NO','view,edit,add,delete'),(11,10,'jurnal_entry','Jurnal Entry','.','YES','YES','view,edit,add,delete');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `trigger_by_insert_menu` AFTER INSERT ON `menu` 
    FOR EACH ROW BEGIN
	CALL sp_fix_privilege_per_menu(NEW.menu_id, NEW.menu_action);
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `trigger_by_update_menu` AFTER UPDATE ON `menu` 
    FOR EACH ROW BEGIN
	UPDATE `privilege` SET `privilege_action` = NEW.menu_action WHERE (`user_group_id` = 1 AND `menu_id` = NEW.menu_id) OR (`user_group_id` = 2  AND `menu_id` = NEW.menu_id AND NEW.menu_segment <> 'menu');
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `trigger_by_delete_menu` AFTER DELETE ON `menu` 
    FOR EACH ROW BEGIN
	DELETE FROM `privilege` WHERE `menu_id` = OLD.menu_id; #Fix Privilege
	#UPDATE `menu` set menu_parent_id = OLD.menu_parent_id WHERE menu_parent_id = OLD.menu_id; #Fix Menu must exectude in server side
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privilege` (
  `privilege_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `privilege_action` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`privilege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilege`
--

LOCK TABLES `privilege` WRITE;
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;
INSERT INTO `privilege` VALUES (1,1,1,'view'),(2,1,2,'view'),(3,1,3,'view'),(4,2,1,'view,edit,add,delete'),(5,2,2,'view,edit,add,delete'),(6,2,3,'view'),(7,3,1,'edit,add,delete,view'),(8,3,2,'edit,add,delete,view'),(9,3,3,'view'),(10,4,1,'view'),(11,4,2,'view'),(12,4,3,''),(13,5,1,'view,edit,add,delete'),(14,5,2,'view,edit,add,delete'),(15,5,3,''),(16,6,1,'view,edit,add,delete'),(17,6,2,'view,edit,add,delete'),(18,6,3,''),(19,7,1,'view,edit,add,delete'),(20,7,2,''),(21,7,3,''),(22,8,1,'view,edit,add,delete'),(23,8,2,'view,edit,add,delete'),(24,8,3,''),(25,9,1,'view,edit,add,delete'),(26,9,2,'view,edit,add,delete'),(27,9,3,''),(28,10,1,'view,edit,add,delete'),(29,10,2,'view,edit,add,delete'),(30,10,3,''),(31,11,1,'view,edit,add,delete'),(32,11,2,'view,edit,add,delete'),(33,11,3,'');
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `user_email` varchar(500) NOT NULL DEFAULT '',
  `user_password` varchar(500) NOT NULL DEFAULT '',
  `user_fullname` varchar(250) NOT NULL DEFAULT '',
  `user_active` enum('YES','NO') NOT NULL DEFAULT 'YES',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1,'if07087@gmail.com','b39b2b3dc81ed59a16c531c44b5160da92fccd72','Harry Osmar Sitohang','YES'),(2,2,'angraenz@gmail.com','03b409cb14fb2ed6c68f9723226f5339295c07ff','Anggraeni Wisono','YES');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `user_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_type` varchar(250) NOT NULL DEFAULT '',
  `user_group_desc` text,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'DEVELOPER','Grant All Access For Developer, Cause Responsible To Create New Feature'),(2,'SUPERADMIN','Grant Almost All Access, Except Create New Menu/Feature'),(3,'ADMIN','Grant Customize Feature');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `trigger_by_insert_user_group` AFTER INSERT ON `user_group` 
    FOR EACH ROW BEGIN
	CALL sp_fix_privilege_per_user_group(NEW.user_group_id, NEW.user_group_type);
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `trigger_by_delete_user_group` AFTER DELETE ON `user_group` 
    FOR EACH ROW BEGIN
	DELETE FROM `privilege` WHERE `user_group_id` = OLD.user_group_id;
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping routines for database 'simpled'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_fix_privilege` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege`()
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
    END BLOCK1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_fix_privilege_per_menu` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege_per_menu`(_menu_id INT, _menu_action TEXT)
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
    END BLOCK1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_fix_privilege_per_user_group` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_fix_privilege_per_user_group`(_user_group_id INT, _user_group_type TEXT)
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
    END BLOCK1 ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-17  3:12:47
