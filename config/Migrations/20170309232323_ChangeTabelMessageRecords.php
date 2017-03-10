<?php
use Migrations\AbstractMigration;

class ChangeTabelMessageRecords extends AbstractMigration
{
    public function up () {
        $sql = "ALTER TABLE message_records
                ADD COLUMN user_id INT NULL AFTER file,
                ADD INDEX message_records_fk2_idx (user_id ASC);
                ALTER TABLE message_records
                ADD CONSTRAINT message_records_fk2
                  FOREIGN KEY (user_id)
                  REFERENCES users (id)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION;";
        $this->execute($sql);
    }

    public function down () {
        $sql = "ALTER TABLE message_records DROP COLUMN user_id;";
        $this->execute($sql);
    }
}
