/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.10-MariaDB : Database - tubes_2022_nisa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category` */

insert  into `category`(`id`,`category_name`,`created_at`,`updated_at`) values 
(1,'Java','2022-04-25 14:41:47',NULL),
(2,'React','2022-04-25 14:41:49',NULL),
(3,'Web Development','2022-04-25 14:41:51',NULL),
(4,'Design','2022-04-25 14:41:53',NULL),
(5,'Test','2022-04-26 10:39:10',NULL);

/*Table structure for table `course` */

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instructor_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `course_image` varchar(250) DEFAULT NULL,
  `course_name` varchar(250) DEFAULT NULL,
  `course_description` longtext DEFAULT NULL,
  `price_type` enum('free','paid') DEFAULT NULL,
  `course_price` int(50) DEFAULT NULL,
  `total_material` int(50) DEFAULT 0,
  `total_duration` int(11) DEFAULT 0,
  `is_active` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course` */

insert  into `course`(`id`,`instructor_id`,`category_id`,`course_image`,`course_name`,`course_description`,`price_type`,`course_price`,`total_material`,`total_duration`,`is_active`,`created_at`,`updated_at`) values 
(8,1,4,'course_1652808440.jpg','Course Test Paid','Course Payment','paid',35000,5,60,'0','2022-05-17 17:27:20',NULL);

/*Table structure for table `course_discussion` */

DROP TABLE IF EXISTS `course_discussion`;

CREATE TABLE `course_discussion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `disscussion` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `course_discussion_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `course_section_material` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_discussion_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_discussion` */

insert  into `course_discussion`(`id`,`material_id`,`user_id`,`disscussion`,`created_at`,`updated_at`) values 
(6,13,3,'Ini maksud pengenalannya gimana ?','2022-05-17 17:39:35',NULL);

/*Table structure for table `course_discussion_reply` */

DROP TABLE IF EXISTS `course_discussion_reply`;

CREATE TABLE `course_discussion_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_discussion_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `reply` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_discussion_id` (`course_discussion_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `course_discussion_reply_ibfk_1` FOREIGN KEY (`course_discussion_id`) REFERENCES `course_discussion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_discussion_reply_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_discussion_reply` */

/*Table structure for table `course_review` */

DROP TABLE IF EXISTS `course_review`;

CREATE TABLE `course_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review` longtext DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `course_review_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_review` */

insert  into `course_review`(`id`,`course_id`,`user_id`,`review`,`rating`,`created_at`,`updated_at`) values 
(3,8,3,'Mantap',5,'2022-05-17 17:39:10',NULL);

/*Table structure for table `course_section` */

DROP TABLE IF EXISTS `course_section`;

