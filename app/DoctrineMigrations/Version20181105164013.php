<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Create table comments
 */
class Version20181105164013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
        CREATE TABLE IF NOT EXISTS comments(
          id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
          user_id INT UNSIGNED NOT NULL,
          wiki_id INT UNSIGNED NOT NULL,
          text LONGTEXT NOT NULL,
          created_at DATETIME NOT NULL,
          CONSTRAINT FK_comments_user FOREIGN KEY (user_id) REFERENCES users(id),
          CONSTRAINT FK_comments_wiki FOREIGN KEY (wiki_id) REFERENCES wiki(id)
        ) engine = InnoDB charset = utf8;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE IF EXISTS comments;");
    }
}
