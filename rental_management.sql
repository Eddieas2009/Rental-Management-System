/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.28 : Database - rental_management
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rental_management` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `rental_management`;

/*Table structure for table `condo_transactions` */

DROP TABLE IF EXISTS `condo_transactions`;

CREATE TABLE `condo_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` decimal(18,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `description` text,
  `condoID` int NOT NULL,
  `userID` int NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `condo_transactions` */

insert  into `condo_transactions`(`id`,`amount`,`paymentDate`,`description`,`condoID`,`userID`,`datecreated`) values (1,50000.00,'2025-06-14','Solid',1,1,'2025-06-14 12:44:21'),(2,21000.00,'2025-06-14','Added 21000 dollars',1,1,'2025-06-14 13:59:06'),(3,100000.00,'2025-06-14','paid 100k dollars',1,1,'2025-06-14 14:20:30');

/*Table structure for table `condos` */

DROP TABLE IF EXISTS `condos`;

CREATE TABLE `condos` (
  `condoID` int NOT NULL AUTO_INCREMENT,
  `cleintnames` varchar(150) NOT NULL,
  `phoneNo` varchar(30) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sellAmount` decimal(18,2) NOT NULL,
  `totalpaid` decimal(18,2) NOT NULL,
  `startDate` date NOT NULL,
  `datecreated` date NOT NULL,
  `unitID` int NOT NULL,
  `propertyID` int NOT NULL,
  `userID` int NOT NULL,
  PRIMARY KEY (`condoID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `condos` */

insert  into `condos`(`condoID`,`cleintnames`,`phoneNo`,`email`,`sellAmount`,`totalpaid`,`startDate`,`datecreated`,`unitID`,`propertyID`,`userID`) values (1,'Simin Peter','0782791343','speter@gmail.com',250000.00,171000.00,'2025-06-14','2025-06-14',3,2,1);

/*Table structure for table `expense_categories` */

DROP TABLE IF EXISTS `expense_categories`;

CREATE TABLE `expense_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `catname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `catname` (`catname`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `expense_categories` */

insert  into `expense_categories`(`id`,`catname`) values (3,'Electricity costs'),(2,'Kitchen Repairs'),(1,'operating expense'),(5,'Windlow glass fixing');

/*Table structure for table `expense_subcategories` */

DROP TABLE IF EXISTS `expense_subcategories`;

CREATE TABLE `expense_subcategories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `expense_subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `expense_subcategories` */

insert  into `expense_subcategories`(`id`,`category_id`,`name`,`description`,`created_at`) values (1,1,'Transport','To see the tenants complaint','2025-04-19 02:09:45');

/*Table structure for table `expenses` */

DROP TABLE IF EXISTS `expenses`;

CREATE TABLE `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text,
  `expense_date` date NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_by` int DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `expenses` */

insert  into `expenses`(`id`,`category_id`,`amount`,`description`,`expense_date`,`payment_method`,`created_by`,`datecreated`,`updated_by`,`date_updated`) values (1,1,2000.00,'Transport to apartment 1','2025-04-18','Bank Transfer',NULL,NULL,1,'2025-05-31 02:05:16'),(2,2,50000.00,'Fixed broken sink','2025-05-31','Cash',1,'2025-05-31 01:05:29',1,'2025-05-31 01:05:03'),(3,5,100000.00,'Office glass window was fixed','2025-05-30','Mobile Money',1,'2025-05-31 01:05:23',NULL,NULL),(4,5,393000.00,'gdfjh gjhkjhyljk','2025-05-29','Card',1,'2025-05-31 02:05:01',NULL,NULL),(5,1,10000.00,'Transport to buy raw materials','2025-05-22','Cash',1,'2025-05-31 02:05:02',NULL,NULL);

/*Table structure for table `maint_category` */

DROP TABLE IF EXISTS `maint_category`;

CREATE TABLE `maint_category` (
  `catID` int NOT NULL AUTO_INCREMENT,
  `catName` varchar(50) NOT NULL,
  PRIMARY KEY (`catID`),
  UNIQUE KEY `catName` (`catName`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `maint_category` */

insert  into `maint_category`(`catID`,`catName`) values (6,'Bathrooms'),(5,'Doors'),(1,'Electricity.'),(7,'Kitchen'),(2,'Transport'),(3,'Walls repairs and paint'),(4,'Windows');

/*Table structure for table `maint_subcategory` */

DROP TABLE IF EXISTS `maint_subcategory`;

CREATE TABLE `maint_subcategory` (
  `subcatID` int NOT NULL AUTO_INCREMENT,
  `subcatName` varchar(100) NOT NULL,
  `catID` int NOT NULL,
  PRIMARY KEY (`subcatID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `maint_subcategory` */

insert  into `maint_subcategory`(`subcatID`,`subcatName`,`catID`) values (1,'Faulty showers',6),(2,'Kitchen lampholder',1),(3,'Transport to visit tenant',2),(4,'Tansport to buy materials',2),(5,'Broken Doors',5);

/*Table structure for table `maintenance_requests` */

DROP TABLE IF EXISTS `maintenance_requests`;

CREATE TABLE `maintenance_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int DEFAULT NULL,
  `tenant_id` int DEFAULT NULL,
  `unitID` int NOT NULL,
  `description` text NOT NULL,
  `status` enum('Pending','In Progress','Completed','Resolved','Cancelled','Query') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Pending',
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `replynotice` text,
  `userID` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `maintenanceCatID` int DEFAULT NULL,
  `mainSubcatID` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`),
  KEY `tenant_id` (`tenant_id`),
  CONSTRAINT `maintenance_requests_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`propertyID`) ON DELETE SET NULL,
  CONSTRAINT `maintenance_requests_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`tenantID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `maintenance_requests` */

insert  into `maintenance_requests`(`id`,`property_id`,`tenant_id`,`unitID`,`description`,`status`,`priority`,`created_at`,`replynotice`,`userID`,`updated_at`,`maintenanceCatID`,`mainSubcatID`) values (1,1,2,2,'Naked wires','In Progress','High','2025-05-18 13:23:13','working on i',5,'2025-05-29 07:05:47',1,2),(2,2,1,3,'Come and repair our birthrooms','Cancelled','Medium','2025-05-18 13:25:23','cancelled',1,'2025-05-18 01:05:55',6,1);

/*Table structure for table `partial_payments` */

DROP TABLE IF EXISTS `partial_payments`;

CREATE TABLE `partial_payments` (
  `partialID` int NOT NULL AUTO_INCREMENT,
  `amount` decimal(18,2) NOT NULL,
  `datereceived` date NOT NULL,
  `paymentID` int NOT NULL,
  `paymentmode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`partialID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `partial_payments` */

insert  into `partial_payments`(`partialID`,`amount`,`datereceived`,`paymentID`,`paymentmode`) values (1,120000.00,'2025-06-12',3,'Cheque'),(2,120000.00,'2025-06-12',3,'Cash'),(3,90000.00,'2025-06-10',3,'Bank Transfer'),(4,100000.00,'2025-06-11',3,'Bank Transfer'),(5,4500.00,'2025-06-12',5,'Bank Transfer'),(6,180000.00,'2025-06-12',5,'Cash'),(7,5000.00,'2025-06-12',3,'Bank Transfer'),(8,20000.00,'2025-06-13',11,'Bank Transfer'),(9,20000.00,'2025-06-13',11,'Cash'),(10,50000.00,'2025-06-13',11,'Cheque'),(11,30000.00,'2025-06-13',11,'Cash'),(12,1080000.00,'2025-06-13',11,'Cash'),(13,2000.00,'2025-06-13',3,'Cash'),(14,4000.00,'2025-06-13',3,'Bank Transfer'),(15,4000.00,'2025-06-13',2,'Bank Transfer'),(16,50000.00,'2025-06-13',9,'Cash');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `month` smallint NOT NULL,
  `year` year NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` enum('Cash','Bank Transfer','Check','Online') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('Paid','Pending','Late','Partial') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `unitID` int DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `emailsent` smallint DEFAULT NULL,
  `datesent` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`tenantID`) ON DELETE SET NULL,
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`propertyID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `payments` */

insert  into `payments`(`id`,`tenant_id`,`property_id`,`amount`,`month`,`year`,`payment_date`,`payment_method`,`status`,`created_at`,`unitID`,`userID`,`emailsent`,`datesent`) values (1,1,2,2000000.00,3,2025,'2025-05-01','Cash','Paid','2025-05-14 22:25:17',3,1,NULL,NULL),(2,1,2,2000000.00,4,2025,'2025-06-13','Bank Transfer','Paid','2025-05-14 22:25:17',3,1,NULL,NULL),(3,2,1,1000000.00,2,2025,'2025-06-13',NULL,'Partial','2025-05-14 22:25:17',2,1,NULL,NULL),(4,2,1,1000000.00,3,2025,'2025-04-19','Cash','Late','2025-05-14 22:25:17',2,1,NULL,NULL),(5,2,1,1000000.00,4,2025,NULL,NULL,'Pending','2025-05-14 22:25:17',2,NULL,NULL,NULL),(6,3,2,4000000.00,5,2025,NULL,NULL,'Pending','2025-05-14 22:25:17',4,NULL,NULL,NULL),(7,4,1,1200000.00,5,2025,'2025-05-13','Cash','Paid','2025-05-14 22:25:17',1,1,NULL,NULL),(8,1,2,2000000.00,5,2025,'2025-05-18','Cash','Late','2025-05-18 10:36:58',3,1,NULL,NULL),(9,2,1,1000000.00,5,2025,'2025-06-13','Cash','Paid','2025-05-26 07:37:07',2,1,NULL,NULL),(10,3,2,4000000.00,6,2025,NULL,NULL,'Pending','2025-06-09 13:45:48',4,NULL,NULL,NULL),(11,4,1,1200000.00,6,2025,'2025-06-13','Cash','Paid',NULL,1,1,NULL,NULL),(12,1,2,2000000.00,8,2025,'2025-06-10','Cash','Paid','2025-06-10 13:51:18',3,1,NULL,NULL);

/*Table structure for table `properties` */

DROP TABLE IF EXISTS `properties`;

CREATE TABLE `properties` (
  `propertyID` int NOT NULL AUTO_INCREMENT,
  `propName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `type` enum('Apartment','House','Commercial') NOT NULL,
  `status` enum('Available','Rented','Maintenance') DEFAULT 'Available',
  `description` text,
  `createdBy` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updatedBy` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`propertyID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `properties` */

