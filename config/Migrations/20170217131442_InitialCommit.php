<?php
use Migrations\AbstractMigration;

class InitialCommit extends AbstractMigration
{
    public function up () {
        $sql="
-- -----------------------------------------------------
-- Table `states`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `states` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `state_cod` VARCHAR(2) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `state_id` INT(4) NULL,
  INDEX `cities_fk1_idx` (`state_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `cities_fk1`
    FOREIGN KEY (`state_id`)
    REFERENCES `states` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `cep` VARCHAR(8) NULL,
  `city_id` INT(4) NULL,
  `street` VARCHAR(45) NULL,
  `number` INT(10) NULL,
  `neighborhood` VARCHAR(45) NULL,
  `public_address` TINYINT(1) NULL,
  `cel_phone` VARCHAR(45) NULL,
  `facebook` VARCHAR(45) NULL,
  `linkedin` VARCHAR(45) NULL,
  `github` VARCHAR(45) NULL,
  `description` VARCHAR(255) NULL,
  `developer_type` VARCHAR(45) NULL,
  `type` CHAR(1) NULL,
  `created_at` DATE NULL,
  PRIMARY KEY (`id`),
  INDEX `users_fk1_idx` (`city_id` ASC),
  CONSTRAINT `users_fk1`
    FOREIGN KEY (`city_id`)
    REFERENCES `cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `skills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `skills` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_skills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_skills` (
  `id` INT NOT NULL,
  `user_id` INT NULL,
  `skill_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_skills_fk1_idx` (`user_id` ASC),
  INDEX `user_skills_fk2_idx` (`skill_id` ASC),
  CONSTRAINT `user_skills_fk1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_skills_fk2`
    FOREIGN KEY (`skill_id`)
    REFERENCES `skills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT NOT NULL,
  `user_id` INT NULL,
  `title` VARCHAR(45) NULL,
  `description` VARCHAR(255) NULL,
  `date_end` DATE NULL,
  `budget` FLOAT NULL,
  `type_area` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `project_skills`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_skills` (
  `id` INT NOT NULL,
  `project_id` INT NULL,
  `skill_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `project_skills_fk1_idx` (`project_id` ASC),
  INDEX `project_skills_fk2_idx` (`skill_id` ASC),
  CONSTRAINT `project_skills_fk1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `project_skills_fk2`
    FOREIGN KEY (`skill_id`)
    REFERENCES `skills` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `project_files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_files` (
  `id` INT NOT NULL,
  `project_id` INT NULL,
  `file` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `project_files_fk1_idx` (`project_id` ASC),
  CONSTRAINT `project_files_fk1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `project_users_intersted`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_users_intersted` (
  `id` INT NOT NULL,
  `project_id` INT NULL,
  `user_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `project_users_fk1_idx` (`project_id` ASC),
  INDEX `project_users_intersted_idx` (`user_id` ASC),
  CONSTRAINT `project_users_fk1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `project_users_intersted`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `project_users_fixed`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_users_fixed` (
  `id` INT NOT NULL,
  `project_id` INT NULL,
  `user_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `project_users_fixed_fk1_idx` (`project_id` ASC),
  INDEX `project_users_fixed_fk2_idx` (`user_id` ASC),
  CONSTRAINT `project_users_fixed_fk1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `project_users_fixed_fk2`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_reputations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_reputations` (
  `id` INT NOT NULL,
  `project_id` INT NULL,
  `user_id` INT NULL,
  `grade` FLOAT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_reputations_fk1_idx` (`project_id` ASC),
  INDEX `user_reputations_fk2_idx` (`user_id` ASC),
  CONSTRAINT `user_reputations_fk1`
    FOREIGN KEY (`project_id`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_reputations_fk2`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `messages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT NOT NULL,
  `to` INT NULL,
  `from` INT NULL,
  `message` TEXT NULL,
  `date` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `messages_fk1_idx` (`to` ASC),
  INDEX `messages_fk2_idx` (`from` ASC),
  CONSTRAINT `messages_fk1`
    FOREIGN KEY (`to`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `messages_fk2`
    FOREIGN KEY (`from`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
";
        $this->execute($sql);
    }
    public function down () {}
}
