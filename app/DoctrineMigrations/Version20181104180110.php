<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * create table wiki
 */
class Version20181104180110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
        CREATE TABLE IF NOT EXISTS wiki(
          id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
          title VARCHAR(255) NOT NULL,
          text VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL
        ) engine = InnoDB charset = utf8;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE IF EXISTS wiki;");
    }
}
