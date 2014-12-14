-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-12-2014 a las 22:25:23
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo_45`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_receptora`
--

CREATE TABLE IF NOT EXISTS `entidad_receptora` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `domicilio` varchar(200) DEFAULT NULL,
  `estado_entidad_Id` int(11) NOT NULL,
  `necesidad_entidad_Id` int(11) NOT NULL,
  `servicio_prestado_Id` int(11) NOT NULL,
  `latitud` varchar(17) DEFAULT NULL,
  `longitud` varchar(17) DEFAULT NULL,
  PRIMARY KEY (`Id`,`estado_entidad_Id`,`necesidad_entidad_Id`,`servicio_prestado_Id`),
  KEY `fk_entidad_receptora_estado_entidad_idx` (`estado_entidad_Id`),
  KEY `fk_entidad_receptora_necesidad_entidad1_idx` (`necesidad_entidad_Id`),
  KEY `fk_entidad_receptora_servicio_prestado1_idx` (`servicio_prestado_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `entidad_receptora`
--

INSERT INTO `entidad_receptora` (`Id`, `razon_social`, `telefono`, `domicilio`, `estado_entidad_Id`, `necesidad_entidad_Id`, `servicio_prestado_Id`, `latitud`, `longitud`) VALUES
(24, 'Un Techo para mi pais', '221491222', '22 y 15 n 818', 1, 2, 1, '-34.9195315802940', '-57.9741730587921'),
(28, 'Caritas', '22151481', '48 y 5 811', 1, 1, 1, '-34.9128900255442', '-57.9402670765195');

--
-- Disparadores `entidad_receptora`
--
DROP TRIGGER IF EXISTS `entidad_receptora_before_delete`;
DELIMITER //
CREATE TRIGGER `entidad_receptora_before_delete` BEFORE DELETE ON `entidad_receptora`
 FOR EACH ROW BEGIN
/*
	Se elimina entidad receptora. Se borran todos los pedidos asociados.
	Ver si los pedidos fueron entregados.
	Se hace lo mismo que con turnos de entrega. Funciona igual
	se aumenta la reserva y esas cosas. 
*/

	declare id_old int(11) default OLD.Id;

	delete from pedido_modelo 
	where  entidad_receptora_id = id_old;
	
 END
//
DELIMITER ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
  ADD CONSTRAINT `fk_entidad_receptora_estado_entidad` FOREIGN KEY (`estado_entidad_Id`) REFERENCES `estado_entidad` (`Id`),
  ADD CONSTRAINT `fk_entidad_receptora_necesidad_entidad1` FOREIGN KEY (`necesidad_entidad_Id`) REFERENCES `necesidad_entidad` (`Id`),
  ADD CONSTRAINT `fk_entidad_receptora_servicio_prestado1` FOREIGN KEY (`servicio_prestado_Id`) REFERENCES `servicio_prestado` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
