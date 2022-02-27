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