<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add column parent_id to table wiki
 */
class Version20181113074212 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE wiki ADD COLUMN parent_id INT UNSIGNED NOT NULL DEFAULT 0;");
        $this->addSql("CREATE INDEX IDX_wiki_parent ON wiki(parent_id);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX IDX_wiki_parent ON wiki;");
        $this->addSql("ALTER TABLE wiki DROP COLUMN parent_id;");
    }
}