insert  into `properties`(`propertyID`,`propName`,`location`,`type`,`status`,`description`,`createdBy`,`created_at`,`updatedBy`,`updated_at`) values (1,'Apartment1','Mbarara','Apartment','Available','2 bedrooms and one sitting room and kitchen',NULL,'2025-04-19 01:18:03',1,'2025-05-14 05:05:17'),(2,'apartment2','Entebbe','Apartment','Available','3 bedrooms, Kitcken and sitting room',1,'2025-04-28 00:00:00',1,'2025-04-28 09:04:38');

/*Table structure for table `tenants` */

DROP TABLE IF EXISTS `tenants`;

CREATE TABLE `tenants` (
  `tenantID` int NOT NULL AUTO_INCREMENT,
  `propertyID` int DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `move_in_date` date DEFAULT NULL,
  `move_out_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unitID` int DEFAULT NULL,
  PRIMARY KEY (`tenantID`),
  UNIQUE KEY `email` (`email`),
  KEY `property_id` (`propertyID`),
  CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`propertyID`) REFERENCES `properties` (`propertyID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tenants` */

insert  into `tenants`(`tenantID`,`propertyID`,`first_name`,`last_name`,`email`,`phone`,`move_in_date`,`move_out_date`,`status`,`created_at`,`created_by`,`updated_at`,`unitID`) values (1,2,'Asiimwe','Edson','eddieas2012@gmail.com','0782791343','2025-03-18',NULL,'Active','2025-04-19 01:19:16',NULL,'2025-05-15 09:05:17',3),(2,1,'Daniel','Jonathan','biz.eddie2024@gmail.com','0782771323','2025-02-24',NULL,'Active','2025-04-19 01:31:30',NULL,'2025-05-31 05:05:06',2),(3,2,'Daniel','Kaheru','eddieas2025@gmail.com','0773525079','2025-05-07',NULL,'Active','2025-05-07 08:05:21',1,'2025-05-31 05:05:00',4),(4,1,'Ampurira','Patricia','ampurira@gmail.com','0789402719','2025-05-07',NULL,'Active','2025-05-07 09:05:50',1,'2025-05-30 08:05:34',1);

/*Table structure for table `units` */

DROP TABLE IF EXISTS `units`;

CREATE TABLE `units` (
  `unitID` int NOT NULL AUTO_INCREMENT,
  `unitname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bathrooms` smallint NOT NULL,
  `bedrooms` smallint NOT NULL,
  `rentamount` decimal(10,0) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `unitstatus` enum('available','maintenance','rented','sold') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  `propertyID` int NOT NULL,
  PRIMARY KEY (`unitID`),
  UNIQUE KEY `unitNo` (`unitname`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `units` */

insert  into `units`(`unitID`,`unitname`,`bathrooms`,`bedrooms`,`rentamount`,`description`,`unitstatus`,`propertyID`) values (1,'1ST FLOOR 01',3,2,1200000,'Sitting Room, Dinning, Kitchen and 2 bedrooms','rented',1),(2,'1ST FLOOR 02',2,2,1000000,'@ sitting rooms and kitchen','rented',1),(3,'1ST FLR 01',3,3,2000000,'Sitting room and Kitchen','sold',2),(4,'1ST FLR 02',4,5,4000000,'good','rented',2);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','sa','user','tenant') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastloginDate` datetime DEFAULT NULL,
  `acc_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `canview` tinyint NOT NULL DEFAULT '0',
  `canedit` tinyint NOT NULL DEFAULT '0',
  `cancreate` tinyint NOT NULL DEFAULT '0',
  `canaprove` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `users` */

insert  into `users`(`userID`,`names`,`username`,`password`,`role`,`lastloginDate`,`acc_status`,`canview`,`canedit`,`cancreate`,`canaprove`) values (1,'Peter','admin','$2y$12$HOg6DTBXgKW2KXQ973zuU.frVvWlK3.nD24vKCnQ6iiNrSTE46/hC','admin',NULL,'active',1,1,1,1),(2,'Edson Asiimwe','user','$2y$12$HOg6DTBXgKW2KXQ973zuU.frVvWlK3.nD24vKCnQ6iiNrSTE46/hC','user',NULL,'active',1,1,1,0),(3,'Edson Asiimwe','userdd','$2y$12$8YGb1ZKZY22dj6okN8713.dAfvQSCL0DBSszP0Gm492wpCeG.yqUG','user',NULL,'active',0,1,0,1),(4,'Edson','eddie','$2y$12$G3Z7Bbbdr0Df7/s2CMF3bOFFjafjuYnPZGev294hJ09QXELJcG/q.','user',NULL,'inactive',1,1,1,1),(5,'Edson','eddieas','$2y$12$mnlyKv4xGN9Fdo1DaUI5QuWl7LdkYSPcwPZRSTdtX9SszYeFyjjcO','tenant',NULL,'active',1,1,1,1);

/* Procedure structure for procedure `sp_get_due_rent_payments` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_get_due_rent_payments` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_due_rent_payments`()
BEGIN
    SELECT 
        t.tenantID,
        t.propertyID,
        t.move_in_date,
        u.rentamount,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y-%m-%d') AS due_date,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%m') AS MONTH,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y') AS YEAR,
        u.unitID
    FROM tenantproperty t
    JOIN units u ON t.unitID = u.unitID
    CROSS JOIN (
        SELECT a.N + b.N * 10 AS number
        FROM 
            (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
             UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a,
            (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
             UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
    ) n
    WHERE t.status = 'Active'
    AND DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y-%m-%d') <= CURDATE()
    AND NOT EXISTS (
        SELECT 1 
        FROM payments p 
        WHERE p.tenant_id = t.tenantID
        AND p.month = DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%m')
        AND p.year = DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y')
    )
    ORDER BY t.tenantID, due_date;
END */$$
DELIMITER ;

/*Table structure for table `ms_subcategory` */

DROP TABLE IF EXISTS `ms_subcategory`;

/*!50001 DROP VIEW IF EXISTS `ms_subcategory` */;
/*!50001 DROP TABLE IF EXISTS `ms_subcategory` */;

/*!50001 CREATE TABLE  `ms_subcategory`(
 `subcatID` int ,
 `subcatName` varchar(100) ,
 `catID` int ,
 `catName` varchar(50) 
)*/;

/*Table structure for table `pendingrent` */

DROP TABLE IF EXISTS `pendingrent`;

/*!50001 DROP VIEW IF EXISTS `pendingrent` */;
/*!50001 DROP TABLE IF EXISTS `pendingrent` */;

/*!50001 CREATE TABLE  `pendingrent`(
 `email` varchar(100) ,
 `first_name` varchar(50) ,
 `last_name` varchar(50) ,
 `amount` decimal(10,2) ,
 `month` smallint ,
 `year` year ,
 `status` enum('Paid','Pending','Late','Partial') 
)*/;

/*Table structure for table `propertyunits` */

DROP TABLE IF EXISTS `propertyunits`;

/*!50001 DROP VIEW IF EXISTS `propertyunits` */;
/*!50001 DROP TABLE IF EXISTS `propertyunits` */;

/*!50001 CREATE TABLE  `propertyunits`(
 `propertyID` int ,
 `propName` varchar(100) ,
 `location` varchar(225) ,
 `type` enum('Apartment','House','Commercial') ,
 `status` enum('Available','Rented','Maintenance') ,
 `description` text ,
 `createdBy` int ,
 `created_at` datetime ,
 `updatedBy` int ,
 `updated_at` datetime ,
 `unitID` int ,
 `unitname` varchar(20) ,
 `bedrooms` smallint ,
 `bathrooms` smallint ,
 `rentamount` decimal(10,0) ,
 `unitdescription` text ,
 `unitstatus` enum('available','maintenance','rented','sold') 
)*/;

/*Table structure for table `rent_collection` */

DROP TABLE IF EXISTS `rent_collection`;

/*!50001 DROP VIEW IF EXISTS `rent_collection` */;
/*!50001 DROP TABLE IF EXISTS `rent_collection` */;

/*!50001 CREATE TABLE  `rent_collection`(
 `id` int ,
 `tenant_id` int ,
 `property_id` int ,
 `amount` decimal(10,2) ,
 `month` smallint ,
 `year` year ,
 `payment_date` date ,
 `payment_method` enum('Cash','Bank Transfer','Check','Online') ,
 `status` enum('Paid','Pending','Late','Partial') ,
 `created_at` timestamp ,
 `unitID` int ,
 `userID` int ,
 `emailsent` smallint ,
 `datesent` date ,
 `partial_pay` decimal(40,2) 
)*/;

/*Table structure for table `tenantproperty` */

DROP TABLE IF EXISTS `tenantproperty`;

/*!50001 DROP VIEW IF EXISTS `tenantproperty` */;
/*!50001 DROP TABLE IF EXISTS `tenantproperty` */;

/*!50001 CREATE TABLE  `tenantproperty`(
 `tenantID` int ,
 `propertyID` int ,
 `first_name` varchar(50) ,
 `last_name` varchar(50) ,
 `email` varchar(100) ,
 `phone` varchar(20) ,
 `move_in_date` date ,
 `move_out_date` date ,
 `status` enum('Active','Inactive') ,
 `created_at` timestamp ,
 `updated_at` timestamp ,
 `unitID` int ,
 `propName` varchar(100) ,
 `location` varchar(225) ,
 `type` enum('Apartment','House','Commercial') ,
 `propertystatus` enum('Available','Rented','Maintenance') ,
 `description` text 
)*/;

/*Table structure for table `total_partial_paid` */

DROP TABLE IF EXISTS `total_partial_paid`;

/*!50001 DROP VIEW IF EXISTS `total_partial_paid` */;
/*!50001 DROP TABLE IF EXISTS `total_partial_paid` */;

/*!50001 CREATE TABLE  `total_partial_paid`(
 `paymentID` int ,
 `partial_pay` decimal(40,2) 
)*/;

/*View structure for view ms_subcategory */

/*!50001 DROP TABLE IF EXISTS `ms_subcategory` */;
/*!50001 DROP VIEW IF EXISTS `ms_subcategory` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ms_subcategory` AS select `ms`.`subcatID` AS `subcatID`,`ms`.`subcatName` AS `subcatName`,`mc`.`catID` AS `catID`,`mc`.`catName` AS `catName` from (`maint_category` `mc` join `maint_subcategory` `ms` on((`mc`.`catID` = `ms`.`catID`))) */;

/*View structure for view pendingrent */

/*!50001 DROP TABLE IF EXISTS `pendingrent` */;
/*!50001 DROP VIEW IF EXISTS `pendingrent` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pendingrent` AS select distinct `t`.`email` AS `email`,`t`.`first_name` AS `first_name`,`t`.`last_name` AS `last_name`,`p`.`amount` AS `amount`,`p`.`month` AS `month`,`p`.`year` AS `year`,`p`.`status` AS `status` from (`payments` `p` join `tenants` `t` on((`p`.`tenant_id` = `t`.`tenantID`))) where (`p`.`status` = 'pending') */;

/*View structure for view propertyunits */

/*!50001 DROP TABLE IF EXISTS `propertyunits` */;
/*!50001 DROP VIEW IF EXISTS `propertyunits` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `propertyunits` AS select `p`.`propertyID` AS `propertyID`,`p`.`propName` AS `propName`,`p`.`location` AS `location`,`p`.`type` AS `type`,`p`.`status` AS `status`,`p`.`description` AS `description`,`p`.`createdBy` AS `createdBy`,`p`.`created_at` AS `created_at`,`p`.`updatedBy` AS `updatedBy`,`p`.`updated_at` AS `updated_at`,`u`.`unitID` AS `unitID`,`u`.`unitname` AS `unitname`,`u`.`bedrooms` AS `bedrooms`,`u`.`bathrooms` AS `bathrooms`,`u`.`rentamount` AS `rentamount`,`u`.`description` AS `unitdescription`,`u`.`unitstatus` AS `unitstatus` from (`properties` `p` join `units` `u` on((`p`.`propertyID` = `u`.`propertyID`))) */;

/*View structure for view rent_collection */

/*!50001 DROP TABLE IF EXISTS `rent_collection` */;
/*!50001 DROP VIEW IF EXISTS `rent_collection` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rent_collection` AS select `p`.`id` AS `id`,`p`.`tenant_id` AS `tenant_id`,`p`.`property_id` AS `property_id`,`p`.`amount` AS `amount`,`p`.`month` AS `month`,`p`.`year` AS `year`,`p`.`payment_date` AS `payment_date`,`p`.`payment_method` AS `payment_method`,`p`.`status` AS `status`,`p`.`created_at` AS `created_at`,`p`.`unitID` AS `unitID`,`p`.`userID` AS `userID`,`p`.`emailsent` AS `emailsent`,`p`.`datesent` AS `datesent`,`t`.`partial_pay` AS `partial_pay` from (`payments` `p` left join `total_partial_paid` `t` on((`p`.`id` = `t`.`paymentID`))) */;

/*View structure for view tenantproperty */

/*!50001 DROP TABLE IF EXISTS `tenantproperty` */;
/*!50001 DROP VIEW IF EXISTS `tenantproperty` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tenantproperty` AS select `t`.`tenantID` AS `tenantID`,`t`.`propertyID` AS `propertyID`,`t`.`first_name` AS `first_name`,`t`.`last_name` AS `last_name`,`t`.`email` AS `email`,`t`.`phone` AS `phone`,`t`.`move_in_date` AS `move_in_date`,`t`.`move_out_date` AS `move_out_date`,`t`.`status` AS `status`,`t`.`created_at` AS `created_at`,`t`.`updated_at` AS `updated_at`,`t`.`unitID` AS `unitID`,`p`.`propName` AS `propName`,`p`.`location` AS `location`,`p`.`type` AS `type`,`p`.`status` AS `propertystatus`,`p`.`description` AS `description` from (`tenants` `t` join `properties` `p` on((`t`.`propertyID` = `p`.`propertyID`))) */;

/*View structure for view total_partial_paid */

/*!50001 DROP TABLE IF EXISTS `total_partial_paid` */;
/*!50001 DROP VIEW IF EXISTS `total_partial_paid` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_partial_paid` AS select `partial_payments`.`paymentID` AS `paymentID`,sum(`partial_payments`.`amount`) AS `partial_pay` from `partial_payments` group by `partial_payments`.`paymentID` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
