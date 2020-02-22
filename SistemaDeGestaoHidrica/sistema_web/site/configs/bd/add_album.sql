-- MySQL Workbench Synchronization
-- Generated: 2015-04-09 09:34
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: victor

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `jardimalforria`.`jatbl_imagem` 
ADD COLUMN `img_album_id` INT(11) NULL DEFAULT NULL AFTER `img_noticia_id`,
ADD INDEX `fk_img_algum_id_idx` (`img_album_id` ASC);

CREATE TABLE IF NOT EXISTS `jardimalforria`.`jatbl_album` (
  `alb_id` INT(11) NOT NULL AUTO_INCREMENT,
  `alb_nome` VARCHAR(100) NULL DEFAULT NULL,
  `alb_descricao` VARCHAR(512) NULL DEFAULT NULL,
  `alb_data_cadastro` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`alb_id`),
  INDEX `ind_alb_nome` (`alb_nome` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `jardimalforria`.`jatbl_imagem` 
ADD CONSTRAINT `fk_img_algum_id`
  FOREIGN KEY (`img_album_id`)
  REFERENCES `jardimalforria`.`jatbl_album` (`alb_id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
