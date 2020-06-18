/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.4.11-MariaDB : Database - test_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `test_db`;

/*Table structure for table `media_draft_table` */

DROP TABLE IF EXISTS `media_draft_table`;

CREATE TABLE `media_draft_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socialid` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` blob NOT NULL,
  `media_path` varchar(500) NOT NULL,
  `mime_type` varchar(10) DEFAULT NULL,
  `posted_id` varchar(100) NOT NULL,
  `tags` varchar(500) NOT NULL,
  `scheduled_time` datetime NOT NULL,
  `state` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `media_draft_table` */

insert  into `media_draft_table`(`id`,`socialid`,`title`,`description`,`media_path`,`mime_type`,`posted_id`,`tags`,`scheduled_time`,`state`,`created_at`,`deleted_at`) values 
(1,129962347,'test1','testing hootsuite','d:/img.png','image/png','5894405600','abc','2020-02-27 12:36:38','','0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,129962347,'test 2','This is test 2','D:/bg.jpg','image/jpg','5894450734','','2020-02-25 14:15:33','SCHEDULED','2020-02-25 08:29:55','0000-00-00 00:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
