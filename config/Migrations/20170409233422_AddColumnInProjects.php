<?php
use Migrations\AbstractMigration;

class AddColumnInProjects extends AbstractMigration
{
    public function up () {
        $sql= "ALTER TABLE projects ADD COLUMN already_fixed CHAR(1);";
        $this->execute($sql);
    }

    public function down () {
        $sql = "ALTER TABLE projects DROP COLUMN already_fixed;";
        $this->execute($sql);
    }
}
