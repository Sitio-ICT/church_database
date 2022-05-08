
ALTER TABLE `mass_booking` ADD `day` VARCHAR(10) NOT NULL AFTER `person`, ADD `mass_time` VARCHAR(5) NOT NULL AFTER `day`;
ALTER TABLE `organization` ADD `meeting_time` VARCHAR(10) NOT NULL AFTER `re_occurance`;
ALTER TABLE `organization` CHANGE `meeting_time` `meeting_time` TIME NOT NULL;

--- 8th May^

ALTER TABLE `profile` ADD `phone_no2` VARCHAR(15) NOT NULL AFTER `phone_no`;
-- 

CREATE TABLE `church_database`.`fixed_price` ( `id` INT NOT NULL AUTO_INCREMENT , 
`price_type` VARCHAR(15) NOT NULL , `price` DECIMAL(19,2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

INSERT INTO `fixed_price` (`id`, `price_type`, `price`) VALUES (NULL, 'mass', '1000');

-- 18th April ^

CREATE TABLE `password_resets` ( `id` INT NOT NULL AUTO_INCREMENT , 
`email` VARCHAR(60) NOT NULL , `token` VARCHAR(600) NOT NULL , 
`date_requsted` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `donation` ADD `profile_id` INT NOT NULL AFTER `description`;
ALTER TABLE `payment` ADD `profile_id` INT NOT NULL AFTER `subscribe_id`;
ALTER TABLE `users` ADD `user_type` VARCHAR(6) NOT NULL DEFAULT 'user' AFTER `passkey`;
CREATE TRIGGER `format_profile_name` BEFORE INSERT ON `profile` FOR EACH ROW BEGIN
  IF (NEW.fullname IS NULL) THEN
    SET NEW.fullname = CONCAT_WS(" ", NEW.first_name, NEW.middle_name, NEW.last_name);
  END IF;
END
-- 3rd March ^

CREATE TABLE `church_database`.`sacraments` ( `id` INT NOT NULL AUTO_INCREMENT , 
`tittle` VARCHAR(60) NOT NULL , `description` TEXT NOT NULL , `minimum_age` INT NOT NULL , 
`max_receivable` INT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB; 

CREATE TABLE `church_database`.`sacraments_recieved` ( `id` INT NOT NULL AUTO_INCREMENT , 
`profile_id` INT NOT NULL , `date_received` DATE NOT NULL , `ministered_by` VARCHAR(80) NOT NULL , 
`sacrament_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `church_database`.`notifications` ( `id` INT NOT NULL , `message` TEXT NOT NULL , 
`status` INT NOT NULL , `person_id` INT NOT NULL , `posted_by` INT NOT NULL , 
`directed_to` VARCHAR(20) NOT NULL ) ENGINE = InnoDB;

ALTER TABLE `users` ADD `status` VARCHAR(7) NOT NULL DEFAULT 'ACTIVE' AFTER `passkey`;
ALTER TABLE `organization_has_profile` ADD `date_joined` DATE NOT NULL AFTER `position`; 