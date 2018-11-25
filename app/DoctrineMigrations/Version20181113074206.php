<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Drop table category
 */
class Version20181113074206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE wiki DROP FOREIGN KEY fk_wiki_category;");
        $this->addSql("ALTER TABLE wiki DROP COLUMN category_id;");
        $this->addSql("DROP TABLE IF EXISTS category;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {}
}
