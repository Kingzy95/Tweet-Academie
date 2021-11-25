# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.7.32)
# Base de données: tweety
# Temps de génération: 2021-03-04 13:33:41 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `commentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(140) DEFAULT NULL,
  `commentOn` int(11) DEFAULT NULL,
  `commentBy` int(11) DEFAULT NULL,
  `commentAt` datetime DEFAULT NULL,
  PRIMARY KEY (`commentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table follow
# ------------------------------------------------------------

DROP TABLE IF EXISTS `follow`;

CREATE TABLE `follow` (
  `followID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `followOn` datetime DEFAULT NULL,
  PRIMARY KEY (`followID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `likeID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `likeBy` int(11) DEFAULT NULL,
  `likeOn` int(11) DEFAULT NULL,
  PRIMARY KEY (`likeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `messageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `messageTo` int(11) DEFAULT NULL,
  `messageFrom` int(11) DEFAULT NULL,
  `messageOn` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;

INSERT INTO `messages` (`messageID`, `message`, `messageTo`, `messageFrom`, `messageOn`, `status`)
VALUES
	(1,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notificationFor` int(11) DEFAULT NULL,
  `notificationFrom` int(11) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `type` enum('follow','retweet','like','mention') DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;

INSERT INTO `notification` (`ID`, `notificationFor`, `notificationFrom`, `target`, `type`, `time`, `status`)
VALUES
	(1,1,2,9,'mention','2021-03-03 23:01:39',1),
	(2,NULL,1,13,'mention','2021-03-03 23:17:54',NULL),
	(3,2,1,15,'mention','2021-03-03 23:42:38',NULL),
	(4,2,1,19,'mention','2021-03-04 11:47:57',NULL);

/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table trends
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trends`;

CREATE TABLE `trends` (
  `trendID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hashtag` varchar(140) DEFAULT NULL,
  `createdOn` datetime DEFAULT NULL,
  PRIMARY KEY (`trendID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `trends` WRITE;
/*!40000 ALTER TABLE `trends` DISABLE KEYS */;

INSERT INTO `trends` (`trendID`, `hashtag`, `createdOn`)
VALUES
	(1,'php','2021-03-04 00:16:05'),
	(2,'epitech','2021-03-04 00:16:38');

/*!40000 ALTER TABLE `trends` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table tweets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tweets`;

CREATE TABLE `tweets` (
  `tweetID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(140) DEFAULT NULL,
  `tweetBy` int(11) DEFAULT NULL,
  `retweetBy` int(11) DEFAULT NULL,
  `retweetID` int(11) DEFAULT NULL,
  `tweetImage` varchar(255) DEFAULT NULL,
  `likesCount` int(11) DEFAULT NULL,
  `retweetCount` int(11) DEFAULT NULL,
  `postedOn` datetime DEFAULT NULL,
  `retweetMsg` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`tweetID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;

INSERT INTO `tweets` (`tweetID`, `status`, `tweetBy`, `retweetBy`, `retweetID`, `tweetImage`, `likesCount`, `retweetCount`, `postedOn`, `retweetMsg`)
VALUES
	(1,'Test',1,NULL,NULL,'',NULL,NULL,'2021-03-03 17:56:34',NULL),
	(2,'Lorem Ipsum',1,NULL,NULL,'',NULL,NULL,'2021-03-03 17:57:17',NULL),
	(3,'Bonsoir',1,NULL,NULL,'',NULL,NULL,'2021-03-03 19:55:19',NULL),
	(4,'ninfeizfnef',1,NULL,NULL,'',NULL,NULL,'2021-03-03 20:05:26',NULL),
	(5,'Bonsoir',1,NULL,NULL,'',NULL,NULL,'2021-03-03 21:05:52',NULL),
	(6,'Je suis malade',1,NULL,NULL,'',NULL,NULL,'2021-03-03 22:35:00',NULL),
	(7,'Bonjour',2,NULL,NULL,'',NULL,NULL,'2021-03-03 22:41:58',NULL),
	(8,'Hi',2,NULL,NULL,'',NULL,NULL,'2021-03-03 23:01:24',NULL),
	(9,'@yapidu69 Salut',2,NULL,NULL,'',NULL,NULL,'2021-03-03 23:01:39',NULL),
	(10,'#php',2,NULL,NULL,'',NULL,NULL,'2021-03-03 23:16:05',NULL),
	(11,'#epitech',2,NULL,NULL,'',NULL,NULL,'2021-03-03 23:16:38',NULL),
	(12,'Happy!',2,NULL,NULL,'',NULL,NULL,'2021-03-03 23:16:45',NULL),
	(13,'@Emmanuel Mingui',1,NULL,NULL,'',NULL,NULL,'2021-03-03 23:17:54',NULL),
	(14,'',1,NULL,NULL,'users/53FD83DC-0403-434D-8DB4-F74BA97C7EFA_1_201_a.jpeg',NULL,NULL,'2021-03-03 23:18:08',NULL),
	(15,'@Kingzy Hello',1,NULL,NULL,'',NULL,NULL,'2021-03-03 23:42:38',NULL),
	(16,'Bonjour',1,NULL,NULL,'',NULL,NULL,'2021-03-04 11:26:22',NULL),
	(17,'',1,NULL,NULL,'users/EuWaKzCXcAURSjI.jpeg',NULL,NULL,'2021-03-04 11:27:24',NULL),
	(18,'DAZDAEC R',1,NULL,NULL,'',NULL,NULL,'2021-03-04 11:41:55',NULL),
	(19,'@kingzy !!!!!',1,NULL,NULL,'',NULL,NULL,'2021-03-04 11:47:57',NULL),
	(20,'@yapidu69 !!!!',1,NULL,NULL,'',NULL,NULL,'2021-03-04 11:48:21',NULL);

/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `screenName` varchar(40) DEFAULT NULL,
  `profileName` varchar(40) DEFAULT NULL,
  `profileImage` varchar(255) DEFAULT NULL,
  `profileCover` varchar(255) DEFAULT NULL,
  `following` int(11) DEFAULT NULL,
  `followers` int(11) DEFAULT NULL,
  `bio` varchar(140) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `screenName`, `profileName`, `profileImage`, `profileCover`, `following`, `followers`, `bio`, `country`, `website`)
VALUES
	(1,'yapidu69','yapi@fr.fr','f957c3b748aa5d068f8d9f7f320ca1c3','yapi yapo',NULL,'users/53FD83DC-0403-434D-8DB4-F74BA97C7EFA_1_201_a.jpeg','users/plaid.png',NULL,NULL,'IT STUDENT','France','www.twitter.com'),
	(2,'Kingzy','lookbykingzy@gmail.com','1a4049aa27765d93b3babf22c0113930','Emmanuel Mingui',NULL,'assets/images/defaultProfileImage.png',NULL,NULL,NULL,'#Code4Life!','France','www.epitech.eu');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
