/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.7.3-MariaDB : Database - EASYBAZARDB2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `SA_USER` */

DROP TABLE IF EXISTS `SA_USER`;

CREATE TABLE `SA_USER` (
  `PK_NO` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` int(11) DEFAULT NULL,
  `NAME` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESIGNATION` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EMAIL` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MOBILE_NO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `GENDER` int(11) DEFAULT 1,
  `DOB` date DEFAULT NULL,
  `FACEBOOK_ID` int(20) DEFAULT NULL,
  `GOOGLE_ID` int(20) DEFAULT NULL,
  `PROFILE_PIC` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PROFILE_PIC_URL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PIC_MIME_TYPE` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACTIVATION_CODE` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACTIVATION_CODE_EXPIRE` datetime DEFAULT NULL,
  `IS_FIRST_LOGIN` int(11) NOT NULL DEFAULT 1,
  `USER_TYPE` int(2) NOT NULL DEFAULT 0 COMMENT '1 = admin 10=shop user, 20 = delivery man',
  `CAN_LOGIN` int(11) NOT NULL DEFAULT 1,
  `REMEMBER_TOKEN` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `STATUS` int(11) NOT NULL DEFAULT 1,
  `F_PARENT_USER_ID` int(11) DEFAULT 0,
  `CREATED_BY` int(11) NOT NULL DEFAULT 0,
  `UPDATED_BY` int(11) NOT NULL DEFAULT 0,
  `CREATED_AT` datetime DEFAULT NULL,
  `UPDATED_AT` datetime DEFAULT NULL,
  `IS_ACTIVE` int(1) NOT NULL DEFAULT 1,
  `SHOP_NAME` varchar(155) DEFAULT NULL,
  `SHOP_ID` int(11) DEFAULT 0,
  `MIN_ORDER_AMOUNT` float DEFAULT 200,
  `MAX_ORDER_AMOUNT` float DEFAULT 1000000,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `MONTHLY_SALARY` float DEFAULT NULL,
  `PER_DELIVERY_COMM` float DEFAULT NULL,
  `JOINING_DATE` date DEFAULT NULL,
  PRIMARY KEY (`PK_NO`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `SA_USER` */

insert  into `SA_USER`(`PK_NO`,`CODE`,`NAME`,`DESIGNATION`,`EMAIL`,`MOBILE_NO`,`PASSWORD`,`GENDER`,`DOB`,`FACEBOOK_ID`,`GOOGLE_ID`,`PROFILE_PIC`,`PROFILE_PIC_URL`,`PIC_MIME_TYPE`,`ACTIVATION_CODE`,`ACTIVATION_CODE_EXPIRE`,`IS_FIRST_LOGIN`,`USER_TYPE`,`CAN_LOGIN`,`REMEMBER_TOKEN`,`STATUS`,`F_PARENT_USER_ID`,`CREATED_BY`,`UPDATED_BY`,`CREATED_AT`,`UPDATED_AT`,`IS_ACTIVE`,`SHOP_NAME`,`SHOP_ID`,`MIN_ORDER_AMOUNT`,`MAX_ORDER_AMOUNT`,`ADDRESS`,`MONTHLY_SALARY`,`PER_DELIVERY_COMM`,`JOINING_DATE`) values 
('2',NULL,'admin','General Admin','admin@easybazar.com','01716824758','$2y$10$aAANKQzyqfRinNTVZ1tlfesvIGYHWa4.Hg5IER24IiykshzpqhZeC','1',NULL,NULL,NULL,'profile_14062022_1655185883.png','/media/images/profile/profile_14062022_1655185883.png',NULL,NULL,NULL,'1','0','1',NULL,'1','0','0','0','2020-10-05 05:06:35','2022-06-14 13:51:23','1',NULL,'0','200','1000000',NULL,NULL,NULL,NULL),
('47',NULL,'s.sifat','logistic','sifat@gmail.com','01716825214','$2y$10$SbohKOR1hjx2oJ0XwkLEYO/0/EJaZsoD3HVhzuKIuXHEiycPuwm3O','0',NULL,NULL,NULL,'computer-icons-user-profile-clip-art.png','http://192.168.203.247/media/images/profile/profile_17122020_1608182835.jpg',NULL,NULL,NULL,'1','0','1',NULL,'1','0','0','0','2020-12-16 05:11:20','2020-12-18 05:08:35','1',NULL,'0','200','1000000',NULL,NULL,NULL,NULL),
('74',NULL,'Web',NULL,'web@azuramart.com','123123123123','$2y$10$aAANKQzyqfRinNTVZ1tlfesvIGYHWa4.Hg5IER24IiykshzpqhZeC','1',NULL,NULL,NULL,'computer-icons-user-profile-clip-art.jpg','http://ukshop.test/media/images/profile/computer-icons-user-profile-clip-art.jpg',NULL,NULL,NULL,'1','0','1',NULL,'1','0','0','0','2021-06-22 16:05:04','2021-06-22 16:05:04','1',NULL,'0','200','1000000',NULL,NULL,NULL,NULL),
('75',NULL,'Jamir','Data analyst','jamir@gmail.com','0123456789','$2y$10$fe3GuMetSaTNpz11UUYPied2.9P8TR3XmoQop.bgaSESszactguqC','1',NULL,NULL,NULL,'profile_01082021_1627798756.png','http://localhost/project/ukshop/public/media/images/profile/profile_01082021_1627798756.png',NULL,NULL,NULL,'1','0','1',NULL,'1','0','0','0','2021-07-06 16:58:30','2021-08-04 17:06:07','1',NULL,'0','200','1000000',NULL,NULL,NULL,NULL),
('79','1001','Central Branch','Admin','Central@gmail.com','1766922573','$2y$10$UYFM64U3lrBmc7CSdzxaaOrGXSOXZBGqS2YGUIM5c1pL34ChKnKiq','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-20 14:33:07','2022-05-21 17:55:05','1','Central Branch','79','200','1000000',NULL,NULL,NULL,NULL),
('80','1002','Nahid2','test','nahid@gmail.com','1681944126','$2y$10$UYFM64U3lrBmc7CSdzxaaOrGXSOXZBGqS2YGUIM5c1pL34ChKnKiq','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','79','2','2','2022-04-20 18:37:00','2022-04-28 13:38:26','1',NULL,'79','200','1000000',NULL,NULL,NULL,NULL),
('81','1003','Kamrul','Manager','kamrul@gmail.com','0124545','$2y$10$ctItXa4iZnGoD8AZVn0DP.kTAMFYVyS5GqDe3Zyps58psthlMuNuu','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','79','2','2','2022-04-21 19:58:51','2022-04-21 19:58:51','1',NULL,'79','200','1000000',NULL,NULL,NULL,NULL),
('82','1004','Banani branch','Admin','Banani@gmail.com','1918993428','$2y$10$aAANKQzyqfRinNTVZ1tlfesvIGYHWa4.Hg5IER24IiykshzpqhZeC','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-23 14:25:03','2022-07-21 20:13:24','1','Banani branch','82','200','1000000',NULL,NULL,NULL,NULL),
('83','1005','Uttara Branch','Admin','uttara@easybazar.com','1715996634','$2y$10$mN5Io7phpDIee0Qp/dXjHuJ8SEZzGSCtVIJqA8qTiZg.Jefk2iQR6','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-23 15:00:33','2022-06-27 21:56:16','1','Uttara Branch','83','200','1000000',NULL,NULL,NULL,NULL),
('84','1006','Dhanmondi Branch',NULL,'dhanmondi@easybazar.com','1712984902','$2y$10$Ss0msOQPYDCVIssh/du38uM9qnq0ek7DGoYjjiJpy5z6WGP05LTJi','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-23 15:50:18','2022-05-21 17:22:40','1','Dhanmondi Branch','84','200','1000000',NULL,NULL,NULL,NULL),
('86','1008','komlapur Branch',NULL,'komlapur@easybazar.com','1687315725','$2y$10$3HQt/qye2UKRxZvqpTy/eOiroaqbP.anCxeOB0YLtZrIAzk9O/IYu','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-23 15:53:50','2022-05-21 18:01:26','1','komlapur Branch','86','200','1000000',NULL,NULL,NULL,NULL),
('87','1009','Gulshan Branch',NULL,'gulshan@easybazar.com','1716553509','$2y$10$6xCNfye.0oJUFPu1XrWMDuTC1IPwpgk0ELP84pQ6yaC8xEubyifty','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-23 15:56:31','2022-05-21 17:35:03','1','Gulshan Branch','87','200','1000000',NULL,NULL,NULL,NULL),
('88','1010','Jamal','Manager','jamal@gmail.com','19188888','$2y$10$T0HtiSDKIa4yA7I7IBJeLe2eWcS0SqYeqUjfFQ3y9U1dJwE7bOZ0S','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','82','2','2','2022-04-24 13:53:03','2022-07-21 20:14:39','1',NULL,'82','200','1000000',NULL,NULL,NULL,NULL),
('89','1011','Uttara Branch 1',NULL,'Uttara@easybazar.com','1736704668','$2y$10$diXrOi3IrBg5IkDyB.dzSu57/oQ3FRJ0RJW9q5xvscnUq/nHJ2gcy','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-04-28 13:32:43','2022-05-21 18:15:37','1','Uttara Branch 1','89','200','1000000',NULL,NULL,NULL,NULL),
('90','1012','Sakil Uttara','manager','sakil@easybazar.com','123456','$2y$10$f2krfw8.svcNhWjvTnFMpubXKIfm3acnIqwrMq1DIYRWI0XmcQIaS','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','83','2','0','2022-04-28 13:38:44','2022-04-28 13:38:44','1',NULL,'0','200','1000000',NULL,NULL,NULL,NULL),
('101','1014','Mohakhali Branch',NULL,'ziariyad@easybazar.com','1860141942','$2y$10$qugSALMKlfANQrpQTU4RDuaDDj2299fqAKPCR13Cuk/4jnCdQm1Fm','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','0','2','2','2022-06-15 16:37:55','2022-06-15 16:37:55','1','Easybazar Mohakhali Branch','101','200','1000000',NULL,NULL,NULL,NULL),
('105','1015','Amir Khan',NULL,'amir@gmail.com','01681994255','$2y$10$Z5zJx/aTgfJ1BzfBE2htIu8St3LYF50XjUVbftz2wfuAW5.TpSKXS','1',NULL,NULL,NULL,NULL,'/public/media/images/delivery_body/avatar-s-9-62b99f3c317bc.webp',NULL,NULL,NULL,'1','20','1',NULL,'1','0','0','0','2022-06-27 20:13:17','2022-06-27 20:14:52','1',NULL,'0','200','1000000','Dhaka','12000','8','2022-06-01'),
('106','1016','shila','BRCC','abc@123.com','123123','$2y$10$V1XrNIaUaoYd0X/U6evEyu0JXrb9l9eNYPJZaNpWVIZF2MwpfRa0.','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1','10','1',NULL,'1','82','2','0','2022-07-20 20:47:49','2022-07-20 20:47:49','1',NULL,'82','200','1000000',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
