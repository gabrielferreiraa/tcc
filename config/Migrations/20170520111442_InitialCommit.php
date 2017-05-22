<?php
use Migrations\AbstractMigration;

class InitialCommit extends AbstractMigration
{
    public function up()
    {

        $sql = "
                CREATE TABLE `states` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `state_cod` int(11) NOT NULL,
                  PRIMARY KEY (`id`)
                );

                CREATE TABLE `cities` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `state_id` int(11) NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `state_id_cities` (`state_id`),
                  CONSTRAINT `state_id_cities` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );
                
                CREATE TABLE `skills` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(45) DEFAULT NULL,
                  PRIMARY KEY (`id`)
                );

                CREATE TABLE `users` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(45) DEFAULT NULL,
                  `email` varchar(45) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `cep` varchar(8) DEFAULT NULL,
                  `city_id` int(4) DEFAULT NULL,
                  `street` varchar(45) DEFAULT NULL,
                  `number` int(10) DEFAULT NULL,
                  `neighborhood` varchar(45) DEFAULT NULL,
                  `public_address` tinyint(1) DEFAULT NULL,
                  `cel_phone` varchar(45) DEFAULT NULL,
                  `facebook` varchar(45) DEFAULT NULL,
                  `linkedin` varchar(45) DEFAULT NULL,
                  `github` varchar(45) DEFAULT NULL,
                  `description` varchar(255) DEFAULT NULL,
                  `developer_type` varchar(45) DEFAULT NULL,
                  `type` char(1) DEFAULT NULL,
                  `created_at` date DEFAULT NULL,
                  `picture` longtext,
                  `is_online` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `users_fk1_idx` (`city_id`),
                  CONSTRAINT `users_fk1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION);

                CREATE TABLE `messages` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `to_user` int(11) DEFAULT NULL,
                  `from_user` int(11) DEFAULT NULL,
                  `message` text,
                  `date` datetime DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `messages_fk1_idx` (`to_user`),
                  KEY `messages_fk2_idx` (`from_user`)
                );
                
                CREATE TABLE `message_records` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `message_id` int(11) DEFAULT NULL,
                  `text` text,
                  `created` datetime DEFAULT NULL,
                  `file` varchar(255) DEFAULT NULL,
                  `user_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `message_records_fk1_idx` (`message_id`),
                  KEY `message_records_fk2_idx` (`user_id`),
                  CONSTRAINT `message_records_fk1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `message_records_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `projects` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `user_id` int(11) DEFAULT NULL,
                  `title` varchar(45) DEFAULT NULL,
                  `description` text,
                  `date_end` date DEFAULT NULL,
                  `budget` float DEFAULT NULL,
                  `type_area` int(11) DEFAULT NULL,
                  `status` char(1) DEFAULT NULL,
                  `already_fixed` char(1) DEFAULT NULL,
                  PRIMARY KEY (`id`)
                );
                
                CREATE TABLE `project_files` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `file` varchar(255) DEFAULT NULL,
                  `ext` varchar(45) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `project_files_fk1_idx` (`project_id`),
                  CONSTRAINT `project_files_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `project_skills` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `skill_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `project_skills_fk1_idx` (`project_id`),
                  KEY `project_skills_fk2_idx` (`skill_id`),
                  CONSTRAINT `project_skills_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `project_skills_fk2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `project_steps` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `description` varchar(255) DEFAULT NULL,
                  `created` datetime DEFAULT NULL,
                  `icon` varchar(45) DEFAULT NULL,
                  `title` varchar(45) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `project_steps_fk_1_idx` (`project_id`),
                  CONSTRAINT `project_steps_fk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `project_users_fixed` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `user_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `project_users_fixed_fk1_idx` (`project_id`),
                  KEY `project_users_fixed_fk2_idx` (`user_id`),
                  CONSTRAINT `project_users_fixed_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `project_users_fixed_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `project_users_intersted` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `user_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `project_users_fk1_idx` (`project_id`),
                  KEY `project_users_intersted_idx` (`user_id`),
                  CONSTRAINT `project_users_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `project_users_intersted` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `user_reputations` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `project_id` int(11) DEFAULT NULL,
                  `user_id` int(11) DEFAULT NULL,
                  `grade` float DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `user_reputations_fk1_idx` (`project_id`),
                  KEY `user_reputations_fk2_idx` (`user_id`),
                  CONSTRAINT `user_reputations_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `user_reputations_fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );

                CREATE TABLE `user_skills` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `user_id` int(11) DEFAULT NULL,
                  `skill_id` int(11) DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `user_skills_fk1_idx` (`user_id`),
                  KEY `user_skills_fk2_idx` (`skill_id`),
                  CONSTRAINT `user_skills_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                  CONSTRAINT `user_skills_fk2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                );";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
