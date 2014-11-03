-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2014 a las 15:43:16
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

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
-- Estructura para la vista `alimentosparaentregadirecta`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosparaentregadirecta` AS select `d`.`Id` AS `Id`,`d`.`fecha_vencimiento` AS `fecha_vencimiento`,`d`.`contenido` AS `contenido`,`d`.`peso_unitario` AS `peso_unitario`,`d`.`stock` AS `stock`,`d`.`reservado` AS `reservado`,`d`.`alimento_codigo` AS `alimento_codigo` from `detalle_alimento` `d` where (`d`.`fecha_vencimiento` between (now() + interval 1 day) and (now() + interval (select `fecha_configuracion`.`dias` from `fecha_configuracion`) day));

--
-- VIEW  `alimentosparaentregadirecta`
-- Datos: Ninguna
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
