-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.5.40 - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para pse
CREATE DATABASE IF NOT EXISTS `pse` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pse`;


-- Volcando estructura para tabla pse.banks
CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(4) NOT NULL,
  `bank_name` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pse.transaction_results
CREATE TABLE IF NOT EXISTS `transaction_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bankURL` varchar(255) DEFAULT NULL,
  `trazabilityCode` varchar(30) NOT NULL,
  `transactionCycle` int(11) NOT NULL,
  `transactionID` int(11) NOT NULL,
  `sessionID` varchar(30) NOT NULL,
  `bankCurrency` varchar(3) DEFAULT NULL,
  `bankFactor` float NOT NULL,
  `responseCode` int(11) NOT NULL,
  `responseReasonCode` varchar(3) NOT NULL,
  `responseReasonText` varchar(255) NOT NULL,
  `returnCode` varchar(30) NOT NULL,
  `reference` varchar(32) DEFAULT NULL,
  `type` varchar(30) NOT NULL,
  `transactionState` varchar(30) DEFAULT NULL,
  `requestDate` datetime DEFAULT NULL,
  `bankProcessDate` datetime DEFAULT NULL,
  `onTest` int(11) DEFAULT NULL,
  `xml_request` text,
  `xml_response` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
