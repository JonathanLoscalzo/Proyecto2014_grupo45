-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2014 a las 19:51:10
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
CREATE DATABASE IF NOT EXISTS `grupo_45` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `grupo_45`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `alimentos_por_entidad_entre_fechas`$$
CREATE DEFINER=`grupo_45`@`localhost` PROCEDURE `alimentos_por_entidad_entre_fechas`(
in fechaIni date,
in fechaFin date
)
begin
	-- Listado (entre fechas) de cada E.R y los kilos de alimento que le fueron entregados (gráfico de torta)
	select e.*, sum(d.peso_unitario * ap.cantidad) as kilogramos
	from entidad_receptora as e
	inner join 
	(
		select p1.* 
		from pedido_modelo as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p on p.entidad_receptora_id = e.Id
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by e.Id;

end$$

DROP PROCEDURE IF EXISTS `alimentos_por_fechas_entre`$$
CREATE DEFINER=`grupo_45`@`localhost` PROCEDURE `alimentos_por_fechas_entre`(
in fechaIni date,
in fechaFin date
)
begin
	-- Listado (entre fechas) de los kilos de alimento que fueron entregados (gráfico de torta)
	select p.fecha, sum(d.peso_unitario * ap.cantidad) as kilogramos
	from (
		select p1.*,t.fecha as fecha
		from pedido_modelo as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p 
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by p.fecha;
	

end$$

DROP PROCEDURE IF EXISTS `probando`$$
CREATE DEFINER=`grupo_45`@`localhost` PROCEDURE `probando`(
in fechaIni date,
in fechaFin date
)
begin
	-- Listado (entre fechas) de cada E.R y los kilos de alimento que le fueron entregados (gráfico de torta)
	select e.*, sum(d.peso_unitario * ap.cantidad)
	from entidad_receptora as e
	inner join 
	(
		select p1.* 
		from pedido_alimento as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p on p.entidad_receptora_id = e.Id
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by e.Id;

end$$

DROP PROCEDURE IF EXISTS `probando2`$$
CREATE DEFINER=`grupo_45`@`localhost` PROCEDURE `probando2`(
in fechaIni date,
in fechaFin date
)
begin
	-- Listado (entre fechas) de los kilos de alimento que fueron entregados (gráfico de torta)
	select p.fecha, sum(d.peso_unitario * ap.cantidad)
	from (
		select p1.*,t.fecha as fecha
		from pedido_alimento as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p 
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by p.fecha;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

DROP TABLE IF EXISTS `alimento`;
CREATE TABLE IF NOT EXISTS `alimento` (
  `codigo` varchar(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`codigo`, `descripcion`) VALUES
('Aceite', 'Aceite vegetal de girasol'),
('Harina ', 'Harina tipo 3'),
('Tomates', 'Tomates varios');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `alimentosparaentregadirecta`
--
DROP VIEW IF EXISTS `alimentosparaentregadirecta`;
CREATE TABLE IF NOT EXISTS `alimentosparaentregadirecta` (
`Id` int(11)
,`fecha_vencimiento` date
,`contenido` varchar(200)
,`peso_unitario` decimal(6,2)
,`stock` int(11)
,`reservado` int(11)
,`alimento_codigo` varchar(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `alimentosvencidos`
--
DROP VIEW IF EXISTS `alimentosvencidos`;
CREATE TABLE IF NOT EXISTS `alimentosvencidos` (
`codigo` varchar(11)
,`descripcion` varchar(45)
,`cantidad` decimal(32,0)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_donante`
--

DROP TABLE IF EXISTS `alimento_donante`;
CREATE TABLE IF NOT EXISTS `alimento_donante` (
  `cantidad` int(11) DEFAULT NULL,
  `donante_Id` int(11) NOT NULL DEFAULT '0',
  `detalle_alimento_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_entrega_directa`
--

DROP TABLE IF EXISTS `alimento_entrega_directa`;
CREATE TABLE IF NOT EXISTS `alimento_entrega_directa` (
  `entrega_directa_id` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `alimento_entrega_directa`
--
DROP TRIGGER IF EXISTS `alimento_entrega_directa_BINS`;
DELIMITER //
CREATE TRIGGER `alimento_entrega_directa_BINS` BEFORE INSERT ON `alimento_entrega_directa`
 FOR EACH ROW BEGIN
	declare cantidad int(11) default NEW.cantidad;
	declare detalle_id int(11) default NEW.detalle_alimento_id;
	update grupo_45.detalle_alimento set stock = stock - cantidad where Id = detalle_id;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_pedido`
--

DROP TABLE IF EXISTS `alimento_pedido`;
CREATE TABLE IF NOT EXISTS `alimento_pedido` (
  `pedido_numero` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `alimento_pedido`
--

INSERT INTO `alimento_pedido` (`pedido_numero`, `detalle_alimento_id`, `cantidad`) VALUES
(16, 9, 5),
(21, 14, 2),
(22, 14, 1),
(23, 14, 1);

--
-- Disparadores `alimento_pedido`
--
DROP TRIGGER IF EXISTS `alimento_pedido_insert`;
DELIMITER //
CREATE TRIGGER `alimento_pedido_insert` AFTER INSERT ON `alimento_pedido`
 FOR EACH ROW begin
	
	declare alimento_id int(11) default new.detalle_alimento_id; 
	declare delta int(11) default new.cantidad;

	update detalle_alimento set reservado = reservado + delta  where Id = alimento_id;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

DROP TABLE IF EXISTS `banco`;
CREATE TABLE IF NOT EXISTS `banco` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `lat` varchar(17) DEFAULT NULL,
  `long` varchar(17) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`id`, `nombre`, `ubicacion`, `lat`, `long`) VALUES
(1, 'Banco de Alimentos', '32 y 12', '-34.9123058441760', '-57.9411511315625');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
`id` int(11) NOT NULL,
  `API-Key` varchar(150) DEFAULT NULL,
  `API-Secret` varchar(150) DEFAULT NULL,
  `OAuth-Token` varchar(150) DEFAULT NULL,
  `OAuth-Secret` varchar(150) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `API-Key`, `API-Secret`, `OAuth-Token`, `OAuth-Secret`) VALUES
(3, '750f8wbrxd35z2', 'pmLeubPRbY5brPNd', '78b0d37d-0c44-4543-bdfb-0febf50b8b94', 'b1f894f4-4129-4c07-85e4-563d19776b0f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_alimento`
--

DROP TABLE IF EXISTS `detalle_alimento`;
CREATE TABLE IF NOT EXISTS `detalle_alimento` (
`Id` int(11) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `contenido` varchar(200) DEFAULT NULL,
  `peso_unitario` decimal(6,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `reservado` int(11) DEFAULT NULL,
  `alimento_codigo` varchar(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `detalle_alimento`
--

INSERT INTO `detalle_alimento` (`Id`, `fecha_vencimiento`, `contenido`, `peso_unitario`, `stock`, `reservado`, `alimento_codigo`) VALUES
(9, '2015-01-16', '2x1lt', '1.00', 5, 5, 'Aceite'),
(14, '2014-12-23', '10x2', '2.00', 5, 3, 'Aceite');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

DROP TABLE IF EXISTS `donante`;
CREATE TABLE IF NOT EXISTS `donante` (
`Id` int(11) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `apellido_contacto` varchar(50) DEFAULT NULL,
  `nombre_contacto` varchar(50) DEFAULT NULL,
  `telefono_contacto` varchar(30) DEFAULT NULL,
  `mail_contacto` varchar(50) DEFAULT NULL,
  `domicilio_contacto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `donante`
--

INSERT INTO `donante` (`Id`, `razon_social`, `apellido_contacto`, `nombre_contacto`, `telefono_contacto`, `mail_contacto`, `domicilio_contacto`) VALUES
(5, 'Coca Cola S.A', 'Pellegrino', 'Carlos', '45249144', 'coca-cola@gmail.com', 'Callao 9100, Capital Federal'),
(7, 'Marolio S.A', 'Lopez', 'Tomas', '0114914221', 'tlopez@hotmail.com', 'Cordoba 4552 (e/ Burruchaga y Azquenaga)\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_receptora`
--

DROP TABLE IF EXISTS `entidad_receptora`;
CREATE TABLE IF NOT EXISTS `entidad_receptora` (
`Id` int(11) NOT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `domicilio` varchar(200) DEFAULT NULL,
  `estado_entidad_Id` int(11) NOT NULL,
  `necesidad_entidad_Id` int(11) NOT NULL,
  `servicio_prestado_Id` int(11) NOT NULL,
  `latitud` varchar(17) DEFAULT NULL,
  `longitud` varchar(17) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `entidad_receptora`
--

INSERT INTO `entidad_receptora` (`Id`, `razon_social`, `telefono`, `domicilio`, `estado_entidad_Id`, `necesidad_entidad_Id`, `servicio_prestado_Id`, `latitud`, `longitud`) VALUES
(24, 'Un Techo para mi pais', '221491222', '22 y 15 n 818', 1, 2, 1, '-34.9195315802940', '-57.9741730587921'),
(28, 'Caritas', '22151481', '48 y 5 811', 1, 1, 1, '-34.9128900255442', '-57.9402670765195');

--
-- Disparadores `entidad_receptora`
--
DROP TRIGGER IF EXISTS `entidad_receptora_delete_trigger`;
DELIMITER //
CREATE TRIGGER `entidad_receptora_delete_trigger` BEFORE DELETE ON `entidad_receptora`
 FOR EACH ROW begin
-- Cuando se elimina un turno, se debe eliminar todos los pedidos asociados
	
	declare id_old int(11) default OLD.Id;

	delete from pedido_modelo 
	where entidad_receptora_id = id_old;
	
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_directa`
--

DROP TABLE IF EXISTS `entrega_directa`;
CREATE TABLE IF NOT EXISTS `entrega_directa` (
`id` int(11) NOT NULL,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_entidad`
--

DROP TABLE IF EXISTS `estado_entidad`;
CREATE TABLE IF NOT EXISTS `estado_entidad` (
`Id` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
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
`id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(0, 'sin enviar'),
(1, 'enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_configuracion`
--

DROP TABLE IF EXISTS `fecha_configuracion`;
CREATE TABLE IF NOT EXISTS `fecha_configuracion` (
  `dias` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fecha_configuracion`
--

INSERT INTO `fecha_configuracion` (`dias`) VALUES
(15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `necesidad_entidad`
--

DROP TABLE IF EXISTS `necesidad_entidad`;
CREATE TABLE IF NOT EXISTS `necesidad_entidad` (
`Id` int(11) NOT NULL,
  `descripcion` varchar(15) DEFAULT NULL
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
`numero` int(11) NOT NULL,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado_pedido_id` int(11) DEFAULT '0',
  `turno_entrega_id` int(11) DEFAULT NULL,
  `con_envio` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `pedido_modelo`
--

INSERT INTO `pedido_modelo` (`numero`, `entidad_receptora_id`, `fecha_ingreso`, `estado_pedido_id`, `turno_entrega_id`, `con_envio`) VALUES
(14, 24, '2014-12-12 15:09:35', 1, 4, 1),
(15, 24, '2014-12-12 15:10:01', 0, 3, 1),
(16, 24, '2014-12-12 15:24:33', 1, 5, 1),
(21, 24, '2014-12-12 18:15:32', 0, 5, 1),
(22, 28, '2014-12-12 18:15:45', 1, 4, 1),
(23, 24, '2014-12-12 18:15:58', 0, 3, 1);

--
-- Disparadores `pedido_modelo`
--
DROP TRIGGER IF EXISTS `pedido_modelo_delete`;
DELIMITER //
CREATE TRIGGER `pedido_modelo_delete` BEFORE DELETE ON `pedido_modelo`
 FOR EACH ROW begin
/* 
Si el pedido no fue enviado, se deberia restar de reserva.
Si fue enviado, no se deberia hacer nada
*/
	declare numero_old int(11) default OLD.numero;
	declare estado_pedido int(11) default OLD.estado_pedido_id;

	declare pn int(11) default 0;
	declare dai int(11) default 0;
	declare delta int(11) default 0;

	DECLARE done boolean default false;
	DECLARE cursor_alimento_pedido 
	CURSOR FOR 
	select * from alimento_pedido where pedido_numero = numero_old;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	

	if (estado_pedido = 0) then
		open cursor_alimento_pedido;
		read_loop : loop
			
			fetch cursor_alimento_pedido into pn, dai, delta;
			
			IF done THEN
				LEAVE read_loop;
			END IF;

			update detalle_alimento 
			set stock = stock, reservado = reservado - delta 
			where id = dai;
			
		end loop;
	end if;
	
	delete from alimento_pedido 
	where pedido_numero = numero_old;
	
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `pedido_modelo_update`;
DELIMITER //
CREATE TRIGGER `pedido_modelo_update` BEFORE UPDATE ON `pedido_modelo`
 FOR EACH ROW begin
/*
	si cambio de estado "no-enviado" a "enviado" ->
	deberia "actualizar" los datos de alimentos. Es decir ->
	restar por cada alimento del pedido la cantidad que tiene en reserva y cantidad del detalle.
*/
	declare estado_old int(11) default old.estado_pedido_id;
	declare estado_new int(11) default new.estado_pedido_id;
	declare id_pedido int(11) default old.numero;

	declare pn int(11) default 0;
	declare dai int(11) default 0;
	declare delta int(11) default 0;
	
	DECLARE done boolean default false;
	DECLARE cursor_alimento_pedido 
	CURSOR FOR 
	select * from alimento_pedido where pedido_numero = id_pedido;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	if (estado_old = 0 and estado_new = 1)  then
		open cursor_alimento_pedido;
		read_loop : loop
			
			fetch cursor_alimento_pedido into pn, dai, delta;
			
			IF done THEN
				LEAVE read_loop;
			END IF;

			update detalle_alimento 
			set stock = stock - delta, reservado = reservado - delta 
			where id = dai;
			
			
		end loop;
	end if ;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
`roleID` int(11) NOT NULL,
  `roleuser` varchar(20) NOT NULL,
  `description` varchar(30) NOT NULL
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
`Id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
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
`id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `turno_entrega`
--

INSERT INTO `turno_entrega` (`id`, `fecha`, `hora`) VALUES
(3, '2014-12-31', '13:30:00'),
(4, '2015-01-22', '20:30:00'),
(5, '2015-01-02', '20:00:00');

--
-- Disparadores `turno_entrega`
--
DROP TRIGGER IF EXISTS `turno_entrega_delete`;
DELIMITER //
CREATE TRIGGER `turno_entrega_delete` BEFORE DELETE ON `turno_entrega`
 FOR EACH ROW begin
-- Cuando se elimina un turno, se debe eliminar todos los pedidos asociados
	
	declare id_old int(11) default OLD.id;

	delete from pedido_modelo 
	where turno_entrega_id = id_old;
	
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`userID`, `username`, `pass`, `roleID`) VALUES
(1, 'admin1', '123456', 1),
(2, 'gestion1', '123456', 2),
(3, 'consulta1', '123456', 3);

-- --------------------------------------------------------

--
-- Estructura para la vista `alimentosparaentregadirecta`
--
DROP TABLE IF EXISTS `alimentosparaentregadirecta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosparaentregadirecta` AS select `d`.`Id` AS `Id`,`d`.`fecha_vencimiento` AS `fecha_vencimiento`,`d`.`contenido` AS `contenido`,`d`.`peso_unitario` AS `peso_unitario`,`d`.`stock` AS `stock`,`d`.`reservado` AS `reservado`,`d`.`alimento_codigo` AS `alimento_codigo` from `detalle_alimento` `d` where (`d`.`fecha_vencimiento` between (now() + interval 1 day) and (now() + interval (select `fecha_configuracion`.`dias` from `fecha_configuracion`) day));

-- --------------------------------------------------------

--
-- Estructura para la vista `alimentosvencidos`
--
DROP TABLE IF EXISTS `alimentosvencidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosvencidos` AS select `a`.`codigo` AS `codigo`,`a`.`descripcion` AS `descripcion`,sum(`d`.`stock`) AS `cantidad` from (`detalle_alimento` `d` join `alimento` `a` on((`d`.`alimento_codigo` = `a`.`codigo`))) where (`d`.`fecha_vencimiento` <= now()) group by `a`.`codigo`;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimento`
--
ALTER TABLE `alimento`
 ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `alimento_donante`
--
ALTER TABLE `alimento_donante`
 ADD PRIMARY KEY (`donante_Id`,`detalle_alimento_Id`), ADD KEY `fk_alimento_donante_detalle_alimento1_idx` (`detalle_alimento_Id`), ADD KEY `donante_Id` (`donante_Id`);

--
-- Indices de la tabla `alimento_entrega_directa`
--
ALTER TABLE `alimento_entrega_directa`
 ADD PRIMARY KEY (`entrega_directa_id`,`detalle_alimento_id`), ADD KEY `fk_alimento_entrega_directa_2_idx` (`detalle_alimento_id`);

--
-- Indices de la tabla `alimento_pedido`
--
ALTER TABLE `alimento_pedido`
 ADD PRIMARY KEY (`pedido_numero`,`detalle_alimento_id`), ADD KEY `fk_alimento_pedido_2_idx` (`detalle_alimento_id`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
 ADD PRIMARY KEY (`Id`), ADD KEY `alimento_codigo` (`alimento_codigo`), ADD KEY `alimento_codigo_2` (`alimento_codigo`);

--
-- Indices de la tabla `donante`
--
ALTER TABLE `donante`
 ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
 ADD PRIMARY KEY (`Id`,`estado_entidad_Id`,`necesidad_entidad_Id`,`servicio_prestado_Id`), ADD KEY `fk_entidad_receptora_estado_entidad_idx` (`estado_entidad_Id`), ADD KEY `fk_entidad_receptora_necesidad_entidad1_idx` (`necesidad_entidad_Id`), ADD KEY `fk_entidad_receptora_servicio_prestado1_idx` (`servicio_prestado_Id`);

--
-- Indices de la tabla `entrega_directa`
--
ALTER TABLE `entrega_directa`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_entrega_directa_1_idx` (`entidad_receptora_id`);

--
-- Indices de la tabla `estado_entidad`
--
ALTER TABLE `estado_entidad`
 ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `necesidad_entidad`
--
ALTER TABLE `necesidad_entidad`
 ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
 ADD PRIMARY KEY (`numero`), ADD KEY `fk_pedido_model_1_idx` (`entidad_receptora_id`), ADD KEY `fk_pedido_model_2_idx` (`estado_pedido_id`), ADD KEY `fk_pedido_model_3_idx` (`turno_entrega_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`roleID`);

--
-- Indices de la tabla `servicio_prestado`
--
ALTER TABLE `servicio_prestado`
 ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `turno_entrega`
--
ALTER TABLE `turno_entrega`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userID`), ADD KEY `userID` (`userID`), ADD KEY `fk_user_1_idx` (`roleID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `donante`
--
ALTER TABLE `donante`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `entrega_directa`
--
ALTER TABLE `entrega_directa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado_entidad`
--
ALTER TABLE `estado_entidad`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `necesidad_entidad`
--
ALTER TABLE `necesidad_entidad`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `servicio_prestado`
--
ALTER TABLE `servicio_prestado`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `turno_entrega`
--
ALTER TABLE `turno_entrega`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
ADD CONSTRAINT `fk_alimento_entrega_directa_1` FOREIGN KEY (`entrega_directa_id`) REFERENCES `entrega_directa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_alimento_entrega_directa_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `alimento_pedido`
--
ALTER TABLE `alimento_pedido`
ADD CONSTRAINT `fk_alimento_pedido_1` FOREIGN KEY (`pedido_numero`) REFERENCES `pedido_modelo` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_alimento_pedido_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
ADD CONSTRAINT `fk_entrega_directa_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
ADD CONSTRAINT `fk_user_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
