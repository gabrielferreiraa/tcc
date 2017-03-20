<?php
use Migrations\AbstractMigration;

class ChangeAutoIncrement extends AbstractMigration
{
    public function up () {
        $sql = "ALTER TABLE project_skills CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT;";
        $this->execute($sql);
    }

    public function down () {
        $sql = "ALTER TABLE project_skills CHANGE COLUMN `id` `id` INT(11) NOT NULL ;";
        $this->execute($sql);
    }
}
