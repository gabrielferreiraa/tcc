<?php
use Migrations\AbstractMigration;

class ChangeTypeColumnStatusProjects extends AbstractMigration
{
    public function up () {
        $sql = "ALTER TABLE projects CHANGE COLUMN status status CHAR NULL DEFAULT NULL ;";
        $this->execute($sql);
    }
}
