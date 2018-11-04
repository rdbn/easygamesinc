<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * create table users
 */
class Version20181104175435 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
        CREATE TABLE IF NOT EXISTS users(
          id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
          username VARCHAR(255) NOT NULL,
          salt VARCHAR(255) NOT NULL,
          password VARCHAR(255) NOT NULL,
          role VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL,
          CONSTRAINT UNIQ_users_username UNIQUE (username)
        ) engine = InnoDB charset = utf8;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE IF EXISTS users;");
    }
}
