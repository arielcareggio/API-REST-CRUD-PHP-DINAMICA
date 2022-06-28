-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.36 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para api_rest_crud_php_dinamica
CREATE DATABASE IF NOT EXISTS `api_rest_crud_php_dinamica` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `api_rest_crud_php_dinamica`;

-- Volcando estructura para tabla api_rest_crud_php_dinamica.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(45) NOT NULL,
  `ap_cliente` varchar(45) NOT NULL,
  `am_cliente` varchar(45) NOT NULL,
  `fn_cliente` date NOT NULL,
  `genero_cliente` char(1) NOT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `id_provincia_cliente` int(11) DEFAULT NULL,
  `date_created_cliente` date DEFAULT NULL,
  `date_updated_cliente` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_rest_crud_php_dinamica.clientes: ~4 rows (aproximadamente)
INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `ap_cliente`, `am_cliente`, `fn_cliente`, `genero_cliente`, `id_tipo_cliente`, `id_provincia_cliente`, `date_created_cliente`, `date_updated_cliente`) VALUES
	(1, 'Juan B', 'Rodrígez B', 'Paredes B', '2005-10-11', 'M', 1, 2, NULL, NULL),
	(2, 'Silvia A', 'Robles', 'Moreno', '1999-10-21', 'F', 2, 1, NULL, NULL),
	(8, 'Ariel', 'Antonio', 'Careggio', '1986-01-08', 'M', 1, 2, NULL, NULL),
	(9, 'Juan B', 'Rodrígez B', 'Paredes B', '2005-10-11', 'M', 2, 1, NULL, NULL);

-- Volcando estructura para tabla api_rest_crud_php_dinamica.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `id_cliente_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(255) NOT NULL DEFAULT '0',
  `date_created_provincia` date DEFAULT NULL,
  `date_updated_provincia` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente_provincia`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_rest_crud_php_dinamica.provincias: 3 rows
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` (`id_cliente_provincia`, `provincia`, `date_created_provincia`, `date_updated_provincia`) VALUES
	(1, 'Córdoba', NULL, NULL),
	(2, 'Buenos Aires', NULL, NULL),
	(3, 'Santa Fe', NULL, NULL);
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;

-- Volcando estructura para tabla api_rest_crud_php_dinamica.tipos
CREATE TABLE IF NOT EXISTS `tipos` (
  `id_cliente_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) DEFAULT NULL,
  `date_created_tipo` date DEFAULT NULL,
  `date_updated_tipo` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente_tipo`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla api_rest_crud_php_dinamica.tipos: 2 rows
/*!40000 ALTER TABLE `tipos` DISABLE KEYS */;
INSERT INTO `tipos` (`id_cliente_tipo`, `tipo`, `date_created_tipo`, `date_updated_tipo`) VALUES
	(1, 'Free', NULL, NULL),
	(2, 'Premium', NULL, NULL);
/*!40000 ALTER TABLE `tipos` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;



UPDATE clientes SET date_created_cliente = '2022-06-28' WHERE id_cliente = 1;
UPDATE clientes SET date_created_cliente = '2022-05-20' WHERE id_cliente = 2;
UPDATE clientes SET date_created_cliente = '2022-04-15' WHERE id_cliente = 3;
UPDATE clientes SET date_created_cliente = '2022-06-28' WHERE id_cliente = 4;

UPDATE clientes SET date_updated_cliente = '2022-05-22' WHERE id_cliente = 1;
UPDATE clientes SET date_updated_cliente = '2022-05-21' WHERE id_cliente = 2;
UPDATE clientes SET date_updated_cliente = '2022-04-17' WHERE id_cliente = 3;
UPDATE clientes SET date_updated_cliente = '2022-01-28' WHERE id_cliente = 4;


UPDATE provincias SET date_created_provincia = '2022-04-25' WHERE id_cliente_provincia = 1;
UPDATE provincias SET date_created_provincia = '2022-03-21' WHERE id_cliente_provincia = 2;
UPDATE provincias SET date_created_provincia = '2022-05-15' WHERE id_cliente_provincia = 3;

UPDATE provincias SET date_updated_provincia = '2022-05-25' WHERE id_cliente_provincia = 1;
UPDATE provincias SET date_updated_provincia = '2022-04-21' WHERE id_cliente_provincia = 2;
UPDATE provincias SET date_updated_provincia = '2022-06-15' WHERE id_cliente_provincia = 3;

UPDATE tipos SET date_created_tipo = '2022-04-15' WHERE id_cliente_tipo = 1;
UPDATE tipos SET date_created_tipo = '2022-06-21' WHERE id_cliente_tipo = 2;

UPDATE tipos SET date_updated_tipo = '2022-05-15' WHERE id_cliente_tipo = 1;
UPDATE tipos SET date_updated_tipo = '2022-06-23' WHERE id_cliente_tipo = 2;