<?php
use Migrations\AbstractMigration;

class ChangeColumnBudgetType extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE `projects` CHANGE COLUMN `budget` `budget` VARCHAR(45) NULL DEFAULT NULL;";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE `projects` CHANGE COLUMN `budget` `budget` FLOAT NULL DEFAULT NULL;";
        $this->execute($sql);
    }
}
