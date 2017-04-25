<?php
use Migrations\AbstractMigration;

class CreateTableProjectSteps extends AbstractMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `project_steps` (
                  `id` INT NOT NULL AUTO_INCREMENT,
                  `project_id` INT NULL,
                  `description` VARCHAR(255) NULL,
                  `created` DATETIME NULL
                  PRIMARY KEY (`id`),
                  INDEX `project_steps_fk_1_idx` (`project_id` ASC),
                  CONSTRAINT `project_steps_fk_1`
                    FOREIGN KEY (`project_id`)
                    REFERENCES `tcc`.`projects` (`id`)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION);";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE project_steps";
        $this->execute($sql);
    }
}
