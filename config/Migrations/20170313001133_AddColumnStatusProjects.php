<?php
use Migrations\AbstractMigration;

class AddColumnStatusProjects extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE projects ADD COLUMN status INTEGER";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE projects DROP COLUMN status";
        $this->execute($sql);
    }
}