CREATE TABLE `course_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `section_name` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `course_section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_section` */

insert  into `course_section`(`id`,`course_id`,`section_name`,`created_at`,`updated_at`) values 
(8,8,'Trailer','2022-05-17 17:30:39',NULL),
(9,8,'Fundamental Website','2022-05-17 17:30:51',NULL),
(10,8,'Advanced Website','2022-05-17 17:31:03',NULL);

/*Table structure for table `course_section_material` */

DROP TABLE IF EXISTS `course_section_material`;

CREATE TABLE `course_section_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) DEFAULT NULL,
  `material_title` varchar(250) DEFAULT NULL,
  `material_type` enum('video','quiz') DEFAULT NULL,
  `material_video_url` varchar(250) DEFAULT NULL,
  `material_description` longtext DEFAULT NULL,
  `is_overview` enum('0','1') DEFAULT '0',
  `duration` int(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  CONSTRAINT `course_section_material_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_section_material` */

insert  into `course_section_material`(`id`,`section_id`,`material_title`,`material_type`,`material_video_url`,`material_description`,`is_overview`,`duration`,`created_at`,`updated_at`) values 
(13,8,'Overview Course','video','https://www.youtube.com/embed/uoPVeGOUwv0','Lorem ipsum sip dolor amet','1',10,'2022-05-17 17:32:33',NULL),
(14,9,'Apa itu Website ?','video','https://www.youtube.com/embed/uoPVeGOUwv0','Lorem ipsum sip dolor amet','1',10,'2022-05-17 17:33:04',NULL),
(15,9,'Dasar - Dasar Website','video','https://www.youtube.com/embed/uoPVeGOUwv0','lorem ipsum sip','0',10,'2022-05-17 17:33:34',NULL),
(17,10,'Keamanan Website','video','https://www.youtube.com/embed/uoPVeGOUwv0','Lorem ipsum sip dolor amet','0',30,'2022-05-17 17:36:24',NULL),
(18,9,'Quiz Pengenalan Website','quiz',NULL,'Lorem ipsum sip dolor amet','0',NULL,'2022-05-17 17:46:17',NULL);

/*Table structure for table `course_section_material_quiz` */

DROP TABLE IF EXISTS `course_section_material_quiz`;

CREATE TABLE `course_section_material_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) DEFAULT NULL,
  `quiz` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `course_section_material_quiz_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `course_section_material` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_section_material_quiz` */

insert  into `course_section_material_quiz`(`id`,`material_id`,`quiz`,`created_at`,`updated_at`) values 
(17,18,'Soal Pertama','2022-05-17 17:46:46',NULL),
(18,18,'Soal Kedua','2022-05-17 17:47:07',NULL),
(19,18,'Soal Ketiga','2022-05-17 17:47:32',NULL),
(20,18,'Soal Keempat','2022-05-17 17:47:50',NULL);

/*Table structure for table `course_section_material_quiz_option` */

DROP TABLE IF EXISTS `course_section_material_quiz_option`;

CREATE TABLE `course_section_material_quiz_option` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(10) DEFAULT NULL,
  `option_1` longtext DEFAULT NULL,
  `option_2` longtext DEFAULT NULL,
  `option_3` longtext DEFAULT NULL,
  `option_4` longtext DEFAULT NULL,
  `correct_answer` enum('1','2','3','4') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `course_section_material_quiz_option_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `course_section_material_quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_section_material_quiz_option` */

insert  into `course_section_material_quiz_option`(`id`,`quiz_id`,`option_1`,`option_2`,`option_3`,`option_4`,`correct_answer`,`created_at`,`updated_at`) values 
(15,17,'Jawaban 1','Jawaban 2','Jawaban 3','Jawaban 4','1','2022-05-17 17:46:46',NULL),
(16,18,'Jawaban 1','Jawaban 2','Jawaban 3','Jawaban 4','2','2022-05-17 17:47:07',NULL),
(17,19,'Jawaban 1','Jawaban 2','Jawaban 3','Jawaban 4','3','2022-05-17 17:47:32',NULL),
(18,20,'Jawaban 1','Jawaban 2','Jawaban 3','Jawaban 4','4','2022-05-17 17:47:50',NULL);

/*Table structure for table `course_user_enroll` */

DROP TABLE IF EXISTS `course_user_enroll`;

CREATE TABLE `course_user_enroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `is_done` enum('0','1') DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `course_user_enroll_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_user_enroll` */

insert  into `course_user_enroll`(`id`,`user_id`,`course_id`,`is_done`,`created_at`,`finished_at`,`updated_at`) values 
(1,3,3,'1','2022-04-26 01:34:02','2022-05-12 06:21:37',NULL),
(2,3,1,'0','2022-05-12 12:19:18',NULL,NULL),
(3,3,8,'1','2022-05-17 17:38:18','2022-05-17 17:53:07',NULL);

/*Table structure for table `course_user_enroll_answer` */

DROP TABLE IF EXISTS `course_user_enroll_answer`;

CREATE TABLE `course_user_enroll_answer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `answer` enum('1','2','3','4') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `course_user_enroll_answer_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `course_section_material_quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_user_enroll_answer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_user_enroll_answer` */

insert  into `course_user_enroll_answer`(`id`,`user_id`,`quiz_id`,`answer`,`created_at`,`updated_at`) values 
(7,3,17,'1','2022-05-17 17:49:26',NULL),
(8,3,18,'2','2022-05-17 17:49:47',NULL),
(9,3,19,'3','2022-05-17 17:50:03',NULL),
(10,3,20,'3','2022-05-17 17:50:20',NULL);

/*Table structure for table `course_user_enroll_section` */

DROP TABLE IF EXISTS `course_user_enroll_section`;

CREATE TABLE `course_user_enroll_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enroll_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `is_understand` enum('1','0') DEFAULT '1',
  `score` int(50) DEFAULT NULL,
  `total_quiz` int(50) DEFAULT NULL,
  `total_correct` int(50) DEFAULT NULL,
  `total_false` int(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`),
  KEY `enroll_id` (`enroll_id`),
  CONSTRAINT `course_user_enroll_section_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `course_section_material` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_user_enroll_section_ibfk_2` FOREIGN KEY (`enroll_id`) REFERENCES `course_user_enroll` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `course_user_enroll_section` */

insert  into `course_user_enroll_section`(`id`,`enroll_id`,`material_id`,`is_understand`,`score`,`total_quiz`,`total_correct`,`total_false`,`created_at`,`updated_at`) values 
(11,3,13,'1',NULL,NULL,NULL,NULL,'2022-05-17 17:39:44',NULL),
(12,3,14,'1',NULL,NULL,NULL,NULL,'2022-05-17 17:40:11',NULL),
(13,3,15,'1',NULL,NULL,NULL,NULL,'2022-05-17 17:40:15',NULL),
(14,3,17,'1',NULL,NULL,NULL,NULL,'2022-05-17 17:40:18',NULL),
(16,3,18,'1',75,4,3,1,'2022-05-17 17:53:07',NULL);

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_code` varchar(50) DEFAULT NULL,
  `payment_proof` varchar(250) DEFAULT NULL,
  `status` enum('pending','complete','deny','need_confirmation') DEFAULT 'pending',
  `total_price` int(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `send_proof_at` datetime DEFAULT NULL,
  `confirm_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `transaction` */

insert  into `transaction`(`id`,`course_id`,`user_id`,`transaction_code`,`payment_proof`,`status`,`total_price`,`created_at`,`send_proof_at`,`confirm_at`,`updated_at`) values 
(4,8,3,NULL,'payment_1652809052.jpg','complete',35000,'2022-05-17 17:37:18','2022-05-17 17:37:32','2022-05-17 17:38:18',NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(250) DEFAULT 'default.png',
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `role` enum('user','admin','instructor') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`id`,`photo`,`name`,`email`,`phone`,`password`,`role`,`created_at`,`updated_at`) values 
(1,'default.png','instructor 1','instructor1@gmail.com','08213123','123456789','instructor',NULL,NULL),
(2,'default.png','instructor 2','instructor2@gmail.com','2143213','123456789','instructor',NULL,NULL),
(3,'default.png','Wader','jhonsonwader@gmail.com','213213','123456789','user',NULL,NULL),
(5,'default.png','User','user12@gmail.com','213123','123456789','user',NULL,NULL),
(6,'default.png','Bellatrix Lestrange','bella@gmail.com','123456789','123456789','admin',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
