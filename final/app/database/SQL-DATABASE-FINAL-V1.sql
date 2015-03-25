-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2015 at 02:55 
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grupo_45`
--

DELIMITER $$
--
-- Procedures
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
		from pedido_modelo as p1 
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
		from pedido_modelo as p1 
		inner join turno_entrega as t 
		on  t.Id = p1.turno_entrega_id
		where p1.estado_pedido_id = 1 and t.fecha between fechaIni and fechaFin
	) as p 
	inner join alimento_pedido as ap on p.numero = ap.pedido_numero
	inner join detalle_alimento as d on ap.detalle_alimento_id = d.Id
	group by p.fecha;
	

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `probando`(
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `probando2`(
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
-- Table structure for table `alimento`
--

CREATE TABLE IF NOT EXISTS `alimento` (
  `codigo` varchar(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alimento`
--

INSERT INTO `alimento` (`codigo`, `descripcion`) VALUES
('Aceite', 'Aceite vegetal de girasol'),
('Harina ', 'Harina tipo 3'),
('Tomates', 'Tomates varios');

-- --------------------------------------------------------

--
-- Stand-in structure for view `alimentosparaentregadirecta`
--
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
-- Stand-in structure for view `alimentosvencidos`
--
CREATE TABLE IF NOT EXISTS `alimentosvencidos` (
`codigo` varchar(11)
,`descripcion` varchar(45)
,`cantidad` decimal(32,0)
);
-- --------------------------------------------------------

--
-- Table structure for table `alimento_donante`
--

CREATE TABLE IF NOT EXISTS `alimento_donante` (
  `cantidad` int(11) DEFAULT NULL,
  `donante_Id` int(11) NOT NULL DEFAULT '0',
  `detalle_alimento_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `alimento_entrega_directa`
--

CREATE TABLE IF NOT EXISTS `alimento_entrega_directa` (
  `entrega_directa_id` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `alimento_entrega_directa`
--
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
-- Table structure for table `alimento_pedido`
--

CREATE TABLE IF NOT EXISTS `alimento_pedido` (
  `pedido_numero` int(11) NOT NULL,
  `detalle_alimento_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alimento_pedido`
--

INSERT INTO `alimento_pedido` (`pedido_numero`, `detalle_alimento_id`, `cantidad`) VALUES
(16, 9, 5),
(21, 14, 2),
(22, 14, 1),
(23, 14, 1),
(24, 14, 1),
(25, 14, 2);

--
-- Triggers `alimento_pedido`
--
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
-- Table structure for table `banco`
--

CREATE TABLE IF NOT EXISTS `banco` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `lat` varchar(17) DEFAULT NULL,
  `long` varchar(17) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `banco`
--

INSERT INTO `banco` (`id`, `nombre`, `ubicacion`, `lat`, `long`) VALUES
(1, 'Banco de Alimentos', '32 y 12', '-34.9123058441760', '-57.9411511315625');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
`id` int(11) NOT NULL,
  `API-Key` varchar(150) DEFAULT NULL,
  `API-Secret` varchar(150) DEFAULT NULL,
  `OAuth-Token` varchar(150) DEFAULT NULL,
  `OAuth-Secret` varchar(150) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id`, `API-Key`, `API-Secret`, `OAuth-Token`, `OAuth-Secret`) VALUES
