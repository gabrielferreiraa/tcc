<?php
use Migrations\AbstractMigration;

class AddColumnAvaliationOnReputation extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE `user_reputations` ADD COLUMN avaliation TEXT";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "ALTER TABLE `user_reputations` DROP COLUMN avaliation";
        $this->execute($sql);
    }
}
