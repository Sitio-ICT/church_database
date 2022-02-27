-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema church_database
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `church_database` ;

-- -----------------------------------------------------
-- Schema church_database
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `church_database` DEFAULT CHARACTER SET utf8 ;
USE `church_database` ;

-- -----------------------------------------------------
-- Table `church_database`.`profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`profile` ;

CREATE TABLE IF NOT EXISTS `church_database`.`profile` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `middle_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `maiden_name` VARCHAR(45) NULL,
  `sex` VARCHAR(10) NULL,
  `marital_status` VARCHAR(45) NULL,
  `d_o_wedding` DATE NULL,
  `d_o_b` DATE NULL,
  `state_of_origin` VARCHAR(45) NULL,
  `phone_no` VARCHAR(15) NULL,
  `email` VARCHAR(45) NULL,
  `residentail_address` TEXT NULL,
  `religion` VARCHAR(20) NULL,
  `registration_no` VARCHAR(16) NULL,
  `registration_date` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`users` ;

CREATE TABLE IF NOT EXISTS `church_database`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `passkey` TEXT NULL,
  `profile_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_profile_idx` (`profile_id` ASC),
  CONSTRAINT `fk_users_profile`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`relationships`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`relationships` ;

CREATE TABLE IF NOT EXISTS `church_database`.`relationships` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `relationship_type` VARCHAR(20) NULL,
  `related_to` INT NULL,
  `profile_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_relationships_profile1_idx` (`profile_id` ASC),
  CONSTRAINT `fk_relationships_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`permissions` ;

CREATE TABLE IF NOT EXISTS `church_database`.`permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `feeds` INT NULL,
  `user_management` INT NULL,
  `mass_booking` INT NULL,
  `configurations` INT NULL,
  `subscriptions` INT NULL,
  `others` INT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_permissions_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_permissions_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `church_database`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`images` ;

CREATE TABLE IF NOT EXISTS `church_database`.`images` (
  `id` INT NOT NULL,
  `image` TEXT NULL,
  `image_type` VARCHAR(45) NULL,
  `profile_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_images_profile1_idx` (`profile_id` ASC),
  CONSTRAINT `fk_images_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`organization`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`organization` ;

CREATE TABLE IF NOT EXISTS `church_database`.`organization` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `org_name` VARCHAR(70) NULL,
  `description` LONGTEXT NULL,
  `type` VARCHAR(45) NULL,
  `meeting_days` VARCHAR(10) NULL,
  `re_occurance` VARCHAR(10) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`organization_has_profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`organization_has_profile` ;

CREATE TABLE IF NOT EXISTS `church_database`.`organization_has_profile` (
  `organization_id` INT NOT NULL,
  `profile_id` INT NOT NULL,
  `position` VARCHAR(45) NULL,
  PRIMARY KEY (`organization_id`, `profile_id`),
  INDEX `fk_organization_has_profile_profile1_idx` (`profile_id` ASC),
  INDEX `fk_organization_has_profile_organization1_idx` (`organization_id` ASC),
  CONSTRAINT `fk_organization_has_profile_organization1`
    FOREIGN KEY (`organization_id`)
    REFERENCES `church_database`.`organization` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_organization_has_profile_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`calendar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`calendar` ;

CREATE TABLE IF NOT EXISTS `church_database`.`calendar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `activity_name` VARCHAR(45) NULL,
  `activity_color` VARCHAR(8) NULL,
  `description` LONGTEXT NULL,
  `start_date` DATETIME NULL,
  `end_date` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`feeds`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`feeds` ;

CREATE TABLE IF NOT EXISTS `church_database`.`feeds` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` TEXT NULL,
  `message` LONGTEXT NULL,
  `feed_type` VARCHAR(10) NULL,
  `date_posted` DATETIME NULL,
  `posted_by` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`mass_booking`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`mass_booking` ;

CREATE TABLE IF NOT EXISTS `church_database`.`mass_booking` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mass_intention` TEXT NULL,
  `person` TEXT NULL,
  `status` INT NULL,
  `profile_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mass_booking_profile1_idx` (`profile_id` ASC),
  CONSTRAINT `fk_mass_booking_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`news_letter`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`news_letter` ;

CREATE TABLE IF NOT EXISTS `church_database`.`news_letter` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `from` VARCHAR(45) NULL,
  `subject` VARCHAR(100) NULL,
  `message` LONGTEXT NULL,
  `to` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`subscription_model`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`subscription_model` ;

CREATE TABLE IF NOT EXISTS `church_database`.`subscription_model` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `type` VARCHAR(45) NULL,
  `reoccurence` VARCHAR(45) NULL,
  `amount` DECIMAL(19,2) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`sub_permission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`sub_permission` ;

CREATE TABLE IF NOT EXISTS `church_database`.`sub_permission` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` INT NULL,
  `access_data` INT NULL,
  `edit_data` INT NULL,
  `committee` INT NULL,
  `subscription_model_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sub_permission_subscription_model1_idx` (`subscription_model_id` ASC),
  CONSTRAINT `fk_sub_permission_subscription_model1`
    FOREIGN KEY (`subscription_model_id`)
    REFERENCES `church_database`.`subscription_model` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`subscribe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`subscribe` ;

CREATE TABLE IF NOT EXISTS `church_database`.`subscribe` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(19,2) NULL,
  `payment_date` DATE NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  `subscription_model_id` INT NOT NULL,
  `profile_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_subscribe_subscription_model1_idx` (`subscription_model_id` ASC),
  INDEX `fk_subscribe_profile1_idx` (`profile_id` ASC),
  CONSTRAINT `fk_subscribe_subscription_model1`
    FOREIGN KEY (`subscription_model_id`)
    REFERENCES `church_database`.`subscription_model` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subscribe_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `church_database`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`donation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`donation` ;

CREATE TABLE IF NOT EXISTS `church_database`.`donation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(19,2) NULL,
  `type` VARCHAR(45) NULL,
  `transaction_date` DATE NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `church_database`.`payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `church_database`.`payment` ;

CREATE TABLE IF NOT EXISTS `church_database`.`payment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `payment_type` VARCHAR(45) NULL,
  `amount` DECIMAL(19,2) NULL,
  `transaction_id` VARCHAR(100) NULL,
  `transaction_date` DATE NULL,
  `description` TEXT NULL,
  `donation_id` INT NOT NULL,
  `subscribe_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_payment_donation1_idx` (`donation_id` ASC),
  INDEX `fk_payment_subscribe1_idx` (`subscribe_id` ASC),
  CONSTRAINT `fk_payment_donation1`
    FOREIGN KEY (`donation_id`)
    REFERENCES `church_database`.`donation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_subscribe1`
    FOREIGN KEY (`subscribe_id`)
    REFERENCES `church_database`.`subscribe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
