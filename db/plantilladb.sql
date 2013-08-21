SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';



CREATE SCHEMA IF NOT EXISTS `plantilla` DEFAULT CHARACTER SET utf8 ;

USE `plantilla` ;



-- -----------------------------------------------------

-- Table `plantilla`.`permisos`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`permisos` (

  `permiso_id` INT(11) NOT NULL AUTO_INCREMENT ,

  `url` VARCHAR(100) NULL DEFAULT NULL ,

  `descripcion` VARCHAR(100) NULL DEFAULT NULL ,

  PRIMARY KEY (`permiso_id`) )

ENGINE = InnoDB

AUTO_INCREMENT = 3

DEFAULT CHARACTER SET = utf8;





-- -----------------------------------------------------

-- Table `plantilla`.`roles`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`roles` (

  `rol_id` INT(11) NOT NULL AUTO_INCREMENT ,

  `nombre` VARCHAR(100) NULL DEFAULT NULL ,

  `descripcion` VARCHAR(100) NULL DEFAULT NULL ,

  PRIMARY KEY (`rol_id`) )

ENGINE = InnoDB

AUTO_INCREMENT = 3

DEFAULT CHARACTER SET = utf8;





-- -----------------------------------------------------

-- Table `plantilla`.`permisos_roles`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`permisos_roles` (

  `permiso_rol_id` INT(11) NOT NULL AUTO_INCREMENT ,

  `rol_id` INT(11) NULL DEFAULT NULL ,

  `permiso_id` INT(11) NULL DEFAULT NULL ,

  PRIMARY KEY (`permiso_rol_id`) ,

  INDEX `fk_permiso_rol_rol_idx` (`rol_id` ASC) ,

  INDEX `fk_permiso_rol_permiso_idx` (`permiso_id` ASC) ,

  CONSTRAINT `fk_permiso_rol_permiso`

    FOREIGN KEY (`permiso_id` )

    REFERENCES `plantilla`.`permisos` (`permiso_id` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION,

  CONSTRAINT `fk_permiso_rol_rol`

    FOREIGN KEY (`rol_id` )

    REFERENCES `plantilla`.`roles` (`rol_id` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB

AUTO_INCREMENT = 4

DEFAULT CHARACTER SET = utf8;





-- -----------------------------------------------------

-- Table `plantilla`.`user`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`user` (

  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,

  `username` VARCHAR(255) NULL DEFAULT NULL ,

  `email` VARCHAR(255) NULL DEFAULT NULL ,

  `display_name` VARCHAR(50) NULL DEFAULT NULL ,

  `password` VARCHAR(128) NOT NULL ,

  `state` SMALLINT(5) UNSIGNED NULL DEFAULT NULL ,

  PRIMARY KEY (`user_id`) ,

  UNIQUE INDEX `username` (`username` ASC) ,

  UNIQUE INDEX `email` (`email` ASC) )

ENGINE = InnoDB

AUTO_INCREMENT = 2

DEFAULT CHARACTER SET = utf8;





-- -----------------------------------------------------

-- Table `plantilla`.`user_provider`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`user_provider` (

  `user_id` INT(10) UNSIGNED NOT NULL ,

  `provider_id` VARCHAR(50) NOT NULL ,

  `provider` VARCHAR(255) NOT NULL ,

  PRIMARY KEY (`user_id`, `provider_id`) ,

  UNIQUE INDEX `provider_id` (`provider_id` ASC, `provider` ASC) ,

  CONSTRAINT `user_provider_ibfk_1`

    FOREIGN KEY (`user_id` )

    REFERENCES `plantilla`.`user` (`user_id` ))

ENGINE = InnoDB

DEFAULT CHARACTER SET = utf8;





-- -----------------------------------------------------

-- Table `plantilla`.`users_roles`

-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `plantilla`.`users_roles` (

  `user_rol_id` INT(11) NOT NULL AUTO_INCREMENT ,

  `rol_id` INT(11) NULL DEFAULT NULL ,

  `user_id` INT(11) NULL DEFAULT NULL ,

  PRIMARY KEY (`user_rol_id`) ,

  INDEX `fk_user_rol_rol_idx` (`rol_id` ASC) ,

  CONSTRAINT `fk_user_rol_rol`

    FOREIGN KEY (`rol_id` )

    REFERENCES `plantilla`.`roles` (`rol_id` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB

AUTO_INCREMENT = 3

DEFAULT CHARACTER SET = utf8;



USE `plantilla` ;





SET SQL_MODE=@OLD_SQL_MODE;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;

SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

