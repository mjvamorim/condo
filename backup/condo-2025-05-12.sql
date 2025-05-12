/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: condo
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB-ubu2404

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `condo`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `condo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;

USE `condo`;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `lastfour` varchar(4) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cards_user_id_foreign` (`user_id`),
  CONSTRAINT `cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `fixo` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `rua` varchar(60) DEFAULT NULL,
  `numero` varchar(30) DEFAULT NULL,
  `complemento` varchar(60) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(30) DEFAULT NULL,
  `uf` varchar(2) DEFAULT 'RJ',
  `pais` varchar(30) DEFAULT 'Brasil',
  `banco` bigint(20) DEFAULT 341,
  `agencia` bigint(20) DEFAULT 0,
  `conta` bigint(20) DEFAULT 0,
  `digito` bigint(20) DEFAULT 0,
  `carteira` bigint(20) DEFAULT 0,
  `convenio` bigint(20) DEFAULT 0,
  `db_host` varchar(30) DEFAULT 'localhost',
  `db_database` varchar(30) DEFAULT NULL,
  `db_username` varchar(30) DEFAULT 'root',
  `db_password` varchar(30) DEFAULT 'root',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES
(1,'Condominio Sonho Dourado (testes)','mjvamorim@gmail.com','(022)99886-9510',NULL,'05.633.392/0001-40','28030-035','Avenida Doutor Nilo Peçanha','614','Sonho Dourado','Parque Santo Amaro','Campos dos Goytacazes','RJ','Brasil',33,3086,13004894,2,101,16396,'127.0.0.1','condo1','root','root','2020-02-14 20:08:28','2021-01-22 15:04:31'),
(2,'Residencial Lagoa Dourada','pelincao@yahoo.com.br','(022)99873-5659','(022)27380-111','31.506.157/0001-17','28035-053','Avenida Pelinca','245','Bloco 02/Administração','Parque Tamandaré','Campos dos Goytacazes','RJ','Brasil',341,1628,1673,3,109,0,'127.0.0.1','condo2','root','root','2020-02-14 20:13:15','2020-07-08 12:46:51'),
(3,'Condomínio Sonho Dourado','admin@condominiosonhodourado.com.br','(022)2732-5045',NULL,'05.633.392/0001-40','28030-035','Avenida Doutor Nilo Peçanha','614-822','Sonho Dourado','Parque Santo Amaro','Campos dos Goytacazes','RJ','Brasil',33,3086,13004894,2,101,16396,'127.0.0.1','condo3','root','root','2020-02-19 21:31:29','2021-02-24 13:33:44'),
(4,'eCondominio','teste@econdominio.net','(022)99886-9510','(022)27325-045','05.633.392/0001-40','28030-035','Avenida Doutor Nilo Peçanha','615',NULL,'Parque Santo Amaro','Campos dos Goytacazes','RJ','Brasil',33,3086,13004894,2,101,16396,'127.0.0.1','condo4','root','root','2020-04-06 02:51:14','2021-01-22 14:39:37'),
(5,'Condominio do Edificio Morada da Baronesa','morada.baronesa@gmail.com','(022)99851-2288','(022)99863-5391','08.743.489/0001-01','28035-053','Avenida Pelinca','245','Bloco 02','Parque Tamandaré','Campos dos Goytacazes','RJ','Brasil',341,1628,99825,2,109,0,'127.0.0.1','condo5','root','root','2021-08-15 15:46:01','2021-08-15 15:57:57'),
(6,'Luiz Galdino','luiz.galdino@tecnoil.com.br','21981287901',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo6','root','root','2020-04-14 16:58:38','2020-04-14 16:58:38'),
(7,'Emerson de Carvalho Paz','emersoncpaz@gmail.com','81981816655',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo7','root','root','2020-04-20 20:02:24','2020-04-20 20:02:24'),
(9,'José Geovanio do Nascimento Brito','geovanio.nascimento85@gmail.com','82 96525698',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo9','root','root','2020-06-02 05:26:07','2020-06-02 05:26:07'),
(10,'Anna Leticia Martins','anna.openparts1@gmail.com','981223977',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo10','root','root','2020-06-04 21:07:10','2020-06-04 21:07:10'),
(11,'Tamires Dos Prazeres Barbosa','tamy_pb07@hotmail.com','81977306846',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo11','root','root','2020-06-07 22:28:54','2020-06-07 22:28:54'),
(12,'JOSE TOBIAS DE FREITAS','jtfreitas42@gmail.com','61981573821',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo12','root','root','2020-11-21 14:05:50','2020-11-21 14:05:50'),
(13,'André Mott Fernandez','vendasobambu@gmail.com','44998855000',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo13','root','root','2020-06-17 02:37:22','2020-06-17 02:37:22'),
(14,'Nancy Ferreira Macedo Bellio','nancymf.nancy@gmail.com','11 976436550',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo14','root','root','2021-06-24 16:03:22','2021-06-24 16:03:22'),
(15,'Paulo Verzbickas Neto','paulo.verzbickas@hotmail.com','11994817284',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo15','root','root','2020-06-18 21:30:23','2020-06-18 21:30:23'),
(16,'Juliano Santiago','julianosantiago.contato@gmail.com','92992928899',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo16','root','root','2021-06-25 12:13:28','2021-06-25 12:13:28'),
(17,'Verônica dos Santos','VERONICAADM21@GMAIL.COM','4498836334',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo17','root','root','2020-06-22 13:08:49','2020-06-22 13:08:49'),
(18,'ALEXIS SAAD FILHO','alexissaad7@gmail.com','11984735755',NULL,'004.301.928-51','06404326','Avenida Trindade','434','75A','Bethaville I','Barueri','SP','Brasil',341,0,0,0,0,0,'127.0.0.1','condo18','root','root','2021-07-07 14:07:12','2021-07-07 14:13:56'),
(19,'CONDOMINIO RESIDENCIAL MACEDO','condominiomacedo2021@gmail.com','11947285342',NULL,'09206936000148','07197-100','Rua da Fortuna','234',NULL,'Macedo','Guarulhos','SP','Brasil',341,3150,39249,0,0,0,'127.0.0.1','condo19','root','root','2021-11-16 23:15:18','2021-11-16 23:22:43'),
(20,'Karla Rahmann','karlacomex@hotmail.com','11 993553459',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo20','root','root','2021-12-11 18:49:00','2021-12-11 18:49:00'),
(21,'Julio Cesar de Sousa Nunes','julio.cesar.nunes@gmail.com','11986549212',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo21','root','root','2022-01-27 11:39:47','2022-01-27 11:39:47'),
(114,'Carlos Alberto de Souza','calberto1957@icloud.com','11976231349',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo114','root','root','2022-04-19 14:23:44','2022-04-19 14:23:44'),
(116,'Vitor martello','vitormartello@hotmail.com','11971506764',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo116','root','root','2022-05-05 13:22:07','2022-05-05 13:22:07'),
(122,'Luiza Rocha','luiza.rrocha@hotmail.com','11972585456',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo122','root','root','2022-06-03 20:46:12','2022-06-03 20:46:12'),
(123,'Thales Antônio Carraro Kunsch','thales.ack@gmail.com','11942522710',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo123','root','root','2022-06-13 17:38:24','2022-06-13 17:38:24'),
(124,'nGcDaFYPKsRgtOzL','mvanb212rnm632ox1@outlook.com','4885768991',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo124','root','root','2022-06-21 02:46:06','2022-06-21 02:46:06'),
(125,'Thiago Valdes Paretti','vera.olimpio@clashbr.com.br','11945222353',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo125','root','root','2022-06-21 13:51:11','2022-06-21 13:51:11'),
(126,'Thiago Valdes Paretti','thiago.paretti@gmail.com','11945222353',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo126','root','root','2022-06-21 14:07:05','2022-06-21 14:07:05'),
(136,'Paulo Pucci','pspucci35@gmail.com','11992552106',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo136','root','root','2022-09-11 16:46:07','2022-09-11 16:46:07'),
(138,'Isabela Barbosa Tenuta Daniel','isabelatenuta@gmail.com','11948491256',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo138','root','root','2022-09-21 23:08:04','2022-09-21 23:08:04'),
(154,'GEORGE HANDUS ESCARMELOTO','georgehe1980@gmail.com','11973810894',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo154','root','root','2022-11-28 13:20:38','2022-11-28 13:20:38'),
(158,'Jose Sinforiano Soares Rocha','josoaresro@outlook.com','11998322635',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo158','root','root','2022-12-04 21:00:24','2022-12-04 21:00:24'),
(159,'MecmKlRD','lezqewoseb@outlook.com','8626518970',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo159','root','root','2022-12-17 05:41:22','2022-12-17 05:41:22'),
(160,'XAWldtviehRN','fusqapofop@outlook.com','8612105726',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo160','root','root','2022-12-17 22:17:35','2022-12-17 22:17:35'),
(161,'Priscila Queiroz Martins','priscilaqm16@hotmail.com','1198191161',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo161','root','root','2022-12-20 20:20:38','2022-12-20 20:20:38'),
(162,'dUhpQJRIl','wivzociyot@outlook.com','4712776228',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo162','root','root','2022-12-21 14:57:20','2022-12-21 14:57:20'),
(163,'KuWhcSgkVTE','bopmicikaj@outlook.com','4325413954',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo163','root','root','2022-12-24 21:17:34','2022-12-24 21:17:34'),
(164,'VubkFIwtcJRdKT','vutwutalez@outlook.com','4772037363',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo164','root','root','2023-01-13 03:56:25','2023-01-13 03:56:25'),
(165,'ELISIANE JOSETE HEBERLE SEBASTIANY','elisianeoncologia@gmail.com','42999044421',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo165','root','root','2023-01-26 00:33:02','2023-01-26 00:33:02'),
(166,'eSwZNKBpnAOqsvWi','zuqfejoxir@outlook.com','5713129805',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo166','root','root','2023-01-28 15:01:35','2023-01-28 15:01:35'),
(167,'Ingrid Miranda','ingrid.miranda717@gmail.com','11941008594',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo167','root','root','2023-02-07 16:35:06','2023-02-07 16:35:06'),
(168,'Cinthia de Vita','admtelemac@outlook.com.br','22999882900',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo168','root','root','2023-03-22 14:54:06','2023-03-22 14:54:06'),
(169,'Paulo Henrique Farias','paulohofarias@gmail.com','11980181111',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo169','root','root','2023-03-27 17:05:33','2023-03-27 17:05:33'),
(170,'ANTONIO MARCOS M SILVA','cond.gardenia.adm@gmail.com','84920019487',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo170','root','root','2023-05-18 21:03:04','2023-05-18 21:03:04'),
(171,'Carolina Ferreira Neves','neves.carolina92@gmail.com','11964971618',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo171','root','root','2023-08-31 00:13:44','2023-08-31 00:13:44'),
(172,'ZqnezIUjhXmCWvG','kitdekalel@outlook.com','9474908733',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo172','root','root','2023-10-22 15:30:36','2023-10-22 15:30:36'),
(173,'Elton Carlos','moxok81018@wanbeiz.com','11940483636',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo173','root','root','2023-10-26 18:26:57','2023-10-26 18:26:57'),
(174,'LmVXgkUCJzIcFQ','sayrelifon@outlook.com','7680468602',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo174','root','root','2023-11-15 16:50:24','2023-11-15 16:50:24'),
(175,'mRyktVgF','heztasegop@outlook.com','3010521052',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo175','root','root','2023-11-23 20:50:11','2023-11-23 20:50:11'),
(176,'ruJdQDon','mulcuzayiv@outlook.com','9485658757',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo176','root','root','2023-12-01 10:44:14','2023-12-01 10:44:14'),
(177,'wrqbkVRoSlZW','leo0n7hayes@outlook.com','8371571572',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo177','root','root','2023-12-22 00:57:29','2023-12-22 00:57:29'),
(178,'wxACFhBYybE','ronaldMY60072@outlook.com','5934198909',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo178','root','root','2024-01-08 03:10:17','2024-01-08 03:10:17'),
(179,'Eliane balera de Almeida costa','elianebalera@hotmail.com','11985927531',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo179','root','root','2024-01-08 13:46:42','2024-01-08 13:46:42'),
(180,'hxSaziyYF','EldenPickens471@yahoo.com','6100495977',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo180','root','root','2024-01-14 10:38:47','2024-01-14 10:38:47'),
(181,'xwDErqMmNUflO','LashondaVillalobos689@aol.com','4719911537',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo181','root','root','2024-02-04 22:35:40','2024-02-04 22:35:40'),
(182,'fJYnaehBLwzsRy','fred.goel3909@yahoo.com','5646256731',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo182','root','root','2024-03-02 09:39:33','2024-03-02 09:39:33'),
(183,'sGIhfOHrdj','stonekatei294@gmail.com','6877108773',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo183','root','root','2024-03-07 20:45:47','2024-03-07 20:45:47'),
(184,'MSaAxTJjWelOD','desmondfosselman1985@aol.com','4320619554',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo184','root','root','2024-03-17 02:57:44','2024-03-17 02:57:44'),
(185,'uQbYRvLAE','TonySandoval21570@outlook.com','8106925334',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo185','root','root','2024-03-24 18:22:49','2024-03-24 18:22:49'),
(186,'pZyFDlPLXTogAQN','daiannbrooks673@gmail.com','9368424391',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo186','root','root','2024-03-29 21:26:18','2024-03-29 21:26:18'),
(187,'gPqTUIRMrkeQx','farran996@gmail.com','4100197411',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo187','root','root','2024-04-04 18:05:08','2024-04-04 18:05:08'),
(188,'uhvEJoTBLZrpK','dunlapcharissaum50@gmail.com','8524020216',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo188','root','root','2024-04-12 04:37:21','2024-04-12 04:37:21'),
(189,'hAUXeYlCrBoIDsyT','lloydwo_waitesdx@outlook.com','7294883742',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo189','root','root','2024-04-14 04:55:28','2024-04-14 04:55:28'),
(190,'wWDsURhSjYBAC','tondamosleybj04@outlook.com','6766978680',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo190','root','root','2024-04-20 10:07:55','2024-04-20 10:07:55'),
(191,'sUrThKBbQWLeqE','idverdrs54@gmail.com','2820589159',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo191','root','root','2024-04-23 04:21:54','2024-04-23 04:21:54'),
(192,'Ana Clara Guimarães Pereira','anaclaraguimaraesp@hotmail.com','13997170602',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo192','root','root','2024-04-26 02:06:02','2024-04-26 02:06:02'),
(193,'Patrícia Mendes Iglesias França','patricia.iglesias@uol.com.br','11972531377',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo193','root','root','2024-04-30 16:50:10','2024-04-30 16:50:10'),
(194,'FicyVZter','evitastrouth9963@outlook.com','7516717029',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo194','root','root','2024-05-03 08:10:03','2024-05-03 08:10:03'),
(195,'QTXuWnFmRJdrB','michael_goodent9py@outlook.com','9903509536',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo195','root','root','2024-05-12 23:05:45','2024-05-12 23:05:45'),
(196,'ClyXGAvKDc','michaelsisco2001@aol.com','2945561742',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo196','root','root','2024-05-16 19:39:54','2024-05-16 19:39:54'),
(197,'tInTCDVLlBJN','josephbd_mohameddv@outlook.com','8905439642',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo197','root','root','2024-05-27 08:56:19','2024-05-27 08:56:19'),
(198,'xvhJCtbnz','ashley_lee1995@yahoo.com','3458162497',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo198','root','root','2024-05-31 02:59:55','2024-05-31 02:59:55'),
(199,'ZRrXNKlDBOcjG','kennediballard3897@gmail.com','9266593239',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo199','root','root','2024-06-11 11:13:39','2024-06-11 11:13:39'),
(200,'Fabiana Cadenassi','fabiana.cadenassi@outlook.com.br','11996704920',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo200','root','root','2024-06-13 19:42:02','2024-06-13 19:42:02'),
(201,'vlFrzBVs','feliswillis1987@gmail.com','3925632353',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo201','root','root','2024-06-17 23:32:48','2024-06-17 23:32:48'),
(202,'IgkzQvsawA','osparksn1993@gmail.com','7465737425',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo202','root','root','2024-06-21 08:55:10','2024-06-21 08:55:10'),
(203,'eHRuyczsxKV','yandajeanpierre6777@yahoo.com','9974526488',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo203','root','root','2024-06-25 03:58:10','2024-06-25 03:58:10'),
(204,'hJfSMoAcCyXEjnR','betty12altieriomp@outlook.com','9093854100',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo204','root','root','2024-07-03 12:51:04','2024-07-03 12:51:04'),
(205,'piSXLxgQYaPu','elbabea9328@gmail.com','3633476973',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo205','root','root','2024-07-08 17:38:17','2024-07-08 17:38:17'),
(206,'IFOdeAgt','afifidaryl4599@yahoo.com','2955219747',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo206','root','root','2024-07-22 16:21:18','2024-07-22 16:21:18'),
(207,'hXeduDUnj','stenrossyk@gmail.com','8772139611',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo207','root','root','2024-07-25 07:03:13','2024-07-25 07:03:13'),
(208,'Juliana Cristina Prest','juliana.prest@gmail.com','27992990305',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo208','root','root','2024-07-27 01:52:06','2024-07-27 01:52:06'),
(209,'YHuacMerdV','santiagoflorah1994@gmail.com','6028842835',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo209','root','root','2024-07-27 19:12:18','2024-07-27 19:12:18'),
(210,'SibOkuwpv','lewisrussell3131@yahoo.com','9882424649',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo210','root','root','2024-07-30 07:05:50','2024-07-30 07:05:50'),
(211,'fqOGoVZTvSA','gleksin17@gmail.com','3130606462',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo211','root','root','2024-08-02 04:16:49','2024-08-02 04:16:49'),
(212,'KSNVGLtRhYov','lisalr_brantleykd@outlook.com','5342258043',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo212','root','root','2024-08-19 19:47:54','2024-08-19 19:47:54'),
(213,'dRFVlyNCksrqO','rodriguezvalerie1990@yahoo.com','6943780747',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo213','root','root','2024-08-25 21:58:52','2024-08-25 21:58:52'),
(214,'fdGLvxNCQylkSbs','djaneiyv22@gmail.com','5856292443',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo214','root','root','2024-08-28 23:11:42','2024-08-28 23:11:42'),
(215,'AltkVWSXQTfv','jacquelyn_green0khe@outlook.com','4766581273',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo215','root','root','2024-09-06 20:26:43','2024-09-06 20:26:43'),
(216,'lCmqAPxw','reinercortezea1993@gmail.com','6251505093',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo216','root','root','2024-09-12 23:11:13','2024-09-12 23:11:13'),
(217,'yDocfNgZSv','rkabisat@yahoo.com','4444112811',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo217','root','root','2024-09-20 04:38:22','2024-09-20 04:38:22'),
(218,'LsjQxqGzRtI','donaldt7_houfx@outlook.com','4069396808',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo218','root','root','2024-09-23 05:56:25','2024-09-23 05:56:25'),
(219,'grupo1','josedvpinho@gmail.com','962846536',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo219','root','root','2024-09-24 09:01:30','2024-09-24 09:01:30'),
(220,'keIPGHjHVKDrUj','tresipy1989@gmail.com','2393305441',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo220','root','root','2024-10-08 13:32:34','2024-10-08 13:32:34'),
(221,'LzZIfDzIu','sadiyausman54@yahoo.com','5451473389',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo221','root','root','2024-10-15 01:08:04','2024-10-15 01:08:04'),
(222,'wwARNoInZce','geilakline115@gmail.com','6906165547',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo222','root','root','2024-10-19 22:33:20','2024-10-19 22:33:20'),
(223,'krJiCxqOxffWQfA','wapcosmumbai@yahoo.com','7344486604',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo223','root','root','2024-10-27 09:04:03','2024-10-27 09:04:03'),
(224,'RzPXnHRScCkRf','mvospoi@gmail.com','8950042392',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo224','root','root','2024-11-01 10:36:11','2024-11-01 10:36:11'),
(225,'teiwIvDXJm','watersrastys3570@gmail.com','5368508604',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo225','root','root','2024-11-05 02:59:57','2024-11-05 02:59:57'),
(226,'Paulo Cesar Gomes da Silva','paulopecegos@bol.com.br',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'RJ','Brasil',341,0,0,0,0,0,'127.0.0.1','condo226','root','root','2024-12-09 14:04:05','2024-12-09 14:04:05');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `uf` varchar(2) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES
('AC','Acre','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('AL','Alagoas','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('AM','Amazonas','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('AP','Amapá','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('BA','Bahia','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('CE','Ceará','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('DF','Distrito Federal','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('ES','Espírito Santo','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('GO','Goiás','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('MA','Maranhão','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('MG','Minas Gerais','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('MS','Mato Grosso do Sul','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('MT','Mato Grosso','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('PA','Pará','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('PB','Paraíba','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('PE','Pernanbuco','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('PI','Piauí','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('PR','Paraná','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('RJ','Rio de Janeiro','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('RN','Rio Grande do Norte','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('RO','Rondônia','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('RR','Roraima','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('RS','Rio Grande do Sul','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('SC','Santa Catarina','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('SE','Sergipe','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('SP','São Paulo','2020-02-14 20:05:46','2020-02-14 20:05:46'),
('TO','Tocantins','2020-02-14 20:05:46','2020-02-14 20:05:46');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs_bkp`
--

