<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add column category_id with table wiki
 */
class Version20181105103313 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("set @@foreign_key_checks=0;");
        $this->addSql("ALTER TABLE wiki ADD COLUMN category_id INT NOT NULL, ADD CONSTRAINT fk_wiki_category FOREIGN KEY (category_id) REFERENCES category(id);");
        $this->addSql("set @@foreign_key_checks=1;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE wiki DROP FOREIGN KEY fk_wiki_category, DROP COLUMN category_id;2");
    }
}
