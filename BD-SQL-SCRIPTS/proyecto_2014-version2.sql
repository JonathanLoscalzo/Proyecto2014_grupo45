-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-10-2014 a las 23:02:36
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

DELIMITER $$
--
-- Procedimientos
--
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
		from pedido_alimento as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p on p.entidad_receptora_id = e.Id
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by e.Id;

end$$

CREATE DEFINER=`grupo_45`@`localhost` PROCEDURE `alimentos_por_fechas_entre`(
in fechaIni date,
in fechaFin date
)
begin
	-- Listado (entre fechas) de los kilos de alimento que fueron entregados (gráfico de torta)
	select p.fecha, sum(d.peso_unitario * ap.cantidad) as kilogramos
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
-- Estructura Stand-in para la vista `alimentosvencidos`
--
CREATE TABLE IF NOT EXISTS `alimentosvencidos` (
`codigo` varchar(11)
,`descripcion` varchar(45)
,`cantidad` decimal(32,0)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento_donante`
--

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

CREATE TABLE IF NOT EXISTS `alimento_pedido` (
  `pedido_numero` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`pedido_numero`,`detalle_alimento_id`),
  KEY `fk_alimento_pedido_2_idx` (`detalle_alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `alimento_pedido`
--
DROP TRIGGER IF EXISTS `alimento_pedido_insert`;
DELIMITER //
CREATE TRIGGER `alimento_pedido_insert` AFTER INSERT ON `alimento_pedido`
 FOR EACH ROW begin
	
	declare alimento_id int(11) default new.detalle_alimento_id; 
	declare delta int(11) default new.cantidad;

	update detalle_alimento set reserva = reserva + delta  where Id = alimento_id;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

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

CREATE TABLE IF NOT EXISTS `estado_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(0, 'sin enviar'),
(1, 'enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `necesidad_entidad`
--

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

--
-- Disparadores `pedido_modelo`
--
DROP TRIGGER IF EXISTS `pedido_modelo_delete`;
DELIMITER //
CREATE TRIGGER `pedido_modelo_delete` BEFORE DELETE ON `pedido_modelo`
 FOR EACH ROW begin
/* Si el pedido tiene estado sin enviar, se debe sumar de cada alimento asociado
La cantidad que tiene el alimento, se resta de reserva, y se suma en cantidad
Luego (para ambos casos) se eliminan todos los alimento_pedidos asociados
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
			set cantidad = cantidad + delta, reserva = reserva - delta 
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
			set cantidad = cantidad - delta, reserva = reserva - delta 
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

CREATE TABLE IF NOT EXISTS `turno_entrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `turno_entrega`
--

INSERT INTO `turno_entrega` (`id`, `fecha`, `hora`) VALUES
(4, '2014-10-30', '17:00:00'),
(7, '2014-10-31', '17:30:00'),
(8, '2014-10-30', '17:30:00');

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

CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `roleID` int(11) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userID` (`userID`),
  KEY `fk_user_1_idx` (`roleID`)
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
-- Estructura para la vista `alimentosvencidos`
--
DROP TABLE IF EXISTS `alimentosvencidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosvencidos` AS select `a`.`codigo` AS `codigo`,`a`.`descripcion` AS `descripcion`,sum(`d`.`stock`) AS `cantidad` from (`detalle_alimento` `d` join `alimento` `a` on((`d`.`alimento_codigo` = `a`.`codigo`))) where (`d`.`fecha_vencimiento` <= now()) group by `a`.`codigo`;

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
  ADD CONSTRAINT `fk_user_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
