<?php
use Migrations\AbstractMigration;

class ChangeColumnName extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE messages 
                DROP FOREIGN KEY messages_fk1,
                DROP FOREIGN KEY messages_fk2;
                ALTER TABLE messages 
                CHANGE COLUMN to to_user INT(11) NULL DEFAULT NULL ,
                CHANGE COLUMN from from_user INT(11) NULL DEFAULT NULL ;
                ALTER TABLE messages 
                ADD CONSTRAINT messages_fk1
                  FOREIGN KEY (to_user)
                  REFERENCES users (id)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION,
                ADD CONSTRAINT messages_fk2
                  FOREIGN KEY (from_user)
                  REFERENCES users (id)
                  ON DELETE NO ACTION
                  ON UPDATE NO ACTION;";
        $this->execute($sql);
    }
}
