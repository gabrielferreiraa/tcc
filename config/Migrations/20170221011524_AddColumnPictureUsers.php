<?php
use Migrations\AbstractMigration;

class AddColumnPictureUsers extends AbstractMigration
{
    public function up ()
    {
        $sql = "ALTER TABLE users ADD COLUMN picture VARCHAR(255);";
        $this->execute($sql);
    }

    public function down () {
        $sql = "ALTER TABLE users DROP COLUMN picture;";
        $this->execute($sql);
    }
}