DROP TABLE IF EXISTS `failed_jobs_bkp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs_bkp` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs_bkp`
--

LOCK TABLES `failed_jobs_bkp` WRITE;
/*!40000 ALTER TABLE `failed_jobs_bkp` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs_bkp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `value` date NOT NULL,
  `refnumber` varchar(255) DEFAULT NULL,
  `status` enum('paid','unpaid','canceld') DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_subscription_id_foreign` (`subscription_id`),
  CONSTRAINT `invoices_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2013_10_14_230018_create_empresas_table',1),
(2,'2014_10_12_000000_create_users_table',1),
(3,'2014_10_12_100000_create_password_resets_table',1),
(4,'2014_11_28_173404_alter_users_table_tenant',1),
(5,'2018_10_24_013745_create_uploads_table',1),
(6,'2018_10_28_173404_alter_users_table_subscriptions',1),
(7,'2018_10_28_173405_create_cards_table',1),
(8,'2018_10_28_173419_create_plans_table',1),
(9,'2018_10_28_173429_create_subscriptions_table',1),
(10,'2018_10_28_173439_create_invoices_table',1),
(11,'2018_10_28_173458_create_payments_table',1),
(12,'2018_10_31_000000_create_examples_table',1),
(13,'2019_12_19_231951_create_proprietarios_table',1),
(14,'2020_01_22_201446_create_estados_table',1),
(15,'2020_03_20_215633_create_jobs_table',2),
(16,'2020_03_20_221851_create_failed_jobs_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES
('systems.pegasus@gmail.com','$2y$10$Fuv4Ojk//dkwWs2UIxh0T.mCx6GvCPvCf3G7JgCn6Vj34vlYSBZsq','2020-04-10 14:21:11'),
('admin@condominiosonhodourado.com.br ','$2y$10$ubzhUw6zS/cimoLnl2M9pOvGUDMLXWbuv3OkkX7W/J5NY9YR7V/xK','2021-06-11 11:44:21'),
('mjvamorim@gmail.com','$2y$10$EHgHVcJPXzY0tH6XTbylZu2KLBfJ2cunGiUXhWZJECUIQipwlZ87m','2022-06-27 18:47:13'),
('lcharleent2k8o4le3@outlook.com','$2y$10$I7Bku4FLbcj2DJSjFv2Oc.yd5hp951zBm2TNpUQhE1lBnK5mWlTiW','2022-10-05 08:18:54'),
('sazjopusef@outlook.com','$2y$10$CFcbY7GRRxUZCZHlQwgL4utt9GaFxPjUY1SHmp2IkghpPT8xfu/N.','2022-11-11 23:07:12'),
('yupnecihil@outlook.com','$2y$10$J.sS8Bh6bQ6BWLXiOJRCUOVdRbCqQAvtsCVxkkcv.jjE8jhaSFasa','2022-11-23 06:06:02'),
('elianebalera@hotmail.com','$2y$10$rDUgQSFo1LOB7fzRlisvVeEP/6LGRmRjLTatHWGcV4H4XE6n6CMYC','2024-01-09 10:37:53'),
('stenrossyk@gmail.com','$2y$10$w5Jp5.Kt2OHmDzSpJ8RFBORIOY6eCIbfc.0hZ6h7tqhlSvYhHoqRW','2024-08-08 10:38:20');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(10) unsigned NOT NULL,
  `card_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `value` double(8,2) NOT NULL,
  `refnumber` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_invoice_id_foreign` (`invoice_id`),
  KEY `payments_card_id_foreign` (`card_id`),
  CONSTRAINT `payments_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`),
  CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `refnumber` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proprietarios`