(1, '750f8wbrxd35z2', 'pmLeubPRbY5brPNd', '78b0d37d-0c44-4543-bdfb-0febf50b8b94', 'b1f894f4-4129-4c07-85e4-563d19776b0f');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_alimento`
--

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
-- Dumping data for table `detalle_alimento`
--

INSERT INTO `detalle_alimento` (`Id`, `fecha_vencimiento`, `contenido`, `peso_unitario`, `stock`, `reservado`, `alimento_codigo`) VALUES
(9, '2015-01-16', '2x1lt', '1.00', 5, 5, 'Aceite'),
(14, '2014-12-23', '10x2', '2.00', 8, 4, 'Aceite');

-- --------------------------------------------------------

--
-- Table structure for table `donante`
--

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
-- Dumping data for table `donante`
--

INSERT INTO `donante` (`Id`, `razon_social`, `apellido_contacto`, `nombre_contacto`, `telefono_contacto`, `mail_contacto`, `domicilio_contacto`) VALUES
(5, 'Coca Cola S.A', 'Pellegrino', 'Carlos', '45249144', 'coca-cola@gmail.com', 'Callao 9100, Capital Federal'),
(7, 'Marolio S.A', 'Lopez', 'Tomas', '0114914221', 'tlopez@hotmail.com', 'Cordoba 4552 (e/ Burruchaga y Azquenaga)\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `entidad_receptora`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `entidad_receptora`
--

INSERT INTO `entidad_receptora` (`Id`, `razon_social`, `telefono`, `domicilio`, `estado_entidad_Id`, `necesidad_entidad_Id`, `servicio_prestado_Id`, `latitud`, `longitud`) VALUES
(24, 'Un Techo para mi pais', '221491222', '22 y 15 n 818', 1, 2, 1, '-34.9195315802940', '-57.9741730587921'),
(28, 'Caritas', '22151481', '48 y 5 811', 1, 1, 1, '-34.9128900255442', '-57.9402670765195');

-- --------------------------------------------------------

--
-- Table structure for table `entrega_directa`
--

CREATE TABLE IF NOT EXISTS `entrega_directa` (
`id` int(11) NOT NULL,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `estado_entidad`
--

CREATE TABLE IF NOT EXISTS `estado_entidad` (
`Id` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `estado_entidad`
--

INSERT INTO `estado_entidad` (`Id`, `descripcion`) VALUES
(1, 'alta'),
(2, 'tramite'),
(3, 'suspendida'),
(4, 'baja');

-- --------------------------------------------------------

--
-- Table structure for table `estado_pedido`
--

CREATE TABLE IF NOT EXISTS `estado_pedido` (
`id` int(11) NOT NULL,
  `descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(0, 'sin enviar'),
(1, 'enviado');

-- --------------------------------------------------------

--
-- Table structure for table `fecha_configuracion`
--

