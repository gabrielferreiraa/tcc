<?php
use Migrations\AbstractMigration;

class ChangeAutoIncrementTableMessage extends AbstractMigration
{
    public function up () {
        $sql = "ALTER TABLE messages 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;";
        $this->execute($sql);
    }
}
