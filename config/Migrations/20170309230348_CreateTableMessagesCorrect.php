<?php
use Migrations\AbstractMigration;

class CreateTableMessagesCorrect extends AbstractMigration
{
    public function up () {
        $sql = "CREATE TABLE message_records (
              id INT NOT NULL AUTO_INCREMENT,
              message_id INT NULL,
              text TEXT NULL,
              created DATETIME NULL,
              file VARCHAR(255) NULL,
              PRIMARY KEY (id),
              INDEX message_records_fk1_idx (message_id ASC),
              CONSTRAINT message_records_fk1
                FOREIGN KEY (message_id)
                REFERENCES messages (id)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);";
        $this->execute($sql);
    }

    public function down () {
        $sql = "DROP TABLE message_records;";
        $this->execute($sql);
    }
}