CREATE TABLE IF NOT EXISTS `fecha_configuracion` (
  `dias` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fecha_configuracion`
--

INSERT INTO `fecha_configuracion` (`dias`) VALUES
(50);

-- --------------------------------------------------------

--
-- Table structure for table `necesidad_entidad`
--

CREATE TABLE IF NOT EXISTS `necesidad_entidad` (
`Id` int(11) NOT NULL,
  `descripcion` varchar(15) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `necesidad_entidad`
--

INSERT INTO `necesidad_entidad` (`Id`, `descripcion`) VALUES
(1, 'maxima'),
(2, 'mediana'),
(3, 'minima');

-- --------------------------------------------------------

--
-- Table structure for table `pedido_modelo`
--

CREATE TABLE IF NOT EXISTS `pedido_modelo` (
`numero` int(11) NOT NULL,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado_pedido_id` int(11) DEFAULT '0',
  `turno_entrega_id` int(11) DEFAULT NULL,
  `con_envio` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `pedido_modelo`
--

INSERT INTO `pedido_modelo` (`numero`, `entidad_receptora_id`, `fecha_ingreso`, `estado_pedido_id`, `turno_entrega_id`, `con_envio`) VALUES
(14, 24, '2014-12-12 15:09:35', 1, 4, 1),
(15, 24, '2014-12-12 15:10:01', 0, 3, 1),
(16, 24, '2014-12-12 15:24:33', 1, 5, 1),
(21, 24, '2014-12-12 18:15:32', 1, 5, 1),
(22, 28, '2014-12-12 18:15:45', 1, 4, 1),
(23, 24, '2014-12-12 18:15:58', 0, 3, 1),
(24, 24, '2014-12-18 02:53:45', 0, 5, 1),
(25, 28, '2014-12-18 03:17:23', 0, 5, 1);

--
-- Triggers `pedido_modelo`
--
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
			set stock = stock + delta, reservado = reservado - delta 
			where id = dai;
			
		end loop;
	end if;
	
	delete from alimento_pedido 
	where pedido_numero = numero_old;
	
end
//
DELIMITER ;
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
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
`roleID` int(11) NOT NULL,
  `roleuser` varchar(20) NOT NULL,
  `description` varchar(30) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleID`, `roleuser`, `description`) VALUES
(1, 'Administrador', 'Todas las funciones del sistem'),
(2, 'Gestion', 'Solo pedidos y entregas.'),
(3, 'Consulta', 'Listar alimentos en stock');

-- --------------------------------------------------------

--
-- Table structure for table `servicio_prestado`
--

CREATE TABLE IF NOT EXISTS `servicio_prestado` (
`Id` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `servicio_prestado`
--

INSERT INTO `servicio_prestado` (`Id`, `descripcion`) VALUES
(1, 'hogar de dia'),
(2, 'comedor infantil');

-- --------------------------------------------------------

--
-- Table structure for table `turno_entrega`
--

CREATE TABLE IF NOT EXISTS `turno_entrega` (
`id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `turno_entrega`
--

INSERT INTO `turno_entrega` (`id`, `fecha`, `hora`) VALUES
(3, '2014-12-31', '13:30:00'),
(4, '2015-01-22', '20:30:00'),
(5, '2015-01-02', '20:00:00');

--
-- Triggers `turno_entrega`
--
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
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`userID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `roleID` int(11) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `pass`, `roleID`, `remember_token`, `updated_at`) VALUES
(1, 'admin1', '$2y$10$a2A0EcTzm3y4p0OIOENx.Opu33xP4wvFD8nRjO9K32q9htnOwwLl6', 1, 'HMoqwdMnaC7SGD23M5efzgD1XDhBR4YyLjcIPCdQ5asKAJLpwgWAvwRGwIzB', '2015-02-12 01:54:29'),
(2, 'gestion1', '$2y$10$a2A0EcTzm3y4p0OIOENx.Opu33xP4wvFD8nRjO9K32q9htnOwwLl6', 2, NULL, '0000-00-00 00:00:00'),
(3, 'consulta1', '$2y$10$a2A0EcTzm3y4p0OIOENx.Opu33xP4wvFD8nRjO9K32q9htnOwwLl6', 3, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure for view `alimentosparaentregadirecta`
--
DROP TABLE IF EXISTS `alimentosparaentregadirecta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosparaentregadirecta` AS select `d`.`Id` AS `Id`,`d`.`fecha_vencimiento` AS `fecha_vencimiento`,`d`.`contenido` AS `contenido`,`d`.`peso_unitario` AS `peso_unitario`,`d`.`stock` AS `stock`,`d`.`reservado` AS `reservado`,`d`.`alimento_codigo` AS `alimento_codigo` from `detalle_alimento` `d` where (`d`.`fecha_vencimiento` between (now() + interval 1 day) and (now() + interval (select `fecha_configuracion`.`dias` from `fecha_configuracion`) day));

-- --------------------------------------------------------

--
-- Structure for view `alimentosvencidos`
--
DROP TABLE IF EXISTS `alimentosvencidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`grupo_45`@`localhost` SQL SECURITY DEFINER VIEW `alimentosvencidos` AS select `a`.`codigo` AS `codigo`,`a`.`descripcion` AS `descripcion`,sum(`d`.`stock`) AS `cantidad` from (`detalle_alimento` `d` join `alimento` `a` on((`d`.`alimento_codigo` = `a`.`codigo`))) where (`d`.`fecha_vencimiento` <= now()) group by `a`.`codigo`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alimento`
--
ALTER TABLE `alimento`
 ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `alimento_donante`
--
ALTER TABLE `alimento_donante`
 ADD PRIMARY KEY (`donante_Id`,`detalle_alimento_Id`), ADD KEY `fk_alimento_donante_detalle_alimento1_idx` (`detalle_alimento_Id`), ADD KEY `donante_Id` (`donante_Id`);

--
-- Indexes for table `alimento_entrega_directa`
--
ALTER TABLE `alimento_entrega_directa`
 ADD PRIMARY KEY (`entrega_directa_id`,`detalle_alimento_id`), ADD KEY `fk_alimento_entrega_directa_2_idx` (`detalle_alimento_id`);

--
-- Indexes for table `alimento_pedido`
--
ALTER TABLE `alimento_pedido`
 ADD PRIMARY KEY (`pedido_numero`,`detalle_alimento_id`), ADD KEY `fk_alimento_pedido_2_idx` (`detalle_alimento_id`);

--
-- Indexes for table `banco`
--
ALTER TABLE `banco`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
 ADD PRIMARY KEY (`Id`), ADD KEY `alimento_codigo` (`alimento_codigo`), ADD KEY `alimento_codigo_2` (`alimento_codigo`);

--
-- Indexes for table `donante`
--
ALTER TABLE `donante`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
 ADD PRIMARY KEY (`Id`,`estado_entidad_Id`,`necesidad_entidad_Id`,`servicio_prestado_Id`), ADD KEY `fk_entidad_receptora_estado_entidad_idx` (`estado_entidad_Id`), ADD KEY `fk_entidad_receptora_necesidad_entidad1_idx` (`necesidad_entidad_Id`), ADD KEY `fk_entidad_receptora_servicio_prestado1_idx` (`servicio_prestado_Id`);

--
-- Indexes for table `entrega_directa`
--
ALTER TABLE `entrega_directa`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_entrega_directa_1_idx` (`entidad_receptora_id`);

--
-- Indexes for table `estado_entidad`
--
ALTER TABLE `estado_entidad`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `estado_pedido`
--
ALTER TABLE `estado_pedido`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `necesidad_entidad`
--
ALTER TABLE `necesidad_entidad`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
 ADD PRIMARY KEY (`numero`), ADD KEY `fk_pedido_model_1_idx` (`entidad_receptora_id`), ADD KEY `fk_pedido_model_2_idx` (`estado_pedido_id`), ADD KEY `fk_pedido_model_3_idx` (`turno_entrega_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `servicio_prestado`
--
ALTER TABLE `servicio_prestado`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `turno_entrega`
--
ALTER TABLE `turno_entrega`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userID`), ADD KEY `userID` (`userID`), ADD KEY `fk_user_1_idx` (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banco`
--
ALTER TABLE `banco`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `donante`
--
ALTER TABLE `donante`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `entrega_directa`
--
ALTER TABLE `entrega_directa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estado_entidad`
--
ALTER TABLE `estado_entidad`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `estado_pedido`
--
ALTER TABLE `estado_pedido`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `necesidad_entidad`
--
ALTER TABLE `necesidad_entidad`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `servicio_prestado`
--
ALTER TABLE `servicio_prestado`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `turno_entrega`
--
ALTER TABLE `turno_entrega`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alimento_donante`
--
ALTER TABLE `alimento_donante`
ADD CONSTRAINT `fk_alimento_donante_detalle_alimento1` FOREIGN KEY (`detalle_alimento_Id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_alimento_donante_donante1` FOREIGN KEY (`donante_Id`) REFERENCES `donante` (`Id`);

--
-- Constraints for table `alimento_entrega_directa`
--
ALTER TABLE `alimento_entrega_directa`
ADD CONSTRAINT `fk_alimento_entrega_directa_1` FOREIGN KEY (`entrega_directa_id`) REFERENCES `entrega_directa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_alimento_entrega_directa_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON UPDATE NO ACTION;

--
-- Constraints for table `alimento_pedido`
--
ALTER TABLE `alimento_pedido`
ADD CONSTRAINT `fk_alimento_pedido_1` FOREIGN KEY (`pedido_numero`) REFERENCES `pedido_modelo` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_alimento_pedido_2` FOREIGN KEY (`detalle_alimento_id`) REFERENCES `detalle_alimento` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalle_alimento`
--
ALTER TABLE `detalle_alimento`
ADD CONSTRAINT `fk_alimento_codigo` FOREIGN KEY (`alimento_codigo`) REFERENCES `alimento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entidad_receptora`
--
ALTER TABLE `entidad_receptora`
ADD CONSTRAINT `fk_entidad_receptora_estado_entidad` FOREIGN KEY (`estado_entidad_Id`) REFERENCES `estado_entidad` (`Id`),
ADD CONSTRAINT `fk_entidad_receptora_necesidad_entidad1` FOREIGN KEY (`necesidad_entidad_Id`) REFERENCES `necesidad_entidad` (`Id`),
ADD CONSTRAINT `fk_entidad_receptora_servicio_prestado1` FOREIGN KEY (`servicio_prestado_Id`) REFERENCES `servicio_prestado` (`Id`);

--
-- Constraints for table `entrega_directa`
--
ALTER TABLE `entrega_directa`
ADD CONSTRAINT `fk_entrega_directa_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
ADD CONSTRAINT `fk_pedido_model_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_pedido_model_2` FOREIGN KEY (`estado_pedido_id`) REFERENCES `estado_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_model_3` FOREIGN KEY (`turno_entrega_id`) REFERENCES `turno_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `fk_user_1` FOREIGN KEY (`roleID`) REFERENCES `role` (`roleID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