--

DROP TABLE IF EXISTS `proprietarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proprietarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(30) NOT NULL,
  `fixo` varchar(30) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `rua` varchar(60) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `complemento` varchar(60) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `pais` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proprietarios`
--

LOCK TABLES `proprietarios` WRITE;
/*!40000 ALTER TABLE `proprietarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `proprietarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `plan_id` int(10) unsigned NOT NULL,
  `start_at` date NOT NULL,
  `end_at` date DEFAULT NULL,
  `charge_day` int(11) NOT NULL,
  `trialdays` int(11) DEFAULT 0,
  `status` enum('active','inactive','delayed','ontrial') NOT NULL DEFAULT 'inactive',
  `refnumber` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_user_id_foreign` (`user_id`),
  KEY `subscriptions_plan_id_foreign` (`plan_id`),
  CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  `resized_name` text NOT NULL,
  `original_name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `empresa_id` int(10) unsigned DEFAULT NULL,
  `nivel` int(11) NOT NULL DEFAULT 9,
  `type` varchar(255) DEFAULT 'User',
  `refnumber` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Mauricio Amorim','mjvamorim@gmail.com','2020-04-02 21:41:16','$2y$10$HHDbLNfvNnYMHSW4Xt/6l.Htu97VNwskzIWWMpe5z.UCjIfVtRyW6','EANFlg6jnP7bwPHJadmyXoSI6GM9KZnGogG1KexgmNQhFaeW9dAm3aJuzLZa','2020-02-14 20:08:28','2020-04-02 21:41:16',NULL,'',1,9,'Admin',NULL),
(2,'Pelincão','pelincao@yahoo.com.br','2021-01-01 00:00:00','$2y$10$Xe0EaG6eGYB1veLO/Y56Cec0pky9GILIU/A8ZoUGsxyBQHZbvv.5C','ToQkoJQEq97VG0ZUHLsJUvtQdP55SEcO2owMBnPVNpudwQL3ytwPhyp2VYRM','2020-02-14 20:13:15','2021-11-29 15:19:32','','',2,9,'User',NULL),
(3,'Sonho Dourado','admin@condominiosonhodourado.com.br ','2020-04-02 14:12:09','$2y$10$6S3G.EIbctg44S3w1i3c5e9XkXhF6m7m0YlGu7xEsJ7iuvi2GNR7W','Ydfs4QV0pwhnjXb23A9xunR5qS95cMyimCibhEPS0PzvLQwQwnDTQCt24TP7','2020-02-19 21:31:29','2020-04-02 14:12:09','','',3,9,'User',NULL),
(4,'eCondominio-teste','teste@econdominio.net','2020-04-06 02:52:19','$2y$10$xwitXdus29Tm8ktV1olW0uk094lnE2Fv8aZf9OxdnMxd0HEGWQLk.','qA5jqgiVwre0PuUaADQRyLaBn7wSVUoYJpL1HmCc9fjT6qGyjG69BOCQHdaz','2020-04-06 02:51:14','2020-04-10 14:25:52','(022)99999-9999',NULL,4,9,'User',NULL),
(5,'Morada da Baronesa','morada.baronesa@gmail.com','2020-08-14 12:00:00','$2y$10$9FORWCZxXkCayvlnM8WBk.gjFwBkJPHxV5QpYfHggh/C0fBwzAQue','jbvoNXJGtAXSPJ7p6Pc1LigjozXejR7wnaZErcSwy5A0mDkeCPLdHeQrOUp3','2021-08-15 15:46:01','2021-08-15 16:06:50','(022)99851-2288',NULL,5,9,'User',NULL),
(6,'Luiz Galdino','luiz.galdino@tecnoil.com.br','2020-04-14 16:59:20','$2y$10$jw9iRvu2TUONisxCvdv96em4zzvVlDdsPRTl5040rsIvP9jukQ9K.',NULL,'2020-04-14 16:58:38','2020-04-15 23:50:19','21981287901',NULL,6,9,'User',NULL),
(7,'Emerson de Carvalho Paz','emersoncpaz@gmail.com','2020-04-20 20:02:47','$2y$10$E2jlZG3dOjq4I.Uz4iFE7eUmeqhdSBlmQNG3V3AeCuTFpK34fBl86',NULL,'2020-04-20 20:02:24','2020-04-20 20:02:47','81981816655',NULL,7,9,'User',NULL),
(8,'Sonho Dourado Consulta','consulta@condominiosonhodourado.com.br','2020-11-01 12:00:00','0GnBINu5ocny2','aWHBy6i5e2Pk41LabaCeSz1c27bGCEe06tbFMBMkxYhRxJGpCJGNsbyxvTk4','2020-04-23 02:04:03','2020-04-23 02:04:03','8139720106',NULL,3,1,'User',NULL),
(9,'José Geovanio do Nascimento Brito','geovanio.nascimento85@gmail.com','2020-04-12 00:29:18','$2y$10$huern6KhF9tgkuEpHVBHTuK9XSxBhyoXSE00mY.0RVqqmEQCjXdpS','6jxIllpqbpeaAyUVPub2I5J17fWLF8dcHt36O0pSjfcItWpzpFEwl09JGMiV','2020-04-12 00:28:58','2020-04-12 00:29:18','82 96525698',NULL,9,9,'User',NULL),
(10,'Anna Leticia Martins','anna.openparts1@gmail.com','2020-06-04 21:08:05','$2y$10$7pHuvjmdUaekSpNBksv4JuY2QjWJwO6Fw00t8Hf/k7fc7Z.lTDSB.','odHkVlewabwKteKthJbbPXSJdH2DAKw4DEgIQwIPmOlXJQVuXhuPUrmjoz7K','2020-06-04 21:07:10','2020-06-04 21:08:05','981223977',NULL,10,9,'User',NULL),
(11,'Tamires Dos Prazeres Barbosa','tamy_pb07@hotmail.com','2020-06-07 22:29:16','$2y$10$PSIFkmZT4s610.hXfiAG/eDUj.J0bfxxshozfgQ.nps0IqSbuO4UO',NULL,'2020-06-07 22:28:54','2020-06-07 22:29:16','81977306846',NULL,11,9,'User',NULL),
(12,'Jose Tobias de Freitas','jtfreitas42@gmail.com','2020-11-21 14:06:36','$2y$10$gaEGLeUxsU71sjvit4g9feV.k4uQD3QQtyuh7jP6Mo3.AV7SBJ8MK',NULL,'2020-11-21 14:05:50','2020-11-21 14:06:36','61981573821',NULL,44,9,'User',NULL),
(13,'André Mott Fernandez','vendasobambu@gmail.com','2020-06-17 02:37:55','$2y$10$1/iOQW.5c1wMx7sA6VrMIuwBMjdEZQeNlsHop2N2Bxx0BMwP0P9XK',NULL,'2020-06-17 02:37:22','2020-06-17 02:37:55','44998855000',NULL,13,9,'User',NULL),
(14,'Nancy Ferreira Macedo Bellio','nancymf.nancy@gmail.com','2021-06-24 16:04:12','$2y$10$ppMcCvvCZEW5NAGyehGT1eerCb0pmdeSvFWR9qa5IdOBIXO41MCmm',NULL,'2021-06-24 16:03:22','2021-06-24 16:04:12','11 976436550',NULL,69,9,'User',NULL),
(15,'Paulo Verzbickas Neto','paulo.verzbickas@hotmail.com','2020-06-18 21:30:59','$2y$10$uc3p9UAi9H5ZPQFpIhcdPOYA77MTdMnEvrw6/Mj/QR8UXEf3wgQuu','tUEW99Ywvgj2sPcbTThmCaFcCG2FVFmK6j5q8iEOQMZGfVcUNkn4uBMwnSqT','2020-06-18 21:30:23','2020-06-18 21:30:59','11994817284',NULL,15,9,'User',NULL),
(16,'Juliano Santiago','julianosantiago.contato@gmail.com','2021-06-25 12:14:03','$2y$10$ER0yPBhqbcSLj/Tf9aWCP.ze1gwSqU1uwMpyUr4pHIq/Bi4rzU5gG',NULL,'2021-06-25 12:13:28','2021-06-25 12:14:03','92992928899',NULL,70,9,'User',NULL),
(17,'Verônica dos Santos','veronicaadm21@gmail.com','2020-06-22 13:11:10','$2y$10$tawqjARaQvWHON1rKIbVgusdfKtWnHFb.sKFJjHlmXNtBTpnkBJku','IKf6mKQGsvTnIb7pGTMugl7V1s3qTk9Mysc9UDjmxeltEiOaxDMntoF5E6RD','2020-06-22 13:08:49','2020-06-22 13:11:10','4498836334',NULL,17,9,'User',NULL),
(18,'Alexis Saad Filho','alexissaad7@gmail.com','2021-07-07 14:07:33','$2y$10$nlPiiD2H.dzY6k1dzHCHDueyuxzt5KikrzNUijP3RI5Fcxa6xv.da',NULL,'2021-07-07 14:07:12','2021-07-07 14:07:33','11984735755',NULL,72,9,'User',NULL),
(19,'Catia Cilene','condominiomacedo2021@gmail.com','2021-11-16 23:18:35','$2y$10$YOWV2n1u7lZzlP.SQ2UU5OFKIsdStVnpET4KDCFFiyVvO2FVorpQi',NULL,'2021-11-16 23:15:18','2021-11-16 23:18:35','11947285342',NULL,89,9,'User',NULL),
(20,'Karla Rahmann','karlacomex@hotmail.com','2021-12-11 18:50:58','$2y$10$r37RCprFe/4wTEKYWf1mReHweosdtp6pDIGhZyrerK6CKMIGO3SVO',NULL,'2021-12-11 18:49:00','2021-12-11 18:50:58','11 993553459',NULL,93,9,'User',NULL),
(21,'Julio Cesar de Sousa Nunes','julio.cesar.nunes@gmail.com','2022-01-27 11:40:01','$2y$10$nV6DiSuwm8HRBTzON2vxyuVPS1qYLXWzZsvXThq.9w9ChWXzNVWXq','RGbk0GY0vMVbBYb1h3v3SiBQUCZqgRUmAscasDUUC0XhBKDD0FP8Odfy1Lrv','2022-01-27 11:39:47','2022-01-27 11:40:01','11986549212',NULL,101,9,'User',NULL),
(114,'Carlos Alberto de Souza','calberto1957@icloud.com','2022-04-19 14:24:09','$2y$10$Ag5cMvmGi8dzdacd8a.h9.hKgLPQk7SazXg1t8gNwAny7EHKRTO4y','kY3ZPHO1GFjodErxe8RvSmMSR3CrlWVWeDo5kbkZKSjhMHiKuVpB3K8MUMti','2022-04-19 14:23:44','2022-04-19 14:24:09','11976231349',NULL,114,9,'User',NULL),
(116,'Vitor martello','vitormartello@hotmail.com','2022-05-05 13:22:26','$2y$10$8Cx.CoNLg2Q6gLqMZ9HYfe8uiCPLYNzovPZpgmXBH3yfC.kzmTkkC',NULL,'2022-05-05 13:22:07','2022-05-05 13:22:26','11971506764',NULL,116,9,'User',NULL),
(122,'Luiza Rocha','luiza.rrocha@hotmail.com','2022-06-03 20:47:10','$2y$10$ATO8PvJvzcr8DyidtIzP3.GJ/xyvSJgqmYqmXBYp039yFzy4YCEqy',NULL,'2022-06-03 20:46:12','2022-06-03 20:47:10','11972585456',NULL,122,9,'User',NULL),
(126,'Thiago Valdes Paretti','thiago.paretti@gmail.com','2022-06-21 14:07:23','$2y$10$ShQ1qoWej8VclWO19Wu13.XSAX/xjZw9qbnu8cip4MckP6BVXgZsW','xVwYtxSVojfM7OCv62MJJb0vRcd0Ck3bs0bwkS7FVFWxGZ1CrLF1LCkYovun','2022-06-21 14:07:05','2022-06-21 14:07:23','11945222353',NULL,126,9,'User',NULL),
(138,'Isabela Barbosa Tenuta Daniel','isabelatenuta@gmail.com','2022-09-21 23:10:04','$2y$10$lD0okAhRkmAqnV3alb7uGe5nTTcXCeNH6B0YGZ66th1OX0fqxT7am',NULL,'2022-09-21 23:08:05','2022-09-21 23:10:04','11948491256',NULL,138,9,'User',NULL),
(158,'Jose Sinforiano Soares Rocha','josoaresro@outlook.com','2022-12-07 00:01:52','$2y$10$gGgvPuzXfWtHJfTu91Rs0edrQVbrAIcid64LqGVCafhV2xbPLlOQu','kq9GqdkNWZCyG3djrorSX6EQVUKeCEyEi1O7Nyk7gUkxIg21oElGRwr7Wuv2','2022-12-04 21:00:24','2022-12-07 00:01:52','11998322635',NULL,158,9,'User',NULL),
(165,'ELISIANE JOSETE HEBERLE SEBASTIANY','elisianeoncologia@gmail.com','2023-01-26 00:33:31','$2y$10$KYhGEiJvWXBWCBmEQPEhqeCXN6RzE4m6X4vRnLu3ocBKNNY.V6I8a',NULL,'2023-01-26 00:33:02','2023-01-26 00:33:31','42999044421',NULL,165,9,'User',NULL),
(167,'Ingrid Miranda','ingrid.miranda717@gmail.com','2023-02-07 16:37:06','$2y$10$oJMp/iiP9EIGBZ4/SbP4J.tx9IORk6m.iV.CRSxZXTx3btGE9NTnO','Cdn6HznaBN52mrMzu1Gi2ghz4RbW5Ijp4qxOlDYsu1G5se3URnRy0ZUGCA0F','2023-02-07 16:35:06','2023-02-07 16:37:06','11941008594',NULL,167,9,'User',NULL),
(170,'ANTONIO MARCOS M SILVA','cond.gardenia.adm@gmail.com','2023-05-18 21:03:31','$2y$10$JxyWfWdKe/k66cQIEcp1tuHpuSNo.j7QdnR29bCOycUHUw9.FUJkW','gPQmyhY9kvl7q6XoCZWLRep8zuFhl4rca9UZGKPL4nn9VPSydXE0Ld6CYzf2','2023-05-18 21:03:05','2023-05-18 21:03:31','84920019487',NULL,170,9,'User',NULL),
(173,'Elton Carlos','moxok81018@wanbeiz.com','2023-10-26 18:27:13','$2y$10$7pbFJA7Qt95BfMuIvz2xiutqOlQHid3X/tccgC4xSOu7L.si027KS',NULL,'2023-10-26 18:26:57','2023-10-26 18:27:13','11940483636',NULL,173,9,'User',NULL),
(193,'Patrícia Mendes Iglesias França','patricia.iglesias@uol.com.br','2024-04-30 16:50:41','$2y$10$KGwIwXg6oG/fcGN9oV9aTe1/rSVjNjlsTNF/xywYJwtXSuTD9TDQ.',NULL,'2024-04-30 16:50:10','2024-04-30 16:50:41','11972531377',NULL,193,9,'User',NULL),
(208,'Juliana Cristina Prest','juliana.prest@gmail.com','2024-07-27 01:52:32','$2y$10$b5f0t1st.qG2oTeHBfL4OuzBj1qWRdV1ceLbhaV.Q8lQqZJLxGyly',NULL,'2024-07-27 01:52:06','2024-07-27 01:52:32','27992990305',NULL,208,9,'User',NULL),
(212,'KSNVGLtRhYov','lisalr_brantleykd@outlook.com',NULL,'$2y$10$ml1NdJdEeBdGb6Fm2ZZtRuZaiM9wVhSSRj2hNDUex65YU1OLsV9mW',NULL,'2024-08-19 19:47:55','2024-08-19 19:47:55','5342258043',NULL,212,9,'User',NULL),
(213,'dRFVlyNCksrqO','rodriguezvalerie1990@yahoo.com',NULL,'$2y$10$AJ58hkHySBhB0dssyqHKxO43KWntS2yZekD6PwGijGgfYZ3sT4ju6',NULL,'2024-08-25 21:58:52','2024-08-25 21:58:52','6943780747',NULL,213,9,'User',NULL),
(214,'fdGLvxNCQylkSbs','djaneiyv22@gmail.com',NULL,'$2y$10$.Q1fN2uXvS/C.P.v0VsUauNucciBvURWot1FXAN761DXeRoJWJzwW',NULL,'2024-08-28 23:11:42','2024-08-28 23:11:42','5856292443',NULL,214,9,'User',NULL),
(215,'AltkVWSXQTfv','jacquelyn_green0khe@outlook.com',NULL,'$2y$10$yyWMJuwpMM8NoRovlzduE.QTFZmZZYzO/acsGNA9K5C97jiHVF3Iy',NULL,'2024-09-06 20:26:43','2024-09-06 20:26:43','4766581273',NULL,215,9,'User',NULL),
(216,'lCmqAPxw','reinercortezea1993@gmail.com',NULL,'$2y$10$eod5qqTae8zxOJtBY1jdsOyAgs7Zox73.isZn47imUhoAwNGEkrZu',NULL,'2024-09-12 23:11:13','2024-09-12 23:11:13','6251505093',NULL,216,9,'User',NULL),
(217,'yDocfNgZSv','rkabisat@yahoo.com',NULL,'$2y$10$QE2MhxPxtlOtVO5Vm8oE4uQJrcVYTGuJiG1fz0vEraif5Qm7ro6vu',NULL,'2024-09-20 04:38:22','2024-09-20 04:38:22','4444112811',NULL,217,9,'User',NULL),
(218,'LsjQxqGzRtI','donaldt7_houfx@outlook.com',NULL,'$2y$10$fgJMI31Q.qhiIodIqLiBUOL2wLCoDqJRnFOg2SSTb9g.jS1c.AfXO',NULL,'2024-09-23 05:56:25','2024-09-23 05:56:25','4069396808',NULL,218,9,'User',NULL),
(219,'grupo1','josedvpinho@gmail.com','2024-09-24 09:04:01','$2y$10$dbS/TJ/Wd5N6FvGUdEzwieZzKLE.8lTyF6HjACRz3DWiTBPnlTE1y','gEp0mLYchSE8ig8h4TLcGAhC3hPbB2H89DZU0teqQTNYCA2ZOjeVNNdIhSAT','2024-09-24 09:01:30','2024-09-24 09:04:01','962846536',NULL,219,9,'User',NULL),
(220,'keIPGHjHVKDrUj','tresipy1989@gmail.com',NULL,'$2y$10$qs.cYMq45lpJk.NYXRSr.uj/rHEK/ZsG05CiEoFY/ZzBYbV0Yc4Ge',NULL,'2024-10-08 13:32:34','2024-10-08 13:32:34','2393305441',NULL,220,9,'User',NULL),
(221,'LzZIfDzIu','sadiyausman54@yahoo.com',NULL,'$2y$10$R2PhF7nRrnto1Eda3ton0OzoYZW0kM6OTUenzN7OZ4WlJsfG2ySXu',NULL,'2024-10-15 01:08:04','2024-10-15 01:08:04','5451473389',NULL,221,9,'User',NULL),
(222,'wwARNoInZce','geilakline115@gmail.com',NULL,'$2y$10$2WYwdAsvFvYxFJyqT.9.vu/xjQLj92xrKHy2RCuXkUWjFgliBJdCO',NULL,'2024-10-19 22:33:20','2024-10-19 22:33:20','6906165547',NULL,222,9,'User',NULL),
(223,'krJiCxqOxffWQfA','wapcosmumbai@yahoo.com',NULL,'$2y$10$vXFaNiueme/K/dhJyhXt5.AaQh7OWb7d8viWTxzSSQrTYtrh2APae',NULL,'2024-10-27 09:04:04','2024-10-27 09:04:04','7344486604',NULL,223,9,'User',NULL),
(224,'RzPXnHRScCkRf','mvospoi@gmail.com',NULL,'$2y$10$aZEZPuGfzQt25lQuamNdde9Tm6npqOVGsgtoEclF/QII56tvpwK6.',NULL,'2024-11-01 10:36:11','2024-11-01 10:36:11','8950042392',NULL,224,9,'User',NULL),
(225,'teiwIvDXJm','watersrastys3570@gmail.com',NULL,'$2y$10$n2H1P1upBJPo53D9BTGFDej1o3k1LJqzYmeWy4cpsoOnFBP2PpAZm',NULL,'2024-11-05 02:59:57','2024-11-05 02:59:57','5368508604',NULL,225,9,'User',NULL),
(226,'Paulo Cesar Gomes da Silva','paulopecegos@bol.com.br','2024-12-09 14:06:16','$2y$10$CKPlc5pHQLzPuW2gqf.gE.w..0BcYdtqJ9pa5HOmhWL9S2GBFIndy',NULL,'2024-12-09 14:04:05','2024-12-09 14:06:16',NULL,NULL,226,9,'User',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-05-12 19:40:38
