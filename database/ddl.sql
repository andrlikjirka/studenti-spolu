-- MySQL Script generated by MySQL Workbench
-- Sun Mar 27 15:09:00 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema studenti.spolu-db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `STATUS_USER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `status_user` ;

CREATE TABLE IF NOT EXISTS `status_user` (
  `id_status` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_status`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `RIGHT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `right` ;

CREATE TABLE IF NOT EXISTS `right` (
  `id_right` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_right`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `USERS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `description` MEDIUMTEXT NULL,
  `e-mail` VARCHAR(255) NOT NULL,
  `login` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `id_right` INT NOT NULL,
  `id_status` INT NOT NULL,
  PRIMARY KEY (`id_user`),
  CONSTRAINT `fk_USERS_STATUS_USER1`
    FOREIGN KEY (`id_status`)
    REFERENCES `status_user` (`id_status`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USERS_RIGHT1`
    FOREIGN KEY (`id_right`)
    REFERENCES `right` (`id_right`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE UNIQUE INDEX `login_UNIQUE` ON `users` (`login` ASC) ;

CREATE UNIQUE INDEX `heslo_UNIQUE` ON `users` (`password` ASC) ;

CREATE INDEX `fk_USERS_STATUS_USER1_idx` ON `users` (`id_status` ASC) ;

CREATE INDEX `fk_USERS_RIGHT1_idx` ON `users` (`id_right` ASC) ;


-- -----------------------------------------------------
-- Table `STATUS_PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `status_project` ;

CREATE TABLE IF NOT EXISTS `status_project` (
  `id_status` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_status`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `PROJECT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `project` ;

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `abstract` TINYTEXT NOT NULL,
  `description` MEDIUMTEXT NOT NULL,
  `create_date` DATETIME NOT NULL,
  `id_status` INT NOT NULL,
  PRIMARY KEY (`id_project`),
  CONSTRAINT `fk_PROJECT_STATUS_PROJECT1`
    FOREIGN KEY (`id_status`)
    REFERENCES `status_project` (`id_status`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_PROJECT_STATUS_PROJECT1_idx` ON `project` (`id_status` ASC) ;


-- -----------------------------------------------------
-- Table `ROLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role` ;

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_role`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `COOPERATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cooperation` ;

CREATE TABLE IF NOT EXISTS `cooperation` (
  `id_user` INT NOT NULL,
  `id_project` INT NOT NULL,
  `id_role` INT NOT NULL,
  PRIMARY KEY (`id_user`, `id_project`, `id_role`),
  CONSTRAINT `fk_COOPERATION_USERS1`
    FOREIGN KEY (`id_user`)
    REFERENCES `users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_COOPERATION_ROLE1`
    FOREIGN KEY (`id_role`)
    REFERENCES `role` (`id_role`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_COOPERATION_PROJECT1`
    FOREIGN KEY (`id_project`)
    REFERENCES `project` (`id_project`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_COOPERATION_ROLE1_idx` ON `cooperation` (`id_role` ASC) ;

CREATE INDEX `fk_COOPERATION_PROJECT1_idx` ON `cooperation` (`id_project` ASC) ;


-- -----------------------------------------------------
-- Table `FILE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `file` ;

CREATE TABLE IF NOT EXISTS `file` (
  `id_file` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `unique_name` VARCHAR(255) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  `upload_date` DATETIME NOT NULL,
  `id_project` INT NOT NULL,
  PRIMARY KEY (`id_file`),
  CONSTRAINT `fk_FILE_PROJECT1`
    FOREIGN KEY (`id_project`)
    REFERENCES `project` (`id_project`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_FILE_PROJECT1_idx` ON `file` (`id_project` ASC) ;


-- -----------------------------------------------------
-- Table `FIELD`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `field` ;

CREATE TABLE IF NOT EXISTS `field` (
  `id_field` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_field`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `USERS_FIELD`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users_field` ;

CREATE TABLE IF NOT EXISTS `users_field` (
  `id_user` INT NOT NULL,
  `id_field` INT NOT NULL,
  PRIMARY KEY (`id_user`, `id_field`),
  CONSTRAINT `fk_USERS_FIELD_USERS1`
    FOREIGN KEY (`id_user`)
    REFERENCES `users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USERS_FIELD_FIELD1`
    FOREIGN KEY (`id_field`)
    REFERENCES `field` (`id_field`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_USERS_FIELD_FIELD1_idx` ON `users_field` (`id_field` ASC) ;


-- -----------------------------------------------------
-- Table `STATUS_OFFER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `status_offer` ;

CREATE TABLE IF NOT EXISTS `status_offer` (
  `id_status` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_status`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `OFFER_COOPERATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `offer_cooperation` ;

CREATE TABLE IF NOT EXISTS `offer_cooperation` (
  `id_offer` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` MEDIUMTEXT NOT NULL,
  `create_date` DATETIME NOT NULL,
  `id_field` INT NOT NULL,
  `id_project` INT NOT NULL,
  `id_status` INT NOT NULL,
  PRIMARY KEY (`id_offer`),
  CONSTRAINT `fk_OFFER_COOPERATION_FIELD1`
    FOREIGN KEY (`id_field`)
    REFERENCES `field` (`id_field`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OFFER_COOPERATION_STATUS_OFFER1`
    FOREIGN KEY (`id_status`)
    REFERENCES `status_offer` (`id_status`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OFFER_COOPERATION_PROJECT1`
    FOREIGN KEY (`id_project`)
    REFERENCES `project` (`id_project`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_OFFER_COOPERATION_FIELD1_idx` ON `offer_cooperation` (`id_field` ASC) ;

CREATE INDEX `fk_OFFER_COOPERATION_STATUS_OFFER1_idx` ON `offer_cooperation` (`id_status` ASC) ;

CREATE INDEX `fk_OFFER_COOPERATION_PROJECT1_idx` ON `offer_cooperation` (`id_project` ASC) ;


-- -----------------------------------------------------
-- Table `STATUS_REQUEST`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `status_request` ;

CREATE TABLE IF NOT EXISTS `status_request` (
  `id_status` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_status`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `REQUEST_COOPERATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `request_cooperation` ;

CREATE TABLE IF NOT EXISTS `request_cooperation` (
  `id_request` INT NOT NULL AUTO_INCREMENT,
  `message` MEDIUMTEXT NOT NULL,
  `create_date` DATETIME NOT NULL,
  `id_user` INT NOT NULL,
  `id_offer` INT NOT NULL,
  `id_status` INT NOT NULL,
  PRIMARY KEY (`id_request`),
  CONSTRAINT `fk_REQUEST_COOPERATION_USERS1`
    FOREIGN KEY (`id_user`)
    REFERENCES `users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_REQUEST_COOPERATION_OFFER_COOPERATION1`
    FOREIGN KEY (`id_offer`)
    REFERENCES `offer_cooperation` (`id_offer`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_REQUEST_COOPERATION_STATUS_REQUEST1`
    FOREIGN KEY (`id_status`)
    REFERENCES `status_request` (`id_status`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;

CREATE INDEX `fk_REQUEST_COOPERATION_USERS1_idx` ON `request_cooperation` (`id_user` ASC) ;

CREATE INDEX `fk_REQUEST_COOPERATION_OFFER_COOPERATION1_idx` ON `request_cooperation` (`id_offer` ASC) ;

CREATE INDEX `fk_REQUEST_COOPERATION_STATUS_REQUEST1_idx` ON `request_cooperation` (`id_status` ASC) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
