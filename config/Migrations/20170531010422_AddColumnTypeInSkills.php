<?php
use Migrations\AbstractMigration;

class AddColumnTypeInSkills extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE `skills` ADD COLUMN type VARCHAR(45)";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE `skills` DROP COLUMN type";
        $this->execute($sql);
    }
}
