SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `projektwh3` ;
CREATE SCHEMA IF NOT EXISTS `projektwh3` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `projektwh3` ;

-- -----------------------------------------------------
-- Table `projektwh3`.`korisnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`korisnik` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`korisnik` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lozinka` VARCHAR(20) NOT NULL ,
  `mail` VARCHAR(45) NOT NULL ,
  `nadimak` VARCHAR(20) NOT NULL ,
  `opis` TEXT NULL ,
  `lat` FLOAT NOT NULL ,
  `lon` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_korisnik_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `mail_UNIQUE` (`mail` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`kategorija`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`kategorija` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`kategorija` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ime` VARCHAR(20) NOT NULL ,
  `opis` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `ime_UNIQUE` (`ime` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`tip`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`tip` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`tip` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ime` VARCHAR(20) NOT NULL ,
  `opis` VARCHAR(100) NULL ,
  `id_kategorija` INT NOT NULL ,
  PRIMARY KEY (`id`, `id_kategorija`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_tip_kategorija1` (`id_kategorija` ASC) ,
  CONSTRAINT `fk_tip_kategorija1`
    FOREIGN KEY (`id_kategorija` )
    REFERENCES `projektwh3`.`kategorija` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`event` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`event` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `opis` TEXT NULL ,
  `vrijeme` TIMESTAMP NOT NULL ,
  `broj_dana` INT NOT NULL ,
  `lat` FLOAT NOT NULL ,
  `lon` FLOAT NOT NULL ,
  `id_kategorija` INT NOT NULL ,
  `id_tip` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_event_kategorija` (`id_kategorija` ASC) ,
  INDEX `fk_event_tip` (`id_tip` ASC) ,
  CONSTRAINT `fk_event_kategorija`
    FOREIGN KEY (`id_kategorija` )
    REFERENCES `projektwh3`.`kategorija` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_tip`
    FOREIGN KEY (`id_tip` )
    REFERENCES `projektwh3`.`tip` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`dolazak`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`dolazak` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`dolazak` (
  `id_korisnik` INT NOT NULL ,
  `id_event` INT NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_event`) ,
  INDEX `fk_korisnik_event` (`id_event` ASC) ,
  INDEX `fk_event_korisnik` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_event_korisnik`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_korisnik_event`
    FOREIGN KEY (`id_event` )
    REFERENCES `projektwh3`.`event` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`prisutnost`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`prisutnost` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`prisutnost` (
  `id_korisnik` INT NOT NULL ,
  `id_event` INT NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_event`) ,
  INDEX `fk_event_korisnikpris` (`id_event` ASC) ,
  INDEX `fk_korisnikpris_event` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_korisnikpris_event`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_korisnikpris`
    FOREIGN KEY (`id_event` )
    REFERENCES `projektwh3`.`event` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`autor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`autor` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`autor` (
  `id_korisnik` INT NOT NULL ,
  `id_event` INT NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_event`) ,
  INDEX `fk_event_autor` (`id_event` ASC) ,
  INDEX `fk_autor_event` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_autor_event`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_autor`
    FOREIGN KEY (`id_event` )
    REFERENCES `projektwh3`.`event` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`lista_prijatelja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`lista_prijatelja` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`lista_prijatelja` (
  `id_korisnik` INT NOT NULL ,
  `id_prijatelj` INT NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_prijatelj`) ,
  INDEX `fk_prijatelj_korisnik,` (`id_prijatelj` ASC) ,
  INDEX `fk_korisnik_prijatelj` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_korisnik_prijatelj`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_prijatelj_korisnik,`
    FOREIGN KEY (`id_prijatelj` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`komentar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`komentar` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`komentar` (
  `id_korisnik` INT NOT NULL ,
  `id_event` INT NOT NULL ,
  `text` TEXT NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_event`) ,
  INDEX `fk_event_korisnikkom` (`id_event` ASC) ,
  INDEX `fk_korisnikkom_event` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_korisnikkom_event`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_korisnikkom`
    FOREIGN KEY (`id_event` )
    REFERENCES `projektwh3`.`event` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`dostignuce`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`dostignuce` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`dostignuce` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `naziv` VARCHAR(45) NOT NULL ,
  `opis` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `naziv_UNIQUE` (`naziv` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projektwh3`.`korisnik_dostignuce`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projektwh3`.`korisnik_dostignuce` ;

CREATE  TABLE IF NOT EXISTS `projektwh3`.`korisnik_dostignuce` (
  `id_korisnik` INT NOT NULL ,
  `id_dostignuce` INT NOT NULL ,
  `korisnik_dostignucecol` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id_korisnik`, `id_dostignuce`) ,
  INDEX `fk_dostignuce_korisnik` (`id_dostignuce` ASC) ,
  INDEX `fk_korisnik_dostgnuce` (`id_korisnik` ASC) ,
  CONSTRAINT `fk_korisnik_dostgnuce`
    FOREIGN KEY (`id_korisnik` )
    REFERENCES `projektwh3`.`korisnik` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dostignuce_korisnik`
    FOREIGN KEY (`id_dostignuce` )
    REFERENCES `projektwh3`.`dostignuce` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
