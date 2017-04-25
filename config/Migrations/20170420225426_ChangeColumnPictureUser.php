<?php
use Migrations\AbstractMigration;

class ChangeColumnPictureUser extends AbstractMigration
{
    public function up () {
        $sql="ALTER TABLE `users` CHANGE COLUMN `picture` LONGTEXT NULL DEFAULT NULL;";
        $this->execute($sql);
    }

    public function down () {
        $sql="ALTER TABLE `users` CHANGE COLUMN `picture` VARCHAR(255) NULL DEFAULT NULL;";
        $this->execute($sql);
    }
}
