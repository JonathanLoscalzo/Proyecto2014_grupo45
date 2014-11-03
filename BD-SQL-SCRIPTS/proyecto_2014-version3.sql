-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2014 a las 16:38:25
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
-- Estructura de tabla para la tabla `pedido_modelo`
--

CREATE TABLE IF NOT EXISTS `pedido_modelo` (
`numero` int(11) NOT NULL,
  `entidad_receptora_id` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estado_pedido_id` int(11) DEFAULT NULL,
  `turno_entrega_id` int(11) DEFAULT NULL,
  `con_envio` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Disparadores `pedido_modelo`
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
 ADD PRIMARY KEY (`numero`), ADD KEY `fk_pedido_model_1_idx` (`entidad_receptora_id`), ADD KEY `fk_pedido_model_2_idx` (`estado_pedido_id`), ADD KEY `fk_pedido_model_3_idx` (`turno_entrega_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido_modelo`
--
ALTER TABLE `pedido_modelo`
ADD CONSTRAINT `fk_pedido_model_1` FOREIGN KEY (`entidad_receptora_id`) REFERENCES `entidad_receptora` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_model_2` FOREIGN KEY (`estado_pedido_id`) REFERENCES `estado_pedido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_model_3` FOREIGN KEY (`turno_entrega_id`) REFERENCES `turno_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
