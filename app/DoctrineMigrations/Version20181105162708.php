<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Change type column text with table wiki
 */
class Version20181105162708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE wiki MODIFY text LONGTEXT;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {}
}
