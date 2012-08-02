-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.40-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema claudio_frouche
--

CREATE DATABASE IF NOT EXISTS comercio;
USE comercio;

--
-- Definition of table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria`
--

/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`id`,`nome`,`delete_date`) VALUES 
 (1,'Televisores',NULL),
 (2,'Livros',NULL);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;


--
-- Definition of table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cliente`
--

/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`id`,`username`,`password`,`email`,`endereco`,`nome`,`telefone`,`delete_date`) VALUES 
 (1,'anamaria','123456','lipsum@gmail.com','Rio de Janeiro','Ana Maria da Silva','11111111',NULL),
 (2,'antoniocarlos','123456','lipsum2@gmail.com','Rio de Janeiro','Antonio Carlos da Silva','11111111',NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;


--
-- Definition of table `fatura`
--

DROP TABLE IF EXISTS `fatura`;
CREATE TABLE `fatura` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `create_date` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fatura`
--

/*!40000 ALTER TABLE `fatura` DISABLE KEYS */;
INSERT INTO `fatura` (`id`,`create_date`,`status`,`update_date`) VALUES 
 (1,'2011-05-22 21:59:37',NULL,NULL),
 (2,'2011-05-22 22:04:28',NULL,NULL),
 (3,'2011-05-22 22:05:35',NULL,NULL),
 (4,'2011-05-22 22:08:55',NULL,NULL),
 (5,'2011-05-22 22:10:03',NULL,NULL),
 (6,'2011-05-22 22:28:52',NULL,NULL),
 (7,'2011-05-22 22:29:59',NULL,NULL),
 (8,'2011-05-22 22:31:13',NULL,NULL),
 (9,'2011-05-22 22:48:11',NULL,NULL),
 (10,'2011-05-22 22:56:52',NULL,NULL),
 (11,'2011-05-22 22:58:16',NULL,NULL),
 (12,'2011-05-22 23:00:29',NULL,NULL),
 (13,'2011-05-22 23:01:11',NULL,NULL),
 (14,'2011-05-22 23:06:53',NULL,NULL),
 (17,'2011-05-23 00:06:16',NULL,NULL),
 (18,'2011-05-23 22:19:06',NULL,NULL),
 (19,'2011-05-23 23:10:55',NULL,NULL),
 (20,'2011-05-23 23:12:51',NULL,NULL),
 (21,'2011-05-23 23:54:58',NULL,NULL),
 (22,'2011-05-24 00:07:07',NULL,NULL);
/*!40000 ALTER TABLE `fatura` ENABLE KEYS */;


--
-- Definition of table `item_pedido`
--

DROP TABLE IF EXISTS `item_pedido`;
CREATE TABLE `item_pedido` (
  `pedido_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produto_id` int(10) unsigned NOT NULL,
  `quantidade` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pedido_id`,`produto_id`) USING BTREE,
  KEY `FK_item_pedido_produto` (`produto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_pedido`
--

/*!40000 ALTER TABLE `item_pedido` DISABLE KEYS */;
INSERT INTO `item_pedido` (`pedido_id`,`produto_id`,`quantidade`) VALUES 
 (1,1,2),
 (3,4,2);
/*!40000 ALTER TABLE `item_pedido` ENABLE KEYS */;


--
-- Definition of table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_session` varchar(45) DEFAULT NULL,
  `id_cliente` int(10) unsigned DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `create_date` varchar(45) NOT NULL,
  `fatura_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedido`
--

/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` (`id`,`id_session`,`id_cliente`,`status`,`create_date`,`fatura_id`) VALUES 
 (1,'hn9emnj5ed9748nu1blk3feqa4',1,'FATURADO','2011-05-24 00:07:02',22),
 (2,NULL,1,'ABERTO','2011-05-24 00:07:02',NULL),
 (3,'pd5e4vnfmv2gsqbgrq093hc9t6',NULL,'ABERTO','2011-05-24 00:07:13',NULL);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;


--
-- Definition of table `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `categoria_id` int(10) unsigned DEFAULT NULL,
  `qtd_estoque` int(10) unsigned DEFAULT NULL,
  `descricao` longtext,
  `descricao_breve` varchar(100) DEFAULT NULL,
  `imagem` varchar(45) DEFAULT NULL,
  `is_disponivel` tinyint(1) DEFAULT '0',
  `preco` double(15,2) DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `create_time` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produto`
--

/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`id`,`nome`,`categoria_id`,`qtd_estoque`,`descricao`,`descricao_breve`,`imagem`,`is_disponivel`,`preco`,`delete_date`,`create_time`) VALUES 
 (1,'Panasonic TC-L32X2 32-Inch 720p LCD HDTV',1,8,'Televisor Lcd / 40 a 47','Televisor Lcd / 40 a 47','tv_1.jpg',1,1000.00,NULL,NULL),
 (2,'LG 42LD450 42-Inch 1080p 60 Hz LCD HDTV',1,6,'Televisor Lcd / 40 a 47','Televisor Lcd / 40 a 47','tv_2.jpg',1,600.00,NULL,NULL),
 (3,'Panasonic VIERA TC-P42G25 42-Inch 1080p Plasma HDTV',1,20,'Televisor Lcd / 40 a 47','Televisor Lcd / 40 a 47','tv_3.jpg',1,1300.00,NULL,NULL),
 (4,'The Red Queen',2,198,'Philippa Gregory’s enthralling new novel brings to life a proud and determined woman who believes that she alone is destined to shape the course of history.','Philippa Gregory’s enthralling new ..','imagem.jpg',1,16.90,NULL,NULL),
 (5,'Querido John - O que Você Faria com uma Carta que Mudasse Tudo?',2,200,'\"Querido John\" narra a história de um jovem soldado americano, John, que se apaixona por Savannah uma estudante conservadora. Quando Savannah Lynn Curtis entra em sua vida, John Tyree sabe que está pronto para começar de novo. ','Grande romance americano','imagem.jpg',1,16.80,NULL,NULL),
 (6,'Grande Dicionário Houaiss da Língua Portuguesa - Antigo Acordo Ortográfico',2,400,'Lançado em 2001, antes do Acordo Ortográfico, o \"Grande Dicionário Houaiss da Língua Portuguesa\" , embora não esteja adaptado às novas regras, apresenta a mais ampla seleção de verbetes já feita em nossa língua.','Lançado em 2001, antes do Acordo Ortográfico..','imagem.jpg',1,119.90,NULL,NULL);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;