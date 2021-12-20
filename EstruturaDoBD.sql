-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(250) NOT NULL,
  `senha` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`tipo_de_crime`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tipo_de_crime` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`contribuicao_crime`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`contribuicao_crime` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `boletim_ocorrencia` VARCHAR(45) NULL,
  `localizacao` POINT NOT NULL,
  `momento_acontecimento` DATETIME NOT NULL,
  `descricao` VARCHAR(500) NOT NULL,
  `ip` VARCHAR(45) NOT NULL,
  `momento_contribuicao` DATETIME NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_tipo_crime` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ID_Contribuicao_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `Numero_BO_UNIQUE` (`boletim_ocorrencia` ASC) VISIBLE,
  INDEX `fk_contribuicao_crime_usuario1_idx` (`id_usuario` ASC) VISIBLE,
  INDEX `fk_contribuicao_crime_tipo_de_crime1_idx` (`id_tipo_crime` ASC) VISIBLE,
  CONSTRAINT `fk_contribuicao_crime_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `mydb`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contribuicao_crime_tipo_de_crime1`
    FOREIGN KEY (`id_tipo_crime`)
    REFERENCES `mydb`.`tipo_de_crime` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Comentario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comentario` VARCHAR(500) NOT NULL,
  `momento_cometario` DATETIME NOT NULL,
  `ip` VARCHAR(45) NOT NULL,
  `id_contribuicao` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Comentario_contribuicao_crime1_idx` (`id_contribuicao` ASC) VISIBLE,
  CONSTRAINT `fk_Comentario_contribuicao_crime1`
    FOREIGN KEY (`id_contribuicao`)
    REFERENCES `mydb`.`contribuicao_crime` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`usuario_identificado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`usuario_identificado` (
  `id` INT NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `nome` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  UNIQUE INDEX `Email_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `CPF_UNIQUE` (`cpf` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_identificado_usuario1_idx` (`id` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_identificado_usuario1`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Telefone` (
  `id` INT ZEROFILL NOT NULL,
  `numero` VARCHAR(25) NOT NULL,
  `id_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Telefone_usuario_identificado1_idx` (`id_usuario` ASC) VISIBLE,
  UNIQUE INDEX `numero_UNIQUE` (`numero` ASC) VISIBLE,
  CONSTRAINT `fk_Telefone_usuario_identificado1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `mydb`.`usuario_identificado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`r_usuario_comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`r_usuario_comentario` (
  `id_comentario` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  INDEX `fk_R_Usuario_Comentario_usuario1_idx` (`id_usuario` ASC) VISIBLE,
  PRIMARY KEY (`id_comentario`),
  CONSTRAINT `fk_R_Usuario_Comentario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `mydb`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_R_Usuario_Comentario_Comentario1`
    FOREIGN KEY (`id_comentario`)
    REFERENCES `mydb`.`Comentario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`r_usuario_identificado_contribuicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`r_usuario_identificado_contribuicao` (
  `id_usuario` INT NOT NULL,
  `id_contibuicao` INT NOT NULL,
  `nota` INT NOT NULL,
  PRIMARY KEY (`id_usuario`, `id_contibuicao`),
  INDEX `fk_usuario_identificado_has_contribuicao_crime_contribuicao_idx` (`id_contibuicao` ASC) VISIBLE,
  INDEX `fk_usuario_identificado_has_contribuicao_crime_usuario_iden_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_identificado_has_contribuicao_crime_usuario_identi1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `mydb`.`usuario_identificado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_identificado_has_contribuicao_crime_contribuicao_c1`
    FOREIGN KEY (`id_contibuicao`)
    REFERENCES `mydb`.`contribuicao_crime` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`admin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`r_admin_contribuicao_crime`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`r_admin_contribuicao_crime` (
  `id_admin` INT NOT NULL,
  `id_contribuicao_crime` INT NOT NULL,
  PRIMARY KEY (`id_admin`, `id_contribuicao_crime`),
  INDEX `fk_admin_has_contribuicao_crime_contribuicao_crime1_idx` (`id_contribuicao_crime` ASC) VISIBLE,
  INDEX `fk_admin_has_contribuicao_crime_admin1_idx` (`id_admin` ASC) VISIBLE,
  CONSTRAINT `fk_admin_has_contribuicao_crime_admin1`
    FOREIGN KEY (`id_admin`)
    REFERENCES `mydb`.`admin` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_admin_has_contribuicao_crime_contribuicao_crime1`
    FOREIGN KEY (`id_contribuicao_crime`)
    REFERENCES `mydb`.`contribuicao_crime` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'user1';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
