SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `plantilla` DEFAULT CHARACTER SET utf8 ;
USE `plantilla` ;

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

USE `plantilla` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
