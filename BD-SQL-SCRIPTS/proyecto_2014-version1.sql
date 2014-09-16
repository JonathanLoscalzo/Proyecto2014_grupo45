SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema grupo_45
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `grupo_45` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `grupo_45` ;

-- -----------------------------------------------------
-- Table `grupo_45`.`estado_entidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`estado_entidad` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(20) NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`necesidad_entidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`necesidad_entidad` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(15) NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`servicio_prestado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`servicio_prestado` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`entidad_receptora`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`entidad_receptora` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `razon_social` VARCHAR(100) NULL,
  `telefono` VARCHAR(30) NULL,
  `domicilio` VARCHAR(200) NULL,
  `estado_entidad_Id` INT NOT NULL,
  `necesidad_entidad_Id` INT NOT NULL,
  `servicio_prestado_Id` INT NOT NULL,
  PRIMARY KEY (`Id`, `estado_entidad_Id`, `necesidad_entidad_Id`, `servicio_prestado_Id`),
  INDEX `fk_entidad_receptora_estado_entidad_idx` (`estado_entidad_Id` ASC),
  INDEX `fk_entidad_receptora_necesidad_entidad1_idx` (`necesidad_entidad_Id` ASC),
  INDEX `fk_entidad_receptora_servicio_prestado1_idx` (`servicio_prestado_Id` ASC),
  CONSTRAINT `fk_entidad_receptora_estado_entidad`
    FOREIGN KEY (`estado_entidad_Id`)
    REFERENCES `grupo_45`.`estado_entidad` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entidad_receptora_necesidad_entidad1`
    FOREIGN KEY (`necesidad_entidad_Id`)
    REFERENCES `grupo_45`.`necesidad_entidad` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entidad_receptora_servicio_prestado1`
    FOREIGN KEY (`servicio_prestado_Id`)
    REFERENCES `grupo_45`.`servicio_prestado` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`detalle_alimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`detalle_alimento` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `fecha_vencimiento` DATE NULL,
  `contenido` VARCHAR(200) NULL,
  `peso_unitario` DECIMAL(6,2) NULL,
  `stock` INT NULL,
  `reservado` INT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`donante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`donante` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `razon_social` VARCHAR(100) NULL,
  `apellido_contacto` VARCHAR(50) NULL,
  `nombre_contacto` VARCHAR(50) NULL,
  `telefono_contacto` VARCHAR(30) NULL,
  `mail_contacto` VARCHAR(50) NULL,
  `domicilio_contacto` VARCHAR(200) NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`alimento_donante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`alimento_donante` (
  `cantidad` INT NULL,
  `donante_Id` INT NOT NULL,
  `detalle_alimento_Id` INT NOT NULL,
  PRIMARY KEY (`donante_Id`, `detalle_alimento_Id`),
  INDEX `fk_alimento_donante_detalle_alimento1_idx` (`detalle_alimento_Id` ASC),
  CONSTRAINT `fk_alimento_donante_donante1`
    FOREIGN KEY (`donante_Id`)
    REFERENCES `grupo_45`.`donante` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alimento_donante_detalle_alimento1`
    FOREIGN KEY (`detalle_alimento_Id`)
    REFERENCES `grupo_45`.`detalle_alimento` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_45`.`alimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_45`.`alimento` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
