-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 25-10-2014 a las 00:38:36
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
CREATE DATABASE IF NOT EXISTS `grupo_45` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `grupo_45`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

DROP TABLE IF EXISTS `alimento`;
CREATE TABLE IF NOT EXISTS `alimento` (
  `codigo` varchar(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`codigo`, `descripcion`) VALUES
('aaaa', 'Yerba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_donante`
--

DROP TABLE IF EXISTS `alimento_donante`;
CREATE TABLE IF NOT EXISTS `alimento_donante` (
  `cantidad` int(11) DEFAULT NULL,
  `donante_Id` int(11) NOT NULL DEFAULT '0',
  `detalle_alimento_Id` int(11) NOT NULL,
  PRIMARY KEY (`donante_Id`,`detalle_alimento_Id`),
  KEY `fk_alimento_donante_detalle_alimento1_idx` (`detalle_alimento_Id`),
  KEY `donante_Id` (`donante_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_entrega_directa`
--

DROP TABLE IF EXISTS `alimento_entrega_directa`;
CREATE TABLE IF NOT EXISTS `alimento_entrega_directa` (
  `entrega_directa_id` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`entrega_directa_id`,`detalle_alimento_id`),
  KEY `fk_alimento_entrega_directa_2_idx` (`detalle_alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_pedido`
--

DROP TABLE IF EXISTS `alimento_pedido`;
CREATE TABLE IF NOT EXISTS `alimento_pedido` (
  `pedido_numero` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`pedido_numero`,`detalle_alimento_id`),
  KEY `fk_alimento_pedido_2_idx` (`detalle_alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(45) DEFAULT NULL,
  `valor` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_alimento`
--

DROP TABLE IF EXISTS `detalle_alimento`;
CREATE TABLE IF NOT EXISTS `detalle_alimento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_vencimiento` date DEFAULT NULL,
  `contenido` varchar(200) DEFAULT NULL,
  `peso_unitario` decimal(6,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `reservado` int(11) DEFAULT NULL,
  `alimento_codigo` varchar(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `alimento_codigo` (`alimento_codigo`),
  KEY `alimento_codigo_2` (`alimento_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `detalle_alimento`
--

INSERT INTO `detalle_alimento` (`Id`, `fecha_vencimiento`, `contenido`, `peso_unitario`, `stock`, `reservado`, `alimento_codigo`) VALUES
(1, '2014-09-02', '10x1kg', '1.00', 100, 10, 'aaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

DROP TABLE IF EXISTS `donante`;
CREATE TABLE IF NOT EXISTS `donante` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) DEFAULT NULL,
  `apellido_contacto` varchar(50) DEFAULT NULL,
  `nombre_contacto` varchar(50) DEFAULT NULL,
  `telefono_contacto` varchar(30) DEFAULT NULL,
  `mail_contacto` varchar(50) DEFAULT NULL,
  `domicilio_contacto` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `donante`
--

INSERT INTO `donante` (`Id`, `razon_social`, `apellido_contacto`, `nombre_contacto`, `telefono_contacto`, `mail_contacto`, `domicilio_contacto`) VALUES
(1, 'Donante1', 'apellido1', 'nombre', '12345', 'loscalzo@hotmail.com', 'asdfg'),
(3, 'Donante2', 'asdfg', 'asdg', '1234', 'asdf@asdf', '                                        asdf\r\n                '),
(4, 'Donante3', 'asdfg', 'asdg', '1234', 'asdf@asdf', '                                        asdf\r\n                ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_receptora`
--

DROP TABLE IF EXISTS `entidad_receptora`;
CREATE TABLE IF NOT EXISTS `entidad_receptora` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `domicilio` varchar(200) DEFAULT NULL,
  `estado_entidad_Id` int(11) NOT NULL,
  `necesidad_entidad_Id` int(11) NOT NULL,
  `servicio_prestado_Id` int(11) NOT NULL,
  `latitud` varchar(15) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`,`estado_entidad_Id`,`necesidad_entidad_Id`,`servicio_prestado_Id`),
  KEY `fk_entidad_receptora_estado_entidad_idx` (`estado_entidad_Id`),
  KEY `fk_entidad_receptora_necesidad_entidad1_idx` (`necesidad_entidad_Id`),
  KEY `fk_entidad_receptora_servicio_prestado1_idx` (`servicio_prestado_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `entidad_receptora`
--

INSERT INTO `entidad_receptora` (`Id`, `razon_social`, `telefono`, `domicilio`, `estado_entidad_Id`, `necesidad_entidad_Id`, `servicio_prestado_Id`, `latitud`, `longitud`) VALUES
(2, 'Comedor Berisso', '12413', '41234', 2, 2, 1, NULL, NULL),
(5, 'aasdf', '123123', 'zxcvsadf', 2, 1, 2, NULL, NULL),
(9, 'asdfasdf', '1234', '1234asdf', 3, 1, 2, NULL, NULL),
(10, 'asdfasdg', '123', '4213', 3, 1, 1, NULL, NULL),
(11, 'perra', '123', 'aouaoui', 2, 1, 1, NULL, NULL),
(12, '123456', '12355', '4123', 2, 2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_directa`
--

DROP TABLE IF EXISTS `entrega_directa`;
CREATE TABLE IF NOT EXISTS `entrega_directa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_entrega_directa_1_idx` (`entidad_receptora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_entidad`
--

DROP TABLE IF EXISTS `estado_entidad`;
CREATE TABLE IF NOT EXISTS `estado_entidad` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `estado_entidad`
--

INSERT INTO `estado_entidad` (`Id`, `descripcion`) VALUES
(1, 'alta'),
(2, 'tramite'),
(3, 'suspendida'),
(4, 'baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

DROP TABLE IF EXISTS `estado_pedido`;
CREATE TABLE IF NOT EXISTS `estado_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `necesidad_entidad`
--

DROP TABLE IF EXISTS `necesidad_entidad`;
CREATE TABLE IF NOT EXISTS `necesidad_entidad` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `necesidad_entidad`
--

INSERT INTO `necesidad_entidad` (`Id`, `descripcion`) VALUES
(1, 'maxima'),
(2, 'mediana'),
(3, 'minima');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_modelo`
--

DROP TABLE IF EXISTS `pedido_modelo`;
CREATE TABLE IF NOT EXISTS `pedido_modelo` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estado_pedido_id` int(11) DEFAULT NULL,
  `turno_entrega_id` int(11) DEFAULT NULL,
  `con_envio` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`numero`),
  KEY `fk_pedido_model_1_idx` (`entidad_receptora_id`),
  KEY `fk_pedido_model_2_idx` (`estado_pedido_id`),
  KEY `fk_pedido_model_3_idx` (`turno_entrega_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `roleID` int(11) NOT NULL AUTO_INCREMENT,
  `roleuser` varchar(20) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`roleID`, `roleuser`, `description`) VALUES
(1, 'Administrador', 'Todas las funciones del sistem'),
(2, 'Gestion', 'Solo pedidos y entregas.'),
(3, 'Consulta', 'Listar alimentos en stock');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_prestado`
--

DROP TABLE IF EXISTS `servicio_prestado`;
CREATE TABLE IF NOT EXISTS `servicio_prestado` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `servicio_prestado`
--

INSERT INTO `servicio_prestado` (`Id`, `descripcion`) VALUES
(1, 'hogar de dia'),
(2, 'comedor infantil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_entrega`
--

DROP TABLE IF EXISTS `turno_entrega`;
CREATE TABLE IF NOT EXISTS `turno_entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `roleID` int(11) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `roleID_2` (`roleID`),
  KEY `roleID` (`roleID`),
  KEY `roleID_3` (`roleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Deberia hash contraseña' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`userID`, `username`, `pass`, `roleID`) VALUES
(1, 'admin1', '123456', 1),
(2, 'gestion1', '123456', 2),
(3, 'consulta1', '123456', 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimento_donante`
--
ALTER TABLE `alimento_donante`
  ADD CONSTRAINT `fk_alimento_donante_detalle_alimento1` FOREIGN KEY (`detalle_alimento_Id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alimento_donante_donante1` FOREIGN KEY (`donante_Id`) REFERENCES `donante` (`Id`);

--
-- Filtros para la tabla `alimento_entrega_directa`
--
ALTER TABLE `alimento_entrega_directa`
  ADD CONSTRAINT `fk_alimento_entrega_directa_1` FOREIGN KEY (`entrega_directa_id`) REFERENCES `alimento_pedido` (`pedido_numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alimento_entrega_directa_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `alimento_pedido`
--
ALTER TABLE `alimento_pedido`
  ADD CONSTRAINT `fk_alimento_pedido_1` FOREIGN KEY (`pedido_numero`) REFERENCES `pedido_modelo` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alimento_pedido_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
  ADD CONSTRAINT `fk_alimento_codigo` FOREIGN KEY (`alimento_codigo`) REFERENCES `alimento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
  ADD CONSTRAINT `fk_entidad_receptora_estado_entidad` FOREIGN KEY (`estado_entidad_Id`) REFERENCES `estado_entidad` (`Id`),
  ADD CONSTRAINT `fk_entidad_receptora_necesidad_entidad1` FOREIGN KEY (`necesidad_entidad_Id`) REFERENCES `necesidad_entidad` (`Id`),
  ADD CONSTRAINT `fk_entidad_receptora_servicio_prestado1` FOREIGN KEY (`servicio_prestado_Id`) REFERENCES `servicio_prestado` (`Id`);

--
-- Filtros para la tabla `entrega_directa`
--
ALTER TABLE `entrega_directa`
  ADD CONSTRAINT `fk_entrega_directa_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
  ADD CONSTRAINT `fk_pedido_model_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_model_2` FOREIGN KEY (`estado_pedido_id`) REFERENCES `estado_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_model_3` FOREIGN KEY (`turno_entrega_id`) REFERENCES `turno_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_roleID` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
